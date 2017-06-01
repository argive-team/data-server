<?php
namespace Application\Entity;

use Application\Utilility\Replace;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_STATUTE",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class Statute
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(length=512) */
    protected $statute;
    
    /** @ORM\Column(name="statute_title", length=512) */
    protected $statuteTitle;
    
    /** @ORM\Column(name="statute_description", length=2048) */
    protected $statuteDescription;
    
    /** @ORM\Column(name="statute_jurisdiction", length=12) */
    protected $statuteJurisdiction;
    
    /** @ORM\Column(name="jurisdiction_name", length=256) */
    protected $jurisdictionName;
    
    /** @ORM\Column(length=2) */
    protected $state;
    
    public function getId()
    {
        return $this->id;
    }

    public function getStatute()
    {
        return $this->statute;
    }

    public function getStatuteTitle()
    {
        return $this->statuteTitle;
    }

    public function getStatuteDescription()
    {
        return $this->statuteDescription;
    }

    public function getStatuteJurisdiction()
    {
        return $this->statuteJurisdiction;
    }

    public function getJurisdictionName()
    {
        return $this->jurisdictionName;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function setStatute($statute)
    {
        $this->statute = $statute;
    }

    public function setStatuteTitle($statuteTitle)
    {
        $this->statuteTitle = $statuteTitle;
    }

    public function setStatuteDescription($statuteDescription)
    {
        $this->statuteDescription = $statuteDescription;
    }

    public function setStatuteJurisdiction($statuteJurisdiction)
    {
        $this->statuteJurisdiction = $statuteJurisdiction;
    }

    public function setJurisdictionName($jurisdictionName)
    {
        $this->jurisdictionName = $jurisdictionName;
    }
    
    public function setState($state)
    {
        $this->state = $state;
    }
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->statute = Replace::replaceNullWithAlt($data['statute'], '');
        $this->statuteTitle = Replace::replaceNullWithAlt($data['statute_title'], '');
        $this->statuteDescription = Replace::replaceNullWithAlt($data['statute_description'], '');
        $this->statuteJurisdiction = Replace::replaceNullWithAlt($data['statute_jurisdiction'], '');
        $this->jurisdictionName = Replace::replaceNullWithAlt($data['jurisdiction_name'], '');
        $this->state = Replace::replaceNullWithAlt($data['state'], '');
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'id');
        $worksheet->setCellValue('B1', 'statute');
        $worksheet->setCellValue('C1', 'statute_title');
        $worksheet->setCellValue('D1', 'statute_description');
        $worksheet->setCellValue('E1', 'statute_jurisdiction');
        $worksheet->setCellValue('F1', 'jurisdiction_name');
        $worksheet->setCellValue('G1', 'jurisdiction_name');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getId());
        $worksheet->setCellValue('B' . $row, $this->getStatute());
        $worksheet->setCellValue('C' . $row, $this->getStatuteTitle());
        $worksheet->setCellValue('D' . $row, $this->getStatuteDescription());
        $worksheet->setCellValue('E' . $row, $this->getStatuteJurisdiction());
        $worksheet->setCellValue('F' . $row, $this->getJurisdictionName());
        $worksheet->setCellValue('G' . $row, $this->getState());
    }
}
