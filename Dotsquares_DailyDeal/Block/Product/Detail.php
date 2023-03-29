<?php


namespace Dotsquares\DailyDeal\Block\Product;


class Detail extends \Magento\Framework\View\Element\Template
{

 protected $seller;
 protected $session;
 protected $_registry;
 protected $_currency;
 protected $dateTimeFactory;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $session,
        \Magento\Directory\Model\Currency $currency,
        // \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        \Dotsquares\Marketplace\Model\ResourceModel\Seller\CollectionFactory $seller,
        \Magento\Backend\Block\Template\Context $context,       
      
        array $data = []
        
    ) {
        $this->dateTimeFactory = $dateTimeFactory;
        $this->session = $session;
        $this->_currency = $currency;
        $this->seller = $seller;
        $this->_registry=$registry;
        parent::__construct($context);
    }
    


    public function getCurrentProduct()
    {        
        return $this->_registry->registry('current_product');
    }    
    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

    public function getCurrentGMTDateTime()
    {
        $dateModel = $this->dateTimeFactory->create();
        return $dateModel->gmtDate();
    }
     /**
     * Get Current symbol
     * @retun void
     */
    public function getCurrencySymbol() {
        return $this->_currency->getCurrencySymbol ();
    }
}

 
      

