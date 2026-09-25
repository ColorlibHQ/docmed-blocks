=== Docmed ===

Contributors: colorlib
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, full-site-editing, block-patterns, block-styles, template-editing, wide-blocks, accessibility-ready, translation-ready, custom-colors, custom-menu, custom-logo, featured-images, threaded-comments, one-column, two-columns, right-sidebar, rtl-language-support, sticky-post, theme-options

A block theme for family clinics, medical centres and doctors' practices.

== Description ==

Docmed is a full site editing theme for a clinic or a doctors' practice:
departments, a doctors carousel and a team page, patient reviews, three tabs
about how the practice works, and an appointment request form — department,
doctor, preferred date and time, name, phone or email and a note — that opens
from the header's "Make an Appointment" button. The appointment, contact and
newsletter forms need no plugin.

It is built from the Docmed HTML template: the pale contact strip above the
header, the doctor on the right of the hero, the three-cell service band, the
two overlapping photographs, the department cards, the review band, the tabs,
the doctors row with its arrows and the two-half appointment band are all
there, as blocks you can edit.

Activate it on a new site and it builds the pages for you — Home, Departments,
Doctors, About, Blog, Contact and Appointment — with a menu to match. On a site
that already has pages it leaves them alone.

Eight colour palettes and five type pairings, each checked for contrast before
release rather than by eye. Visitor-facing dark mode that follows the reader's
system setting until they choose for themselves. WooCommerce is styled if you
install it and loads nothing if you do not.

== Installation ==

1. In WordPress, go to Appearance → Themes → Add New Theme → Upload Theme.
2. Choose docmed.zip and click Install Now, then Activate.
3. Appearance → Editor is where the header, footer, colours and templates live.

== Frequently Asked Questions ==

= Do I need a plugin for the appointment form? =

No. The appointment, contact and newsletter forms are part of the theme
([docmed_form type="appointment"], type="contact", type="newsletter") and send
with WordPress's own wp_mail() to the site's admin address. If your host cannot
send mail, install any SMTP plugin — whatever fixes a lost password-reset email
fixes the forms too. To send submissions somewhere else (a practice-management
system, a mailing list), hook the `docmed_form_handlers` filter and return true.

The form only requests an appointment: a person at the practice confirms it.
It stores nothing in the database, so no health information is kept on the
site; it is emailed, or handed to whatever you hook in.

= How do I change the departments and doctors in the form? =

With two filters, `docmed_appointment_departments` and
`docmed_appointment_doctors`, each an array of value => label. The department
cards link to the form with ?department=<value>, which preselects the choice.

= Can the header button go to the Appointment page instead of opening a dialog? =

Yes: add_filter( 'docmed_appointment_dialog', '__return_false' ); The button is
already a link to /appointment/, so without the dialog (or without JavaScript)
it simply goes there.

= How do I change the colours? =

Appearance → Editor → Styles → Browse styles. Eight palettes are included —
Sky (the template's own blues), Teal, Navy, Sage, Plum, Coral, and the dark
Midnight and Graphite — and each restyles every section.

= Why are the blues deeper than the template's? =

The template's blue, #009dff, is 2.9:1 against white and its light blue,
#5db2ff, 2.3:1; both fail WCAG AA for text and for a white button label. The
light blue ships as the decorative accent (the bars under titles, the ticks,
the tab icons), and #0a6fd6 and deeper shades carry links, buttons, the blue
bands and anything else you have to read.

= How do I change the map on the contact page? =

The map is a Custom HTML block holding an OpenStreetMap embed. Open
openstreetmap.org, find your practice, choose Share → HTML, and paste the new
address into the block's src.

= Can I turn dark mode off? =

Yes: add add_filter( 'docmed_enable_dark_mode', '__return_false' ); to a
child theme or a small plugin. The switch in the header disappears with it.

= Can I turn the scroll animations off? =

Yes: add add_filter( 'docmed_enable_scroll_animations', '__return_false' );
to a child theme or a small plugin. Visitors who have asked their system for
reduced motion never see them either way; the reviews slider, the doctors
carousel, the tabs and the dialog keep working.

= What does the update check send? =

Docmed is distributed from colorlib.com, not the WordPress.org directory, so
it asks updates.colorlib.com for new versions, twice a day at most. It sends
the theme's name and version, the WordPress and PHP versions, the locale,
whether the site is a multisite, and a one-way hash of the site address — no
site name, no address, no email address, nothing personal. add_filter(
'docmed_check_for_updates', '__return_false' ); stops it entirely.

== Theme Check ==

Theme Check reports two REQUIRED findings and no warnings. Both are
deliberate, and each is the price of something the theme does on purpose.

1. **add_shortcode() in inc/appointment.php.** The forms have to keep working
   after a pattern is expanded into a page's content, where PHP never runs. A
   shortcode is the only mechanism WordPress offers for that. Moving it to a
   plugin would mean the appointment form stops working the moment the plugin
   is disabled, on a page the theme built.
2. **Update URI in style.css.** This theme is distributed outside the
   WordPress.org directory and checks colorlib.com for its own updates. A theme
   inside the directory must not carry this header.

The photographs are all from Pexels. The Pexels License is not GPL-compatible
either; replace them with your own photographs for a site of your own.

== Copyright ==

Docmed WordPress Theme, (C) 2026 Colorlib.
Docmed is distributed under the terms of the GNU GPL v2 or later.

Poppins and Lora
License: SIL Open Font License 1.1
Source: https://fontsource.org/

Tabler Icons
License: MIT, https://github.com/tabler/tabler-icons/blob/main/LICENSE
Source: https://tabler.io/icons

Photographs
From Pexels (Pexels License, https://www.pexels.com/license/). The hero, the
page banner and the two appointment-band backgrounds are studio portraits
widened by continuing their plain backdrop; the rest are crops.

* hero.webp, doctor-1.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/confident-doctor-with-stethoscope-portrait-32254662/
* banner.webp, doctor-3.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/confident-young-healthcare-professional-portrait-32115962/
* doctor-2.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/confident-female-doctor-in-white-coat-with-stethoscope-32254667/
* doctor-4.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/portrait-of-a-young-medical-professional-with-stethoscope-32115911/
* doctor-5.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/female-doctor-holding-medical-book-in-studio-32254657/
* doctor-6.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/professional-female-nurse-with-stethoscope-32115898/
* doctor-7.webp, band-call.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/doctor-analyzing-x-ray-image-in-clinic-32115951/
* band-book.webp — Daniil Kondrashin,
  https://www.pexels.com/photo/young-female-doctor-reading-a-medical-book-32254654/
* doctor-8.webp — Vitaly Gariev,
  https://www.pexels.com/photo/senior-doctor-in-office-with-stethoscope-39192331/
* about-1.webp — Vitaly Gariev,
  https://www.pexels.com/photo/doctor-examining-child-with-stethoscope-39192341/
* about-2.webp — Vitaly Gariev,
  https://www.pexels.com/photo/doctor-measuring-patient-s-blood-pressure-in-office-39192345/
* tab-family.webp — Vitaly Gariev,
  https://www.pexels.com/photo/doctor-consulting-mother-and-child-in-clinic-39192346/
* tab-team.webp — Vitaly Gariev,
  https://www.pexels.com/photo/healthcare-professionals-analyzing-x-ray-on-tablet-39192393/
* tab-sameday.webp — Vitaly Gariev,
  https://www.pexels.com/photo/female-doctor-using-laptop-and-phone-in-office-39192373/
* reviews.webp — Vitaly Gariev,
  https://www.pexels.com/photo/doctor-and-patient-consultation-in-modern-office-39192354/
* dept-children.webp — Vitaly Gariev,
  https://www.pexels.com/photo/child-pretends-doctor-with-teddy-bear-and-stethoscope-39192352/
* dept-eye.webp — Antoni Shkraba,
  https://www.pexels.com/photo/a-man-having-an-eye-examination-6749697/
* dept-physio.webp — Funkcinės Terapijos Centras,
  https://www.pexels.com/photo/physiotherapist-instructing-patient-20860594/
* dept-dental.webp — Karolina Grabowska (kaboompics.com),
  https://www.pexels.com/photo/a-man-at-the-dentist-6627419/
* dept-lab.webp — Karolina Grabowska (kaboompics.com),
  https://www.pexels.com/photo/laboratory-worker-using-modern-hospital-equipment-6627687/
* dept-skin.webp — Gustavo Fring,
  https://www.pexels.com/photo/doctor-examining-patient-s-mole-7446661/

== Changelog ==

= 1.0.1 =
* The sample email address in the header, footer and contact patterns is now hello@yourdomain.com. The 1.0.0 address used a domain that belongs to someone else.

= 1.0.0 =
* Initial release.
