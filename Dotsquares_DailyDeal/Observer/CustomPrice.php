<?php
    /**
     * Webkul Hello CustomPrice Observer
     *
     * @category    Webkul
     * @package     Webkul_Hello
     * @author      Webkul Software Private Limited
     *
     */
    namespace Dotsquares\DailyDeal\Observer;

    use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\App\RequestInterface;

    class CustomPrice implements ObserverInterface
    {
        protected $subject;
        protected $pricehelper;
        protected $dateTimeFactory;
        protected $helper;

        public function __construct(
            \Magento\Catalog\Model\Product $subject,
            \Dotsquares\DailyDeal\Helper\Data $helper,
            \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        \Magento\Framework\Pricing\Helper\Data $pricehelper,
        array $data = []
        
        ) {
          
            $this->subject = $subject;
            $this->helper = $helper;
            $this->dateTimeFactory = $dateTimeFactory;
            $this->pricehelper = $pricehelper;
        }
        public function execute(\Magento\Framework\Event\Observer $observer) {
           if($this->helper->getDailyDealEnable()){

           
            $dealenable = $this->subject->getDailyDeal();
            $dealfrom = $this->subject->getDealFrom();
            $dealto = $this->subject->getDealTo();
            $dealtype = $this->subject->getDiscountType();
            $dateModel = $this->dateTimeFactory->create();
            $currenttime = $this->getCurrentGMTDateTime();
            $dealvalue = $this->subject->getDealValue();
        $dealtype = $this->subject->getDiscountType();
        $price = $this->subject->getPrice();
        if($dealtype == 'percentage'){
            $dealvalue = $price/100*$dealvalue; 

        }
            
           //set your price here
           if($dealenable == 1 && $dealfrom <= $currenttime && $currenttime <= $dealto && $dealvalue >= 1){
           
            $item = $observer->getEvent()->getData('quote_item');            
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
           //set your price here
            $item->setCustomPrice(round($dealvalue));
            $item->setOriginalCustomPrice(round($dealvalue));
            $item->getProduct()->setIsSuperMode(true);
           }
        }  
        }
        public function getCurrentGMTDateTime()
        {
            $dateModel = $this->dateTimeFactory->create();
            
            return $dateModel->gmtDate();
        }

    }