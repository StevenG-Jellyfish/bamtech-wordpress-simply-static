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


/* 
    *  Loop $section_ids array and pull each values in respectives areas
    *  @ league_accordion_text
    *  @ league_accordion_body
    */  
$pos_class = array('One','Two','Three','Four','Five','Six','Seven','Eight');
$acc_count=0;

function card($acc_count, $section_id) {        
    $text = get_field('league_accordion_text', $section_id);  
    $body = get_field('league_accordion_body', $section_id);
    $output = <<< EndHTML
            <!-- Accordion card -->
            <div class="card">
        
                <!-- Card header -->
                <div class="card-header" role="tab" id="heading$acc_count">
                    <a data-toggle="collapse" data-parent="#league-toc-accordion" href="#collapse$acc_count" aria-expanded="false" aria-controls="collapse$acc_count">
                        <h5 class="mb-0">
                            $text <i class="fa fa-chevron-down"></i></i>
                        </h5>
                    </a>
                </div>
                <!-- // Card header -->
                <!-- Card body -->
                <div id="collapse$acc_count" class="collapse" role="tabpanel" aria-labelledby="heading$acc_count" data-parent="#league-toc-accordion">
                    <div class="card-body">
                        $body
                    </div>
                </div>
                <!-- // Card body -->
            </div>
            <!-- // Accordion card -->
EndHTML;
return $output;
} //card()


$leftCol='';
$rightCol='';
foreach($section_ids as $section_id) {
    if($acc_count%2 == 0){
        $leftCol .= card($acc_count, $section_id);  
    }
    else {
        $rightCol .= card($acc_count, $section_id);
        
    }
    $acc_count++;
} //foreach

?>


    <!--  Cut just this for the component -->
    <section class="league-toc">
        <div class="container">

            <!--*** replace this script with php -->
            <div class="copyright">&copy;<script>var d = new Date(); document.write( d.getFullYear() ); </script> ESPN </div>

            <div class="accordion-container">
                <div class="accordion" id="league-toc-accordion1" role="tablist" aria-multiselectable="true">
                    <?php echo $leftCol;?>
                </div>
                <div class="accordion" id="league-toc-accordion2" role="tablist" aria-multiselectable="true">
                    <?php echo $rightCol;?>
                </div>    

            </div>
            <!--// accordion wrapper-->
        </div>    
         <!--// container -->
    </section>
    <!--  //End Cut -->

<?php 
}