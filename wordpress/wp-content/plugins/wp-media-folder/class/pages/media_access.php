<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
    <div class="content-box content-wpmf-media-access">
        <div class="cboption">
            <div class="wpmf_row_full">
                <input type="hidden" name="wpmf_active_media" value="0">
                <label data-alt="<?php esc_html_e('Once user upload some media, he will have a
             personal folder, can be per User or per User Role', 'wpmf'); ?>"
                       class="text"><?php esc_html_e('Media access by User or User Role', 'wpmf') ?></label>
                <div class="switch-optimization">
                    <label class="switch switch-optimization">
                        <input type="checkbox" name="wpmf_active_media"
                               id="cb_option_active_media" value="1"
                            <?php
                            if (isset($wpmf_active_media) && (int) $wpmf_active_media === 1) {
                                echo 'checked';
                            }
                            ?>
                        >
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
            <div class="wpmf_row_full">
                <label data-alt="<?php esc_html_e('Automatically create a
             folder per User or per WordPress User Role', 'wpmf'); ?>"
                       class="text"><?php esc_html_e('Folder automatic creation', 'wpmf') ?></label>
                <label>
                    <select name="wpmf_create_folder">
                        <option
                            <?php selected($wpmf_create_folder, 'user'); ?> value="user">
                            <?php esc_html_e('By user', 'wpmf') ?>
                        </option>
                        <option
                            <?php selected($wpmf_create_folder, 'role'); ?> value="role">
                            <?php esc_html_e('By role', 'wpmf') ?>
                        </option>
                    </select>
                </label>
            </div>

            <div class="wpmf_row_full">
                <label data-alt="<?php esc_html_e('Select the root folder to store all user media and
             folders (only if Media by User or User Role is activated above)', 'wpmf'); ?>"
                       class="text"><?php esc_html_e('User media folder root', 'wpmf') ?></label>
            </div>
            <div class="wpmf_row_full">
                <span id="wpmfjaouser"></span>
            </div>

            <div class="wpmf_row_full">
                <input type="hidden" name="wpmf_option_singlefile" value="0">
                <label data-alt="<?php esc_html_e('Apply single file design with below
             parameters when insert file to post / page', 'wpmf'); ?>" class="text">
                    <?php esc_html_e('Enable single file design', 'wpmf') ?></label>
                <div class="switch-optimization">
                    <label class="switch switch-optimization">
                        <input type="checkbox" name="wpmf_option_singlefile"
                               value="1"
                            <?php
                            if (isset($option_singlefile) && (int) $option_singlefile === 1) {
                                echo 'checked';
                            }
                            ?>
                        >
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

        <div class="wpmf_group_color">
            <div class="wpmf_group_singlefile">
                <label class="control-label" for="singlebg"><?php esc_html_e('Background color', 'wpmf') ?></label>
                <label>
                    <input name="wpmf_color_singlefile[bgdownloadlink]" type="text"
                           value="<?php echo esc_attr($wpmf_color_singlefile->bgdownloadlink) ?>"
                           class="inputbox input-block-level wp-color-field-bg wp-color-picker">
                </label>
            </div>

            <div class="wpmf_group_singlefile">
                <label class="control-label" for="singlebg"><?php esc_html_e('Hover color', 'wpmf') ?></label>
                <label>
                    <input name="wpmf_color_singlefile[hvdownloadlink]" type="text"
                           value="<?php echo esc_attr($wpmf_color_singlefile->hvdownloadlink) ?>"
                           class="inputbox input-block-level wp-color-field-hv wp-color-picker">
                </label>
            </div>

            <div class="wpmf_group_singlefile">
                <label class="control-label" for="singlebg"><?php esc_html_e('Font color', 'wpmf') ?></label>
                <label>
                    <input name="wpmf_color_singlefile[fontdownloadlink]" type="text"
                           value="<?php echo esc_attr($wpmf_color_singlefile->fontdownloadlink) ?>"
                           class="inputbox input-block-level wp-color-field-font wp-color-picker">
                </label>
            </div>

            <div class="wpmf_group_singlefile">
                <label class="control-label" for="singlebg"><?php esc_html_e('Hover font color', 'wpmf') ?></label>
                <label>
                    <input name="wpmf_color_singlefile[hoverfontcolor]" type="text"
                           value="<?php echo esc_attr($wpmf_color_singlefile->hoverfontcolor) ?>"
                           class="inputbox input-block-level wp-color-field-hvfont wp-color-picker">
                </label>
            </div>
        </div>

        <div class="cboption">
            <div class="wpmf_row_full">
                <input type="hidden" name="wpmf_option_lightboximage" value="0">
                <label data-alt="<?php esc_html_e('Add a lightbox option on each image of your WordPress content', 'wpmf'); ?>"
                       class="text"><?php esc_html_e('Enable the single image lightbox feature', 'wpmf') ?></label>
                <div class="switch-optimization">
                    <label class="switch switch-optimization">
                        <input type="checkbox" name="wpmf_option_lightboximage"
                               id="cb_option_lightboximage" value="1"
                            <?php
                            if (isset($option_lightboximage) && (int) $option_lightboximage === 1) {
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
                <input type="hidden" name="social_sharing" value="0">
                <label data-alt="<?php esc_html_e('Possibility to load social sharing buttons on hover to image in gallery', 'wpmf'); ?>"
                       class="text"><?php esc_html_e('Enable social sharing buttons', 'wpmf') ?></label>
                <div class="switch-optimization">
                    <label class="switch switch-optimization">
                        <input type="checkbox" name="social_sharing" value="1"
                            <?php
                            if (isset($social_sharing) && (int) $social_sharing === 1) {
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
                <label class="text">
                    <?php esc_html_e('Facebook', 'wpmf') ?>
                </label>
                <input title="facebook" type="text" name="social_sharing_link[facebook]"
                       class="regular-text" value="<?php echo esc_attr($facebook); ?>">
            </div>
        </div>

        <div class="cboption">
            <div class="wpmf_row_full">
                <label class="text">
                    <?php esc_html_e('Twitter', 'wpmf') ?>
                </label>
                <input title="twitter" type="text" name="social_sharing_link[twitter]"
                       class="regular-text" value="<?php echo esc_attr($twitter); ?>">
            </div>
        </div>

        <div class="cboption">
            <div class="wpmf_row_full">
                <label class="text">
                    <?php esc_html_e('Google+', 'wpmf') ?>
                </label>
                <input title="google" type="text" name="social_sharing_link[google]"
                       class="regular-text" value="<?php echo esc_attr($google); ?>">
            </div>
        </div>

        <div class="cboption">
            <div class="wpmf_row_full">
                <label class="text">
                    <?php esc_html_e('Instagram', 'wpmf') ?>
                </label>
                <input title="instagram" type="text" name="social_sharing_link[instagram]"
                       class="regular-text" value="<?php echo esc_attr($instagram); ?>">
            </div>
        </div>

        <div class="cboption">
            <div class="wpmf_row_full">
                <label class="text">
                    <?php esc_html_e('Pinterest', 'wpmf') ?>
                </label>
                <input title="pinterest" type="text" name="social_sharing_link[pinterest]"
                       class="regular-text" value="<?php echo esc_attr($pinterest); ?>">
            </div>
        </div>
    </div>
<?php
wp_enqueue_style('wp-color-picker');
wp_enqueue_script('wp-color-picker');
?>