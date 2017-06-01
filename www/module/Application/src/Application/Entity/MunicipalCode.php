<?php
namespace Application\Entity;

use Application\Utilility\Replace;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_MUNICIPAL_CODE",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class MunicipalCode
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(length=2) */
    protected $state;
    
    /** @ORM\Column(length=1024) */
    protected $municipality;
    
    /** @ORM\Column(length=2048) */
    protected $title;
    
    public function getId()
    {
        return $this->id;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getMunicipality()
    {
        return $this->municipality;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->state = Replace::replaceNullWithAlt($data['state'], '');
        $this->municipality = Replace::replaceNullWithAlt($data['municipality'], '');
        $this->title = Replace::replaceNullWithAlt($data['title'], '');
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'id');
        $worksheet->setCellValue('B1', 'state');
        $worksheet->setCellValue('C1', 'municipality');
        $worksheet->setCellValue('D1', 'title');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getId());
        $worksheet->setCellValue('B' . $row, $this->getState());
        $worksheet->setCellValue('C' . $row, $this->getMunicipality());
        $worksheet->setCellValue('D' . $row, $this->getTitle());
    }
}
