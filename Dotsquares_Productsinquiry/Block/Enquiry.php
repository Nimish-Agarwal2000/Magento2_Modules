<?php


namespace Dotsquares\Productsinquiry\Block;

class Enquiry extends \Magento\Framework\View\Element\Template
{

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    // getPathUrl() is a function that get base url. i.e. localhost or Domain Name

    public function getPathUrl() {
        //$this keyword use to refer the current object in the class
        return $this->getBaseUrl().'dotsquares/enquiry/news/';
    }
}