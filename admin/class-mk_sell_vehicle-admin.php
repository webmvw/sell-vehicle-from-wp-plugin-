<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/admin
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Mk_sell_vehicle_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mk_sell_vehicle_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mk_sell_vehicle_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mk_sell_vehicle-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style( "dataTables", plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mk_sell_vehicle_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mk_sell_vehicle_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mk_sell_vehicle-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "dataTables", plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );

	}

	public function mk_sell_vehicle_admin_menu(){
		add_menu_page( "MK Sell Vehicle", "MK Sell Vehicle", "manage_options", "mk_sell_vehicle", array($this, 'mk_sell_vehicle_dashboard') );
		add_submenu_page( "mk_sell_vehicle", "Dashboard", "Dashboard", "manage_options", "mk_sell_vehicle", array($this, 'mk_sell_vehicle_dashboard') );
		add_submenu_page( "mk_sell_vehicle", "Vehicle", "Vehicle", "manage_options", "mk_vehicle", array($this, 'callback_mk_vehicle') );
	}

	public function mk_sell_vehicle_dashboard(){
		ob_start();
		include plugin_dir_path( __FILE__ ).'partials/dashboard/dashboard.php';
		$ob_template = ob_get_contents();
		ob_clean();
		echo $ob_template;
	}


	public function callback_mk_vehicle(){
		global $wpdb;
		$mk_sell_vehicle_data = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}mk_sell_vehicle ORDER BY id DESC"
		);

		$action = isset($_GET['action']) ? $_GET['action'] : 'list';

		switch($action){
			case 'edit':
				$template = plugin_dir_path( __FILE__ ). 'partials/vehicle/edit-vehicle.php';
				break;

			case 'delete':
				$template = plugin_dir_path( __FILE__ ). 'partials/vehicle/delete-vehicle.php';
				break;	

			default:
				$template = plugin_dir_path(__FILE__).'partials/vehicle/view-vehicle.php';
				break;
		}

		if(file_exists($template)){
			ob_start();
			include $template;
			$ob_template = ob_get_contents();
			ob_clean();
			echo $ob_template;
		}

	}


	public function sell_vehicle_insert_ajax_callback(){
		global $wpdb;
	    $data['make'] = isset($_POST['mk_vehicle_make']) ? sanitize_textarea_field($_POST['mk_vehicle_make']) : '';
	    $data['model'] = isset($_POST['mk_vehicle_model']) ? sanitize_textarea_field($_POST['mk_vehicle_model']) : '';
	    $data['trim'] = isset($_POST['mk_vehicle_trim']) ? sanitize_textarea_field($_POST['mk_vehicle_trim']) : '';
		$inserted = $wpdb->insert(
			"{$wpdb->prefix}mk_sell_vehicle",
			$data,
			[
				'%s', '%s', '%s'
			]
		);
		if($inserted){
			$last_record = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}mk_sell_vehicle ORDER BY id DESC LIMIT 1"
			);
			// echo json_encode(
			// 	array('year' => $data['year'], 'make' => $data['make'], 'model' => $data['model'], 'trim' => $data['trim'], 'value' => $data['value'])
			// );
			echo json_encode($last_record);
		}else{
			echo '<span style="color:red">Data Not Insert</span>';
		}
	}


}
