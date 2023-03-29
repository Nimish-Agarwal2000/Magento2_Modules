<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Block\Widget;

use Magento\Backend\Model\UrlInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface; 
use Magento\Customer\Model\Session;

use Magento\Store\Model\StoreManagerInterface;

class Upcomingdeal extends Template implements BlockInterface {

	protected $_template = "widget/upcomigdeal.phtml";
	



    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    protected $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\AttributeSet\Options
     */
    protected $options;

    /**
     * @var \Magento\Eav\Api\AttributeManagementInterface
     */
    protected $attributeManagement;
    protected$_scopeConfig;
    protected $_attributeFactory;
    protected $block;
    protected  $brands;
    protected $helper;
    protected $productFactory;
    protected $moduleReader;
    protected $_registry;
    protected $_urlBuilder;
    protected $storeManagerInterface;
    protected $dateTimeFactory;
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory  
     * @param \Magento\Catalog\Model\Product\AttributeSet\Options            $options            
     * @param \Magento\Eav\Api\AttributeManagementInterface                  $attributeManagement
     */
   
    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Asset\Repository $moduleReader,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogWidget\Block\Product\ProductsList $block,
        \Magento\Framework\UrlInterface $urlBuilder,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\Product\AttributeSet\Options $options,
        \Magento\Eav\Api\AttributeManagementInterface $attributeManagement,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
        \Magento\Framework\Stdlib\DateTime\DateTimeFactory $dateTimeFactory,
        array $data = []
        
    ) {
        $this->_scopeConfig  = $scopeConfig;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->block = $block;
        $this->moduleReader = $moduleReader;
        $this->_urlBuilder   = $urlBuilder;
        $this->productFactory = $productFactory;
        $this->_registry=$registry;
        $this->_attributeFactory = $attributeFactory;
        $this->collectionFactory = $collectionFactory;
        $this->options = $options;
        $this->attributeManagement = $attributeManagement;
        parent::__construct($context, $data);
    }
    public function getCurrentGMTDateTime()
    {
        $dateModel = $this->dateTimeFactory->create();
        return $dateModel->gmtDate();
    }
    public function getproduct(){
        return $this->block;
    }
	protected function _prepareLayout()
    {
       
        parent::_prepareLayout();
        $page_size = $this->getPagerCount();
        $page_data = $this->getProductCollection();
		$this->pageConfig->getTitle()->set(__('De Collection'));
        // print_r($page_size);
        
        if ($this->getProductCollection()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class
            )
                ->setAvailableLimit($page_size)
                ->setShowPerPage(true)
                ->setCollection($page_data);
            $this->setChild('pager', $pager);
            $this->getProductCollection()->load();
        }
        return $this;
    }
    
    public function getUpcomingPageTitle(){
        return $this->getData('headertitle');
    }
    
    public function getUpcomingPageTitleDetail(){
        return $this->getData('headerinfo');
    }
   

public function getProductCollection()
{
    $currenttime = $this->getCurrentGMTDateTime();
    $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
    $pageSize = ($this->getRequest()->getParam('limit')) ;
    $collection = $this->collectionFactory->create();
    $collection->addAttributeToSelect('*');
    // $collection->addFieldToFilter("seller_id",['in' =>explode("", $this->getData('sellerids')) ]);
    $collection->addAttributeToFilter('daily_deal',[1]);
	$collection->setFlag('has_stock_status_filter', false);

    $collection->addFieldToFilter('deal_from', array('gteq' => $currenttime));
	$collection->getSelect()->limit($this->getData('productlimit'));
    $collection->setPageSize($pageSize);
    $collection->setCurPage($page); 
    return $collection;
    
}  
public function getPagerCount()
{
	// get collection
	$minimum_show = $this->getData('productlimit'); // set minimum records
	$page_array = [];
	$list_data = $this->collectionFactory->create();
	$list_count = ceil(count($list_data->getData())); 
	$show_count = $minimum_show + 1;
	if (count($list_data->getData()) >= $show_count) {
		$list_count = $list_count / $minimum_show;
		$page_nu = $total = $minimum_show;
		$page_array[$minimum_show] = $minimum_show;
		for ($x = 0; $x <= $list_count; $x++) {
			$total = $total + $page_nu;
			$page_array[$total] = $total;
		}
	} else {
		$page_array[$minimum_show] = $minimum_show;
		$minimum_show = $minimum_show + $minimum_show;
		$page_array[$minimum_show] = $minimum_show;
	}
	return $page_array;
}


public function getPathUrlMedia() {
    //$this keyword use to refer the current object in the class
    return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
}
public function getPagerHtml()
    {
       return $this->getChildHtml('pager');
    }





    public function getsession()
    {
        return  $this->_session;
    }
    public function getPathBaceUrl() {
        //$this keyword use to refer the current object in the class
        return  $this->_storeManager->getStore()->getBaseUrl();
    }
   
    public function getProducts()
    {
        //$this keyword use to refer the get cuurent product
        return $this->_registry->registry('current_product');
    }
    public function getUrllink()
    {
               //$this keyword use to refer the get Url
        return $this->_urlBuilder->getUrl('allbrand');
    }
   





    

   
}
    
