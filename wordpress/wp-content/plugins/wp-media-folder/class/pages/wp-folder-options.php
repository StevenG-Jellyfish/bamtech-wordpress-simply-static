<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
<h1 style="font-weight: 400;font-size: 23px;"><?php esc_html_e('Media Folder Settings', 'wpmf') ?></h1>
<form name="form1" id="form_list_size" action="" method="post">
    <?php
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/menus.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/general.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/media_access.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/gallery.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/files_folders.php';
    if (current_user_can('install_plugins')) {
        require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/ftp_import.php';
        require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/sync_media.php';
    }
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/regenerate_thumbnails.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/image_compression.php';
    if (is_plugin_active('wp-media-folder-addon/wp-media-folder-addon.php')) {
        // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
        echo $html_tabgoogle;
        // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
        echo $html_tabdropbox;
        // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
        echo $html_tabonedrive;
    }
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/jutranslation.php';
    require_once WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/pages/submit_button.php';
    ?>
    <input type="hidden" class="setting_tab_value" name="setting_tab_value" value="wpmf-general">
    <input type="hidden" name="wpmf_nonce" value="<?php echo esc_html(wp_create_nonce('wpmf_nonce')) ?>">
</form>
<script>

    (function ($) {
        $(function () {
            jQuery('.wp-color-field-bg').wpColorPicker({width: 180, defaultColor: '#444444'});
            jQuery('.wp-color-field-hv').wpColorPicker({width: 180, defaultColor: '#888888'});
            jQuery('.wp-color-field-font').wpColorPicker({width: 180, defaultColor: '#ffffff'});
            jQuery('.wp-color-field-hvfont').wpColorPicker({width: 180, defaultColor: '#ffffff'});
            jQuery('.wpmf-tab-header[data-label="<?php echo esc_html($tab) ?>"]').click();
        });
    })(jQuery);

</script>