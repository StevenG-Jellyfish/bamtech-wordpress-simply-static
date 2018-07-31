<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
<div class="tab-header">
    <div class="wpmf-tabs">
        <div class="wpmf-tab-header active" data-label="wpmf-general"><?php esc_html_e('General', 'wpmf'); ?></div>
        <div class="wpmf-tab-header" data-label="wpmf-gallery"><?php esc_html_e('Gallery', 'wpmf'); ?></div>
        <div class="wpmf-tab-header"
             data-label="wpmf-media-access"><?php esc_html_e('Media access & design', 'wpmf'); ?></div>
        <div class="wpmf-tab-header"
             data-label="wpmf-files-folders"><?php esc_html_e('Files & Folders', 'wpmf'); ?></div>
        <?php if (current_user_can('install_plugins')) : ?>
            <div class="wpmf-tab-header" data-label="wpmf-ftp-import"><?php esc_html_e('FTP import', 'wpmf'); ?></div>
            <div class="wpmf-tab-header"
                 data-label="wpmf-media-sync"><?php esc_html_e('Sync external media', 'wpmf'); ?></div>
        <?php endif; ?>
        <div class="wpmf-tab-header" data-label="wpmf-regen-thumbnail">
            <?php esc_html_e('Regenerate Thumbnails', 'wpmf'); ?></div>
        <div class="wpmf-tab-header" data-label="wpmf-image-compression">
            <?php esc_html_e('Image compression', 'wpmf'); ?></div>
        <?php if (is_plugin_active('wp-media-folder-addon/wp-media-folder-addon.php')) : ?>
            <div class="wpmf-tab-header"
                 data-label="wpmf-google-drive"><?php esc_html_e('Google Drive', 'wpmf'); ?></div>
            <div class="wpmf-tab-header" data-label="wpmf-dropbox"><?php esc_html_e('Dropbox', 'wpmf'); ?></div>
            <div class="wpmf-tab-header" data-label="wpmf-onedrive"><?php esc_html_e('OneDrive', 'wpmf'); ?></div>
        <?php endif; ?>
        <div class="wpmf-tab-header" data-label="wpmf-jutranslation"><?php esc_html_e('Translation', 'wpmf'); ?></div>
    </div>
</div>