<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Controllers_SyndicateNow extends DTB_Base{
	protected static $instance = null;
	protected $tumblr_menu_slug = null;
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

	public function dbtb_syndicate_now(){
		$data = array();
		$args = array(
			'posts_per_page'   => -1,
			'post_type' => array('post','deadbeatposts'),
			'post_status' => 'publish',
		);
		$posts_array = get_posts( $args );
		$data['method'] = 'post_syndicate_now';
		$data['action'] = 'admin.php?page=' . $this->menu_slug;
		$data['posts_array'] = $posts_array;
		DTB_View::get_instance()->admin_partials('partials/syndicate-now/main.php', $data);
	}
	
	public function post_syndicate_now(){
		/*echo '<pre>';
		print_r($_POST);
		echo '</pre>';*/
		$has_posts_selected = false;
		//get posts
		$posts = array();
		$posts_array = array();
		if( isset($_POST['posts']) ){
			$has_posts_selected = true;
			$posts = $_POST['posts'];
			$args = array(
				'post__in' => $posts
			);
			$get_posts = get_posts( $args );

			if( $get_posts ){
				foreach($get_posts as $key => $val){
					$posts_array[] = array(
						'id' => $val->ID,
						'title' => $val->post_title,
						'content' => wp_strip_all_tags($val->post_content),
						'content_fifty' => substr(wp_strip_all_tags($val->post_content),0,50) . '...',
						'url' => get_permalink($val->ID),
					);
				}
			}
			/*echo '<pre>';
			print_r($posts_array);
			echo '</pre>';*/
			if( !empty($posts_array) && !empty($_POST['syndicate']) ){
				$syndicate = $_POST['syndicate'];
				foreach($posts_array as $key => $val){
					foreach($syndicate as $key_syndicate => $val_syndicate){
						if( isset($val_syndicate['service']) ){
							switch($val_syndicate['service']){
								case 'facebook':
									$post_message = '';
									$post_message  = $val_syndicate['message'];
									//echo $post_message;
									$replace_post = array($val['title'], $val['content'], $val['content_fifty'], $val['url']);
									//print_r($replace_post);
									$search_syndicate   = array("%TITLE%", "%CONTENT%", "%FIRST50%", "%LINK%");
									//print_r($search_syndicate);
									$new_post_message = str_replace($search_syndicate, $replace_post, $post_message);
									echo ':'.$new_post_message.'<br>';
								break;
							}
						}
					}
				}
			}
		}
		
		//get posts
	}
	
	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}
	
	public function __construct(){
		$this->menu_slug = DTB_Admin_SyndicateNow::get_instance()->menu_slug();
	}
}
