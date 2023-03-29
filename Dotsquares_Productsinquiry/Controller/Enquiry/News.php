<?php

namespace Dotsquares\Productsinquiry\Controller\Enquiry;


use Zend\Log\Filter\Timestamp;
use Dotsquares\Productsinquiry\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Store\Model\StoreManagerInterface;
use Dotsquares\Productsinquiry\Model\TestFactory;
class News implements ActionInterface
{
    const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
    protected $storeManager;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $_helper;
    
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Action\Context $context,
        \Dotsquares\Productsinquiry\Helper\Data $helper,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        TestFactory $test,
        PageFactory $resultPageFactory,
        array $data = []
    )
    {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
         $this->_helper = $helper;
        
        $this->resultPageFactory    = $resultPageFactory;
        $this->request              = $request; 
        $this->resultFactory        = $resultFactory;
        $this->messageManager       = $messageManager;
        $this->test = $test;
        // parent::__construct($context);
    }

    public function execute()
    {
        
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setRefererOrBaseUrl(); // test

        try {
            $post =  $this->request->getPostValue();
                
            // Send Mail
            $this->_inlineTranslation->suspend();
            $senderIdentity = $this->_helper ->getSenderGroupIdentity(); 
           $contextemail = 'trans_email/ident_' . $senderIdentity ;
            $contextname = 'trans_email/ident_'.$senderIdentity;
            
            $sentToEmail = $this->_scopeConfig ->getValue($contextemail.'/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
             
            $sentToName = $this->_scopeConfig ->getValue($contextname.'/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            
            
            $sendermail = $this->_helper ->getSendermailId();
            $sender = [
                'name' => $sentToName,
                'email' => $sentToEmail
               
            ];

            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('products_general_email_template')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ]
                )
                ->setTemplateVars([
                    'name'  => $post['c_name'],
                    'email'  => $post['email'],
                    'telephone' => $post['telephone'],
                    'sku' => $post['sku'],
                    'producturl' => $post['producturl'],
                    'subject' => $post['subject'],
                    'massage' => $post['massage']
                ])
                ->setFromByScope($sender)
                //->addTo($sentToEmail,$sentToName)
                ->addTo($sendermail)
                ->getTransport();
                 
                $transport->sendMessage();
                 
                $this->_inlineTranslation->resume();
                $this->messageManager->addSuccess('Enquiry Submited');
                

            if($post){
                
                $test = $this->test->create();

                // $test->setName('sadskdshj');
                $test->setName($post['c_name']);
                $test->setEmail($post['email']);
                $test->setTelephone($post['telephone']);
                $test->setSubject($post['subject']);
                $test->setSku($post['sku']);
                $test->setProductName($post['product_name']);
                $test->setProductId($post['product_id']);
                $test->setMassage($post['massage']);
                $test->setProducturl($post['producturl']);

                $test->save();
            }else{
                $this->messageManager->addError(__("No data"));
            }
            return $redirect;
        }
        catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->debug($e->getMessage());
            
        }
    }
}
