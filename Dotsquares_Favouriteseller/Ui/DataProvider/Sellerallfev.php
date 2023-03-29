<?php
namespace Dotsquares\Favouriteseller\Ui\DataProvider;

use Dotsquares\Favouriteseller\Model\ResourceModel\Blog\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class Sellerallfev extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $dataPersistor;
    protected $loadedData;
    protected $collection;
	protected $_resource;
    protected $fevsellerHelper;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
		\Magento\Framework\App\Request\Http $request,
        DataPersistorInterface $dataPersistor,
        \Dotsquares\Favouriteseller\Helper\Data $fevsellerHelper,
		\Magento\Framework\App\ResourceConnection $Resource,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
		$this->request = $request;
        $this->dataPersistor = $dataPersistor;
        $this->fevsellerHelper = $fevsellerHelper;
		$this->_resource = $Resource;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {	
        $customerId = $this->fevsellerHelper->getCustomerId();
        // $customerId = 1;
		$rmaCollection = $this->collection
								->addFieldToSelect("*")
								->addFieldToFilter("seller_id",$customerId);
        //echo $rmaCollection->getSelect();    die('seller');
       	foreach($rmaCollection as $rma){
			$aryItem = array();
			$aryItem['id'] = $rma->getId();
            $aryItem['customer_name'] = $rma->getCustomerName();
            $aryItem['added_at'] = $rma->getAddedAt();
            
			$this->loadedData[] = $aryItem;			
		}
		$ary = array();
		$ary['totalRecords'] = $rmaCollection->getSize();
		$ary['items'] = $this->loadedData;
        return $ary;
    }
}
