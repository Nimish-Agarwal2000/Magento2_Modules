<?php

namespace Dotsquares\Sellerbadge\Controller\Adminhtml\Seller;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;
use Dotsquares\Marketplace\Model\SellerFactory;
use Dotsquares\Marketplace\Model\ResourceModel\Seller\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;

class MassBadgeRemove extends Action
{
    protected $filter;
    protected $resultPageFactory;
    protected $collectionFactory;
    protected $extensionModelFactory;
    private $scopeConfig;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Filter $filter,
        ScopeConfigInterface $scopeConfig,
        SellerFactory $extensionModelFactory,
        CollectionFactory $collectionFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->scopeConfig = $scopeConfig;
        $this->extensionModelFactory = $extensionModelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $updated = 0;
            foreach ($collection as $item) {
                $model = $this->extensionModelFactory->create()->load($item['id']);
                $badges = $model->getAssignBadge();
               $badge = $this->getRequest()->getParam('remove_badge');
               $badges = str_replace(",".$badge, '', $badges);
              
                 $model->setAssignBadge($badges);
                 $model->save();
                 $updated++;
               
              
            }
            if ($updated) {
                $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $updated));
            }

        } catch (\Exception $e) {
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

    protected function _isAllowed()
    {
        return true;
    }
}