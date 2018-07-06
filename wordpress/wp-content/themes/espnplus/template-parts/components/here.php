<?php
/**
 * Spotlight component
 *
 * @package Bamtech ESPN+
 */
/* Device detect */
require get_template_directory() . '/Mobile_Detect.php';

function isMobile(){
    $detect = new Mobile_Detect;
    // Find c,m, or t (Computer, Mobile, or Tablet)
    if ($detect->isMobile() && !$detect->isTablet()) {
        $device = 'm';
    } elseif ( $detect->isTablet()) {
        $device = 't'; 
    } else {
        $device = 'c';
    }
    return $device;
}
/* ------- */
 $page_id = get_query_var('page_override_id');

 if (empty($page_id)) {
	   $page_id = get_the_ID();
 }

?>
    <section class="">
        <div class="container">
            <p>MEH</p>
        </div>
    </section>
   
<?php
