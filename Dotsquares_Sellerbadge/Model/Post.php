<?php
namespace Dotsquares\Sellerbadge\Model;
use Dotsquares\Sellerbadge\Api\Data\PostInterface;
class Post extends \Magento\Framework\Model\AbstractModel implements PostInterface
{
	const CACHE_TAG = 'dotsquares_sellerbadge_post';

	protected $_cacheTag = 'dotsquares_sellerbadge_post';

	protected $_eventPrefix = 'dotsquares_sellerbadge_post';

	protected function _construct()
	{
		$this->_init('Dotsquares\Sellerbadge\Model\ResourceModel\Post');
	}
	/**
     * Get BrandId.
     *
     * @return int
     */
    public function getBadgeId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * Set BrandId.
     */
    public function setBadgeId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

	/**
     * Get Name.
     *
     * @return varchar
     */
    public function getThumbnail()
	{
        return $this->getData(self::THUMBNAIL);
    }

    /**
     * Set Name.
     */
    public function setThumbnail($thumbnail)
	{
        return $this->setData(self::THUMBNAIL, $thumbnail);
    }

	/**
     * Get Email.
     *
     * @return varchar
     */
    public function getBadgeName()
	{
        return $this->getData(self::BADGE_NAME);
    }

    /**
     * Set Email.
     */
    public function setBadgeName($badgeName)
	{
        return $this->setData(self::BADGE_NAME, $badgeName);
    }
    public function getBadgedescriptions()
	{
        return $this->getData(self::BADGE_DESCRIPTIONS);
    }

    /**
     * Set Name.
     */
    public function setBadgedescriptions($badgeDescriptions)
	{
        return $this->setData(self::BADGE_DESCRIPTIONS, $badgeDescriptions);
    }


    public function getCreated()
	{
        return $this->getData(self::CREATED);
    }

    /**
     * Set Name.
     */
    public function setCreated($created)
	{
        return $this->setData(self::CREATED, $created);
    }

    public function getSellerstatus()
	{
        return $this->getData(self::SELLER_STATUS);
    }

    /**
     * Set Name.
     */
    public function setSellerstatus($sellerStatus)
	{
        return $this->setData(self::SELLER_STATUS, $sellerStatus);
    }



    public function getAction()
	{
        return $this->getData(self::ACTION);
    }

    /**
     * Set Name.
     */
    public function setAction($action)
	{
        return $this->setData(self::ACTION, $action);
    }


    public function getRanks()
	{
        return $this->getData(self::RANKS);
    }

    /**
     * Set Name.
     */
    public function setRanks($ranks)
	{
        return $this->setData(self::RANKS, $ranks);
    }


    public function getPath()
	{
        return $this->getData(self::SETPATH);
    }

    /**
     * Set Name.
     */
    public function setPath($path)
	{
        return $this->setData(self::SETPATH, $path);
    }




}



