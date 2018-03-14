<?php
/**
 * Spotlight component
 *
 * @package lincolntech
 */
 $page_id = get_query_var('page_override_id');
 if (empty($page_id)) {
	   $page_id = get_the_ID();
 }
 $component = get_field('component_spotlight', $page_id);
 if ($component !== false) {
?>

<!-- SPOTLIGHT -->
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading"><?php echo get_field('spotlight_overlogo_text', $component);?> <em>MORE</em></h1>
        <div class="jumbotron-logo">
            <img src="<?php echo get_field('spotlight_logo_image', $component);?>"> <!--*** replace src with {{spotlight_logo_image}} -->
        </div>
        <p class="lead">
            The NEW <?php echo get_field('spotlight_main_text', $component);?> ESPN.<br>
            Live Sports, ESPN Originals, Only $4.99 a month.
        </p>
        <div class="espn-cta-container">
            <div class="parallelogram">
                <a href="{{ spotlight_cta_link }}" class="btn btn-primary espn-cta"><?php echo get_field('spotlight_cta_text', $component);?></a>
                <!--*** Add in phase II if we put color controls into admin:
                    style="background-color: {{ spotlight_cta_background_color }}; color: {{ spotlight_cta_text_color }};" 
                -->
            </div>
        </div>
        <p class="below-cta">
		<?php echo get_field('spotlight_belowcta_text', $component);?> <a href="#">terms</a>.
        </p>
    </div>
    <div class="container-fluid jubmotron-background">
        <div class="embed-responsive embed-responsive-16by9 div_style">
            <video id="background-movie" preload autoplay>
                <source src="../../_video/001_ALL_7Pannel_021618.mp4" type="video/mp4">
                <source src="../../_video/001_ALL_7Pannel_021618.mp4" type="video/ogg">
                <img src="../../_images/001_ALL_7Pannel_021618.png" title="Your browser does not support the <video> tag">
            </video>
        </div>
    </div>
</section>
<!-- SPOTLIGHT ###-->
<?php
 
}
