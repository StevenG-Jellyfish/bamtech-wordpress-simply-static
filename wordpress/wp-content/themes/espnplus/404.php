<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package espnplus
 */
get_header();
?>

<header id="masthead" class="">
    <div class="headerbox">
        <div class="site-header center">
            <div class="site-branding">
				<?php the_custom_logo() ?> 
            </div> 
        </div>
    </div>
</header>
	
<div id="page" class="content-area 404-page site">
	<main id="main" class="site-main">

		<section class="error-404 not-found">
			
			<div class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'Oops! That page can&rsquo;t be found. 404', 'espnplus' ); ?>
				</h1>
			</div>

			<div class="page-content">

				<img src="<?php bloginfo('template_url'); ?>/imgs/404.png" alt="404">
				
				<div class="error-msg">
					<div class="">The page you are looking for can't be found. Please <a href="<?php echo get_site_url(); ?>">click here</a> to return to the homepage.</div>
				</div>
				
				<div class="error404-divider"><div class="divider"></div></div>
				
				<picture>
					<source media="(max-width: 480px)" srcset="<?php bloginfo('template_url'); ?>/imgs/hero-1280-generic.png">
					<img class="main-404-img" src="<?php bloginfo('template_url'); ?>/imgs/hero-1280-generic-2x.png" alt="404">
				</picture>

			</div>

		</section>

	</main>
</div>

<?php
get_footer();