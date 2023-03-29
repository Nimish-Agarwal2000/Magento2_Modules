<?php
namespace Dotsquares\Sellerbadge\Model\ResourceModel\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dotsquares\Sellerbadge\Model\Post as BlogModel;
use Dotsquares\Sellerbadge\ResourceModel\Post as BlogResourceModel;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'badge_id';
	protected $_eventPrefix = 'dotsquares_sellerbadge_badge_collection';
	protected $_eventObject = 'badge_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(BlogModel::class, BlogResourceModel::class);
		$this->_init('Dotsquares\Sellerbadge\Model\Post', 'Dotsquares\Sellerbadge\Model\ResourceModel\Post');
	}

}
















