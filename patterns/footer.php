<?php
/**
 * Title: Footer
 * Slug: docmed/footer
 * Keywords: footer, address, links
 * Block Types: core/template-part/footer
 * Description: The template's dark footer: the logo, a line about the clinic and social squares, departments, useful links and the address, with the copyright line beneath.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-footer","backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-footer has-on-dark-color has-dark-background-color has-text-color has-background"><!-- wp:group {"align":"full","className":"docmed-footer__top","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-footer__top" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:site-title {"level":0,"className":"docmed-footer__brand"} /-->

<!-- wp:paragraph {"textColor":"on-dark"} -->
<p class="has-on-dark-color has-text-color">A family clinic on Green Lane since 2009: doctors, dentists and therapists under one roof, and one record that follows you between them.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-docmed-squares","layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links has-small-icon-size is-style-docmed-squares"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"className":"docmed-footer__title","textColor":"overlay","fontSize":"x-large"} -->
<h2 class="wp-block-heading docmed-footer__title has-overlay-color has-text-color has-x-large-font-size">Departments</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"docmed-footer__links"} -->
<ul class="wp-block-list docmed-footer__links"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Eye Care</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Physiotherapy</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Dental Care</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Diagnostics &amp; Lab</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Dermatology</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"className":"docmed-footer__title","textColor":"overlay","fontSize":"x-large"} -->
<h2 class="wp-block-heading docmed-footer__title has-overlay-color has-text-color has-x-large-font-size">Useful links</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"docmed-footer__links"} -->
<ul class="wp-block-list docmed-footer__links"><!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About us</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/doctors/' ) ); ?>">Our doctors</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Health news</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><a href="<?php echo esc_url( home_url( '/appointment/' ) ); ?>">Appointments</a></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"20%"} -->
<div class="wp-block-column" style="flex-basis:20%"><!-- wp:heading {"className":"docmed-footer__title","textColor":"overlay","fontSize":"x-large"} -->
<h2 class="wp-block-heading docmed-footer__title has-overlay-color has-text-color has-x-large-font-size">Address</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-footer__address","textColor":"on-dark"} -->
<p class="docmed-footer__address has-on-dark-color has-text-color">200 Green Lane, Suite 4<br>Riverside, CA 92501<br><a href="tel:+15550104400">(555) 010-4400</a><br><a href="mailto:hello@docmed.clinic">hello@docmed.clinic</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"on-dark","fontSize":"small"} -->
<p class="has-on-dark-color has-text-color has-small-font-size">Monday to Friday 8am–7pm, Saturday 9am–2pm</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"docmed-footer__bottom","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-footer__bottom"><!-- wp:paragraph {"className":"docmed-footer__legal","style":{"typography":{"textAlign":"center"}},"textColor":"on-dark","fontSize":"small"} -->
<p class="has-text-align-center docmed-footer__legal has-on-dark-color has-text-color has-small-font-size">© Docmed Family Clinic. All rights reserved. Theme by <a href="https://colorlib.com/" rel="nofollow">Colorlib</a>.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
