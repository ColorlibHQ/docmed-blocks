<?php
/**
 * Title: Sidebar
 * Slug: docmed/sidebar
 * Keywords: sidebar
 * Description: Search, categories, recent posts, tags and a newsletter sign-up, each in a pale box.
 * Inserter: no
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"className":"docmed-sidebar","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-sidebar"><!-- wp:group {"className":"is-style-docmed-panel","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-panel"><!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search keyword","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-panel","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-panel"><!-- wp:heading {"className":"docmed-widget__title","fontSize":"large"} -->
<h2 class="wp-block-heading docmed-widget__title has-large-font-size">Category</h2>
<!-- /wp:heading -->

<!-- wp:categories {"showPostCounts":true,"className":"docmed-counts"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-panel","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-panel"><!-- wp:heading {"className":"docmed-widget__title","fontSize":"large"} -->
<h2 class="wp-block-heading docmed-widget__title has-large-font-size">Recent posts</h2>
<!-- /wp:heading -->

<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeWidth":80,"featuredImageSizeHeight":80,"className":"docmed-recent"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-panel","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-panel"><!-- wp:heading {"className":"docmed-widget__title","fontSize":"large"} -->
<h2 class="wp-block-heading docmed-widget__title has-large-font-size">Tag clouds</h2>
<!-- /wp:heading -->

<!-- wp:tag-cloud {"smallestFontSize":"0.8125rem","largestFontSize":"0.8125rem","className":"docmed-tags"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-panel","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-docmed-panel"><!-- wp:heading {"className":"docmed-widget__title","fontSize":"large"} -->
<h2 class="wp-block-heading docmed-widget__title has-large-font-size">Newsletter</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A short health note from our doctors once a month. No advertising.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[docmed_form type="newsletter" layout="stacked" button="Subscribe"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
