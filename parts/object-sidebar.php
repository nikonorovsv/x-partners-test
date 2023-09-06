<?php

defined( 'ABSPATH' ) || exit;

global $post;

?>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title font-weight-bold">Цена</h5>
        <div class="h5">
            <span class="font-weight-bold display-4 text-success">
                <?= get_field( 'price', $post->ID ) ?>
            </span>
            <span>руб.</span>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title font-weight-bold">Характеристики</h5>
        <div class="card-text">
            <?php get_template_part( 'parts/object', 'description' ); ?>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title font-weight-bold">Адрес</h5>
        <div class="card-text">
            <address>
                <?= get_field( 'address', $post->ID ) ?>
            </address>
        </div>
    </div>
</div>