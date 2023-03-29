<?php
namespace Dotsquares\Brands\Model\ResourceModel\Brand;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Dotsquares\Brands\Model\Brand',
            'Dotsquares\Brands\Model\ResourceModel\Brand'
        );
    }
}