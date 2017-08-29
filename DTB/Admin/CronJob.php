<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_Admin_CronJob {
	protected static $instance = null;
	protected $model;
	protected $queue_model_items;
	protected $queue_model_meta;
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
	
		
	public function menu_slug($id){
		return '?dtbcronjob='.$id;
	}
	
	public function http_request_print($dtbcronjob_id = null){
		global $wp_query;
		//wget "http://test.dev/wp/?dtbcronjob=123"
		//curl "http://test.dev/wp/?dtbcronjob=123"
		//print_r($wp_query);
		//print_r($_GET);

		//echo isset($_GET['dtbcronjob']) ? 'y':'n';

		if( !is_null($dtbcronjob_id) && isset($_GET['dtbcronjob']) ){
			$dtbcronjob_id = $_GET['dtbcronjob'];
		}

		if( $dtbcronjob_id ){
			$post_id_array = array();
			$queue_items_id_array = array();
			
			$queue_id = $dtbcronjob_id;
			$queue = $this->model->get_db_list($queue_id);
			//$items = $this->queue_model_items->get_db_list($queue_id);
			$items = $this->queue_model_items->get_item_not_posted($queue_id);
			if( $items ){
				foreach($items as $k => $v){
					$post_id_array[] = $v->post_id;
					$queue_items_id_array[] = $v->deadbeat_queue_id;
				}//foreach($items as $k => $v)
			}

			$accounts = $this->account->get();
			$posts_array = DTB_Admin_Post::get_instance()->get_posts($post_id_array);
			$source = array(
				'title' => '%TITLE%',
				'message' => '%CONTENT%',
				'first50' => '%FIRST50%',
				'link' => '%LINK%',
			);
			if( !empty($posts_array) ){
				foreach($posts_array as $k => $val){
					$post_id = $val['id'];
					$replace_post = array(
						'title' => $val['title'], 
						'content' => $val['content'], 
						'content_fifty' => $val['content_fifty'], 
						'url' => $val['url']
					);
					$new_msg = str_replace($source, $replace_post, $source);
					/*echo '<pre>';
					print_r($accounts);
					echo '</pre>';*/
					
					foreach($accounts as $key_accounts => $val_accounts){
						$_creds = unserialize($val_accounts->settings);
						switch($val_accounts->service){
							case 'facebookx':
								
								$app_id = $_creds['app_id'];
								$app_secret = $_creds['app_secret'];
								$fb_access_token = $_creds['fb_access_token'];
								
								$fb_page = $this->queue_model_meta->get_by_queue_id($queue_id, 'facebook_page');
								$fb_page_meta = unserialize($fb_page[0]->meta_value);
								
								$fb_page_token_array = '';
								$fb_page_token = '';
								$fb_api_pages = DTB_Admin_Facebook::get_instance()->get_pages_id($val_accounts->account_id);
								if( $fb_api_pages ){
									foreach($fb_api_pages as $k => $v){
										if( in_array($v['id'], $fb_page_meta) ){
											$fb_page_token = $v['access_token'];
											$me = DTB_API_Facebook::get_instance()->publish_account(
												$v['id'],
												$app_id,
												$app_secret,
												$fb_page_token,
												$new_msg['title'].'-'.$new_msg['link']
											);
										}
									}
								}
							break;
							case 'twitterx':
								$consumer_key = $_creds['consumer_key'];
								$consumer_secret = $_creds['consumer_secret'];
								$access_token = $_creds['access_token'];
								$access_token_secret = $_creds['access_token_secret'];
								$cred = array(
									'consumer_key' => $consumer_key,
									'consumer_secret' => $consumer_secret,
									'access_token' => $access_token,
									'access_token_secret' => $access_token_secret,
								);
								//run twitter post api here
								DTB_API_Twitter::get_instance()->post_status($cred, $new_msg['title'].' '.$new_msg['link']);
							break;
							case 'wordpressx':
								$content = array(
									'title' => $new_msg['title'],
									'content' => $new_msg['content'],
								);
								$cred = array(
									'account_id' => $_creds['account_id'],
									'client_id' => $_creds['client_id'],
									'client_secret' => $_creds['client_secret'],
									'api_token' => $_creds['api_token'],
									'blog_id' => $_creds['blog_id'],
								);
								$ret = DTB_API_WP::get_instance()->post_status($cred, $content);
								//echo 'wordpress: '.$new_post_message.'<br>';
								//run wordpress post api here
								
							break;
							case 'tumblrx':
								$tumbrl_post_array = array(
									'type' => 'text',
									'title' => $new_msg['title'],
									'body' => $new_msg['message'],
								);
								
								if( isset($_creds['account_id']) ){
									$arr_settings = array(
										'account_id' => $_creds['account_id'],
										'blog_id' => $_creds['blog_id'],
										'consumer_key' => $_creds['consumer_key'],
										'consumer_secret' => $_creds['consumer_secret'],
										'access_token' => $_creds['access_token'],
										'access_token_secret' => $_creds['access_token_secret'],
									);
									$ret = DTB_API_Tumblr::get_instance()->create_new_blog_post($arr_settings, $tumbrl_post_array);
								}
								//echo 'tumblr: '.$new_post_message.'<br>';
								//run tumblr post api here
							break;
						}
					}//foreach($accounts as $key_accounts => $val_accounts)
					$this->queue_model_items->db_update_is_posted($queue_id, $post_id);
				}//foreach($posts_array as $k => $val)
			}else{
				$ret = $this->queue_model_items->db_reset_post($queue_id);
				//$this->http_request_print($queue_id);
			}//if( !empty($posts_array) )
			die();
		}//if( isset($_GET['dtbcronjob']) )
	}
	
	public function __construct(){
		if( !is_admin() ){
			add_action('init', array($this,'http_request_print'));
		}
		
		$this->account = new DTB_Admin_AccountDB;
		$this->model = new DTB_Model_Queue;
		$this->queue_model_items = new DTB_Model_QueueItem;
		$this->queue_model_meta = new DTB_Model_QueueMeta;
	}	
}
