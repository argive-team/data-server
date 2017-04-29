<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Import for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Import\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Import\Controller\ReviewController;

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

