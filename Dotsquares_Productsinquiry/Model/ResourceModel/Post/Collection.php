<?php
namespace Dotsquares\Productsinquiry\Model\ResourceModel\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dotsquares\Productsinquiry\Model\Post as BlogModel;
use Dotsquares\Productsinquiry\ResourceModel\Post as BlogResourceModel;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'post_id';
	protected $_eventPrefix = 'dotsquares_products_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(BlogModel::class, BlogResourceModel::class);
		$this->_init('Dotsquares\Productsinquiry\Model\Post', 'Dotsquares\Productsinquiry\Model\ResourceModel\Post');
	}

}
