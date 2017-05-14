<?php
namespace Export\Factory\View;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Export\View\Strategy\XlsxStrategy;

class XlsxFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface$serviceLocator)
    {
        $viewRenderer = $serviceLocator->get('ViewRenderer');
        return new XlsxStrategy($viewRenderer);
    }
}
