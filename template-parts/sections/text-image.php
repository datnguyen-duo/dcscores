<?php
defined( 'ABSPATH' ) || exit;
$layout = $args['layout'];
$variation = get_sub_field('variation');
$columns = get_sub_field('columns');
$list = get_sub_field('list');
$header_args = array(
    'layout' => $layout,
    'pre_heading' => get_sub_field('pre_heading'),
    'heading' => get_sub_field('heading'),
    'description' => get_sub_field('description'),
    'cta' => get_sub_field('cta'),
);
?>
    <div class="<?php echo $layout . '__columns'; ?>">
        <?php if ($variation == 'default' && $columns): 
            $image = $columns['image'];
            $content = $columns['content'];
            ?>
            <?php if ($image): ?>
                <div class="<?php echo $layout . '__column --image'; ?>">
                    <?php image($image['ID'], 'full', $layout . '__column-image active', $image['alt']); ?>
                </div>
            <?php endif; ?>
            <div class="<?php echo $layout . '__column --content'; ?>">
                <?php 
                    echo $content['pre_title'] ? '<p class="' . $layout . '__column-pre-title">' . $content['pre_title'] . '</p>' : '';
                    echo $content['title'] ? '<p class="' . $layout . '__column-title">' . $content['title'] . '</p>' : '';
                    echo $content['description'] ? '<p class="' . $layout . '__column-description">' . $content['description'] . '</p>' : '';
                    if (!empty($content['cta'])) {
                        echo '<div class="' . $layout . '__column-cta">';
                        foreach($content['cta'] as $key => $link) { 
                            if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                                $url = $link['link']['url'];
                                $target = $link['link']['target'];
                                $class = "primary";
                                $title = $link['link']['title'];
                                echo "<div class='" . $layout . "__cta-link'>";
                                    button($title, $class, $url, $target);
                                echo "</div>";
                            } 
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        <?php else: 
            $hasImage = false;
            foreach($list as $item) {
                if ($item['image']) {
                    $hasImage = true;
                    break;
                }
            }
            ?>
            <?php if ($hasImage): ?>
                <div class="<?php echo $layout . '__column --image'; ?>">
                    <?php foreach($list as $key => $item): 
                        $image = $item['image'];
                        if ($image) {
                            image($image, 'full', $layout . '__column-image' . ($key === 0 ? ' active' : ''), '');
                        }
                    endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="<?php echo $layout . '__column --content'; ?>">
                <?php get_template_part('template-parts/sections/section-header', null, $header_args); ?>
                <?php if ($variation == 'toggles'): ?>
                    <ul class="<?php echo $layout . '__column-toggles'; ?>">
                        <?php foreach ($list as $item): ?>
                            <li class="<?php echo $layout . '__column-toggle'; ?>">
                                <?php echo $item['content']['label'] ? $item['content']['label'] : $item['content']['title']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div class="<?php echo $layout . '__column-group'; ?>">
                    <?php foreach($list as $key => $item): 
                        $content = $item['content'];
                        ?>
                        <div class="<?php echo $layout . '__column-inner' . ($key === 0 ? ' active' : ''); ?>">
                            <?php
                                echo $content['pre_title'] ? '<p class="' . $layout . '__column-pre-title">' . $content['pre_title'] . '</p>' : '';
                                echo $content['title'] ? '<p class="' . $layout . '__column-title">' . $content['title'] . '</p>' : '';
                                echo $content['description'] ? '<p class="' . $layout . '__column-description">' . $content['description'] . '</p>' : '';
                                echo $content['subtext'] ? '<p class="' . $layout . '__column-subtext">' . $content['subtext'] . '</p>' : '';
                                if (!empty($content['cta'])) {
                                    echo '<div class="' . $layout . '__column-cta">';
                                    foreach($content['cta'] as $key => $link) { 
                                        if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                                            $url = $link['link']['url'];
                                            $target = $link['link']['target'];
                                            $class = "primary";
                                            $title = $link['link']['title'];
                                            echo "<div class='" . $layout . "__cta-link'>";
                                                button($title, $class, $url, $target);
                                            echo "</div>";
                                        } 
                                    }
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    