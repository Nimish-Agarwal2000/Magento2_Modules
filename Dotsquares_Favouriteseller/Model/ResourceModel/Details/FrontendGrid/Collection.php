<?php
namespace Dotsquares\Favouriteseller\Model\ResourceModel\Details\FrontendGrid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Dotsquares\Favouriteseller\Model\ResourceModel\Details\Collection as DetailsCollection;

class Collection extends DetailsCollection implements SearchResultInterface
{
    protected $aggregations;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entity,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $event,
        \Magento\Store\Model\StoreManagerInterface $store,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null,
        $eventPrefix,
        $mainTable,
        $eventObject,
        $resourceModel,
        \Magento\Customer\Model\Session $customerSession
    ) {
        parent::__construct($entity, $logger, $fetchStrategy, $event, $store, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->setMainTable($mainTable);
        $this->_eventObject = $eventObject;
        $this->_init(\Magento\Framework\View\Element\UiComponent\DataProvider\Document::class, $resourceModel);
        $this->_customerSession = $customerSession;
    }

    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setItems(array $items = null)
    {
        return $this;
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    protected function _renderFiltersBefore()
    {
        $customerId = $this->_customerSession->getCustomer()->getId();
        $this->getSelect()->group("main_table.id");
        $this->addFieldToFilter('seller_id', ['eq' => $customerId]);
        parent::_renderFiltersBefore();
    }
}
