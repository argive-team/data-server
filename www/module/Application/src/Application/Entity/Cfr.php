<?php
namespace Application\Entity;

use Application\Utilility\Replace;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_CFR",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class Cfr
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(name="cfr_title", length=256) */
    protected $cfrTitle;
    
    /** @ORM\Column(name="cfr_part", length=256) */
    protected $cfrPart;
    
    /** @ORM\Column(length=256) */
    protected $subpart;
    
    /** @ORM\Column(name="discretionary_type", length=64) */
    protected $discretionaryType;
    
    /**
     * @ORM\ManyToOne(targetEntity="Agency", fetch="EAGER")
     * @ORM\JoinColumn(name="agency_id", referencedColumnName="id")
     */
    protected $agency;
    
    /** @ORM\Column(name="code_link", length=256) */
    protected $codeLink;
    
    /** @ORM\Column(name="cfr_title_description", length=2048) */
    protected $cfrTitleDescription;
    
    /** @ORM\Column(name="regulatory_code_description", length=2048) */
    protected $regulatoryCodeDescription;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $wordcount;
    
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
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $industry;
    
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

    public function getCfrTitle()
    {
        return $this->cfrTitle;
    }

    public function getCfrPart()
    {
        return $this->cfrPart;
    }

    public function getSubpart()
    {
        return $this->subpart;
    }

    public function getDiscretionaryType()
    {
        return $this->discretionaryType;
    }

    public function getAgency()
    {
        return $this->agency;
    }

    public function getCodeLink()
    {
        return $this->codeLink;
    }

    public function getCfrTitleDescription()
    {
        return $this->cfrTitleDescription;
    }

    public function getRegulatoryCodeDescription()
    {
        return $this->regulatoryCodeDescription;
    }

    public function getWordcount()
    {
        return $this->wordcount;
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

    public function getIndustry()
    {
        return $this->industry;
    }

    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
    
    public function setCfrTitle($cfrTitle)
    {
        $this->cfrTitle = $cfrTitle;
    }

    public function setCfrPart($cfrPart)
    {
        $this->cfrPart = $cfrPart;
    }

    public function setSubpart($subpart)
    {
        $this->subpart = $subpart;
    }

    public function setDiscretionaryType($discretionaryType)
    {
        $this->discretionaryType = $discretionaryType;
    }

    public function setAgency($agency)
    {
        $this->agency = $agency;
    }

    public function setCodeLink($codeLink)
    {
        $this->codeLink = $codeLink;
    }

    public function setCfrTitleDescription($cfrTitleDescription)
    {
        $this->cfrTitleDescription = $cfrTitleDescription;
    }

    public function setRegulatoryCodeDescription($regulatoryCodeDescription)
    {
        $this->regulatoryCodeDescription = $regulatoryCodeDescription;
    }

    public function setWordcount($wordcount)
    {
        $this->wordcount = $wordcount;
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

    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->cfrTitle = Replace::replaceNullWithAlt($data['cfr_title'], '');
        $this->cfrPart = Replace::replaceNullWithAlt($data['cfr_part'], '');
        $this->subpart = Replace::replaceNullWithAlt($data['subpart'], '');
        $this->discretionaryType = Replace::replaceNullWithAlt($data['discretionary_type'], '');
        $this->codeLink = Replace::replaceNullWithAlt($data['code_link'], '');
        $this->cfrTitleDescription = Replace::replaceNullWithAlt($data['cfr_title_description'], '');
        $this->regulatoryCodeDescription = Replace::replaceNullWithAlt($data['regulatory_code_description'], '');
        $this->dateUpdated = new \DateTime();
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'id');
        $worksheet->setCellValue('B1', 'cfr_title');
        $worksheet->setCellValue('C1', 'cfr_part');
        $worksheet->setCellValue('D1', 'subpart');
        $worksheet->setCellValue('E1', 'discretionary_type');
        $worksheet->setCellValue('F1', 'code_link');
        $worksheet->setCellValue('G1', 'regulatory_code_description');
        $worksheet->setCellValue('H1', 'date_updated');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getId());
        $worksheet->setCellValue('B' . $row, $this->getCfrTitle());
        $worksheet->setCellValue('C' . $row, $this->getCfrPart());
        $worksheet->setCellValue('D' . $row, $this->getSubpart());
        $worksheet->setCellValue('E' . $row, $this->getDiscretionaryType());
        $worksheet->setCellValue('F' . $row, $this->getCodeLink());
        $worksheet->setCellValue('G' . $row, $this->getRegulatoryCodeDescription());
        $worksheet->setCellValue('H' . $row, $this->getDateUpdated()->format('Y-m-d H:i:s'));
    }
}
