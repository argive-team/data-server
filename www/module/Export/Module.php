<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Export for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Export;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
//use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /*
    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $sharedEvents = $e->getApplication()->getEventManager()->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();
        
        $sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function($e) use ($sm) {
            $strategy = $sm->get('CsvStrategy');
            $view = $sm->get('ViewManager')->getView();
            $strategy->attach($view->getEventManager());
        }, 100);
    }
    */
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('render', array($this, 'registerStrategy'), 100);
    }
    
    public function registerStrategy(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $view = $sm->get('ViewManager')->getView();
        
        $routeMatch = $e->getRouteMatch();
        if (!empty($routeMatch)) {
            $routeName = $routeMatch->getMatchedRouteName();
            switch ($routeName) {
                case 'export':
                    $strategy = $sm->get('CsvStrategy');
                    $view->getEventManager()->attach($strategy, 100);
                    break;
                case 'export-default-data':
                    $strategy = $sm->get('XlsxStrategy');
                    $view->getEventManager()->attach($strategy, 100);
                    break;
            }
        }
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CsvStrategy' => 'Export\Factory\View\CsvFactory',
                'XlsxStrategy' => 'Export\Factory\View\XlsxFactory',
            )
        );
    }
}
