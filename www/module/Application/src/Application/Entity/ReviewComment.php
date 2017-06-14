<?php
namespace Application\Entity;

use Application\Utilility\Replace;
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
     * @ORM\ManyToOne(targetEntity="Review", inversedBy="reviewComments", fetch="EAGER")
     * @ORM\JoinColumn(name="review_id", referencedColumnName="id", nullable=false)
     */
    protected $review;
    
    /** @ORM\Column(name="user_name", length=255) */
    protected $userName;
    
    /** @ORM\Column(name="is_user_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isUserAnonymityRequested;
    
    /** @ORM\Column(name="comment_at", type="datetime", options={"default":"CURRENT_TIMESTAMP"}) */
    protected $commentAt;
    
    /** @ORM\Column(name="comment", length=2048) */
    protected $comment;
    
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
    
    public function getComment()
    {
        return $this->comment;
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
    
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->review = $data['review'];
        $this->userName = $data['user_name'];
        $this->isUserAnonymityRequested = $data['is_user_anonymity_requested'];
        $this->commentAt = Replace::replaceNullWithAlt(\DateTime::createFromFormat('Y-m-d H:i:s', $data['comment_at']), new \DateTime());
        $this->comment = $data['comment'];
    }
}

