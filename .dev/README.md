# Build tooling

Nothing in `patterns/`, `theme.json` or `styles/` is written by hand. Edit the
generator, run it, and commit what it produces.

```bash
python3 .dev/build_theme.py        # theme.json + styles/colors/* + styles/typography/*
python3 .dev/build_patterns.py     # patterns/*.php
node    .dev/build-fonts.mjs       # assets/fonts/*.woff2 (only when the faces change)
python3 .dev/photos/cut.py <dir>   # assets/images/*.webp from the Pexels originals in <dir>
```

## The order that matters

Generated block markup is a guess until the editor has seen it. Block comment
attributes must match what a block's `save()` writes, and when they do not, the
editor shows "this block contains unexpected or invalid content" — while the
front end looks perfect and nothing warns you at build time.

So, against a WordPress with this theme active:

```bash
node .dev/normalize-blocks.mjs     # re-serialise every pattern as the editor would
node .dev/validate-blocks.mjs      # then fail on anything still invalid (patterns, templates, stored pages)
node .dev/explain-invalid.mjs patterns/x.php   # what the editor expected, for a pattern that will not normalise
```

A throwaway WordPress to run them against (port 9491 is this theme's):

```bash
npx -y @wp-playground/cli@3.1.54 server --port=9491 --php=8.3 --wp=latest \
  --mount-before-install="$PWD:/wordpress/wp-content/themes/docmed" \
  --blueprint=.dev/blueprint.json --login
```

The blueprint activates the theme (which builds the starter pages) and runs
`.dev/demo/import.php`, the same importer the colorlibhub demo uses: site title
and tagline, an author of its own ("Docmed Clinic"), six posts with categories,
tags, photographs from `.dev/demo/media/` and comments, and WordPress's "Hello
world!" and "Sample Page" removed. It is safe to run twice. None of it ships.
On the demo server:

```bash
sudo -u www-data wp --path=/var/www/colorlibhub.com/public \
  --url=https://colorlibhub.com/docmed-blocks/ eval "require '<dir>/import.php';"
```

**Starter pages are copies made at activation.** After changing a pattern,
restart the Playground before judging a page, or you are looking at the old one.

Every script defaults to `WP_URL=http://127.0.0.1:9491`, `admin`/`password`,
and reads the pages to visit from `DOCMED_PATHS` (comma-separated).

## The other checks

```bash
node .dev/contrast-rendered.mjs    # measured text contrast, photographs sampled by pixel
DOCMED_DARK=1 node .dev/contrast-rendered.mjs
node .dev/button-boundary.mjs      # every button visible as a button (fill/border 3:1, label 4.5:1)
DOCMED_DARK=1 node .dev/button-boundary.mjs
DOCMED_PALETTE=colors-7-midnight node .dev/contrast-rendered.mjs   # any of the eight palettes
node .dev/overflow-check.mjs       # elements wider than the box they live in, 1400/1024/768/390
node .dev/alignment-check.mjs      # constrained children that took the width cap but not the centring
python3 .dev/dead-selectors.py     # CSS nothing emits; registered block styles nothing styles
node .dev/editor-check.mjs         # every pattern opened in the editor: warnings, placeholders, icons
bash .dev/check-rendered.sh        # all of the rendered checks, every page x palette x scheme
node .dev/screenshot.mjs <url>     # screenshot.png at 1200x900
bash .dev/build-zip.sh [outdir]    # the distributable, without .dev or node_modules
```

`build_theme.py` audits every palette before writing and **refuses to emit one
that fails WCAG AA** on any foreground/background pair the design produces,
including the dark-mode palette `assets/css/scheme.css` derives at runtime (it
reads that file, so the two cannot drift).

The template's own blues are decorative for that reason. `#009dff` is 2.9:1
on white and `#5db2ff` 2.3:1; the light one ships as `accent`, and deeper
shades — `primary`, `primary-deep`, `wash` — carry links, labels, the button
gradient, the blue bands and the washes behind white words on photographs.

## Side-by-sides

```bash
node .dev/capture.mjs https://preview.colorlib.com/theme/docmed .dev/compare/source \
  home=/index.html,about=/about.html,departments=/Department.html,doctors=/Doctors.html,contact=/contact.html,blog=/blog.html,single=/single-blog.html 1440,390
node .dev/capture.mjs http://127.0.0.1:9491 .dev/compare/theme \
  home=/,about=/about/,departments=/departments/,doctors=/doctors/,contact=/contact/,blog=/blog/,single=/your-first-visit/ 1440,390
node .dev/compare.mjs home,about,departments,doctors,contact,blog,single 1440,390
```

`.dev/compare/` is gitignored: its left halves are the template's third-party
photographs.

## What the measuring scripts measure, and the two traps fixed in them

- **Text on a gradient fill is sampled with only its letters made transparent**
  (and its transition off). Hiding the element instead photographed the white
  page behind every gradient button and reported its label at 1:1; with the
  transition left on, the label was still half-drawn when the pixels were read.
- **A gradient fill is its colour stops.** The button check reads
  `background-image`, not only `background-color`, and holds the worst stop.
- Large text (24px, or 18.66px bold) is held to 3:1 and icon-only buttons to
  WCAG 1.4.11's 3:1; everything else to 4.5:1.
- Text scrolled out of a clipping ancestor (the reviews slider's other slides)
  is not on screen and is skipped.
- `dead-selectors.py` ignores a bare `docmed-` prefix: an id built as
  `'docmed-' . $form` made every selector count as live and the check pass
  without checking anything.

## Spacing and colour are vocabularies, not values

`sp()` refuses any spacing step that is not on the registered scale, because an
undefined preset variable makes WordPress drop the whole declaration and the
element silently falls back to its inherited gap. The same applies to colour
slugs: patterns name `primary` or `surface`, never a hex value, which is what
lets all eight palettes restyle every section.
