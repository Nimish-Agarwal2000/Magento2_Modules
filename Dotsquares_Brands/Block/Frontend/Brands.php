<?php
declare(strict_types=1);

namespace Dotsquares\Brands\Block\Frontend;


use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;

use Magento\Customer\Model\Session;
use Magento\Backend\Model\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
class Brands extends \Magento\Framework\View\Element\Template
{
    const CMS_PAGE = 'brands/general/cms_page';
    const BRAND_LABEL = 'brands/general/brands_item_label';
     /**
   *
   * @var StoreManagerInterface
   */
  protected $customFactory;
  protected $moduleReader;
  protected $storeManagerInterface;
  protected $collectionFactory;
  protected $_registry;
  protected $helper;
    public $brands;
    protected $_urlBuilder;
    protected$_scopeConfig;
    // public $_session;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */

    // constructor for necesssary files
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Dotsquares\Brands\Model\Post $customFactory,
        \Magento\Framework\View\Asset\Repository $moduleReader,
        \Dotsquares\Brands\Model\ResourceModel\Post\CollectionFactory $brands,
        \Dotsquares\Brands\Helper\Data $helper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManagerInterface,
        

        array $data= [] ) 

    {
        // Collection Factory is used for display data from data collection file 
        $this->moduleReader = $moduleReader;
        $this->customFactory = $customFactory;
        $this->brands = $brands;
        $this->helper = $helper;
        $this->collectionFactory =$collectionFactory;
        $this->_registry=$registry;
        $this->_urlBuilder   = $urlBuilder;
        $this->_scopeConfig  = $scopeConfig;
        parent::__construct($context, $data);
        
        // $this->_session = $session;
        
    }


    protected function _prepareLayout()
    {
       
        parent::_prepareLayout();
        $page_size = $this->getPagerCount();
        $page_data = $this->getBrandCollections();
        // print_r($page_size);
        
        if ($this->getBrandCollections()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class
            )
                ->setAvailableLimit($page_size)
                ->setShowPerPage(true)
                ->setCollection($page_data);
            $this->setChild('pager', $pager);
            $this->getBrandCollections()->load();
        }
        return $this;
    }


    public function getPagerHtml()
    {
       return $this->getChildHtml('pager');
    }
    public function getBrandCollections()
    {
        // get param values
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest()->getParam('limit') : 5; // set minimum records
        // get custom collection
        $collection = $this->customFactory->getCollection();
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }
    public function getPagerCount()
    {
        // get collection
        $minimum_show = 6; // set minimum records
        $page_array = [];
        $list_data = $this->brands->create();
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



    // public function getPagerHtml()
    // {
    //     return $this->getChildHtml('pager');
    // }
    public function getPopup() {
        
        return $this->helper->getPopUp();
    }
    public function getPPBSDescription() {
        
        return $this->helper->getPPBSDescription();
    }
    public function getPPBLogoWidth() {
        
        return $this->helper->getPPBLogoWidth();
    }
    public function getPPBLogoHeight() {
        
        return $this->helper->getPPBLogoHeight();
    }
    public function getBrandEnable() {
        
        return $this->helper->getBrandEnable();
    }
    public function error()
    {
      return exit;
      
    }
    
    

    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

    public function getPathUrlMedia() {
        //$this keyword use to refer the current object in the class
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

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
   
    public function getProduct()
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



