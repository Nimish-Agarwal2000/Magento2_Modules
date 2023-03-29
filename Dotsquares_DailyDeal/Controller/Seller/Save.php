<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Controller\Product;


class Save extends \Magento\Framework\App\Action\Action
{
    /*
     * @var Blog
     */
    protected $productFactory;
    /**
     * @var Session
     */
    protected $adminsession;
    /**
     * @param Action\Context $context
     * @param Blog           $productFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Catalog\Model\Product $productFactory, \Magento\Framework\Filesystem\Driver\File $file) {
        $this->resultPageFactory = $resultPageFactory;
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
        $this->_file = $file;
        parent::__construct ( $context );
    }
    /**
     * Save blog record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {  
        
        $data = $this->getRequest()->getPostValue();
        
        if ($data) {
            $productId = $this->getRequest ()->getParam ( 'product_id' );
            if ($productId) {
                $this->productFactory->load($productId);
                $collecton = $this->productRepository->getById($productId);
            }

            if($data['daily_deal']){
                $this->productFactory->setDailyDeal($data['daily_deal']);
            }
            if($data['discount_type'] =="fixed")
            {
                if($data['deal_value'] && (int)$collecton->getPrice()>$data['deal_value']){
                    $this->productFactory->setDealValue($data['deal_value']);
                    $this->productFactory->setSpecialPrice($data['deal_value']);
                }else{
                
                $this->messageManager->addError(__('Deal Value is incorrect'));
                $this->_redirect ( 'dailydeal/seller/editdealform/product_id/'.$productId.'/' );
                           return;
                }
            }elseif($data['deal_value'] && $data['deal_value']<=99){
          
                $this->productFactory->setDealValue($data['deal_value']);
                $this->productFactory->setSpecialPrice($data['deal_value']);
            }
            elseif(!$data['deal_value']){
                $this->productFactory->setDealValue();
            }else{
                $this->messageManager->addError(__('Deal Value is greterthan 99'));
                $this->_redirect ( 'dailydeal/seller/editdealform/product_id/'.$productId.'/' );
                           return;
            }
        
             $this->productFactory->setDailyDeal($data['daily_deal']);
            if($data['discount_type']){$this->productFactory->setDiscountType($data['discount_type']);   }
            
            if($data['deal_from']){ $this->productFactory->setDealFrom($data['deal_from']);}
            else{$this->productFactory->setDealFrom('');}
            if($data['deal_to']>$data['deal_from']){$this->productFactory->setDealTo($data['deal_to']);}
            else{
                $this->messageManager->addError(__('Deal To date incorrect'));
                $this->_redirect ( 'dailydeal/seller/editdealform/product_id/'.$productId.'/' );
                           return;}
            try {
                $this->productFactory->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
              
               
                $this->_redirect ( 'dailydeal/product/editdealform');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                echo $e->getMessage();die;
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            // $this->_getSession()->setFormData($data);
            $this->_redirect ( 'dailydeal/seller/dealproductlist' );
            return;
        }
        $this->_redirect ( 'dailydeal/seller/dealproductlist' );
        return;
    } 
}
