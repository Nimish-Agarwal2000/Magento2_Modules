<?php

namespace Dotsquares\DailyDeal\Ui\DataProvider\Product\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;

class Dealfrom extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier
{
    /**
     * @var ArrayManager
     * @since 101.0.0
     */
    protected $arrayManager;

    public function __construct(
        ArrayManager $arrayManager
    ) {
        $this->arrayManager = $arrayManager;
    }

    public function modifyMeta(array $meta)
    {
        $meta = $this->customizeFieldSub($meta);

        return $meta;
    }

    public function modifyData(array $data)
    {
        return $data;
    }
  
    protected function customizeFieldSub(array $meta)
    {
        $weightPath = $this->arrayManager->findPath('deal_from', $meta, null, 'children');

        if ($weightPath) {
            $meta = $this->arrayManager->merge(
                $weightPath . static::META_CONFIG_PATH,
                $meta,
                [
                    'dataScope' => 'deal_from',
                    'validation' => [
                        'required-entry' => true
                        
                    ],
                    'additionalClasses' => 'admin__field-small',
                    'imports' => [
                        'disabled' => '${$.provider}:' . self::DATA_SCOPE_PRODUCT
                            . '.daily_deal:value'
                    ]
                ]
            );
        }
        return $meta;
    }
}