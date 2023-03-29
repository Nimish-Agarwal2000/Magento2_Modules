<?php 

namespace Dotsquares\Sellerbadge\Ui\Component\Listing\Grid\Column;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ThumbnailBadge extends Column {

  /**
   *
   * @var StoreManagerInterface
   */
  protected $storeManagerInterface;

  public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    \Dotsquares\Sellerbadge\Model\PostFactory $favourite,
    StoreManagerInterface $storeManagerInterface,
    array $components = [],
    array $data = []
  ) {
      parent::__construct($context, $uiComponentFactory, $components, $data);
      $this->storeManagerInterface = $storeManagerInterface;
      $this->favourite  = $favourite;
  }

  public function prepareDataSource(array $dataSource)
  {
    foreach($dataSource["data"]["items"] as &$item) {
      if (isset($item['assign_badge'])) {
        $myArray=[];
        $myArray = explode(',', $item['assign_badge']);
       
      }
      if(isset($myArray)){
        $imagesContainer='';
        foreach ($myArray  as $image) {
          $url = $this->storeManagerInterface->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) ."imageUploader/images/";
          $collection = $this->favourite->create()->load($image);
          $data =$collection->getThumbnail();
          $sataus =$collection->getSellerstatus();
          
          if($data && $sataus=='Approved'){
            $imageUrl = $url.$data;
            $imagesContainer = $imagesContainer."<img src=". $imageUrl ." width='50px' height='50px' style='display:inline-block;margin:2px'/>";
        
          }
        }
  $item['assign_badge']=$imagesContainer;
      }
     
    }

    return $dataSource;
  }
}
