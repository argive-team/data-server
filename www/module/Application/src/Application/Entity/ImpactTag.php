<?php
namespace Application\Entity;

use PHPExcel_Worksheet;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_IMPACT_TAG",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="impact_key_UNIQUE", columns={"impact_key"})}
 *      )
 */
class ImpactTag
{
    /** @ORM\Id @ORM\Column(name="impact_key", type="integer") */
    protected $impactKey;
    
    /** @ORM\Column(length=8) */
    protected $tone;
    
    /** @ORM\Column(length=256) */
    protected $specifics;
    
    public function getImpactKey()
    {
        return $this->impactKey;
    }

    public function getTone()
    {
        return $this->tone;
    }
    
    public function getSpecifics()
    {
        return $this->specifics;
    }

    public function setImpactKey($impactKey)
    {
        $this->impactKey= $impactKey;
    }

    public function setTone($tone)
    {
        $this->tone = $tone;
    }
    
    public function setSpecifics($specifics)
    {
        $this->specifics = $specifics;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'feedback_key');
        $worksheet->setCellValue('B1', 'tone');
        $worksheet->setCellValue('C1', 'specifics');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getFeedbackKey());
        $worksheet->setCellValue('B' . $row, $this->getTone());
        $worksheet->setCellValue('C' . $row, $this->getSpecifics());
    }
}
