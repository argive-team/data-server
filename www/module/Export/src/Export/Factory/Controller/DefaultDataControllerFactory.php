<?php
namespace Export\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use Export\Controller\DefaultDataController;

class DefaultDataControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $container)
    {
        $parentLocator = $container->getServiceLocator();
        
        $config = $parentLocator->get('Config');
        
        $session = new Container('user');
        $environment = $session->offsetGet('environment');
        if (empty($environment) || $environment == 'production') {
            $em = $parentLocator->get('doctrine.entitymanager.orm_default');
        } else {
            $em = $parentLocator->get('doctrine.entitymanager.orm_development');
        }
        
        return new DefaultDataController($config, $em);
    }
}

