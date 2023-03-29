<?php
/**
 * Dotsquares_Productsinquiry Grid Interface.
 *
 * @category    Dotsquares
 *
 * @author      Dotsquares Software Private Limited
 */
namespace Dotsquares\Productsinquiry\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const POST_ID = 'post_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const TELEPHONE = 'telephone';
    const SUBJECT = 'subject';
    const SKU = 'sku';
    const PRODUCT_NAME = 'product_name';
    const PRODUCT_ID = 'product_id';
    const MASSAGE = 'massage';
    const PRODUCTURL ='producturl';

    /**
     * Get PostyId.
     *
     * @return int
     */
    public function getPostId();

    /**
     * Set PostId.
     */
    public function setPostId($postId);

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
    public function getEmail();

    /**
     * Set Email.
     */
    public function setEmail($email);

    /**
     * Get Telephone.
     *
     * @return number
     */
    public function getTelephone();

    /**
     * Set Telephone.
     */
    public function setTelephone($telephone);

    /**
     * Get Subject.
     *
     * @return varchar
     */
    public function getSubject();

    /**
     * Set Subject.
     */
    public function setSubject($subject);

    /**
     * Get Sku.
     *
     * @return varchar
     */
     /**
     * @return varchar
     */
    public function getSku();

    /**
     * Set Sku.
     */
    public function setSku($sku);
    /**
     * Get ProductName.
     *
     * @return varchar
     */
    public function getProductName();

    /**
     * Set ProductName.
     */
    public function setProductName($productName);

    /**
     * Get ProductId.
     *
     * @return varchar
     */
    public function getProductId();

    /**
     * Set ProductId.
     */
    public function setProductId($productId);

    /**
     * Get Massage.
     *
     * @return varchar
     */
    public function getMassage();

    /**
     * Set Massage.
     */
    public function setMassage($massage);

     /**
     * Get Producturl.
     *
     * @return varchar
     */


    public function getProducturl();

    /**
     * Set Producturl.
     */
    public function setProducturl($producturl);
}