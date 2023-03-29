<?php
namespace Dotsquares\Favouriteseller\Block\Customergroup;

class Seller extends \Magento\Framework\View\Element\Html\Link\Current
{
    protected $_customerSession;

    protected $groupCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,
        \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $groupCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context, $defaultPath, $data);
    }

    protected function _toHtml()
    {    
        $responseHtml = null;
        if($this->_customerSession->isLoggedIn()) {
            $customerGroupCollection = $this->groupCollectionFactory->create()->addFieldToFilter('customer_group_code','Marketplace Seller');
            foreach($customerGroupCollection as $marketplaceCustomerGroup){
                $_marketplaceCustomerGroupId = $marketplaceCustomerGroup->getId();
            }
            $customerGroup = $this->_customerSession->getCustomer()->getGroupId();
            if($customerGroup == $_marketplaceCustomerGroupId) {
                $responseHtml = parent::_toHtml();
            } 
        }
        return $responseHtml;
    }
}