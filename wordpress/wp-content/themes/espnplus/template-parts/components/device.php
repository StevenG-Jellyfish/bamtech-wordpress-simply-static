<?php
/**
* Device component
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
  
   

    <section class="devices-bar">
        <div class="container">
            <h3 class="devices-header">
                 <?php echo  __( 'Available on All Your Favorite Supported Devices', 'espnplus' ); ?>
            </h3>
            <div class="devices-container">  

            <?php foreach($section_ids as $section_id) {?>
                
                <div class="device">
                
                    <?php $image = get_field('device_image', $section_id);?>
                    <img class="device-image" src="<?echo $image['sizes']['medium'];?>" alt="<?php echo the_field('device_text', $section_id,false);?>">
                    <p class="device-copy"><?php echo the_field('device_text', $section_id,false);?></p>
                    
                </div>

            <?php } ?>

            </div>    

        </div>
    </section>
   

<?php 
}
