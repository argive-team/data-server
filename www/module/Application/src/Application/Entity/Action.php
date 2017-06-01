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
    
    /** @ORM\Column(length=256) */
    protected $description;
    
    public function getActionKey()
    {
        return $this->actionKey;
    }
    
    public function getDecription()
    {
        return $this->description;
    }
    
    public function setActionKey($actionKey)
    {
        $this->actionKey = $actionKey;
    }
    
    public function setDescription($description)
    {
        $this->description= $description;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'action_key');
        $worksheet->setCellValue('B1', 'description');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getActionKey());
        $worksheet->setCellValue('B' . $row, $this->getDecription());
    }
}
