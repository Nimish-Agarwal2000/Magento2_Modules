<?php
namespace Dotsquares\Brands\Model;

use Magento\Framework\Model\AbstractModel;

class Brand extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Dotsquares\Brands\Model\ResourceModel\Brand');
    }
}