<?php
/**
 * Copyright © Sellerbadge All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Dotsquares\Sellerbadge\Api\Data;

interface PostInterface
{

    const THUMBNAIL = 'thumbnail'; 
    const BADGE_NAME = 'badge_name';
    const BADGE_DESCRIPTIONS = 'badge_descriptions';
    const RANKS = 'ranks';
    const CREATED = 'created';
    const POST_ID = 'post_id';
    const ACTION = 'action';
    const SELLER_STATUS = 'seller_status';
    const SETPATH = 'setpath';
   


 /**
     * Get Badge_id
     * @return string|null
     */
    public function getBadgeId();

    /**
     * Set Badge_id
     * @param string $BadgeId 
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setBadgeId($postId);

    /**
     * Get name
     * @return string|null
     */
    public function getThumbnail();

    /**
     * Set name
     * @param string $name
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setThumbnail($thumbnail);

    /**
     * Get email
     * @return string|null
     */
    public function getBadgename();

    /**
     * Set email
     * @param string $email
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setBadgename($badgeName);

    /**
     * Get testimonial
     * @return string|null
     */
    public function getBadgedescriptions();

    /**
     * Set testimonial
     * @param string $testimonial
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setBadgedescriptions($badgeDescriptions);

    /**
     * Get product_name
     * @return string|null
     */
    public function getCreated();

    /**
     * Set product_name
     * @param string $productName
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setCreated($created);

    /**
     * Get image
     * @return string|null
     */
   
    /**
     * Get status
     * @return string|null
     */
    public function getSellerstatus();

    /**
     * Set status
     * @param string $status
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setSellerstatus($sellerStatus);

    /**
     * Get Badgeed_date
     * @return string|null
     */
   
    /**
     * Get action
     * @return string|null
     */
    public function getAction();

    /**
     * Set action
     * @param string $action
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setAction($action);
     /**
     * Get action
     * @return string|null
     */
   
    public function getRanks();

    /**
     * Set action
     * @param string $action
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setRanks($ranks);


    public function getPath();

    /**
     * Set name 
     * @param string $name
     * @return \Dotsquares\Sellerbadge\Badge\Api\Data\PostInterface
     */
    public function setPath($path);
   

}

