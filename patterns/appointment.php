<?php
/**
 * Title: Appointment request form
 * Slug: docmed/appointment
 * Categories: docmed-sections
 * Keywords: appointment, booking, form
 * Description: The clinic's hours and phone line beside the appointment request form: department, doctor, date, time, name, phone, email and a note.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"surface","layout":{"type":"constrained"},"anchor":"appointment"} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" id="appointment" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"className":"is-style-docmed-bar"} -->
<h2 class="wp-block-heading is-style-docmed-bar">Request an appointment</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Tell us who you would like to see and when suits you. A receptionist will confirm the time by phone or email, usually within one working day.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dclock"} -->
<p class="docmed-info docmed-icon--clock"><strong>Opening hours</strong><br>Monday to Friday 8am–7pm, Saturday 9am–2pm</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dphone-call"} -->
<p class="docmed-info docmed-icon--phone-call"><strong>Same-day line</strong><br><a href="tel:+15550104411">(555) 010-4411</a>, before 10am</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dmap-pin"} -->
<p class="docmed-info docmed-icon--map-pin"><strong>200 Green Lane, Suite 4</strong><br>Riverside, CA 92501</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"docmed-note","fontSize":"small"} -->
<p class="docmed-note has-small-font-size">This form is not for emergencies. If you need urgent help, call your local emergency number.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%"} -->
<div class="wp-block-column" style="flex-basis:60%"><!-- wp:group {"className":"is-style-docmed-form-box","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-form-box"><!-- wp:shortcode -->
[docmed_form type="appointment" layout="grid" button="Confirm appointment request"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
