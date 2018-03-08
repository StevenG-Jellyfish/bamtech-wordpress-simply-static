<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>

			<h1><?php the_title(); ?></h1>

		<?php if (have_posts()): while (have_posts()) : the_post(); ?>

			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				
				<?php

				// check if the repeater field has rows of data
				if( have_rows('section_component_block') ):

 					// loop through the rows of data
    				while ( have_rows('section_component_block') ) : the_row();

        				// display a sub field value
        				the_sub_field('content');
						the_sub_field('header');
						the_sub_field('image');
						echo '<img src="';echo the_sub_field('image'); echo'">';
						echo "<br>";
    				endwhile;

				else :
    // no rows found
				endif;?>

				<?php comments_template( '', true ); // Remove if you don't want comments ?>

				<br class="clear">

				<?php edit_post_link(); ?>

			</article>
			<!-- /article -->

		<?php endwhile; ?>

		<?php else: ?>

			<!-- article -->
			<article>

				<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

			</article>
			<!-- /article -->

		<?php endif; ?>

		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
