<?php
/**
 * Title: Appointment band: call or book
 * Slug: docmed/appointment-band
 * Categories: docmed-sections
 * Keywords: appointment, call to action, contact
 * Description: Two halves across the page on blue-washed photographs: a same-day phone line, and the online appointment form.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-split__wrap","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull docmed-split__wrap"><!-- wp:columns {"className":"docmed-split","style":{"spacing":{"blockGap":{"top":"0","left":"0"}}}} -->
<div class="wp-block-columns docmed-split"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/band-call.webp' ) ); ?>","dimRatio":85,"overlayColor":"wash","isUserOverlayColor":true,"minHeight":242,"className":"docmed-split__half","layout":{"type":"constrained"}} -->
<div class="wp-block-cover docmed-split__half" style="min-height:242px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/band-call.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-wash-background-color has-background-dim-90 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"docmed-split__row","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-split__row"><!-- wp:group {"className":"docmed-split__words","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-split__words"><!-- wp:heading {"level":3,"textColor":"overlay","fontSize":"large"} -->
<h3 class="wp-block-heading has-overlay-color has-text-color has-large-font-size">Need to be seen today?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size">Call before 10am for a same-day appointment.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-outline docmed-pill"} -->
<div class="wp-block-button is-style-docmed-outline docmed-pill"><a class="wp-block-button__link wp-element-button" href="tel:+15550104411">(555) 010-4411</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/band-book.webp' ) ); ?>","dimRatio":95,"overlayColor":"wash","isUserOverlayColor":true,"minHeight":242,"className":"docmed-split__half","layout":{"type":"constrained"}} -->
<div class="wp-block-cover docmed-split__half" style="min-height:242px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/band-book.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-wash-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"docmed-split__row","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-split__row"><!-- wp:group {"className":"docmed-split__words","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-split__words"><!-- wp:heading {"level":3,"textColor":"overlay","fontSize":"large"} -->
<h3 class="wp-block-heading has-overlay-color has-text-color has-large-font-size">Make an Online Appointment</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"overlay","fontSize":"small"} -->
<p class="has-overlay-color has-text-color has-small-font-size">Pick a department, a doctor and a day.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-outline docmed-open-appointment docmed-pill"} -->
<div class="wp-block-button is-style-docmed-outline docmed-open-appointment docmed-pill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/appointment/' ) ); ?>">Make an Appointment</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
