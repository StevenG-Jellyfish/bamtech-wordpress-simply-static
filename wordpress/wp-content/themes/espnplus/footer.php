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
           $('img.lazy').Lazy({
			// your configuration goes here
			bind: "event",
            delay: 2000,
			scrollDirection: 'vertical',
			visibleOnly: true,

   // show_while_loading: true, //best for progressive JPEG
			afterLoad: function(element) {
				console.log('ok');
			},
			onError: function(element) {
				console.log('error loading ' + element.data('src'));
			}
			});
			//
		loadCSS('<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css?ver='.VERSION; ?>');
	</script>	
	<noscript>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri().'/css/espnplus-non-critical.min.css?ver='.VERSION; ?>">
	</noscript>
	<script src="//cdn.unid.go.com/js/unid.min.js" data-client="ESPN-ONESITE.WEB-PROD"></script>
    <script>
    	var LangCode = '<?php echo apply_filters( 'wpml_current_language', NULL );  ?>';
		<?php $context_vars = explode('-',$wp_query->post->post_title); ?>
		var ALeague = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[0])) : 'no league';?>';
		var ASport = '<?php echo array_key_exists(1,$context_vars)? strtolower(trim($context_vars[1])) : 'no sport';?>';
    </script>

	<?php wp_footer(); ?>

</body>
</html>
