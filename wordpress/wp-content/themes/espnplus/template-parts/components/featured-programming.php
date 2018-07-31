<?php
/**
* Featured_programming component
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
$component = get_field('component_featured_programming', $page_id);

//for use in the loop, list 5 post titles related to first tag on current post
$tags = wp_get_post_tags($post->ID);
if ($tags) {
  $related_minimum = 1;
  $related_maximum = 10;
  $related_tags = NULL;
  foreach ($tags as $tag) {
    $related_tags .= $tag->term_id . ', ';
  }
  $related_tags = preg_replace('/, $/','',$related_tags);
  $args=array(
    'post_type' => 'featured_programming',
    'tag__in' => array($related_tags),
    'post__not_in' => array($post->ID),
    'posts_per_page' => $related_maximum,
    'ignore_sticky_posts' => 1,
    'meta_query'     => array(
      'datetime_clause' => array(
        'key' => 'program_datetime',
	'value' => date('Y-m-d H:i:s'),
	'type' => 'DATETIME',
	'compare' => '>='
      )
    ),
    'orderby'    => array(
      'datetime_clause' => 'ASC'
    )
  );
  $related_query = new WP_Query($args);
  if( $related_query->found_posts >= $related_minimum ) {
?>

<!--BEGINNING OF SECTION GOES HERE -->
<section>

<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>

<p><?php the_title(); ?><br />
<?php the_field('program_datetime'); ?><br />
<?php the_field('leaguesport_code'); ?></p>

<?php endwhile; ?>

<!--END OF SECTION GOES HERE -->
</section>

<?php
  }
  wp_reset_query();
}
?>
