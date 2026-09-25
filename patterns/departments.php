<?php
/**
 * Title: Departments: six cards
 * Slug: docmed/departments
 * Categories: docmed-sections
 * Keywords: departments, services, cards
 * Description: Six departments on the pale blue ground, each a photograph over a white panel with a title, a line of copy and a booking link.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"surface","layout":{"type":"constrained"},"anchor":"departments"} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" id="departments" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"docmed-section-head","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"620px"}} -->
<div class="wp-block-group docmed-section-head"><!-- wp:heading {"className":"is-style-docmed-bar","style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center is-style-docmed-bar">Our Departments</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center">Six departments in one building, so a referral is usually a walk down the corridor.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-eye.webp' ) ); ?>" alt="An optometrist taking a young man's eye examination at a slit lamp in a bright consulting room" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Eye Care</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Sight tests, contact lens fittings and check-ups for dry eyes, glaucoma and diabetes.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=eye' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-physio.webp' ) ); ?>" alt="A physiotherapist in blue scrubs guiding a patient through a hamstring stretch on a treatment table" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Physiotherapy</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>One-to-one sessions for back pain, sports injuries and getting moving after an operation.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=physio' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-dental.webp' ) ); ?>" alt="A dentist in green scrubs and a mask examining a young man's teeth in the dental chair" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Dental Care</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Check-ups, hygienist visits, fillings and gentle care for anyone nervous of the dentist.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=dental' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-lab.webp' ) ); ?>" alt="A gloved hand placing a blood sample tube into a laboratory centrifuge" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Diagnostics &amp; Lab</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Blood tests, ECGs and ultrasound on site, with results sent to your doctor.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=lab' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-skin.webp' ) ); ?>" alt="A dermatologist checking a mole on a patient's back with a tablet and a dermatoscope" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Dermatology</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Mole checks, eczema, acne and psoriasis clinics, with photos kept on your record.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=skin' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-docmed-card","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-docmed-card"><!-- wp:image {"aspectRatio":"3/2","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/dept-children.webp' ) ); ?>" alt="A young boy in a white coat listening to a teddy bear's heart with a stethoscope" style="aspect-ratio:3/2;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"docmed-card__body","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group docmed-card__body"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( home_url( '/departments/' ) ); ?>">Children's Health</a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Baby checks, vaccinations and a paediatric clinic every weekday afternoon.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-more"} -->
<p class="docmed-more"><a href="<?php echo esc_url( home_url( '/appointment/?department=children' ) ); ?>">Book a visit</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
