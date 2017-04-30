<?php
namespace Application\Entity;

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
}

