<?php
/**
 * Created By : Rohan Hapani
 */
namespace Dotsquares\Brands\Block\Frontend;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;

use Magento\Customer\Model\Session;

use Magento\Store\Model\StoreManagerInterface;

class Brandview extends \Magento\Framework\View\Element\Template {

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $collectionFactory;
    protected $_productCollectionFactory;

    const CMS_PAGE = 'brands/general/cms_page';
    const BRAND_LABEL = 'brands/general/brands_item_label';
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
    /**
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory  
     * @param \Magento\Catalog\Model\Product\AttributeSet\Options            $options            
     * @param \Magento\Eav\Api\AttributeManagementInterface                  $attributeManagement
     */
   
    public function __construct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Dotsquares\Brands\Helper\Data $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Asset\Repository $moduleReader,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogWidget\Block\Product\ProductsList $block,
        \Dotsquares\Brands\Model\ResourceModel\Post\CollectionFactory $brands,
        \Magento\Framework\UrlInterface $urlBuilder,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\Product\AttributeSet\Options $options,
        \Magento\Eav\Api\AttributeManagementInterface $attributeManagement,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
       $productCollectionFactory,    
           

        array $data = []
        
    ) {
        $this->_scopeConfig  = $scopeConfig;
        $this->block = $block;
        $this->brands =  $brands;
        $this->helper = $helper;
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
    public function getproduct(){
        return $this->block;
    }
    protected function _prepareLayout()
    {
        $brand = $this->getBrands();
        parent::_prepareLayout();
        
         $this->pageConfig->getTitle()->set(__($brand['name']));
         if ($this->getProductCollection()) {
             $pager = $this->getLayout()->createBlock(
               'Magento\Theme\Block\Html\Pager',
                'custom.history.pager'
                )->setAvailableLimit([2 => 2, 4 => 4, 12 => 12, 16 => 16, 20 => 20])
                ->setShowPerPage(true)->setCollection(
             $this->getProductCollection()
             );
             $this->setChild('pager', $pager);
             $this->getProductCollection()->load();
         }
         return $this;
    }
    public function getAttrOptIdByLabel($attrCode,$optLabel)
    {
        $product = $this->productFactory->create();
        $isAttrExist = $product->getResource()->getAttribute($attrCode); // Add here your attribute code
        $optId = '';
        if ($isAttrExist && $isAttrExist->usesSource()) {
            $optId = $isAttrExist->getSource()->getOptionId($optLabel);
        }
        return $optId;
    }
   
    public function getAttr()
{
    $attributeInfo = $this->_attributeFactory->getCollection();
   
   foreach($attributeInfo as $attributes)
   {
        $attributeId = $attributes->getFrontendLabel();
        
        echo $attributeId;
        echo "<br>";

        // You can get all fields of attribute here
   }

   
        exit;
     
}

public function getProductCollection()
{
    $custId = $this->getRequest()->getParam('id');
    $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
    $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(

)->getParam('limit') : 4;
    $collection = $this->collectionFactory->create();
    $collection->addAttributeToSelect('*')->addAttributeToFilter('brands',['eq'=>$custId]);
    $collection->setPageSize($pageSize);
    $collection->setCurPage($page); 
    return $collection;
    
}
public function getBrands(){
    $custId = $this->getRequest()->getParam('id');
    $collect = $this->brands->create();
    
    foreach($collect as $item){
        if($item['brand_id']== $custId){
            return $item;
        }
    }
}
public function getPathUrlMedia() {
    //$this keyword use to refer the current object in the class
    return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
}
public function getPagerHtml()
    {
       return $this->getChildHtml('pager');
    }





    public function getPopup() {
        
        return $this->helper->getPopUp();
    }
    public function getPPBSDescription() {
        
        return $this->helper->getPLPBSDescription();
    }
    public function getPPBLogoWidth() {
        
        return $this->helper->getPLPBLogoWidth();
    }
    public function getPLPBLogoHeight() {
        
        return $this->helper->getPPBLogoHeight();
    }
    public function getPLPBLogo() {
        
        return $this->helper->getPLPBLogo();
    }
    public function getBrandEnable() {
        
        return $this->helper->getBrandEnable();
    }

    

    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

   

    // Function for Display Data on page
    public function getBrandCollection()
    {
        return $this->brands->create();
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
    public function getMenuButtoneName()
    {
        //$this keyword use to refer the get cuurent product
        return $this->_scopeConfig->getValue(self::BRAND_LABEL, 
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE
    );
    }
    public function getStarUrl()
    {

        return $this->moduleReader->getUrl('Dotsquares_Brands::images/template.png');
        
    }





    

   
}
    
