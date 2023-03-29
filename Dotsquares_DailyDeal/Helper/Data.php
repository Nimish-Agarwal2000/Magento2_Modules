<?php

/**
 * Dotsquares_Brands Module Registration
 *
 * @category    Dotsquares
 * @package     Dotsquares_Brands
 * @author      Dotsquares Software Private Limited
 *
 */

namespace Dotsquares\DailyDeal\Helper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   
    /**
     * An array list of valid contact types.
     * 
     * @var array
     */
   
    /**
     * Admin configuration paths
     *
     */
    const DAILY_DEAL_ENABLE              = 'marketplace/dailydeal/dailydeal_enable';
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
 /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    protected $groupRepository;

    /**
     * Data constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->customerSession         = $customerSession;
        $this->groupRepository         = $groupRepository;
            
    }
    /**
     *  dailydeal module enable or disable
     */
    public function getDailyDealEnable()
    {
        return $this->scopeConfig->getValue(self::DAILY_DEAL_ENABLE, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    public function getCustomerId()
    {
        //return $this->httpContext->getValue('customer_id');
        return $this->customerSession->getCustomer()->getId(); 
    }
    public function getCustomerGroup(){
        if($this->customerSession->isLoggedIn()) {
            $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
            $group = $this->groupRepository->getById($customerGroupId);
            $groupCode = $group->getCode();
            return $groupCode;
        }
    }
  
 
}

