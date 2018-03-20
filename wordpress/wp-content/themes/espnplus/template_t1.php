<?php
/**
 * Template Name: T1 Home
 *
 * @package Jellyfish
 * @subpackage lincolntech
 */
if(!get_field('component_icon_and_text')){
	set_query_var('testimonialShade', 'gray');
	set_query_var('textmediaShade', 'top');
}
get_header();
get_template_part('template-parts/components/header');
get_template_part('template-parts/components/spotlight');
get_template_part('template-parts/components/section');
get_template_part('template-parts/components/section2');
get_template_part('template-parts/components/section3');
get_template_part('template-parts/components/section4');
get_template_part('template-parts/components/section5');
get_template_part('template-parts/components/section6');
get_template_part('template-parts/components/section7');
get_template_part('template-parts/components/section8');
get_template_part('template-parts/components/section9');
get_template_part('template-parts/components/section10');
?>

<?php
if(get_field('component_text_and_media')){
	get_template_part('template-parts/components/text-and-media');
}

if(get_field('component_icon_and_text')){
	get_template_part('template-parts/components/icon-and-text');
}

if(get_field('component_testimonial')){
	get_template_part('template-parts/components/testimonial');
}
get_template_part('template-parts/components/footer');
get_footer();