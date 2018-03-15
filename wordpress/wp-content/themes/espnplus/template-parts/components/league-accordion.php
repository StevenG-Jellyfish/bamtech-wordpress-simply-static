<?php
/**
* League_accordion component
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
$component = get_field('component_league_accordion', $page_id);

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 

if ($component !== false) {
    
    print_r($component);
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


    ?>


<!--  Cut just this for the component -->
<section class="league-toc">
    <div class="container">

        <!--*** replace this script with php -->
        <div class="copyright">&copy;<script>var d = new Date(); document.write( d.getFullYear() ); </script> ESPN </div>

            <!--Accordion wrapper-->
            <div class="accordion" id="league-toc-accordion" role="tablist" aria-multiselectable="true">



                <!-- Accordion card -->
                <div class="card">
            
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingOne">
                        <a data-toggle="collapse" data-parent="#league-toc-accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <h5 class="mb-0">
                                Collapsible Group Item #1 <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                        </a>
                    </div>
                    <!-- // Card header -->
                    <!-- Card body -->
                    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#league-toc-accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                            non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch
                            3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt
                            sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                            accusamus labore sustainable VHS.
                        </div>
                    </div>
                    <!-- // Card body -->
                </div>
                <!-- // Accordion card -->
            
                <!-- Accordion card -->
                <div class="card">
            
                    <!-- Card header -->
                    <div class="card-header" role="tab" id="headingTwo">
                        <a class="collapsed" data-toggle="collapse" data-parent="#league-toc-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <h5 class="mb-0">
                                Collapsible Group Item #2 <i class="fa fa-angle-down rotate-icon"></i>
                            </h5>
                        </a>
                    </div>
                    <!-- // Card header -->            
                    <!-- Card body -->
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#league-toc-accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute,
                            non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch
                            3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda
                            shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt
                            sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them
                            accusamus labore sustainable VHS.
                        </div>
                    </div>
                    <!-- // Card body -->
                </div>
                <!-- // Accordion card -->
    
            </div>
            <!--// Accordion wrapper-->
    </div>    
</section>
<!--  //End Cut -->

<?php 
}