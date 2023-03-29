<?php

namespace Dotsquares\Brands\Controller\Adminhtml\Post;

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
    \Dotsquares\Brands\Model\PostFactory $postFactory
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
    $post_id = $this->getRequest()->getParam('brand_id');
if( $post_id){
    $data = $this->getRequest()->getPostValue();
    $resultRedirect = $this->resultRedirectFactory->create();
    if ($data) {
        $post_id = $this->getRequest()->getParam('brand_id');
        $model = $this->_objectManager->create(\Dotsquares\Brands\Model\Post::class)->load($post_id);
        if (!$model->getId() && $post_id) {
          $this->messageManager->addErrorMessage(__('This quote no longer exists.'));
          return $resultRedirect->setPath('*/*/addRow');
        }
        $data = $this->_filterAttachmentData($data);
			
        $model->setData($data);
        try {
          $model->save();
            $this->messageManager->addSuccess(__('The data has been saved.'));
            $this->adminsession->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                if ($this->getRequest()->getParam('back') == 'add') {
                    return $resultRedirect->setPath('*/*/addRow');
                } else {
                    return $resultRedirect->setPath('*/*/edit', ['brand_id' => $this->postFactory->getBlogId(), '_current' => true]);
                }
            }
            return $resultRedirect->setPath('*/*/index');
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
        }
        $this->_getSession()->setFormData($data);
        return $resultRedirect->setPath('*/*/addRow', ['brand_id' => $this->getRequest()->getParam('brand_id')]);
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
      $imageId = 'image';
      if (isset($params['image']) && count($params['image']) && isset($params['name']) ){
          $imageId = $params['image'][0];
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
        $image->setName($params['name']);
        $image->setSortDetail($params['sort_detail']);
        $image->setFullDetail($params['full_detail']);
        $image->setImage($info['file']);
        $image->setPath($this->mediaDirectory->getRelativePath('imageUploader/images'));
        $image->save();
    } catch (ValidationException $e) {
      throw new LocalizedException(__('Image extension is not supported. Only extensions allowed are jpg, jpeg and png'));
    }
  
    catch (\Exception $e) {
        //if an except is thrown, no image has been uploaded
        throw new LocalizedException(__('Image is required'));
    }

    $this->messageManager->addSuccessMessage(__('Image uploaded successfully'));

    return $this->_redirect('*/*/index');
    } catch (LocalizedException $e) {
      $this->messageManager->addErrorMessage($e->getMessage());
      return $this->_redirect('*/*/addRow');
    } catch (\Exception $e) {
        error_log($e->getMessage());
        error_log($e->getTraceAsString());
        $this->messageManager->addErrorMessage(__('An error occurred, please try again later.'));
        return $this->_redirect('*/*/addRow');
    }

  }
}
public function _filterAttachmentData(array $rawData)
    {
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}
