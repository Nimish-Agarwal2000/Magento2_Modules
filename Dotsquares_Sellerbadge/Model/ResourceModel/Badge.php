<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\Sellerbadge\Model\ResourceModel;

class Badge extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('marketplace_sellerbadge', 'badge_id');   //here "vky_test" is table name and "test_id" is the primary key of custom table
    }
}