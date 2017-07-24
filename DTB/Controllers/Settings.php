<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Lbc_Controllers_Settings extends Lbc_Base{
	protected static $instance = null;
	protected $setting_db_entity = null;
	protected $setting_db = null;
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
	
	public function update_settings(){
		$front_slider = $_POST['front_page_envira_id'];
		$inner_slider = $_POST['inner_page_envira_id'];
		$this->setting_db_entity->update_slider_front($front_slider);
		$this->setting_db_entity->update_slider_inner($inner_slider);
		$this->lbc_settings_theme();
	}
	
	public function lbc_settings_theme(){
		global $wpdb;
		$data = array();
		$data['heading'] = 'Theme Settings';
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'envira',
			'post_status'      => 'publish'
		);
		$envira_posts_array = get_posts( $args ); 
		$data['envira'] = $envira_posts_array;
		$data['method'] = 'update_settings';
		$data['action'] = 'admin.php?page=lbc-settings-theme';
		$data['db_slider_front'] = $this->setting_db_entity->get_slider_front();
		$data['db_slider_inner'] = $this->setting_db_entity->get_slider_inner();
		$data['choose_home_slider'] = Lbc_View::get_instance()->admin_part_partials('settings/front-page-dropdown.php', $data);
		$data['choose_page_slider'] = Lbc_View::get_instance()->admin_part_partials('settings/inner-page-dropdown.php', $data);
		Lbc_View::get_instance()->admin_partials('settings/index.php', $data);
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
		$this->setting_db_entity = new Lbc_Model_Settings_DBEntity;
		$this->setting_db = new Lbc_Model_Settings;
	}
}
