<?php
namespace Dotsquares\Productsinquiry\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Dotsquares\Productsinquiry\Model\Test',
            'Dotsquares\Productsinquiry\Model\ResourceModel\Test'
        );
    }
}