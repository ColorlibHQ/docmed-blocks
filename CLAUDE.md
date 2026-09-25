# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Docmed 1.0.1** is a Colorlib **WordPress block theme** (full site editing)
for family clinics, medical centres and doctors' practices. Text domain and
slug `docmed`. 31 patterns, 14 templates, 3 parts, 8 colour palettes × 5 type
pairings, 7 starter pages built on activation, visitor dark mode, WooCommerce
styling, and appointment / contact / newsletter forms that need no plugin.

It reproduces the design of the Docmed HTML template
(`preview.colorlib.com/theme/docmed/`, Bootstrap 5) section by section — the
pale contact strip over the header, the hero with the doctor on the right, the
three-cell service band, the two overlapping welcome photographs, the
department cards, the review band, the tabs, the doctors carousel, the
two-half appointment band and the dark footer — judged with side-by-side
full-page renders (`.dev/compare/`, gitignored). The older Elementor edition
is `colorlibhub.com/docmed/` (ColorlibHQ/docmed-theme + the Docmed Companion
plugin + Contact Form 7 for its forms); this theme ships beside it.

Decisions made and not to be revisited: **block theme only, no companion
plugin, no page builder, no jQuery**; **self-hosted, not wp.org** (`Update
URI: https://updates.colorlib.com/theme/docmed.json`). On colorlibhub it is
installed as `themes/docmed-blocks`: nothing may depend on the directory name
(the updater matches the Update URI; style.css is enqueued by template path).
It is not a static HTML template — the HTML upgrade phases in the global
instructions do not apply.

Provenance: the toolchain and `inc/` were ported from
`~/Fresh Projects/horseclub-blocks` (checkers, forms) and
`~/Fresh Projects/dreamrs-blocks` (directory-independent updater, capture and
compare, `-` decoding in dead-selectors). **Every leftover word from a
source theme is a silent bug**: `grep -riE "horseclub|dreamrs|unioncorp|pato|daren"`
must find nothing outside this paragraph.

## The story (content)

One family clinic on Green Lane, Riverside: six departments (eye care,
physiotherapy, dental, diagnostics and lab, dermatology, children's health),
eight named clinicians, fictional 555-01xx phone numbers. The copy invents
ordinary practice facts (hours, names, departments) and **never claims
outcomes or statistics**; anything urgent points to the local emergency
number. Photographs are all Pexels: Daniil Kondrashin's studio portraits for
the doctors, hero and banners (the upright portraits are widened by
continuing their backdrop, `.dev/photos/extend.py`), Vitaly Gariev's clinic
series for the scenes, and four department photos from other Pexels
photographers. The HTML template's own photos were traced (Shutterstock,
Freepik, Dreamstime, Unsplash — see the release report) and none ships.
`.dev/photos/cut.py` cuts every slot from its original at 2× (originals not
committed); readme.txt credits each file.

## Commands

```bash
python3 .dev/build_theme.py        # theme.json + styles/** (audits contrast first; refuses a failing palette)
python3 .dev/build_patterns.py     # patterns/*.php (deletes and rewrites them all)
node    .dev/build-fonts.mjs       # assets/fonts: Poppins 300–700 + Lora variable, latin + latin-ext
python3 .dev/photos/cut.py <dir-of-pexels-originals>   # assets/images/*.webp

# A throwaway WordPress on this theme's port (9491). Pages are copies made at
# activation: restart after any pattern change.
npx -y @wp-playground/cli@3.1.54 server --port=9491 --php=8.3 --wp=latest \
  --mount-before-install="$PWD:/wordpress/wp-content/themes/docmed" \
  --blueprint=.dev/blueprint.json --login

node .dev/normalize-blocks.mjs     # ALWAYS after build_patterns.py; 0 changes on a second run
node .dev/validate-blocks.mjs      # patterns, templates, parts, stored pages, posts, menus
node .dev/editor-check.mjs         # every pattern opened in the editor
bash .dev/check-rendered.sh        # contrast (8 palettes × light/dark), buttons, overflow, alignment, dead selectors
node .dev/capture.mjs https://preview.colorlib.com/theme/docmed .dev/compare/source home=/index.html,...
node .dev/capture.mjs http://127.0.0.1:9491 .dev/compare/theme home=/,...
node .dev/compare.mjs home,about,departments,doctors,contact,blog,single 1440,390
bash .dev/build-zip.sh             # the distributable, without .dev, CLAUDE.md, node_modules
```

Playwright and sharp come from `node_modules`, a symlink (gitignored) to
`~/Fresh Projects/tailwind-templates/node_modules`.

## Where things live

| Concern | File(s) |
| --- | --- |
| Palettes, type, spacing, gradients, element styles | `.dev/build_theme.py` → `theme.json`, `styles/**` (never edit the JSON) |
| Sections, part bodies, hidden pieces, whole pages | `.dev/build_patterns.py` (+ `.dev/patternlib.py`) → `patterns/*.php` |
| Templates and parts | `templates/*.html`, `parts/*.html` (hand-written, validated) |
| Components, block-style CSS, icons, header, hero, carousel, tabs, dialog | `style.css` (also the editor stylesheet) |
| Forms `[docmed_form type="appointment"]` (also contact, newsletter) + header dialog | `inc/appointment.php` + `assets/css/forms.css` |
| Form-plugin styling | `inc/forms.php` + `assets/css/forms.css` |
| Starter pages + menu on activation | `inc/front-page-setup.php` |
| Dark mode | `inc/scheme.php`, `assets/css/scheme.css`, `assets/js/scheme-toggle.js` |
| Reveals, reviews slider, doctors carousel, tabs, dialog, header shadow | `assets/js/interactions.js` |
| Self-hosted updates | `inc/updates.php` |
| WooCommerce | `inc/woocommerce.php`, `assets/css/woocommerce.css` |
| Demo content (colorlibhub + Playground, not shipped) | `.dev/demo/import.php`, `.dev/demo/media/` |
| colorlib.com page material | `.dev/publish/` |

## Conventions that matter

- **Generated, then normalised.** `build_patterns.py` writes markup that
  merely parses; `normalize-blocks.mjs` re-serialises it through the real
  serialiser. Cover dim classes round half up (`85` → `-90`, JavaScript's
  `Math.round`, not Python's); `0` writes `has-background-dim-0`, `50` writes
  no step class.
- **Palette slugs name jobs.** `overlay`/`on-dark` on photographs and the dark
  footer; `on-primary` on blue fills (the service band, buttons); `ink` for
  words on the pale hero photograph (stays dark in dark palettes and dark
  mode); `wash` for the deep blue behind white words on photographs (banners,
  appointment band) and the hero button — dark mode lifts `primary` to a pale
  blue, so anything that must stay deep uses `wash`. `accent` (#5db2ff, the
  template's light blue) is decoration only.
- **The hero** is a cover pinned to the photograph's right edge on wide
  screens; below 1024px the photograph takes the top 54% and fades into its
  backdrop colour (#b5c2c8, sampled from hero.webp) so the words sit below the
  face. Checked with a face box at 1440/1280/1024/820/390.
- **The sticky header** is the whole template part with
  `top: admin-bar − --docmed-topbar-h`, so the contact strip scrolls away and
  the main row stays.
- **Forms**: one shortcode; the redirect target travels in a hidden field
  (`wp_validate_redirect`); honeypot `docmed_website`; nonce written by hand
  (no duplicate ids when the dialog and a page form share a page); select
  values must be one of the field's options; appointment needs phone **or**
  email. `docmed_form_handlers` (return true = handled, no mail) is how the
  demo swallows mail. The dialog is printed in `wp_footer` on every page except
  one whose content already holds the appointment form, and reopens after a
  submission that came from it.
- **Icons are classes on the block** (`docmed-icon--<name>`), drawn by a
  `::before` mask so the editor shows them; every name needs a rule
  (dead-selectors checks).
- **Starter content is inserted with `wp_slash()` and kses lifted** for the
  theme's own inserts only (the contact map is an `<iframe>`); the flag is
  claimed only after something was created, with an `admin_init` retry.
  Never `get_page_by_path()`.

## Theme Check

Run on the **built** zip. Two REQUIRED findings, no warnings, both deliberate:
`add_shortcode()` (forms must survive pattern expansion) and `Update URI`.
Pexels credits are not flagged.
