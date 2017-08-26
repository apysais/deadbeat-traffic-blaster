<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_Queue {
	protected static $instance = null;
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
		
	public function menu_slug(){
		return 'dbtb-queue';
	}
	
	/**
	 * Add sub menu page
	 *
	 * @since 1.0.0
	 */
	public function add_admin_submenu() {
		$textdomain = dbtb_get_text_domain();
		$parent = DTB_Admin_DeadBeatTrafficBlaster::get_instance()->menu_slug();
		add_submenu_page(
			$parent,
			esc_html__( 'Queue Syndicate', $textdomain ),
			esc_html__( 'Queue Syndicate', $textdomain ),
			'manage_options',
			$this->menu_slug(),
			array(DTB_Controllers_Queue::get_instance(), 'controller')
		);
	}
	
	public function init_hook(){
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'add_admin_submenu' ) );
			add_action( 'init', array( $this, 'codex_deabdeat_init' ) );
		}
	}
	public function codex_deabdeat_init() {
		$textdomain = dbtb_get_text_domain();
		$labels = array(
			'name'               => _x( 'Deadbeat Posts', 'post type general name', $textdomain ),
			'singular_name'      => _x( 'Deadbeat Post', 'post type singular name', $textdomain ),
			'menu_name'          => _x( 'Deadbeat Posts', 'admin menu', $textdomain ),
			'name_admin_bar'     => _x( 'Deadbeat Post', 'add new on admin bar', $textdomain ),
			'add_new'            => _x( 'Add New', 'book', $textdomain ),
			'add_new_item'       => __( 'Add New Deadbeat Post', $textdomain ),
			'new_item'           => __( 'New Deadbeat Post', $textdomain ),
			'edit_item'          => __( 'Edit Deadbeat Post', $textdomain ),
			'view_item'          => __( 'View Deadbeat Post', $textdomain ),
			'all_items'          => __( 'All Deadbeat Posts', $textdomain ),
			'search_items'       => __( 'Search Deadbeat Posts', $textdomain ),
			'parent_item_colon'  => __( 'Parent Deadbeat Posts:', $textdomain ),
			'not_found'          => __( 'No Deadbeat Post found.', $textdomain ),
			'not_found_in_trash' => __( 'No Deadbeat Posts found in Trash.', $textdomain )
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', $textdomain ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'deadbeatposts' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( 'deadbeatposts', $args );
	}
	
	public function get_posts(){
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'deadbeatposts',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'	   => '',
			'author_name'	   => '',
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts_array = get_posts( $args );
		return $posts_array;
	}
	
	public function __construct(){
		$this->init_hook();
	}	
}
