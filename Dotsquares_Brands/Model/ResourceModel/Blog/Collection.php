<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd
 */
namespace Dotsquares\Brands\Model\ResourceModel\Blog;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dotsquares\Brands\Model\Blog as BlogModel;
use Dotsquares\Brands\Model\ResourceModel\Blog as BlogResourceModel;
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(BlogModel::class, BlogResourceModel::class);
    }
}