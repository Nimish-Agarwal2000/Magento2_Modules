<?php
namespace Dotsquares\Favouriteseller\Model\ResourceModel;

class Details extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $resourceConnection;
   
    protected $orderItemCollection;
    
    protected $connectionName = \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION;
  
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory $orderItemCollection,
        $connectionName = null
    ) {
        $this->resourceConnection       = $resourceConnection;
        $this->orderItemCollection      = $orderItemCollection;
        if ($connectionName !== null) {
            $this->connectionName = $connectionName;
        }
        parent::__construct($context, $connectionName);
    }
    
    protected function _construct()
    {
        $this->_init('marketplace_fevseller_details', 'id');
    }
   
    public function load(\Magento\Framework\Model\AbstractModel $object, $value, $field = null)
    {
        if (!is_numeric($value) && $field===null) {
            $field = 'identifier';
        }
        return parent::load($object, $value, $field);
    }
   
   
}
