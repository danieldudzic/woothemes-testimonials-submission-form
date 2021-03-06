<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Enable the usage of do_action( 'woothemes_testimonials_submission_form' ) to display a slideshow within a theme/plugin.
 *
 * @since  1.0.6
 */
add_action( 'woothemes_testimonials_submission_form', 'woothemes_testimonials_submission_form_html' );

if ( ! function_exists( 'woothemes_testimonials_submission_form_html' ) ) {
/**
 * Generate the testimonials submission form html.
 *
 * @param array $args woothemes_testimonials_submission_form_html function parameters.
 * @access public
 * @since 1.6.0
 * @return string Submission form html.
 */
function woothemes_testimonials_submission_form_html ( $args = '' ) {

	// Check if the Testimonials by WooThemes plugin is installed and activated.
	if( class_exists( 'Woothemes_Testimonials' ) ) {

		$args = Submission_Form()->process_parameters( $args );

		// Print an initial notice.
		Submission_Form()->initial_notice();

		$html = '';

		ob_start();
		do_action( 'woothemes_testimonials_submission_form_before_form' );
	    $html .= ob_get_contents();
	    ob_end_clean();

		$html .= '<div id="testimonials-submission">';
		$html .= '<h2>' . __( 'Add a testimonial', 'woothemes-testimonials-submission-form' ) . '</h2>';
		$html .= '<form method="post" class="testimonials-submission">';

		ob_start();
		do_action( 'woothemes_testimonials_submission_form_before_form_fields' );
	    $html .= ob_get_contents();
	    ob_end_clean();

	    $fields = Submission_Form()->get_submission_form_fields();

		foreach ( $fields as $field_name => $field_params ) {

			if ( $field_params['type'] == 'external' ) {
				$html .= '';
				break;
			}

			if ( $field_params['required'] == true ) {
				$required = __( '<span class="required">*</span>', 'woothemes-testimonials-submission-form' );
			} else {
				$required = '';
			}

			if ( $field_params['type'] == 'submit' ) {

				ob_start();
				do_action( 'woothemes_testimonials_submission_form_before_submit_field' );
				$html .= ob_get_contents();
				ob_end_clean();

			}

			if ( $field_params['type'] == 'hidden' ) {

				$html .= '<input type="hidden" name="' . $field_name . '" id="' . $field_name . '" value="' . $field_params['value'] . '" />';
				continue;

			}

			$html .= '<p class="form-row form-row-wide ' . $field_name . '">';

				if ( $field_params['type'] == 'text' ) {

					$html .= '<label for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
					$html .= '<input type="text" class="input-text" name="' . $field_name . '" id="' . $field_name . '" />';

				} elseif ( $field_params['type'] == 'textarea' ) {

					$html .= '<label for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
					$html .= '<textarea class="input-textarea" name="' . $field_name . '" rows="10" cols="40" id="' . $field_name . '"></textarea>';

			    } elseif ( $field_params['type'] == 'email' ) {

				    $html .= '<label for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
					$html .= '<input type="text" class="input-email" name="' . $field_name . '" id="' . $field_name . '" />';

			    } elseif ( $field_params['type'] == 'byline' ) {

				    $html .= '<label for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
					$html .= '<input type="text" class="input-byline" name="' . $field_name . '" id="' . $field_name . '" />';

			    } elseif ( $field_params['type'] == 'website_url' ) {

				    $html .= '<label for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
				    $html .= '<input type="text" class="input-website-url" name="' . $field_name . '" id="' . $field_name . '" />';

			    } elseif ( $field_params['type'] == 'checking' ) {

				    $html .= '<label class="input-checking" for="' . $field_name . '">' . $field_params['label'] . $required . '</label>';
				    $html .= '<input type="text" class="input-checking" name="' . $field_name . '" id="' . $field_name . '" />';

			    } elseif ( $field_params['type'] == 'submit' ) {

				    $html .= '<input type="submit" class="button" name="' . $field_name . '" id="' . $field_name . '" value="' . $field_params['label'] . '" />';

			    }

			$html .= '</p>';
		}

		ob_start();
		do_action( 'woothemes_testimonials_submission_form_after_form_fields' );
	    $html .= ob_get_contents();
	    ob_end_clean();

		$html .= '</form>';
		$html .= '</div>';

		ob_start();
		do_action( 'woothemes_testimonials_submission_form_after_form' );
	    $html .= ob_get_contents();
	    ob_end_clean();

	    // Allow child themes/plugins to filter here.
		$html = apply_filters( 'woothemes_testimonials_submission_form_html', $html, $args );

	} else {
		$html = __( '<div class="woothemes-testimonials-notice error">In order to use the submission form, please install & activate the <a href="https://wordpress.org/plugins/testimonials-by-woothemes/"><strong>Testimonials by WooThemes</strong></a> plugin first.</div>', 'woothemes-testimonials-submission-form' );
	}

	if ( $args['echo'] != true ) { return $html; }

	// Should only run is "echo" is set to true.
	echo $html;
} // End woothemes_testimonials_submission_form_html()
}

if ( ! function_exists( 'woothemes_testimonials_submission_form_shortcode' ) ) {
/**
 * Testimonials submission form shortcode function.
 *
 * @param array $atts [woothemes_testimonials_submission_form] shortcode parameters.
 * @access public
 * @since 1.6.0
 * @return void
 */
function woothemes_testimonials_submission_form_shortcode ( $atts ) {
	$args = (array)$atts;

	$defaults = array(
		'echo' => true
	);

	$args = wp_parse_args( $defaults, $args );

	return woothemes_testimonials_submission_form_html( $args );

} // End woothemes_testimonials_submission_form_shortcode()
}

add_shortcode( 'woothemes_testimonials_submission_form', 'woothemes_testimonials_submission_form_shortcode' );
?>