<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquaress Pvt. Ltd.
 */
namespace Dotsquares\Productsinquiry\Block\Adminhtml\Index\Edit\Button;
use Magento\Backend\Block\Widget\Context;
use Magento\Setup\Module\Di\Code\Reader\ClassesScanner;
/**
 * Class Generic
 */
class Generic extends ClassesScanner
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
     * Return model ID
     *
     * @return int|null
     */
    public function getModelId()
    {
        return $this->context->getRequest()->getParam('post_id');
    }
    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}