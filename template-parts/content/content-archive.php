<?php
defined( 'ABSPATH' ) || exit;
$header_args = array(
    'layout' => 'archive',
    'pre_heading' => '',
    'heading' => get_search_query() ? 'Search Results for: ' . esc_html(get_search_query()) : get_the_archive_title(),
    'description' => '',
    'cta' => '',
);
?>
<section class="archive">
    <div class="container">
        <?php get_template_part('template-parts/sections/section', 'header', $header_args); ?>
        <div class="posts posts--archive --post" style="--posts-per-slide: 4">
            <?php if (have_posts()) :
                while (have_posts()) : the_post(); 
                get_template_part('template-parts/content/content', 'card');
                endwhile;
                the_posts_navigation();
            else :
                get_template_part('template-parts/content/content', 'none');
            endif; ?>
        </div>
    </div>
</section>