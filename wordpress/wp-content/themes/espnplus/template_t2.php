<?php
/**
 * Template Name: T2 Bamtech LP
 *
 * @package Jellyfish
 * @subpackage Bamtech ESPN+
 */

if(get_field('component_text_and_media')){
	
	set_query_var('testimonialShade', 'gray');
	set_query_var('textmediaShade', 'top');
}

get_header();
get_template_part('template-parts/components/header');
get_template_part('template-parts/components/spotlight');
get_template_part('template-parts/components/device');
get_template_part('template-parts/components/section');
get_template_part('template-parts/components/toc');
get_template_part('template-parts/components/footer-links');
get_template_part('template-parts/components/league-accordion');
// get_template_part('template-parts/components/featured-programming');
get_footer();

?>
