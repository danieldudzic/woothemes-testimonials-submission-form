<?php
/**
 * Plugin Name: Submission Form for Testimonials by WooThemes
 * Plugin URI: http://woothemes.com/
 * Description: A small, nifty plugin that extends Testimonials by WooThemes and enables your users testimonials submissions via a simple form.
 * Version: 1.0.0
 * Author: WooThemes
 * Author URI: http://woothemes.com/
 * Requires at least: 4.0.0
 * Tested up to: 4.1
 *
 * Text Domain: woothemes-testimonials-submission-form
 * Domain Path: /lang/
 *
 * @package WordPress
 * @subpackage Woothemes_Testimonials_Submission_Form
 * @category Core
 * @author @danieldudzic
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Returns the main instance of WooThemes_Testimonials_Submission_Form to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object WooThemes_Testimonials_Submission_Form
 */
function WooThemes_Testimonials_Submission_Form () {
	return WooThemes_Testimonials_Submission_Form::instance( __FILE__ );
} // End Starter_Plugin()

function Submission_Form () {
	return Submission_Form::instance( __FILE__ );
} // End Starter_Plugin()

function Captcha_Integration () {
	return Captcha_Integration::instance( __FILE__ );
} // End Starter_Plugin()

WooThemes_Testimonials_Submission_Form();

/**
 * Main WooThemes_Testimonials_Submission_Form Class
 *
 * @class Woothemes_Testimonials_Submission_Form
 * @version	1.0.0
 * @since 1.0.0
 * @package	WordPress
 * @author Danny
 */
final class WooThemes_Testimonials_Submission_Form {
	/**
	 * WooThemes_Testimonials_Submission_Form The single instance of WooThemes_Testimonials_Submission_Form.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * File.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	/**
	 * The plugin directory URL.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_url;

	/**
	 * The plugin directory path.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plugin_path;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
		$this->token 			= 'woothemes-testimonials-submission-form';
		$this->file 			= $file;
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.0.0';

		// Main plugin class
		require_once( 'classes/class-submission-form.php' );

		// Captcha integration class
		require_once( 'classes/class-captcha-integration.php' );


		require_once( 'templates/woothemes-testimonials-submission-form-template.php' );

		Submission_Form();

		Captcha_Integration();

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

	} // End __construct()


	/**
	 * Main WooThemes_Testimonials_Submission_Form Instance
	 *
	 * Ensures only one instance of WooThemes_Testimonials_Submission_Form is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WooThemes_Testimonials_Submission_Form()
	 * @return Main WooThemes_Testimonials_Submission_Form instance
	 */
	public static function instance ( $file ) {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self( $file );
		return self::$_instance;
	} // End instance()

	/**
	 * Load the plugin's localisation file.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'woothemes-testimonials-submission-form', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation()

	/**
	 * Load the plugin textdomain from the main WordPress "languages" folder.
	 * @since  1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'woothemes-testimonials-submission-form';
	    // The "plugin_locale" filter is also used in load_plugin_textdomain()
	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_plugin_textdomain()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	} // End __wakeup()

	/**
	 * Installation. Runs on activation.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install () {
		$this->_log_version_number();
	} // End install()

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number () {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	} // End _log_version_number()

} // End Class
?>
