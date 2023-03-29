<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Productattribute implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;

    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $statusOptions = 'Dotsquares\DailyDeal\Model\Config\Source\Enabledisable';
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'daily_deal', [ 
            'group' => 'Daily Deals',
            'type' => 'int',
            'label' => 'Deal Status',
            'sort_order' => 1,
            'input' => 'select',
            'used_in_product_listing' => false,
            'user_defined' => false,
            'source' => $statusOptions,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'unique' => false,
            'required' => false,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'is_used_in_grid'            => true
            
        ]);
        $discounttype = 'Dotsquares\DailyDeal\Model\Config\Source\PercentFixed';
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'discount_type', [
            'group' => 'Daily Deals',
            'type' => 'text',
            'label' => 'Discount Type',
            'sort_order' => 2,
            'input' => 'select',
            'used_in_product_listing' => false,
            'user_defined' => false,
            'source' => $discounttype,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'unique' => false,
            'required' => false,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            'is_used_in_grid'            => true
            
        ]);
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'deal_from', [
            'group' => 'Daily Deals',
            'type' => 'datetime',
            'label' => 'Deal From',
            'sort_order' => 3,
            'input' => 'datetime',
            'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
            'frontend' => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime',
            'frontend_class' => 'starting_date',
            'class' => '',
            'source' => '',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible'                    => true,
            'searchable'                 => true,
            'filterable'                 => false,
            'comparable'                 => false,
            'required'                   => false,
            'used_for_sort_by'           => true,
            'is_configurable'            => false,
            'visible_on_front'           => false,
            'visible_in_advanced_search' => false,
            'used_in_product_listing'    => true,
            'user_defined' => false,
            'unique' => false,
            'default' => "",
            'is_used_in_grid' => true,
            'apply_to' => ''
           
               ]);
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'deal_to', [
            'group' => 'Daily Deals',
            'type' => 'datetime',
            'label' => 'Deal To',
            'sort_order' => 4,
            'input' => 'datetime',
            'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\Datetime',
            'frontend' => 'Magento\Eav\Model\Entity\Attribute\Frontend\Datetime',
            'frontend_class' => 'starting_date',
            'class' => '',
            'source' => '',
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible'                    => true,
            'searchable'                 => true,
            'filterable'                 => false,
            'comparable'                 => false,
            'required'                   => false,
            'used_for_sort_by'           => true,
            'is_configurable'            => false,
            'visible_on_front'           => false,
            'visible_in_advanced_search' => false,
            'used_in_product_listing'    => true,
            'user_defined' => false,
            'unique' => false,
            'default' => "",
            'is_used_in_grid' => true,
            'apply_to' => ''
           
           
            
            
            
        ]);
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'deal_value', [
            'group' => 'Daily Deals',
            'type' => 'int',
            'label' => 'Deal Value',
            'sort_order' => 5,
            'input' => 'text',
            'backend' => '',
            'frontend' => '',
            'frontend_class' => 'validate-greater-than-zero validate-digits validate-length maximum-length-5',
            'class' => '',
            'source' => '',
            'used_in_product_listing' => true,
            'user_defined' => false,
            'global' =>  \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'unique' => false,
            'required' => false,
            'searchable' => true,
            'default' => 0,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => false,
            'is_used_in_grid' => true,
            'apply_to' => ''
 
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}