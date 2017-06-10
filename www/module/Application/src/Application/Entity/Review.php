<?php
namespace Application\Entity;

use Application\Utilility\Replace;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_REVIEW",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}
 *      )
 */
class Review
{
    const ANONYMITY_PRIVATE_STRING = "PRIVATE";
    
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(name="is_reviewed", type="boolean", options={"default":0}) */
    protected $isReviewed;
    
    /**
     * @ORM\ManyToMany(targetEntity="Cfr", fetch="EAGER")
     * @ORM\JoinTable(name="T_REVIEW_has_T_CFR",
     *      joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="cfr_id", referencedColumnName="id")}
     *      )
     */
    protected $cfrs;
    
    /** @ORM\Column(name="federal_register_id", type="integer", nullable=true) */
    protected $federalRegisterId;
    
    /**
     * @ORM\ManyToOne(targetEntity="StateCode", fetch="EAGER")
     * @ORM\JoinColumn(name="state_code_id", referencedColumnName="id")
     */
    protected $stateCode;
    
    /**
     * @ORM\ManyToOne(targetEntity="MunicipalCode", fetch="EAGER")
     * @ORM\JoinColumn(name="municipal_code_id", referencedColumnName="id")
     */
    protected $municipalCode;
    
    /**
     * @ORM\ManyToOne(targetEntity="Statute", fetch="EAGER")
     * @ORM\JoinColumn(name="statute_id", referencedColumnName="id")
     */
    protected $statute;
    
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
    
    /** 
     * @ORM\ManyToOne(targetEntity="Naics")
     * @ORM\JoinColumn(name="NAICS_code", referencedColumnName="NAICS_code")
     */
    protected $naics;
    
    /** @ORM\Column(name="user_comments", length=4000) */
    protected $userComments;
    
    /** @ORM\Column(name="suggested_action", length=2048) */
    protected $suggestedAction;
    
    /** @ORM\Column(name="complaint_status", length=8, options={"default":"OPEN"}) */
    protected $complaintStatus;
    
    /** @ORM\Column(length=255, options={"default":"USER"}) */
    protected $origin;
    
    /**
     * @ORM\ManyToMany(targetEntity="Feedback", fetch="EAGER")
     * @ORM\JoinTable(name="T_REVIEW_has_T_FEEDBACK_CD",
     *      joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="feedback_key", referencedColumnName="feedback_key")}
     *      )
     */
    protected $feedbacks;
    
    /**
     * @ORM\ManyToMany(targetEntity="Action", fetch="EAGER")
     * @ORM\JoinTable(name="T_REVIEW_has_T_ACTION_CD",
     *      joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="action_key", referencedColumnName="action_key")}
     *      )
     */
    protected $actions;
    
    /**
     * @ORM\ManyToMany(targetEntity="ImpactTag", fetch="EAGER")
     * @ORM\JoinTable(name="T_REVIEW_has_T_IMPACT_TAG",
     *      joinColumns={@ORM\JoinColumn(name="review_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="impact_key", referencedColumnName="impact_key")}
     *      )
     */
    protected $impactTags;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImpactTiming")
     * @ORM\JoinColumn(name="impact_timing_key", referencedColumnName="impact_timing_key")
     */
    protected $impactTiming;
    
    public function __construct()
    {
        date_default_timezone_set('UTC');
        
        $this->cfrs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feedbacks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->impactTags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getIsReviewed()
    {
        return $this->isReviewed;
    }

    public function getCfrs()
    {
        return $this->cfrs;
    }

    public function getFederalRegisterId()
    {
        return $this->federalRegisterId;
    }

    public function getStateCode()
    {
        return $this->stateCode;
    }

    public function getMunicipalCode()
    {
        return $this->municipalCode;
    }

    public function getStatute()
    {
        return $this->statute;
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
        if (!empty($this->firstName)) {
            if ($this->getIsUserAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->firstName;
            }
        }
        
        return $this->firstName;
    }

    public function getLastName()
    {
        if (!empty($this->lastName)) {
            if ($this->getIsUserAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->lastName;
            }
        }
        
        return $this->lastName;
    }

    public function getIsUserAnonymityRequested()
    {
        return $this->isUserAnonymityRequested;
    }

    public function getBusinessName()
    {
        if (!empty($this->businessName)) {
            if ($this->getIsBusinessAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->businessName;
            }
        }
        
        return $this->businessName;
    }

    public function getIsBusinessAnonymityRequested()
    {
        return $this->isBusinessAnonymityRequested;
    }

    public function getOrganizationName()
    {
        if (!empty($this->organizationName)) {
            if ($this->getIsOrganizationAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->organizationName;
            }
        }
        
        return $this->organizationName;
    }

    public function getIsOrganizationAnonymityRequested()
    {
        return $this->isOrganizationAnonymityRequested;
    }

    public function getZipcode()
    {
        if (!empty($this->zipcode)) {
            if ($this->getIsZipcodeAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->zipcode;
            }
        }
        
        return $this->zipcode;
    }

    public function getIsZipcodeAnonymityRequested()
    {
        return $this->isZipcodeAnonymityRequested;
    }

    public function getEmail()
    {
        if (!empty($this->email)) {
            if ($this->getIsEmailAnonymityRequested()) {
                return self::ANONYMITY_PRIVATE_STRING;
            } else {
                return $this->email;
            }
        }
        
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

    public function getNaics()
    {
        return $this->naics;
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

    public function getFeedbacks()
    {
        return $this->feedbacks;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function getImpactTags()
    {
        return $this->impactTags;
    }

    public function getImpactTiming()
    {
        return $this->impactTiming;
    }
    
    public function setIsReviewed($isReviewed)
    {
        $this->isReviewed = $isReviewed;
    }

    public function setCfrs($cfrs)
    {
        $this->cfrs = $cfrs;
    }

    public function setFederalRegisterId($federalRegisterId)
    {
        $this->federalRegisterId = $federalRegisterId;
    }

    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;
    }

    public function setMunicipalCode($municipalCode)
    {
        $this->municipalCode = $municipalCode;
    }

    public function setStatute($statute)
    {
        $this->statute = $statute;
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

    public function setNaics($naics)
    {
        $this->naics = $naics;
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

    public function setFeedbacks($feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }

    public function setActions($actions)
    {
        $this->actions = $actions;
    }

    public function setImpactTags($impactTags)
    {
        $this->impactTags = $impactTags;
    }

    public function setImpactTiming($impactTiming)
    {
        $this->impactTiming = $impactTiming;
    }
    
    private function isPrivateData($value)
    {
        $data = strtolower(trim($value));
        
        if ($data == strtolower(self::ANONYMITY_PRIVATE_STRING)) {
            return true;
        }
        
        return false;
    }
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->isReviewed = ($data['is_reviewed'] == null ? 0 : 1);
        $this->cfrs = $data['cfrs'];
        $this->federalRegisterId = $data['federal_register_id'];
        $this->stateCode = $data['stateCode'];
        $this->municipalCode = $data['municipalCode'];
        $this->statute = $data['statute'];
        $this->commentAt = Replace::replaceNullWithAlt(\DateTime::createFromFormat('Y-m-d H:i:s', $data['comment_at']), new \DateTime());
        $this->userType = Replace::replaceNullWithAlt($data['user_type'], 'BUSINESS_OWNER');
        
        if ($data['first_name'] == null) {
            $this->firstName = '';
        } else if (!$this->isPrivateData($data['first_name'])) {
            $this->firstName = $data['first_name'];
        }
        if ($data['last_name'] == null) {
            $this->lastName= '';
        } else if (!$this->isPrivateData($data['last_name'])) {
            $this->lastName= $data['last_name'];
        }
        $this->isUserAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_user_anonymity_requested']);
        
        if ($data['business_name'] == null) {
            $this->businessName= '';
        } else if (!$this->isPrivateData($data['business_name'])) {
            $this->businessName= $data['business_name'];
        }
        $this->isBusinessAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_business_anonymity_requested']);
        
        if ($data['organization_name'] == null) {
            $this->organizationName= '';
        } else if (!$this->isPrivateData($data['organization_name'])) {
            $this->organizationName= $data['organization_name'];
        }
        $this->isOrganizationAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_organization_anonymity_requested']);
        
        if ($data['zipcode'] == null) {
            $this->zipcode= '';
        } else if (!$this->isPrivateData($data['zipcode'])) {
            $this->zipcode= $data['zipcode'];
        }
        $this->isZipcodeAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_zipcode_anonymity_requested']);
        
        if ($data['email'] == null) {
            $this->email= '';
        } else if (!$this->isPrivateData($data['email'])) {
            $this->email= $data['email'];
        }
        $this->isEmailAnonymityRequested = Replace::replaceEmptyAnonymity($data['is_email_anonymity_requested']);
        
        $this->numFteUsEmployees = $data['num_fte_us_employees'];
        
        if (empty($data['NAICS_code'])) {
            $this->naics = null;
        } else {
            $naics = $entityManager->find('Application\Entity\Naics', $data['NAICS_code']);
            if (!is_null($naics)) {
                $this->naics = $naics;
            }
        }
        
        $this->userComments = Replace::replaceNullWithAlt($data['user_comments'], '');
        $this->suggestedAction = Replace::replaceNullWithAlt($data['suggested_action'], '');
        $this->complaintStatus = Replace::replaceNullWithAlt($data['complaint_status'], 'OPEN');
        $this->origin = Replace::replaceNullWithAlt($data['origin'], 'USER');
        $this->feedbacks = $data['feedbacks'];
        $this->actions = $data['actions'];
        $this->impactTags = $data['impactTags'];
        
        if (empty($data['impact_timing_key'])) {
            $this->impactTiming = null;
        } else {
            $impactTiming = $entityManager->find('Application\Entity\ImpactTiming', $data['impact_timing_key']);
            if (!is_null($impactTiming)) {
                $this->impactTiming = $impactTiming;
            }
        }
    }
    
    public function getCsvColumnPlainHeader()
    {
        return array(
            'Argive Reviewed and Approved?',
            'Review Comment ID',
            'User Type',
            'First Name',
            'Last Name',
            'Name anonymity requested?',
            'Business Name',
            'Company name anonymity requested?',
            'Organization Name',
            'Organization Name Anonymity',
            'Zip Code',
            'Hide zip code?',
            'Email',
            'Email Anonymity',
            '# of FTE US Employees',
            'Timestamp (when was comment entered?)',
            'NAICS_max',
            'Submittor Comments (Free Text)',
            'Suggested Action (Free text)',
            'Origin',
            'Federal Register ID',
            'State Code ID',
            'Statute ID',
            'Municipal Code ID',
            'CFR Id\'s',
            'Feedback Tags',
            'Action Tags',
            'Impact Timing',
            'Impact Tags'
            /*,
            'Argive Comments',
            'Agency Response (free text)',
            'Statute ID',
            'Jurisdiction',
            'State (if applicable)',
            'Associated Statute',
            'Associated Statute: Description',
            'CFR Id',
            'Type: Discretionary',
            'Title (CFR)',
            'Part (CFR)',
            'Code Link Federal register notices are ideal',
            'Regulatory Code Description',
            'Subpart (CFR)',
            'State Code ID',
            'State (if applicable)',
            'State: Title',
            'State: Division',
            'State: Chapter',
            'State: Part',
            'State: Article',
            'State: Section',
            'Municipal Code Id',
            'Municipal Code',
            'Municipal State',
            'Municipality' */
        );
    }
    
    public function getCsvColumnHeader()
    {
        return array(
            'T_REVIEW.is_reviewed',
            'T_REVIEW.id',
            'T_REVIEW.user_type',
            'T_REVIEW.first_name',
            'T_REVIEW.last_name',
            'T_REVIEW.is_user_anonymity_requested',
            'T_REVIEW.business_name',
            'T_REVIEW.is_business_anonymity_requested',
            'T_REVIEW.organization_name',
            'T_REVIEW.is_organization_anonymity_requested',
            'T_REVIEW.zipcode',
            'T_REVIEW.is_zipcode_anonymity_requested',
            'T_REVIEW.email',
            'T_REVIEW.is_email_anonymity_requested',
            'T_REVIEW.num_fte_us_employees',
            'T_REVIEW.comment_at',
            'T_REVIEW.NAICS_code',
            'T_REVIEW.user_comments',
            'T_REVIEW.suggested_action',
            'T_REVIEW.origin',
            'T_REVIEW.federal_register_id',
            'T_REVIEW.state_code_id',
            'T_REVIEW.statute_id',
            'T_REVIEW.municipal_code_id',
            'T_REVIEW_has_T_CFR.cfr_id',
            'T_REVIEW_has_T_FEEDBACK_CD.feedback_key',
            'T_REVIEW_has_T_ACTION_CD.action_key',
            'T_REVIEW.impact_timing_key',
            'T_REVIEW_has_T_IMPACT_TAG.impact_key'
            /*,
            'T_REVIEW_COMMENT.user_name=argive',
            'T_REVIEW_COMMENT.user_name=agency_response',
            'T_STATUTE.id',
            'T_STATUTE.statute_jurisdiction',
            'T_STATUTE.state',
            'T_STATUTE.statute',
            'T_STATUTE.statute_description',
            'T_CFR.id',
            'T_CFR.discretionary_type',
            'T_CFR.cfr_title',
            'T_CFR.cfr_part',
            'T_CFR.code_link',
            'T_CFR.regulatory_code_description',
            'T_CFR.subpart',
            'T_STATE_CODE.id',
            'T_STATE_CODE.state',
            'T_STATE_CODE.title',
            'T_STATE_CODE.division',
            'T_STATE_CODE.chapter',
            'T_STATE_CODE.part',
            'T_STATE_CODE.article',
            'T_STATE_CODE.section',
            'T_MUNICIPAL_CODE.id',
            'T_MUNICIPAL_CODE.title',
            'T_MUNICIPAL_CODE.state',
            'T_MUNICIPAL_CODE.municipality' */
        );
    }
    
    private function getCfrsAsDelimitedStr()
    {
        $result = '';
        
        foreach ($this->cfrs as $cfr) {
            $result .= $cfr->getId() . ',';
        }
        
        return rtrim($result, ',');
    }
    
    private function getFeedbacksAsDelimitedStr()
    {
        $result = '';
        
        foreach ($this->feedbacks as $feedback) {
            $result .= $feedback->getFeedbackKey() . ',';
        }
        
        return rtrim($result, ',');
    }
    
    private function getActionsAsDelimitedStr()
    {
        $result = '';
        
        foreach ($this->actions as $action) {
            $result .= $action->getActionKey() . ',';
        }
        
        return rtrim($result, ',');
    }
    
    private function getImpactTagsAsDelimitedStr()
    {
        $result = '';
        
        foreach ($this->impactTags as $tag) {
            $result .= $tag->getImpactKey() . ',';
        }
        
        return rtrim($result, ',');
    }
    
    public function getAsCsvArray()
    {
        return array(
            $this->isReviewed,
            $this->id,
            $this->userType,
            $this->getFirstName(),
            $this->getLastName(),
            ($this->isUserAnonymityRequested ? 'Y' : 'N'),
            $this->getBusinessName(),
            ($this->isBusinessAnonymityRequested ? 'Y' : 'N'),
            $this->getOrganizationName(),
            ($this->isOrganizationAnonymityRequested ? 'Y' : 'N'),
            $this->getZipcode(),
            ($this->isZipcodeAnonymityRequested ? 'Y' : 'N'),
            $this->getEmail(),
            ($this->isEmailAnonymityRequested ? 'Y' : 'N'),
            $this->numFteUsEmployees,
            $this->commentAt->format('Y-m-d H:i:s'),
            (is_null($this->naics) ? '' : $this->naics->getNAICSCode()),
            $this->userComments,
            $this->suggestedAction,
            $this->origin,
            $this->federalRegisterId,
            (is_null($this->stateCode) ?  '' : $this->stateCode->getId()),
            (is_null($this->statute) ?  '' : $this->statute->getId()),
            (is_null($this->municipalCode) ?  '' : $this->municipalCode->getId()),
            (count($this->cfrs) > 0 ?  $this->getCfrsAsDelimitedStr() : ''),
            (count($this->feedbacks) == 0 ? '' : $this->getFeedbacksAsDelimitedStr()),
            (count($this->actions) == 0 ? '' : $this->getActionsAsDelimitedStr()),
            (is_null($this->impactTiming) ?  '' : $this->impactTiming->getImpactTimingKey()),
            (count($this->impactTags) == 0 ? '' : $this->getImpactTagsAsDelimitedStr()),
            
            /*,
            'T_REVIEW_COMMENT.user_name=argive',
            'T_REVIEW_COMMENT.user_name=agency_response',
            (is_null($this->statute) ?  '' : $this->statute->getId()),
            (is_null($this->statute) ?  '' : $this->statute->getStatuteJurisdiction()),
            (is_null($this->statute) ?  '' : $this->statute->getState()),
            (is_null($this->statute) ?  '' : $this->statute->getStatute()),
            (is_null($this->statute) ?  '' : $this->statute->getStatuteDescription()),
            (is_null($this->cfr) ?  '' : $this->cfr->getId()),
            (is_null($this->cfr) ?  '' : $this->cfr->getDiscretionaryType()),
            (is_null($this->cfr) ?  '' : $this->cfr->getCfrTitle()),
            (is_null($this->cfr) ?  '' : $this->cfr->getCfrPart()),
            (is_null($this->cfr) ?  '' : $this->cfr->getCodeLink()),
            (is_null($this->cfr) ?  '' : $this->cfr->getRegulatoryCodeDescription()),
            (is_null($this->cfr) ?  '' : $this->cfr->getSubpart()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getId()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getState()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getTitle()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getDivision()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getChapter()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getPart()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getArticle()),
            (is_null($this->stateCode) ?  '' : $this->stateCode->getSection()),
            (is_null($this->municipalCode) ?  '' : $this->municipalCode->getId()),
            (is_null($this->municipalCode) ?  '' : $this->municipalCode->getTitle()),
            (is_null($this->municipalCode) ?  '' : $this->municipalCode->getState()),
            (is_null($this->municipalCode) ?  '' : $this->municipalCode->getMunicipality()) */
        );
    }
}
