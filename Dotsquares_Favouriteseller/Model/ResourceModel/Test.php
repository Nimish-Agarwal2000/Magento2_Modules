<?php

namespace Dotsquares\Favouriteseller\Model\ResourceModel;

class Test extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('marketplace_fevseller_details', 'id');   //here "marketplace_fevseller_details" is table name and "id" is the primary key of custom table
    }
}