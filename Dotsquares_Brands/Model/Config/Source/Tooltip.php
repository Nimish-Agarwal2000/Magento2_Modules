<?php

namespace Dotsquares\Brands\Model\Config\Source;
class Tooltip implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => "no", 'label' => __('No')],
            ['value' => "all_brands", 'label' => __('All Brands Page')],
            ['value' => "product", 'label' => __('Product Page')],
            ['value' => "listing", 'label' => __('Listing Page')]
        ];
    }
}

