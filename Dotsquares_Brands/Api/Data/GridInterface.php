<?php
/**
 * Dotsquares_Brands Grid Interface.
 *
 * @category    Dotsquares
 *
 * @author      Dotsquares Private Limited
 */
namespace Dotsquares\Brands\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const BRAND_ID    = 'brand_id';
    const NAME        = 'name';
    const IMAGE       = 'image';
    CONST PATH        = 'path';
    CONST SORT_DETAIL ='sort_detail';
    CONST FULL_DETAIL ='full_detail';
    /**
     * Get PostyId.
     *
     * @return int
     */
    public function getBrandId();

    /**
     * Set BrandId.
     */
    public function setBrandId($BrandId);

    /**
     * Get Name.
     *
     * @return varchar
     */
    public function getName();

    /**
     * Set Name.
     */
    public function setName($name);

    /**
     * Get Email.
     *
     * @return varchar
     */
    public function getImage();

    /**
     * Set Email.
     */
    public function setImage($image);

   

    public function getPath();

    public function setPath($value);

     /**
     * Get sort detail.
     *
     * @return varchar
     */
    public function getSortDetail();

    /**
     * Set sort detail.
     */
    public function setSortDetail($sortdetail);

    /**
     * Get full detail.
     *
     * @return varchar
     */
    public function getFullDetail();

    /**
     * Set full detail.
     */
    public function setFullDetail($fulldetail);
}