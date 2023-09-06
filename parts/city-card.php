<?php

defined( 'ABSPATH' ) || exit;

global $post;

?>

<div class="card mb-4">
    <figure class="card-img-top">
        <?= get_the_post_thumbnail($post, 'medium', ['class' => 'w-100']) ?>
    </figure>
    <div class="card-body">
        <h5 class="card-title">
            <?= get_the_title($post) ?>
        </h5>

        <a href="<?= get_permalink($post) ?>" class="btn btn-danger btn-sm">
            <?= __( 'Найти в городе..', THEME_TEXT_PREFIX ) ?>
        </a>
    </div>
</div>
