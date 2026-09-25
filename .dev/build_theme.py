#!/usr/bin/env python3
"""
Generates theme.json and every style variation from one table of colours.

Docmed's blue, #009dff, is 2.89:1 on white; the light blue it pairs with,
#5db2ff, is 2.26:1, and the template's button gradient runs between the two
with a white label on top. That is fine for a 2px rule under a heading and
fails AA for every word a patient has to read. So the palette keeps #5db2ff as
`accent`, for decoration only, and derives `primary` (#0a6fd6, 4.93:1) and
`primary-deep` for links, labels, the button gradient and the blue bands.

Nothing here is eyeballed: audit() computes every pair the design actually
produces and refuses to write a palette that fails, including the dark-mode
palette that assets/css/scheme.css derives at runtime.

Usage:  python3 .dev/build_theme.py
"""

import collections
import json
import os
import re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
os.chdir(ROOT)

# ---------------------------------------------------------------------------
# Palette
# ---------------------------------------------------------------------------
# Thirteen slugs, the same in every variation, so a pattern written against
# them works under all of them. Every colour that sits on something other than
# `base` has its own slug: `overlay` and `on-dark` on photographs and the dark
# footer, `on-primary` on blue fills, and `ink` on the hero's pale studio
# photograph, which stays pale in a dark palette and in dark mode.
PALETTE = [
    ("Base",          "base",          "#ffffff"),
    ("Surface",       "surface",       "#f5fbff"),   # the template's pale blue panels
    ("Contrast",      "contrast",      "#1f1f1f"),   # the template's heading colour
    ("Muted",         "muted",         "#6b6b6b"),   # body copy
    ("Primary",       "primary",       "#0a6fd6"),   # readable blue: links, buttons, bands
    ("Primary deep",  "primary-deep",  "#0858ad"),   # hover, the darker band cell
    ("Accent",        "accent",        "#5db2ff"),   # the template's light blue, decorative
    ("Dark",          "dark",          "#1f1f1f"),   # the footer and the ground under photographs
    ("Divider",       "divider",       "#e3edf5"),
    ("Overlay",       "overlay",       "#ffffff"),   # text on photographs and on `dark`
    ("On dark",       "on-dark",       "#c7c7c7"),   # body copy in the footer
    ("On primary",    "on-primary",    "#ffffff"),   # labels and words on a primary fill
    ("Ink",           "ink",           "#1f1f1f"),   # words on the pale hero photograph
    # The deep blue behind white words on a photograph (the page banners, the
    # appointment band) and the hero's button on its pale photograph. A light
    # palette's `primary-deep`, but dark mode lifts both primaries to pale
    # blues, so the wash has its own slug that stays deep, and scheme.css
    # leaves it alone.
    ("Wash",          "wash",          "#0858ad"),
]

COLOR_SETS = {
    "colors-1-sky": ("Sky", {
        "base": "#ffffff", "surface": "#f5fbff", "contrast": "#1f1f1f", "muted": "#6b6b6b",
        "primary": "#0a6fd6", "primary-deep": "#0858ad", "accent": "#5db2ff", "dark": "#1f1f1f",
        "divider": "#e3edf5", "overlay": "#ffffff", "on-dark": "#c7c7c7", "on-primary": "#ffffff",
        "ink": "#1f1f1f", "wash": "#0858ad",
    }),
    "colors-2-teal": ("Teal", {
        "base": "#ffffff", "surface": "#f2faf9", "contrast": "#10201e", "muted": "#52625f",
        "primary": "#0f766e", "primary-deep": "#0b5a54", "accent": "#2ec4b6", "dark": "#0f1f1d",
        "divider": "#d9ebe8", "overlay": "#ffffff", "on-dark": "#c3d6d3", "on-primary": "#ffffff",
        "ink": "#10201e", "wash": "#0b5a54",
    }),
    "colors-3-navy": ("Navy", {
        "base": "#ffffff", "surface": "#f5f7fc", "contrast": "#111b2e", "muted": "#55617a",
        "primary": "#1d4282", "primary-deep": "#142f5e", "accent": "#3a6fd0", "dark": "#0a111e",
        "divider": "#dde3ee", "overlay": "#ffffff", "on-dark": "#c9d3e3", "on-primary": "#ffffff",
        "ink": "#111b2e", "wash": "#142f5e",
    }),
    "colors-4-sage": ("Sage", {
        "base": "#ffffff", "surface": "#f5f9f3", "contrast": "#1b2619", "muted": "#58634f",
        "primary": "#3d6b37", "primary-deep": "#2c5127", "accent": "#7fb069", "dark": "#141c12",
        "divider": "#dfe8da", "overlay": "#ffffff", "on-dark": "#cbd6c6", "on-primary": "#ffffff",
        "ink": "#1b2619", "wash": "#2c5127",
    }),
    "colors-5-plum": ("Plum", {
        "base": "#ffffff", "surface": "#faf5fa", "contrast": "#241424", "muted": "#665866",
        "primary": "#7a2e7a", "primary-deep": "#5c215c", "accent": "#b565b5", "dark": "#1a0e1a",
        "divider": "#ecdfec", "overlay": "#ffffff", "on-dark": "#d8c8d8", "on-primary": "#ffffff",
        "ink": "#241424", "wash": "#5c215c",
    }),
    "colors-6-coral": ("Coral", {
        "base": "#ffffff", "surface": "#fdf6f4", "contrast": "#2a1512", "muted": "#6d5a56",
        "primary": "#b03a29", "primary-deep": "#8c2d1f", "accent": "#f07a62", "dark": "#1c0f0d",
        "divider": "#f0e0dc", "overlay": "#ffffff", "on-dark": "#dccbc7", "on-primary": "#ffffff",
        "ink": "#2a1512", "wash": "#8c2d1f",
    }),
    # Dark palettes: `base` is the page, so it is dark here, a primary fill is
    # a light colour and its label is the DARK one. `ink` stays dark: it only
    # ever sits on the pale hero photograph.
    "colors-7-midnight": ("Midnight", {
        "base": "#0e1621", "surface": "#152030", "contrast": "#eef3f9", "muted": "#a3b0c2",
        "primary": "#6cb8ff", "primary-deep": "#9ccfff", "accent": "#5db2ff", "dark": "#070c12",
        "divider": "#243246", "overlay": "#ffffff", "on-dark": "#b9c4d2", "on-primary": "#0e1621",
        "ink": "#1f1f1f", "wash": "#0b56a8",
    }),
    "colors-8-graphite": ("Graphite", {
        "base": "#141414", "surface": "#1e1e1e", "contrast": "#f2f2f2", "muted": "#ababab",
        "primary": "#5ec8c0", "primary-deep": "#8edbd5", "accent": "#2ec4b6", "dark": "#0a0a0a",
        "divider": "#303030", "overlay": "#ffffff", "on-dark": "#bdbdbd", "on-primary": "#141414",
        "ink": "#1f1f1f", "wash": "#0f625c",
    }),
}
DEFAULT_COLORS = "colors-1-sky"

# Typography. Poppins is the template's only face. Lora is a calm, readable
# serif for a practice that wants to sound less like an app, and the system
# stack is the zero-download option. Two families, five pairings.
TYPE_SETS = {
    "type-1-poppins": ("Poppins throughout", "poppins", "poppins", None),
    "type-2-lora-poppins": ("Lora headings, Poppins text", "lora", "poppins", None),
    "type-3-poppins-system": ("Poppins headings, system text", "poppins", "system", "400"),
    "type-4-lora-system": ("Lora headings, system text", "lora", "system", "400"),
    "type-5-system": ("System fonts", "system", "system", "400"),
}

LATIN = ("U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, "
         "U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD")
LATIN_EXT = ("U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, "
             "U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, "
             "U+2C60-2C7F, U+A720-A7FF")

# name, CSS stack, [(weight, file stem)] — each stem ships as -latin and -latin-ext.
FAMILIES = collections.OrderedDict([
    ("poppins", ("Poppins", "Poppins, system-ui, -apple-system, 'Segoe UI', sans-serif",
                 [(w, "poppins-%s-" + w + "-normal") for w in ("300", "400", "500", "600", "700")])),
    ("lora", ("Lora", "Lora, Georgia, 'Times New Roman', serif",
              [("400 700", "lora-%s-wght-normal")])),
    ("system", ("System", "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif", [])),
])


def fluid(minimum, maximum):
    return collections.OrderedDict([("min", minimum), ("max", maximum)])


# The template's scale, restated: 13px for a doctor's specialty, 14px small
# print, 16px body copy (28px leading), 20px card and tab titles, 22px
# department names, 36px section titles, 50px page banners and 70px on the
# hero. Sizes without a fluid range are fixed on purpose: left to WordPress's
# default fluid rule, 16px body copy shrinks on a phone.
FONT_SIZES = [
    ("X Small",  "x-small",  "0.8125rem", None),
    ("Small",    "small",    "0.875rem",  None),
    ("Medium",   "medium",   "1rem",      None),
    ("Large",    "large",    "1.25rem",   None),
    ("X Large",  "x-large",  "1.375rem",  fluid("1.25rem", "1.375rem")),
    ("Heading",  "heading",  "2.25rem",   fluid("1.75rem", "2.25rem")),
    ("Display",  "display",  "3.125rem",  fluid("2rem", "3.125rem")),
    ("Colossal", "colossal", "4.375rem",  fluid("2.375rem", "4.375rem")),
]

# The template's sections sit 120px apart and its titles 55px above their
# content; 80 and 60 land on those at desktop and step down on a phone.
SPACING = [
    ("20", "0.5rem"),
    ("30", "1rem"),
    ("40", "1.5rem"),
    ("50", "clamp(1.75rem, 3vw, 2.5rem)"),
    ("60", "clamp(2.5rem, 4vw, 3.4375rem)"),
    ("70", "clamp(3rem, 6vw, 5rem)"),
    ("80", "clamp(4rem, 8vw, 7.5rem)"),
]

# Every foreground/background pair the design actually puts together, at the
# ratio it needs: 4.5 for text, 3 for large text and graphics.
CONTRAST_CHECKS = [
    ("contrast", "base", 4.5), ("contrast", "surface", 4.5),
    ("muted", "base", 4.5), ("muted", "surface", 4.5),
    ("primary", "base", 4.5), ("primary", "surface", 4.5),
    ("primary-deep", "base", 4.5),
    ("overlay", "dark", 4.5),
    ("on-dark", "dark", 4.5),
    # Every label and every word on a blue fill: the buttons at rest and
    # hovered, and the three service cells (primary, primary-deep).
    ("on-primary", "primary", 4.5),
    ("on-primary", "primary-deep", 4.5),
    # White words on the blue wash over photographs.
    ("overlay", "wash", 4.5),
    # The dark button is `contrast` with a `base` label.
    ("base", "contrast", 4.5),
    # `accent` is not here on purpose: it only draws the rules under titles
    # and the list ticks, decoration that WCAG 1.4.11 does not hold to 3:1.
]


# ---------------------------------------------------------------------------
# Contrast
# ---------------------------------------------------------------------------
def _channel(value):
    value = value / 255
    return value / 12.92 if value <= 0.04045 else ((value + 0.055) / 1.055) ** 2.4


def luminance(hex_colour):
    r, g, b = (int(hex_colour[i:i + 2], 16) for i in (1, 3, 5))
    return 0.2126 * _channel(r) + 0.7152 * _channel(g) + 0.0722 * _channel(b)


def contrast_ratio(a, b):
    la, lb = luminance(a), luminance(b)
    lighter, darker = max(la, lb), min(la, lb)
    return (lighter + 0.05) / (darker + 0.05)


# ---------------------------------------------------------------------------
# theme.json
# ---------------------------------------------------------------------------
def od(*pairs):
    return collections.OrderedDict(pairs)


def var(slug):
    return "var(--wp--preset--color--%s)" % slug


def fs(slug):
    return "var(--wp--preset--font-size--%s)" % slug


def ff(slug):
    return "var(--wp--preset--font-family--%s)" % slug


def sp(slug):
    valid = {s for s, _ in SPACING}
    if slug not in valid:
        raise SystemExit("spacing %r is not on the scale %s" % (slug, sorted(valid)))
    return "var(--wp--preset--spacing--%s)" % slug


def palette(colors):
    missing = [slug for _, slug, _ in PALETTE if slug not in colors]
    if missing:
        raise SystemExit("palette is missing %s" % ", ".join(missing))
    return [od(("name", name), ("slug", slug), ("color", colors[slug])) for name, slug, _ in PALETTE]


def font_families():
    out = []
    for key, (name, stack, faces) in FAMILIES.items():
        entry = od(("name", name), ("slug", key), ("fontFamily", stack))
        if faces:
            entry["fontFace"] = []
            for weight, stem in faces:
                for subset, rng in (("latin", LATIN), ("latin-ext", LATIN_EXT)):
                    entry["fontFace"].append(od(
                        ("fontFamily", name), ("fontStyle", "normal"), ("fontWeight", weight),
                        ("fontDisplay", "swap"),
                        ("src", ["file:./assets/fonts/%s.woff2" % (stem % subset)]),
                        ("unicodeRange", rng),
                    ))
        out.append(entry)
    return out


def font_files():
    files = []
    for _, (_, _, faces) in FAMILIES.items():
        for _, stem in faces:
            files += ["%s.woff2" % (stem % s) for s in ("latin", "latin-ext")]
    return files


GRADIENTS = [
    # The template's button sweep, dark blue to light, in readable shades.
    ("Brand", "brand", "linear-gradient(90deg, %s 0%%, %s 100%%)" % (var("primary-deep"), var("primary"))),
    # The inner-page banner: the template's blue wash from the left, deep
    # enough behind the title to carry white words, gone by the right third.
    ("Banner", "banner", "linear-gradient(90deg, %s 0%%, %s 45%%, transparent 90%%)"
     % (var("wash"), "color-mix(in srgb, %s 82%%, transparent)" % var("wash"))),
]


def build_settings():
    return od(
        ("appearanceTools", True),
        ("useRootPaddingAwareAlignments", True),
        # The template's Bootstrap 5 container is 1320px with 12px gutters:
        # 1296px of content at 1440.
        ("layout", od(("contentSize", "1296px"), ("wideSize", "1440px"))),
        ("color", od(("custom", True), ("defaultPalette", False), ("defaultGradients", False),
                     ("defaultDuotone", False),
                     ("palette", palette(COLOR_SETS[DEFAULT_COLORS][1])),
                     ("gradients", [od(("name", n), ("slug", s), ("gradient", g)) for n, s, g in GRADIENTS]))),
        ("typography", od(
            ("fluid", True), ("customFontSize", True), ("defaultFontSizes", False),
            ("fontFamilies", font_families()),
            # A size with no fluid range is fixed: left to WordPress's default
            # fluid rule, 15px body copy shrinks to 14px on a phone and the 18px
            # site title to 14px.
            ("fontSizes", [od(("name", name), ("slug", slug), ("size", size), ("fluid", f if f else False))
                           for name, slug, size, f in FONT_SIZES]),
        )),
        ("spacing", od(("units", ["px", "em", "rem", "vh", "vw", "%"]),
                       ("padding", True), ("margin", True), ("blockGap", True),
                       ("defaultSpacingSizes", False),
                       ("spacingSizes", [od(("name", name), ("slug", name), ("size", size))
                                         for name, size in SPACING]))),
        ("border", od(("color", True), ("radius", True), ("style", True), ("width", True))),
        ("shadow", od(("defaultPresets", False), ("presets", [
            # The template's own card hover, a long soft shadow down and left.
            # The template's department card: a faint shadow straight down.
            od(("name", "Card"), ("slug", "card"), ("shadow", "0 6px 10px rgba(0, 0, 0, 0.04)")),
            od(("name", "Header"), ("slug", "header"), ("shadow", "0 3px 16px 0 rgba(0, 0, 0, 0.1)")),
        ]))),
    )


def build_styles():
    return od(
        ("color", od(("background", var("base")), ("text", var("muted")))),
        ("typography", od(("fontFamily", ff("poppins")), ("fontSize", fs("medium")),
                          ("fontWeight", "400"), ("lineHeight", "1.75"))),
        ("spacing", od(("blockGap", sp("40")),
                       ("padding", od(("top", "0px"), ("bottom", "0px"),
                                      ("left", sp("40")), ("right", sp("40")))))),
        ("elements", od(
            ("heading", od(("typography", od(("fontFamily", ff("poppins")), ("fontWeight", "500"),
                                             ("lineHeight", "1.25"))),
                           ("color", od(("text", var("contrast")))))),
            ("h1", od(("typography", od(("fontSize", fs("display")))))),
            ("h2", od(("typography", od(("fontSize", fs("heading")))))),
            ("h3", od(("typography", od(("fontSize", fs("x-large")))))),
            ("h4", od(("typography", od(("fontSize", fs("large")))))),
            ("h5", od(("typography", od(("fontSize", "1rem"))))),
            ("h6", od(("typography", od(("fontSize", fs("small")))))),
            ("link", od(("color", od(("text", var("primary")))),
                        (":hover", od(("color", od(("text", var("primary-deep")))))))),
            ("button", od(
                # The template's gradient button, in the readable shades. The
                # label is `on-primary`, which the audit holds against both ends
                # of the gradient and the hover fill, in every palette and in
                # dark mode.
                ("color", od(("gradient", "var(--wp--preset--gradient--brand)"),
                             ("text", var("on-primary")))),
                ("typography", od(("fontFamily", "inherit"), ("fontWeight", "500"),
                                  ("fontSize", "0.9375rem"), ("lineHeight", "1.5"))),
                ("border", od(("radius", "4px"), ("width", "1px"), ("style", "solid"),
                              ("color", "transparent"))),
                ("spacing", od(("padding", od(("top", "0.9rem"), ("bottom", "0.9rem"),
                                              ("left", "2.25rem"), ("right", "2.25rem"))))),
            )),
            ("caption", od(("typography", od(("fontSize", fs("small")))))),
        )),
        ("blocks", od(
            ("core/separator", od(("color", od(("text", var("divider")))))),
            ("core/site-title", od(("typography", od(("fontWeight", "600"), ("fontSize", "1.625rem"),
                                                     ("lineHeight", "1.2"))),
                                   ("elements", od(("link", od(("color", od(("text", var("contrast")))),
                                                               ("typography", od(("textDecoration", "none"))))))))),
            ("core/navigation", od(("typography", od(("fontSize", "0.9375rem"), ("fontWeight", "500"))))),
            ("core/post-title", od(("elements", od(("link", od(("color", od(("text", var("contrast")))),
                                                               ("typography", od(("textDecoration", "none"))))))))),
            ("core/quote", od(("border", od(("left", od(("color", var("accent")), ("style", "solid"),
                                                        ("width", "3px"))))),
                              ("color", od(("background", var("surface")))),
                              ("spacing", od(("padding", od(("top", sp("40")), ("bottom", sp("40")),
                                                            ("left", sp("40")), ("right", sp("40")))))),
                              ("typography", od(("fontStyle", "normal")))),
             ),
            ("core/pullquote", od(("border", od(("top", od(("color", var("accent")), ("style", "solid"), ("width", "2px"))),
                                                ("bottom", od(("color", var("accent")), ("style", "solid"), ("width", "2px"))))))),
        )),
    )


def build_theme():
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3),
        ("settings", build_settings()),
        ("styles", build_styles()),
        ("customTemplates", [
            od(("name", "page-no-title"), ("title", "Page without banner"), ("postTypes", ["page"])),
            od(("name", "page-with-sidebar"), ("title", "Page with sidebar"), ("postTypes", ["page"])),
            od(("name", "single-no-sidebar"), ("title", "Post without sidebar"), ("postTypes", ["post"])),
        ]),
        ("templateParts", [
            od(("name", "header"), ("title", "Header"), ("area", "header")),
            od(("name", "footer"), ("title", "Footer"), ("area", "footer")),
            od(("name", "sidebar"), ("title", "Sidebar"), ("area", "uncategorized")),
        ]),
    )


def build_color_variation(slug, name, colors):
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("settings", od(("color", od(("palette", palette(colors)))))),
    )


def build_type_variation(slug, name, heading, body, weight):
    typography = od(("fontFamily", ff(body)))
    if weight:
        # A light weight is Poppins' character; in a system face it just reads thin.
        typography["fontWeight"] = weight
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("styles", od(
            ("typography", typography),
            ("elements", od(
                ("heading", od(("typography", od(("fontFamily", ff(heading)))))),
                ("button", od(("typography", od(("fontFamily", ff(body)))))),
            )),
            ("blocks", od(("core/site-title", od(("typography", od(("fontFamily", ff(heading)))))))),
        )),
    )


def write(path, data):
    os.makedirs(os.path.dirname(path) or ".", exist_ok=True)
    with open(path, "w", encoding="utf-8") as handle:
        json.dump(data, handle, indent="\t", ensure_ascii=False)
        handle.write("\n")
    return path


def _mix_with_white(hex_colour, percent):
    """CSS `color-mix(in srgb, <colour> <percent>%, white)`, per channel."""
    channels = [int(hex_colour[i:i + 2], 16) for i in (1, 3, 5)]
    share = percent / 100
    return "#" + "".join("%02x" % round(c * share + 255 * (1 - share)) for c in channels)


def _dark_scheme():
    """What assets/css/scheme.css does to the palette, read from the file itself.

    Read rather than restated: the percentages live in the CSS, and a second
    copy here would drift from it. It also refuses any colour slug the palette
    does not define — a colour-mix on an undefined variable makes the whole
    declaration invalid, `primary` stops resolving and every button renders as
    bare text, while every text check still passes.
    """
    css = open("assets/css/scheme.css", encoding="utf-8").read()
    defined = {slug for _, slug, _ in PALETTE}
    referenced = set(re.findall(r"var\(--wp--preset--color--([a-z0-9-]+)\)", css))
    unknown = sorted(referenced - defined)
    if unknown:
        raise SystemExit("scheme.css reads colour slugs the palette does not define: %s"
                         % ", ".join(unknown))

    def mix(slug):
        m = re.search(r"--wp--preset--color--%s:\s*color-mix\(in srgb,\s*"
                      r"var\(--wp--preset--color--([a-z0-9-]+)\)\s*(\d+)%%,\s*white\)"
                      % re.escape(slug), css)
        if not m:
            raise SystemExit("scheme.css: cannot read the dark-mode `%s` mix" % slug)
        return m.group(1), int(m.group(2))

    def fixed(slug):
        m = re.search(r"--wp--preset--color--%s:\s*(#[0-9a-fA-F]{6})\s*;" % re.escape(slug), css)
        if not m:
            raise SystemExit("scheme.css: cannot read the dark-mode `%s`" % slug)
        return m.group(1).lower()

    return {
        "primary": mix("primary"), "primary-deep": mix("primary-deep"),
        "on-primary": fixed("on-primary"), "base": fixed("base"), "surface": fixed("surface"),
        "contrast": fixed("contrast"), "muted": fixed("muted"),
    }


def audit():
    problems = []

    print("  light      label/primary  /deep")
    for slug, (name, colors) in sorted(COLOR_SETS.items()):
        for fg, bg, need in CONTRAST_CHECKS:
            ratio = contrast_ratio(colors[fg], colors[bg])
            if ratio < need:
                problems.append("%s: %s on %s is %.2f, needs %.1f" % (name, fg, bg, ratio, need))
        print("  %-10s %13.2f  %5.2f" % (
            name, contrast_ratio(colors["on-primary"], colors["primary"]),
            contrast_ratio(colors["on-primary"], colors["primary-deep"])))

    dark = _dark_scheme()
    print("\n  dark mode, as scheme.css applies it: primary = %s %d%%, deep = %s %d%% (+ white)"
          % (dark["primary"] + dark["primary-deep"]))
    print("  dark       text/base  text/surf  link-hover  label  label-hover  boundary")
    for slug, (name, colors) in sorted(COLOR_SETS.items()):
        fill = _mix_with_white(colors[dark["primary"][0]], dark["primary"][1])
        deep = _mix_with_white(colors[dark["primary-deep"][0]], dark["primary-deep"][1])
        measured = (
            ("primary text on base", contrast_ratio(fill, dark["base"]), 4.5),
            ("primary text on surface", contrast_ratio(fill, dark["surface"]), 4.5),
            ("hovered link on base", contrast_ratio(deep, dark["base"]), 4.5),
            ("button label on its fill", contrast_ratio(dark["on-primary"], fill), 4.5),
            ("button label on the hover fill", contrast_ratio(dark["on-primary"], deep), 4.5),
            # WCAG 1.4.11. A button has to be visible as a button, not merely
            # carry a readable label.
            ("button fill against the page",
             min(contrast_ratio(fill, dark["base"]), contrast_ratio(fill, dark["surface"])), 3.0),
        )
        for label, value, need in measured:
            if value < need:
                problems.append("%s (dark): %s is %.2f, needs %.1f" % (name, label, value, need))
        print("  %-10s %9.2f  %9.2f  %10.2f  %5.2f  %11.2f  %8.2f"
              % ((name,) + tuple(v for _, v, _ in measured)))
    for fg, bg in (("contrast", "base"), ("contrast", "surface"), ("muted", "base"), ("muted", "surface"),
                   ("base", "contrast")):
        ratio = contrast_ratio(dark[fg], dark[bg])
        if ratio < 4.5:
            problems.append("dark: %s on %s is %.2f" % (fg, bg, ratio))

    print("\n  for the record: the template's #009dff is %.2f:1 on white, #5db2ff %.2f:1 and #727272 %.2f:1 —"
          % (contrast_ratio("#009dff", "#ffffff"), contrast_ratio("#5db2ff", "#ffffff"),
             contrast_ratio("#727272", "#ffffff")))
    print("  the light blue ships as `accent`, for decoration, never as text or under a label.")
    if problems:
        raise SystemExit("\nContrast failures:\n  " + "\n  ".join(problems))


def check_fonts():
    missing = [f for f in font_files() if not os.path.exists(os.path.join("assets/fonts", f))]
    if missing:
        print("\n  warning: fonts not downloaded yet (node .dev/build-fonts.mjs): %s" % ", ".join(missing))


def main():
    audit()
    written = [write("theme.json", build_theme())]
    for slug, (name, colors) in sorted(COLOR_SETS.items()):
        written.append(write("styles/colors/%s.json" % slug, build_color_variation(slug, name, colors)))
    for slug, (name, heading, body, weight) in sorted(TYPE_SETS.items()):
        written.append(write("styles/typography/%s.json" % slug,
                             build_type_variation(slug, name, heading, body, weight)))
    check_fonts()
    print("\n  %d files written" % len(written))
    for path in written:
        print("    " + path)


if __name__ == "__main__":
    main()
