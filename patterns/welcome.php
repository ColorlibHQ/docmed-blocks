<?php
/**
 * Title: Welcome: two photographs and the clinic's story
 * Slug: docmed/welcome
 * Categories: docmed-sections
 * Keywords: about, welcome, story
 * Description: Two overlapping photographs beside a small underlined kicker, a heading, the clinic's story, three ticked points and a button.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-welcome","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-welcome" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:group {"className":"docmed-welcome__photos","layout":{"type":"default"}} -->
<div class="wp-block-group docmed-welcome__photos"><!-- wp:image {"aspectRatio":"382/464","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"docmed-welcome__one"} -->
<figure class="wp-block-image size-large docmed-welcome__one"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-1.webp' ) ); ?>" alt="An older doctor listening to a young boy's chest with a stethoscope while his mother looks on" style="aspect-ratio:382/464;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:image {"aspectRatio":"322/392","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"docmed-welcome__two"} -->
<figure class="wp-block-image size-large docmed-welcome__two"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/about-2.webp' ) ); ?>" alt="A doctor in a white coat taking a woman's blood pressure at his desk" style="aspect-ratio:322/392;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","className":"docmed-welcome__text"} -->
<div class="wp-block-column is-vertically-aligned-center docmed-welcome__text" style="flex-basis:50%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"className":"is-style-docmed-kicker"} -->
<h2 class="wp-block-heading is-style-docmed-kicker">Welcome to Docmed</h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"className":"docmed-welcome__title","fontSize":"heading"} -->
<h3 class="wp-block-heading docmed-welcome__title has-heading-font-size">Good care starts <br>with knowing you</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Docmed is an independent family clinic. Our doctors, dentists and therapists share one building and one record, so the person who sees you on Tuesday already knows what was said on Monday — and your children are seen by the same faces as they grow up.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-docmed-checks"} -->
<ul class="wp-block-list is-style-docmed-checks"><!-- wp:list-item -->
<li>Appointments that start on time, and time to ask questions.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Tests, scans and results handled under one roof.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Evening and Saturday clinics for work and school days.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-docmed-ghost"} -->
<div class="wp-block-button is-style-docmed-ghost"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About the clinic</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
