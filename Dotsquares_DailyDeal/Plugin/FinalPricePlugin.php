<?php
namespace Dotsquares\DailyDeal\Plugin;

class FinalPricePlugin
{
    public function beforeSetTemplate(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject, $template)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $enable=$objectManager->create('Dotsquares\DailyDeal\Helper\Data')->getDailyDealEnable();
        if ($enable) {
            if ($template == 'Magento_Catalog::product/price/final_price.phtml') {
                return ['Dotsquares_DailyDeal::product/price/final_price.phtml'];
            } 
            else
            {
                return [$template];
            }
        } else {
            return[$template];
        }
    }
}