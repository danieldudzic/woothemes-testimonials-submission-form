<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Captcha Integration Class
 *
 * All functionality pertaining to the Testimonials Captcha Integration.
 *
 * @package WordPress
 * @subpackage Woothemes_Testimonials
 * @category Plugin
 * @author Danny
 * @since 1.0.0
 */
class Captcha_Integration {
	public $plugin_enabled;
	public $captcha_option;

	/**
	 * Captcha_Integration The single instance of Captcha_Integration.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Constructor function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( $file ) {
		add_action( 'woothemes_testimonials_submission_form_process_params', array( $this, 'load_captcha' ) );

		$this->captcha_option = get_option( '_woothemes_testimonials_submission_form_captcha' );

		// Check if the plugin is active.
		$this->captcha_check();

		add_filter( 'woothemes_testimonials_submission_form_fields', array( $this, 'register_captcha_fields' ) );
		add_filter( 'woothemes_testimonials_submission_form_validate_hooked_data', array( $this, 'validate_captcha_field' ), 10, 3 );


	}

	/**
	* Main Captcha_Integration Instance
	*
	* Ensures only one instance of Captcha_Integration is loaded or can be loaded.
	*
	* @since 1.0.0
	* @static
	* @return Main Captcha_Integration instance
	*/
	public static function instance ( $file ) {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self( $file );
		return self::$_instance;
	} // End instance()


	/**
	 * Check if the plugin is active and if the "captcha" param was set in the shortcode.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function captcha_check ( ) {
		// Captcha plugin integration.
		if( function_exists( 'cptch_display_captcha_custom' ) && function_exists( 'cptch_check_custom_form' ) ) {
			$this->plugin_enabled = true;
		} else {
			$this->plugin_enabled = false;
		}
	} // End captcha_check()

	public function load_captcha( $args ) {

		$this->process_captcha_option( $args );

		if( $this->plugin_enabled == true && $this->captcha_option == true ) {
			add_action( 'woothemes_testimonials_submission_form_before_submit_field', array( $this, 'output_external_captcha_field' ) );
		}

	}

	/**
	 * Handle the "captcha" parameter in the form shortcode.
	 *
	 * @param array $args submission_form function parameters.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function process_captcha_option ( $args ) {
		if( isset( $args['captcha'] ) && $args['captcha'] != '' ) {

			// Let's convert user input into a boolean
			$args['captcha'] = filter_var( $args['captcha'], FILTER_VALIDATE_BOOLEAN );

			if ( $args['captcha'] == true && $this->plugin_enabled == false ) {
				// In the case the "captcha" param is set in the shortcode, but the plugin is inactive print notice.
				add_filter( 'woothemes_testimonials_submission_form_add_notice', array( $this, 'generate_plugin_inactive_notice' ) );
			}

			if( $this->captcha_option != $args['captcha'] ) {
			    update_option( '_woothemes_testimonials_submission_form_captcha', $args['captcha'] );
			    $this->captcha_option = $args['captcha'];
		    }

		} else {
			delete_option( '_woothemes_testimonials_submission_form_captcha' );
		}
	} // End process_captcha_option()

	/**
	 * Generate a notice in case "captcha" param is set in the shortcode, but the plugin is inactive.
	 *
	 * @param array $response_items
	 * @access public
	 * @since 1.0.0
	 * @return array
	 */
	public function generate_plugin_inactive_notice ( $response_items ) {
		$response_items[] = array(
								'message' => __( 'In order to use the captcha verification you will have to install & activate the <a href="https://wordpress.org/plugins/captcha/">Captcha</a> plugin.', 'woothemes-testimonials-submission-form' ),
								'type' => 'error'
							);
		return $response_items;
	} // End generate_plugin_inactive_notice()

	/**
	 * Register captcha form fields.
	 *
	 * @param array $fields Form fields.
	 * @access public
	 * @since 1.0.0
	 * @return array
	 */
	public function register_captcha_fields ( $fields ) {
		$fields['cntctfrm_contact_action'] = array(
								  'type' => 'hidden',
								  'required' => false,
								  'value' => 'true'
							  );

		$fields['cptch_number'] = array(
								  'label' => __( 'Captcha', 'woothemes-testimonials-submission-form' ),
								  'type' => 'external',
								  'required' => true
							  );
		return $fields;
	} // End register_captcha_fields()

	/**
	 * Register captcha form fields.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return string
	 */
	public function output_external_captcha_field ( ) {
		$html = '<p class="form-row form-row-wide cntctfrm_contact_action">';
		$html .= cptch_display_captcha_custom();
		$html .=  __( '<span class="required">*</span>', 'woothemes-testimonials-submission-form' );
		$html .= '</p>';

		echo $html;
	} // End output_external_captcha_field()

	/**
	 * Validate the captcha input.
	 *
	 * @param array $fields Form fields.
	 * @param array $data $_POST hooked testimonial data.
	 * @param array $errors Field errors.
	 * @access public
	 * @since 1.0.0
	 * @return array
	 */
	public function validate_captcha_field ( $fields, $data, $errors ) {
		// Makes sure the email has been submitted.
		if ( isset ( $data[ 'cptch_number' ] ) && $data[ 'cptch_number' ] != '' ) {

			if( cptch_check_custom_form() == true ) {
				// valid
			} else {
				$errors['invalid_content']['cptch_number'] = true;
			}

		} else {
			$errors['missing_content']['cptch_number'] = true;
			$errors['missing_required']['cptch_number'] = true;
		}

		return $errors;
	} // End validate_captcha_field()

}