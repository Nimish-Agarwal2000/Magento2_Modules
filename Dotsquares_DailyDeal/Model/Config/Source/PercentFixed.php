<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class PercentFixed extends AbstractSource
{
 protected $collection;
     /* Brands options
     *
     * @var array
     */
    protected $_options = null;

    public function __construct
    (
        
        $data = []
    ) 
    {
        
        
    }
    

    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            // $this->_options = [];
           
            
                
                    
                    $this->_options = [
                        ['label' => __('Percentage'), 'value' => "percentage"],
                        ['label' => __('Fixed'), 'value' => "fixed"]
                    ];
                    
                
        
        return $this->_options;
    }
}
    
      

    
      

}