<?php
/**
 * Title: Posts list
 * Slug: docmed/hidden-posts-list
 * Description: The post list used by the blog and every archive: a photograph with its date badge, the title, an excerpt, categories and comments.
 * Inserter: no
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:query {"queryId":0,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":true},"className":"docmed-posts","layout":{"type":"default"}} -->
<div class="wp-block-query docmed-posts"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}}} -->
<!-- wp:group {"className":"docmed-post","layout":{"type":"default"}} -->
<div class="wp-block-group docmed-post"><!-- wp:group {"className":"docmed-post__media","layout":{"type":"default"}} -->
<div class="wp-block-group docmed-post__media"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"750/375"} /-->

<!-- wp:post-date {"format":"d M","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"className":"docmed-date-badge"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-post__body","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-post__body"><!-- wp:post-title {"isLink":true,"fontSize":"x-large"} /-->

<!-- wp:post-excerpt {"excerptLength":36} /-->

<!-- wp:group {"className":"docmed-post__meta","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-post__meta"><!-- wp:post-terms {"term":"category","className":"docmed-post-cats","fontSize":"small"} /-->

<!-- wp:post-comments-count {"className":"docmed-comments-count","fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>Nothing here yet. Try a search, or start again from the home page.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results -->

<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query -->
