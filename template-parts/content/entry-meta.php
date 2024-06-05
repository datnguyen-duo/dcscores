<?php
defined( 'ABSPATH' ) || exit; 
?>
<div class="entry__meta">
    <span class="posted-on">
        <?php
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }
        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );
        printf( '<span class="screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a>',
            esc_html_x( 'Posted on', 'post date', 'template' ),
            esc_url( get_permalink() ),
            $time_string
        );
        ?>
    </span>
    <span class="byline">
        <?php
        printf( esc_html_x( 'By %s', 'post author', 'template' ), '<span class="author vcard">' . esc_html( get_the_author_meta('display_name', $post->post_author) ) . '</span>' );
        ?>
    </span>
</div>