<?php
namespace Application\Entity;

use PHPExcel_Worksheet;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_FEEDBACK_CD",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="feedback_key_UNIQUE", columns={"feedback_key"})}
 *      )
 */
class Feedback
{
    /** @ORM\Id @ORM\Column(name="feedback_key", type="integer") */
    protected $feedbackKey;
    
    /** @ORM\Column(length=8) */
    protected $tone;
    
    /** @ORM\Column(length=256) */
    protected $category;
    
    /** @ORM\Column(length=256) */
    protected $specifics;
    
    public function getFeedbackKey()
    {
        return $this->feedbackKey;
    }

    public function getTone()
    {
        return $this->tone;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getSpecifics()
    {
        return $this->specifics;
    }

    public function setFeedbackKey($feedbackKey)
    {
        $this->feedbackKey = $feedbackKey;
    }

    public function setTone($tone)
    {
        $this->tone = $tone;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function setSpecifics($specifics)
    {
        $this->specifics = $specifics;
    }
    
    public function setPHPExcelColumnHeader(\PHPExcel_Worksheet $worksheet)
    {
        $worksheet->setCellValue('A1', 'feedback_key');
        $worksheet->setCellValue('B1', 'tone');
        $worksheet->setCellValue('C1', 'category');
        $worksheet->setCellValue('D1', 'specifics');
    }
    
    public function setPHPExelRow(\PHPExcel_Worksheet $worksheet, $row)
    {
        $worksheet->setCellValue('A' . $row, $this->getFeedbackKey());
        $worksheet->setCellValue('B' . $row, $this->getTone());
        $worksheet->setCellValue('C' . $row, $this->getCategory());
        $worksheet->setCellValue('D' . $row, $this->getSpecifics());
    }
}
