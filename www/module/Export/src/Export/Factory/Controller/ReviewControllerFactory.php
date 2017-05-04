<?php
namespace Export\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Export\Controller\ReviewController;

class ReviewControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $container)
    {
        $parentLocator = $container->getServiceLocator();
        $config = $parentLocator->get('Config');
        $em = $parentLocator->get('doctrine.entitymanager.orm_default');
        
        return new ReviewController($config, $em);
    }
}

