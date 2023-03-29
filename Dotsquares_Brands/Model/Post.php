<?php
namespace Dotsquares\Brands\Model;
use Dotsquares\Brands\Api\Data\GridInterface;
class Post extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
	const CACHE_TAG = 'brands';

	protected $_cacheTag = 'brands';

	protected $_eventPrefix = 'brands';

	protected function _construct()
	{
		$this->_init('Dotsquares\Brands\Model\ResourceModel\Post');
	}
	/**
     * Get BrandId.
     *
     * @return int
     */
    public function getBrandId()
    {
        return $this->getData(self::BRAND_ID);
    }

    /**
     * Set BrandId.
     */
    public function setBrandId($BrandId)
    {
        return $this->setData(self::BRAND_ID, $BrandId);
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
     * Get Image.
     *
     * @return varchar
     */
    public function getImage()
	{
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image.
     */
    public function setImage($image)
	{
        return $this->setData(self::IMAGE, $image);
    }
	 public function getPath()
  {
    return $this->getData(self::PATH);
  }

  public function setPath($value)
  {
    return $this->setData(self::PATH, $value);
  }

  /**
     * Get sort detail.
     *
     * @return varchar
     */
    public function getSortDetail()
	{
        return $this->getData(self::SORT_DETAIL);
    }


    /**
     * Set sort detail.
     */
    public function setSortDetail($sortdetail){
        return $this->setData(self::SORT_DETAIL, $sortdetail);
    }
     /**
     * Get sort detail.
     *
     * @return varchar
     */
    public function getFullDetail()
	{
        return $this->getData(self::FULL_DETAIL);
    }


    /**
     * Set sort detail.
     */
    public function setFullDetail($fulldetail){
        return $this->setData(self::FULL_DETAIL, $fulldetail);
    }
}



