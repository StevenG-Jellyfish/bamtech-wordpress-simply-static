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
        <div class="site-header">
            <div class="site-branding">
                <?php 
                    echo '<img src="';
                    the_field('header_logo', $component);
                    echo '" alt="ESPN+">';

                if ( is_front_page() && is_home() ) :
                    ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php
                else :
                    ?>
                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php
                endif;
                $espnplus_description = get_bloginfo( 'description', 'display' );
                if ( $espnplus_description || is_customize_preview() ) :
                    ?>
                    <p class="site-description"><?php echo $espnplus_description; /* WPCS: xss ok. */ ?></p>
                <?php endif; ?>
            </div>
            <nav class="main-navigation">
                <div class="menu-main-menu-container">
					<ul id="primary-menu" class="menu">
                        <li class="menu-item">
                            <a>
                                <div class="espn-cta-container">
                                    <div class="parallelogram">
                                    <a href="<?php the_field('header_cta_link', $component);?>" class="btn btn-primary"><?php the_field('header_cta_text', $component);?></a>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php the_field('header_login_url', $component);?>"><?php the_field('header_login_text', $component);?></a>
                        </li>
					</ul>
				</div>       
				</nav>
            </div>
        </div>

    </header>

    <div class="container-fluid">

        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'espnplus' ); ?></a>
    
        <div id="content" class="site-content">

   
