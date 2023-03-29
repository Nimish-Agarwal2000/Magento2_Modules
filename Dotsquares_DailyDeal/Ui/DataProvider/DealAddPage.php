<?php
namespace Dotsquares\DailyDeal\Ui\DataProvider;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

use Magento\Framework\App\Request\DataPersistorInterface;

class DealAddPage extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $dataPersistor;
    protected $loadedData;
    protected $collection;
	protected $_resource;
    protected $helper;

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
        \Dotsquares\DailyDeal\Helper\Data $helper,
		\Magento\Framework\App\ResourceConnection $Resource,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
		$this->request = $request;
        $this->dataPersistor = $dataPersistor;
        $this->helper = $helper;
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
        $customerId = $this->helper->getCustomerId();
        // $customerId = 1;
		$collection = $this->collection;
        $collection->addFieldToFilter("seller_id",$customerId);
        $collection ->addAttributeToFilter(array (
            
            array('attribute'=> 'deal_to', 'null' => true),
        array('attribute'=> 'deal_from', 'null' => true),
        array('attribute'=> 'deal_value', 'null' =>true)
        ));
        
        
        //echo $collection->getSelect();    die('seller');
       	foreach($collection as $rma){
			$aryItem = array();
			$aryItem['entity_id'] = $rma->getId();
            $aryItem['name'] = $rma->getName();
            $aryItem['sku'] = $rma->getSku();
            $aryItem['image'] = $rma->getImage();
            $aryItem['thumbnail'] = $rma->getThumbnail();
            $aryItem['price'] = $rma->getPrice();
            // $aryItem['added_at'] = $rma->getAddedAt();
            
			$this->loadedData[] = $aryItem;			
		}
		$ary = array();
		$ary['totalRecords'] = $collection->getSize();
		$ary['items'] = $this->loadedData;
        return $ary;
    }
}
