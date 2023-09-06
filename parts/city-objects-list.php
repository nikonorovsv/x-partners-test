<?php

defined( 'ABSPATH' ) || exit;

$cityId = get_queried_object_id();

?>

<div class="row">
    <?php

    $objects = new WP_Query([
        'post_type'      => 'real_estate_object',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => max(1, get_query_var('paged')),
        'meta_query' => [
            [
                'key'   => 'city_id',
                'value' => $cityId
            ]
        ]
    ]);
    if ($objects->have_posts()) {
        while ($objects->have_posts()) {
            $objects->the_post(); ?>

            <div class="col-md-3 col-sm-6 col-lg-4">
                <?php get_template_part('parts/object', 'card'); ?>
            </div>

            <?php
        }
        wp_reset_postdata();
    } else { ?>

        <p><?= __( 'Нет объектов для этого города.', THEME_TEXT_PREFIX ) ?></p>

        <?php
    } ?>
</div>

<?php
// Display the pagination component.
understrap_pagination(['total' => $objects->max_num_pages]);


