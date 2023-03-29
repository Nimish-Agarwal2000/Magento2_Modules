<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\Favouriteseller\Controller\Seller;


use Zend\Log\Filter\Timestamp;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Store\Model\StoreManagerInterface;

class Email implements ActionInterface
{
    protected $storeManager;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $favourite;
    protected $_scopeConfig;
    protected $cemail;
    protected $_options = null;
    protected $_logLoggerInterface;
    protected $_helper;
    private static $_siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?";
    private $_secret;
    private static $_version = "php_1.0";

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\Action\Context $context,
        \Dotsquares\Favouriteseller\Model\ResourceModel\Details\CollectionFactory $favourite,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        PageFactory $resultPageFactory,
        array $data = []
    )
    {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->favourite = $favourite;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->resultPageFactory    = $resultPageFactory;
        $this->request              = $request; 
        $this->resultFactory        = $resultFactory;
        $this->messageManager       = $messageManager;
       
    }

    public function execute()
    {
        $post =  $this->request->getPostValue();  
        $id[] =$post['custome'];
        $seleremail =$post['s_email'];
        $selername =$post['s_name'];
        
      
            
        
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setRefererOrBaseUrl(); // test
        
        try {
           
            // Send Mail
            $this->_inlineTranslation->suspend();
            
        
           
        $sender = [
            'name' => $selername,
            'email' => $seleremail
           
        ];
        foreach($id as $allCustomerMail){
            foreach($allCustomerMail as $onecustomer){
           
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('transactional_email_genera_send_to_followers')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ]
                )
                ->setTemplateVars([
                    'subject' => $post['subject'],
                    'massage' => $post['massage']
                ])
                ->setFromByScope($sender)
               
               
                   
                   -> addTo($onecustomer)
                
                
                ->getTransport();
                 
                $transport->sendMessage();
            }
        }
                $this->_inlineTranslation->resume();
                $this->messageManager->addSuccess('Email Send Successfully');
                

            
            return $redirect;
        }
        catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->debug($e->getMessage());
            
        }
    }
}