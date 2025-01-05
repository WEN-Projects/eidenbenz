<?php
function divi__child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'divi__child_theme_enqueue_styles' );
 
 
//you can add custom functions below this line:


// Register Custom Post Type
function eb_register_cpt() {

    $labels = array(
        'name'                  => _x( 'Kundenarchivs', 'Post type general name', 'eidenbenz' ),
        'singular_name'         => _x( 'Kundenarchiv', 'Post type singular name', 'eidenbenz' ),
        'menu_name'             => _x( 'Kundenarchivs', 'Admin Menu text', 'eidenbenz' ),
        'name_admin_bar'        => _x( 'Kundenarchiv', 'Add New on Toolbar', 'eidenbenz' ),
        'add_new'               => __( 'Add New', 'eidenbenz' ),
        'add_new_item'          => __( 'Add New Kundenarchiv', 'eidenbenz' ),
        'new_item'              => __( 'New Kundenarchiv', 'eidenbenz' ),
        'edit_item'             => __( 'Edit Kundenarchiv', 'eidenbenz' ),
        'view_item'             => __( 'View Kundenarchiv', 'eidenbenz' ),
        'all_items'             => __( 'All Kundenarchivs', 'eidenbenz' ),
        'search_items'          => __( 'Search Kundenarchivs', 'eidenbenz' ),
        // 'parent_item_colon'     => __( 'Parent Kundenarchivs:', 'eidenbenz' ),
        // 'not_found'             => __( 'No Kundenarchivs found.', 'eidenbenz' ),
        // 'not_found_in_trash'    => __( 'No Kundenarchivs found in Trash.', 'eidenbenz' ),
        // 'featured_image'        => _x( 'Kundenarchivk Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'eidenbenz' ),
        // 'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'eidenbenz' ),
        // 'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'eidenbenz' ),
        // 'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'eidenbenz' ),
        // 'archives'              => _x( 'Kundenarchiv archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'eidenbenz' ),
        // 'insert_into_item'      => _x( 'Insert into Kundenarchiv', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'eidenbenz' ),
        // 'uploaded_to_this_item' => _x( 'Uploaded to this Kundenarchiv', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'eidenbenz' ),
        // 'filter_items_list'     => _x( 'Filter Kundenarchiv list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'eidenbenz' ),
        // 'items_list_navigation' => _x( 'Kundenarchivs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'eidenbenz' ),
        // 'items_list'            => _x( 'Kundenarchivs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'eidenbenz' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => false, //disable the sinlge page and only enable archive page for the post type kundenarchiv
        'rewrite'            => array( 'slug' => 'kundenarchiv' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'author' ),
    );
 
    register_post_type( 'kundenarchiv', $args );

    register_taxonomy( 'bereich', 'kundenarchiv', array( //register taxonomy material for collection posts
        'label'        => __( 'Bereich', 'bereich' ),
        'public'       => false,
        'rewrite'      => false,
        'hierarchical' => true,
        'show_ui' => true, 
        'show_admin_column' => true, 
        'show_in_nav_menus' => true, 
        'show_tagcloud' => true
    ) );

}
add_action( 'init', 'eb_register_cpt' );

if ( file_exists( get_stylesheet_directory() . "/inc/class-kundenarchiv-filter.php" ) ) {
	require_once get_stylesheet_directory() . "/inc/class-kundenarchiv-filter.php"; //functionality that handles the kundenarchiv posts filter
}

function wpdocs_theme_name_scripts() { //enqueue custom js
	wp_enqueue_script( 'kundenarchiv-custom-js', get_stylesheet_directory_uri() . '/js/kundenarchiv-custom.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

function eb_posts_where( $where, $query ) { //filter to customize wp query, so that it can list post that begins with the specific letter.
    global $wpdb;

    $starts_with = esc_sql( $query->get( 'starts_with' ) );

    if ( $starts_with ) {
        $where .= " AND $wpdb->posts.post_title LIKE '$starts_with%'";
    }

    return $where;
}
add_filter( 'posts_where', 'eb_posts_where', 10, 2 );

