<?php

namespace FormAlertBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sms_user")
 */
class SmsUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", length=255) */
    private $username;

    /** @ORM\Column(type="string", length=255, unique=true) */
    private $usernameCanonical;

    /** @ORM\Column(type="string", length=255, unique=true) */
    private $email;

    /** @ORM\Column(type="string", length=255, unique=true) */
    private $emailCanonical;

    /** @ORM\Column(type="boolean") */
    private $enabled;

    /** @ORM\Column(type="string", length=255) */
    private $salt;

    /** @ORM\Column(type="string", length=255) */
    private $password;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $lastLogin;

    /** @ORM\Column(type="boolean") */
    private $locked;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $expiresAt;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $confirmationToken;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $passwordRequestedAt;

    /** @ORM\Column(type="array") */
    private $roles;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $credentialsExpireAt;

    /** @ORM\Column(type="string", length=20, nullable=true) */
    private $firstname;

    /** @ORM\Column(type="string", length=20, nullable=true) */
    private $lastname;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $address;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $city;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $country;

    /** @ORM\Column(type="string", length=5, nullable=true) */
    private $zipcode;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $phone;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $company;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $passcodeMobyt;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $uidMobyt;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $pseudoMobyt;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $ip;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $siret;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $apiKey;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $codePhone;

    /** @ORM\Column(type="boolean") */
    private $isEnabledWithPhone;

    /** @ORM\Column(type="boolean") */
    private $isCgvAccepted;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $tva;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $urlResponseCallback;

    /** @ORM\Column(type="integer") */
    private $customerType;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $notifResponseTo;

    /** @ORM\Column(type="boolean", options={"default"=1}) */
    private $isBuyer;

    /** @ORM\Column(type="integer", nullable=true) */
    private $parentId;
    /** @ORM\Column(type="boolean", options={"default"=0}) */
    private $isApiParentDisplay;

    /** @ORM\Column(type="string", length=20) */
    private $smscId;

    /** @ORM\Column(type="datetime") */
    private $lastrequestsmsid_at;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $smscPass;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $smscPseudo;

    /** @ORM\Column(type="string", length=20, nullable=true) */
    private $smscIdLowcost;

    /** @ORM\Column(type="boolean", options={"default"=0}) */
    private $isMaxPaymentAuthorize;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $useParentPhone;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $useParentEmail;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $urlDlrCallback;

    /** @ORM\Column(type="integer") */
    private $createFrom;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $isModeDebug;

    /** @ORM\Column(type="string", length=3, nullable=true) */
    private $countryCode;

    /** @ORM\Column(type="boolean", options={"default"=1}) */
    private $forceStopLc;

    /** @ORM\Column(type="boolean", options={"default"=1}) */
    private $forceStopMarketing;

    /** @ORM\Column(type="integer", options= {"default"=0}) */
    private $typeSubaccount;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $toDelete;

    /** @ORM\Column(type="datetime") */
    private $deleteAt;

    /** @ORM\Column(type="string", length=11, nullable=true) */
    private $defaultSender;

    /** @ORM\Column(type="boolean") */
    private $isNewsAccepted;

    /** @ORM\Column(type="integer", options={"default"=500}) */
    private $maxBulkSend;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $emailConfirmationToken;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $hasViewPopup;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $isPostpayment;

    /** @ORM\Column(type="string", length=3, options={"default"="fr"}) */
    private $local;

    /** @ORM\Column(type="string", length=3000, nullable=true) */
    private $ips;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $hasIps;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $hasMail2smsMail;

    /** @ORM\Column(type="string", length=3000, nullable=true) */
    private $mail2smsMail;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $hasFlood;

    /** @ORM\Column(type="integer", options= {"default"=0}) */
    private $hasSaSameParams;

    /** @ORM\Column(type="integer", options= {"default"=0}) */
    private $vosfacturesId;

    /** @ORM\Column(type="boolean", options={"default"=1}) */
    private $stopManage;

    /** @ORM\Column(type="integer") */
    private $emailType;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $disableAntispamFilter;

    /** @ORM\Column(type="boolean", options= {"default"=0}) */
    private $twoFactorAuthentification;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $twoFactorCodeAt;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $fingerPrint;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $moduleIdent;

    /** @ORM\Column(type="integer", options={"default"=1}) */
    private $webhookVersion;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private $timeZone;

    /** @ORM\Column(type="string", length=5, nullable=true) */
    private $tag;

    /** @ORM\Column(type="integer", options= {"default"=0}) */
    private $priority;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $senderToAuthorized;

    /** @ORM\Column(type="integer") */
    private $hasExclude;

    /** @ORM\Column(type="string", length=700, nullable=true) */
    private $exclude;

    /** @ORM\Column(type="string", length=700, nullable=true) */
    private $include;

    /** @ORM\Column(type="integer") */
    private $routeType;

    /** @ORM\Column(type="boolean") */
    private $hasRouteLc;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $wordsToAuthorized;

    /** @ORM\Column(type="string", length=5000, nullable=true) */
    private $personnalisation;
    
    // Ajoutez ici les getters et setters pour chaque propriété.

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsernameCanonical() 
    {
        return $this->usernameCanonical;
    }

    public function setUsernameCanonical($usernameCanonical) 
    {
        $this->usernameCanonical = $usernameCanonical;
        return $this;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
        return $this;
    }

    public function getEmailCanonical() 
    {
        return $this->emailCanonical;
    }

    public function setEmailCanonical($emailCanonical) 
    {
        $this->emailCanonical = $emailCanonical;
        return $this;
    }

    public function isEnabled() 
    {
        return $this->enabled;
    }

    public function setEnabled($enabled) 
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function getSalt() 
    {
        return $this->salt;
    }

    public function setSalt( $salt) 
    {
        $this->salt = $salt;
        return $this;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    public function setPassword( $password) 
    {
        $this->password = $password;
        return $this;
    }



    public function isLocked() 
    {
        return $this->locked;
    }

    public function setLocked( $locked) 
    {
        $this->locked = $locked;
        return $this;
    }



    public function getPasswordRequestedAt() 
    {
        return $this->passwordRequestedAt;
    }

  
    public function getRoles() 
    {
        return $this->roles;
    }

    public function setRoles(array $roles) 
    {
        $this->roles = $roles;
        return $this;
    }

    public function getCredentialsExpireAt() 
    {
        return $this->credentialsExpireAt;
    }



    public function getFirstname() 
    {
        return $this->firstname;
    }

    public function setFirstname( $firstname) 
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname() 
    {
        return $this->lastname;
    }

    public function setLastname( $lastname) 
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getAddress() 
    {
        return $this->address;
    }

    public function setAddress( $address) 
    {
        $this->address = $address;
        return $this;
    }

    public function getCity() 
    {
        return $this->city;
    }

    public function setCity( $city) 
    {
        $this->city = $city;
        return $this;
    }

    public function getCountry() 
    {
        return $this->country;
    }

    public function setCountry( $country) 
    {
        $this->country = $country;
        return $this;
    }

    public function getZipcode() 
    {
        return $this->zipcode;
    }

    public function setZipcode( $zipcode) 
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function getPhone() 
    {
        return $this->phone;
    }

    public function setPhone( $phone) 
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCompany() 
    {
        return $this->company;
    }

    public function setCompany( $company) 
    {
        $this->company = $company;
        return $this;
    }

    public function getPasscodeMobyt() 
    {
        return $this->passcodeMobyt;
    }

    public function setPasscodeMobyt( $passcodeMobyt) 
    {
        $this->passcodeMobyt = $passcodeMobyt;
        return $this;
    }

    public function getUidMobyt() 
    {
        return $this->uidMobyt;
    }

    public function setUidMobyt( $uidMobyt) 
    {
        $this->uidMobyt = $uidMobyt;
        return $this;
    }

    public function getPseudoMobyt() 
    {
        return $this->pseudoMobyt;
    }

    public function setPseudoMobyt( $pseudoMobyt) 
    {
        $this->pseudoMobyt = $pseudoMobyt;
        return $this;
    }

    public function getIp() 
    {
        return $this->ip;
    }

    public function setIp( $ip) 
    {
        $this->ip = $ip;
        return $this;
    }

    public function getCreatedAt()  
    {
        return $this->createdAt;
    }

    public function setCreatedAt(  $createdAt) 
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getSiret() 
    {
        return $this->siret;
    }

    public function setSiret( $siret) 
    {
        $this->siret = $siret;
        return $this;
    }

    public function getApiKey() 
    {
        return $this->apiKey;
    }

    public function setApiKey( $apiKey) 
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getCodePhone() 
    {
        return $this->codePhone;
    }

    public function setCodePhone( $codePhone) 
    {
        $this->codePhone = $codePhone;
        return $this;
    }

    public function isEnabledWithPhone() 
    {
        return $this->isEnabledWithPhone;
    }

    public function setEnabledWithPhone( $isEnabledWithPhone) 
    {
        $this->isEnabledWithPhone = $isEnabledWithPhone;
        return $this;
    }

    public function isCgvAccepted() 
    {
        return $this->isCgvAccepted;
    }

    public function setCgvAccepted( $isCgvAccepted) 
    {
        $this->isCgvAccepted = $isCgvAccepted;
        return $this;
    }

    public function getTva() 
    {
        return $this->tva;
    }

    public function setTva( $tva) 
    {
        $this->tva = $tva;
        return $this;
    }

    public function getUrlResponseCallback() 
    {
        return $this->urlResponseCallback;
    }

    public function setUrlResponseCallback( $urlResponseCallback) 
    {
        $this->urlResponseCallback = $urlResponseCallback;
        return $this;
    }

    public function getCustomerType() 
    {
        return $this->customerType;
    }

    public function setCustomerType( $customerType) 
    {
        $this->customerType = $customerType;
        return $this;
    }

    public function getNotifResponseTo() 
    {
        return $this->notifResponseTo;
    }

    public function setNotifResponseTo( $notifResponseTo) 
    {
        $this->notifResponseTo = $notifResponseTo;
        return $this;
    }

    public function isBuyer() 
    {
        return $this->isBuyer;
    }

    public function setBuyer( $isBuyer) 
    {
        $this->isBuyer = $isBuyer;
        return $this;
    }

    public function getParentId() 
    {
        return $this->parentId;
    }

    public function setParentId(  $parentId) 
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function isApiParentDisplay() 
    {
        return $this->isApiParentDisplay;
    }

    public function setApiParentDisplay( $isApiParentDisplay) 
    {
        $this->isApiParentDisplay = $isApiParentDisplay;
        return $this;
    }

    public function getSmscId() 
    {
        return $this->smscId;
    }

    public function setSmscId( $smscId) 
    {
        $this->smscId = $smscId;
        return $this;
    }

    public function getLastrequestsmsid_at()  
    {
        return $this->lastrequestsmsid_at;
    }

    public function setLastrequestsmsid_at(  $lastrequestsmsid_at) 
    {
        $this->lastrequestsmsid_at = $lastrequestsmsid_at;
        return $this;
    }

    public function getSmscPass() 
    {
        return $this->smscPass;
    }

    public function setSmscPass( $smscPass) 
    {
        $this->smscPass = $smscPass;
        return $this;
    }

    public function getSmscPseudo() 
    {
        return $this->smscPseudo;
    }

    public function setSmscPseudo( $smscPseudo) 
    {
        $this->smscPseudo = $smscPseudo;
        return $this;
    }

    public function getSmscIdLowcost() 
    {
        return $this->smscIdLowcost;
    }

    public function setSmscIdLowcost( $smscIdLowcost) 
    {
        $this->smscIdLowcost = $smscIdLowcost;
        return $this;
    }

    public function isMaxPaymentAuthorize() 
    {
        return $this->isMaxPaymentAuthorize;
    }

    public function setMaxPaymentAuthorize( $isMaxPaymentAuthorize) 
    {
        $this->isMaxPaymentAuthorize = $isMaxPaymentAuthorize;
        return $this;
    }

    public function useParentPhone() 
    {
        return $this->useParentPhone;
    }

    public function setUseParentPhone( $useParentPhone) 
    {
        $this->useParentPhone = $useParentPhone;
        return $this;
    }

    public function useParentEmail() 
    {
        return $this->useParentEmail;
    }

    public function setUseParentEmail( $useParentEmail) 
    {
        $this->useParentEmail = $useParentEmail;
        return $this;
    }

    public function getUrlDlrCallback() 
    {
        return $this->urlDlrCallback;
    }

    public function setUrlDlrCallback( $urlDlrCallback) 
    {
        $this->urlDlrCallback = $urlDlrCallback;
        return $this;
    }

    public function getCreateFrom() 
    {
        return $this->createFrom;
    }

    public function setCreateFrom( $createFrom) 
    {
        $this->createFrom = $createFrom;
        return $this;
    }

    public function isModeDebug() 
    {
        return $this->isModeDebug;
    }

    public function setModeDebug( $isModeDebug) 
    {
        $this->isModeDebug = $isModeDebug;
        return $this;
    }

    public function getCountryCode() 
    {
        return $this->countryCode;
    }

    public function setCountryCode( $countryCode) 
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function isForceStopLc() 
    {
        return $this->forceStopLc;
    }

    public function setForceStopLc( $forceStopLc) 
    {
        $this->forceStopLc = $forceStopLc;
        return $this;
    }

    public function isForceStopMarketing() 
    {
        return $this->forceStopMarketing;
    }

    public function setForceStopMarketing( $forceStopMarketing) 
    {
        $this->forceStopMarketing = $forceStopMarketing;
        return $this;
    }

    public function getTypeSubaccount() 
    {
        return $this->typeSubaccount;
    }

    public function setTypeSubaccount( $typeSubaccount) 
    {
        $this->typeSubaccount = $typeSubaccount;
        return $this;
    }

    public function isToDelete() 
    {
        return $this->toDelete;
    }

    public function setToDelete( $toDelete) 
    {
        $this->toDelete = $toDelete;
        return $this;
    }

    public function getDeleteAt()  
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(  $deleteAt) 
    {
        $this->deleteAt = $deleteAt;
        return $this;
    }

    public function getDefaultSender() 
    {
        return $this->defaultSender;
    }

    public function setDefaultSender( $defaultSender) 
    {
        $this->defaultSender = $defaultSender;
        return $this;
    }

    public function isNewsAccepted() 
    {
        return $this->isNewsAccepted;
    }

    public function setNewsAccepted( $isNewsAccepted) 
    {
        $this->isNewsAccepted = $isNewsAccepted;
        return $this;
    }

    public function getMaxBulkSend() 
    {
        return $this->maxBulkSend;
    }

    public function setMaxBulkSend( $maxBulkSend) 
    {
        $this->maxBulkSend = $maxBulkSend;
        return $this;
    }

    public function getEmailConfirmationToken() 
    {
        return $this->emailConfirmationToken;
    }

    public function setEmailConfirmationToken( $emailConfirmationToken) 
    {
        $this->emailConfirmationToken = $emailConfirmationToken;
        return $this;
    }

    public function hasViewPopup() 
    {
        return $this->hasViewPopup;
    }

    public function setHasViewPopup( $hasViewPopup) 
    {
        $this->hasViewPopup = $hasViewPopup;
        return $this;
    }

    public function isPostpayment() 
    {
        return $this->isPostpayment;
    }

    public function setPostpayment( $isPostpayment) 
    {
        $this->isPostpayment = $isPostpayment;
        return $this;
    }

    public function getLocal() 
    {
        return $this->local;
    }

    public function setLocal( $local) 
    {
        $this->local = $local;
        return $this;
    }

    public function getIps() 
    {
        return $this->ips;
    }

    public function setIps( $ips) 
    {
        $this->ips = $ips;
        return $this;
    }

    public function hasIps() 
    {
        return $this->hasIps;
    }

    public function setHasIps( $hasIps) 
    {
        $this->hasIps = $hasIps;
        return $this;
    }

    public function hasMail2smsMail() 
    {
        return $this->hasMail2smsMail;
    }

    public function setHasMail2smsMail( $hasMail2smsMail) 
    {
        $this->hasMail2smsMail = $hasMail2smsMail;
        return $this;
    }

    public function getMail2smsMail() 
    {
        return $this->mail2smsMail;
    }

    public function setMail2smsMail( $mail2smsMail) 
    {
        $this->mail2smsMail = $mail2smsMail;
        return $this;
    }

    public function hasFlood() 
    {
        return $this->hasFlood;
    }

    public function setHasFlood( $hasFlood) 
    {
        $this->hasFlood = $hasFlood;
        return $this;
    }

    public function getHasSaSameParams() 
    {
        return $this->hasSaSameParams;
    }

    public function setHasSaSameParams( $hasSaSameParams) 
    {
        $this->hasSaSameParams = $hasSaSameParams;
        return $this;
    }

    public function getVosfacturesId() 
    {
        return $this->vosfacturesId;
    }

    public function setVosfacturesId( $vosfacturesId) 
    {
        $this->vosfacturesId = $vosfacturesId;
        return $this;
    }

    public function isStopManage() 
    {
        return $this->stopManage;
    }

    public function setStopManage( $stopManage) 
    {
        $this->stopManage = $stopManage;
        return $this;
    }

    public function getEmailType() 
    {
        return $this->emailType;
    }

    public function setEmailType( $emailType) 
    {
        $this->emailType = $emailType;
        return $this;
    }

    public function isDisableAntispamFilter() 
    {
        return $this->disableAntispamFilter;
    }

    public function setDisableAntispamFilter( $disableAntispamFilter) 
    {
        $this->disableAntispamFilter = $disableAntispamFilter;
        return $this;
    }

    public function isTwoFactorAuthentification() 
    {
        return $this->twoFactorAuthentification;
    }

    public function setTwoFactorAuthentification( $twoFactorAuthentification) 
    {
        $this->twoFactorAuthentification = $twoFactorAuthentification;
        return $this;
    }

    public function getTwoFactorCodeAt() 
    {
        return $this->twoFactorCodeAt;
    }

    public function setTwoFactorCodeAt(  $twoFactorCodeAt) 
    {
        $this->twoFactorCodeAt = $twoFactorCodeAt;
        return $this;
    }

    public function getFingerPrint() 
    {
        return $this->fingerPrint;
    }

    public function setFingerPrint( $fingerPrint) 
    {
        $this->fingerPrint = $fingerPrint;
        return $this;
    }

    public function getModuleIdent() 
    {
        return $this->moduleIdent;
    }

    public function setModuleIdent( $moduleIdent) 
    {
        $this->moduleIdent = $moduleIdent;
        return $this;
    }

    public function getWebhookVersion() 
    {
        return $this->webhookVersion;
    }

    public function setWebhookVersion( $webhookVersion) 
    {
        $this->webhookVersion = $webhookVersion;
        return $this;
    }

    public function getTimeZone() 
    {
        return $this->timeZone;
    }

    public function setTimeZone( $timeZone) 
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    public function getTag() 
    {
        return $this->tag;
    }

    public function setTag( $tag) 
    {
        $this->tag = $tag;
        return $this;
    }

    public function getPriority() 
    {
        return $this->priority;
    }

    public function setPriority( $priority) 
    {
        $this->priority = $priority;
        return $this;
    }

    public function getSenderToAuthorized() 
    {
        return $this->senderToAuthorized;
    }

    public function setSenderToAuthorized( $senderToAuthorized) 
    {
        $this->senderToAuthorized = $senderToAuthorized;
        return $this;
    }

    public function getHasExclude() 
    {
        return $this->hasExclude;
    }

    public function setHasExclude( $hasExclude) 
    {
        $this->hasExclude = $hasExclude;
        return $this;
    }

    public function getExclude() 
    {
        return $this->exclude;
    }

    public function setExclude( $exclude) 
    {
        $this->exclude = $exclude;
        return $this;
    }

    public function getInclude() 
    {
        return $this->include;
    }

    public function setInclude( $include) 
    {
        $this->include = $include;
        return $this;
    }

    public function getRouteType() 
    {
        return $this->routeType;
    }

    public function setRouteType( $routeType) 
    {
        $this->routeType = $routeType;
        return $this;
    }

    public function hasRouteLc() 
    {
        return $this->hasRouteLc;
    }

    public function setHasRouteLc( $hasRouteLc) 
    {
        $this->hasRouteLc = $hasRouteLc;
        return $this;
    }

    public function getWordsToAuthorized() 
    {
        return $this->wordsToAuthorized;
    }

    public function setWordsToAuthorized( $wordsToAuthorized) 
    {
        $this->wordsToAuthorized = $wordsToAuthorized;
        return $this;
    }

    public function getPersonnalisation() 
    {
        return $this->personnalisation;
    }

    public function setPersonnalisation( $personnalisation) 
    {
        $this->personnalisation = $personnalisation;
        return $this;
    }

   
}
