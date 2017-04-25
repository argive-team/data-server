<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_REVIEW",
 *      indexes={@ORM\Index(name="id_UNIQUE", columns={"id"})}
 * )
 */
class Review
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(type="boolean") */
    protected $is_reviewed;
    
    /** @ORM\Column(length=16) */
    protected $review_type;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $cfr_id;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $federal_register_id;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $state_code_id;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $statute_id;
    
    /** @ORM\Column(type="datetime") */
    protected $comment_at;
    
    /** @ORM\Column(length=45) */
    protected $user_type;

    /** @ORM\Column(length=100) */
    protected $first_name;
    
    /** @ORM\Column(length=100) */
    protected $last_name;
    
    /** @ORM\Column(type="boolean") */
    protected $is_user_anonymity_requested;
    
    /** @ORM\Column(length=100) */
    protected $business_name;
    
    /** @ORM\Column(type="boolean") */
    protected $is_business_anonymity_requested;
    
    /** @ORM\Column(length=100) */
    protected $organization_name;
    
    /** @ORM\Column(type="boolean") */
    protected $is_organization_anonymity_requested;
    
    /** @ORM\Column(length=16) */
    protected $zipcode;
    
    /** @ORM\Column(type="boolean") */
    protected $is_zipcode_anonymity_requested;
    
    /** @ORM\Column(length=100) */
    protected $email;
    
    /** @ORM\Column(type="boolean") */
    protected $is_email_anonymity_requested;
    
    /** @ORM\Column(type="integer", nullable=true) */
    protected $num_fte_us_employees;
    
    /** @ORM\Column(length=6) */
    protected $NAICS_code;
    
    /** @ORM\Column(length=4000) */
    protected $user_comments;
    
    /** @ORM\Column(length=2048) */
    protected $suggested_action;
    
    /** @ORM\Column(length=8) */
    protected $complaint_status;
    
    /** @ORM\Column(length=255) */
    protected $origin;
    
    public function getId() { return $this->id; }
    
    public function exchangeData($data)
    {
        $this->id = $data['id'];
    }
}

