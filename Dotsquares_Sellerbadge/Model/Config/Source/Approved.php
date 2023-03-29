<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Dotsquares\Sellerbadge\Model\Config\Source;

/**
 * Source model for element with enable and disable variants.
 * @api
 * @since 100.0.2
 */
class Approved implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Value which equal Enable for Enabledisable dropdown.
     */
    const Approved = "Approved";

    /**
     * Value which equal Disable for Enabledisable dropdown.
     */
    const Pending = "Pending";

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => "Approved", 'label' => __('Approved')], ['value' => "Pending", 'label' => __('Pending')]];
    }
}
