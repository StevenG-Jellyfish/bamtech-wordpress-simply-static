<?php

function cptui_register_my_cpts() {

    /**
     * Post Type: News.
     */

    $labels = array(
        "name" => __( 'News', 'html5blank' ),
        "singular_name" => __( 'News', 'html5blank' ),
    );

    $args = array(
        "label" => __( 'News', 'html5blank' ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "news", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "news", $args );
}

//add_action( 'init', 'cptui_register_my_cpts' );


