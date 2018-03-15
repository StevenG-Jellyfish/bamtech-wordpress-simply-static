<?php
/**
 * Template Name: T2 Bamtech LP
 *
 * @package Jellyfish
 * @subpackage Bamtech ESPN
 */
if(get_field('component_text_and_media')){
	set_query_var('testimonialShade', 'gray');
	set_query_var('textmediaShade', 'top');
}

get_header();

get_template_part('template-parts/components/header');
get_template_part('template-parts/components/spotlight');
get_template_part('template-parts/components/section_0');
?>
<section id="rfi" class="section-wpr two-column-rfi">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 add-divider">
				<div class="rfi-form-wpr">
					<div class="rfi-form">
						<?php get_template_part('template-parts/components/form');?>
					</div>
					<span class="rfi-form-shadow"></span>
				</div>
			</div>
			<div class="col-sm-6">
				<?php 
					get_template_part('template-parts/components/accordion-list');
				?>
			</div>
		</div>
	</div>
</section>
<?php
if(get_field('component_text_and_media')){
	get_template_part('template-parts/components/text-and-media');
}
if(get_field('component_testimonial')){
	get_template_part('template-parts/components/testimonial');
}
get_template_part('template-parts/components/footer');
get_footer();