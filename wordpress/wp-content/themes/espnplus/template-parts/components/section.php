<?php
/**
* Section component
*
* @package Bamtech ESPN+
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
       
        <section class="section <?echo $odd_even; if ($section_id === reset($section_ids)) {echo " first-section";}if ($section_id === end($section_ids))
        {echo " last-section";}?>">
            <div class="container">
                <div class="row flexbox">
                    
                    <div class="col-md-6 copy-container">
                        
                        <h2 class="featurette-heading"><?php the_field('section_header', $section_id,false);?></h2>

                        <p class="lead"><?php the_field('section_body', $section_id,false);?></p>

                    </div>

                    <div class="col-md-6 media-container"> 
                    <?php $image = get_field('section_image', $section_id); ?>
                        <img 
                            class="featurette-image img-fluid mx-auto lazy"
                            src="<?echo $image['sizes']['bamtech-xsmall-width'];?>"
                            data-src="<?echo $image['sizes']['bamtech-large-width'];?>" 
                            alt="cool"
                        />
                    <noscript>
                        <img 
                            class="featurette-image img-fluid mx-auto nolazy"
                            src="<?echo $image['sizes']['bamtech-large-width'];?>"
                            alt="cool"
                        />
                    </noscript>
                    </div>

                </div>
            </div>
        </section>
      

    <?php 
    } 
}
