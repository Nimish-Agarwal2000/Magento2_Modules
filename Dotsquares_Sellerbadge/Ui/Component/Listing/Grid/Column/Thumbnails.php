<?php 

namespace Dotsquares\Sellerbadge\Ui\Component\Listing\Grid\Column;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnails extends Column {

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
    foreach($dataSource["data"]["items"] as &$item) {
      if (isset($item['path'])) {
        
        $url = $this->storeManagerInterface->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) ."imageUploader/images/";
        $url = $url."/".$item['thumbnail'];
        $item['path_src'] = $url;
        $item['path_alt'] = $item['badge_id'];
        $item['path_link'] = $url;
        $item['path_orig_src'] = $url;
      }
    }

    return $dataSource;
  }
}