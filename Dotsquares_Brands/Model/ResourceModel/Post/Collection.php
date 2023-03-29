<?php
namespace Dotsquares\Brands\Model\ResourceModel\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dotsquares\Brands\Model\Post as BlogModel;
use Dotsquares\Brands\ResourceModel\Post as BlogResourceModel;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'brand_id';
	protected $_eventPrefix = 'dotsquares_brands_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(BlogModel::class, BlogResourceModel::class);
		$this->_init('Dotsquares\Brands\Model\Post', 'Dotsquares\Brands\Model\ResourceModel\Post');
	}

}
