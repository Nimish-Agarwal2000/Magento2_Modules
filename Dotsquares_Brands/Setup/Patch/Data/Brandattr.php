<?php
namespace Dotsquares\Brands\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class Brandattr implements DataPatchInterface
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
        $statusOptions = 'Dotsquares\Brands\Model\Config\Source\Brandsname';
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute('catalog_product', 'brands', [
            'group' => 'Product Details',
            'type' => 'int',
            'label' => 'Brands',
            'sort_order' => 6,
            'input' => 'select',
            'used_in_product_listing' => true,
            'user_defined' => false,
            'source' => $statusOptions,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'unique' => false,
            'required' => false,
            'searchable' => true,
            'filterable' => true,
            'comparable' => true,
            
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