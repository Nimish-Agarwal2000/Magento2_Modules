<?php
namespace Dotsquares\Sellerbadge\Ui\Component\Listing\Grid\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class GetName extends Column
{
    protected $path;
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        \Magento\Customer\Model\CustomerFactory $favourite,
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
                $collection = $this->favourite->create()->load($item['customer_id']);
                $data =$collection->getName();
                $item[$this->getData('name')]['edit'] = [
                    'label' => __($data),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }
   
}