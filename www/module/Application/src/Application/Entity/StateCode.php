<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_STATE_CODE",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class StateCode
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
        
    /** @ORM\Column(name="document_title", length=2048) */
    protected $documentTitle;
    
    /** @ORM\Column(length=2) */
    protected $state;
    
    /** @ORM\Column(type="integer") */
    protected $year;
    
    /** @ORM\Column(length=2048) */
    protected $title;
    
    /** @ORM\Column(length=255) */
    protected $part;
    
    /** @ORM\Column(length=255) */
    protected $chapter;
    
    /** @ORM\Column(name="file_name", length=255) */
    protected $fileName;
    
    /** @ORM\Column(type="integer") */
    protected $wordcount;
    
    /** @ORM\Column(length=255) */
    protected $section;
    
    /** @ORM\Column(name="reg_number", length=255) */
    protected $regNumber;
    
    /** @ORM\Column(length=255) */
    protected $division;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agency", fetch="EAGER")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     */
    protected $agency;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $shall;
    
    /** @ORM\Column(type="integer") */
    protected $must;
    
    /** @ORM\Column(name="may_not", type="integer") */
    protected $mayNot;
    
    /** @ORM\Column(type="integer") */
    protected $required;
    
    /** @ORM\Column(type="integer") */
    protected $prohibited;
    
    /** @ORM\Column(name="restrictions_total", type="integer") */
    protected $restrictionsTotal;
    
    /** @ORM\Column(name="date_updated", type="datetime", options={"default":"CURRENT_TIMESTAMP"}) */
    protected $dateUpdated;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDocumentTitle()
    {
        return $this->documentTitle;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPart()
    {
        return $this->part;
    }

    public function getChapter()
    {
        return $this->chapter;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getWordcount()
    {
        return $this->wordcount;
    }

    public function getSection()
    {
        return $this->section;
    }

    public function getRegNumber()
    {
        return $this->regNumber;
    }

    public function getDivision()
    {
        return $this->division;
    }

    public function getAgencyId()
    {
        return $this->agencyId;
    }

    public function getShall()
    {
        return $this->shall;
    }

    public function getMust()
    {
        return $this->must;
    }

    public function getMayNot()
    {
        return $this->mayNot;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getProhibited()
    {
        return $this->prohibited;
    }

    public function getRestrictionsTotal()
    {
        return $this->restrictionsTotal;
    }

    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function setDocumentTitle($documentTitle)
    {
        $this->documentTitle = $documentTitle;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setPart($part)
    {
        $this->part = $part;
    }

    public function setChapter($chapter)
    {
        $this->chapter = $chapter;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function setWordcount($wordcount)
    {
        $this->wordcount = $wordcount;
    }

    public function setSection($section)
    {
        $this->section = $section;
    }

    public function setRegNumber($regNumber)
    {
        $this->regNumber = $regNumber;
    }

    public function setDivision($division)
    {
        $this->division = $division;
    }

    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;
    }

    public function setShall($shall)
    {
        $this->shall = $shall;
    }

    public function setMust($must)
    {
        $this->must = $must;
    }

    public function setMayNot($mayNot)
    {
        $this->mayNot = $mayNot;
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function setProhibited($prohibited)
    {
        $this->prohibited = $prohibited;
    }

    public function setRestrictionsTotal($restrictionsTotal)
    {
        $this->restrictionsTotal = $restrictionsTotal;
    }

    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }
}

