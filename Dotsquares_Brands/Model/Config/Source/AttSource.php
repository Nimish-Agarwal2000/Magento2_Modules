<?php

namespace Dotsquares\Brands\Model\Config\Source;

use \Magento\Framework\Data\OptionSourceInterface;

class AttSource implements OptionSourceInterface {

    protected $_attributeFactory;

    public function __construct(

\Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory
) {

    $this->_attributeFactory = $attributeFactory;
}

public function toOptionArray() {
    $arr = [];
    $attributeInfo = $this->_attributeFactory->getCollection()->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, 4);

    foreach ($attributeInfo as $attributes) {
        $attributeId = $attributes->getAttributeId();
        // You can get all fields of attribute here

        $arr[$attributes->getAttributeId()] = $attributes->getFrontendLabel();
    }
    return $arr;
}
}