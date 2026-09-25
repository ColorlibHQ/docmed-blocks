<?php
/**
 * Title: Patient reviews over a photograph
 * Slug: docmed/reviews
 * Categories: docmed-sections
 * Keywords: testimonials, reviews, quotes
 * Description: Three patients' words in a slider, centred over a darkened photograph of a consultation.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/reviews.webp' ) ); ?>","dimRatio":60,"overlayColor":"dark","isUserOverlayColor":true,"focalPoint":{"x":0.5,"y":0.2},"minHeight":620,"align":"full","className":"docmed-reviews","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull docmed-reviews" style="min-height:620px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/reviews.webp' ) ); ?>" style="object-position:50% 20%" data-object-fit="cover" data-object-position="50% 20%"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-60 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"840px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"docmed-review__quote docmed-icon\u002d\u002dquote","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__quote docmed-icon--quote has-overlay-color has-text-color"><span class="screen-reader-text">What our patients say</span></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"docmed-slider","layout":{"type":"default"}} -->
<div class="wp-block-group docmed-slider"><!-- wp:group {"className":"docmed-slide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-slide"><!-- wp:paragraph {"className":"docmed-review__text","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__text has-overlay-color has-text-color">Dr. Hale has looked after three generations of our family. He still remembers my mother's birthday and my son's broken wrist, and he never makes us feel rushed.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-review__name","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__name has-overlay-color has-text-color">Maria Delgado, patient since 2011</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-slide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-slide"><!-- wp:paragraph {"className":"docmed-review__text","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__text has-overlay-color has-text-color">I rang at eight with a feverish toddler and we were seen by half past eleven. The nurse even called the next morning to ask how she was.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-review__name","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__name has-overlay-color has-text-color">James Whitfield, parent</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-slide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-slide"><!-- wp:paragraph {"className":"docmed-review__text","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__text has-overlay-color has-text-color">After my knee operation Karim got me back on my bike in a way the leaflets never could. Clear exercises, honest answers and a lot of patience.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-review__name","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center docmed-review__name has-overlay-color has-text-color">Anita Rao, physiotherapy patient</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
