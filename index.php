<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
    <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

    <div class="wrapper" id="index-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

            <main class="site-main" id="main">
                <section>
                    <header>
                        <h2 class="my-5">
                            <?= __( 'Новые объекты!', THEME_TEXT_PREFIX ) ?>
                        </h2>
                    </header>

                    <?php get_template_part('parts/main', 'objects-list'); ?>
                </section>

                <section>
                    <header>
                        <h2 class="my-5">
                            <?= __( 'Искать в городе:', THEME_TEXT_PREFIX ) ?>
                        </h2>
                    </header>

                    <?php get_template_part('parts/main', 'cities-list'); ?>
                </section>

                <section>
                    <header>
                        <h2 class="my-5">
                            <?= __( 'Добавить свой объект', THEME_TEXT_PREFIX ) ?>
                        </h2>
                    </header>

                    <?php get_template_part('parts/main', 'form'); ?>
                </section>
            </main>

        </div><!-- #content -->

    </div><!-- #index-wrapper -->

<?php
get_footer();
