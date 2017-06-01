<?php
namespace Application\Entity;

use Application\Utilility\Replace;
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
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $year;
    
    /** @ORM\Column(length=2048) */
    protected $title;
    
    /** @ORM\Column(length=255) */
    protected $article;
    
    /** @ORM\Column(length=255) */
    protected $part;
    
    /** @ORM\Column(length=255) */
    protected $chapter;
    
    /** @ORM\Column(name="file_name", length=255) */
    protected $fileName;
    
    /** @ORM\Column(type="integer", nullable=true) */
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
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $must;
    
    /** @ORM\Column(name="may_not", type="integer", nullable=true) */
    protected $mayNot;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $required;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $prohibited;
    
    /** @ORM\Column(name="restrictions_total", type="integer", nullable=true) */
    protected $restrictionsTotal;
    
    /** @ORM\Column(name="date_updated", type="datetime", nullable=true, options={"default":"CURRENT_TIMESTAMP"}) */
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
    
    public function getArticle()
    {
        return $this->article;
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

    public function getAgency()
    {
        return $this->agency;
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
    
    public function setArticle($article)
    {
        $this->article = $article;
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

    public function setAgency($agency)
    {
        $this->agency = $agency;
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
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->documentTitle = Replace::replaceNullWithAlt($data['document_title'], '');
        $this->state = Replace::replaceNullWithAlt($data['state'], '');
        $this->year = $data['year'];
        $this->title = Replace::replaceNullWithAlt($data['title'], '');
        $this->article = Replace::replaceNullWithAlt($data['article'], '');
        $this->part = Replace::replaceNullWithAlt($data['part'], '');
        $this->chapter = Replace::replaceNullWithAlt($data['chapter'], '');
        $this->fileName = Replace::replaceNullWithAlt($data['file_name'], '');
        $this->wordcount = $data['wordcount'];
        $this->section = Replace::replaceNullWithAlt($data['section'], '');
        $this->regNumber = Replace::replaceNullWithAlt($data['reg_number'], '');
        $this->division = Replace::replaceNullWithAlt($data['division'], '');
        //$this->agency = $data['agency'];
        $this->shall = $data['shall'];
        $this->must = $data['must'];
        $this->mayNot = $data['mayNot'];
        $this->required = $data['required'];
        $this->prohibited = $data['prohibited'];
        $this->restrictionsTotal = $data['restrictions_total'];
        $this->dateUpdated= Replace::replaceNullWithAlt(\DateTime::createFromFormat('Y-m-d H:i:s', $data['date_updated']), new \DateTime());
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'id');
        $worksheet->setCellValue('B1', 'document_title');
        $worksheet->setCellValue('C1', 'state');
        $worksheet->setCellValue('D1', 'year');
        $worksheet->setCellValue('E1', 'title');
        $worksheet->setCellValue('F1', 'article');
        $worksheet->setCellValue('G1', 'part');
        $worksheet->setCellValue('H1', 'chapter');
        $worksheet->setCellValue('I1', 'file_name');
        $worksheet->setCellValue('J1', 'wordcount');
        $worksheet->setCellValue('K1', 'section');
        $worksheet->setCellValue('L1', 'reg_number');
        $worksheet->setCellValue('M1', 'division');
        $worksheet->setCellValue('N1', 'agency_id');
        $worksheet->setCellValue('O1', 'shall');
        $worksheet->setCellValue('P1', 'must');
        $worksheet->setCellValue('Q1', 'may_not');
        $worksheet->setCellValue('R1', 'required');
        $worksheet->setCellValue('S1', 'prohibited');
        $worksheet->setCellValue('T1', 'restrictions_total');
        $worksheet->setCellValue('U1', 'date_updated');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getId());
        $worksheet->setCellValue('B' . $row, $this->getDocumentTitle());
        $worksheet->setCellValue('C' . $row, $this->getState());
        $worksheet->setCellValue('D' . $row, $this->getYear());
        $worksheet->setCellValue('E' . $row, $this->getTitle());
        $worksheet->setCellValue('F' . $row, $this->getArticle());
        $worksheet->setCellValue('G' . $row, $this->getPart());
        $worksheet->setCellValue('H' . $row, $this->getChapter());
        $worksheet->setCellValue('I' . $row, $this->getFileName());
        $worksheet->setCellValue('J' . $row, $this->getWordcount());
        $worksheet->setCellValue('K' . $row, $this->getSection());
        $worksheet->setCellValue('L' . $row, $this->getRegNumber());
        $worksheet->setCellValue('M' . $row, $this->getDivision());
        $worksheet->setCellValue('N' . $row, (is_null($this->getAgency()) ? '' : $this->getAgency()->getId()));
        $worksheet->setCellValue('O' . $row, $this->getShall());
        $worksheet->setCellValue('P' . $row, $this->getMust());
        $worksheet->setCellValue('Q' . $row, $this->getMayNot());
        $worksheet->setCellValue('R' . $row, $this->getRequired());
        $worksheet->setCellValue('S' . $row, $this->getProhibited());
        $worksheet->setCellValue('T' . $row, $this->getRestrictionsTotal());
        $worksheet->setCellValue('U' . $row, $this->getDateUpdated()->format('Y-m-d H:i:s'));
    }
}
