<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Block\Product;

class TopDeal extends \Magento\Framework\View\Element\Template {

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    protected $_productCollectionFactory;
    protected $block;
    protected $_registry;

    protected $dateTimeFactory;
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory     
     */
   
    public function __construct(
       
        \Magento\Framework\Registry $registry,
        \Magento\CatalogWidget\Block\Product\ProductsList $block,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        array $data = []
        
    ) {
        
        $this->dateTimeFactory = $dateTimeFactory;
        $this->block = $block;
        $this->_registry=$registry;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }
   
    public function getproduct(){
        return $this->block;
    }
   


public function getProductCollection()
{
    $i=0;
    $currenttime = $this->getCurrentGMTDateTime();
    $collection = $this->collectionFactory->create();
    $collection->addAttributeToSelect('*');
    $collection->addFieldToFilter('entity_id',$this->getProducIds());
   
    return $collection;
    
}  
public function getProducIds()
{


    $discount =[''];
    $currenttime = $this->getCurrentGMTDateTime();
    $collection = $this->collectionFactory->create();
    $collection->addAttributeToSelect('*');
    // $collection->addAttributeToFilter('daily_deal',[1]);
    $collection->addAttributeToFilter ('daily_deal',['eq'=> 1]); 
    $collection->addFieldToFilter('deal_from', array('lteq' => $currenttime));
$collection->addFieldToFilter('deal_to', array('gteq' => $currenttime)); 
$collection->addFieldToFilter('deal_value', array('gteq' => 1)); 


foreach ($collection as $item){
    if($item->getDiscountType()=='fixed'){
        $value = $item->getDealValue();
        $discount[$item->getId()] =100 - $item->getDealValue()/(int)$item->getPrice()*100;
    }else{
        $discount[$item->getId()] = 100 - $item->getDealValue();
    }
  }    
  $productIdss = implode(array_keys($discount, max($discount)));
    return $productIdss;
    
}  
public function getCurrentGMTDateTime()
{
    $dateModel = $this->dateTimeFactory->create();
    return $dateModel->gmtDate();
}
  
}
    
