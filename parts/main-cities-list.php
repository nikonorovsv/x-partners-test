<?php

defined( 'ABSPATH' ) || exit;

?>

<div class="row">
    <?php

    $objects = new WP_Query([
        'post_type'      => 'city',
        'post_status'    => 'publish',
        'posts_per_page' => 6,
    ]);

    while ($objects->have_posts()) {
        $objects->the_post(); ?>

        <div class="col-md-2 col-sm-4">
            <?php get_template_part('parts/city', 'card'); ?>
        </div>

        <?php
    }
    wp_reset_postdata();

    ?>
</div>


