<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_Post {
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
		
	public function get_posts($posts = array()){
		$posts_array = array();
		if( is_array($posts) && !empty($posts) ){
			$args = array(
				'post__in' => $posts,
				'post_type' => array('post', 'deadbeatposts')
			);
			$get_posts = get_posts( $args );

			if( $get_posts ){
				
				foreach($get_posts as $key => $val){
					$posts_array[] = array(
						'id' => $val->ID,
						'title' => $val->post_title,
						'content' => $val->post_content,
						'content_fifty' => substr($val->post_content,0,50) . '...',
						'url' => get_permalink($val->ID),
					);
				}
			}
			return $posts_array;
		}
		return false;
	}
	
	public function parse_message_title($source, $post){
		$array_parse = array();
		$msg = '';
		if( isset($source['message']) ){
			$msg = $source['message'];
		}
		$title = '';
		if( isset($source['title']) ){
			$title = $source['title'];
		}
		
		$post_title= '';
		if( isset($post['title']) ){
			$post_title= $post['title'];
		}
		$post_content= '';
		if( isset($post['content']) ){
			$post_content= $post['content'];
		}
		$post_content_fifty= '';
		if( isset($post['content_fifty']) ){
			$post_content_fifty= $post['content_fifty'];
		}
		$post_url= '';
		if( isset($post['url']) ){
			$post_url= $post['url'];
		}
		
		$replace_post = array(
			$post_title, 
			$post_content, 
			$post_content_fifty, 
			$post_url
		);
		
		$search_syndicate = array(
			"%TITLE%", 
			"%CONTENT%", 
			"%FIRST50%", 
			"%LINK%"
		);
		$array_parse['message'] = str_replace($search_syndicate, $replace_post, $msg);
		$array_parse['title'] = str_replace(array("%TITLE%"), $post_title, $title);
		
		return $array_parse;
	}
	
	public function __construct(){}	
}
