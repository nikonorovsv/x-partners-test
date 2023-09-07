<?php

namespace theme\ajax_handlers;

use theme\core\AjaxHandler;

class RealEstateObject extends AjaxHandler {
    const ACTION = 'real-estate-object';

    const PUBLIC = true;

    public function createHandler() {
        $name       = $this->getStringQueryVar('name');
        $desc       = $this->getStringQueryVar('desc');
        $area       = $this->getIntQueryVar('area');
        $livingArea = $this->getIntQueryVar('living_area');
        $price      = $this->getIntQueryVar('price');
        $address    = $this->getStringQueryVar('address');
        $floor      = $this->getIntQueryVar('floor');
        $author     = $this->getIntQueryVar('author');

        $postId = wp_insert_post([
            'post_type'    => 'real_estate_object',
            'post_title'   => $name,
            'post_content' => $desc,
            'post_status'  => 'publish', // pending
            'post_author'  => $author,
        ]);

        update_field('area', $area, $postId);
        update_field('living_area', $livingArea, $postId);
        update_field('price', $price, $postId);
        update_field('address', $address, $postId);
        update_field('floor', $floor, $postId);

        $this->addResponseParam( 'url', get_permalink( $postId ) );
    }
}