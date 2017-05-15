<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Export for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Export\Controller;

use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use Zend\Http\Headers;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DefaultDataController extends AbstractActionController
{
    protected $config;
    protected $em;
    
    public function __construct($config, $em)
    {
        date_default_timezone_set('America/Los_Angeles');
        
        $this->config = $config;
        $this->em = $em;
    }
    
    public function indexAction()
    {
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setTitle('Argive Default Data Export');
        $worksheetIndex = 0;
        
        // Action keys
        $actions = $this->em->getRepository('Application\Entity\Action')->findAll();
        $worksheet = $objPHPExcel->getSheet($worksheetIndex);
        $worksheet->setTitle('Action Keys');
        $this->writeToWorksheet($worksheet, $actions);
        
        // Agencies
        $agencies = $this->em->getRepository('Application\Entity\Agency')->findAll();
        $worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'Agencies');
        $objPHPExcel->addSheet($worksheet, ++$worksheetIndex);
        $this->writeToWorksheet($worksheet, $agencies);
        
        // Feedback keys
        $feedbacks = $this->em->getRepository('Application\Entity\Feedback')->findAll();
        $worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'Feedback Keys');
        $objPHPExcel->addSheet($worksheet, ++$worksheetIndex);
        $this->writeToWorksheet($worksheet, $feedbacks);
        
        // NAICS
        $naics = $this->em->getRepository('Application\Entity\Naics')->findAll();
        $worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'NAICS');
        $objPHPExcel->addSheet($worksheet, ++$worksheetIndex);
        $this->writeToWorksheet($worksheet, $naics);
        
        // State codes
        $stateCodes = $this->em->getRepository('Application\Entity\StateCode')->findAll();
        $worksheet = new \PHPExcel_Worksheet($objPHPExcel, 'State Codes');
        $objPHPExcel->addSheet($worksheet, ++$worksheetIndex);
        $this->writeToWorksheet($worksheet, $stateCodes);
        
        // Output writer
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filename = 'Argive Default Data Export ' . date("Y-m-d G:i:s") . '.xlsx';
        $response = $this->createHttpResponse($objWriter, $filename);
        
        return $response;
    }
    
    private function writeToWorksheet(\PHPExcel_Worksheet $worksheet, $results)
    {
        $row = 1;
        foreach ($results as $result) {
            if ($row == 1) {
                $result->setPHPExcelColumnHeader($worksheet);
                $row++;
            }
            $result->setPHPExelRow($worksheet, $row);
            $row++;
        }
    }
    
    private function createHttpResponse(\PHPExcel_Writer_IWriter $writer, $filename)
    {
        $headers = [
            'Pragma' => 'public',
            'Cache-control' => 'must-revalidate, post-check=0, pre-check=0',
            'Cache-control' => 'private',
            'Expires' => '0000-00-00',
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];
        
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();
        
        $response = new Response();
        $response->setContent($content);
        $response->setStatusCode('200');
        
        $responseHeaders = new Headers();
        $responseHeaders->addHeaders($headers);
        $response->setHeaders($responseHeaders);
        
        return $response;
    }
}
