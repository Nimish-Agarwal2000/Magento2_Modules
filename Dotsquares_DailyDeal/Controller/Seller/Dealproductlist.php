<?php
namespace Dotsquares\DailyDeal\Controller\Seller;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\RequestInterface;


class Dealproductlist extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $url;
    
    protected $formKey;
    
    protected $request;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $session;

    protected $_messageManager;

    protected $dealHeleper;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Customer\Model\Url $url,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Dotsquares\DailyDeal\Helper\Data $dealHeleper,
        \Magento\Customer\Model\Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->url = $url;
        $this->request = $request;
        $this->formKey = $formKey;
        $this ->request->setParam('form_key',$this->formKey->getFormKey());
        $this->_messageManager = $messageManager;
        $this->dealHeleper = $dealHeleper;
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
            $groupCode = $this->dealHeleper->getCustomerGroup();
            if($groupCode == 'Marketplace Seller'){
                $resultPage = $this->resultPageFactory->create();
                $resultPage->getConfig()->getTitle()->set(__('Enabled Deal List'));
                return $resultPage;
            }else{
                $this->_messageManager->addError('You are not authorize to access this page');
                return $this->resultRedirectFactory->create()->setPath('customer/account/');
            }
        }
    }
}
