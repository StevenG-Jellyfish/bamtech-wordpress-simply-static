<?php
/**
 * Spotlight component
 *
 * @package Bamtech ESPN+
 */
 $page_id = get_query_var('page_override_id');

 if (empty($page_id)) {
	   $page_id = get_the_ID();
 }

 $component = get_field('component_spotlight', $page_id);
 
 if ($component !== false) {
?>

   
    <section class="jumbotron text-center">
        <div class="container">
            
            <a class="jumbotron-login" href="https://secure.web.plus.espn.com">Log In</a>

            <h1 class="jumbotron-heading"><?php the_field('spotlight_overlogo_text', $component);?></h1>
            
            <div class="jumbotron-logo">
    			<?php $image = get_field('spotlight_logo_image', $component);?>
                <img src="<?php echo $image['sizes']['medium'];?>" alt="ESPN+"> 
            </div>
           
            <p class="lead"><?php the_field('spotlight_main_text', $component, false);?></p>
            
            <div class="espn-cta-container">
                <div class="parallelogram">
    				<?$link = get_field('spotlight_cta_link', $component);?>
                    <a href="<?php echo $link['url'];?>" class="btn btn-primary espn-cta"><?php the_field('spotlight_cta_text', $component,false);?></a>
                   
                </div>
            </div>
            
            <p class="below-cta"><?php the_field('spotlight_belowcta_text', $component,false);?></p>
    	
        </div>
    	
        <?php 
            $video = get_field('spotlight_background-video', $component);
            $small_video = get_field('spotlight_background_small_video', $component);
        ?>
        
        <div class="container-fluid jubmotron-background">

            <div class="embed-responsive embed-responsive-16by9 div_style">
                <video id="background-movie" preload autoplay loop>
                    <source src="<?php echo $video['url'];?>" type="video/mp4" media="(min-width:768px)">
                    <source src="<?php echo $small_video['url'];?>" type="video/mp4" media="(max-width:767px)"> 
                    <?php $video_image = get_field('spotlight_video_image', $component);?>
                    <img src="<?php echo $video_image['sizes']['medium'];?>" title="Your browser does not support the <video> tag" alt="ESPN+">
                </video>
            </div>
        </div>

    </section>
   
<?php
}
