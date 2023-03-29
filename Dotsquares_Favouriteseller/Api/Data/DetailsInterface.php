<?php
namespace Dotsquares\Favouriteseller\Api\Data;

/**
 * Favouriteseller DetailsInterface.
 * @api
 */
interface DetailsInterface
{

    const ENTITY_ID = 'id';
    /**#@-*/

    public function getId();

    public function setId($id);
}
