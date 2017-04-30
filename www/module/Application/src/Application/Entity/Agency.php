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
    protected $parentAgencyId;
    
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

    public function getParentAgencyId()
    {
        return $this->parentAgencyId;
    }

    public function getIsMainAgency()
    {
        return $this->isMainAgency;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setParentAgencyId($parentAgencyId)
    {
        $this->parentAgencyId = $parentAgencyId;
    }

    public function setIsMainAgency($isMainAgency)
    {
        $this->isMainAgency = $isMainAgency;
    }

    
    
}

