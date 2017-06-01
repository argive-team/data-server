<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_IMPACT_TIMING",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="impact_timing_key_UNIQUE", columns={"impact_timing_key"})}
 *      )
 */
class ImpactTiming
{
    /** @ORM\Id @ORM\Column(name="impact_timing_key", length=8) */
    protected $impactTimingKey;
    
    /** @ORM\Column(length=256) */
    protected $specifics;
    
    public function getImpactTimingKey()
    {
        return $this->impactTimingKey;
    }
    
    public function getSpecifics()
    {
        return $this->specifics;
    }
    
    public function setImpactTimingKey($impactTimingKey)
    {
        $this->impactTimingKey = $impactTimingKey;
    }
    
    public function setSpecifics($specifics)
    {
        $this->specifics = $specifics;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'impact_timing_key');
        $worksheet->setCellValue('B1', 'specifics');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getImpactTimingKey());
        $worksheet->setCellValue('B' . $row, $this->getSpecifics());
    }
    
}
