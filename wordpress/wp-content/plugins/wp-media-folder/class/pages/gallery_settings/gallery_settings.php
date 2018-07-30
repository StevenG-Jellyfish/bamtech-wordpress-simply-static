<?php
/* Prohibit direct script loading */
defined('ABSPATH') || die('No direct script access allowed!');
?>
<div class="cboption">
    <h3><?php esc_html_e('Default settings', 'wpmf'); ?></h3>
    <!-- For setting default theme -->
    <?php
    // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
    echo $default_theme;
    ?>
    <!-- For setting portfolio theme -->
    <?php
    // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
    echo $portfolio_theme;
    ?>
    <!-- For setting masonry theme -->
    <?php
    // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
    echo $masonry_theme;
    ?>
    <!-- For setting slider theme -->
    <?php
    // phpcs:ignore WordPress.XSS.EscapeOutput -- Content already escaped in the method
    echo $slider_theme;
    ?>
</div>