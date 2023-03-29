<?php

/**
 * Grid Grid Model.
 * @category  Bhanu
 * @package   Bhanu_Grid
 * @author    Bhanu
 * @copyright Copyright (c) 2010-2017 Bhanu Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Dotsquares\Productsinquiry\Model;

use Dotsquares\Productsinquiry\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'dotsquares_products_inq';

    /**
     * @var string
     */
    protected $_cacheTag = 'dotsquares_products_inq';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'dotsquares_products_inq';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Dotsquares\Productsinquiry\Model\ResourceModel\Post');
    }
    /**
     * Get PostId.
     *
     * @return int
     */
    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * Set PostId.
     */
    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

	/**
     * Get Name.
     *
     * @return varchar
     */
    public function getName()
	{
        return $this->getData(self::NAME);
    }

    /**
     * Set Name.
     */
    public function setName($name)
	{
        return $this->setData(self::NAME, $name);
    }

	/**
     * Get Email.
     *
     * @return varchar
     */
    public function getEmail()
	{
        return $this->getData(self::EMAIL);
    }

    /**
     * Set Email.
     */
    public function setEmail($email)
	{
        return $this->setData(self::EMAIL, $email);
    }
	/**
     * Get Publish Date.
     *
     * @return varchar
     */
    public function getTelephone()
	{
        return $this->getData(self::TELEPHONE);
    }

    /**
     * Set PublishDate.
     */
    public function setTelephone($telephone)
	{
        return $this->setData(self::TELEPHONE, $telephone);
    }

	/**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getSubject()
	{
        return $this->getData(self::SUBJECT);
    }

    /**
     * Set StartingPrice.
     */
    public function setSubject($subject)
	{
        return $this->setData(self::SUBJECT, $subject);
    }


   public function getSku()
   {
	return $this->getData(self::SKU);
}

   /**
	* Set Url.
	*/
   public function setSku($sku)
   {
	return $this->setData(self::SKU, $sku);
}

/**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getProductName()
	{
		return $this->getData(self::PRODUCT_NAME);
	}

    /**
     * Set CreatedAt.
     */
    public function setProductName($productName)
	{
		return $this->setData(self::PRODUCT_NAME, $productName);
	}
    /**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getProductId()
	{
		return $this->getData(self::PRODUCT_Id);
	}

    /**
     * Set CreatedAt.
     */
    public function setProductId($productId)
	{
		return $this->setData(self::PRODUCT_ID, $productId);
	}
/**
     * Get CreatedAt.
     *
     * @return varchar
     */
    public function getMassage()
	{
		return $this->getData(self::MASSAGE);
	}

    /**
     * Set CreatedAt.
     */
    public function setMassage($massage)
	{
		return $this->setData(self::MASSAGE, $massage);
	}

 /**
    * Get CreatedAt.
    *
    * @return varchar
    */
   public function getProducturl()
   {
       return $this->getData(self::PRODUCTURL);
   }

   /**
    * Set CreatedAt.
    */
   public function setProducturl($producturl)
   {
       return $this->setData(self::PRODUCTURL, $producturl);
   }


}