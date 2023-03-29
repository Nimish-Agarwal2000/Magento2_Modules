<?php
namespace Dotsquares\Sellerbadge\Model\ResourceModel\Badge;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Dotsquares\Sellerbadge\Model\Badge',
            'Dotsquares\Sellerbadge\Model\ResourceModel\Badge'
        );
    }
}