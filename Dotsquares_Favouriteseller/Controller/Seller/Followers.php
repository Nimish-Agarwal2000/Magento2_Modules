<?php
namespace Dotsquares\Favouriteseller\Controller\Seller;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;

class Followers extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $url;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    protected $_messageManager;

    protected $fevHelper;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Customer\Model\Url $url,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Dotsquares\Favouriteseller\Helper\Data $fevHelper,
        \Magento\Customer\Model\Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->url = $url;
        $this->_messageManager = $messageManager;
        $this->fevHelper = $fevHelper;
        $this->session = $session;
        parent::__construct($context);
    }

    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->url->getLoginUrl();
        if (!$this->session->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    public function execute()
    {
        if($this->session->isLoggedIn()) { 
            $groupCode = $this->fevHelper->getCustomerGroup();
            if($groupCode == 'Marketplace Seller'){
                $resultPage = $this->resultPageFactory->create();
                $resultPage->getConfig()->getTitle()->set(__('Followers List'));
                return $resultPage;
            }else{
                $this->_messageManager->addError('You are not authorize to access this page');
                return $this->resultRedirectFactory->create()->setPath('customer/account/');
            }
        }
    }
}
