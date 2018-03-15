<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package espnplus
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="content">
			<div class="temp-spotlight"></div>
			<div class="temp-content">
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Link with href
  </a>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Button with data-target
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
  </div>
</div>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
				<p>Hello</p>
			</div>
		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
