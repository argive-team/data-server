<?php
namespace Application\Entity;

use Application\Utilility\Replace;
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
    
    /** @ORM\Column(name="is_reviewed", type="boolean", options={"default":0}) */
    protected $isReviewed;
    
    /** @ORM\Column(name="review_type", length=16) */
    protected $reviewType;
    
    /** @ORM\Column(name="cfr_id", type="integer", nullable=true) */
    protected $cfrId;
    
    /** @ORM\Column(name="federal_register_id", type="integer", nullable=true) */
    protected $federalRegisterId;
    
    /** @ORM\Column(name="state_code_id", type="integer", nullable=true) */
    protected $stateCodeId;
    
    /** @ORM\Column(name="statute_id", type="integer", nullable=true) */
    protected $statuteId;
    
    /** @ORM\Column(name="comment_at", type="datetime") */
    protected $commentAt;
    
    /** @ORM\Column(name="user_type", length=45, options={"default":"BUSINESS_OWNER"}) */
    protected $userType;

    /** @ORM\Column(name="first_name", length=100) */
    protected $firstName;
    
    /** @ORM\Column(name="last_name", length=100) */
    protected $lastName;
    
    /** @ORM\Column(name="is_user_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isUserAnonymityRequested;
    
    /** @ORM\Column(name="business_name", length=100) */
    protected $businessName;
    
    /** @ORM\Column(name="is_business_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isBusinessAnonymityRequested;
    
    /** @ORM\Column(name="organization_name", length=100) */
    protected $organizationName;
    
    /** @ORM\Column(name="is_organization_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isOrganizationAnonymityRequested;
    
    /** @ORM\Column(length=16) */
    protected $zipcode;
    
    /** @ORM\Column(name="is_zipcode_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isZipcodeAnonymityRequested;
    
    /** @ORM\Column(length=100) */
    protected $email;
    
    /** @ORM\Column(name="is_email_anonymity_requested", type="boolean", options={"default":1}) */
    protected $isEmailAnonymityRequested;
    
    /** @ORM\Column(name="num_fte_us_employees", type="integer", nullable=true) */
    protected $numFteUsEmployees;
    
    /** @ORM\Column(name="NAICS_code", length=6) */
    protected $NAICSCode;
    
    /** @ORM\Column(name="user_comments", length=4000) */
    protected $userComments;
    
    /** @ORM\Column(name="suggested_action", length=2048) */
    protected $suggestedAction;
    
    /** @ORM\Column(name="complaint_status", length=8, options={"default":"OPEN"}) */
    protected $complaintStatus;
    
    /** @ORM\Column(length=255, options={"default":"USER"}) */
    protected $origin;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getIsReviewed()
    {
        return $this->isReviewed;
    }

    public function getReviewType()
    {
        return $this->reviewType;
    }

    public function getCfrId()
    {
        return $this->cfrId;
    }

    public function getFederalRegisterId()
    {
        return $this->federalRegisterId;
    }

    public function getStateCodeId()
    {
        return $this->stateCodeId;
    }

    public function getStatuteId()
    {
        return $this->statuteId;
    }

    public function getCommentAt()
    {
        return $this->commentAt;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getIsUserAnonymityRequested()
    {
        return $this->isUserAnonymityRequested;
    }

    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function getIsBusinessAnonymityRequested()
    {
        return $this->isBusinessAnonymityRequested;
    }

    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    public function getIsOrganizationAnonymityRequested()
    {
        return $this->isOrganizationAnonymityRequested;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getIsZipcodeAnonymityRequested()
    {
        return $this->isZipcodeAnonymityRequested;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIsEmailAnonymityRequested()
    {
        return $this->isEmailAnonymityRequested;
    }

    public function getNumFteUsEmployees()
    {
        return $this->numFteUsEmployees;
    }

    public function getNAICSCode()
    {
        return $this->NAICSCode;
    }

    public function getUserComments()
    {
        return $this->userComments;
    }

    public function getSuggestedAction()
    {
        return $this->suggestedAction;
    }

    public function getComplaintStatus()
    {
        return $this->complaintStatus;
    }

    public function getOrigin()
    {
        return $this->origin;
    }

    public function setIsReviewed($isReviewed)
    {
        $this->isReviewed = $isReviewed;
    }

    public function setReviewType($reviewType)
    {
        $this->reviewType = $reviewType;
    }

    public function setCfrId($cfrId)
    {
        $this->cfrId = $cfrId;
    }

    public function setFederalRegisterId($federalRegisterId)
    {
        $this->federalRegisterId = $federalRegisterId;
    }

    public function setStateCodeId($stateCodeId)
    {
        $this->stateCodeId = $stateCodeId;
    }

    public function setStatuteId($statuteId)
    {
        $this->statuteId = $statuteId;
    }

    public function setCommentAt($commentAt)
    {
        $this->commentAt = $commentAt;
    }

    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setIsUserAnonymityRequested($isUserAnonymityRequested)
    {
        $this->isUserAnonymityRequested = $isUserAnonymityRequested;
    }

    public function setBusinessName($businessName)
    {
        $this->businessName = $businessName;
    }

    public function setIsBusinessAnonymityRequested($isBusinessAnonymityRequested)
    {
        $this->isBusinessAnonymityRequested = $isBusinessAnonymityRequested;
    }

    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    public function setIsOrganizationAnonymityRequested($isOrganizationAnonymityRequested)
    {
        $this->isOrganizationAnonymityRequested = $isOrganizationAnonymityRequested;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function setIsZipcodeAnonymityRequested($isZipcodeAnonymityRequested)
    {
        $this->isZipcodeAnonymityRequested = $isZipcodeAnonymityRequested;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setIsEmailAnonymityRequested($isEmailAnonymityRequested)
    {
        $this->isEmailAnonymityRequested = $isEmailAnonymityRequested;
    }

    public function setNumFteUsEmployees($numFteUsEmployees)
    {
        $this->numFteUsEmployees = $numFteUsEmployees;
    }

    public function setNAICSCode($NAICSCode)
    {
        $this->NAICSCode = $NAICSCode;
    }

    public function setUserComments($userComments)
    {
        $this->userComments = $userComments;
    }

    public function setSuggestedAction($suggestedAction)
    {
        $this->suggestedAction = $suggestedAction;
    }

    public function setComplaintStatus($complaintStatus)
    {
        $this->complaintStatus = $complaintStatus;
    }

    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }
    
    public function exchangeData($data = array())
    {
        //$data = array_filter($data, function($value) { return $value != null; });
        
        $this->id = $data['id'];
        $this->isReviewed = ($data['is_reviewed'] == null ? 0 : 1);
        $this->reviewType = Replace::replaceNullWithAlt($data['review_type'], 'CFR');
        $this->cfrId = $data['cfr_id'];
        $this->federalRegisterId = $data['federal_register_id'];
        $this->stateCodeId = $data['state_code_id'];
        $this->statuteId = $data['statute_id'];
        $this->commentAt = Replace::replaceNullWithAlt(\DateTime::createFromFormat('Y-m-d H:i:s', $data['comment_at']), new \DateTime());
        $this->userType = Replace::replaceNullWithAlt($data['user_type'], 'BUSINESS_OWNER');
        $this->firstName = Replace::replaceNullWithAlt($data['first_name'], '');
        $this->lastName = Replace::replaceNullWithAlt($data['last_name'], '');
        $this->isUserAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_user_anonymity_requested']);
        $this->businessName = Replace::replaceNullWithAlt($data['business_name'], '');
        $this->isBusinessAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_business_anonymity_requested']);
        $this->organizationName = Replace::replaceNullWithAlt($data['organization_name'], '');
        $this->isOrganizationAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_organization_anonymity_requested']);
        $this->zipcode = Replace::replaceNullWithAlt($data['zipcode'], '');
        $this->isZipcodeAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_zipcode_anonymity_requested']);
        $this->email = Replace::replaceNullWithAlt($data['email'], '');
        $this->isEmailAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_email_anonymity_requested']);
        $this->numFteUsEmployees = $data['num_fte_us_employees'];
        $this->NAICSCode = Replace::replaceNullWithAlt($data['NAICS_code'], '');;
        $this->userComments = Replace::replaceNullWithAlt($data['user_comments'], '');
        $this->suggestedAction = Replace::replaceNullWithAlt($data['suggested_action'], '');
        $this->complaintStatus = Replace::replaceNullWithAlt($data['complaint_status'], 'OPEN');
        $this->origin = Replace::replaceNullWithAlt($data['origin'], 'USER');
    }
}

