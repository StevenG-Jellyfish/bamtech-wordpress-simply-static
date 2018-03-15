<?php
/**
* Device component
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
$component = get_field('component_device', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 
if ($component !== false) {
    
    //print_r($component);
    $section_ids = array();
    
    foreach($component as $value){
        $section_ids[] = $value['component_device_item'];
    }
    //print_r($section_ids);

    
    /* 
     *  Loop $section_ids array and pull each values in respectives areas
     *  @ device_image
     *  @ device_link
     */ 
    ?>
  
  <!--  Cut just this for the component -->

<section class="devices-bar">
    <div class="container">
        <h3 class="devices-header">
            {{ devices-header}}
        </h3>

        <div class="devices-container">  
            <div class="device">
                <a href="#{{ device_link }}">
                    <img class="device-image" src="../_svgs/apple.svg">
                    <p class="device-copy">
                        iPhone / iPad
                    </p>
                </a>
            </div>
            <div class="device">
                <a href="#{{ device_link }}">
                    <img class="device-image" src="../_svgs/apple.svg">
                    <p class="device-copy">
                        iPhone / iPad
                    </p>
                </a>
            </div>
            <div class="device">
                <a href="#{{ device_link }}">
                    <img class="device-image" src="../_svgs/amazon-fire-tv.svg">
                    <p class="device-copy">
                        Amazon FireTV
                    </p>
                </a>
            </div>
            <div class="device">
                <a href="#{{ device_link }}">
                    <img class="device-image" src="../_svgs/apple.svg">
                    <p class="device-copy">
                        iPhone / iPad
                    </p>
                </a>
            </div>
        </div>    

    </div>
</section>
<!--  //End Cut -->

    <?php 
}
