<?php

defined( 'ABSPATH' ) || exit;

global $post;

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

    </header><!-- .entry-header -->

    <figure class="my-5">
        <?= get_the_post_thumbnail( $post->ID, 'large', ['class' => 'img-thumbnail w-100'] ); ?>
    </figure>

    <div class="entry-content">

        <?php
            the_content();
            understrap_link_pages();
        ?>

        <h3 class="mt-5">Галерея</h3>
        <div class="my-3">
            <?php get_template_part( 'parts/object', 'gallery' ); ?>
        </div>

    </div><!-- .entry-content -->

    <footer class="entry-footer">

        <?php understrap_entry_footer(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
