<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\Favouriteseller\Model;
use Magento\Framework\Model\AbstractModel;
use Dotsquares\Favouriteseller\Model\ResourceModel\Blog as BlogResourceModel;
class Blog extends \Magento\Framework\Model\AbstractModel
{
     /**
     * @var string
     */
    protected $_cacheTag = 'customer_comment';

    /**
     * @var string
     */
    protected $_eventPrefix = 'customer_comment';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}