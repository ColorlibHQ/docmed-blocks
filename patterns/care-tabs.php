<?php
/**
 * Title: Tabs: three ways we care
 * Slug: docmed/care-tabs
 * Categories: docmed-sections
 * Keywords: tabs, services, about
 * Description: Three tabs on a pale bar — family medicine, the team, same-day care — each opening an icon, a heading, a paragraph and a photograph.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-tabs","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-tabs"><!-- wp:group {"align":"full","className":"docmed-tabs__bar","backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull docmed-tabs__bar has-surface-background-color has-background"><!-- wp:group {"className":"docmed-tabs__list","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group docmed-tabs__list"><!-- wp:paragraph {"className":"docmed-tab"} -->
<p class="docmed-tab">Family Medicine</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-tab"} -->
<p class="docmed-tab">Qualified Doctors</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-tab"} -->
<p class="docmed-tab">Same-Day Care</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-tabs__panels","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-tabs__panels" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"className":"docmed-tabs__panel","layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-tabs__panel"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"placeholder":" ","className":"docmed-tabs__icon docmed-icon\u002d\u002dfirst-aid-kit"} -->
<p class="docmed-tabs__icon docmed-icon--first-aid-kit"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Care for every age, from one practice</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Your family doctor is the person who knows the whole picture: check-ups, long-term conditions, vaccinations, travel advice and the conversations that do not fit anywhere else. We keep lists small enough that you can usually see the same doctor.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"aspectRatio":"636/440","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tab-family.webp' ) ); ?>" alt="A mother and her young son in a consultation with an older doctor, who is writing notes at his desk" style="aspect-ratio:636/440;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-tabs__panel","layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-tabs__panel"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"placeholder":" ","className":"docmed-tabs__icon docmed-icon\u002d\u002dstethoscope"} -->
<p class="docmed-tabs__icon docmed-icon--stethoscope"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">A team that talks to each other</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every doctor, dentist and therapist at Docmed is registered with their professional body and works from the same building. When a case needs two opinions, the two people meet in the corridor, not by letter three weeks later.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"aspectRatio":"636/440","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tab-team.webp' ) ); ?>" alt="Two doctors in white coats looking at a scan together on a tablet" style="aspect-ratio:636/440;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-tabs__panel","layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-tabs__panel"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"placeholder":" ","className":"docmed-tabs__icon docmed-icon\u002d\u002dphone-call"} -->
<p class="docmed-tabs__icon docmed-icon--phone-call"></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Seen today when it cannot wait</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We keep appointments free every morning for patients who are unwell today. Call before 10am and a nurse will ring you back to find the right slot. For a medical emergency, always call your local emergency number.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"aspectRatio":"636/440","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tab-sameday.webp' ) ); ?>" alt="A doctor in a white coat on the phone at her desk, typing on a laptop" style="aspect-ratio:636/440;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
