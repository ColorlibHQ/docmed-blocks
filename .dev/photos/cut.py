#!/usr/bin/env python3
"""Cut every theme photograph from its Pexels original.

  python3 .dev/photos/cut.py <dir-with-originals>

Originals are `<pexels id>.jpg`, fetched full size from
https://images.pexels.com/photos/<id>/pexels-photo-<id>.jpeg (not committed).
Each slot is cut at twice its largest rendered size (full-bleed capped at
1920px wide) and written as WebP to assets/images/. readme.txt credits every
file; SOURCES below is the same table.
"""
import os
import sys

from PIL import Image

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from extend import extend  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
OUT = os.path.join(ROOT, "assets", "images")

# slot: (pexels id, output size, crop box in original pixels (x0, y0, x1, y1))
CROPS = {
    # About: the practice's senior GP with a family (Vitaly Gariev's clinic series).
    "about-1": ("39192341", (764, 928), (1350, 0, 3128, 2160)),
    "about-2": ("39192345", (644, 784), (1000, 0, 2776, 2160)),
    # Departments, 3:2 cards.
    "dept-eye": ("6749697", (832, 550), (300, 300, 5100, 3473)),
    "dept-physio": ("20860594", (832, 550), (0, 0, 4000, 2644)),
    "dept-dental": ("6627419", (832, 550), (0, 1500, 4480, 4462)),
    "dept-lab": ("6627687", (832, 550), (300, 0, 6720, 4244)),
    "dept-skin": ("7446661", (832, 550), (0, 1200, 3840, 3738)),
    "dept-children": ("39192352", (832, 550), (400, 0, 3668, 2160)),
    # Reviews band behind the quote.
    "reviews": ("39192354", (1920, 834), (0, 0, 3840, 1668)),
    # The three tabs.
    "tab-family": ("39192346", (1272, 880), (500, 0, 3622, 2160)),
    "tab-team": ("39192393", (1272, 880), (400, 0, 3522, 2160)),
    "tab-sameday": ("39192373", (1272, 880), (400, 0, 3522, 2160)),
    # Doctors, 604x572 cards (Daniil Kondrashin's studio series, plus the senior GP).
    "doctor-1": ("32254662", (604, 572), (440, 1110, 3534, 4040)),
    "doctor-2": ("32254667", (604, 572), (713, 1000, 3153, 3311)),
    "doctor-3": ("32115962", (604, 572), (1033, 1560, 2833, 3265)),
    "doctor-4": ("32115911", (604, 572), (693, 1100, 3493, 3752)),
    "doctor-5": ("32254657", (604, 572), (787, 1000, 3187, 3273)),
    "doctor-6": ("32115898", (604, 572), (500, 1000, 3500, 3841)),
    "doctor-7": ("32115951", (604, 572), (400, 1650, 3200, 4302)),
    "doctor-8": ("39192331", (604, 572), (870, 0, 2990, 2008)),
}

# Studio portraits widened by continuing the backdrop (extend.py).
EXTENDED = {
    # slot: (id, size, (y0, y1), head x in the original, where it lands 0..1)
    "hero": ("32254662", (1920, 800), (1000, 5200), 1985, 0.72),
    "banner": ("32115962", (1920, 440), (1750, 3100), 1933, 0.78),
    "band-call": ("32115951", (1440, 484), (1850, 3500), 2133, 0.30),
    "band-book": ("32254654", (1440, 484), (1250, 2900), 1950, 0.62),
}


def main(src):
    os.makedirs(OUT, exist_ok=True)
    for slot, (pid, size, box) in CROPS.items():
        im = Image.open(os.path.join(src, pid + ".jpg")).convert("RGB")
        x0, y0, x1, y1 = box
        want = size[0] / size[1]
        got = (x1 - x0) / (y1 - y0)
        if abs(want - got) > 0.02:
            raise SystemExit("%s: crop ratio %.3f, slot %.3f" % (slot, got, want))
        if (x1 - x0) < size[0]:
            raise SystemExit("%s: crop %dpx is narrower than the slot" % (slot, x1 - x0))
        im.crop(box).resize(size, Image.LANCZOS).save(os.path.join(OUT, slot + ".webp"), "WEBP", quality=80, method=6)
        print(slot, pid, size)
    for slot, (pid, size, region, head_x, place) in EXTENDED.items():
        im = extend(os.path.join(src, pid + ".jpg"), size[0], size[1], region, head_x, place)
        im.save(os.path.join(OUT, slot + ".webp"), "WEBP", quality=80, method=6)
        print(slot, pid, size)


if __name__ == "__main__":
    main(sys.argv[1] if len(sys.argv) > 1 else ".")
