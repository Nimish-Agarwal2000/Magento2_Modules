<?php
namespace Dotsquares\DailyDeal\Ui\DataProvider;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

use Magento\Framework\App\Request\DataPersistorInterface;

class DealEditPage extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $dataPersistor;
    protected $loadedData;
    protected $collection;
    protected $_currency;
	protected $_resource;
    protected $helper;
    protected $priceHelper;

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
        \Magento\Framework\Pricing\Helper\Data $priceHelper,
        \Magento\Directory\Model\Currency $currency,
        DataPersistorInterface $dataPersistor,
        \Dotsquares\DailyDeal\Helper\Data $helper,
		\Magento\Framework\App\ResourceConnection $Resource,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
		$this->request = $request;
        $this->dataPersistor = $dataPersistor;
        $this->_currency = $currency;
        $this->helper = $helper;
        $this->priceHelper = $priceHelper;
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
		$collection->addAttributeToFilter ('deal_from',['notnull'=> true]);
        $collection->addAttributeToFilter ('deal_to',['notnull'=> true]);
        $collection->addAttributeToFilter ('deal_value',['notnull'=> true]);
        
        //echo $collection->getSelect();    die('seller');
       	foreach($collection as $rma){
			$aryItem = array();
			$aryItem['entity_id'] = $rma->getId();
            $aryItem['name'] = $rma->getName();
            $status = $rma->getDailyDeal();
            if($status==1){
                $aryItem['daily_deal'] = "Enable";
            }else{
                $aryItem['daily_deal'] = "Disable";
            }
            if($rma->getDiscountType()=="percentage"){
                $price = (int)$rma->getPrice();
                $prices = $price/100*$rma->getDealValue();
                
                $prices = $this->priceHelper->currency((int)$prices, true, false);
                $aryItem['deal_price'] = $prices;
            }else{
                $prices = $rma->getDealValue();
                $prices = $this->priceHelper->currency((int)$prices, true, false);
                $aryItem['deal_price'] = $prices;
            }
            $aryItem['discount_type'] = $rma->getDiscountType();
            $aryItem['deal_from'] = $rma->getDealFrom();
            $aryItem['deal_to'] = $rma->getDealTo();
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
    public function getCurrencySymbol() {
        return $this->_currency->getCurrencySymbol ();
    }
}



 