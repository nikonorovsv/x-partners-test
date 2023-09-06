<?php

defined( 'ABSPATH' ) || exit;

?>

<div class="row">
    <?php

    $objects = new WP_Query([
        'post_type'      => 'real_estate_object',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
    ]);

    while ($objects->have_posts()) {
        $objects->the_post(); ?>

        <div class="col-md-3 col-sm-6">
            <?php get_template_part('parts/object', 'card'); ?>
        </div>

        <?php
    }
    wp_reset_postdata();

    ?>
</div>


