<?php
namespace Dotsquares\Favouriteseller\Model;

use Dotsquares\Favouriteseller\Api\Data\DetailsInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Details extends AbstractModel implements DetailsInterface, IdentityInterface
{
    const NOROUTE_ENTITY_ID = 'no-route';

    const CACHE_TAG = 'favouriteseller_details';

    protected $_cacheTag = 'favouriteseller_details';

    protected $_eventPrefix = 'favouriteseller_details';

    protected function _construct()
    {
        $this->_init(\Dotsquares\Favouriteseller\Model\ResourceModel\Details::class);
    }

    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteDetails();
        }
        return parent::load($id, $field);
    }

    public function noRouteDetails()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }
}
