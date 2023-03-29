<?php

namespace Dotsquares\Productsinquiry\Helper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONTACT_GENRAL    = 'general';
    const CONTACT_SALES     = 'sales';
    const CONTACT_SUPPORT   = 'support';
    const CONTACT_CUSTOM1   = 'custom1';
    const CONTACT_CUSTOM2   = 'custom2';
    
    /**
     * An array list of valid contact types.
     * 
     * @var array
     */
    protected $_validContactTypes = array(
        self::CONTACT_GENRAL,
        self::CONTACT_SALES,
        self::CONTACT_SUPPORT,
        self::CONTACT_CUSTOM1,
        self::CONTACT_CUSTOM2,
    );
    /**
     * Admin configuration paths
     *
     */
    const IS_ENABLED            = 'products/general/enable';
    const BUTTON_LAVEL        	= 'products/general/tab_label';	
    const DISPLAY_FORM_TYPE     = 'products/general/select';	
    const SENDERMAIL_ID         = 'products/general/send_email_to';	
    const IS_ENABLE_G_CAPTCHA   = 'products/general/Google_reCaptcha';	
    const G_CAPTCHA_PRIVATE_KEY = 'products/general/private_key';
    const SENDER_GROUP_IDENTITY = 'products/general/identity';
    const EMAIL_TEMPLATE        = 'products/general/email_template';

   

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
 
    /**
     * Data constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
            
    }

    /**
     *  isEnabled
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::IS_ENABLED, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * ButtonLavel
     * tabname 
     * product page show button name for popup form
     */
    public function getButtonLavel()
    {
        return $this->scopeConfig->getValue(self::BUTTON_LAVEL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * FormType popup ot Tab
     */
    public function getFormType()
    {
        return $this->scopeConfig->getValue(self::DISPLAY_FORM_TYPE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Email Template ot Tab
     */
    public function getTemplate()
    {
        return $this->scopeConfig->getValue(self::EMAIL_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
     /**
     * admin emailId 
     * when user submit inquiry form get mail 
     */
    public function getSendermailId(){
        return $this->scopeConfig->getValue(self::SENDERMAIL_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Sender Identity
     * when user submit inquiry form get mail owner name
     */
    public function getSenderGroupIdentity(){
        return $this->scopeConfig->getValue(self::SENDER_GROUP_IDENTITY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
   
    /**
     *Is Google reCptcha enable in inquiry form
     */
    public function isreCptchaEnable(){
        return $this->scopeConfig->getValue(self::IS_ENABLE_G_CAPTCHA,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
     /**
     *Is Google reCptcha Private Key
     */
    public function getreCptchaPrivateKey(){
        return $this->scopeConfig->getValue(self::G_CAPTCHA_PRIVATE_KEY,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getPopTemplate(){
        $isenabled= $this->scopeConfig->getValue(self::IS_ENABLED,\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($isenabled){
            $template= 'Dotsquares_Productsinquiry::post_requirements.phtml';
        }
        return  $template;
    }
 
    /**
     * 
     * @param type $contactType
     * 
     * @return string
     */
    protected function _buildContactString($contactType)
    {
        return 'trans_email/ident_' . $contactType;
    }
    
    /**
     * Checks is the given contact type is valid according to the list above.
     * 
     * @param type $contactType
     * 
     * @return boolean
     */
    
    
    /**
     * Gets contact name by contact type.
     * 
     

     * 
     * @param type $contactType
     * 
     * @return string
     */
    public function getContatName($contactType)
    {
        
        
        return $this->_buildContactString($contactType) . '/name';
    }
    
    /**
     * Gets contact email by contact type.
     * 
     * Example Use: Mage::helper('henryahyes_contacts')->getContatEmail(HenryHayes_Contacts_Helper_Data::CONTACT_GENRAL);
     * Example Use: Mage::helper('henryahyes_contacts')->getContatEmail('general');
     * 
     * @param type $contactType
     * 
     * @return string
     */
    public function getContatEmail($contactType)
    {
        
        
        return $this->_buildContactString($contactType) . '/email';
    }
    
}
