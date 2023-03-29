<?php

namespace Dotsquares\Brands\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Brandsname extends AbstractSource
{
 protected $brand;
 protected $collection;
     /* Brands options
     *
     * @var array
     */
    protected $_options = null;

    public function __construct
    (
        
        \Dotsquares\Brands\Model\Brand $brand,
        $data = []
    ) 
    {
        $this->brand = $brand;
        
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
            $this->_options[] = [
                    
                'label' => 'No Any Brand',
                'value'=> ""
                
            ];
            foreach ($this->brand->getCollection()as $group) {
                $this->_options[] = [
                    
                    'label' => $group['name'],
                    'value'=>$group['brand_id']
                    
                ];
        }
        return $this->_options;
    }
}
    
      

    
      

}