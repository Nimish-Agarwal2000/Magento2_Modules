<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\Productsinquiry\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Blog extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dotsquares_products_inq', 'post_id');
    }
}