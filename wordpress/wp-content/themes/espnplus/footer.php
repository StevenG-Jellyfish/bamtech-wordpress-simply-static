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
				<div class="site-info"></div>
			</footer>

		</div>
	</div>

	<script>
		loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>');
	</script>	
	<noscript>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css'; ?>">
	</noscript>

    <script>
    	var LangCode = '<?php echo apply_filters( 'wpml_current_language', NULL );  ?>';
		<?php $context_vars = explode('-',$wp_query->post->post_title); ?>
		var ALeague = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[0])) : 'no league';?>';
		var ASport = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[1])) : 'no sport';?>';
    </script>
<!-- added to functions.php	
	<script async src="<?php echo get_stylesheet_directory_uri(); ?>/js/espnplus-non-critical.js"></script> 
	<script async src="<?php echo get_stylesheet_directory_uri(); ?>/js/espnplus-bottom.min.js"></script>
-->

	<?php wp_footer(); ?>

</body>
</html>
