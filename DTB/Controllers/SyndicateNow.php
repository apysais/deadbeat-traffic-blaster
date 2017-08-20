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
		echo '</pre>';exit();*/
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
							$new_post_message = '';
							$post_message = '';
							$post_message  = $val_syndicate['message'];
							//echo $post_message;
							$replace_post = array($val['title'], $val['content'], $val['content_fifty'], $val['url']);
							//print_r($replace_post);
							$search_syndicate   = array("%TITLE%", "%CONTENT%", "%FIRST50%", "%LINK%");
							//print_r($search_syndicate);
							$new_post_message = str_replace($search_syndicate, $replace_post, $post_message);
							
							$post_title = '';
							$new_title_only = '';
							if( isset($val_syndicate['title']) ){
								$post_title = $val_syndicate['title'];
								$replace_title_only = array($val['title']);
								$search_title_only = array("%TITLE%");
								$new_title_only = str_replace($search_title_only, $replace_title_only, $post_title);
							}
							
							$post_content = $val_syndicate['message'];
							$replace_content_only = array($val['content']);
							$search_content_only = array("%CONTENT%");
							$new_content_only = str_replace($search_content_only, $replace_content_only, $post_content);

							$post_content_fifty = $val_syndicate['message'];
							$replace_content_fifty_only = array($val['content_fifty']);
							$search_content_fifty_only = array("%FIRST50%");
							$new_content_fifty_only = str_replace($search_content_fifty_only, $replace_content_fifty_only, $post_content_fifty);

							$post_link = $val_syndicate['message'];
							$replace_link = array($val['url']);
							$search_link = array("%LINK%");
							$new_link = str_replace($search_link, $replace_link, $post_link);
							
							switch($val_syndicate['service']){
								case 'facebook':
									if( isset($val_syndicate['pages']) ){
										$explode_pages = explode('::', $val_syndicate['pages']);
										//print_r($explode_pages);
										$page_access_token = '';
										if( isset($explode_pages[0]) ){
											$page_access_token = $explode_pages[0];
										}
										$page_id = '';
										if( isset($explode_pages[1]) ){
											$page_id = $explode_pages[1];
										}
										$app_id = $val_syndicate['app_id'];
										$app_secret = $val_syndicate['app_secret'];
										$fb_access_token = $val_syndicate['fb_access_token'];
										//echo 'facebook: '.$new_post_message.'<br>';
										$me = DTB_API_Facebook::get_instance()->publish_account(
											$page_id,
											$app_id,
											$app_secret,
											$page_access_token,
											$new_post_message
										);
										//print_r($me);
									}
									//run facebook post api here
								break;
								case 'twitter':
									$cred = array(
										'consumer_key' => $val_syndicate['consumer_key'],
										'consumer_secret' => $val_syndicate['consumer_secret'],
										'access_token' => $val_syndicate['access_token'],
										'access_token_secret' => $val_syndicate['access_token_secret'],
									);
									//run twitter post api here
									DTB_API_Twitter::get_instance()->post_status($cred, $new_post_message);
								break;
								case 'wordpress':
									$content = array(
										'title' => $new_title_only,
										'content' => $new_post_message,
									);
									$cred = array(
										'account_id' => $val_syndicate['account_id'],
										'client_id' => $val_syndicate['client_id'],
										'client_secret' => $val_syndicate['client_secret'],
										'api_token' => $val_syndicate['api_token'],
										'blog_id' => $val_syndicate['blog_id'],
									);
									$ret = DTB_API_WP::get_instance()->post_status($cred, $content);
									//echo 'wordpress: '.$new_post_message.'<br>';
									//run wordpress post api here
								break;
								case 'tumblr':
									if($val_syndicate['title'] != '' && $val_syndicate['message'] != ''){
										$post_array = array(
											'type' => 'text',
											'title' => $new_title_only,
											'body' => $new_content_only,
										);
										$arr_settings = array(
											'account_id' => $val_syndicate['account_id'],
											'blog_id' => $val_syndicate['blog_id'],
											'consumer_key' => $val_syndicate['consumer_key'],
											'consumer_secret' => $val_syndicate['consumer_secret'],
											'access_token' => $val_syndicate['access_token'],
											'access_token_secret' => $val_syndicate['access_token_secret'],
										);
										$ret = DTB_API_Tumblr::get_instance()->create_new_blog_post($arr_settings, $post_array);
									}
									//echo 'tumblr: '.$new_post_message.'<br>';
									//run tumblr post api here
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
