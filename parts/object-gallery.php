<?php

defined( 'ABSPATH' ) || exit;

global $post;

$images = get_field( 'gallery', $post->ID );

if (empty($images)) {
    echo '<p>Изображения не загружены.</p>';

    return;
}

?>

<div id="object-gallery" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php for ( $i=0; $i<count($images); $i++ ) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>"<?= !$i ? ' class="active"' : '' ?>></li>
        <?php } ?>
    </ol>
    <div class="carousel-inner">
        <?php

        $i = 0;
        foreach ($images as $url) { ?>

            <div class="carousel-item<?= !$i ? ' active' : '' ?>">
                <img class="d-block w-100" src="<?= esc_url($url) ?>" alt="<?= $i+1 ?> slide">
            </div>

            <?php
            $i++;
        } ?>
    </div>
    <a class="carousel-control-prev" href="#object-gallery" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">
            <?= __( 'Предыдущая', THEME_TEXT_PREFIX ) ?>
        </span>
    </a>
    <a class="carousel-control-next" href="#object-gallery" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">
            <?= __( 'Следующая', THEME_TEXT_PREFIX ) ?>
        </span>
    </a>
</div>
