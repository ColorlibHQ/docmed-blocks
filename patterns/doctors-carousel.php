<?php
/**
 * Title: Doctors: a sliding row
 * Slug: docmed/doctors-carousel
 * Categories: docmed-sections
 * Keywords: doctors, team, staff, carousel
 * Description: Eight doctors in a row that slides with arrows, four at a time on a wide screen: a portrait over a pale panel with the name and specialty.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"},"anchor":"doctors"} -->
<div class="wp-block-group alignfull" id="doctors" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"docmed-section-head docmed-section-head\u002d\u002dleft","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-section-head docmed-section-head--left"><!-- wp:heading {"className":"is-style-docmed-bar","style":{"typography":{"textAlign":"left"}}} -->
<h2 class="wp-block-heading has-text-align-left is-style-docmed-bar">Expert Doctors</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"docmed-carousel","layout":{"type":"default"}} -->
<div class="wp-block-group docmed-carousel"><!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-8.webp' ) ); ?>" alt="An older doctor with white hair and glasses, in a white coat and tie, smiling in his consulting room" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Robert Hale</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Family Medicine · Medical Director</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-1.webp' ) ); ?>" alt="A smiling young doctor in a white coat over maroon scrubs, a stethoscope round his neck" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Daniel Mensah</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Family Medicine</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-5.webp' ) ); ?>" alt="A smiling doctor in a patterned headscarf and dark green scrubs, a stethoscope round her neck" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Amira Saleh</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Paediatrics</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-2.webp' ) ); ?>" alt="A doctor with long dark hair in a white coat over light blue scrubs, a stethoscope round her neck" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Lucia Paredes</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Optometry</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-6.webp' ) ); ?>" alt="A doctor with long dark hair in navy scrubs, looking straight at the camera" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Sofia Ramos</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Dentistry</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-4.webp' ) ); ?>" alt="A doctor with a dark fringe in black scrubs, a stethoscope round her neck" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Elena Novak</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Dermatology</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-3.webp' ) ); ?>" alt="A bearded young man in royal blue scrubs with a stethoscope, arms folded" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Karim Haddad</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Physiotherapy</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-docmed-doctor","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-doctor"><!-- wp:image {"aspectRatio":"302/286","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/doctor-7.webp' ) ); ?>" alt="A young doctor in a white coat holding up a chest X-ray to the light" style="aspect-ratio:302/286;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-doctor__name","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-doctor__name"><!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">Dr. Mateo Quispe</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"docmed-doctor__role","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="has-text-align-center docmed-doctor__role has-x-small-font-size">Diagnostics &amp; Imaging</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
