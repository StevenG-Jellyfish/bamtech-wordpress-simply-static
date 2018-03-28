<?php
/**
* Header component
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
$component = get_field('component_header', $page_id);
$espnplus_description = get_bloginfo( 'description', 'display' );

/* 
*  Verify if repeater value is empty
*  Then store the repeater component sections ids in a new array
*/ 
if ($component !== false) {
    
    /* 
    *  Loop $section_ids array and pull each values in respectives areas
    *  @ header_logo
    *  @ header_cta_text
    *  @ header_cta_link
    *  @ header_login_url
    *  @ header_login_text
    */ 

    $header_cta_link= get_field('header_cta_link', $component);
    $header_cta_text= get_field('header_cta_text', $component);
    $header_login_url= get_field('header_login_url', $component);
    $header_login_text= get_field('header_login_text', $component);
    $header_logo= get_field('header_logo', $component);

}else{ 

    //reset values to avoid breaking the page
    $header_cta_link= '';
    $header_cta_text= '';
    $header_login_url= '';
    $header_login_text= '';
    $header_logo= '';
}

?>

<div id="page" class="site">
    <header id="masthead" class="">
        <div class="headerbox">
            <?php if ( empty($header_cta_text) && empty($header_login_text) ) :?>
                <div class="site-header center">
                    <div class="site-branding">
                        <img src="<?php echo $header_logo;?>" alt="ESPN+">
                    </div> 
                </div>
            <?php else: ?>
                <div class="site-header">
                    <div class="site-branding">
                        <img src="<?php echo $header_logo;?>" alt="ESPN+">
                    </div>
                    <nav class="main-navigation">
                        <div class="menu-main-menu-container">
                            <ul id="primary-menu" class="menu">
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-320">
                                    <div class="espn-cta-container">
                                        <div class="parallelogram">
                                            <a href="<?php echo $header_cta_link;?>" class="btn btn-primary"><?php echo $header_cta_text;?></a>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-319">
                                    <a href="<?php echo $header_login_url;?>"><?php echo $header_login_text;?></a>
                                </li>
                            </ul>
                        </div> 
                    </nav>
                </div>
            <?php endif; ?>
                <!-- </div> -->
        </div>
    </header>

    <div class="container-fluid">

        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'espnplus' ); ?></a>
    
        <div id="content" class="site-content">

   
