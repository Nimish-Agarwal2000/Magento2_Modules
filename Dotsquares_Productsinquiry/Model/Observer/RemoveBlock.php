<?php


namespace Dotsquares\Productsinquiry\Model\Observer;

use Magento\Catalog\Api\Data\ProductInterface;
use Dotsquares\Productsinquiry\Registry\CurrentProduct;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
 
class RemoveBlock implements ObserverInterface
{
     /**
     * @var CurrentProduct
     */
    private $currentProduct;
    protected $_scopeConfig;
 
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        
        
    )
    {
        $this->_scopeConfig = $scopeConfig;
       
        
        
    }
 
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getLayout();
        if($observer->getFullActionName() === 'catalog_product_view'){
        $block = $layout->getBlock('example.tab');  // here block reference name to remove
        
   
        
        // $enquiry = $product->getEnquiry();
        
        if ($block) {
           
            $remove = $this->_scopeConfig->getValue('products/general/enable', ScopeInterface::SCOPE_STORE);
            
            if ($remove == false) {
                
                $layout->unsetElement($block->getNameInLayout());
                }
                
        }
    }
}
}

