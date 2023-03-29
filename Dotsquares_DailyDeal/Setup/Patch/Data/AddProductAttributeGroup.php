<?php declare(strict_types=1);
namespace Dotsquares\DailyDeal\Setup\Patch\Data;
use Magento\Catalog\Model\Config;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
class AddProductAttributeGroup implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * @var Config
     */
    private $magentoConfig;
    /**
     * Constructor
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        Config $magentoConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->magentoConfig = $magentoConfig;
    }
    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        // get default attribute set id
        $attributeSetId = $eavSetup->getDefaultAttributeSetId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeGroupName = "Daily Deals";
        $g_id = $this->magentoConfig->getAttributeGroupId($attributeSetId, $attributeGroupName);
        file_put_contents(__DIR__.'/tt', json_encode(['g_id' => $g_id, 'sid' => $attributeSetId, 'name'=>$attributeGroupName]));
        if (!$g_id) {
          $eavSetup->addAttributeGroup(
              \Magento\Catalog\Model\Product::ENTITY,
              $attributeSetId,
              $attributeGroupName,
              10 // sort order
          );
        }
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [
        ];
    }
}


