<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Controller\Seller;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\Action\Context;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;


class MassDisable extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Filter
     */
    protected $filter;
    protected $formKey;
    
    protected $request;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
  
    public function __construct(
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\App\Request\Http $request,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->request = $request;
        $this->formKey = $formKey;
        $this ->request->setParam('form_key',$this->formKey->getFormKey());
        parent::__construct($context);
    }
   
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
      

      
         foreach ($collection as $item) { 
           
        
          $item->setDailyDeal(0);
          $item->save();
        
        }

        
        
        $this->messageManager->addSuccess(__('A total of %1 element(s) have been disable.', $collectionSize));
                      /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                      $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                      return  $resultRedirect->setPath('*/*/dealproductlist');
    }
}