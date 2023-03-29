<?php
namespace Dotsquares\Rmamarketplace\Ui\Component\Listing\Columns\Frontend;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class DetailsActionSeller extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'rmamarketplace/seller/rma',
                        ['id' => $item['id']]
                    ),
                    'label' => __('View'),
                    'hidden' => false,
                ];
              /*  if($item['final_status'] == '0'){
                    $item[$this->getData('name')]['cancel'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'rmamarketplace/seller/cancel',
                            ['id' => $item['id']]
                        ),
                        'label' => __('Cancel'),
                        'hidden' => false,
                    ];
                }*/
            }
        }
        return $dataSource;
    }
}
