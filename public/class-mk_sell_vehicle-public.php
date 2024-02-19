<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webmkit.com
 * @since      1.0.0
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mk_sell_vehicle
 * @subpackage Mk_sell_vehicle/public
 * @author     webmk <masudrana.bbpi@gmail.com>
 */
class Mk_sell_vehicle_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mk_sell_vehicle-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mk_sell_vehicle-public.js', array( 'jquery' ), $this->version, false );

	}

	public function mk_sell_vehicle_form_shortcode_callback(){

		global $wpdb;
		$mk_sell_vehicle_make = $wpdb->get_results(
			"SELECT make FROM {$wpdb->prefix}mk_sell_vehicle GROUP BY make ORDER BY id DESC"
		);

		ob_start();
		require_once(plugin_dir_path(__FILE__).'partials/mk_sell_vehicle-public-display.php');
		$template = ob_get_contents();
		ob_clean();
		echo $template;
	}

	public function sell_vehicle_form_make_ajax_callback(){
		global $wpdb;
		$data_make = isset($_POST['mk_sell_vehicle_form_make']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_make']) : '';

		$get_form_data_model = $wpdb->get_results(
			"SELECT model FROM {$wpdb->prefix}mk_sell_vehicle WHERE make='{$data_make}' GROUP BY model ORDER BY id DESC"
		);
		echo json_encode($get_form_data_model);
	}

	public function sell_vehicle_form_model_ajax_callback(){
		global $wpdb;
		$data_model = isset($_POST['mk_sell_vehicle_form_model']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_model']) : '';

		$get_form_data_trim = $wpdb->get_results(
			"SELECT `trim` FROM {$wpdb->prefix}mk_sell_vehicle WHERE model='{$data_model}' GROUP BY `trim` ORDER BY id DESC"
		);
		echo json_encode($get_form_data_trim);
	}

	public function sell_vehicle_form_submition_ajax_callback(){
		global $wpdb;
		$data_email = isset($_POST['mk_sell_vehicle_form_email']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_email']) : '';
		$data_phone = isset($_POST['mk_sell_vehicle_form_phone']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_phone']) : '';
		$data_year = isset($_POST['mk_sell_vehicle_form_year']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_year']) : '';
		$data_make = isset($_POST['mk_sell_vehicle_form_make']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_make']) : '';
		$data_model = isset($_POST['mk_sell_vehicle_form_model']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_model']) : '';
		$data_trim = isset($_POST['mk_sell_vehicle_form_trim']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_trim']) : '';
		$data_mileage = isset($_POST['mk_sell_vehicle_form_mileage']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_mileage']) : '';
		$data_message = isset($_POST['mk_sell_vehicle_form_message']) ? sanitize_text_field($_POST['mk_sell_vehicle_form_message']) : '';


		$site_title = get_bloginfo('blogname');

		$message = "Message: {$data_message} <br> Phone: {$data_phone} <br> Year: {$data_year} <br> Make: {$data_make} <br> Model: {$data_model} <br> Trim: {$data_trim} <br> Mileage: {$data_mileage}";

		// mailer variables
		$to = get_bloginfo('admin_email');
		$subject = "Sell Vehicle Request from - {$site_title}";
		$headers = 'From: '. $data_email . "\r\n" . 'Reply-To: ' . $data_email . "\r\n";

		$sent = wp_mail($to, $subject, $message, $headers);
		if($sent){
			echo "Thank you. we received your data. we will contact you as soon as possible via email or phone.";
		}else{
			echo "Oops!! Something went wrong. Please try again.";
		}
	}

}
