# Docmed

A block theme for family clinics, medical centres and doctors' practices.

A free WordPress block theme by [Colorlib](https://colorlib.com/). Full site editing,
no page builder and no plugins required.

- **Theme page:** https://colorlib.com/wp/themes/docmed/
- **Live demo:** https://colorlibhub.com/docmed-blocks/
- **Download:** https://updates.colorlib.com/download/theme/docmed.zip (or the zip attached to the [latest release](../../releases/latest))

## Description

Docmed is a full site editing theme for a clinic or a doctors' practice: departments, a doctors carousel and a team page, patient reviews, three tabs about how the practice works, and an appointment request form — department, doctor, preferred date and time, name, phone or email and a note — that opens from the header's "Make an Appointment" button. The appointment, contact and newsletter forms need no plugin.

It is built from the Docmed HTML template: the pale contact strip above the header, the doctor on the right of the hero, the three-cell service band, the two overlapping photographs, the department cards, the review band, the tabs, the doctors row with its arrows and the two-half appointment band are all there, as blocks you can edit.

Activate it on a new site and it builds the pages for you — Home, Departments, Doctors, About, Blog, Contact and Appointment — with a menu to match. On a site that already has pages it leaves them alone.

Eight colour palettes and five type pairings, each checked for contrast before release rather than by eye. Visitor-facing dark mode that follows the reader's system setting until they choose for themselves. WooCommerce is styled if you install it and loads nothing if you do not.

## Two versions

This repository is the **block theme**. The same design also exists as an
**Elementor edition** for sites built with Elementor: [live demo](https://colorlibhub.com/docmed/),
[source](https://github.com/ColorlibHQ/docmed-theme). It needs the free Elementor plugin. It also needs the [Docmed Companion](https://github.com/ColorlibHQ/docmed-companion) plugin. For a new site
the block theme is the one to use.

## Installation

1. In WordPress, go to Appearance → Themes → Add New Theme → Upload Theme.
2. Choose docmed.zip and click Install Now, then Activate.
3. Appearance → Editor is where the header, footer, colours and templates live.

The theme updates itself from colorlib.com: it is distributed outside the
WordPress.org directory, so it checks `updates.colorlib.com` for new versions.

## Development

The files in `.dev/` generate and check the theme (palettes, patterns, block
validation, rendered contrast, overflow and alignment checks) and build the zip.
They are not part of the distributed theme. See `.dev/README.md` where present,
and `CLAUDE.md` for the conventions.

## Licence

GNU General Public License v2 or later. Photographs and fonts carry their own
licences, listed in `readme.txt`.
