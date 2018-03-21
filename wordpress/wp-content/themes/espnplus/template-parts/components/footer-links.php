<?php
/**
* Footer component
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
$component = get_field('component_footer_link', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 
if ($component !== false) {
    
    //print_r($component);
    $section_ids = array();
    
    foreach($component as $value){
        $section_ids[] = $value['component_footer_link_item'];
    }
    //print_r($section_ids);

    
    /* 
     *  Loop $section_ids array and pull each values in respectives areas
     *  @ footer_link_text
     *  @ footer_link_URL
     */ 
    ?>
  
    <section class="footer-links">
        <div class="container">
            
            <div class="espn-lang">
           
                <div class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/imgs/E+_logo.svg" alt="ESPN plus logo">
                </div>

                <div class="select-wrap">
                    <?php 
                        if (is_active_sidebar('lang-select')){
                            dynamic_sidebar('lang-select');
                        }
                    ?>   
                </div>

            </div>

            
        
            <div class="espn-links">
                <?php 
                foreach($section_ids as $section_id) {
                    
                    $link = get_field('footer_link_URL', $section_id);
                ?>
                <div class="link">
                    <a href="<?php echo $link;?>"><?php echo get_field('footer_link_text', $section_id);?></a>
                </div>
                <?php }?>
            </div>
        
        </div>    

    </section>
    <!-- // section --> 
<?php 
}
