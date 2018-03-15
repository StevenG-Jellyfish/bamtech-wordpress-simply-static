<?php
/**
* League_accordion component
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
$component = get_field('component_league_accordion', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 

if ($component !== false) {
    
    //print_r($component);
    $section_ids = array();
    
    foreach($component as $value){
        $section_ids[] = $value['component_league_accordion_item'];
    }
    //print_r($section_ids);

    ?>


    <!--  Cut just this for the component -->
    <section class="league-toc">
        <div class="container">

            <!--*** replace this script with php -->
            <div class="copyright">&copy;<script>var d = new Date(); document.write( d.getFullYear() ); </script> ESPN </div>

                <!--Accordion wrapper-->
                <div class="accordion" id="league-toc-accordion" role="tablist" aria-multiselectable="true">


                    <?php
                    /* 
                     *  Loop $section_ids array and pull each values in respectives areas
                     *  @ league_accordion_text
                     *  @ league_accordion_body
                     */  
                    $pos_class = array('One','Two','Three','Four','Five','Six','Seven','Eight');
                    $acc_count=0;
                    foreach($section_ids as $section_id) {

                    ?>
                        <!-- Accordion card -->
                        <div class="card">
                    
                            <!-- Card header -->
                            <div class="card-header" role="tab" id="heading<?php echo $pos_class[$acc_count]; ?>">
                                <a data-toggle="collapse" data-parent="#league-toc-accordion" href="#collapse<?php echo $pos_class[$acc_count]; ?>" aria-expanded="false" aria-controls="collapse<?php echo $pos_class[$acc_count]; ?>">
                                    <h5 class="mb-0">
                                        <?php echo get_field('league_accordion_text', $section_id);?> <i class="fa fa-angle-down rotate-icon"></i>
                                    </h5>
                                </a>
                            </div>
                            <!-- // Card header -->
                            <!-- Card body -->
                            <div id="collapse<?php echo $pos_class[$acc_count]; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $pos_class[$acc_count]; ?>" data-parent="#league-toc-accordion">
                                <div class="card-body">
                                    <?php echo get_field('league_accordion_body', $section_id);?>
                                </div>
                            </div>
                            <!-- // Card body -->
                        </div>
                        <!-- // Accordion card -->
                
                    <?php $acc_count++; } ?>

                    
        
                </div>
                <!--// Accordion wrapper-->
        </div>    
    </section>
    <!--  //End Cut -->

<?php 
}