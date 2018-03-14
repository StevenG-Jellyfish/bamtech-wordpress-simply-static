<?php
/**
 * Section2 component
 *
 * @package lincolntech
 */
 $page_id = get_query_var('page_override_id');
 if (empty($page_id)) {
	   $page_id = get_the_ID();
 }
 $component = get_field('component_section_2', $page_id);
 if ($component !== false) {
?>

<!-- SECTION -->
<section class="section odd">
    <div class="container">
        <div class="row flexbox">
            <div class="col-md-6 copy-container">
                <h2 class="featurette-heading">EVEN featurette heading. <span class="text-muted">It'll blow your mind.</span><?php echo get_field('section_header', $component);?></h2>

                <p class="lead"><?php echo get_field('section_body', $component);?> <a href="#">Fusce dapibus</a>, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-6 media-container">    
                <picture> <!--*** {{ section image at various media settings (presets form the admin) }} -->
                    <source media="(min-width: 990px)" srcset="../_images/theme/ep_valueProp_Logos_multi.png">
                    <source media="(min-width: 768px)" srcset="../_images/theme/ep_valueProp_Logos_multi.png">
                    <source media="(min-width: 420px)" srcset="../_images/theme/ep_valueProp_Logos_multi.png">
                    <source media="(min-width: 0px)" srcset="../_images/theme/ep_valueProp_Logos_multi.png">
                    
                    <img class="featurette-image img-fluid mx-auto" src="../_images/theme/ep_valueProp_Logos_multi.png">
                </picture>
                <!-- {{ //section_image }} -->
            </div>
        </div>
    </div>
</section>
<!-- SECTION ###-->
<?php
 
}
