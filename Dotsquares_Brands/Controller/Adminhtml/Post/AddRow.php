<?php

namespace Dotsquares\Brands\Controller\Adminhtml\Post;

class AddRow extends \Magento\Backend\App\Action
{
	protected $resultPageFactory = false;
    public $FormId;
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	
	public function execute()
	{
		$FormId = $this->getRequest()->getParam('brand_id');
	if($FormId){
      $title="Edit Brand";
	}
	else{
		$title="Add Brands";
	}
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__($title)));

		return $resultPage;
	}
	

}