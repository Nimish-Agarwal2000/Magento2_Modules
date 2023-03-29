<?php
namespace Dotsquares\Brands\Setup;
 
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
class Uninstall implements \Magento\Framework\Setup\UninstallInterface
{
    private $eavSetupFactory;
 
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
     
    public function uninstall(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $setup->startSetup();
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'brands');
         
        $setup->endSetup();
    }
}