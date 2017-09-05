<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class DTB_API_Facebook {
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
	
	public function login($app_id, $app_secret){
		//$app_id = '1210726989041567';
		//$app_secret = 'f02ad8e69538fb2291da6adcfbc18769';
		$_SESSION['app_id'] = $app_id;
		$_SESSION['app_secret'] = $app_secret;
		
		$fb = new Facebook\Facebook([
		  'app_id' => $app_id, // Replace {app-id} with your app id
		  'app_secret' => $app_secret,
		  'default_graph_version' => 'v2.8',
		  ]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email', 'manage_pages', 'publish_pages']; // Optional permissions
		$url = admin_url('admin.php?page=dbtb-facebook&_method=fallback');
		$loginUrl = $helper->getLoginUrl($url, $permissions);
		echo '<div id="dbtb-wrapper" class="about-wrap wrap">';
		echo '<h2><a href="' . htmlspecialchars($loginUrl) . '&app_id='.$app_id.'&app_secret='.$app_secret.'">To gain permission click this to Log in with Facebook!</a></h2>';
		echo '</div>';
	}
	
	public function fallback(){
		$msg = array(
			'error' => array(),
			'success' => array()
		);
		$app_id = '';
		if( isset($_SESSION['app_id']) 
			&& trim($_SESSION['app_id']) != ''
		){
			$app_id = $_SESSION['app_id'];
		}
		$app_secret = '';
		if( isset($_SESSION['app_secret']) 
			&& trim($_SESSION['app_secret']) != ''
		){
			$app_secret = $_SESSION['app_secret'];
		}
		
		$fb = new Facebook\Facebook([
			'app_id' => $app_id, // Replace {app-id} with your app id
			'app_secret' => $app_secret,
			'default_graph_version' => 'v2.8',
		]);

		$helper = $fb->getRedirectLoginHelper();
		if (isset($_GET['state'])) {
			$helper->getPersistentDataHandler()->set('state', $_GET['state']);
		}
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  $msg['error'][] = 'Graph returned an error: ' . $e->getMessage();
		  return $msg;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  $msg['error'][] = 'Facebook SDK returned an error: ' . $e->getMessage();
		  return $msg;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
			/*header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";*/
			$msg['error'] = array(
				"Error: " . $helper->getError(),
				"Error Code: " . $helper->getErrorCode(),
				"Error Reason: " . $helper->getErrorReason(),
				"Error Description: " . $helper->getErrorDescription()
			);
		  } else {
			//header('HTTP/1.0 400 Bad Request');
			$msg['error'][] = 'Bad request';
		  }
		  return $msg;
		}
		
		
		
		// Logged in
		$msg['success']['accessTokenLogged'] = $accessToken->getValue();
		//var_dump($accessToken->getValue());

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		$msg['success']['tokenMetadata'] = $tokenMetadata;

		// Validation (these will throw FacebookSDKException's when they fail)
		$tokenMetadata->validateAppId($app_id); // Replace {app-id} with your app id
		// If you know the user ID this access token belongs to, you can validate it here
		//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		  // Exchanges a short-lived access token for a long-lived one
		  try {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		  } catch (Facebook\Exceptions\FacebookSDKException $e) {
			$msg['error'][] = "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
			return $msg;
		  }

		  //echo '<h3>Long-lived</h3>';
		  $msg['success']['accessTokenLongLived'] = $accessToken->getValue();
		}

		$fb_access_token = (string) $accessToken;
		$msg['success']['fb_access_token'] = $fb_access_token;
		return $msg;
	}
	
	public function me($app_id, $app_secret, $access_token){
		$fb = new Facebook\Facebook([
		  'app_id' => $app_id,
		  'app_secret' => $app_secret,
		  'default_graph_version' => 'v2.2',
		  ]);

		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $fb->get('/me?fields=id,name', $access_token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		return $response->getGraphUser();
	}
	
	public function me_account($app_id, $app_secret, $access_token){
		$fb = new Facebook\Facebook([
		  'app_id' => $app_id,
		  'app_secret' => $app_secret,
		  'default_graph_version' => 'v2.2',
		  ]);

		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $fb->get('/me?fields=accounts', $access_token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		return $response;
	}

	public function publish_account($fb_page_id, $app_id, $app_secret, $access_token, $message){
		$fb = new Facebook\Facebook([
		  'app_id' => $app_id,
		  'app_secret' => $app_secret,
		  'default_graph_version' => 'v2.2',
		  ]);
		//$access_token = 'EAARNJlgaD58BALEZAF9HH56tW3tJ8rGy7iiwQ5DrCHTp0RDIBpbH6lZAvFNLjUxogrD6P6k78s19yhda0Qrikw0mPsE1sN34dGTXhYAfB6jnouM1DRyN2LFCZCuzGs1Xzb1p37jXV5Ih7m4t1WI8w2l452gVqfrQeMVuvImBsomZC4mDcicV';
		$request = $fb->request('POST',
			'/'.$fb_page_id.'/feed', 
			['message' => $message], 
			$access_token
		);

		// Send the request to Graph
		try {
			$response = $fb->getClient()->sendRequest($request);
			$graphNode = $response->getGraphNode();
			return $graphNode;
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  return 'Graph returned an error: ' . $e->getMessage();
		  //exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  return 'Facebook SDK returned an error: ' . $e->getMessage();
		  //exit;
		}

		
	}
	
	public function get_access_token($page_id){
	}
	
	public function __construct(){}
}

