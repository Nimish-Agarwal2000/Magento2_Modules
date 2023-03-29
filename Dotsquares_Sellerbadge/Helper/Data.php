<?php
namespace Dotsquares\Sellerbadge\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    CONST FEV_ENABLE ='marketplace/favseller/fevseller_approval';    
    CONST BEDGE_ENABLE ='marketplace/seller_badge/enable_badge'; 
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
   
    protected $groupRepository;
    protected $_request;
    

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository      
    ) {
        $this->scopeConfig             = $context->getScopeConfig();
        $this->request                 = $context->getRequest();
        $this->storeManager            = $storeManager;
        $this->customerSession         = $customerSession;
        $this->groupRepository         = $groupRepository;
        $this->_request                = $request;
        parent::__construct($context);
    }
    public function getCustomerGroup(){
        if($this->customerSession->isLoggedIn()) {
            $customerGroupId = $this->customerSession->getCustomer()->getGroupId();
            $group = $this->groupRepository->getById($customerGroupId);
            $groupCode = $group->getCode();
            return $groupCode;
        }
    }
    public function getCustomerId()
    {
        //return $this->httpContext->getValue('customer_id');
        return $this->customerSession->getCustomer()->getId(); 
    }
    public function getTemplate()
    {
        
        if ($this->scopeConfig->isSetFlag('marketplace/favseller/fevseller_approval')) {
            $template =  'Dotsquares_Favouriteseller::seller/sellerprofile.phtml';
        }elseif ($this->scopeConfig->isSetFlag('marketplace/seller_badge/enable_badge')){
            $template =  'Dotsquares_Sellerbadge::seller/sellerprofile.phtml';
        }        
        else {
            $template = 'Dotsquares_Marketplace::seller/displayseller.phtml';
        }

        return $template;
    }
    public function isFavouritesellermoduleEnable(){

         return $this->scopeConfig->getValue(self::FEV_ENABLE, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
    }
    public function isSelleBadgermoduleEnable(){

        return $this->scopeConfig->getValue(self::BEDGE_ENABLE, 
           \Magento\Store\Model\ScopeInterface::SCOPE_STORE );
   }
    
}
