<?php

namespace Dotsquares\Brands\Model\Config\Source;
class ListMode implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => "no", 'label' => __('No')],
            ['value' => "displayfirst", 'label' => __('Display First')],
            ['value' => "displaylast", 'label' => __('Display Last')]
        ];
    }
}

