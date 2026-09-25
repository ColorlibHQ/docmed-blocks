<?php
/**
 * Title: Service band: three cells
 * Slug: docmed/services-band
 * Categories: docmed-sections
 * Keywords: services, band, features
 * Description: Three services side by side on the brand blue, the middle one a shade deeper, each with an icon, a line of copy and an outlined button.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-band","backgroundColor":"primary","textColor":"on-primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-band has-on-primary-color has-primary-background-color has-text-color has-background"><!-- wp:columns {"className":"docmed-band__row","style":{"spacing":{"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns docmed-band__row"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"docmed-band__cell","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-band__cell"><!-- wp:paragraph {"placeholder":" ","className":"docmed-band__icon docmed-icon\u002d\u002dstethoscope"} -->
<p class="docmed-band__icon docmed-icon--stethoscope"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"docmed-band__title","textColor":"on-primary"} -->
<h3 class="wp-block-heading docmed-band__title has-on-primary-color has-text-color">Family Doctor</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-primary"} -->
<p class="has-on-primary-color has-text-color">Register once and see the same doctor, with your whole family's record in one place.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-outline"} -->
<div class="wp-block-button is-style-docmed-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Register with us</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"backgroundColor":"primary-deep"} -->
<div class="wp-block-column has-primary-deep-background-color has-background"><!-- wp:group {"className":"docmed-band__cell","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-band__cell"><!-- wp:paragraph {"placeholder":" ","className":"docmed-band__icon docmed-icon\u002d\u002dphone-call"} -->
<p class="docmed-band__icon docmed-icon--phone-call"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"docmed-band__title","textColor":"on-primary"} -->
<h3 class="wp-block-heading docmed-band__title has-on-primary-color has-text-color">Same-Day Care</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-primary"} -->
<p class="has-on-primary-color has-text-color">Unwell today? Call before 10am and we will fit you in before the end of the day.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-outline"} -->
<div class="wp-block-button is-style-docmed-outline"><a class="wp-block-button__link wp-element-button" href="tel:+15550104411">(555) 010-4411</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"docmed-band__cell","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-band__cell"><!-- wp:paragraph {"placeholder":" ","className":"docmed-band__icon docmed-icon\u002d\u002dcalendar-event"} -->
<p class="docmed-band__icon docmed-icon--calendar-event"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"docmed-band__title","textColor":"on-primary"} -->
<h3 class="wp-block-heading docmed-band__title has-on-primary-color has-text-color">Book a Visit</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-primary"} -->
<p class="has-on-primary-color has-text-color">Choose a department, a doctor and a day, and we will confirm the time by phone or email.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-outline docmed-open-appointment"} -->
<div class="wp-block-button is-style-docmed-outline docmed-open-appointment"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/appointment/' ) ); ?>">Make an Appointment</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
