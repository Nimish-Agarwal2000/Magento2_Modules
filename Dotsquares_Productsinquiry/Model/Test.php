<?php
namespace Dotsquares\Productsinquiry\Model;

use Magento\Framework\Model\AbstractModel;

class Test extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Dotsquares\Productsinquiry\Model\ResourceModel\Test');
    }
}