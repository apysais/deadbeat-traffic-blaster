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
			'post_type' 	   => array('post', 'deadbeatposts'),
			'post_status' => 'publish',
		);
		$posts_array = get_posts( $args );
		$data['method'] = 'post_syndicate_now';
		$data['action'] = 'admin.php?page=' . $this->menu_slug;
		$data['posts_array'] = $posts_array;
		DTB_View::get_instance()->admin_partials('partials/syndicate-now/main.php', $data);
	}
	
	public function post_syndicate_now(){
		$has_posts_selected = false;
		//get posts
		$posts = array();
		$posts_array = array();
		$result_syndicate = array();
		if( isset($_POST['posts']) ){
			$has_posts_selected = true;
			$posts = $_POST['posts'];
			$posts_array = DTB_Admin_Post::get_instance()->get_posts($posts);
			if( !empty($posts_array) && !empty($_POST['syndicate']) ){
				$syndicate = $_POST['syndicate'];
				foreach($posts_array as $key => $val){
					foreach($syndicate as $key_syndicate => $val_syndicate){
						if( isset($val_syndicate['service']) ){
							$source = array(
								'message' => $val_syndicate['message'],
								'title' => isset($val_syndicate['title']) ? $val_syndicate['title']:'',
							);
							$replace_post = array(
								'title' => $val['title'], 
								'content' => $val['content'], 
								'content_fifty' => $val['content_fifty'], 
								'url' => $val['url']
							);
							$parse_content = DTB_Admin_Post::get_instance()->parse_message_title($source, $replace_post);
							
							switch($val_syndicate['service']){
								case 'facebookx':
									if( isset($val_syndicate['pages']) ){
										$explode_pages = explode('::', $val_syndicate['pages']);
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
										$me = DTB_API_Facebook::get_instance()->publish_account(
											$page_id,
											$app_id,
											$app_secret,
											$page_access_token,
											$parse_content['message']
										);
										//print_r($me);
										//echo $me['id'];
										if( isset($me['id']) ){
											$result_syndicate['success'][] = 'Facebook successfully syndicated';
										}else{
											$result_syndicate['error'][] = 'Facebook error: '.$me;
										}
									}
									//run facebook post api here
								break;
								case 'twitterx':
									$cred = array(
										'consumer_key' => $val_syndicate['consumer_key'],
										'consumer_secret' => $val_syndicate['consumer_secret'],
										'access_token' => $val_syndicate['access_token'],
										'access_token_secret' => $val_syndicate['access_token_secret'],
									);
									//run twitter post api here
									$res = DTB_API_Twitter::get_instance()->post_status($cred, $parse_content['message']);
									if( isset($res->errors) ){
										$result_syndicate['error'][] = 'Twitter error: '.$res->errors[0]->message;
									}else{
										$result_syndicate['success'][] = 'Twitter successfully syndicated';
									}
								break;
								case 'wordpressx':
									$content = array(
										'title' => $parse_content['title'],
										'content' => $parse_content['message'],
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
									if( isset($ret->error) ){
										$result_syndicate['error'][] = 'WordPress error: '.$ret->error.'-'.$ret->message;
									}else{
										$result_syndicate['success'][] = 'WordPress successfully syndicated';
									}
									//print_r($result_syndicate);
								break;
								case 'tumblr':
									if($val_syndicate['title'] != '' && $val_syndicate['message'] != ''){
										$post_array = array(
											'type' => 'text',
											'title' => $parse_content['title'],
											'body' => $parse_content['message'],
										);
										$arr_settings = array(
											'account_id' => $val_syndicate['account_id'],
											'blog_id' => $val_syndicate['blog_id'],
											'consumer_key' => $val_syndicate['consumer_key'],
											'consumer_secret' => $val_syndicate['consumer_secret'],
											'access_token' => $val_syndicate['access_token'],
											'access_token_secret' => $val_syndicate['access_token_secret'],
										);
										try{
											DTB_API_Tumblr::get_instance()->create_new_blog_post($arr_settings, $post_array);
											$result_syndicate['success'][] = 'Tumblr successfully syndicated';
										}
										catch(Tumblr\API\RequestException $e){
											$result_syndicate['error'][] = 'Tumblr error: '.$e->getMessage();
										}
										//print_r($result_syndicate);
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
