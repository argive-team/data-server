<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_REVIEW_COMMENT",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class ReviewComment
{
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Review", fetch="EAGER")
     * @ORM\JoinColumn(name="review_id", referencedColumnName="id", nullable=false)
     */
    protected $review;
    
    /** @ORM\Column(name="user_name", length=255) */
    protected $userName;
    
    /** @ORM\Column(name="is_user_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isUserAnonymityRequested;
    
    /** @ORM\Column(name="comment_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"}) */
    protected $commentAt;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getReview()
    {
        return $this->review;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getIsUserAnonymityRequested()
    {
        return $this->isUserAnonymityRequested;
    }

    public function getCommentAt()
    {
        return $this->commentAt;
    }

    public function setReview($review)
    {
        $this->review = $review;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    public function setIsUserAnonymityRequested($isUserAnonymityRequested)
    {
        $this->isUserAnonymityRequested = $isUserAnonymityRequested;
    }

    public function setCommentAt($commentAt)
    {
        $this->commentAt = $commentAt;
    }

    
}

