<?php
defined( 'ABSPATH' ) || exit;
$categories = get_the_category();
if ( $categories ) {
    $category_ids = array();
    foreach ( $categories as $category ) {
        $category_ids[] = $category->term_id;
    }

    $args = array(
        'post__not_in'        => array( get_the_ID() ),
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
        'category__in'        => $category_ids,
    );

    $related_query = new WP_Query( $args );

    if ( $related_query->have_posts() ) : ?>
        <div class="entry__related">
            <h2 class="entry__related-title">Related Posts</h2>
            <div class="posts posts--related">
                <?php while ( $related_query->have_posts() ){
                    $related_query->the_post();
                    get_template_part('template-parts/content/content', 'card');    
                }; wp_reset_postdata(); ?>
            </div>

        </div>
    <?php endif; 
} else {
    get_template_part('template-parts/content/content', 'none');
}
?>