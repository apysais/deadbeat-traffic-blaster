<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Notice Class | Singleton
 *
 *	Display success, error notice after a event
 *
 * @since 3.12
 * @access (protected, public)
 * */
class DTB_Notice{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	
	protected $notice;

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
	
	public function set($val){
		$_SESSION['notice'] = $val;
	}
	
	public function get(){
		return $_SESSION['notice'];
	}
	
	public function getError(){
		if( isset($_SESSION['notice']['error']) ){
			return $_SESSION['notice']['error'];
		}
		return false;
	}

	public function getSuccess(){
		if( isset($_SESSION['notice']['success']) ){
			return $_SESSION['notice']['success'];
		}
		return false;
	}
	
	public function clear(){
		if( isset($_SESSION['notice']['error']) ){
			unset($_SESSION['notice']['error']);
		}
		if( isset($_SESSION['notice']['success']) ){
			unset($_SESSION['notice']['success']);
		}
		//unset($_SESSION['notice']);
	}
	
	public function __construct(){
		$this->clear();
	}

}
