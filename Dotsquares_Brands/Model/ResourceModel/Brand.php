<?php

namespace Dotsquares\Brands\Model\ResourceModel;

class Brand extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('brands', 'brand_id');   //here "vky_test" is table name and "test_id" is the primary key of custom table
    }
}