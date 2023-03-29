<?php


namespace Dotsquares\Favouriteseller\Block\Sellergroup;


class Addfevseller extends \Magento\Framework\View\Element\Template
{

 protected $seller;
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
        \Dotsquares\Marketplace\Model\ResourceModel\Seller\CollectionFactory $seller
        
        
    ) {
        
        $this->session = $session;
        $this->seller = $seller;
        $this->_registry=$registry;
        parent::__construct($context);
    }

    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

    public function getPathUrl() {
        //$this keyword use to refer the current object in the class
        return $this->getBaseUrl().'favouriteseller/seller/save';
    }
  
   
    public function getCustomer() {
        //$this keyword use to refer the Customer data
        return $this->session->getCustomer();
    }
    public function getProduct()
    {
        //$this keyword use to refer the get cuurent product
        return $this->_registry->registry('current_product');
    }
    public function getAllsellerdatas() {
        
        // get values of current page
        $collection = $this->seller->create();
        // $collection->addAttributeToSelect('*');
           
        return $collection;
    }

}