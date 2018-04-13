<?php
/**
 * Spotlight component
 *
 * @package Bamtech ESPN+
 */
/* Device detect */
function isMobile() {
    return preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
/* -------- */
// function isMobile(){
//     if(defined(isMobile)) { return isMobile;
//     @define(isMobile,(!($HUA=@trim(@$_SERVER['HTTP_USER_AGENT']))?0:
//     (
//        preg_match('/(android|bb\d+|meego).+mobile|silk|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i'
//        ,$HUA)
//     ||
//        preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i'
//        ,$HUA)
//     )
//     ));
// }

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
            <h1 class="jumbotron-heading"><?php the_field('spotlight_overlogo_text', $component);?></h1>
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
            <?php }?>

            <p class="below-cta"><?php echo $tracking_added;?></p>
    	
        </div>
    	
        <?php 
            $video = get_field('spotlight_background-video', $component);
            $small_video = get_field('spotlight_background_small_video', $component);
            $video_image = get_field('spotlight_video_image', $component);
        ?>
        
        <div class="container-fluid jubmotron-background">

            <div id="embed-responsive-16by9" class="">
                <?php
                // Use the function
                 if(isMobile()){
                    // Do something for only mobile users
                    ?>
                    <video id="background-img"  class="embed-responsive-item" preload="preload" autoplay="autoplay" loop="loop" muted>
                        <img src="<?php echo $video_image['sizes']['large'];?>" title="Your browser does not support the &lt;video&gt; tag" alt="ESPN+">
                    </video>
                    <?php
                }
                else {
                    // Do something for only desktop users
                    ?>
                    <video id="background-movie"  class="embed-responsive-item" preload="preload" autoplay="autoplay" loop="loop" muted>
                        <source src="<?php echo $video['url'];?>" type="video/mp4">
                        <img src="<?php echo $video_image['sizes']['large'];?>" title="Your browser does not support the &lt;video&gt; tag" alt="ESPN+">
                    </video>
                    <?php
                }
                ?>
            </div>

            <div id="embed-responsive-4by3" class="">
                <div id="background-movie"  class="video-img embed-responsive-item">

                    <img src="<?php echo $video_image['sizes']['medium'];?>" title="Your browser does not support the &lt;video&gt; tag" alt="ESPN+">
                    
            </div>
            </div>
        </div>

    </section>
   
<?php
}
