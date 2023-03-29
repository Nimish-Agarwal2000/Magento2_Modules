<?php

namespace Dotsquares\Productsinquiry\Model\Config\Source;
class ListMode implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('In Tab')],
            ['value' => 0, 'label' => __('Popup')]
        ];
    }
}

