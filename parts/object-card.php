<?php

defined( 'ABSPATH' ) || exit;

global $post;

?>

<div class="card mb-4">
    <figure class="card-img-top">
        <?= get_object_thumbnail($post->ID, 'medium', ['class' => 'w-100']) ?>
    </figure>
    <div class="card-body">
        <h5 class="card-title">
            <?= get_the_title($post) ?>
        </h5>
        <p class="card-text">
            <span class="lead font-weight-bold text-success">
                <?= get_field( 'price', $post->ID ) ?>
            </span>
            <span>
                руб.
            </span>
        </p>
        <a href="<?= get_permalink($post) ?>" class="btn btn-primary">
            <?= __( 'Подробнее..', THEME_TEXT_PREFIX ) ?>
        </a>
    </div>
</div>