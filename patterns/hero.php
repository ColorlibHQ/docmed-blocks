<?php
/**
 * Title: Hero
 * Slug: docmed/hero
 * Categories: docmed-sections
 * Keywords: hero, banner
 * Description: A doctor on the right of a pale studio photograph, the headline, a line of copy and a button on the left.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>","dimRatio":0,"overlayColor":"base","isUserOverlayColor":true,"focalPoint":{"x":0.72,"y":0.3},"minHeight":700,"contentPosition":"center left","align":"full","className":"docmed-hero","layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-center-left docmed-hero" style="min-height:700px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>" style="object-position:72% 30%" data-object-fit="cover" data-object-position="72% 30%"/><span aria-hidden="true" class="wp-block-cover__background has-base-background-color has-background-dim-0 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"docmed-hero__words","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"620px"}} -->
<div class="wp-block-group docmed-hero__words"><!-- wp:heading {"level":1,"className":"docmed-hero__title","textColor":"ink","fontSize":"colossal"} -->
<h1 class="wp-block-heading docmed-hero__title has-ink-color has-text-color has-colossal-font-size"><strong>Health Care</strong> <br>For the Whole Family</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-hero__text","textColor":"ink"} -->
<p class="docmed-hero__text has-ink-color has-text-color">Family doctors, dentists, eye care and physiotherapy under one roof on Green Lane, with same-day appointments every weekday.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Our Departments</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
