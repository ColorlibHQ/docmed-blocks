<?php
/**
 * Title: Archive banner
 * Slug: docmed/hidden-archive-banner
 * Description: The banner an archive title sits on.
 * Inserter: no
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/banner.webp' ) ); ?>","focalPoint":{"x":0.78,"y":0.35},"minHeight":400,"gradient":"banner","contentPosition":"center left","align":"full","className":"docmed-banner","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull has-custom-content-position is-position-center-left docmed-banner" style="min-height:400px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/banner.webp' ) ); ?>" style="object-position:78% 35%" data-object-fit="cover" data-object-position="78% 35%"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-banner-gradient-background"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:query-title {"type":"archive","textColor":"overlay"} /-->

<!-- wp:group {"className":"docmed-breadcrumb","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-breadcrumb"><!-- wp:paragraph {"className":"docmed-breadcrumb__home","textColor":"overlay"} -->
<p class="docmed-breadcrumb__home has-overlay-color has-text-color"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"overlay"} -->
<p class="has-overlay-color has-text-color">Archive</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
