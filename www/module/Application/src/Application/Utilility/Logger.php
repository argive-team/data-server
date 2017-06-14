<?php
namespace Application\Utilility;

use Application\Entity\ImportHistory;
use Application\Entity\ImportHistoryItem;

class Logger
{
    protected $em;
    
    public function __construct($em)
    {
        date_default_timezone_set('UTC');
        
        $this->em = $em;
    }
    
    public function logImportHistory($type, $fileName, $total, $succeeded, $updated, $failed)
    {
        $importHistory = new ImportHistory();
        
        $importHistory->setType($type);
        $importHistory->setFileName($fileName);
        $importHistory->setTotal($total);
        $importHistory->setSucceeded($succeeded);
        $importHistory->setUpdated($updated);
        $importHistory->setFailed($failed);
        $importHistory->setImportAt(new \DateTime());
        
        $this->em->persist($importHistory);
        $this->em->flush();
        
        return $importHistory;
    }
    
    public function logImportHistoryItem($importHistory, $message, $entity, $line, $severity)
    {
        $importHistoryItem = new ImportHistoryItem();
        
        $importHistoryItem->setImportHistory($importHistory);
        $importHistoryItem->setMessage($message);
        $importHistoryItem->setEntity($entity);
        $importHistoryItem->setLine($line);
        $importHistoryItem->setSeverity($severity);
        $importHistoryItem->setDateAt(new \Datetime());
        
        $this->em->persist($importHistoryItem);
        $this->em->flush();
        
        return $importHistoryItem;
    }
}

