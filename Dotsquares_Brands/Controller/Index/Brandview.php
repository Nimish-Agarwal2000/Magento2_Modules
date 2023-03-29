<?php

namespace Dotsquares\Brands\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Brandview extends Action
{
    protected $resultPageFactory;
    public $session;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
       
    }   

    public function execute()
    {

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        // $resultPage->getConfig()->getTitle()->set(__('Custom Pagination'));
        return $resultPage;
        // return $this->resultPageFactory->create();
    }
}