<?php
namespace Import\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Import\Controller\ReviewController;

class ReviewControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $container)
    {
        $parentLocator = $container->getServiceLocator();
        
        $request = $parentLocator->get('Request');
        
        $config = $parentLocator->get('Config');
        $em = $parentLocator->get('doctrine.entitymanager.orm_default');
        
        return new ReviewController($config, $em);
    }
}

