<?php
namespace Application\Entity;

use PHPExcel_Worksheet;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_ACTION_CD",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="action_key_UNIQUE", columns={"action_key"})}
 *      )
 */
class Action
{
    /** @ORM\Id @ORM\Column(name="action_key", type="integer") */
    protected $actionKey;
    
    /** @ORM\Column(length=8) */
    protected $tone;
    
    /** @ORM\Column(length=256) */
    protected $category;
    
    public function getActionKey()
    {
        return $this->actionKey;
    }
    
    public function getTone()
    {
        return $this->tone;
    }

    public function getCategory()
    {
        return $this->category;
    }
    
    public function setActionKey($actionKey)
    {
        $this->actionKey = $actionKey;
    }

    public function setTone($tone)
    {
        $this->tone = $tone;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'action_key');
        $worksheet->setCellValue('B1', 'tone');
        $worksheet->setCellValue('C1', 'category');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getActionKey());
        $worksheet->setCellValue('B' . $row, $this->getTone());
        $worksheet->setCellValue('C' . $row, $this->getCategory());
    }
}
