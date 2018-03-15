<?php
/**
* Section component
*
* @package lincolntech
*/

$page_id = get_query_var('page_override_id');

if (empty($page_id)) {
    $page_id = get_the_ID();
}
 
/* 
*  Assign repeater field to $component variable
*/ 
$component = get_field('component_section', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 
if ($component !== false) {
    
    //print_r($component);
    $section_ids = array();
    
    foreach($component as $value){
        $section_ids[] = $value['component_section_item'];
    }
    //print_r($section_ids);

    
    /* 
     *  Loop $section_ids array and pull each values in respectives areas
     *  @ section_header
     *  @ section_body
     *  @ section_image
     */ 
    $count = 0;
    foreach($section_ids as $section_id) {
    $odd_even = ++$count % 2 ? "even" : "odd";
    ?>
        <!-- SECTION -->
        <section class="section <?echo $odd_even;?>">
            <div class="container">
                <div class="row flexbox">
                    
                    <div class="col-md-6 copy-container">
                        
                        <h2 class="featurette-heading">EVEN featurette heading. 
                            <span class="text-muted">It'll blow your mind.</span>
                            <?php echo get_field('section_header', $section_id);?>
                        </h2>

                        <p class="lead">
                            <?php echo get_field('section_body', $section_id);?> <a href="#">Fusce dapibus</a>, tellus ac cursus commodo.
                        </p>
                    </div>

                    <div class="col-md-6 media-container">    
                        <!--*** {{ section image at various media settings (presets form the admin) }} -->
                        <picture> 
                            <?php $image = get_field('section_image', $section_id);?>

                            <source media="(min-width: 990px)" srcset="<?echo $image['sizes']['medium_large'];?>">
                            <source media="(min-width: 768px)" srcset="<?echo $image['sizes']['medium'];?>">
                            <source media="(min-width: 420px)" srcset="<?echo $image['sizes']['large'];?>">
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
}
