<?php

/**

 *
 * @category    Dotsquares
 * @package     Dotsquares_Favouriteseller
 * @version     1.0.0

 *
 */
namespace Dotsquares\Favouriteseller\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Store\Model\StoreManagerInterface;

/**
 * This class contains seller approval/disapproval functions
 */
class Cataloginventoryupdate implements ObserverInterface {
    protected $action;
    protected $storeManager;
    protected $_stockItemRepository;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $productcollection;
    protected $_inlineTranslation;
    protected $favourite;
    public function __construct(
      Action $action,
      StoreManagerInterface $storeManager,
      \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
      \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
      \Magento\CatalogInventory\Api\StockRegistryInterface $stockItemRepository, 
      \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
      \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productcollection,
      \Dotsquares\Favouriteseller\Model\ResourceModel\Details\CollectionFactory $favourite,
      ) {
        $this->action = $action;
        $this->favourite = $favourite;
        $this->storeManager = $storeManager;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->productcollection = $productcollection;
        $this->_stockItemRepository = $stockItemRepository;
       
        
    }
    
    /**
     * Execute the result
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
       
            $product = $observer->getProduct ();
            $productUrl = $product-> getProductUrl();
            $productSku = $product-> getSku();
            $productSellerId = $product->getSellerId ();           
            $collections = $this->favourite->create();    
               
       
            foreach($collections as $collection ){
                if($productSellerId == $collection['seller_id']){

                    $sender = [
                        'name' => $collection['seller_name'],
                        'email' => $collection['seller_email']
                       
                    ];
               
                
            $this->_inlineTranslation->suspend();
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('transactional_email_genera_product_notification')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ]
                )
                
                ->setFromByScope($sender)
               
               
                   
                   -> addTo($collection['customer_email'])
                   ->setTemplateVars([
                    'customer_name' => $collection['customer_name'],
                    'seller_name' => $collection['seller_name'],
                    'product_url' => $productUrl,
                    'product_sku' => $productSku
                    
                ])
                
                ->getTransport();
                 
                $transport->sendMessage();

                   }
    
                }
            
    }
   
}

