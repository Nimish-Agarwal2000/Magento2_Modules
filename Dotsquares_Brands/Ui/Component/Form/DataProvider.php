<?php

namespace Dotsquares\Brands\Ui\Component\Form;

use Dotsquares\Brands\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

protected $collection;     
protected $dataPersistor;
public    $_storeManager;    
protected $loadedData;

public function __construct(
    $name,
    $primaryFieldName,
    $requestFieldName,
    CollectionFactory $blockCollectionFactory,
    DataPersistorInterface $dataPersistor,
    \Magento\Store\Model\StoreManagerInterface $storeManager,        
    array $meta = [],
    array $data = []
) {
    $this->collection = $blockCollectionFactory->create();
    $this->_storeManager=$storeManager;       
    $this->dataPersistor = $dataPersistor;
    parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
}

public function getData()
{
    $baseurl =  $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."imageUploader/images/";
    if (isset($this->loadedData)) {

        return $this->loadedData;
    } 

    $items = $this->collection->getItems();

    if($items){
    foreach ($items as $page) {


        $temp = $page->getData();
        $img = [];
        $img[0]['name'] = $temp['image'];
        $img[0]['url'] = $baseurl.$temp['image'];
        $temp['image'] = $img;


    }

    $data = $this->dataPersistor->get('brands');
    if (!empty($data)) {
        $page = $this->collection->getNewEmptyItem();
        $page->setData($data);
        $this->loadedData[$page->getId()] = $page->getData();

        $this->dataPersistor->clear('brands');
    }else {
        if ($page->getData('image') != null) {

            $t2[$page->getId()] = $temp;     

            return $t2;
        } else {                

            // echo '<pre>';
 //print_r($this->loadedData);exit;
           return $this->loadedData;

        }
      } 
    }      
}
}