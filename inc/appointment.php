<?php
/**
 * The theme's own forms: appointment request, contact and newsletter.
 *
 * A clinic's site exists to get a patient an appointment, so Docmed ships the
 * forms rather than requiring a plugin for the one thing a visitor came to do.
 * One shortcode draws all three:
 *
 *     [docmed_form type="appointment" layout="grid" button="Confirm appointment request"]
 *     [docmed_form type="contact" layout="split"]
 *     [docmed_form type="newsletter" layout="stacked"]
 *
 * The header's "Make an Appointment" button opens the same appointment form in
 * a dialog (docmed_appointment_dialog() below, opened by interactions.js);
 * with JavaScript off it is a link to the Appointment page.
 *
 * It is a **shortcode**, not inline PHP in a pattern. That is not a style
 * preference: inc/front-page-setup.php expands patterns into real post content
 * so the copy stays editable, and PHP inside stored post content never runs.
 * A pattern that rendered the form inline would freeze whatever it produced at
 * activation into the page forever.
 *
 * A theme must not create database tables or register a post type, so Docmed
 * stores nothing. It validates, then hands the submission to whoever wants it:
 *
 *   - `docmed_form_handlers` — return true from any handler to say the
 *     submission has been dealt with, and the built-in email is skipped. This
 *     is where a practice-management system, a mailing list or a webhook
 *     hooks in (and how a demo site swallows mail).
 *   - `docmed_appointment_departments` / `docmed_appointment_doctors` — the
 *     choices in the appointment form's two drop-downs.
 *   - `docmed_form_email_to` / `_subject` / `_body` — adjust the email the
 *     theme sends when nothing else claims the submission.
 *   - `docmed_form_fields` — add, remove or relabel fields, per form type.
 *
 * The forms work with JavaScript off: each is a plain POST to the same URL,
 * answered with a redirect carrying the result.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;

const DOCMED_FORM_ACTION = 'docmed_form';

/**
 * The form types and their fields.
 *
 * @param string $type appointment, contact or newsletter.
 * @return array<string, array<string, mixed>>
 */
function docmed_form_fields( $type ) {
	$name  = array(
		'label'        => __( 'Your name', 'docmed' ),
		'type'         => 'text',
		'autocomplete' => 'name',
		'required'     => true,
	);
	$email = array(
		'label'        => __( 'Email address', 'docmed' ),
		'type'         => 'email',
		'autocomplete' => 'email',
		'required'     => true,
	);

	$sets = array(
		'appointment' => array(
			'department' => array(
				'label'    => __( 'Department', 'docmed' ),
				'type'     => 'select',
				'required' => true,
				'options'  => docmed_appointment_departments(),
			),
			'doctor'     => array(
				'label'    => __( 'Doctor', 'docmed' ),
				'type'     => 'select',
				'required' => false,
				'options'  => docmed_appointment_doctors(),
				'empty'    => __( 'Any available doctor', 'docmed' ),
			),
			'date'       => array(
				'label'    => __( 'Preferred date', 'docmed' ),
				'type'     => 'date',
				'required' => true,
				'min'      => gmdate( 'Y-m-d' ),
			),
			'time'       => array(
				'label'    => __( 'Preferred time', 'docmed' ),
				'type'     => 'select',
				'required' => false,
				'options'  => array(
					'morning'   => __( 'Morning, 8am to 12pm', 'docmed' ),
					'afternoon' => __( 'Afternoon, 12pm to 4pm', 'docmed' ),
					'evening'   => __( 'Evening, 4pm to 7pm', 'docmed' ),
				),
				'empty'    => __( 'Any time', 'docmed' ),
			),
			'name'       => $name,
			'phone'      => array(
				'label'        => __( 'Phone number', 'docmed' ),
				'type'         => 'tel',
				'autocomplete' => 'tel',
				'required'     => false,
				'reach'        => true,
			),
			'email'      => array_merge(
				$email,
				array(
					'required' => false,
					'reach'    => true,
				)
			),
			'message'    => array(
				'label'    => __( 'Reason for the visit (optional)', 'docmed' ),
				'type'     => 'textarea',
				'required' => false,
			),
		),
		'contact'     => array(
			'message' => array(
				'label'    => __( 'Message', 'docmed' ),
				'type'     => 'textarea',
				'required' => true,
			),
			'name'    => $name,
			'email'   => $email,
			'subject' => array(
				'label'    => __( 'Subject', 'docmed' ),
				'type'     => 'text',
				'required' => false,
			),
			'phone'   => array(
				'label'        => __( 'Phone number (optional)', 'docmed' ),
				'type'         => 'tel',
				'autocomplete' => 'tel',
				'required'     => false,
			),
		),
		'newsletter'  => array(
			'email' => $email,
		),
	);

	$fields = isset( $sets[ $type ] ) ? $sets[ $type ] : array();

	/**
	 * Filters the fields of one of the theme's forms.
	 *
	 * @param array  $fields Field definitions keyed by name.
	 * @param string $type   appointment, contact or newsletter.
	 */
	return apply_filters( 'docmed_form_fields', $fields, $type );
}

/**
 * The known form types.
 *
 * @return string[]
 */
function docmed_form_types() {
	return array( 'appointment', 'contact', 'newsletter' );
}

/**
 * The appointment form's departments, value => label.
 *
 * The values match the `?department=` links on the department cards, which
 * preselect the choice.
 *
 * @return array<string, string>
 */
function docmed_appointment_departments() {
	return apply_filters(
		'docmed_appointment_departments',
		array(
			'family'   => __( 'Family medicine', 'docmed' ),
			'eye'      => __( 'Eye care', 'docmed' ),
			'physio'   => __( 'Physiotherapy', 'docmed' ),
			'dental'   => __( 'Dental care', 'docmed' ),
			'lab'      => __( 'Diagnostics and lab', 'docmed' ),
			'skin'     => __( 'Dermatology', 'docmed' ),
			'children' => __( "Children's health", 'docmed' ),
		)
	);
}

/**
 * The appointment form's doctors, value => label.
 *
 * @return array<string, string>
 */
function docmed_appointment_doctors() {
	return apply_filters(
		'docmed_appointment_doctors',
		array(
			'hale'    => __( 'Dr. Robert Hale, family medicine', 'docmed' ),
			'mensah'  => __( 'Dr. Daniel Mensah, family medicine', 'docmed' ),
			'saleh'   => __( 'Dr. Amira Saleh, paediatrics', 'docmed' ),
			'paredes' => __( 'Dr. Lucia Paredes, optometry', 'docmed' ),
			'ramos'   => __( 'Dr. Sofia Ramos, dentistry', 'docmed' ),
			'novak'   => __( 'Dr. Elena Novak, dermatology', 'docmed' ),
			'haddad'  => __( 'Karim Haddad, physiotherapy', 'docmed' ),
			'quispe'  => __( 'Dr. Mateo Quispe, diagnostics', 'docmed' ),
		)
	);
}

/**
 * Render one field, label included.
 *
 * Every field has a real <label for>. The compact and inline layouts hide it
 * visually and show the same words as the placeholder, as the design does —
 * the label is still what a screen reader announces.
 *
 * @param string $form  Form type.
 * @param string $name  Field name.
 * @param array  $field Field definition.
 * @param bool   $quiet Whether the label is visually hidden.
 * @param string $scope Distinguishes two copies of one form on a page (the
 *                      appointment page's form and the header's dialog).
 * @return string
 */
function docmed_form_field( $form, $name, $field, $quiet, $scope = '' ) {
	$id       = 'docmed-' . $form . $scope . '-' . $name;
	$required = ! empty( $field['required'] );

	$attributes = array(
		'id'    => $id,
		'name'  => $name,
		'class' => 'docmed-field__control',
	);

	if ( $required ) {
		$attributes['required'] = 'required';
	}
	if ( ! empty( $field['autocomplete'] ) ) {
		$attributes['autocomplete'] = $field['autocomplete'];
	}
	if ( isset( $field['min'] ) ) {
		$attributes['min'] = $field['min'];
	}
	// A select and a date input have no placeholder to carry the words, so
	// they keep a visible label in every layout.
	$shows_label = ! $quiet || in_array( $field['type'], array( 'date', 'select' ), true );
	if ( ! $shows_label ) {
		$attributes['placeholder'] = $field['label'] . ( $required ? ' *' : '' );
	}
	if ( ! empty( $field['reach'] ) ) {
		$attributes['aria-describedby'] = 'docmed-' . $form . $scope . '-reach';
	}

	$label_class = 'docmed-field__label' . ( $shows_label ? '' : ' screen-reader-text' );

	$out  = '<p class="docmed-field docmed-field--' . esc_attr( $name ) . '">';
	$out .= '<label class="' . esc_attr( $label_class ) . '" for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] );
	if ( $required ) {
		$out .= ' <span class="docmed-field__required" aria-hidden="true">*</span>';
	}
	$out .= '</label>';

	if ( 'textarea' === $field['type'] ) {
		$attributes['rows'] = 4;
		$out               .= '<textarea' . docmed_attributes( $attributes ) . '></textarea>';
	} elseif ( 'select' === $field['type'] ) {
		$chosen = docmed_form_preselect( $name );
		$out   .= '<select' . docmed_attributes( $attributes ) . '>';
		if ( $required ) {
			$out .= '<option value="">' . esc_html__( 'Choose one', 'docmed' ) . '</option>';
		} else {
			$out .= '<option value="">' . esc_html( isset( $field['empty'] ) ? $field['empty'] : __( 'No preference', 'docmed' ) ) . '</option>';
		}
		foreach ( $field['options'] as $value => $text ) {
			$out .= '<option value="' . esc_attr( $value ) . '"' . selected( $chosen, (string) $value, false ) . '>' . esc_html( $text ) . '</option>';
		}
		$out .= '</select>';
	} else {
		$attributes['type'] = $field['type'];
		$out               .= '<input' . docmed_attributes( $attributes ) . '>';
	}

	return $out . '</p>';
}

/**
 * A choice passed in the address, such as the department cards'
 * `?department=eye`. Only ever compared with the field's own option values.
 *
 * @param string $name Field name.
 * @return string
 */
function docmed_form_preselect( $name ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- selects a default, changes nothing.
	return isset( $_GET[ $name ] ) && in_array( $name, array( 'department', 'doctor' ), true ) ? sanitize_key( wp_unslash( $_GET[ $name ] ) ) : '';
}

/**
 * Build an attribute string from a map, escaping every value.
 *
 * @param array $attributes Attribute map.
 * @return string
 */
function docmed_attributes( $attributes ) {
	$out = '';
	foreach ( $attributes as $key => $value ) {
		if ( '' === $value ) {
			continue;
		}
		$out .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}
	return $out;
}

/**
 * The form shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function docmed_form( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'type'   => 'appointment',
			'layout' => '',
			'button' => '',
		),
		$atts,
		'docmed_form'
	);

	return docmed_render_form( $atts['type'], $atts['layout'], $atts['button'] );
}

/**
 * Draw one of the forms.
 *
 * @param string $type   appointment, contact or newsletter.
 * @param string $layout grid, split, inline or stacked; '' for the type's own.
 * @param string $label  Button text; '' for the type's own.
 * @param string $scope  Suffix that keeps ids unique when the same form is on
 *                       the page twice (the header's dialog uses `-dialog`).
 * @return string
 */
function docmed_render_form( $type, $layout = '', $label = '', $scope = '' ) {
	$type = in_array( $type, docmed_form_types(), true ) ? $type : 'appointment';

	$defaults = array(
		'appointment' => array( 'grid', __( 'Confirm appointment request', 'docmed' ) ),
		'contact'     => array( 'split', __( 'Send message', 'docmed' ) ),
		'newsletter'  => array( 'stacked', __( 'Subscribe', 'docmed' ) ),
	);

	$layout = in_array( $layout, array( 'grid', 'split', 'inline', 'stacked' ), true ) ? $layout : $defaults[ $type ][0];
	$label  = '' !== $label ? $label : $defaults[ $type ][1];
	$quiet  = 'stacked' !== $layout || 'newsletter' === $type;
	$anchor = 'docmed-form-' . $type . $scope;
	$fields = docmed_form_fields( $type );

	$out  = '<form class="docmed-form docmed-form--' . esc_attr( $layout ) . ' docmed-form--' . esc_attr( $type ) . '" method="post" action="' . esc_url( docmed_current_url() ) . '#' . esc_attr( 'docmed-form-' . $type ) . '">';
	$out .= '<span id="' . esc_attr( $anchor ) . '" class="docmed-form__anchor"></span>';
	$out .= docmed_form_notice( $type );
	// The nonce written by hand rather than with wp_nonce_field(), which gives
	// it an id: two forms on one page would then share it.
	$out .= '<input type="hidden" name="docmed_form_nonce" value="' . esc_attr( wp_create_nonce( DOCMED_FORM_ACTION ) ) . '">';
	$out .= '<input type="hidden" name="action" value="' . esc_attr( DOCMED_FORM_ACTION ) . '">';
	$out .= '<input type="hidden" name="docmed_form_type" value="' . esc_attr( $type ) . '">';

	// The page to come back to, carried explicitly.
	//
	// wp_get_referer() cannot do this job: it returns false whenever the
	// referer matches the current request URI, which is always the case for a
	// form that posts to its own page, and the visitor would land on the front
	// page with no form in sight. Validated with wp_validate_redirect() on the
	// way back out, so a crafted value cannot send anyone off-site.
	$out .= '<input type="hidden" name="docmed_redirect" value="' . esc_url( docmed_current_url() ) . '">';

	// A field no visitor sees and no visitor fills in. Bots fill everything.
	$out .= '<p class="docmed-form__trap" aria-hidden="true">';
	$out .= '<label for="' . esc_attr( 'docmed-' . $type . $scope . '-website' ) . '">' . esc_html__( 'Leave this field empty', 'docmed' ) . '</label>';
	$out .= '<input id="' . esc_attr( 'docmed-' . $type . $scope . '-website' ) . '" type="text" name="docmed_website" tabindex="-1" autocomplete="off">';
	$out .= '</p>';

	$out .= '<div class="docmed-form__grid">';
	foreach ( $fields as $name => $field ) {
		$out .= docmed_form_field( $type, $name, $field, $quiet, $scope );
	}
	$out .= '</div>';

	// Phone or email: either is enough to confirm a time, and the form says so
	// rather than marking both as required.
	foreach ( $fields as $field ) {
		if ( ! empty( $field['reach'] ) ) {
			$out .= '<p id="' . esc_attr( 'docmed-' . $type . $scope . '-reach' ) . '" class="docmed-form__hint">' . esc_html__( 'Give us a phone number or an email address (or both) so we can confirm the time.', 'docmed' ) . '</p>';
			break;
		}
	}

	$out .= '<p class="docmed-form__actions">';
	$out .= '<button type="submit" class="wp-block-button__link wp-element-button">' . esc_html( $label ) . '</button>';
	$out .= '</p>';
	$out .= '</form>';

	return $out;
}
add_shortcode( 'docmed_form', 'docmed_form' );

/**
 * The current URL, without any previous result parameters.
 *
 * @return string
 */
function docmed_current_url() {
	$url = is_singular() ? get_permalink() : '';
	if ( ! $url ) {
		$url = home_url( add_query_arg( array() ) );
	}
	return remove_query_arg( array( 'docmed-form', 'docmed-form-type' ), $url );
}

/**
 * The message shown after a submission, on the form that was submitted.
 *
 * @param string $type Form type.
 * @return string
 */
function docmed_form_notice( $type ) {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- display only.
	$result = isset( $_GET['docmed-form'] ) ? sanitize_key( wp_unslash( $_GET['docmed-form'] ) ) : '';
	$which  = isset( $_GET['docmed-form-type'] ) ? sanitize_key( wp_unslash( $_GET['docmed-form-type'] ) ) : '';
	// phpcs:enable

	if ( $which !== $type ) {
		return '';
	}

	$sent = array(
		'appointment' => __( 'Thank you — your request is with our reception team. We will call or email to confirm a time, usually within one working day.', 'docmed' ),
		'contact'     => __( 'Thank you — your message is with us. We will reply by email shortly.', 'docmed' ),
		'newsletter'  => __( 'Thank you — you are on the list for the next newsletter.', 'docmed' ),
	);

	$messages = array(
		'sent'    => array( 'ok', $sent[ $type ] ),
		'invalid' => array( 'error', __( 'Please check the form: every field marked * needs an answer.', 'docmed' ) ),
		'email'   => array( 'error', __( 'That email address does not look right.', 'docmed' ) ),
		'reach'   => array( 'error', __( 'Please give a phone number or an email address, so we can confirm the time.', 'docmed' ) ),
		'failed'  => array( 'error', __( 'Sorry, that could not be sent. Please call the clinic instead.', 'docmed' ) ),
		'expired' => array( 'error', __( 'That form had been open a while and expired. Please send it again.', 'docmed' ) ),
	);

	if ( ! isset( $messages[ $result ] ) ) {
		return '';
	}

	list( $kind, $text ) = $messages[ $result ];

	return '<p class="docmed-form__notice is-' . esc_attr( $kind ) . '" role="status">' . esc_html( $text ) . '</p>';
}

/**
 * Handle a submitted form.
 *
 * Runs on `template_redirect` so it can redirect before anything is sent —
 * the POST/redirect/GET that stops a refresh from sending it twice.
 */
function docmed_handle_form() {
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : '' ) ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- checked immediately below.
	if ( ! isset( $_POST['action'] ) || DOCMED_FORM_ACTION !== $_POST['action'] ) {
		return;
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- nonce checked below; these only select the form and where to go.
	$type     = isset( $_POST['docmed_form_type'] ) ? sanitize_key( wp_unslash( $_POST['docmed_form_type'] ) ) : '';
	$posted   = isset( $_POST['docmed_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['docmed_redirect'] ) ) : '';
	// phpcs:enable
	$type     = in_array( $type, docmed_form_types(), true ) ? $type : 'appointment';
	$redirect = wp_validate_redirect( $posted, home_url( '/' ) );
	$redirect = remove_query_arg( array( 'docmed-form', 'docmed-form-type' ), $redirect );

	$nonce = isset( $_POST['docmed_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['docmed_form_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, DOCMED_FORM_ACTION ) ) {
		docmed_form_redirect( $redirect, $type, 'expired' );
	}

	// Silently accept and discard anything that filled the honeypot: telling a
	// bot it failed only teaches it to try again differently.
	if ( ! empty( $_POST['docmed_website'] ) ) {
		docmed_form_redirect( $redirect, $type, 'sent' );
	}

	$submission = array();
	foreach ( docmed_form_fields( $type ) as $name => $field ) {
		$raw = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitised by type below.
		$raw = is_string( $raw ) ? $raw : '';

		if ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} elseif ( 'email' === $field['type'] ) {
			$value = sanitize_email( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}

		// Something typed that is not an address gets the email message, not
		// "every field marked * needs an answer": sanitize_email() empties it.
		if ( 'email' === $field['type'] && '' !== trim( $raw ) && ! is_email( $value ) ) {
			docmed_form_redirect( $redirect, $type, 'email' );
		}

		if ( ! empty( $field['required'] ) && '' === $value ) {
			docmed_form_redirect( $redirect, $type, 'invalid' );
		}

		// A choice from a list must be one of the list's own values.
		if ( 'select' === $field['type'] && '' !== $value && ! isset( $field['options'][ $value ] ) ) {
			docmed_form_redirect( $redirect, $type, 'invalid' );
		}

		if ( ! empty( $field['reach'] ) && '' !== $value ) {
			$reachable = true;
		}

		$submission[ $name ] = $value;
	}

	// Phone or email, at least one.
	if ( isset( $reachable ) || ! array_filter( docmed_form_fields( $type ), 'docmed_field_is_reach' ) ) {
		$reachable = true;
	} else {
		docmed_form_redirect( $redirect, $type, 'reach' );
	}

	if ( ! empty( $submission['email'] ) && ! is_email( $submission['email'] ) ) {
		docmed_form_redirect( $redirect, $type, 'email' );
	}

	/**
	 * Filters whether the submission has already been handled.
	 *
	 * Return true from any handler and Docmed will not send its own email —
	 * which is how a practice-management system, a mailing list or a webhook
	 * takes over, and how a demo site swallows every submission.
	 *
	 * @param bool   $handled    Whether something has dealt with it.
	 * @param array  $submission The sanitised submission.
	 * @param string $type       appointment, contact or newsletter.
	 */
	$handled = apply_filters( 'docmed_form_handlers', false, $submission, $type );

	if ( ! $handled ) {
		$handled = docmed_form_email( $submission, $type );
	}

	docmed_form_redirect( $redirect, $type, $handled ? 'sent' : 'failed' );
}
add_action( 'template_redirect', 'docmed_handle_form' );

/**
 * Whether a field is one of the "phone or email" pair.
 *
 * @param array $field Field definition.
 * @return bool
 */
function docmed_field_is_reach( $field ) {
	return ! empty( $field['reach'] );
}

/**
 * Redirect back to the form with a result, and stop.
 *
 * @param string $url    Where to go.
 * @param string $type   Form type.
 * @param string $result Result key.
 */
function docmed_form_redirect( $url, $type, $result ) {
	$url = add_query_arg(
		array(
			'docmed-form'      => $result,
			'docmed-form-type' => $type,
		),
		$url
	);
	wp_safe_redirect( $url . '#docmed-form-' . $type, 303 );
	exit;
}

/**
 * Email the submission to the site's admin address.
 *
 * From: is the site's own address, never the visitor's. Putting the visitor
 * there fails SPF and DMARC — the mail is sent by this server, not by their
 * provider — and it is the classic route to header injection. Reply-To carries
 * them instead, and wp_mail() rejects a header containing a newline.
 *
 * @param array  $submission Sanitised submission.
 * @param string $type       Form type.
 * @return bool
 */
function docmed_form_email( $submission, $type ) {
	$to = apply_filters( 'docmed_form_email_to', get_option( 'admin_email' ), $type );

	if ( ! $to || ! is_email( $to ) ) {
		return false;
	}

	$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$what = array(
		/* translators: %s: site name. */
		'appointment' => __( '[%s] Appointment request', 'docmed' ),
		/* translators: %s: site name. */
		'contact'    => __( '[%s] Website message', 'docmed' ),
		/* translators: %s: site name. */
		'newsletter' => __( '[%s] Newsletter sign-up', 'docmed' ),
	);
	$subject = sprintf( $what[ $type ], $site );
	$subject = apply_filters( 'docmed_form_email_subject', $subject, $submission, $type );

	$lines  = array();
	$fields = docmed_form_fields( $type );
	foreach ( $submission as $name => $value ) {
		if ( '' === $value ) {
			continue;
		}
		$label = isset( $fields[ $name ]['label'] ) ? $fields[ $name ]['label'] : $name;
		if ( isset( $fields[ $name ]['options'][ $value ] ) ) {
			$value = $fields[ $name ]['options'][ $value ];
		}
		$lines[] = $label . ': ' . $value;
	}

	$body = implode( "\n", $lines );
	$body = apply_filters( 'docmed_form_email_body', $body, $submission, $type );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( ! empty( $submission['email'] ) && is_email( $submission['email'] ) ) {
		$headers[] = 'Reply-To: ' . $submission['email'];
	}

	return (bool) wp_mail( $to, $subject, $body, $headers );
}

/**
 * The appointment form in a dialog, for the header's button.
 *
 * Printed once in the footer of every page except the one that already shows
 * the form. assets/js/interactions.js opens it from any `.docmed-open-appointment`
 * button; without JavaScript that button is a link to the Appointment page,
 * and this stays closed and inert. A site that wants the button to go to the
 * page every time can turn the dialog off:
 *
 *     add_filter( 'docmed_appointment_dialog', '__return_false' );
 */
function docmed_appointment_dialog() {
	if ( is_admin() || ! apply_filters( 'docmed_appointment_dialog', true ) ) {
		return;
	}
	// The Appointment page already shows the form; a second copy in a dialog
	// would only duplicate it.
	if ( is_singular() && false !== strpos( (string) get_post_field( 'post_content', get_queried_object_id() ), 'type="appointment"' ) ) {
		return;
	}
	?>
<dialog class="docmed-dialog" id="docmed-appointment-dialog" aria-labelledby="docmed-appointment-dialog-title">
	<div class="docmed-dialog__box">
		<button type="button" class="docmed-dialog__close" data-docmed-close><span class="screen-reader-text"><?php esc_html_e( 'Close', 'docmed' ); ?></span></button>
		<h2 class="docmed-dialog__title" id="docmed-appointment-dialog-title"><?php esc_html_e( 'Make an Appointment', 'docmed' ); ?></h2>
		<?php echo docmed_render_form( 'appointment', 'grid', __( 'Confirm', 'docmed' ), '-dialog' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped as it is built. ?>
	</div>
</dialog>
	<?php
}
add_action( 'wp_footer', 'docmed_appointment_dialog' );
