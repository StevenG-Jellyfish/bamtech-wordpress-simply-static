<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
<div class="content-box usegellery content-wpmf-gallery">
    <div class="cboption">
        <div class="wpmf_row_full">
            <input type="hidden" name="wpmf_usegellery" value="0">
            <label data-alt="<?php _e('Enhance the WordPress default gallery system
             by adding themes and additional parameters in the gallery manager', 'wpmf'); ?>" class="text">
                <?php _e('Enable the gallery feature', 'wpmf') ?>
            </label>
            <div class="switch-optimization">
                <label class="switch switch-optimization">
                    <input type="checkbox" name="wpmf_usegellery" value="1"
                        <?php
                        if (isset($usegellery) && $usegellery == 1) {
                            echo 'checked';
                        }
                        ?>
                    >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="cboption">
        <div class="wpmf_row_full">
            <input type="hidden" name="wpmf_usegellery_lightbox" value="0">
            <label data-alt="<?php _e('Add lightbox to images in WordPress default  galleries', 'wpmf'); ?>" class="text">
                <?php _e('Lightbox in galleries', 'wpmf') ?></label>
            <div class="switch-optimization">
                <label class="switch switch-optimization">
                    <input type="checkbox" name="wpmf_usegellery_lightbox" value="1"
                        <?php
                        if (isset($use_glr_lightbox) && $use_glr_lightbox == 1) {
                            echo 'checked';
                        }
                        ?>
                    >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="cboption">
        <h3><?php _e('Slider Animation', 'wpmf'); ?></h3>
        <div>
            <div class="wpmfcard">
                <label class="radio">
                    <input id="radio1" type="radio" name="wpmf_slider_animation"
                           value="slide" <?php checked($slider_animation, 'slide') ?>>
                    <span class="outer"><span class="inner"></span></span><?php _e('Slide', 'wpmf'); ?></label>
                <label class="radio">
                    <input id="radio2" type="radio" name="wpmf_slider_animation"
                           value="fade" <?php checked($slider_animation, 'fade') ?>>
                    <span class="outer"><span class="inner"></span></span><?php _e('Fade', 'wpmf'); ?></label>
            </div>
        </div>
    </div>

    <hr class="wpmf_setting_line">

    <div class="cboption">
        <div id="gallery_image_size" class="div_list">
            <ul class="image_size">
                <li class="div_list_child accordion-section control-section control-section-default open">
                    <h3 class="accordion-section-title wpmf-section-title sizes_title"
                        data-title="sizes" tabindex="0"><?php _e('Gallery image sizes available', 'wpmf') ?></h3>
                    <ul class="content_list_sizes">
                        <?php
                        //global $_wp_additional_image_sizes;
                        $sizes = apply_filters('image_size_names_choose', array(
                            'thumbnail' => __('Thumbnail', 'wpmf'),
                            'medium' => __('Medium', 'wpmf'),
                            'large' => __('Large', 'wpmf'),
                            'full' => __('Full Size', 'wpmf'),
                        ));
                        foreach ($sizes as $key => $size) :
                            ?>

                            <li class="customize-control customize-control-select" style="display: list-item;">
                                <div class="pure-checkbox">
                                    <input id="<?php echo $key ?>" type="checkbox" name="size_value[]"
                                           value="<?php echo $key ?>"
                                        <?php
                                        if (in_array($key, $size_selected)) {
                                            echo 'checked';
                                        }
                                        ?>
                                    >
                                    <label for="<?php echo $key ?>"><?php echo $size ?></label>
                                </div>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                    <p class="description">
                        <?php _e('Select the image size you can load in galleries.
                     Custom image size available here can be generated by 3rd party plugins', 'wpmf'); ?>
                    </p>
                </li>
            </ul>
        </div>

        <!--    setting padding     -->
        <div id="gallery_image_padding" class="div_list">
            <ul class="image_size">
                <li class="div_list_child accordion-section control-section control-section-default open">
                    <h3 class="accordion-section-title wpmf-section-title padding_title"
                        data-title="padding" tabindex="0">
                        <?php _e('Gallery themes settings', 'wpmf') ?>
                    </h3>
                    <ul class="content_list_padding">
                        <li class="customize-control customize-control-select" style="display: list-item;">
                            <span><?php _e('Masonry Theme', 'wpmf'); ?></span>
                            <label><?php _e('Space between images (padding)', 'wpmf') ?></label>
                            <label>
                                <input name="padding_gallery[wpmf_padding_masonry]" class="padding_gallery small-text"
                                       type="number" min="0" max="30" value="<?php echo $padding_masonry ?>">
                            </label>
                            <label><?php _e('px', 'wpmf') ?></label>
                        </li>

                        <li class="customize-control customize-control-select" style="display: list-item;">
                            <span><?php _e('Portfolio Theme', 'wpmf'); ?></span>
                            <label><?php _e('Space between images (padding)', 'wpmf') ?></label>
                            <label>
                                <input name="padding_gallery[wpmf_padding_portfolio]" class="padding_gallery small-text"
                                       type="number" min="0" max="30" value="<?php echo $padding_portfolio ?>">
                            </label>
                            <label><?php _e('px', 'wpmf') ?></label>
                        </li>
                    </ul>
                    <p class="description"><?php _e('Determine the space between images', 'wpmf'); ?></p>
                </li>
            </ul>
        </div>
    </div>

    <hr class="wpmf_setting_line">
    <?php if (defined('NGG_PLUGIN_VERSION')) : ?>
        <?php if (current_user_can('manage_options')) : ?>
            <div class="cboption">
                <input type="button" id="btn_import_gallery"
                       class="btn waves-effect waves-light waves-input-wrapper btn_import_gallery"
                       value="<?php _e('Sync/Import NextGEN galleries', 'wpmf'); ?>">
                <span class="spinner" style="float: left;display:none"></span>
                <span class="wpmf_info_update"><?php _e('Settings saved.', 'wpmf') ?></span>
            </div>
            <p style="margin-left:10px;" class="description">
                <?php _e('Import nextGEN albums as image in folders in the media manager.
             You can then create new galleries from WordPress media manager', 'wpmf'); ?>
            </p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    if (is_plugin_active('wp-media-folder-gallery-addon/wp-media-folder-gallery-addon.php')) {
        echo $gallery_settings;
    }
    ?>
</div>