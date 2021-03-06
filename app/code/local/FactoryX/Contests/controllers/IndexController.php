<?php

/**
 * Class FactoryX_Contests_IndexController
 */
class FactoryX_Contests_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction() {
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setTitle('Contests');

        $this->renderLayout();
    }

    public function viewAction() {
        $this->loadLayout();

        if ($this->getLayout()->getBlock('contestForm')) {
            $this->getLayout()->getBlock('contestForm')->setFormAction(Mage::getUrl('*/*/post'));
        }

        try {
            // Load the contest
            $contestId = $this->getRequest()->getParam('id');
            $collection = Mage::getResourceModel('contests/contest_collection')
                ->addFieldToSelect(array('title','contest_id'))
                ->addFieldToFilter('contest_id', $contestId)
                ->setPageSize(1)
                ->setCurPage(1);

            if ($collection->getSize()) {
                $contest = $collection->getFirstItem();
                $contestTitle = $contest->getTitle();
            } else {
                throw new Exception('This contest does not exist');
            }

            // Ensure the contest is viewable in the store
            if (!Mage::app()->isSingleStoreMode()) {
                if (!$contest->isStoreViewable()) {
                    throw new Exception ('This contest is not available with this store');
                }
            }

            // Initiate the session messages
            $this->_initLayoutMessages('core/session');

            // Set meta title and description
            $this->getLayout()->getBlock('head')->setTitle($contestTitle);
            $this->getLayout()->getBlock('head')->setDescription($contestTitle);
        }
        catch (Exception $e) {
            Mage::helper('contests')->log($this->__('Exception caught in %s under % with message: %s', __FILE__, __FUNCTION__, $e->getMessage()));
            Mage::getSingleton('core/session')->addException($e, $this->__('There was a problem loading the contest'));
            $this->_redirectReferer();
            return;
        }

        $this->renderLayout();

    }

    public function termsAction()
    {
        $this->loadLayout();

        $this->renderLayout();
    }

    public function thankyouAction()
    {
        $this->loadLayout();

        $this->renderLayout();
    }

    public function postAction() {

        // Sender name & email
        $sender = Mage::helper('contests')->getSender();
        // Mage::helper('contests')->log(sprintf("%s->sender=%s", __METHOD__, print_r($sender, true)) );

        if (empty($sender['email'])) {
            Mage::helper('contests')->log("Contest Module: Sender email not recognised.");
            return;
        }
        if (empty($sender['name'])) {
            Mage::helper('contests')->log("Contest Module: Sender name not recognised.");
            return;
        }

        // Get the session
        //$session = Mage::getSingleton('core/session');
        $session = Mage::getSingleton('core/session', array("name"=>"frontend"));
        // $session = Mage::getSingleton("customer/session");
        // Mage::helper('contests')->log(sprintf("EncryptedSessionId=%s", $session->getEncryptedSessionId()) );

        // Get the POST data
        $post = $this->getRequest()->getPost();
        Mage::helper('contests')->log(sprintf("post:%s", print_r($post, true)) );
        $postObject = new Varien_Object();
        $postObject->setData($post);

        // Translation mode
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        try {
            // Contest ID
            $contestId = $this->getRequest()->getParam('contest_id');
            $contest = Mage::getModel('contests/contest')->load($contestId);

            // Avoid ghost competitions to be created
            Mage::helper('contests')->log(sprintf("%s->contestId=%s", __METHOD__, $contestId));
            if (!$contest->getIdentifier()) {
                Mage::throwException($this->__('An error has occured, please try again.'));
            }

            // Get data
            $name = $postObject['name'];
            $email = $postObject['email'];
            $mobile = $postObject['mobile'];
            $state = $postObject['state'];
            $terms = $postObject['terms'];
            $gender = $postObject['gender'];

            // Set session data
            if ($contest->getIsCompetition()) {
                $competition = $postObject['competition'];
            }
            else {
                $competition = null;
            }

            // Friends information added to session
            if ($contest->isReferAFriendContest()) {
                $friends = array();
                for ($i = 1; $i <= 10; $i++ ) {
                    $label = sprintf("friend%d", $i);
                    //Mage::helper('contests')->log(sprintf("%s->label=%s", __METHOD__, $label));
                    if (isset($postObject[$label]) && strlen(trim($postObject[$label])) > 0) {
                        $val = addslashes($postObject[$label]);
                        $friends[$label] = $val;
                    }
                }
            }

            // Captcha check
            $formId = "contests";
            $captchaModel = Mage::helper("captcha")->getCaptcha($formId);
            if ($captchaModel->isRequired()) {
                if (!$captchaModel->isCorrect($this->_getCaptchaString($this->getRequest(), $formId))) {
                    Mage::throwException($this->__('Incorrect CAPTCHA.'));
                }
            }

            // Terms and conditions check
            if ($terms != 'on') {
                Mage::throwException($this->__('You must agree to the terms and conditions before you enter this contest.'));
            }

            // Name check
            if (!Zend_Validate::is(trim($name) , 'NotEmpty')) {
                Mage::throwException($this->__('Please enter your full name'));
            }

            // Email address check
            if (!Zend_Validate::is(trim($email), 'EmailAddress')) {
                Mage::throwException($this->__('Please enter your email address'));
            }

            // Validate competition
            if ($contest->getIsCompetition() && !empty($competition)) {
                $validateComp = $this->_validateWordCount($competition, 'competition', 1, $contest->getMaximumWordCount());
                if ($validateComp !== true) {
                    Mage::throwException($validateComp);
                }
            }

            // Referrer check
            $referrer = Mage::getModel('contests/referrer')->loadByEmailAndContest($email, $contestId);

            if ($referrer->getEmail()) {
                if (!$contest->isAllowedDuplicateEntries()) {
                    Mage::throwException($this->__("This email address has already entered this contest: %s", $email));
                }
                else {
                    Mage::helper('contests')->log("duplicate entrant: %s",$email);
                }
            }

            // Friends information check
            if ($contest->isReferAFriendContest()) {
                $friends = array();
                for ( $c = 1; $c <= 10; $c++) {
                    $key = sprintf("friend%d", $c);
                    Mage::helper('contests')->log(sprintf("key: %s|%s", $key, $postObject[$key]));
                    //if (strcmp($postObject[$key],"") != 0) {
                    if (empty($postObject[$key])) {
                        continue;
                    }
                    $friend = $postObject[$key];
                    Mage::helper('contests')->log(sprintf("friend: %s", $friend));
                    if (!Zend_Validate::is(trim($friend), 'EmailAddress') ) {
                        $err = sprintf("You have entered an invalid email address for your friend '%s'", $friend);
                        Mage::helper('contests')->log(sprintf("err: %s", $err));
                        Mage::throwException($this->__($err));
                    }
                    else if ($email == $friend) {
                        $err = sprintf("You have entered the same email address for one of your friend '%s'", $friend);
                        Mage::helper('contests')->log(sprintf("err: %s", $err));
                        Mage::throwException($this->__($err));
                    }
                    else if (in_array($friend, $friends)) {
                        $err = sprintf("You have entered a duplicate email address for your friend '%s'", $friend);
                        Mage::helper('contests')->log(sprintf("err: %s", $err));
                        Mage::throwException($this->__($err));
                    }

                    // Now check if the subscriber already in the database
                    $referee = Mage::getModel('contests/referee')->loadByEmailAndContest($friend, $contestId);
                    if (!$contest->isAllowedDuplicateReferrals() && $referee->getId()) {
                        $err = sprintf("Sorry '%s' has already been referred.", $friend);
                        Mage::helper('contests')->log(sprintf("err: %s", $err));
                        Mage::throwException($this->__($err));
                    }
                    else {
                        array_push($friends, $friend);
                    }
                } // end foreach friend
                Mage::helper('contests')->log(sprintf("friends: %s", print_r($friends, true)) );
            }


            // Clean mobile
            $mobile = "";
            if ($postObject['mobile']) {
                $mobile = str_replace(" ", "", $postObject['mobile']);
            }
            Mage::helper('contests')->log(sprintf("Set up the referrer"));
            $referrer = Mage::getModel('contests/referrer')
                ->setContestId($contestId)
                ->setName($name)
                ->setEmail($email)
                ->setMobile($mobile)
                ->setState($state)
                ->setCompetition($competition)
                ->setGender($gender)
                ->save();
            Mage::helper('contests')->log(sprintf("referrer: %s", get_class($referrer)) );
            $sendFriendEmail = true;
            if ($contest->isReferAFriendContest() && $sendFriendEmail) {
                foreach ($friends as $friend) {
                    // note. $contest->getIdentifier() <> $contest->getId()
                    //Mage::helper('contests')->log(sprintf("create a link to referrer[%s->%s]: %s", $contest->getId(), $referrer->getId(), $friend) );
                    try {
                        // Create link to referrer
                        $newFriend = Mage::getModel('contests/referee')
                            ->setEmail($friend)
                            ->setContestId($contest->getId())
                            ->setReferrerId($referrer->getId())
                            ->save();
                        //Mage::helper('contests')->log(sprintf("_sendFriendEmail: %s", $friend) );
                        $this->_sendFriendEmail($contest, $name, $sender, $friend);
                        //Mage::helper('contests')->log(sprintf("ok") );
                    }
                    catch (Mage_Core_Exception $e) {
                        $err = sprintf("There was a problem with the contest subscription: %s", $e->getMessage());
                        Mage::helper('contests')->log($err);
                        $session->addException($e, $this->__($err));
                        $this->_redirectReferer();
                        return;
                    }
                    catch (Exception $e) {
                        $err = sprintf("There was a problem with the contest subscription: %s", $e->getMessage());
                        Mage::helper('contests')->log($err);
                        $session->addException($e, $this->__($err));
                        $this->_redirectReferer();
                        return;
                    }
                }
            }

            // Campaign Monitor information
            $name = trim($name);
            $firstname = $name;
            $lastname = "";
            $source = $contest->getIdentifier();

            if (preg_match("/\\s/", $name)) {
                $fname = explode(' ', $name, 2);
                $firstname = $fname[0];
                $lastname = $fname[1];
            }

            // Increase the new subscriber counter
            if (!is_null(Mage::helper('campaignmonitor/cm')->getCMStatus($postObject['email'])) && Mage::helper('campaignmonitor/cm')->getCMStatus($postObject['email']) != 2) {
                $newSubscriberCounter = $contest->getNewSubscriberCounter();
                $newSubscriberCounter++;
                $contest->setNewSubscriberCounter($newSubscriberCounter);
                $contest->save();
            }

            Mage::helper('contests')->subscribeToCampaignMonitor(
                array(
                    /*
                    "firstname"         => $firstname,
                    "lastname"          => $lastname,
                    */
                    "name"              => $name,
                    "email"             => $postObject['email'],
                    "mobile"            => $mobile,
                    "state"             => $state,
                    "title"             => $source,
                    "gender"            => $gender
                ),
                $contest->getCampaignmonitorList()
            );

            $translate->setTranslateInline(true);
            $session->addSuccess('Thank you for entering... good luck');

            // Now to send confirmation email
            if ($contest->getData('confirmation_email')) {
                $templateId = $contest->getData('confirmation_email_template_id');
                if (!$templateId || ($templateId == -1)) {
                    $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('contest_confirmation_template');
                }
                else {
                    $emailTemplate  = Mage::getModel('core/email_template')->load($templateId);
                }
                if ($emailSubject = $contest->getEmailSubject()) {
                    $emailTemplate->setTemplateSubject($emailSubject);
                }
                //Create an array of variables to assign to template
                $emailTemplateVariables = array();
                $emailTemplateVariables['contest_title'] = $contest->getData('title');
                $emailTemplateVariables['contest_referrer'] = $name;
                $emailTemplate->setSenderName($sender['name']);
                $emailTemplate->setSenderEmail($sender['email']);
                $emailTemplate->send($postObject['email'], $name, $emailTemplateVariables);
            }
        }
        catch (Exception $e) {
            $session->setFormData($post);
            $errorMessage = "";
            $errorMessage = $e->getMessage();
            Mage::helper('contests')->log("Error: " . $errorMessage);
            $translate->setTranslateInline(true);
            $session->addError($errorMessage);
            $this->_redirectReferer();
            return;
        }

        if ($redirectUrl = $contest->getThankYouRedirectUrl()) {
            $session->setThankYouRedirectUrl($redirectUrl);
        }
        else {
            $session->setThankYouRedirectUrl(Mage::helper('core/url')->getHomeUrl());
        }
        if ($thankYouImageUrl = $contest->getThankYouImageUrl()) {
            $session->setThankYouImageUrl($thankYouImageUrl);
        }
        //Mage::helper('contests')->log(sprintf("session: %s", print_r(Mage::getSingleton('core/session'), true)) );
        $this->_redirect('*/*/thankyou/');
        return;
    }

    /**
     * @param $field
     * @param $fieldname
     * @param $minlen
     * @param $maxlen
     * @return bool
     */
    protected function _validateWordCount($field, $fieldname, $minlen, $maxlen)
    {
        // calculation for counting in numbers
        $count = count(explode(' ',$field));

        if($count < $minlen )
        {
            return ($this->__("%s contains too few words (required:%s - %s) (current word count: %s)", $fieldname, $minlen, $maxlen, $count ) );
        }
        // Check maximum string length
        if($count > $maxlen )
        {
            return ($this->__("%s contains too many words (max:%s) (current word count: %s)", $fieldname, $maxlen, $count ) );
        }

        return true;
    }

    /**
     * @param $request
     * @param $formId
     * @return mixed
     */
    protected function _getCaptchaString($request, $formId) {
        $captchaParams = $request->getPost(Mage_Captcha_Helper_Data::INPUT_NAME_FIELD_VALUE);
        return $captchaParams[$formId];
    }

    /**
     * @param $contest
     * @param $name
     * @param $sender
     * @param $friendEmail
     */
    protected function _sendFriendEmail($contest, $name, $sender, $friendEmail)
    {
        // Email template
        $templateId = $contest->getEmailTemplateId() ? $contest->getEmailTemplateId() : Mage::helper('contests')->getTemplate();
        if (!is_numeric($templateId)) {
            Mage::helper('contests')->log("Contest Module: Template ID is not numeric.");
            return;
        }
        $templateId = intval($templateId);
        if (!$templateId || ($templateId == -1)) {
            $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('contests_options_template');
        }
        else {
            $emailTemplate  = Mage::getModel('core/email_template')->load($templateId);
        }
        if ($emailSubject = $contest->getRefereeEmailSubject()) {
            $emailTemplate->setTemplateSubject($emailSubject);
        }
        //Create an array of variables to assign to template
        $emailTemplateVariables = array();
        $emailTemplateVariables['referrer'] = $name;
        $emailTemplateVariables['contest_identifier'] = $contest->getIdentifier();
        $emailTemplateVariables['contest_identifier'] = sprintf("%s%s", Mage::getBaseUrl(), $contest->getIdentifier());
        $emailTemplateVariables['contest_url'] = sprintf("%s%s", Mage::getBaseUrl(), $contest->getIdentifier());
        // Convert to frontend
        $imageURL = Mage::getBaseUrl('media') . 'contest' . $contest->getEmailImageUrl();
        $emailTemplateVariables['contest_email_image'] = $imageURL;
        $emailTemplateVariables['contest_title'] = $contest->getTitle();
        $emailTemplate->setSenderName($sender['name']);
        $emailTemplate->setSenderEmail($sender['email']);
        $emailTemplate->send($friendEmail, "", $emailTemplateVariables);
    }

}