<?php

defined( 'ABSPATH' ) || exit;

extract( [
    'id'   => null,
    'name' => '',
    'url'  => '#'
], EXTR_SKIP );

if ( empty( $id ) ) return;

?>

<div class="card mb-4">
    <figure class="card-img-top">
        <?= get_the_post_thumbnail( $id, 'medium', [ 'class' => 'w-100' ] ) ?>
    </figure>
    <div class="card-body">
        <h5 class="card-title">
            <?= $name ?>
        </h5>

        <a href="<?= $url ?>" class="btn btn-danger btn-sm">
            <?= __( 'Найти в городе..', THEME_TEXT_PREFIX ) ?>
        </a>
    </div>
</div>
