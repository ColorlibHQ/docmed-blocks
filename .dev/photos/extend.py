"""Widen a studio portrait by continuing its plain backdrop.

The hero and the page banners want a doctor on the right and quiet ground on
the left for the words, like the template's. The Pexels studio portraits are
upright, so the backdrop is continued sideways: each row's edge colour
(smoothed, so the grain does not streak) is carried outwards and blended into
the photograph over a soft seam, with a little noise to match the grain.
"""
import numpy as np
from PIL import Image, ImageFilter


def extend(src, out_w, out_h, region, head_x, place_x, seam=0.12, seed=1):
    """src: path. region: (y0, y1) of the original kept top to bottom.
    head_x: x (original px) that should land at place_x (0..1) of the output."""
    im = Image.open(src).convert("RGB")
    w, h = im.size
    y0, y1 = region
    scale = out_h / (y1 - y0)
    band = im.crop((0, y0, w, y1)).resize((round(w * scale), out_h), Image.LANCZOS)
    bw = band.size[0]
    a = np.asarray(band).astype(np.float32)
    off = round(place_x * out_w - head_x * scale)
    edge = max(8, bw // 40)

    def profile(cols):
        p = a[:, cols, :].mean(axis=1)                      # (out_h, 3)
        img = Image.fromarray(np.clip(p, 0, 255).astype(np.uint8)[:, None, :].repeat(4, 1))
        img = img.filter(ImageFilter.GaussianBlur(out_h / 25))
        return np.asarray(img).astype(np.float32)[:, 0, :]

    left, right = profile(slice(0, edge)), profile(slice(bw - edge, bw))
    canvas = np.zeros((out_h, out_w, 3), np.float32)
    xs = np.arange(out_w)
    for x in range(out_w):
        canvas[:, x, :] = left if x < off + bw / 2 else right
    rng = np.random.default_rng(seed)
    canvas += rng.normal(0, 1.6, canvas.shape)
    # Paste the photograph with feathered sides.
    feather = max(4, round(bw * seam))
    ramp = np.ones(bw, np.float32)
    ramp[:feather] = np.linspace(0, 1, feather)
    ramp[-feather:] = np.minimum(ramp[-feather:], np.linspace(1, 0, feather))
    x0, x1 = max(0, off), min(out_w, off + bw)
    sx0 = x0 - off
    m = ramp[sx0:sx0 + (x1 - x0)][None, :, None]
    if off > 0:
        pass
    else:
        m = m.copy(); m[:, :min(feather, x1 - x0), :] = 1 if off < 0 else m[:, :min(feather, x1 - x0), :]
    if off + bw > out_w:
        m = m.copy(); m[:, -min(feather, x1 - x0):, :] = 1
    canvas[:, x0:x1, :] = canvas[:, x0:x1, :] * (1 - m) + a[:, sx0:sx0 + (x1 - x0), :] * m
    return Image.fromarray(np.clip(canvas, 0, 255).astype(np.uint8))
