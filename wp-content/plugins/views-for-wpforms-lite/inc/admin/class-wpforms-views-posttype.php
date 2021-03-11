<?php

class WPForms_Views_Posttype {
	function __construct() {
		add_action( 'init', array( $this, 'create_posttype' ) );
		add_filter( 'manage_posts_columns' , array( $this,'add_shortcode_column') );
		add_action( 'manage_wpforms-views_posts_custom_column' , array( $this, 'shortcode_column_detail' ), 10, 2 );
	}

	function create_posttype() {

		$labels = array(
			'name'               => _x( 'WPForms Views', 'post type general name', 'wpforms-views' ),
			'singular_name'      => _x( 'WPForms View', 'post type singular name', 'wpforms-views' ),
			'menu_name'          => _x( 'WPForms Views Lite', 'admin menu', 'wpforms-views' ),
			'name_admin_bar'     => _x( 'WPForms Views', 'add new on admin bar', 'wpforms-views' ),
			'add_new'            => _x( 'Add New', 'book', 'wpforms-views' ),
			'add_new_item'       => __( 'Add New', 'wpforms-views' ),
			'new_item'           => __( 'New WPForms View', 'wpforms-views' ),
			'edit_item'          => __( 'Edit WPForms View', 'wpforms-views' ),
			'view_item'          => __( 'View WPForms View', 'wpforms-views' ),
			'all_items'          => __( 'All Views', 'wpforms-views' ),
			'search_items'       => __( 'Search Views', 'wpforms-views' ),
			'parent_item_colon'  => __( 'Parent Views:', 'wpforms-views' ),
			'not_found'          => __( 'No view found.', 'wpforms-views' ),
			'not_found_in_trash' => __( 'No view found in Trash.', 'wpforms-views' )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'wpforms-views' ),
			'public'             => false,
			'exclude_from_search'=> true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'wpforms-views' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'menu_icon'		 => 'dashicons-format-gallery',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'false' )
		);

		register_post_type( 'wpforms-views', $args );
	}

	function add_shortcode_column( $columns ) {
		$columns = array_slice($columns, 0, 2, true) + array("shortcode" =>__( 'Shortcode', 'wpforms-views' )) + array_slice($columns, 2, count($columns)-2, true);
		//$columns['shortcode'] = __( 'Shortcode', 'wpforms-views' );
		return $columns;
	}

	function shortcode_column_detail( $column, $post_id ) {
		switch ( $column ) {

			case 'shortcode' :
				 echo '<code>[wpforms-views id='.$post_id.']</code>';
				break;

		}
	}

}

new WPForms_Views_Posttype();
