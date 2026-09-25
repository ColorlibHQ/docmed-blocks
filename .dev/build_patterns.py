#!/usr/bin/env python3
"""Generate Docmed's patterns.

Run from the theme root:

    python3 .dev/build_patterns.py
    node .dev/normalize-blocks.mjs      # then let the editor re-serialise them
    node .dev/validate-blocks.mjs       # and refuse anything it calls invalid

Every pattern file is committed as generated. Edit this file, never
patterns/*.php.

The sections follow the Docmed HTML template section by section: the two-row
header (a pale contact strip over the logo, menu and appointment button), the
hero with the doctor on the right, the three-cell service band, the welcome
block with two overlapping photographs, the department cards, the review band
over a photograph, the three tabs, the doctors carousel, the two-half
appointment band and the dark four-column footer. The copy is one family
clinic's, start to finish. It makes no claims about outcomes: the facts it
invents are a practice's ordinary ones — departments, names, hours.
"""

import json
import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from patternlib import (  # noqa: E402
    button, buttons, column, columns, cover, group, heading, image,
    paragraph, shortcode, sp, spacer,
)

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
PATTERNS = os.path.join(ROOT, "patterns")
WRITTEN = []

SECTIONS = ["docmed-sections"]
PAGES = ["docmed-pages"]

# Numbers in the 555-01xx range are reserved for fiction: nobody's phone rings.
PHONE = "(555) 010-4400"
PHONE_HREF = "tel:+15550104400"
SAME_DAY = "(555) 010-4411"
SAME_DAY_HREF = "tel:+15550104411"
EMAIL = "hello@yourdomain.com"
ADDRESS = "200 Green Lane, Suite 4"
TOWN = "Riverside, CA 92501"
HOURS = "Monday to Friday 8am&ndash;7pm, Saturday 9am&ndash;2pm"


def write(slug, title, content, categories=None, keywords=None,
          description=None, inserter=True, block_types=None):
    header = ["Title: " + title, "Slug: docmed/" + slug]
    if categories:
        header.append("Categories: " + ", ".join(categories))
    if keywords:
        header.append("Keywords: " + ", ".join(keywords))
    if block_types:
        header.append("Block Types: " + ", ".join(block_types))
    if description:
        header.append("Description: " + description)
    if not inserter:
        header.append("Inserter: no")

    body = (
        "<?php\n/**\n * " + "\n * ".join(header) + "\n *\n * @package Docmed\n */\n\n"
        "defined( 'ABSPATH' ) || exit;\n?>\n" + content.strip() + "\n"
    )
    with open(os.path.join(PATTERNS, slug + ".php"), "w") as fh:
        fh.write(body)
    WRITTEN.append(slug)


def home(path="/"):
    """A link to one of the starter pages, resolved when the pattern loads.

    A literal `/contact/` breaks on a site installed in a subdirectory; `#`
    goes nowhere. The pattern is PHP, so it can ask WordPress, and the link is
    correct in the page activation builds from it.
    """
    return "<?php echo esc_url( home_url( '%s' ) ); ?>" % path


def icon(name):
    """The class that draws a Tabler icon on the block that carries it.

    style.css draws the icon from the class with a mask filled in the text
    colour, so it follows the palette and dark mode, shows in the editor (an
    empty inline element would not), and changing it is an edit to Advanced ->
    Additional CSS class(es). Every name needs a `.docmed-icon--<name>` rule;
    .dev/dead-selectors.py checks it."""
    return "docmed-icon--%s" % name


def flex_row(inner, justify=None, gap=None, wrap="wrap", vertical="center", extra_class=None):
    """A horizontal group, written directly; normalize-blocks.mjs canonicalises it."""
    layout = {"type": "flex", "flexWrap": wrap}
    if justify:
        layout["justifyContent"] = justify
    if vertical:
        layout["verticalAlignment"] = vertical
    data = {}
    if extra_class:
        data["className"] = extra_class
    if gap is not None:
        data["style"] = {"spacing": {"blockGap": sp(gap) if gap != "0" else "0"}}
    data["layout"] = layout
    cls = "wp-block-group" + (" " + extra_class if extra_class else "")
    return '<!-- wp:group %s -->\n<div class="%s">\n%s\n</div>\n<!-- /wp:group -->' % (
        json.dumps(data, separators=(",", ":")), cls, inner
    )


def section_title(title, blurb=None, align="center"):
    """The template's section title: 36px, a short light-blue bar beneath it,
    one or two lines of copy, and 55px to the content."""
    parts = [heading(title, level=2, align=align, style="docmed-bar")]
    if blurb:
        parts.append(paragraph(blurb, align=align))
    return group("\n".join(parts), layout="constrained", content_size="620px" if align == "center" else None,
                 gap="30", extra_class="docmed-section-head" + (" docmed-section-head--left" if align != "center" else ""))


def section(inner, background=None, padding="80", anchor=None, extra_class=None, text=None):
    return group(inner, align="full", background=background, padding_y=padding, text=text,
                 layout="constrained", anchor=anchor, extra_class=extra_class)


def plain_list(items, extra_class):
    return ('<!-- wp:list {"className":"%s"} -->\n<ul class="wp-block-list %s">%s</ul>\n<!-- /wp:list -->'
            % (extra_class, extra_class,
               "".join("<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->" % i for i in items)))


def checks(items):
    return ('<!-- wp:list {"className":"is-style-docmed-checks"} -->\n'
            '<ul class="wp-block-list is-style-docmed-checks">%s</ul>\n<!-- /wp:list -->'
            % "".join("<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->" % i for i in items))


def social_links(style="docmed-plain", justify="left", size="has-small-icon-size"):
    services = ["facebook", "x", "instagram", "linkedin"]
    data = {"size": size, "className": "is-style-" + style,
            "layout": {"type": "flex", "justifyContent": justify, "flexWrap": "wrap"}}
    return (
        '<!-- wp:social-links %s -->\n'
        '<ul class="wp-block-social-links %s is-style-%s">%s</ul>\n'
        '<!-- /wp:social-links -->' % (
            json.dumps(data, separators=(",", ":")), size, style,
            "".join('<!-- wp:social-link {"url":"#","service":"%s"} /-->' % s for s in services))
    )


def appointment_button(text="Make an Appointment", style=None, extra=""):
    """A button that opens the appointment form.

    It is a link to the Appointment page, so it works with JavaScript off and
    in a pattern pasted anywhere; assets/js/interactions.js opens the same
    form in a dialog instead when the page has it (inc/appointment.php prints
    it into the footer).
    """
    return button(text, home("/appointment/"), style=style,
                  extra_class=("docmed-open-appointment " + extra).strip())


# ---------------------------------------------------------------------------
# Parts
# ---------------------------------------------------------------------------
def build_header():
    contact = flex_row("\n".join([
        paragraph('<a href="mailto:%s">%s</a>' % (EMAIL, EMAIL), size="x-small",
                  extra_class="docmed-topbar__item " + icon("mail")),
        paragraph('<a href="%s">%s</a>' % (PHONE_HREF, PHONE), size="x-small",
                  extra_class="docmed-topbar__item " + icon("phone")),
    ]), justify="right", gap="50", wrap="wrap", extra_class="docmed-topbar__contact")
    top = group(flex_row(social_links("docmed-plain") + "\n" + contact, justify="space-between", gap="40",
                         wrap="nowrap"),
                align="full", background="surface", layout="constrained", extra_class="docmed-topbar")

    # The switch needs text inside it: an empty core/button renders nothing at
    # all. The label is for screen readers; inc/scheme.php adds the pressed state.
    toggle = button('<span class="screen-reader-text">Switch between light and dark mode</span>', "#",
                    extra_class="docmed-scheme-toggle")
    brand = flex_row('<!-- wp:site-logo {"width":163} /-->\n<!-- wp:site-title {"level":0} /-->',
                     gap="30", wrap="nowrap", extra_class="docmed-brand")
    nav = ('<!-- wp:navigation {"overlayMenu":"mobile","className":"docmed-nav",'
           '"layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} /-->')
    actions = buttons([toggle, appointment_button(extra="docmed-header__cta")], gap="30", nowrap=True)
    main = group(flex_row("\n".join([brand, nav, actions]), justify="space-between", gap="40", wrap="nowrap",
                          extra_class="docmed-header__row"),
                 align="full", background="base", layout="constrained", extra_class="docmed-header__main")

    write("header", "Header",
          group(top + "\n" + main, align="full", layout="default", extra_class="docmed-header"),
          keywords=["header", "navigation"],
          description="The template's two-row header: a pale strip with social icons, email and phone, then "
                      "the logo, the menu and the appointment button.",
          block_types=["core/template-part/header"])


DEPARTMENTS = [
    ("eye", "dept-eye", "Eye Care",
     "An optometrist taking a young man's eye examination at a slit lamp in a bright consulting room",
     "Sight tests, contact lens fittings and check-ups for dry eyes, glaucoma and diabetes."),
    ("physio", "dept-physio", "Physiotherapy",
     "A physiotherapist in blue scrubs guiding a patient through a hamstring stretch on a treatment table",
     "One-to-one sessions for back pain, sports injuries and getting moving after an operation."),
    ("dental", "dept-dental", "Dental Care",
     "A dentist in green scrubs and a mask examining a young man's teeth in the dental chair",
     "Check-ups, hygienist visits, fillings and gentle care for anyone nervous of the dentist."),
    ("lab", "dept-lab", "Diagnostics &amp; Lab",
     "A gloved hand placing a blood sample tube into a laboratory centrifuge",
     "Blood tests, ECGs and ultrasound on site, with results sent to your doctor."),
    ("skin", "dept-skin", "Dermatology",
     "A dermatologist checking a mole on a patient's back with a tablet and a dermatoscope",
     "Mole checks, eczema, acne and psoriasis clinics, with photos kept on your record."),
    ("children", "dept-children", "Children's Health",
     "A young boy in a white coat listening to a teddy bear's heart with a stethoscope",
     "Baby checks, vaccinations and a paediatric clinic every weekday afternoon."),
]


def build_footer():
    brand = column("\n".join([
        '<!-- wp:site-title {"level":0,"className":"docmed-footer__brand"} /-->',
        paragraph("A family clinic on Green Lane since 2009: doctors, dentists and therapists under one roof, "
                  "and one record that follows you between them.", color="on-dark"),
        social_links("docmed-squares"),
    ]), width="40%")
    depts = column("\n".join([
        heading("Departments", level=2, size="x-large", color="overlay", extra_class="docmed-footer__title"),
        plain_list(['<a href="%s">%s</a>' % (home("/departments/"), d[2]) for d in DEPARTMENTS[:5]],
                   "docmed-footer__links"),
    ]), width="20%")
    links = column("\n".join([
        heading("Useful links", level=2, size="x-large", color="overlay", extra_class="docmed-footer__title"),
        plain_list(['<a href="%s">About us</a>' % home("/about/"),
                    '<a href="%s">Our doctors</a>' % home("/doctors/"),
                    '<a href="%s">Health news</a>' % home("/blog/"),
                    '<a href="%s">Contact</a>' % home("/contact/"),
                    '<a href="%s">Appointments</a>' % home("/appointment/")], "docmed-footer__links"),
    ]), width="20%")
    address = column("\n".join([
        heading("Address", level=2, size="x-large", color="overlay", extra_class="docmed-footer__title"),
        paragraph("%s<br>%s<br><a href=\"%s\">%s</a><br><a href=\"mailto:%s\">%s</a>"
                  % (ADDRESS, TOWN, PHONE_HREF, PHONE, EMAIL, EMAIL), color="on-dark",
                  extra_class="docmed-footer__address"),
        paragraph(HOURS, color="on-dark", size="small"),
    ]), width="20%")
    body = columns([brand, depts, links, address], gap="60")
    legal = group(paragraph('&copy; Docmed Family Clinic. All rights reserved. Theme by '
                            '<a href="https://colorlib.com/" rel="nofollow">Colorlib</a>.',
                            align="center", size="small", color="on-dark", extra_class="docmed-footer__legal"),
                  align="full", layout="constrained", extra_class="docmed-footer__bottom")
    write("footer", "Footer",
          group(group(body, align="full", layout="constrained", padding_y="80", extra_class="docmed-footer__top")
                + "\n" + legal, align="full", background="dark", text="on-dark", layout="constrained",
                extra_class="docmed-footer"),
          keywords=["footer", "address", "links"],
          description="The template's dark footer: the logo, a line about the clinic and social squares, "
                      "departments, useful links and the address, with the copyright line beneath.",
          block_types=["core/template-part/footer"])


def box(title, inner):
    """One of the sidebar's pale boxes."""
    parts = []
    if title:
        parts.append(heading(title, level=2, size="large", extra_class="docmed-widget__title"))
    parts.append(inner)
    return group("\n".join(parts), layout="constrained", gap="40", style="docmed-panel")


def build_sidebar():
    inner = "\n".join([
        box(None, '<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search keyword","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true} /-->'),
        box("Category", '<!-- wp:categories {"showPostCounts":true,"className":"docmed-counts"} /-->'),
        box("Recent posts", '<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageSizeSlug":"thumbnail","featuredImageAlign":"left","featuredImageSizeWidth":80,"featuredImageSizeHeight":80,"className":"docmed-recent"} /-->'),
        box("Tag clouds", '<!-- wp:tag-cloud {"smallestFontSize":"0.8125rem","largestFontSize":"0.8125rem","className":"docmed-tags"} /-->'),
        box("Newsletter", paragraph("A short health note from our doctors once a month. No advertising.")
            + "\n" + shortcode('[docmed_form type="newsletter" layout="stacked" button="Subscribe"]')),
    ])
    write("sidebar", "Sidebar", group(inner, layout="constrained", gap="50", extra_class="docmed-sidebar"),
          keywords=["sidebar"], inserter=False,
          description="Search, categories, recent posts, tags and a newsletter sign-up, each in a pale box.")


# ---------------------------------------------------------------------------
# Sections
# ---------------------------------------------------------------------------
# hero.webp is a studio portrait widened by continuing its backdrop
# (.dev/photos/extend.py), so the doctor stands in the right third and the
# left is quiet ground for the words, as in the template. On a phone the cover
# keeps the doctor's face at the top and the words sit below it.
HERO_FOCAL = (0.72, 0.3)


def build_hero():
    inner = "\n".join([
        heading('<strong>Health Care</strong> <br>For the Whole Family', level=1, color="ink",
                size="colossal", extra_class="docmed-hero__title"),
        paragraph("Family doctors, dentists, eye care and physiotherapy under one roof on Green Lane, "
                  "with same-day appointments every weekday.", color="ink", extra_class="docmed-hero__text"),
        buttons([button("Our Departments", home("/departments/"))]),
    ])
    write("hero", "Hero",
          cover(group(inner, layout="constrained", content_size="620px", gap="40",
                      extra_class="docmed-hero__words"), "hero", overlay="base", dim=0, min_height=700,
                content_position="center left", extra_class="docmed-hero", focal=HERO_FOCAL,
                inner_layout="default"),
          categories=SECTIONS, keywords=["hero", "banner"],
          description="A doctor on the right of a pale studio photograph, the headline, a line of copy and "
                      "a button on the left.")


def build_services_band():
    cells = [
        ("stethoscope", "Family Doctor",
         "Register once and see the same doctor, with your whole family's record in one place.",
         button("Register with us", home("/contact/"), style="docmed-outline")),
        ("phone-call", "Same-Day Care",
         "Unwell today? Call before 10am and we will fit you in before the end of the day.",
         button(SAME_DAY, SAME_DAY_HREF, style="docmed-outline")),
        ("calendar-event", "Book a Visit",
         "Choose a department, a doctor and a day, and we will confirm the time by phone or email.",
         appointment_button("Make an Appointment", style="docmed-outline")),
    ]
    cols = []
    for n, (ico, title, text, btn) in enumerate(cells):
        inner = "\n".join([
            paragraph("", extra_class="docmed-band__icon " + icon(ico), placeholder=" "),
            heading(title, level=3, color="on-primary", extra_class="docmed-band__title"),
            paragraph(text, color="on-primary"),
            buttons([btn]),
        ])
        cols.append(column(group(inner, layout="constrained", gap="30", extra_class="docmed-band__cell"),
                           background="primary-deep" if n == 1 else None))
    write("services-band", "Service band: three cells",
          group(columns(cols, gap="0", extra_class="docmed-band__row"), align="full", background="primary",
                text="on-primary", layout="constrained", extra_class="docmed-band"),
          categories=SECTIONS, keywords=["services", "band", "features"],
          description="Three services side by side on the brand blue, the middle one a shade deeper, "
                      "each with an icon, a line of copy and an outlined button.")


def build_welcome(anchor=None):
    photos = group("\n".join([
        image("about-1", "An older doctor listening to a young boy's chest with a stethoscope while his mother "
                         "looks on", ratio="382/464", extra_class="docmed-welcome__one"),
        image("about-2", "A doctor in a white coat taking a woman's blood pressure at his desk",
              ratio="322/392", extra_class="docmed-welcome__two"),
    ]), layout="default", extra_class="docmed-welcome__photos")
    text = "\n".join([
        heading("Welcome to Docmed", level=2, style="docmed-kicker"),
        heading("Good care starts <br>with knowing you", level=3, size="heading", extra_class="docmed-welcome__title"),
        paragraph("Docmed is an independent family clinic. Our doctors, dentists and therapists share one "
                  "building and one record, so the person who sees you on Tuesday already knows what was said "
                  "on Monday &mdash; and your children are seen by the same faces as they grow up."),
        checks(["Appointments that start on time, and time to ask questions.",
                "Tests, scans and results handled under one roof.",
                "Evening and Saturday clinics for work and school days."]),
        buttons([button("About the clinic", home("/about/"), style="docmed-ghost")]),
    ])
    write("welcome", "Welcome: two photographs and the clinic's story",
          section(columns([
              column(photos, width="50%"),
              column(group(text, layout="constrained", gap="30"), width="50%", vertical="center",
                     extra_class="docmed-welcome__text"),
          ], gap="70", vertical="center"), anchor=anchor, extra_class="docmed-welcome"),
          categories=SECTIONS, keywords=["about", "welcome", "story"],
          description="Two overlapping photographs beside a small underlined kicker, a heading, the clinic's "
                      "story, three ticked points and a button.")


def department_card(key, slug, title, alt, text):
    body = group("\n".join([
        heading('<a href="%s">%s</a>' % (home("/departments/"), title), level=3, size="x-large"),
        paragraph(text),
        paragraph('<a href="%s">Book a visit</a>' % home("/appointment/?department=" + key),
                  extra_class="docmed-more"),
    ]), layout="constrained", gap="20", extra_class="docmed-card__body")
    return column(group(image(slug, alt, ratio="3/2") + "\n" + body, layout="default", style="docmed-card"))


def build_departments():
    rows = "\n".join(columns([department_card(*d) for d in DEPARTMENTS[i:i + 3]], gap="40") for i in (0, 3))
    inner = section_title("Our Departments",
                          "Six departments in one building, so a referral is usually a walk down the corridor.")
    write("departments", "Departments: six cards",
          section(inner + "\n" + group(rows, layout="constrained", gap="40"), background="surface",
                  anchor="departments"),
          categories=SECTIONS, keywords=["departments", "services", "cards"],
          description="Six departments on the pale blue ground, each a photograph over a white panel with a "
                      "title, a line of copy and a booking link.")


REVIEWS = [
    ("Dr. Hale has looked after three generations of our family. He still remembers my mother's birthday "
     "and my son's broken wrist, and he never makes us feel rushed.", "Maria Delgado, patient since 2011"),
    ("I rang at eight with a feverish toddler and we were seen by half past eleven. The nurse even called "
     "the next morning to ask how she was.", "James Whitfield, parent"),
    ("After my knee operation Karim got me back on my bike in a way the leaflets never could. Clear "
     "exercises, honest answers and a lot of patience.", "Anita Rao, physiotherapy patient"),
]


def build_reviews():
    slides = "\n".join(
        group("\n".join([
            paragraph(text, align="center", color="overlay", extra_class="docmed-review__text"),
            paragraph(who, align="center", color="overlay", extra_class="docmed-review__name"),
        ]), layout="constrained", gap="40", extra_class="docmed-slide")
        for text, who in REVIEWS)
    inner = "\n".join([
        paragraph('<span class="screen-reader-text">What our patients say</span>', align="center",
                  color="overlay", extra_class="docmed-review__quote " + icon("quote")),
        group(slides, layout="default", extra_class="docmed-slider"),
    ])
    write("reviews", "Patient reviews over a photograph",
          cover(group(inner, layout="constrained", content_size="840px", gap="40"), "reviews", dim=60,
                min_height=620, extra_class="docmed-reviews", focal=(0.5, 0.2)),
          categories=SECTIONS, keywords=["testimonials", "reviews", "quotes"],
          description="Three patients' words in a slider, centred over a darkened photograph of a consultation.")


TABS = [
    ("Family Medicine", "first-aid-kit", "tab-family", "Care for every age, from one practice",
     "Your family doctor is the person who knows the whole picture: check-ups, long-term conditions, "
     "vaccinations, travel advice and the conversations that do not fit anywhere else. We keep lists small "
     "enough that you can usually see the same doctor.",
     "A mother and her young son in a consultation with an older doctor, who is writing notes at his desk"),
    ("Qualified Doctors", "stethoscope", "tab-team", "A team that talks to each other",
     "Every doctor, dentist and therapist at Docmed is registered with their professional body and works "
     "from the same building. When a case needs two opinions, the two people meet in the corridor, not "
     "by letter three weeks later.",
     "Two doctors in white coats looking at a scan together on a tablet"),
    ("Same-Day Care", "phone-call", "tab-sameday", "Seen today when it cannot wait",
     "We keep appointments free every morning for patients who are unwell today. Call before 10am and a "
     "nurse will ring you back to find the right slot. For a medical emergency, always call your local "
     "emergency number.",
     "A doctor in a white coat on the phone at her desk, typing on a laptop"),
]


def build_tabs():
    bar = group(flex_row("\n".join(paragraph(t[0], extra_class="docmed-tab") for t in TABS), gap="0",
                         wrap="nowrap", extra_class="docmed-tabs__list"),
                align="full", background="surface", layout="constrained", extra_class="docmed-tabs__bar")
    panels = []
    for label, ico, slug, title, text, alt in TABS:
        words = group("\n".join([
            paragraph("", extra_class="docmed-tabs__icon " + icon(ico), placeholder=" "),
            heading(title, level=3, size="large"),
            paragraph(text),
        ]), layout="constrained", gap="30")
        panels.append(group(columns([
            column(words, vertical="center"),
            column(image(slug, alt, ratio="636/440"), vertical="center"),
        ], gap="60", vertical="center"), layout="constrained", extra_class="docmed-tabs__panel"))
    body = group("\n".join(panels), layout="constrained", padding_y="70", extra_class="docmed-tabs__panels")
    write("care-tabs", "Tabs: three ways we care",
          group(bar + "\n" + body, align="full", layout="constrained", extra_class="docmed-tabs"),
          categories=SECTIONS, keywords=["tabs", "services", "about"],
          description="Three tabs on a pale bar — family medicine, the team, same-day care — each opening an "
                      "icon, a heading, a paragraph and a photograph.")


DOCTORS = [
    ("doctor-8", "Dr. Robert Hale", "Family Medicine &middot; Medical Director",
     "An older doctor with white hair and glasses, in a white coat and tie, smiling in his consulting room"),
    ("doctor-1", "Dr. Daniel Mensah", "Family Medicine",
     "A smiling young doctor in a white coat over maroon scrubs, a stethoscope round his neck"),
    ("doctor-5", "Dr. Amira Saleh", "Paediatrics",
     "A smiling doctor in a patterned headscarf and dark green scrubs, a stethoscope round her neck"),
    ("doctor-2", "Dr. Lucia Paredes", "Optometry",
     "A doctor with long dark hair in a white coat over light blue scrubs, a stethoscope round her neck"),
    ("doctor-6", "Dr. Sofia Ramos", "Dentistry",
     "A doctor with long dark hair in navy scrubs, looking straight at the camera"),
    ("doctor-4", "Dr. Elena Novak", "Dermatology",
     "A doctor with a dark fringe in black scrubs, a stethoscope round her neck"),
    ("doctor-3", "Karim Haddad", "Physiotherapy",
     "A bearded young man in royal blue scrubs with a stethoscope, arms folded"),
    ("doctor-7", "Dr. Mateo Quispe", "Diagnostics &amp; Imaging",
     "A young doctor in a white coat holding up a chest X-ray to the light"),
]


def doctor_card(slug, name, role, alt):
    return group("\n".join([
        image(slug, alt, ratio="302/286"),
        group("\n".join([
            heading(name, level=3, size="large", align="center"),
            paragraph(role, align="center", size="x-small", extra_class="docmed-doctor__role"),
        ]), layout="constrained", gap="20", extra_class="docmed-doctor__name"),
    ]), layout="default", style="docmed-doctor")


def build_doctors():
    cards = "\n".join(doctor_card(*d) for d in DOCTORS)
    track = group(cards, layout="default", extra_class="docmed-carousel")
    inner = section_title("Expert Doctors", align="left") + "\n" + track
    write("doctors-carousel", "Doctors: a sliding row",
          section(inner, anchor="doctors"),
          categories=SECTIONS, keywords=["doctors", "team", "staff", "carousel"],
          description="Eight doctors in a row that slides with arrows, four at a time on a wide screen: "
                      "a portrait over a pale panel with the name and specialty.")

    rows = "\n".join(columns([column(doctor_card(*d)) for d in DOCTORS[i:i + 4]], gap="40") for i in (0, 4))
    write("doctors-grid", "Doctors: two rows of four",
          section(group(rows, layout="constrained", gap="40"), anchor="team"),
          categories=SECTIONS, keywords=["doctors", "team", "staff", "grid"],
          description="All eight doctors in two rows of four: portrait, name and specialty.")


def build_appointment_band():
    def half(slug, title, text, btn, dim):
        inner = flex_row("\n".join([
            group("\n".join([
                heading(title, level=3, color="overlay", size="large"),
                paragraph(text, color="overlay", size="small"),
            ]), layout="constrained", gap="20", extra_class="docmed-split__words"),
            buttons([btn]),
        ]), justify="center", gap="40", wrap="wrap", extra_class="docmed-split__row")
        return column(cover(inner, slug, overlay="wash", dim=dim, min_height=242, align=None,
                            extra_class="docmed-split__half"))

    halves = [
        half("band-call", "Need to be seen today?", "Call before 10am for a same-day appointment.",
             button(SAME_DAY, SAME_DAY_HREF, style="docmed-outline", extra_class="docmed-pill"), 85),
        half("band-book", "Make an Online Appointment", "Pick a department, a doctor and a day.",
             appointment_button("Make an Appointment", style="docmed-outline", extra="docmed-pill"), 95),
    ]
    write("appointment-band", "Appointment band: call or book",
          group(columns(halves, gap="0", extra_class="docmed-split"), align="full", layout="default",
                extra_class="docmed-split__wrap"),
          categories=SECTIONS, keywords=["appointment", "call to action", "contact"],
          description="Two halves across the page on blue-washed photographs: a same-day phone line, and "
                      "the online appointment form.")


def build_appointment():
    info = group("\n".join([
        heading("Request an appointment", level=2, style="docmed-bar"),
        paragraph("Tell us who you would like to see and when suits you. A receptionist will confirm the "
                  "time by phone or email, usually within one working day."),
        group("\n".join([
            paragraph("<strong>Opening hours</strong><br>%s" % HOURS, extra_class="docmed-info " + icon("clock")),
            paragraph('<strong>Same-day line</strong><br><a href="%s">%s</a>, before 10am' % (SAME_DAY_HREF, SAME_DAY),
                      extra_class="docmed-info " + icon("phone-call")),
            paragraph("<strong>%s</strong><br>%s" % (ADDRESS, TOWN), extra_class="docmed-info " + icon("map-pin")),
        ]), layout="constrained", gap="40"),
        paragraph("This form is not for emergencies. If you need urgent help, call your local emergency "
                  "number.", size="small", extra_class="docmed-note"),
    ]), layout="constrained", gap="40")
    form = group(shortcode('[docmed_form type="appointment" layout="grid" button="Confirm appointment request"]'),
                 layout="constrained", style="docmed-form-box")
    write("appointment", "Appointment request form",
          section(columns([column(info, width="40%"), column(form, width="60%")], gap="70"),
                  background="surface", anchor="appointment"),
          categories=SECTIONS, keywords=["appointment", "booking", "form"],
          description="The clinic's hours and phone line beside the appointment request form: department, "
                      "doctor, date, time, name, phone, email and a note.")


def build_contact():
    def item(name, first, second):
        return paragraph("<strong>%s</strong><br>%s" % (first, second), extra_class="docmed-info " + icon(name))

    details = group("\n".join([
        item("map-pin", ADDRESS, TOWN),
        item("phone", '<a href="%s">%s</a>' % (PHONE_HREF, PHONE), HOURS),
        item("mail", '<a href="mailto:%s">%s</a>' % (EMAIL, EMAIL), "Send us your questions any time"),
    ]), layout="constrained", gap="50")
    form = group("\n".join([
        heading("Get in Touch", level=2, size="x-large"),
        shortcode('[docmed_form type="contact" layout="split" button="Send"]'),
    ]), layout="constrained", gap="40")
    map_block = (
        '<!-- wp:html -->\n'
        '<iframe class="docmed-map" title="Map of the streets around the clinic" loading="lazy" '
        'src="https://www.openstreetmap.org/export/embed.html?bbox=-117.4100%2C33.9650%2C-117.3500%2C33.9950&amp;layer=mapnik" '
        'style="width:100%;height:480px;border:0"></iframe>\n'
        '<!-- /wp:html -->'
    )
    inner = map_block + "\n" + spacer("70") + "\n" + columns(
        [column(form, width="66.66%"), column(details, width="33.33%")], gap="70")
    write("contact", "Contact: map, form and details",
          section(inner, anchor="contact", extra_class="docmed-contact"),
          categories=SECTIONS, keywords=["contact", "form", "map"],
          description="A map across the width, then the message form beside the address, phone and email.")


def build_news():
    query = (
        '<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post",'
        '"order":"desc","orderBy":"date","inherit":false},"className":"docmed-news","layout":{"type":"default"}} -->\n'
        '<div class="wp-block-query docmed-news"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"grid","columnCount":3}} -->\n'
        + group("\n".join([
            '<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2"} /-->',
            group("\n".join([
                '<!-- wp:post-date {"format":"M j, Y","fontSize":"x-small"} /-->',
                '<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"large"} /-->',
                '<!-- wp:post-excerpt {"excerptLength":18} /-->',
            ]), layout="constrained", gap="20", extra_class="docmed-card__body"),
        ]), layout="default", style="docmed-card") + '\n'
        '<!-- /wp:post-template -->\n'
        '<!-- wp:query-no-results -->\n'
        + paragraph("Health notes from our doctors will appear here as soon as the first post is published.",
                    align="center") + '\n'
        '<!-- /wp:query-no-results --></div>\n'
        '<!-- /wp:query -->'
    )
    inner = section_title("Health Notes", "Seasonal advice and clinic news, written by the people who work here.")
    write("latest-news", "Latest posts: three cards",
          section(inner + "\n" + query, background="surface"),
          categories=SECTIONS, keywords=["blog", "news", "posts"],
          description="The three most recent posts as cards: photograph, date, title and a short excerpt.")


# ---------------------------------------------------------------------------
# Hidden patterns: the pieces templates are built from.
# ---------------------------------------------------------------------------
def breadcrumb(current):
    """Home / current, as the template's banner has it."""
    return flex_row("\n".join([
        paragraph('<a href="%s">Home</a>' % home("/"), color="overlay", extra_class="docmed-breadcrumb__home"),
        current,
    ]), gap="20", wrap="wrap", extra_class="docmed-breadcrumb")


def banner(slug, title, description, title_block, current):
    inner = "\n".join([title_block, breadcrumb(current)])
    write(slug, title, cover(group(inner, layout="constrained", gap="20"), "banner", dim=100,
                             min_height=400, preset_gradient="banner", content_position="center left",
                             extra_class="docmed-banner", focal=(0.78, 0.35)),
          inserter=False, description=description)


def build_hidden():
    here = lambda text: paragraph(text, color="overlay")
    banner("hidden-page-banner", "Page banner", "The photograph banner a page title sits on.",
           '<!-- wp:post-title {"level":1,"textColor":"overlay"} /-->',
           '<!-- wp:post-title {"level":0,"textColor":"overlay"} /-->')
    banner("hidden-single-banner", "Post banner", "The photograph banner a post title sits on.",
           '<!-- wp:post-title {"level":1,"textColor":"overlay"} /-->',
           here("Blog"))
    banner("hidden-blog-banner", "Blog banner", "The heading for the posts page.",
           heading("Blog", level=1, color="overlay"), here("Blog"))
    banner("hidden-archive-banner", "Archive banner", "The banner an archive title sits on.",
           '<!-- wp:query-title {"type":"archive","textColor":"overlay"} /-->',
           here("Archive"))
    banner("hidden-search-banner", "Search banner", "The banner search results sit under.",
           '<!-- wp:query-title {"type":"search","textColor":"overlay"} /-->',
           here("Search"))
    banner("hidden-404-banner", "Not found banner", "The banner of the page that is not there.",
           heading("Page not found", level=1, color="overlay"), here("404"))

    posts = (
        '<!-- wp:query {"queryId":0,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post",'
        '"order":"desc","orderBy":"date","inherit":true},"className":"docmed-posts","layout":{"type":"default"}} -->\n'
        '<div class="wp-block-query docmed-posts"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|60"}}} -->\n'
        + group("\n".join([
            group("\n".join([
                '<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"750/375"} /-->',
                '<!-- wp:post-date {"format":"d M","className":"docmed-date-badge"} /-->',
            ]), layout="default", extra_class="docmed-post__media"),
            group("\n".join([
                '<!-- wp:post-title {"isLink":true,"level":2,"fontSize":"x-large"} /-->',
                '<!-- wp:post-excerpt {"excerptLength":36} /-->',
                flex_row("\n".join([
                    '<!-- wp:post-terms {"term":"category","fontSize":"small","className":"docmed-post-cats"} /-->',
                    '<!-- wp:post-comments-count {"fontSize":"small","className":"docmed-comments-count"} /-->',
                ]), gap="40", extra_class="docmed-post__meta"),
            ]), layout="constrained", gap="30", extra_class="docmed-post__body"),
        ]), layout="default", extra_class="docmed-post") + '\n'
        '<!-- /wp:post-template -->\n'
        '<!-- wp:query-no-results -->\n'
        + paragraph("Nothing here yet. Try a search, or start again from the home page.") + '\n'
        '<!-- /wp:query-no-results -->\n'
        '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->\n'
        '<!-- wp:query-pagination-previous /-->\n'
        '<!-- wp:query-pagination-numbers /-->\n'
        '<!-- wp:query-pagination-next /-->\n'
        '<!-- /wp:query-pagination --></div>\n'
        '<!-- /wp:query -->'
    )
    write("hidden-posts-list", "Posts list", posts, inserter=False,
          description="The post list used by the blog and every archive: a photograph with its date badge, "
                      "the title, an excerpt, categories and comments.")

    meta = flex_row("\n".join([
        '<!-- wp:post-terms {"term":"category","fontSize":"small","className":"docmed-post-cats"} /-->',
        '<!-- wp:post-date {"fontSize":"small"} /-->',
        '<!-- wp:post-author-name {"fontSize":"small","className":"docmed-author"} /-->',
    ]), gap="40", extra_class="docmed-post__meta")
    write("hidden-post-meta", "Post meta", meta, inserter=False,
          description="Categories, date and author for a single post.")

    comments = (
        '<!-- wp:comments {"className":"docmed-comments"} -->\n'
        '<div class="wp-block-comments docmed-comments">\n'
        '<!-- wp:comments-title {"level":2,"fontSize":"large"} /-->\n'
        '<!-- wp:comment-template -->\n'
        '<!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->\n'
        '<div class="wp-block-columns is-not-stacked-on-mobile">'
        '<!-- wp:column {"width":"70px"} -->\n<div class="wp-block-column" style="flex-basis:70px">'
        '<!-- wp:avatar {"size":70,"style":{"border":{"radius":"50%"}}} /--></div>\n<!-- /wp:column -->\n'
        '<!-- wp:column -->\n<div class="wp-block-column">'
        '<!-- wp:comment-content /-->\n'
        '<!-- wp:comment-author-name {"fontSize":"medium"} /-->\n'
        '<!-- wp:comment-date {"fontSize":"small"} /-->\n'
        '<!-- wp:comment-reply-link {"className":"docmed-reply","fontSize":"x-small"} /-->'
        '</div>\n<!-- /wp:column --></div>\n'
        '<!-- /wp:columns -->\n'
        '<!-- /wp:comment-template -->\n'
        '<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"left"}} -->\n'
        '<!-- wp:comments-pagination-previous /-->\n'
        '<!-- wp:comments-pagination-numbers /-->\n'
        '<!-- wp:comments-pagination-next /-->\n'
        '<!-- /wp:comments-pagination -->\n'
        '<!-- wp:post-comments-form /-->\n'
        '</div>\n'
        '<!-- /wp:comments -->'
    )
    write("hidden-comments", "Comments", comments, inserter=False,
          description="The comments and the reply form for a single post.")

    notfound = "\n".join([
        heading("We could not find that page", level=2, align="center"),
        paragraph("The address may be old, or the page may have moved. Try a search, or start again from "
                  "the home page.", align="center"),
        '<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search the site","buttonText":"Search","align":"center"} /-->',
        buttons([button("Back to the home page", home("/"))], align="center"),
    ])
    write("hidden-404", "404 content",
          section(group(notfound, layout="constrained", content_size="620px", gap="40")),
          inserter=False, description="What a visitor sees when nothing is there.")


# ---------------------------------------------------------------------------
# Whole pages
# ---------------------------------------------------------------------------
def ref(slug):
    return '<!-- wp:pattern {"slug":"docmed/%s"} /-->' % slug


def build_pages():
    pages = {
        "page-home": ("Page: home", ["hero", "services-band", "welcome", "departments", "reviews",
                                     "care-tabs", "doctors-carousel", "appointment-band"]),
        "page-about": ("Page: about", ["welcome", "reviews", "care-tabs", "doctors-carousel",
                                       "appointment-band"]),
        "page-departments": ("Page: departments", ["services-band", "departments", "reviews", "care-tabs",
                                                   "doctors-carousel", "appointment-band"]),
        "page-doctors": ("Page: doctors", ["doctors-grid", "reviews", "care-tabs", "appointment-band"]),
        "page-appointment": ("Page: appointment", ["appointment", "appointment-band"]),
        "page-contact": ("Page: contact", ["contact"]),
    }
    for slug, (title, refs) in pages.items():
        write(slug, title, "\n".join(ref(r) for r in refs), categories=PAGES,
              description="A complete %s page, built from the theme's sections, as the template lays it out."
              % title.split(": ")[1])


def main():
    os.makedirs(PATTERNS, exist_ok=True)
    for name in os.listdir(PATTERNS):
        if name.endswith(".php"):
            os.remove(os.path.join(PATTERNS, name))
    build_header()
    build_footer()
    build_sidebar()
    build_hidden()
    build_hero()
    build_services_band()
    build_welcome()
    build_departments()
    build_reviews()
    build_tabs()
    build_doctors()
    build_appointment_band()
    build_appointment()
    build_contact()
    build_news()
    build_pages()

    for slug in sorted(WRITTEN):
        print("  patterns/%s.php" % slug)
    print("\n%d patterns" % len(WRITTEN))


if __name__ == "__main__":
    main()
