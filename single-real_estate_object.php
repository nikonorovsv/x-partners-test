<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

    <div class="wrapper" id="single-wrapper">
        <main class="site-main <?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
            <div class="row">
                <div class="col-md-8">
                    <?php
                    while ( have_posts() ) {
                        the_post();
                        get_template_part( 'parts/object', 'content' );
                        understrap_post_nav();

                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    }
                    ?>

                </div>
                <div class="col-md-4">
                    <?php get_template_part( 'parts/object', 'sidebar' ) ?>
                    <?php get_template_part( 'parts/sidebar', 'cities' ) ?>
                </div>
            </div><!-- .row -->
        </main><!-- #content -->
    </div><!-- #single-wrapper -->

<?php
get_footer();
