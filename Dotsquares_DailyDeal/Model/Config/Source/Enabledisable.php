<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Dotsquares Pvt. Ltd.
 */
namespace Dotsquares\DailyDeal\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Enabledisable extends AbstractSource
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
                        ['label' => __('Disable'), 'value' => 0],
                        ['label' => __('Enable'), 'value' => 1]
                    ];
                    
                
        
        return $this->_options;
    }
}
    
      

    
      

}