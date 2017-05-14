<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_NAICS",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="NAICS_code_UNIQUE", columns={"NAICS_code"})}
 *      )
 */
class Naics
{
    /** @ORM\Id @ORM\Column(name="NAICS_code", length=6) */
    protected $NAICSCode;
    
    /** @ORM\Column(length=256) */
    protected $title;
    
    public function getNAICSCode()
    {
        return $this->NAICSCode;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setNAICSCode($NAICSCode)
    {
        $this->NAICSCode = $NAICSCode;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function exchangeData($data = array())
    {
        $this->NAICSCode= $data['NAICS_code'];
        $this->title= $data['title'];
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'NAICS_code');
        $worksheet->setCellValue('B1', 'title');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getNAICSCode());
        $worksheet->setCellValue('B' . $row, $this->getTitle());
    }
}
