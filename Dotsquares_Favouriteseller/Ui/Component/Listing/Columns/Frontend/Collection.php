<?php
namespace Dotsquares\Favouriteseller\Ui\Component\Listing\Columns\Frontend;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Collection extends Column
{
    protected $path;
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        \Dotsquares\Marketplace\Model\ResourceModel\Seller\CollectionFactory $favourite,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->favourite  = $favourite;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $data=$this->favourite->create();
                foreach($data as $sellerstore){
                    if($sellerstore['email']==$item['seller_email']){
                        $this->path=$sellerstore['store_name'];
                        $this->path= str_replace(' ', '-', $this->path);
                        // $this->path="hiii";

                    }
                }
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl($this->path),
                    'label' => __("collection"),
                    'hidden' => false,
                ];
               
            }
        }

        return $dataSource;
    }
}