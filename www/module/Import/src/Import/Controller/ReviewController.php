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

class ReviewController extends AbstractActionController
{
    protected $config;
    
    public function __construct($config)
    {
        $this->config= $config;
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
        $targetDir = $config['argive']['reviews']['upload_dir'];
        $cleanupTargetDir = $config['argive']['reviews']['cleanup_dir']; // Remove old files
        $maxFileAge = 5 * 3600;   // Temp file age in seconds
        
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
	       $fileName = $_FILES["file"]["name"];
        } else {
	       $fileName = uniqid("file_");
        }
        
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        
        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        
        // Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                $json = '{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
                $this->response->setContent($json);
                $this->response->setStatusCode(Response::STATUS_CODE_500);
                
                return $this->response;
            }
            
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                
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
        $targetDir = $config['argive']['reviews']['upload_dir'];
        $sheetIndex = 0;
        
        $files = glob($targetDir . DIRECTORY_SEPARATOR . '*.[cC][sS][vV]', GLOB_BRACE);
        
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
            
            for ($row = 1; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row);
            }
        }
        
        return array();
    }
}
