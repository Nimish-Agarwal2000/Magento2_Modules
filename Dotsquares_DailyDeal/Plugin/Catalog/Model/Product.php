<?php
/**
 * Vendor Desc.
 * php version 7.3.*
 *
 * @category  Vendor
 * @package   Vendor_CustomModule
 * @author    Vendor
 * @copyright Vendor (https://example.com)
 * @license   https://example.com/license.html
 */
namespace Dotsquares\DailyDeal\Plugin\Catalog\Model;
 
class Product
{
protected $pricehelper;
protected $dateTimeFactory;
protected $helper;
protected $subjec;


    public function __construct(\Dotsquares\DailyDeal\Helper\Data $helper,
        
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        \Magento\Catalog\Model\Product $subjec,
        \Magento\Framework\Pricing\Helper\Data $pricehelper,
        array $data = []
    ) {
        $this->dateTimeFactory = $dateTimeFactory;
        $this->helper = $helper;
        $this->subjec = $subjec;
        $this->pricehelper = $pricehelper;
        
    }
    public function getCurrentGMTDateTime()
    {
        $dateModel = $this->dateTimeFactory->create();
        
        return $dateModel->gmtDate();
    }
    /**
     * Get product's special price
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param float $result
     *
     * @return float
     */
   

  public function afterGetSpecialPrice(\Magento\Catalog\Model\Product $subject, $result)

  { 
    
        if($this->helper->getDailyDealEnable()){
        $dealvalue = $subject->getDealValue();
        $dealenable = $subject->getDailyDeal();
        $dealfrom = $subject->getDealFrom();
        $dealto = $subject->getDealTo();
        $dealtype = $subject->getDiscountType();
        $dateModel = $this->dateTimeFactory->create();
        $currenttime = $this->getCurrentGMTDateTime();
        $price = $subject->getPrice();
        if($dealtype == 'percentage'){
            $dealvalue = (int)$price/100*(int)$dealvalue; 

        }
        if($dealenable == 1 && $dealfrom <= $currenttime && $currenttime <= $dealto && $dealvalue >= 1){
            $prices = round($dealvalue);
            return $prices;
            //special must be less than product price otherwise it will display the product price
    }else{
        return $result ;
    }

}
   return $result ;
  }



}