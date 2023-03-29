<?php


namespace Dotsquares\Favouriteseller\Block\Sellergroup;


class Email extends \Magento\Framework\View\Element\Template
{

 protected $customer;
 protected $session;
 protected $_registry;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\View\Element\Template\Context $context,
        \Dotsquares\Favouriteseller\Model\ResourceModel\Details\CollectionFactory $customer
        
        
    ) {
        
        $this->session = $session;
        $this->customer = $customer;
        $this->_registry=$registry;
        parent::__construct($context);
    }

    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

    public function getPathUrl() {
        //$this keyword use to refer the current object in the class
        return $this->getBaseUrl().'favouriteseller/seller/email';
    }
  
   
  
    public function getProduct()
    {
        //$this keyword use to refer the get cuurent product
        return $this->_registry->registry('current_product');
    }
    public function getCustomer() {
        
        // get values of current page
        $collection = $this->customer->create();
        // $collection->addAttributeToSelect('*');
           
        return $collection;
    }

}