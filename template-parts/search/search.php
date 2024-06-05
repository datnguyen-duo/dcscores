<?php
/**
 * The template for displaying search results.
 *
 * @package YourThemeName
 */

get_header(); ?>

<main id="primary" class="site-main">
    <section class="content-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <?php if (have_posts()) : ?>
                        <header class="page-header">
                            <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'YourThemeName'), '<span>' . get_search_query() . '</span>'); ?></h1>
                        </header><!-- .page-header -->

                        <?php
                        while (have_posts()) :
                            the_post();
                            // Include the template part for the content
                            get_template_part('template-parts/content', 'search');
                        endwhile;

                        // Include pagination
                        the_posts_navigation();
                    else :
                        // If no content found, include the template part for no content
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                </div><!-- .col-md-8 -->

                <div class="col-md-4">
                    <?php get_sidebar(); ?>
                </div><!-- .col-md-4 -->
            </div><!-- .row -->
        </div><!-- .container -->
    </section><!-- .content-area -->
</main><!-- #primary -->

<?php get_footer(); ?>