<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details
 *
 * Created By: MageDelight Pvt. Ltd.
 */
namespace Dotsquares\Sellerbadge\Block\Adminhtml\Index\Edit\Button;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
class Delete extends Generic implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        $badge_id = $this->context->getRequest()->getParam('badge_id');
        if ($badge_id) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 9,
            ];
        }
        return $data;
    }
    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $badge_id = $this->context->getRequest()->getParam('badge_id');
        return $this->getUrl('*/*/delete', ['badge_id' => $badge_id]);
    }
}