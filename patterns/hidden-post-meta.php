<?php
/**
 * Title: Post meta
 * Slug: docmed/hidden-post-meta
 * Description: Categories, date and author for a single post.
 * Inserter: no
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"className":"docmed-post__meta","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-post__meta"><!-- wp:post-terms {"term":"category","className":"docmed-post-cats","fontSize":"small"} /-->

<!-- wp:post-date {"metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}},"fontSize":"small"} /-->

<!-- wp:post-author-name {"className":"docmed-author","fontSize":"small"} /--></div>
<!-- /wp:group -->
