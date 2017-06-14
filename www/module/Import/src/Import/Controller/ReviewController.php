<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Import for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Import\Controller;

use PHPExcel_IOFactory;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

use Application\Entity\Cfr;
use Application\Entity\MunicipalCode;
use Application\Entity\Review;
use Application\Entity\StateCode;
use Application\Entity\Statute;
use Application\Utilility\Replace;
use Application\Entity\ReviewComment;
use Application\Utilility\Logger;
use Application\Entity\ImportHistoryItem;
use Application\Entity\Feedback;
use Application\Entity\Action;
use Application\Entity\ImpactTag;
use Application\Entity\ImportHistory;
use Zend\View\Model\ViewModel;

class ReviewController extends AbstractActionController
{
    protected $config;
    protected $em;
    protected $logger;
    
    public function __construct($config, $em)
    {
        date_default_timezone_set('America/Los_Angeles');
        
        $this->config = $config;
        $this->em = $em;
        $this->logger = new Logger($em);
    }
    
    public function indexAction()
    {
        return array();
    }
    
    public function uploadAction()
    {
        $request = $this->getRequest();
        
        $config = $this->config;
        
        // Settings
        $uploadDir = $config['argive']['reviews']['upload_dir'];
        $cleanupTargetDir = $config['argive']['reviews']['cleanup_dir']; // Remove old files
        $maxFileAge = 365 * 31 * 24 * 60 * 60;   // Temp file age in seconds
        
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
	       $fileName = $_FILES["file"]["name"];
        } else {
	       $fileName = uniqid("file_");
        }
        
        $filePath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
        
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        
        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($uploadDir) || !$dir = opendir($uploadDir)) {
                $json = '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
                $this->response->setContent($json);
                $this->response->setStatusCode(Response::STATUS_CODE_500);
                
                return $this->response;
            }
            
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $uploadDir . DIRECTORY_SEPARATOR . $file;
                
                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                
                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        
        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            $json = '{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
            $this->response->setContent($json);
            $this->response->setStatusCode(Response::STATUS_CODE_500);
            
            return $this->response;
        }
        
        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $json = '{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                $this->response->setContent($json);
                $this->response->setStatusCode(Response::STATUS_CODE_500);
                
                return $this->response;
            }
            
            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                $json = '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                $this->response->setContent($json);
                $this->response->setStatusCode(Response::STATUS_CODE_500);
                
                return $this->response;
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                $json = '{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                $this->response->setContent($json);
                $this->response->setStatusCode(Response::STATUS_CODE_500);
                
                return $this->response;
            }
        }
        
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        
        @fclose($out);
        @fclose($in);
        
        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
        
        // Return Success JSON-RPC response
        $json = '{"jsonrpc" : "2.0", "result" : null, "id" : "id"}';
        $this->response->setContent($json);
        $this->response->setStatusCode(Response::STATUS_CODE_200);
        
        return $this->response;
    }
    
    public function importAction()
    {
        $config = $this->config;
        
        // Settings
        $uploadDir = $config['argive']['reviews']['upload_dir'];
        $completedDir = $config['argive']['reviews']['completed_dir'];
        $sheetIndex = 0;
        
        $files = glob($uploadDir . DIRECTORY_SEPARATOR . '*.[cC][sS][vV]', GLOB_BRACE);
        
        foreach ($files as $inputFileName) {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            
            try {
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (\Exception $e) {
                // [TODO: Need to add error message to page]
                return array();
            }
            
            $sheet = $objPHPExcel->getSheet($sheetIndex);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $rowHeader = $sheet->rangeToArray('A2:' . $highestColumn . 2);
            
            $importHistory = $this->logger->logImportHistory(ImportHistory::TYPE_REVIEW, basename($inputFileName), $highestRow - 2, 0, 0, 0);
            
            for ($row = 3; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row);
                $data = array_combine($rowHeader[0], $rowData[0]);
                
                $cfrs = $this->importCfrs($data, $this->em, $row, $importHistory);
                $statute = $this->importStatute($data, $this->em, $row, $importHistory);
                $stateCode = $this->importStateCode($data, $this->em, $row, $importHistory);
                $municipalCode = $this->importMunicipalCode($data, $this->em, $row, $importHistory);
                $feedbacks = $this->importFeedbacks($data, $this->em, $row, $importHistory);
                $actions = $this->importActions($data, $this->em, $row, $importHistory);
                $impactTags = $this->importImpactTags($data, $this->em, $row, $importHistory);
                $review = $this->importReview($data, $cfrs, $statute, $stateCode, $municipalCode, $feedbacks, $actions, $impactTags, $this->em, $row, $importHistory);
            }
            
            $this->em->persist($importHistory);
            $this->em->flush();
            
            rename($inputFileName, $completedDir . '/' . basename($inputFileName));
        }
        
        return array();
    }
    
    private function getColumnsByTableName($tableName, $indata)
    {
        $data = array();
        
        foreach (array_keys($indata) as $key) {
            $arr = explode('.', $key);
            if (sizeof($arr) == 2 && $arr[0] == $tableName) {
                $data[$arr[1]] = $indata[$key];
            }
        }
        
        return $data;
    }
    
    private function importCfrs($indata, $entityManager, $row, $importHistory)
    {
        $data = $this->getColumnsByTableName('T_CFR', $indata);
        
        $cfrs = new \Doctrine\Common\Collections\ArrayCollection();
        
        if ($indata['T_REVIEW_has_T_CFR.cfr_id'] != null) {
            $ids = explode(',', $indata['T_REVIEW_has_T_CFR.cfr_id']);
            
            for ($i=0; $i<sizeof($ids); $i++) {
                if (!empty($ids[$i])) {
                    $cfr = $entityManager->find('Application\Entity\Cfr', trim($ids[$i]));
                    
                    if (is_null($cfr)) {
                        $this->logger->logImportHistoryItem(
                            $importHistory, 'T_REVIEW_has_T_CFR.cfr_id: ' . trim($ids[$i]), Cfr::class, $row, ImportHistoryItem::E_INVALID_ID
                        );
                    } else {
                        $cfrs->add($cfr);
                    }
                }
            }
        } else if ($data['cfr_title'] != null && $data['cfr_part'] != null) {
            $parts = explode(',', $data['cfr_part']);
            
            for ($i=0; $i<sizeof($parts); $i++) {
                if (!empty($parts[$i])) {
                    $data['cfr_part'] = trim($parts[$i]);
                    $query = $entityManager->createQuery('SELECT c FROM Application\Entity\Cfr c WHERE c.cfrTitle = :title AND c.cfrPart = :part');
                    $query->setParameters(array(
                        'title'   => Replace::replaceNullWithAlt($data['cfr_title'], ''),
                        'part'    => Replace::replaceNullWithAlt($data['cfr_part'], '')
                    ));
                    $results = $query->getResult();
                    
                    // Take first CFR.  There should be only one.
                    if (sizeof($results) > 0) {
                        $cfr = $results[0];
                    } else {
                        $cfr = new Cfr();
                    }
                    
                    $cfr->exchangeData($data, $entityManager);
                    $entityManager->persist($cfr);
                    $entityManager->flush();
                    
                    $cfrs->add($cfr);
                }
            }
        }
        
        return $cfrs;
    }
    
    private function importStatute($indata, $entityManager, $row, $importHistory)
    {
        $data = $this->getColumnsByTableName('T_STATUTE', $indata);
        
        $statute = null;
        
        if ($indata['T_REVIEW.statute_id'] != null) {
            $statute= $entityManager->find('Application\Entity\Statute', $indata['T_REVIEW.statute_id']);
            
            if (is_null($statute)) {
                $this->logger->logImportHistoryItem(
                    $importHistory, 'Invalid T_REVIEW.statute_id: ' . $indata['T_REVIEW.statute_id'], Statute::class, $row, ImportHistoryItem::E_INVALID_ID
                );
            }
        } else if ($data['statute'] != null || $data['statute_description'] != null || $data['statute_jurisdiction'] != null || $data['state'] != null) {
            $query = $entityManager->createQuery('SELECT s FROM Application\Entity\Statute s WHERE s.statute = :statute AND s.statuteDescription = :description AND s.statuteJurisdiction = :jurisdiction AND s.state = :state');
            $query->setParameters(array(
                'statute'      => Replace::replaceNullWithAlt($data['statute'], ''),
                'description'  => Replace::replaceNullWithAlt($data['statute_description'], ''),
                'jurisdiction' => Replace::replaceNullWithAlt($data['statute_jurisdiction'], ''),
                'state'        => Replace::replaceNullWithAlt($data['state'], '')
            ));
            $statutes= $query->getResult();
            
            // Take first statute
            if (sizeof($statutes) > 0) {
                $statute = $statutes[0];
            } else {
                $statute = new Statute();
            }
            
            $statute->exchangeData($data, $entityManager);
            $entityManager->persist($statute);
            $entityManager->flush();
        }
        
        return $statute;
    }
    
    private function importStateCode($indata, $entityManager, $row, $importHistory)
    {
        $data = $this->getColumnsByTableName('T_STATE_CODE', $indata);
        
        $stateCode = null;
        
        if ($indata['T_REVIEW.state_code_id'] != null) {
            $stateCode = $entityManager->find('Application\Entity\StateCode', $indata['T_REVIEW.state_code_id']);
            
            if (is_null($stateCode)) {
                $this->logger->logImportHistoryItem(
                    $importHistory, 'Invalid T_REVIEW.state_code_id: ' . $indata['T_REVIEW.state_code_id'], StateCode::class, $row, ImportHistoryItem::E_INVALID_ID
                );
            }
        } else if ($data['state'] != null || $data['title'] != null || $data['division'] != null || $data['chapter'] != null || $data['part'] != null || $data['article'] != null || $data['section'] != null) {
            $query = $entityManager->createQuery('SELECT s FROM Application\Entity\StateCode s WHERE s.state = :state AND s.title = :title AND s.division = :division AND s.chapter = :chapter AND s.part = :part AND s.article = :article AND s.section = :section');
            $query->setParameters(array(
                'state'    => Replace::replaceNullWithAlt($data['state'], ''),
                'title'    => Replace::replaceNullWithAlt($data['title'], ''),
                'division' => Replace::replaceNullWithAlt($data['division'], ''),
                'chapter'  => Replace::replaceNullWithAlt($data['chapter'], ''),
                'part'     => Replace::replaceNullWithAlt($data['part'], ''),
                'article'  => Replace::replaceNullWithAlt($data['article'], ''),
                'section'  => Replace::replaceNullWithAlt($data['section'], '')
            ));
            $stateCodes = $query->getResult();
            
            // Take first state code
            if (sizeof($stateCodes) > 0) {
                $stateCode = $stateCodes[0];
            } else {
                $stateCode = new StateCode();
            }
            
            $stateCode->exchangeData($data, $entityManager);
            $entityManager->persist($stateCode);
            $entityManager->flush();
        }
        
        return $stateCode;
    }
    
    private function importMunicipalCode($indata, $entityManager, $row, $importHistory)
    {
        $data = $this->getColumnsByTableName('T_MUNICIPAL_CODE', $indata);
        
        $municipalCode = null;
        
        if ($indata['T_REVIEW.municipal_code_id'] != null) {
            $municipalCode = $entityManager->find('Application\Entity\MunicipalCode', $indata['T_REVIEW.municipal_code_id']);
            
            if (is_null($municipalCode)) {
                $this->logger->logImportHistoryItem(
                    $importHistory, 'Invalid T_REVIEW.municipal_code_id: ' . $indata['T_REVIEW.municipal_code_id'], MunicipalCode::class, $row, ImportHistoryItem::E_INVALID_ID
                );
            }
        } else if ($data['state'] != null || $data['municipality'] != null || $data['title'] != null) {
            $query = $entityManager->createQuery('SELECT m FROM Application\Entity\MunicipalCode m WHERE m.state = :state AND m.municipality = :municipality AND m.title = :title');
            $query->setParameters(array(
                'state'        => Replace::replaceNullWithAlt($data['state'], ''),
                'municipality' => Replace::replaceNullWithAlt($data['municipality'], ''),
                'title'        => Replace::replaceNullWithAlt($data['title'], '')
            ));
            $municipalCodes = $query->getResult();
            
            // Take first state code
            if (sizeof($municipalCodes) > 0) {
                $municipalCode = $municipalCodes[0];
            } else {
                $municipalCode = new MunicipalCode();
            }
            
            $municipalCode->exchangeData($data, $entityManager);
            $entityManager->persist($municipalCode);
            $entityManager->flush();
        }
        
        return $municipalCode;
    }
    
    private function importFeedbacks($indata, $entityManager, $row, $importHistory)
    {
        $feedbacks = new \Doctrine\Common\Collections\ArrayCollection();
        
        if ($indata['T_REVIEW_has_T_FEEDBACK_CD.feedback_key'] != null) {
            $keys = explode(',', rtrim($indata['T_REVIEW_has_T_FEEDBACK_CD.feedback_key'], ','));
            
            for ($i=0; $i<sizeof($keys); $i++) {
                if (!empty($keys[$i])) {
                    $feedback = $entityManager->find('Application\Entity\Feedback', trim($keys[$i]));
                    
                    if (is_null($feedback)) {
                        $this->logger->logImportHistoryItem(
                            $importHistory, 'Invalid T_REVIEW_has_T_FEEDBACK_CD.feedback_key: ' . trim($keys[$i]), Feedback::class, $row, ImportHistoryItem::E_INVALID_ID
                        );
                    } else {
                        $feedbacks->add($feedback);
                    }
                }
            }
        }
        
        return $feedbacks;
    }
    
    private function importActions($indata, $entityManager, $row, $importHistory)
    {
        $actions = new \Doctrine\Common\Collections\ArrayCollection();
        
        if ($indata['T_REVIEW_has_T_ACTION_CD.action_key'] != null) {
            $keys = explode(',', rtrim($indata['T_REVIEW_has_T_ACTION_CD.action_key'], ','));
            
            for ($i=0; $i<sizeof($keys); $i++) {
                if (!empty($keys[$i])) {
                    $action = $entityManager->find('Application\Entity\Action', trim($keys[$i]));
                    
                    if (is_null($action)) {
                        $this->logger->logImportHistoryItem(
                            $importHistory, 'Invalid T_REVIEW_has_T_ACTION_CD.action_key: ' . trim($keys[$i]), Action::class, $row, ImportHistoryItem::E_INVALID_ID
                        );
                    } else {
                        $actions->add($action);
                    }
                }
            }
        }
        
        return $actions;
    }
    
    private function importImpactTags($indata, $entityManager, $row, $importHistory)
    {
        $impactTags = new \Doctrine\Common\Collections\ArrayCollection();
        
        if ($indata['T_REVIEW_has_T_IMPACT_TAG.impact_key'] != null) {
            $tags = explode(',', rtrim($indata['T_REVIEW_has_T_IMPACT_TAG.impact_key'], ','));
            
            for ($i=0; $i<sizeof($tags); $i++) {
                $impactTag = $entityManager->find('Application\Entity\ImpactTag', trim($tags[$i]));
                
                if (is_null($impactTag)) {
                    $this->logger->logImportHistoryItem(
                        $importHistory, 'Invalid T_REVIEW_has_T_IMPACT_TAG.impact_key: ' . $indata['T_REVIEW_has_T_IMPACT_TAG.impact_key'], ImpactTag::class, $row, ImportHistoryItem::E_INVALID_ID
                    );
                } else {
                    $impactTags->add($impactTag);
                }
            }
        }
        
        return $impactTags;
    }
    
    private function importReview($indata, $cfrs, $statute, $stateCode, $municipalCode, $feedbacks, $actions, $impactTags, $entityManager, $row, $importHistory)
    {
        $data = $this->getColumnsByTableName('T_REVIEW', $indata);
        $data['cfrs'] = $cfrs;
        $data['statute'] = $statute;
        $data['stateCode'] = $stateCode;
        $data['municipalCode'] = $municipalCode;
        $data['feedbacks'] = $feedbacks;
        $data['actions'] = $actions;
        $data['impactTags'] = $impactTags;
        
        $review = null;
        
        if ($data['id'] != null) {
            $review = $entityManager->find('Application\Entity\Review', $data['id']);
            
            if (is_null($review)) {
                $this->logger->logImportHistoryItem(
                    $importHistory, 'Invalid T_REVIEW.id: ' . $data['id'], Review::class, $row, ImportHistoryItem::E_INVALID_ID
                );
                $importHistory->incrementFailed();
                
                return null;
            } else {
                $importHistory->incrementUpdated();
            }
        }
        
        if (is_null($review)) {
            $review = new Review();
        }
        $review->exchangeData($data, $entityManager);
        $entityManager->persist($review);
        $entityManager->flush();
        
        $importHistory->incrementSucceeded();
        
        return $review;
    }
    
    /*
     * @Deprecated.  Decided to move to future UI for commenting on reviews.
     */
    private function importReviewComments($review, $indata, $entityManager)
    {
        $data = $this->getColumnsByTableName('T_REVIEW_COMMENT', $indata);
        $data['review'] = $review;
        
        // Argive comments
        if ($data['user_name=argive'] != null) {
            $data['user_name'] = 'argive';
            $data['is_user_anonymity_requested'] = false;
            $data['comment'] = $data['user_name=argive'];
            
            $query = $entityManager->createQuery('SELECT c FROM Application\Entity\ReviewComment c WHERE c.review =:review AND c.userName = :userName');
            $query->setParameters(array(
                'review'   => $review,
                'userName' => 'argive'
            ));
            
            $comments = $query->getResult();
            
            // Take first comment
            // Take first state code
            if (sizeof($comments) > 0) {
                $comment = $comments[0];
            } else {
                $comment = new ReviewComment();
            }
            
            $comment->exchangeData($data, $entityManager);
            $entityManager->persist($comment);
            $entityManager->flush();
        }
        
        // Agency response
        if ($data['user_name=agency_response'] != null) {
            $data['user_name'] = 'agency_response';
            $data['is_user_anonymity_requested'] = false;
            $data['comment'] = $data['user_name=agency_response'];
            
            $query = $entityManager->createQuery('SELECT c FROM Application\Entity\ReviewComment c WHERE c.review =:review AND c.userName = :userName');
            $query->setParameters(array(
                'review'   => $review,
                'userName' => 'agency_response'
            ));
            
            $comments = $query->getResult();
            
            // Take first comment
            // Take first state code
            if (sizeof($comments) > 0) {
                $comment = $comments[0];
            } else {
                $comment = new ReviewComment();
            }
            
            $comment->exchangeData($data, $entityManager);
            $entityManager->persist($comment);
            $entityManager->flush();
        }
    }
    
    public function historyAction()
    {
        $query = $this->em->createQuery('SELECT h FROM Application\Entity\ImportHistory h ORDER BY h.importAt DESC');
        $importHistory = $query->getResult();
        
        return new ViewModel(array(
            'importHistory' => $importHistory
        ));
    }
    
    public function historyDetailsAction()
    {
        $id = $this->params()->fromRoute('id');
        $importHistory = $this->em->find('Application\Entity\ImportHistory', $id);
        
        return new ViewModel(array(
            'importHistoryItems' => $importHistory->getImportHistoryItems()
        ));
    }
}
