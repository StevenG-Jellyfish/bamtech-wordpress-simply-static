<?php
/**
* Toc component
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
$component = get_field('component_toc', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 
if ($component !== false) {
    /* 
     *  Loop $section_ids array and pull each values in respectives areas
     *  @ toc_body
     */ 
    ?>

    <section class="terms-conditions">
       
        <div class="container">
            <p><?php the_field('toc_body',$component,false);?></p>
        </div> 
       
    </section>
   
<?php 
}