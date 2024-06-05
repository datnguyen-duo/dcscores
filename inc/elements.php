<?php 
function image($ID, $size, $class = '', $alt = 'Feature Image', $loading = 'lazy') {
    echo wp_get_attachment_image($ID, $size, false, 
        array(
            'class' => $class, 
            'alt' => $alt,
            'loading' => $loading,
            'role' => 'presentation',
            'aria-label' => $alt,
            'title' => $alt,
        )
    );
}

function video($src, $mime_type, $class = '', $settings = '', $poster = '', $captions = '') { ?>
    <video class="<?php echo $class; ?>" <?php echo $settings?> poster="<?php echo $poster; ?>">
        <source src="<?php echo $src; ?>" type="<?php echo $mime_type; ?>">
        <?php if ($captions): ?>
            <track kind="captions" src="<?php echo $captions; ?>" srclang="en">
        <?php endif; ?>
        Your browser does not support the video tag.
    </video>
<?php }

function button($text, $class = '', $link = '#', $target = '_self') {
    echo '<a href="' . $link . '" class="button button--' . $class . '" target="' . $target . '">' . $text . '</a>';
}
?>