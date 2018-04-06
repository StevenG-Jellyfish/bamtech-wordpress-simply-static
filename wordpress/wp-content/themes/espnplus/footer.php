<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package espnplus
 */
?>
	</div>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
		</div>
	</footer>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script language="JavaScript" type="text/javascript" href="<?php echo get_template_directory();?>/js/espnplus-non-critical.js"></script>

<noscript>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>">
</noscript>
<?php wp_footer(); ?>
</body>

</html>