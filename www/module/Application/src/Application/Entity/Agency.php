<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_AGENCY",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class Agency
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
        
    /** @ORM\Column(length=256) */
    protected $name;
    
    /** 
     * @ORM\ManyToOne(targetEntity="Agency", fetch="EAGER")
     * @ORM\JoinColumn(name="parent_agency_id", referencedColumnName="id")
     */
    protected $parentAgency;
    
    /** @ORM\Column(name="is_main_agency", type="boolean") */
    protected $isMainAgency;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getParentAgency()
    {
        return $this->parentAgency;
    }

    public function getIsMainAgency()
    {
        return $this->isMainAgency;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setParentAgency($parentAgency)
    {
        $this->parentAgency = $parentAgency;
    }

    public function setIsMainAgency($isMainAgency)
    {
        $this->isMainAgency = $isMainAgency;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'id');
        $worksheet->setCellValue('B1', 'name');
        $worksheet->setCellValue('C1', 'parent_agency_id');
        $worksheet->setCellValue('D1', 'is_main_agency');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getId());
        $worksheet->setCellValue('B' . $row, $this->getName());
        $worksheet->setCellValue('C' . $row, (is_null($this->getParentAgency()) ? '' : $this->getParentAgency()->getId()));
        $worksheet->setCellValue('D' . $row, ($this->getIsMainAgency() ? 1 : 0));
    }
}
