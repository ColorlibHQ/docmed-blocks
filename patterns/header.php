<?php
/**
 * Title: Header
 * Slug: docmed/header
 * Keywords: header, navigation
 * Block Types: core/template-part/header
 * Description: The template's two-row header: a pale strip with social icons, email and phone, then the logo, the menu and the appointment button.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-header","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull docmed-header"><!-- wp:group {"align":"full","className":"docmed-topbar","backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-topbar has-surface-background-color has-background"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-docmed-plain","layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links has-small-icon-size is-style-docmed-plain"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:group {"className":"docmed-topbar__contact","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"right","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-topbar__contact"><!-- wp:paragraph {"className":"docmed-topbar__item docmed-icon\u002d\u002dmail","fontSize":"x-small"} -->
<p class="docmed-topbar__item docmed-icon--mail has-x-small-font-size"><a href="mailto:hello@yourdomain.com">hello@yourdomain.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-topbar__item docmed-icon\u002d\u002dphone","fontSize":"x-small"} -->
<p class="docmed-topbar__item docmed-icon--phone has-x-small-font-size"><a href="tel:+15550104400">(555) 010-4400</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"docmed-header__main","backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-header__main has-base-background-color has-background"><!-- wp:group {"className":"docmed-header__row","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-header__row"><!-- wp:group {"className":"docmed-brand","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-brand"><!-- wp:site-logo {"width":163} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"className":"docmed-nav","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->

<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"docmed-scheme-toggle"} -->
<div class="wp-block-button docmed-scheme-toggle"><a class="wp-block-button__link wp-element-button" href="#"><span class="screen-reader-text">Switch between light and dark mode</span></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"docmed-open-appointment docmed-header__cta"} -->
<div class="wp-block-button docmed-open-appointment docmed-header__cta"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/appointment/' ) ); ?>">Make an Appointment</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
