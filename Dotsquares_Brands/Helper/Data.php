<?php

namespace Dotsquares\Brands\Helper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
   
    /**
     * An array list of valid contact types.
     * 
     * @var array
     */
   
    /**
     * Admin configuration paths
     *
     */
    const BRAND_ENABLE              = 'brands/general/enable';
    const CMS_PAGE                  = 'brands/general/cms_page';
    const BRAND_TITLE               = 'brands/general/brands_item_label';
    const POP_UP                    = 'brands/general/show_brands_list_popup';
    const P_P_B_LOGO                = 'brands/product_page_brand_settings/show_logo_on_product_page';
    const P_P_B_S_DISCRAPTION       = 'brands/product_page_brand_settings/show_sortdescription_on_product_page';
    const P_P_B_L_WIDTH             = 'brands/product_page_brand_settings/brand_logo_width';
    const P_P_B_L_HEIGHT            = 'brands/product_page_brand_settings/brand_logo_height';
    const POPUP_P_LOGO_ENAB         = 'brands/popup_configuration/show_brands_logo';
    const POPUP_P_LOGO_WIDTH        = 'brands/popup_configuration/logo_width';
    const POPUP_P_LOGO_HEIGHT       = 'brands/popup_configuration/logo_height';
    const POPUP_P_FILTER_ENAB       = 'brands/popup_configuration/enable_filter_character';
    const POPUP_P_CHARACTOR_W_B     = 'brands/popup_configuration/show_character_brand';
    const POPUP_P_CHARACTOR_WB      = 'brands/popup_configuration/show_chaacter_brand';
    const P_L_P_B_LOGO              = 'brands/product_listing_brand_settings/show_logo_on_product_listing';
    CONST P_L_P_B_LOGO_WIDTH        = 'brands/product_listing_brand_settings/brand_logo_width_on_product_listing';
    CONST P_L_P_B_LOGO_HEIGHT       = 'brands/product_listing_brand_settings/brand_logo_height_on_product_listing';
    CONST P_L_P_B_S_DISCRAPTION     = 'brands/product_listing_brand_settings/show_sortdescription_on_product_listing_page';
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
 
    /**
     * Data constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
            
    }
    /**
     *  brand module enable or disable
     */
    public function getBrandEnable()
    {
        return $this->scopeConfig->getValue(self::BRAND_ENABLE, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     *  get cms page 
     */
    public function getButtonLavel()
    {
        return $this->scopeConfig->getValue(self::BRAND_TITLE, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     *  get cms page 
     */
    public function getCmspage()
    {
        return $this->scopeConfig->getValue(self::CMS_PAGE, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     *  pop up enable or disable
     */
    public function getPopUp()
    {
        return $this->scopeConfig->getValue(self::POP_UP, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
     /**
     *  prpduct page brand logo enable or disable
     */
    public function getPPBLogo()
    {
        return $this->scopeConfig->getValue(self::P_P_B_LOGO, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
      /**
     *  prpduct page brand logo width
     */
    public function getPPBLogoWidth()
    {
        return $this->scopeConfig->getValue(self::P_P_B_L_WIDTH, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     *  prpduct page brand logo height
     */
    public function getPPBLogoHeight()
    {
        return $this->scopeConfig->getValue(self::P_P_B_L_HEIGHT, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

      /**
     *  prpduct listing page brand logo enable or disable
     */
    public function getPLPBLogo()
    {
        return $this->scopeConfig->getValue(self::P_L_P_B_LOGO, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
      /**
     *  prpduct listing page brand logo width
     */
    public function getPLPBLogoWidth()
    {
        return $this->scopeConfig->getValue(self::P_L_P_B_LOGO_WIDTH, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     *  prpduct listing page brand logo height
     */
    public function getPLPBLogoHeight()
    {
        return $this->scopeConfig->getValue(self::P_L_P_B_LOGO_HEIGHT, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
     /**
     *  prpduct page brand sort descraption enable or disable
     */
    public function getPPBSDescription()
    {
        return $this->scopeConfig->getValue(self::P_P_B_S_DISCRAPTION, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getPLPBSDescription()
    {
        return $this->scopeConfig->getValue(self::P_L_P_B_S_DISCRAPTION, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    
}
