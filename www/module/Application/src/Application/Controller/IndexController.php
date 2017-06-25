<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function changeEnvAction()
    {
        $environment= $this->params()->fromPost('environment');
        
        $session = new Container('user');
        $session->offsetSet('environment', $environment);
        
        $result = new JsonModel(array(
            'done' => true,
        ));
        
        return $result;
    }
}
