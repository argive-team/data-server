<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_IMPORT_HISTORY_ITEM",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class ImportHistoryItem
{
    const E_ERROR      = "E_ERROR";
    const E_INVALID_ID = "E_INVALID_ID";
    const E_NOTICE     = "E_NOTICE";
    const E_PARSE      = "E_PARSE";
    
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImportHistory", inversedBy="importHistoryItems", fetch="EAGER")
     * @ORM\JoinColumn(name="import_history_id", referencedColumnName="id", nullable=false)
     */
    protected $importHistory;
    
    /** @ORM\Column(name="message", length=4096) */
    protected $message;
    
    /** @ORM\Column(name="entity", length=64, nullable=true) */
    protected $entity;
    
    /** @ORM\Column(name="line", type="integer", nullable=true) */
    protected $line;
    
    /** @ORM\Column(name="severity", length=16) */
    protected $severity;
    
    /** @ORM\Column(name="date_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"}) */
    protected $dateAt;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getImportHistory()
    {
        return $this->importHistory;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getDateAt()
    {
        return $this->dateAt;
    }

    public function setImportHistory($importHistory)
    {
        $this->importHistory = $importHistory;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    public function setLine($line)
    {
        $this->line = $line;
    }

    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    public function setDateAt($dateAt)
    {
        $this->dateAt = $dateAt;
    }
}

