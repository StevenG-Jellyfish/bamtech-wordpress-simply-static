<?php
/**
 * Header component
 *
 * @package lincolntech
 */
 $page_id = get_query_var('page_override_id');
 if (empty($page_id)) {
	   $page_id = get_the_ID();
 }
 $component = get_field('component_header', $page_id);
 if ($component !== false) {
?>

<!--GLOBAL STICKY HEADER -->
<header>
	<nav class="navbar navbar-fixed-top">
	  <div class="container">
	    <div class="navbar-header"> 
	    <?php
			if (get_field('header_logo_cta', $component)) {
	    ?>
	    	<a class="navbar-brand" href="<?php echo get_field('header_logo_cta_url', $component);?>" style="display: block;">
	    <?php
	    	} else {
			?>
				<span class="navbar-brand" style="display: block;">
			<?php
				} 
      		if (get_field_object('header_logo_type', $component)['value'] == 'inline') {
      			echo get_field('header_logo_inline', $component);
      		} else {
      			echo "<img src='".get_field('header_logo', $component)."'>";
      		}	
      		if (get_field('header_logo_cta', $component)) {
	    ?>
	      </a>
	    <?php
	  		} else {
			?>
				</span>
			<?php
				}
	  	?>
	    </div>
		
	  </div>
	</nav>
</header>
<!--GLOBAL STICKY HEADER ###-->
<?php
 }
?>
<!-- start main -->
<main class="main" id="main">
