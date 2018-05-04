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

 $component = get_field('component_spotlight', $page_id);
 
 if ($component !== false) {

    // ADD tracking code to variable content with a single a href tag
    $temporal = get_field('spotlight_belowcta_text', $component,false);
    $tracking_added = str_replace('">', '" id="spotlight_terms">', $temporal);
?>
    <section class="jumbotron text-center">
        <div class="container">
            <!-- <a class="jumbotron-login" href="https://secure.web.plus.espn.com">Log In</a> -->
            <h1 class="jumbotron-heading"><?php the_field('spotlight_overlogo_text', $component, false);?></h1>
            <div class="jumbotron-logo">
    			<?php $image = get_field('spotlight_logo_image', $component);?>
                <img src="<?php echo $image['sizes']['medium'];?>" alt="ESPN+"> 
            </div>
            <p class="lead"><?php the_field('spotlight_main_text', $component, false);?></p>
            <?php if (!empty(get_field('spotlight_cta_link', $component))){?>
            <?php $link=get_field('spotlight_cta_link', $component);?>
            <div class="espn-cta-container">
                <div class="parallelogram">  
                    <a id="spotlight_cta" href="<?php echo $link['url'];?>" class="btn btn-primary espn-cta" ><?php the_field('spotlight_cta_text', $component,false);?></a>
                </div>
            </div>
            <?php 
        }
        ?>
            <p class="below-cta"><?php echo $tracking_added;?></p>
        </div>
        <?php 
            $video = get_field('spotlight_background-video', $component);
            $small_video = get_field('spotlight_background_small_video', $component);
            $video_image = get_field('spotlight_video_image', $component);
            $video_image_wide = get_field('spotlight_video_image_wide', $component);
        ?>
        
        <div class="container-fluid jubmotron-background">
                <?php
                $isMobile = isMobile();
                if($isMobile == "m"){
                    ?>
                    <div id="embed-responsive-16by9-img">
                        <div id="background-img" class="embed-responsive-item" autoplay="autoplay" loop="loop" muted>
                                <img src="<?php echo $video_image_wide['sizes']['large'];?>">
                        </div>
                    </div>
                    <div id="embed-responsive-4by3-img">
                        <div id="background-img"  class="video-img embed-responsive-item" style="background-image: url(<?php echo $video_image['sizes']['medium'];?>)">
                        </div>
                    </div>
                    <?php
                }
                else {
                    // Do something for only desktop users
                    ?>
                    <div id="embed-responsive-16by9-video" style="background-image: url(<?php echo $video_image_wide['sizes']['medium'];?>);background-repeat: no-repeat; background-size:cover">
                        <video id="background-movie" poster="<?php echo $video_image['sizes']['small'];?>"  class="embed-responsive-item" autoplay="autoplay" loop="loop" muted>
                            <source src="<?php echo $video['url'];?>" type="video/mp4">
                        </video>
                    </div>
                    <div id="embed-responsive-4by3-img">
                        <div id="background-img"  class="video-img embed-responsive-item" style="background-image: url(<?php echo $video_image['sizes']['medium'];?>)">
                        </div>
                    </div>
                    <?php
                }
                ?>
        </div>
    </section>
   
<?php
}
