<?php

namespace Dotsquares\Sellerbadge\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Backend\Model\Session;
use Magento\Framework\Validation\ValidationException;

class Save extends \Magento\Backend\App\Action {
  /**
   *
   * @var UploaderFactory
   */
  protected $uploaderFactory;

  /**
   * @var \VENDOR\Brands\Model\postFactory
   */
  protected $postFactory;

  /** 
   * @var Filesystem\Directory\WriteInterface 
   */
  protected $mediaDirectory;

  protected $adminsession;
  
  public function __construct(
    Context $context,
    \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
    Filesystem $filesystem,
    Session $adminsession,
    \Dotsquares\Sellerbadge\Model\PostFactory $postFactory
  )
  {
    parent::__construct($context);
    $this->uploaderFactory = $uploaderFactory;
    $this->adminsession = $adminsession;
    $this->postFactory = $postFactory;
    
    $this->mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
  }

  public function execute()
  {
    $badge_id = $this->getRequest()->getParam('badge_id');
  if( $badge_id){
    $data = $this->getRequest()->getPostValue();
    $resultRedirect = $this->resultRedirectFactory->create();
    if ($data) {
        $badge_id = $this->getRequest()->getParam('badge_id');
        $model = $this->_objectManager->create(\Dotsquares\Sellerbadge\Model\Post::class)->load($badge_id);
        if (!$model->getId() && $badge_id) {
          $this->messageManager->addErrorMessage(__('This quote no longer exists.'));
          return $resultRedirect->setPath('*/index/add');
        }
        $data = $this->_filterAttachmentData($data);
			
        $model->setData($data);
        try {
          $model->save();
            $this->messageManager->addSuccess(__('Badge Assigned Successfully'));
            $this->adminsession->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                if ($this->getRequest()->getParam('back') == 'add') {
                    return $resultRedirect->setPath('*/index/add');
                } else {
                    return $resultRedirect->setPath('*/*/edit', ['badge_id' => $this->postFactory->getBadgeId(), '_current' => true]);
                }
            }
            return $resultRedirect->setPath('*/index/index');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
        }
        $this->_getSession()->setFormData($data);
        return $resultRedirect->setPath('*/*/add', ['badge_id' => $this->getRequest()->getParam('badge_id')]);
    }
    return $resultRedirect->setPath('*/*/');
}

  
  else{
    
    try {
      
      if ($this->getRequest()->getMethod() !== 'POST' || !$this->_formKeyValidator->validate($this->getRequest())) {
        throw new LocalizedException(__('Invalid Request'));
       
    }

    //validate image
    $fileUploader = null;
    $params = $this->getRequest()->getParams();          
    try {
      $imageId = 'thumbnail';
      if (isset($params['thumbnail']) && count($params['thumbnail']) ){
          $imageId = $params['thumbnail'][0];
          if (!file_exists($imageId['tmp_name'])) {
              $imageId['tmp_name'] = $imageId['path'] . '/' . $imageId['file'];
          }
      }
        
        $fileUploader = $this->uploaderFactory->create(['fileId' => $imageId]);
    
        $fileUploader->setAllowedExtensions(['jpg', 'jpeg', 'png']);
        $fileUploader->setAllowRenameFiles(true);
        $fileUploader->setAllowCreateFolders(true);
        $fileUploader->validateFile();
        //upload image
        $info = $fileUploader->save($this->mediaDirectory->getAbsolutePath('imageUploader/images'));
        /** @var \VENDOR\Brands\Model\Image */
        $image = $this->postFactory->create();
        $image->setBadgename($params['badge_name']);
        $image->setThumbnail($info['file']);
        $image->setRanks($params['ranks']);
        $image->setBadgedescriptions($params['badge_descriptions']);
        $image->setSellerstatus($params['seller_status']);


        $image->setPath($this->mediaDirectory->getRelativePath('imageUploader/images'));
        $image->save();
    } catch (ValidationException $e) {
      throw new LocalizedException(__('Image extension is not supported. Only extensions allowed are jpg, jpeg and png'));
    }
  
    catch (\Exception $e) {
        //if an except is thrown, no image has been uploaded
        throw new LocalizedException(__('Image is required'));
    }

    $this->messageManager->addSuccessMessage(__('Badge Assigned Successfully'));

    return $this->_redirect('*/index/index');
    } catch (LocalizedException $e) {
      $this->messageManager->addErrorMessage($e->getMessage());
      return $this->_redirect('*/index/add');
    } catch (\Exception $e) {
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        $this->messageManager->addErrorMessage(__('An error occurred, please try again later.'));
        return $this->_redirect('*/index/add');
    }

  }
}
public function _filterAttachmentData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['thumbnail'][0]['name'])) {
            $data['thumbnail'] = $data['thumbnail'][0]['name'];
        } else {
            $data['thumbnail'] = null;
        }
        return $data;
    }
}
