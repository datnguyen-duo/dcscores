<?php 
defined( 'ABSPATH' ) || exit; 
$ID = get_the_ID();
$author = get_field('author', $ID);    
?>
<div class="entry__sidebar">
    <p class="entry__sidebar-title font__size-6">Published</p>
    <p class="entry__sidebar-description"><?php the_date(); ?></p>
    <?php if ($author): ?>
        <p class="entry__sidebar-title font__size-6">Author</p>
        <p class="entry__sidebar-description"><?php echo $author; ?></p>
    <?php endif; ?>
    <div class="entry__sidebar-share">
        <div class="entry__sidebar-share-icon">
            <?php icon_share(); ?>
        </div>
        <div class="entry__sidebar-share-links">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><?php icon_facebook(); ?></a>
            <a href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><?php icon_x(); ?></a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" target="_blank"><?php icon_linkedin(); ?></a>
        </div>
    </div>
</div>