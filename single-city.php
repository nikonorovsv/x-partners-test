<?php
/**
 * The template for displaying all single posts
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

global $post;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

    <div class="wrapper" id="single-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

            <div class="row">
                <div class="col-md-8">
                    <main class="site-main" id="main">
                        <h3 class="h1">Объекты недвижимости</h3>
                        <?php get_template_part('parts/city', 'objects-list'); ?>
                    </main>
                </div>
                <div class="col-md-4">
                    <aside>
                        <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

                            <header class="entry-header">
                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                            </header><!-- .entry-header -->

                            <figure class="my-4">
                                <?= get_the_post_thumbnail( $post->ID, 'large', ['class' => 'img-thumbnail w-100'] ); ?>
                            </figure>

                            <div class="entry-content">
                                <?= get_the_content($post->ID) ?>
                            </div><!-- .entry-content -->
                        </article>
                    </aside>
                </div>
            </div>
        </div><!-- #content -->

    </div><!-- #single-wrapper -->

<?php
get_footer();
