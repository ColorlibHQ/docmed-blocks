<?php
/**
 * Title: Contact: map, form and details
 * Slug: docmed/contact
 * Categories: docmed-sections
 * Keywords: contact, form, map
 * Description: A map across the width, then the message form beside the address, phone and email.
 *
 * @package Docmed
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"docmed-contact","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"},"anchor":"contact"} -->
<div class="wp-block-group alignfull docmed-contact" id="contact" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:html -->
<iframe class="docmed-map" title="Map of the streets around the clinic" loading="lazy" src="https://www.openstreetmap.org/export/embed.html?bbox=-117.4100%2C33.9650%2C-117.3500%2C33.9950&amp;layer=mapnik" style="width:100%;height:480px;border:0"></iframe>
<!-- /wp:html -->

<!-- wp:spacer {"height":"var(\u002d\u002dwp\u002d\u002dpreset\u002d\u002dspacing\u002d\u002d70)"} -->
<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size">Get in Touch</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[docmed_form type="contact" layout="split" button="Send"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dmap-pin"} -->
<p class="docmed-info docmed-icon--map-pin"><strong>200 Green Lane, Suite 4</strong><br>Riverside, CA 92501</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dphone"} -->
<p class="docmed-info docmed-icon--phone"><strong><a href="tel:+15550104400">(555) 010-4400</a></strong><br>Monday to Friday 8am–7pm, Saturday 9am–2pm</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"docmed-info docmed-icon\u002d\u002dmail"} -->
<p class="docmed-info docmed-icon--mail"><strong><a href="mailto:hello@yourdomain.com">hello@yourdomain.com</a></strong><br>Send us your questions any time</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
