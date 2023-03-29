<?php

namespace Dotsquares\Sellerbadge\Controller\Adminhtml\Index;

class Add extends \Magento\Backend\App\Action
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
		$FormId = $this->getRequest()->getParam('badge_id');
	if($FormId){
      $title="Edit Badge";
	}
	else{
		$title="Manage Badges";
	}
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend((__($title)));

		return $resultPage;
	}
	

}