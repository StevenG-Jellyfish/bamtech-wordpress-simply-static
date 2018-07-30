<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
<div class="wpmf_row_full">
    <h4 class="settings_theme_name"><?php echo esc_html($theme_label); ?></h4>
    <div class="wpmf_glr_settings">
        <p>
            <label class="setting text" data-alt="<?php esc_html_e('Number of columns
                 by default in the gallery theme', 'wpmf'); ?>">
                <?php esc_html_e('Columns', 'wpmf'); ?>
            </label>

            <label>
                <select class="columns" name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][columns]">
                    <?php for ($i = 1; $i <= 8; $i ++) { ?>
                        <option value="<?php echo esc_html($i) ?>" <?php selected((int) $settings['columns'], (int) $i) ?> >
                            <?php echo esc_html($i) ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
        </p>

        <p>
            <label class="setting text" data-alt="<?php esc_html_e('Image size to load
                 by default as thumbnail', 'wpmf'); ?>">
                <?php esc_html_e('Gallery image size', 'wpmf'); ?>
            </label>
            <label class="size">
                <select class="size" name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][size]">
                    <?php
                    $sizes_value = json_decode(get_option('wpmf_gallery_image_size_value'));
                    $sizes       = apply_filters('image_size_names_choose', array(
                        'thumbnail' => __('Thumbnail', 'wpmf'),
                        'medium'    => __('Medium', 'wpmf'),
                        'large'     => __('Large', 'wpmf'),
                        'full'      => __('Full Size', 'wpmf'),
                    ));
                    ?>

                    <?php foreach ($sizes_value as $key) : ?>
                        <?php if (!empty($sizes[$key])) : ?>
                            <option value="<?php echo esc_attr($key); ?>" <?php selected($settings['size'], $key); ?>>
                                <?php echo esc_html($sizes[$key]); ?>
                            </option>
                        <?php endif; ?>

                    <?php endforeach; ?>

                </select>
            </label>
        </p>

        <p>
            <label class="setting text" data-alt="<?php esc_html_e('Image size to load by default as full
                 size (opened in the lightbox)', 'wpmf'); ?>">
                <?php esc_html_e('Lightbox size', 'wpmf'); ?>
            </label>

            <label>
                <select class="targetsize"
                        name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][targetsize]">
                    <?php
                    $sizes = array(
                        'thumbnail' => __('Thumbnail', 'wpmf'),
                        'medium'    => __('Medium', 'wpmf'),
                        'large'     => __('Large', 'wpmf'),
                        'full'      => __('Full Size', 'wpmf'),
                    );
                    ?>

                    <?php foreach ($sizes as $key => $name) : ?>
                        <option value="<?php echo esc_attr($key); ?>"
                            <?php selected($settings['targetsize'], $key); ?>>
                            <?php echo esc_html($name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>

        <p>
            <label class="setting text" data-alt="<?php esc_html_e('Action when the user
                 click on the image thumbnail', 'wpmf'); ?>">
                <?php esc_html_e('Action on click', 'wpmf'); ?>
            </label>

            <label>
                <select class="link-to" name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][link]">
                    <option value="file" <?php selected($settings['link'], 'file'); ?>>
                        <?php esc_html_e('Lightbox', 'wpmf'); ?>
                    </option>
                    <option value="post" <?php selected($settings['link'], 'post'); ?>>
                        <?php esc_html_e('Attachment Page', 'wpmf'); ?>
                    </option>
                    <option value="none" <?php selected($settings['link'], 'none'); ?>>
                        <?php esc_html_e('None', 'wpmf'); ?>
                    </option>
                </select>
            </label>
        </p>

        <p>
            <label class="setting text" data-alt="<?php esc_html_e('Image gallery
                 default ordering', 'wpmf'); ?>">
                <?php esc_html_e('Order by', 'wpmf'); ?>
            </label>

            <label>
                <select class="wpmf_orderby"
                        name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][orderby]">
                    <option value="post__in" <?php selected($settings['orderby'], 'post__in'); ?>>
                        <?php esc_html_e('Custom', 'wpmf'); ?>
                    </option>
                    <option value="rand" <?php selected($settings['orderby'], 'rand'); ?>>
                        <?php esc_html_e('Random', 'wpmf'); ?>
                    </option>
                    <option value="title" <?php selected($settings['orderby'], 'title'); ?>>
                        <?php esc_html_e('Title', 'wpmf'); ?>
                    </option>
                    <option value="date" <?php selected($settings['orderby'], 'date'); ?>>
                        <?php esc_html_e('Date', 'wpmf'); ?>
                    </option>
                </select>
            </label>
        </p>

        <p>
            <label class="setting text" data-alt="<?php esc_html_e('By default, use ascending
                 or descending order', 'wpmf'); ?>">
                <?php esc_html_e('Order', 'wpmf'); ?>
            </label>

            <label>
                <select class="wpmf_order" name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][order]">
                    <option value="ASC" <?php selected($settings['order'], 'ASC'); ?>>
                        <?php esc_html_e('Ascending', 'wpmf'); ?>
                    </option>
                    <option value="DESC" <?php selected($settings['order'], 'DESC'); ?>>
                        <?php esc_html_e('Descending', 'wpmf'); ?>
                    </option>
                </select>
            </label>
        </p>

        <?php if ($theme_name === 'slider_theme') : ?>
            <p>
                <label class="setting">
                    <span class="text"><?php esc_html_e('Transition type', 'wpmf'); ?></span>
                </label>

                <label>
                    <select class="wpmf_animation"
                            name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][animation]">
                        <option value="slide" <?php selected($settings['animation'], 'slide'); ?>>
                            <?php esc_html_e('Slide', 'wpmf'); ?>
                        </option>
                        <option value="fade" <?php selected($settings['animation'], 'fade'); ?>>
                            <?php esc_html_e('Fade', 'wpmf'); ?>
                        </option>
                    </select>
                </label>
            </p>
            <p>
                <label class="setting">
                    <span class="text"><?php esc_html_e('Transition duration', 'wpmf'); ?></span>
                </label>

                <label>
                    <input type="number" name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][duration]"
                           value="<?php echo esc_attr($settings['duration']) ?>"> ms
                </label>
            </p>
            <p>
                <label class="setting">
                    <span class="text"><?php esc_html_e('Automatic animation', 'wpmf'); ?></span>
                </label>

                <label>
                    <input type="hidden"
                           name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][auto_animation]" value="0">
                    <span class="switch-optimization">
                        <label class="switch switch-optimization">
                            <?php if (isset($settings['auto_animation']) && (int) $settings['auto_animation'] === 1) : ?>
                                <input type="checkbox"
                                       name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][auto_animation]"
                                       value="1" checked>
                            <?php else : ?>
                                <input type="checkbox"
                                       name="wpmf_glr_settings[theme][<?php echo esc_html($theme_name) ?>][auto_animation]"
                                       value="1">
                            <?php endif; ?>

                            <span class="slider round"></span>
                        </label>
                    </span>
                </label>
            </p>
        <?php endif; ?>
    </div>
</div>