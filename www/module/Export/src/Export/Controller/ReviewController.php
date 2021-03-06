<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Export for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Export\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReviewController extends AbstractActionController
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
        $reviews = $this->em->getRepository('Application\Entity\Review')->findAll();
        
        $model = new ViewModel(array(
            'reviews' => $reviews, 
            'filename' => 'Argive Reviews Export ' . date("Y-m-d G:i:s")
        ));
        $model->setTemplate('export/download/review-csv.phtml')
            ->setTerminal(true);
        
        return $model;
    }
}
