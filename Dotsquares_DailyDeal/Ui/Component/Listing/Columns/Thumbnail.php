<?php 

namespace Dotsquares\DailyDeal\Ui\Component\Listing\Columns;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column {

  /**
   *
   * @var StoreManagerInterface
   */
  protected $storeManagerInterface;

  public function __construct(
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    StoreManagerInterface $storeManagerInterface,
    array $components = [],
    array $data = []
  ) {
      parent::__construct($context, $uiComponentFactory, $components, $data);
      $this->storeManagerInterface = $storeManagerInterface;
  }

  public function prepareDataSource(array $dataSource)
  {
    if($dataSource["data"]["items"]){
    foreach($dataSource["data"]["items"] as &$item) {
      if (isset($item['thumbnail'])) {
        
        $url = $this->storeManagerInterface->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) ."catalog/product/";
        $url = $url."/".$item['thumbnail'];
        $item['thumbnail_src'] = $url;
        $item['thumbnail_alt'] = $item['entity_id'];
        $item['thumbnail_link'] = $url;
        $item['thumbnail_orig_src'] = $url;
      }
    }
    }
    return $dataSource;
  }
}