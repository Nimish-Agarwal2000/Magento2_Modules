<?php

declare(strict_types=1);

namespace Dotsquares\Brands\Setup\Patch\Data;

use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Store\Model\Store;

class CreateCmsPage implements DataPatchInterface, PatchRevertableInterface
{
    const CMS_PAGE_IDENTIFIER = 'allbrand';

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param PageFactory $pageFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        PageFactory $pageFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        $this->pageFactory->create()
            ->setTitle('All Brands')
            ->setIdentifier(self::CMS_PAGE_IDENTIFIER)
            ->setIsActive(true)
            ->setPageLayout('1column')
            ->setContent('{{block class="Dotsquares\Brands\Block\Frontend\Brands" template="Dotsquares_Brands::dotsquares_brand.phtml"}}')
            ->setStores([Store::DEFAULT_STORE_ID])
            ->save();

        $this->moduleDataSetup->endSetup();
    }

    /**
     * {@inheritdoc}
     */
    public function revert()
    {
        $sampleCmsPage = $this->pageFactory
            ->create()
            ->load(self::CMS_PAGE_IDENTIFIER, 'identifier');

        if ($sampleCmsPage->getId()) {
            $sampleCmsPage->delete();
        }
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }
}