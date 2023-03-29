<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: MageDelight Pvt. Ltd
 */
namespace Dotsquares\Sellerbadge\Model;
use Magento\Framework\Model\AbstractModel;
use Dotsquares\Sellerbadge\Model\ResourceModel\Badge as BadgeResourceModel;
class Badge extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(BadgeResourceModel::class);
    }
}