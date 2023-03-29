<?php

namespace Dotsquares\Sellerbadge\Ui\Component\MassAction\Status;

use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;

class BadgesAssignOption implements \JsonSerializable
{
    protected $options;
    protected $data;
    protected $urlBuilder;
    protected $urlPath;
    protected $paramName;
    protected $badge;
    protected $additionalData = [];

    public function __construct(
        \Dotsquares\Sellerbadge\Model\Badge $badge,
        UrlInterface $urlBuilder,
        array $data = []
    )
    {
        $this->badge = $badge;
        $this->data = $data;
        $this->urlBuilder = $urlBuilder;
    }

    public function jsonSerialize() : mixed
    {
        if ($this->options === null) {
           $collection = $this->badge->getCollection();
           $a=0;
            if(count($collection) >= 1){
                foreach ($collection as $group) {
                    if($group['seller_status']=="Approved"){
                        $a++;
                    $options[] = [
                        'value'=>$group['badge_id'],
                        'label' => $group['badge_name']
                        
                        
                    ];
                }
                }
                     
        if($a >= 1){
            $this->prepareData();
            foreach ($options as $optionCode) {
                $this->options[$optionCode['value']] = [
                    'type' => 'change_status_' . $optionCode['value'],
                    'label' => __($optionCode['label']),
                    '__disableTmpl' => true
                ];

                if ($this->urlPath && $this->paramName) {
                    $this->options[$optionCode['value']]['url'] = $this->urlBuilder->getUrl(
                        $this->urlPath,
                        [$this->paramName => $optionCode['value']]
                    );
                }

                $this->options[$optionCode['value']] = array_merge_recursive(
                    $this->options[$optionCode['value']],
                    $this->additionalData
                );
            }
        
            $this->options = array_values($this->options);
        }
    }
        return $this->options;
    }
}

    protected function prepareData()
    {
        foreach ($this->data as $key => $value) {
            switch ($key) {
                case 'urlPath':
                    $this->urlPath = $value;
                    break;
                case 'paramName':
                    $this->paramName = $value;
                    break;
                case 'confirm':
                    foreach ($value as $messageName => $message) {
                        $this->additionalData[$key][$messageName] = (string)new Phrase($message);
                    }
                    break;
                default:
                    $this->additionalData[$key] = $value;
                    break;
            }
        }
    }
}