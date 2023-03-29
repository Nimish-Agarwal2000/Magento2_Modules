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
use Dotsquares\Favouriteseller\Model\TestFactory;

class Save implements ActionInterface
{
    protected $storeManager;
    protected $favourite;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $collectt;
    protected $data;
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
        TestFactory $test,
        PageFactory $resultPageFactory,
        array $data = []
    )
    {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->favourite = $favourite;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        
        
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
        $post =  $this->request->getPostValue();
        if(!$post['c_id']){
            
            $this->messageManager->addError('A login and a password are required.');
           return $redirect;
                 }
        $this->collectt = $this->favourite->create();
        $sellerid[] ="";
        $customerid[] ="";
       
        $seller = $this->collectt;
        foreach($seller as $sellers){
            if($sellers['customer_id']==$post['c_id']){
                if($sellers['seller_id']==$post['s_id']) {
                    $this->data =$sellers['seller_id'];
                }
            }
           $sellerid[] = $sellers['seller_id'] ;
           $customerid[] = $sellers['customer_id'] ;
        }
        
        
       
        if ($this->data){
            $this->messageManager->addError(__("This seller already add"));
            return $redirect;
        }
        else{
            try {
                $post =  $this->request->getPostValue();


  // Send Mail

       
     
     
         if($post){   
            
            
            $this->_inlineTranslation->suspend();
if($post['c_email']){
        $email = $this->_scopeConfig->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $name  = $this->_scopeConfig->getValue('trans_email/ident_general/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $sender = [
            'name' => $name,
            'email' => $email
           
        ];
        $transport = $this->_transportBuilder
      ->setTemplateIdentifier('transactional_email_genera_followed_mail_to_costomer')
      ->setTemplateOptions(
          [
              'area' => 'frontend',
              'store' => $this->storeManager->getStore()->getId()
          ]
          )
          ->setTemplateVars([
              'customer_name' => $post['c_name'],
              'seller_name' => $post['s_name']
          ])
          ->setFromByScope($sender)
          //->addTo($sentToEmail,$sentToName)
         
             
             -> addTo($post['c_email'])
          
          
          ->getTransport();
           
          $transport->sendMessage();
          }
          if($post['s_email']){
            
            $sendercustomer = [
                'name' => $post['c_name'],
                'email' => $post['c_email']
               
            ];
            $transport = $this->_transportBuilder
      ->setTemplateIdentifier('transactional_email_genera_followed_mail_to_seller')
      ->setTemplateOptions(
          [
              'area' => 'frontend',
              'store' => $this->storeManager->getStore()->getId()
          ]
          )
          ->setTemplateVars([
              'seller_name' => $post['s_name'],
              'customer_name' => $post['c_name']
              
          ])
          ->setFromByScope($sendercustomer)
          //->addTo($sentToEmail,$sentToName)
         
             
             -> addTo($post['s_email'])
          
          
          ->getTransport();
           
          $transport->sendMessage();
          }
                    $test = $this->test->create();
                   
     $test->setCustomerName($post['c_name']);
     $test->setCustomerEmail($post['c_email']);
     $test->setCustomerId($post['c_id']);
     $test->setSellerId($post['s_id']);
     $test->setSellerName($post['s_name']);
     $test->setSellerEmail($post['s_email']);
    //  $test->setProductId($post['product_id']);
     $test->save();
     $this->messageManager->addSuccess('Seller added to favourite');
                    // }
    
                   
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
  
}