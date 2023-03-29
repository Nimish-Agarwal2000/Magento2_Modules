<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Dotsquares\Productsinquiry\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Dotsquares\Productsinquiry\Model\Blog
     */
    protected $blogFactory;
    /**
     * @param Context                  $context
     * @param \Dotsquares\Productsinquiry\Model\Blog $blogFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Dotsquares\Productsinquiry\Model\Blog $blogFactory
    ) {
        parent::__construct($context);
        $this->blogFactory = $blogFactory;
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dotsquares_Productsinquiry::index_delete');
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $blogFactory = $this->blogFactory;
                $blogFactory->load($id);
                $blogFactory->delete();
                $this->messageManager->addSuccess(__('Record deleted successfully.'));
                return $resultRedirect->setPath('*/post/index');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['post_id' => $id]);
            }
        }
        $this->messageManager->addError(__('Record does not exist.'));
        return $resultRedirect->setPath('*/*/edit');
    }
}