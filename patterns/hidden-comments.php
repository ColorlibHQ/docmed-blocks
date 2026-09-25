<?php
/**
 * Title: Comments
 * Slug: docmed/hidden-comments
 * Description: The comments and the reply form for a single post.
 * Inserter: no
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:comments {"className":"docmed-comments"} -->
<div class="wp-block-comments docmed-comments"><!-- wp:comments-title {"fontSize":"large"} /-->

<!-- wp:comment-template -->
<!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns is-not-stacked-on-mobile"><!-- wp:column {"width":"70px"} -->
<div class="wp-block-column" style="flex-basis:70px"><!-- wp:avatar {"size":70,"style":{"border":{"radius":"50%"}}} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:comment-content /-->

<!-- wp:comment-author-name {"fontSize":"medium"} /-->

<!-- wp:comment-date {"fontSize":"small"} /-->

<!-- wp:comment-reply-link {"className":"docmed-reply","fontSize":"x-small"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"left"}} -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form /--></div>
<!-- /wp:comments -->
