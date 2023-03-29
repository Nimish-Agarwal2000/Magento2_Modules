<?php

namespace Dotsquares\DailyDeal\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;

class Deleteattribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $eavSetupFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        
        
        
        
        
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'daily_deal');
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'discount_type');
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'deal_from');
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'deal_to');
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'deal_value');

        $this->moduleDataSetup->endSetup();
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}
