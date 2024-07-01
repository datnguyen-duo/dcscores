<?php
$social_links = get_field('social_media_links', 'option');
if ($social_links): ?>
    <ul class="social-links">
        <?php foreach($social_links as $key => $link): ?>
            <li class="social-links__item">
                <a href="<?php echo $link['link']; ?>" class="social-links__link" aria-label="<?php echo $link['platform']; ?>" target="_blank" rel="noopener noreferrer">
                    <?php 
                        $icon_function = 'icon_' . $link['platform'];
                        if (function_exists($icon_function)) {
                            $icon_function();
                        }
                    ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>