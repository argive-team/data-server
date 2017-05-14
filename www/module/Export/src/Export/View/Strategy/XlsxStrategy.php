<?php
namespace Export\View\Strategy;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Renderer\RendererInterface;
use Zend\View\ViewEvent;

class XlsxStrategy extends AbstractListenerAggregate
{
    protected $renderer;
    protected $listener = array();
    
    public function __construct(RendererInterface $renderer)
    {
        date_default_timezone_set('America/Los_Angeles');
        
        $this->renderer = $renderer;
    }
    
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }
    
    public function selectRenderer(ViewEvent $e)
    {
        return $this->renderer;
    }
    
    public function injectResponse(ViewEvent $e)
    {
        $renderer = $e->getRenderer();
        if ($renderer !== $this->renderer) {
            return;
        }
        
        $result = $e->getResult();
        
        $filename = 'Argive Default Data Export ' . date("Y-m-d G:i:s");
        
        $response = $e->getResponse();
        $response->setContent($result);
        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->addHeaderLine('Content-Disposition',
                                    sprintf("attachment; filename=\"%s\"", $filename)
                                )
                ->addHeaderLine('Accept-Ranges', 'bytes')
                ->addHeaderLine('Content-Length', strlen($result));
    }
    
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
