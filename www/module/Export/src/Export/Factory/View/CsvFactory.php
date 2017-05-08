<?php
namespace Export\Factory\View;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Export\View\Strategy\CsvStrategy;

class CsvFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface$serviceLocator)
    {
        $viewRenderer = $serviceLocator->get('ViewRenderer');
        return new CsvStrategy($viewRenderer);
    }
}
