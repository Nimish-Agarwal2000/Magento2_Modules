<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Controller\Product;


class Savedata extends \Magento\Framework\App\Action\Action
{
    protected $utcConverter;
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
    public function __construct( \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone, \Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Catalog\Model\Product $productFactory, \Magento\Framework\Filesystem\Driver\File $file) {
        $this->resultPageFactory = $resultPageFactory;
        $this->productRepository = $productRepository;
        $this->utcConverter = $timezone;
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
            if(!$data['deal_value']){
               
                $this->productFactory->setDealValue();
            }elseif($data['discount_type'] =="fixed"){
                if((int)$collecton->getPrice()>$data['deal_value']){
                    $this->productFactory->setDealValue($data['deal_value']);
                    // $this->productFactory->setSpecialPrice($data['deal_value']);
                }else{
                    $this->messageManager->addError(__('Deal Value is not lessthan price'));
                    $this->_redirect ( 'dailydeal/seller/adddealform/product_id/'.$productId.'/' );
                               return;
                }
               
            }elseif($data['deal_value']<=99){
                $this->productFactory->setDealValue($data['deal_value']);
                // $this->productFactory->setSpecialPrice($data['deal_value']);

            }else{
                $this->messageManager->addError(__('Deal Value is greterthan 99'));
                $this->_redirect ( 'dailydeal/seller/adddealform/product_id/'.$productId.'/' );
                           return $deal_value = $data['deal_value'];
            }

            if($data['discount_type']){$this->productFactory->setDiscountType($data['discount_type']);   }
            if($data['deal_from']){
                
                $this->productFactory->setDealFrom($this->converToTz(
                    $data['deal_from'], 
                    // get default timezone of system (UTC)
                    $this->utcConverter->getDefaultTimezone(), 
                    // get Config Timezone of current user 
                    $this->utcConverter->getConfigTimezone()
                ));}
            if($data['deal_to']){
            if($data['deal_to']>$data['deal_from']){$this->productFactory->setDealTo($this->converToTz(
                $data['deal_to'], 
                // get default timezone of system (UTC)
                $this->utcConverter->getDefaultTimezone(), 
                // get Config Timezone of current user 
                $this->utcConverter->getConfigTimezone()
            ));}
            else{
                $this->messageManager->addError(__('"Deal To" date incorrect'));
                $this->_redirect ( 'dailydeal/seller/adddealform/product_id/'.$productId.'/' );
                           return;}
            }
            try {
                $this->productFactory->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
              
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/adddealform');
                    } else {
                        return $resultRedirect->setPath('*/*/adddealform', ['productId' => $this->productFactory->getBlogId(), '_current' => true]);
                    }
                }
                $this->_redirect ( 'dailydeal/product/adddealform');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                echo $e->getMessage();die;
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
            // $this->_getSession()->setFormData($data);
            $this->_redirect ( 'dailydeal/seller/dealonproduct' );
            return;
        }
        $this->_redirect ( 'dailydeal/seller/dealonproduct' );
        return;
    } 
   
   
    
     protected function converToTz($dateTime="", $toTz='', $fromTz='')
        {   
            // timezone by php friendly values
            $date = new \DateTime($dateTime, new \DateTimeZone($fromTz));
            $date->setTimezone(new \DateTimeZone($toTz));
            $dateTime = $date->format('m/d/Y H:i:s');
            return $dateTime;
        }
}
