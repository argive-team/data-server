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
    /** @ORM\Id @ORM\GeneratedValue(strategy="AUTO") @ORM\Column(type="integer") */
    protected $id;
    
    /** @ORM\Column(name="is_reviewed", type="boolean", options={"default":0}) */
    protected $isReviewed;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cfr", fetch="EAGER")
     * @ORM\JoinColumn(name="cfr_id", referencedColumnName="id")
     */
    protected $cfr;
    
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

    public function getCfr()
    {
        return $this->cfr;
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

    public function setCfr($cfr)
    {
        $this->cfr = $cfr;
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
    
    public function exchangeData($data = array(), $entityManager)
    {
        $this->isReviewed = ($data['is_reviewed'] == null ? 0 : 1);
        $this->cfr = $data['cfr'];
        $this->federalRegisterId = $data['federal_register_id'];
        $this->stateCode = $data['stateCode'];
        $this->municipalCode = $data['municipalCode'];
        $this->statute = $data['statute'];
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
        
        $this->feedbacks->clear();
        if (!empty($data['feedback_key'])) {
            $codes = explode(',', $data['feedback_key']);
            foreach ($codes as $code) {
                // [TODO: Is there exception to catch if fail?]
                $feedback = $entityManager->find('Application\Entity\Feedback', $code);
                // [TODO: Log invalid code]
                if (!is_null($feedback)) {
                    $this->feedbacks->add($feedback);
                }
            }
        }
        
        $this->actions->clear();
        if (!empty($data['action_key'])) {
            $codes = explode(',', $data['action_key']);
            foreach ($codes as $code) {
                // [TODO: Is there exception to catch if fail?]
                $action = $entityManager->find('Application\Entity\Action', $code);
                // [TODO: Log invalid code]
                if (!is_null($action)) {
                    $this->actions->add($action);
                }
            }
        }
        
        $this->impactTags->clear();
        if (!empty($data['impact_key'])) {
            $tags = explode(',', $data['impact_key']);
            foreach ($tags as $tag) {
                // [TODO: Is there exception to catch if fail?]
                $impact = $entityManager->find('Application\Entity\ImpactTag', $tag);
                // [TODO: Log invalid impact key]
                if (!is_null($impact)) {
                    $this->impactTags->add($impact);
                }
            }
        }
        
        if (empty($data['impact_timing_key'])) {
            $this->impactTiming = null;
        } else {
            $impactTiming = $entityManager->find('Application\Entity\ImpactTiming', $data['impact_timing_key']);
            if (!is_null($impactTiming)) {
                $this->impactTiming = $impactTiming;
            }
        }
    }
    
    public function getCsvColumnHeader()
    {
        return array(
            'id', 'is_reviewed', 'review_type', 'cfr_id', 'federal_register_id', 'state_code_id', 'statute_id', 'comment_at', 'user_type', 'first_name', 'last_name',
            'is_user_anonymity_requested', 'business_name', 'is_business_anonymity_requested', 'organization_name', 'is_organization_anonymity_requested',
            'zipcode', 'is_zipcode_anonymity_requested', 'email', 'is_email_anonymity_requested', 'num_fte_us_employees', 'NAICS_code', 'user_comments',
            'suggested_action', 'complaint_status', 'origin', 'feedback_key', 'action_key'
        );
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
    
    public function getAsCsvArray()
    {
        return array(
            $this->id,
            $this->isReviewed,
            (is_null($this->cfr) ?  '' : $this->cfr->getId()),
            $this->federalRegisterId,
            (is_null($this->stateCode) ?  '' : $this->stateCode->getId()),
            (is_null($this->statute) ?  '' : $this->statute->getId()),
            $this->commentAt->format('Y-m-d H:i:s'),
            $this->userType,
            $this->firstName,
            $this->lastName,
            ($this->isUserAnonymityRequested ? 'Y' : 'N'),
            $this->businessName,
            ($this->isBusinessAnonymityRequested ? 'Y' : 'N'),
            $this->organizationName,
            ($this->isOrganizationAnonymityRequested ? 'Y' : 'N'),
            $this->zipcode,
            ($this->isZipcodeAnonymityRequested ? 'Y' : 'N'),
            $this->email,
            ($this->isEmailAnonymityRequested ? 'Y' : 'N'),
            $this->numFteUsEmployees,
            (is_null($this->naics) ? '' : $this->naics->getNAICSCode()),
            $this->userComments,
            $this->suggestedAction,
            $this->complaintStatus,
            $this->origin,
            (count($this->feedbacks) == 0 ? '' : $this->getFeedbacksAsDelimitedStr()),
            (count($this->actions) == 0 ? '' : $this->getActionsAsDelimitedStr()),
        );
    }
}
