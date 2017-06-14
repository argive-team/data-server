<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_IMPORT_HISTORY",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class ImportHistory
{
    const TYPE_REVIEW = 'REVIEW';
    
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="ImportHistoryItem", mappedBy="importHistory", fetch="EAGER")
     */
    protected $importHistoryItems;
    
    /** @ORM\Column(name="type", length=64) */
    protected $type;
    
    /** @ORM\Column(name="file_name", length=512) */
    protected $fileName;
    
    /** @ORM\Column(type="integer") */
    protected $total;
    
    /** @ORM\Column(type="integer") */
    protected $succeeded;
    
    /** @ORM\Column(type="integer") */
    protected $updated;
    
    /** @ORM\Column(type="integer") */
    protected $failed;
    
    /** @ORM\Column(name="import_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"}) */
    protected $importAt;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
        
        $this->importHistoryItems = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getImportHistoryItems()
    {
        return $this->importHistoryItems;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getFileName()
    {
        return $this->fileName;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getSucceeded()
    {
        return $this->succeeded;
    }
    
    public function getUpdated()
    {
        return $this->updated;
    }

    public function getFailed()
    {
        return $this->failed;
    }

    public function getImportAt()
    {
        return $this->importAt;
    }
    
    public function setImportHistoryItems($importHistoryItems)
    {
        $this->importHistoryItems = $importHistoryItems;
    }
    
    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setSucceeded($succeeded)
    {
        $this->succeeded = $succeeded;
    }
    
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }
    
    public function setFailed($failed)
    {
        $this->failed = $failed;
    }

    public function setImportAt($importAt)
    {
        $this->importAt = $importAt;
    }
    
    public function incrementSucceeded()
    {
        $this->succeeded++;
    }
    
    public function incrementUpdated()
    {
        $this->updated++;
    }
    
    public function incrementFailed()
    {
        $this->failed++;
    }
}

