#!/usr/bin/env python
# encoding: utf-8
# Généré par Mocodo 2.3.7 le Mon, 27 Jul 2020 07:51:44

from __future__ import division
from math import hypot

import time, codecs

import json

with codecs.open('Livres_geo.json') as f:
    geo = json.loads(f.read())
(width,height) = geo.pop('size')
for (name, l) in geo.items(): globals()[name] = dict(l)
card_max_width = 19
card_max_height = 14
card_margin = 5
arrow_width = 12
arrow_half_height = 6
arrow_axis = 8
card_baseline = 3

def cmp(x, y):
    return (x > y) - (x < y)

def offset(x, y):
    return (x + card_margin, y - card_baseline - card_margin)

def line_intersection(ex, ey, w, h, ax, ay):
    if ax == ex:
        return (ax, ey + cmp(ay, ey) * h)
    if ay == ey:
        return (ex + cmp(ax, ex) * w, ay)
    x = ex + cmp(ax, ex) * w
    y = ey + (ay-ey) * (x-ex) / (ax-ex)
    if abs(y-ey) > h:
        y = ey + cmp(ay, ey) * h
        x = ex + (ax-ex) * (y-ey) / (ay-ey)
    return (x, y)

def straight_leg_factory(ex, ey, ew, eh, ax, ay, aw, ah, cw, ch):
    
    def card_pos(twist, shift):
        compare = (lambda x1_y1: x1_y1[0] < x1_y1[1]) if twist else (lambda x1_y1: x1_y1[0] <= x1_y1[1])
        diagonal = hypot(ax-ex, ay-ey)
        correction = card_margin * 1.4142 * (1 - abs(abs(ax-ex) - abs(ay-ey)) / diagonal) - shift
        (xg, yg) = line_intersection(ex, ey, ew, eh + ch, ax, ay)
        (xb, yb) = line_intersection(ex, ey, ew + cw, eh, ax, ay)
        if compare((xg, xb)):
            if compare((xg, ex)):
                if compare((yb, ey)):
                    return (xb - correction, yb)
                return (xb - correction, yb + ch)
            if compare((yb, ey)):
                return (xg, yg + ch - correction)
            return (xg, yg + correction)
        if compare((xb, ex)):
            if compare((yb, ey)):
                return (xg - cw, yg + ch - correction)
            return (xg - cw, yg + correction)
        if compare((yb, ey)):
            return (xb - cw + correction, yb)
        return (xb - cw + correction, yb + ch)
    
    def arrow_pos(direction, ratio):
        (x0, y0) = line_intersection(ex, ey, ew, eh, ax, ay)
        (x1, y1) = line_intersection(ax, ay, aw, ah, ex, ey)
        if direction == "<":
            (x0, y0, x1, y1) = (x1, y1, x0, y0)
        (x, y) = (ratio * x0 + (1 - ratio) * x1, ratio * y0 + (1 - ratio) * y1)
        return (x, y, x1 - x0, y0 - y1)
    
    straight_leg_factory.card_pos = card_pos
    straight_leg_factory.arrow_pos = arrow_pos
    return straight_leg_factory


def curved_leg_factory(ex, ey, ew, eh, ax, ay, aw, ah, cw, ch, spin):
    
    def bisection(predicate):
        (a, b) = (0, 1)
        while abs(b - a) > 0.0001:
            m = (a + b) / 2
            if predicate(bezier(m)):
                a = m
            else:
                b = m
        return m
    
    def intersection(left, top, right, bottom):
       (x, y) = bezier(bisection(lambda p: left <= p[0] <= right and top <= p[1] <= bottom))
       return (int(round(x)), int(round(y)))
    
    def card_pos(shift):
        diagonal = hypot(ax-ex, ay-ey)
        correction = card_margin * 1.4142 * (1 - abs(abs(ax-ex) - abs(ay-ey)) / diagonal)
        (top, bot) = (ey - eh, ey + eh)
        (TOP, BOT) = (top - ch, bot + ch)
        (lef, rig) = (ex - ew, ex + ew)
        (LEF, RIG) = (lef - cw, rig + cw)
        (xr, yr) = intersection(LEF, TOP, RIG, BOT)
        (xg, yg) = intersection(lef, TOP, rig, BOT)
        (xb, yb) = intersection(LEF, top, RIG, bot)
        if spin > 0:
            if (yr == BOT and xr <= rig) or (xr == LEF and yr >= bot):
                return (max(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y >= bot) - correction + shift, bot + ch)
            if (xr == RIG and yr >= top) or yr == BOT:
                return (rig, min(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x >= rig) + correction + shift)
            if (yr == TOP and xr >= lef) or xr == RIG:
                return (min(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y <= top) + correction + shift - cw, TOP + ch)
            return (LEF, max(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x <= lef) - correction + shift + ch)
        if (yr == BOT and xr >= lef) or (xr == RIG and yr >= bot):
            return (min(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y >= bot) + correction + shift - cw, bot + ch)
        if xr == RIG or (yr == TOP and xr >= rig):
            return (rig, max(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x >= rig) - correction + shift + ch)
        if yr == TOP or (xr == LEF and yr <= top):
            return (max(x for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if y <= top) - correction + shift, TOP + ch)
        return (LEF, min(y for (x, y) in ((xr, yr), (xg, yg), (xb, yb)) if x <= lef) + correction + shift)
    
    def arrow_pos(direction, ratio):
        t0 = bisection(lambda p: abs(p[0] - ax) > aw or abs(p[1] - ay) > ah)
        t3 = bisection(lambda p: abs(p[0] - ex) < ew and abs(p[1] - ey) < eh)
        if direction == "<":
            (t0, t3) = (t3, t0)
        tc = t0 + (t3 - t0) * ratio
        (xc, yc) = bezier(tc)
        (x, y) = derivate(tc)
        if direction == "<":
            (x, y) = (-x, -y)
        return (xc, yc, x, -y)
    
    diagonal = hypot(ax - ex, ay - ey)
    (x, y) = line_intersection(ex, ey, ew + cw / 2, eh + ch / 2, ax, ay)
    k = (cw *  abs((ay - ey) / diagonal) + ch * abs((ax - ex) / diagonal))
    (x, y) = (x - spin * k * (ay - ey) / diagonal, y + spin * k * (ax - ex) / diagonal)
    (hx, hy) = (2 * x - (ex + ax) / 2, 2 * y - (ey + ay) / 2)
    (x1, y1) = (ex + (hx - ex) * 2 / 3, ey + (hy - ey) * 2 / 3)
    (x2, y2) = (ax + (hx - ax) * 2 / 3, ay + (hy - ay) * 2 / 3)
    (kax, kay) = (ex - 2 * hx + ax, ey - 2 * hy + ay)
    (kbx, kby) = (2 * hx - 2 * ex, 2 * hy - 2 * ey)
    bezier = lambda t: (kax*t*t + kbx*t + ex, kay*t*t + kby*t + ey)
    derivate = lambda t: (2*kax*t + kbx, 2*kay*t + kby)
    
    curved_leg_factory.points = (ex, ey, x1, y1, x2, y2, ax, ay)
    curved_leg_factory.card_pos = card_pos
    curved_leg_factory.arrow_pos = arrow_pos
    return curved_leg_factory


def upper_round_rect(x, y, w, h, r):
    return " ".join([str(x) for x in ["M", x + w - r, y, "a", r, r, 90, 0, 1, r, r, "V", y + h, "h", -w, "V", y + r, "a", r, r, 90, 0, 1, r, -r]])

def lower_round_rect(x, y, w, h, r):
    return " ".join([str(x) for x in ["M", x + w, y, "v", h - r, "a", r, r, 90, 0, 1, -r, r, "H", x + r, "a", r, r, 90, 0, 1, -r, -r, "V", y, "H", w]])

def arrow(x, y, a, b):
    c = hypot(a, b)
    (cos, sin) = (a / c, b / c)
    return " ".join([str(x) for x in [ "M", x, y, "L", x + arrow_width * cos - arrow_half_height * sin, y - arrow_half_height * cos - arrow_width * sin, "L", x + arrow_axis * cos, y - arrow_axis * sin, "L", x + arrow_width * cos + arrow_half_height * sin, y + arrow_half_height * cos - arrow_width * sin, "Z"]])

def safe_print_for_PHP(s):
    try:
        print(s)
    except UnicodeEncodeError:
        print(s.encode("utf8"))


lines = '<?xml version="1.0" standalone="no"?>\n<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN"\n"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'
lines += '\n\n<svg width="%s" height="%s" view_box="0 0 %s %s"\nxmlns="http://www.w3.org/2000/svg"\nxmlns:link="http://www.w3.org/1999/xlink">' % (width,height,width,height)
lines += u'\\n\\n<desc>Généré par Mocodo 2.3.7 le %s</desc>' % time.strftime("%a, %d %b %Y %H:%M:%S", time.localtime())
lines += '\n\n<rect id="frame" x="0" y="0" width="%s" height="%s" fill="%s" stroke="none" stroke-width="0"/>' % (width,height,colors['background_color'] if colors['background_color'] else "none")

lines += u"""\n\n<!-- Association passer -->"""
(x,y) = (cx[u"passer"],cy[u"passer"])
(ex,ey) = (cx[u"Client"],cy[u"Client"])
leg=straight_leg_factory(ex,ey,39,55,x,y,59,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"passer,Client"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">0,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Commande"],cy[u"Commande"])
leg=straight_leg_factory(ex,ey,55,38,x,y,59,29,18+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"passer,Commande"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-passer">""" % {}
path = upper_round_rect(-59+x,-29+y,118,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-59+x,-1.0+y,118,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="118" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -59+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -59+x, 'y0': -1+y, 'x1': 59+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">passer</text>""" % {'x': -31+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">DateCommande</text>""" % {'x': -52+x, 'y': 17.1+y, 'text_color': colors['association_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association rediger -->"""
(x,y) = (cx[u"rediger"],cy[u"rediger"])
(ex,ey) = (cx[u"Livre"],cy[u"Livre"])
leg=straight_leg_factory(ex,ey,56,81,x,y,43,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"rediger,Livre"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">0,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Auteur"],cy[u"Auteur"])
leg=straight_leg_factory(ex,ey,42,55,x,y,43,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"rediger,Auteur"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-rediger">""" % {}
path = upper_round_rect(-43+x,-29+y,86,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-43+x,-1.0+y,86,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="86" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -43+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -43+x, 'y0': -1+y, 'x1': 43+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">rediger</text>""" % {'x': -36+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association contenir -->"""
(x,y) = (cx[u"contenir"],cy[u"contenir"])
(ex,ey) = (cx[u"Commande"],cy[u"Commande"])
leg=straight_leg_factory(ex,ey,55,38,x,y,48,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"contenir,Commande"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Exemplaire"],cy[u"Exemplaire"])
leg=straight_leg_factory(ex,ey,60,30,x,y,48,29,18+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"contenir,Exemplaire"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-contenir">""" % {}
path = upper_round_rect(-48+x,-29+y,96,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-48+x,-1.0+y,96,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="96" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -48+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -48+x, 'y0': -1+y, 'x1': 48+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">contenir</text>""" % {'x': -41+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">quantite</text>""" % {'x': -41+x, 'y': 17.1+y, 'text_color': colors['association_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association appartenir -->"""
(x,y) = (cx[u"appartenir"],cy[u"appartenir"])
(ex,ey) = (cx[u"Livre"],cy[u"Livre"])
leg=straight_leg_factory(ex,ey,56,81,x,y,57,29,18+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"appartenir,Livre"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Categorie"],cy[u"Categorie"])
leg=straight_leg_factory(ex,ey,54,38,x,y,57,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"appartenir,Categorie"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">0,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-appartenir">""" % {}
path = upper_round_rect(-57+x,-29+y,114,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-57+x,-1.0+y,114,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="114" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -57+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -57+x, 'y0': -1+y, 'x1': 57+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">appartenir</text>""" % {'x': -50+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association travailler -->"""
(x,y) = (cx[u"travailler"],cy[u"travailler"])
(ex,ey) = (cx[u"Auteur"],cy[u"Auteur"])
leg=straight_leg_factory(ex,ey,42,55,x,y,56,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(True,shift[u"travailler,Auteur"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Editeur"],cy[u"Editeur"])
leg=straight_leg_factory(ex,ey,56,47,x,y,56,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"travailler,Editeur"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-travailler">""" % {}
path = upper_round_rect(-56+x,-29+y,112,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-56+x,-1.0+y,112,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="112" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -56+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -56+x, 'y0': -1+y, 'x1': 56+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">travailler</text>""" % {'x': -49+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association editer -->"""
(x,y) = (cx[u"editer"],cy[u"editer"])
(ex,ey) = (cx[u"Livre"],cy[u"Livre"])
leg=straight_leg_factory(ex,ey,56,81,x,y,36,29,18+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"editer,Livre"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Editeur"],cy[u"Editeur"])
leg=straight_leg_factory(ex,ey,56,47,x,y,36,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"editer,Editeur"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-editer">""" % {}
path = upper_round_rect(-36+x,-29+y,72,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-36+x,-1.0+y,72,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="72" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -36+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -36+x, 'y0': -1+y, 'x1': 36+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">editer</text>""" % {'x': -29+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Association correspondre -->"""
(x,y) = (cx[u"correspondre"],cy[u"correspondre"])
(ex,ey) = (cx[u"Livre"],cy[u"Livre"])
leg=straight_leg_factory(ex,ey,56,81,x,y,72,29,19+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"correspondre,Livre"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">0,N</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
(ex,ey) = (cx[u"Exemplaire"],cy[u"Exemplaire"])
leg=straight_leg_factory(ex,ey,60,30,x,y,72,29,18+2*card_margin,14+2*card_margin)
lines += u"""\n<line x1="%(ex)s" y1="%(ey)s" x2="%(ax)s" y2="%(ay)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'ex': ex, 'ey': ey, 'ax': x, 'ay': y, 'stroke_color': colors['leg_stroke_color']}
(tx,ty)=offset(*leg.card_pos(False,shift[u"correspondre,Exemplaire"]))
lines += u"""\n<text x="%(tx)s" y="%(ty)s" fill="%(text_color)s" font-family="Futura" font-size="11">1,1</text>""" % {'tx': tx, 'ty': ty, 'text_color': colors['card_text_color']}
lines += u"""\n<g id="association-correspondre">""" % {}
path = upper_round_rect(-72+x,-29+y,144,28,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_cartouche_color'], 'stroke_color': colors['association_cartouche_color']}
path = lower_round_rect(-72+x,-1.0+y,144,30,14)
lines += u"""\n	<path d="%(path)s" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'path': path, 'color': colors['association_color'], 'stroke_color': colors['association_color']}
lines += u"""\n	<rect x="%(x)s" y="%(y)s" width="144" height="58" fill="%(color)s" rx="14" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -72+x, 'y': -29+y, 'color': colors['transparent_color'], 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -72+x, 'y0': -1+y, 'x1': 72+x, 'y1': -1+y, 'stroke_color': colors['association_stroke_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">correspondre</text>""" % {'x': -65+x, 'y': -7.7+y, 'text_color': colors['association_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">quantité</text>""" % {'x': -65+x, 'y': 17.1+y, 'text_color': colors['association_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Livre -->"""
(x,y) = (cx[u"Livre"],cy[u"Livre"])
lines += u"""\n<g id="entity-Livre">""" % {}
lines += u"""\n	<g id="frame-Livre">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -56+x, 'y': -81+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="132" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -56+x, 'y': -51.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="162" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -56+x, 'y': -81+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -56+x, 'y0': -51+y, 'x1': 56+x, 'y1': -51+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Livre</text>""" % {'x': -25+x, 'y': -59.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idLivre</text>""" % {'x': -48+x, 'y': -34.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -48+x, 'y0': -31+y, 'x1': -5+x, 'y1': -31+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">titre</text>""" % {'x': -48+x, 'y': -16.9+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">prix</text>""" % {'x': -48+x, 'y': 0.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">ISBN</text>""" % {'x': -48+x, 'y': 17.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">date_Parution</text>""" % {'x': -48+x, 'y': 34.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">maison_edition</text>""" % {'x': -48+x, 'y': 51.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">auteur</text>""" % {'x': -48+x, 'y': 68.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Categorie -->"""
(x,y) = (cx[u"Categorie"],cy[u"Categorie"])
lines += u"""\n<g id="entity-Categorie">""" % {}
lines += u"""\n	<g id="frame-Categorie">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="108" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -54+x, 'y': -38+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="108" height="46" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -54+x, 'y': -8.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="108" height="76" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -54+x, 'y': -38+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -54+x, 'y0': -8+y, 'x1': 54+x, 'y1': -8+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Categorie</text>""" % {'x': -46+x, 'y': -16.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idCategorie</text>""" % {'x': -46+x, 'y': 9.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -46+x, 'y0': 12+y, 'x1': 28+x, 'y1': 12+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">description</text>""" % {'x': -46+x, 'y': 26.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Client -->"""
(x,y) = (cx[u"Client"],cy[u"Client"])
lines += u"""\n<g id="entity-Client">""" % {}
lines += u"""\n	<g id="frame-Client">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="78" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -39+x, 'y': -55+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="78" height="80" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -39+x, 'y': -25.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="78" height="110" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -39+x, 'y': -55+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -39+x, 'y0': -25+y, 'x1': 39+x, 'y1': -25+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Client</text>""" % {'x': -31+x, 'y': -33.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idClient</text>""" % {'x': -31+x, 'y': -7.9+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -31+x, 'y0': -5+y, 'x1': 19+x, 'y1': -5+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">nom</text>""" % {'x': -31+x, 'y': 9.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">email</text>""" % {'x': -31+x, 'y': 26.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">mdp</text>""" % {'x': -31+x, 'y': 43.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Commande -->"""
(x,y) = (cx[u"Commande"],cy[u"Commande"])
lines += u"""\n<g id="entity-Commande">""" % {}
lines += u"""\n	<g id="frame-Commande">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="110" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -55+x, 'y': -38+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="110" height="46" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -55+x, 'y': -8.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="110" height="76" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -55+x, 'y': -38+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -55+x, 'y0': -8+y, 'x1': 55+x, 'y1': -8+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Commande</text>""" % {'x': -47+x, 'y': -16.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idCommande</text>""" % {'x': -47+x, 'y': 9.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -47+x, 'y0': 12+y, 'x1': 37+x, 'y1': 12+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">numero</text>""" % {'x': -47+x, 'y': 26.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Editeur -->"""
(x,y) = (cx[u"Editeur"],cy[u"Editeur"])
lines += u"""\n<g id="entity-Editeur">""" % {}
lines += u"""\n	<g id="frame-Editeur">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -56+x, 'y': -47+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="64" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -56+x, 'y': -17.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="112" height="94" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -56+x, 'y': -47+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -56+x, 'y0': -17+y, 'x1': 56+x, 'y1': -17+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Editeur</text>""" % {'x': -36+x, 'y': -25.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idEditeur</text>""" % {'x': -48+x, 'y': 0.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -48+x, 'y0': 3+y, 'x1': 9+x, 'y1': 3+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">maison_edition</text>""" % {'x': -48+x, 'y': 17.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">date_parution</text>""" % {'x': -48+x, 'y': 34.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Auteur -->"""
(x,y) = (cx[u"Auteur"],cy[u"Auteur"])
lines += u"""\n<g id="entity-Auteur">""" % {}
lines += u"""\n	<g id="frame-Auteur">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="84" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -42+x, 'y': -55+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="84" height="80" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -42+x, 'y': -25.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="84" height="110" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -42+x, 'y': -55+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -42+x, 'y0': -25+y, 'x1': 42+x, 'y1': -25+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Auteur</text>""" % {'x': -34+x, 'y': -33.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idAuteur</text>""" % {'x': -34+x, 'y': -7.9+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -34+x, 'y0': -5+y, 'x1': 22+x, 'y1': -5+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">nom</text>""" % {'x': -34+x, 'y': 9.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">prenom</text>""" % {'x': -34+x, 'y': 26.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">titre</text>""" % {'x': -34+x, 'y': 43.0+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}

lines += u"""\n\n<!-- Entity Exemplaire -->"""
(x,y) = (cx[u"Exemplaire"],cy[u"Exemplaire"])
lines += u"""\n<g id="entity-Exemplaire">""" % {}
lines += u"""\n	<g id="frame-Exemplaire">""" % {}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="120" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -60+x, 'y': -30+y, 'color': colors['entity_cartouche_color'], 'stroke_color': colors['entity_cartouche_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="120" height="30" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="0"/>""" % {'x': -60+x, 'y': 0.0+y, 'color': colors['entity_color'], 'stroke_color': colors['entity_color']}
lines += u"""\n		<rect x="%(x)s" y="%(y)s" width="120" height="60" fill="%(color)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x': -60+x, 'y': -30+y, 'color': colors['transparent_color'], 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n		<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1.5"/>""" % {'x0': -60+x, 'y0': 0+y, 'x1': 60+x, 'y1': 0+y, 'stroke_color': colors['entity_stroke_color']}
lines += u"""\n	</g>""" % {}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Copperplate" font-size="18">Exemplaire</text>""" % {'x': -52+x, 'y': -8.7+y, 'text_color': colors['entity_cartouche_text_color']}
lines += u"""\n	<text x="%(x)s" y="%(y)s" fill="%(text_color)s" font-family="Gill Sans" font-size="15">idExemplaire</text>""" % {'x': -52+x, 'y': 17.1+y, 'text_color': colors['entity_attribute_text_color']}
lines += u"""\n	<line x1="%(x0)s" y1="%(y0)s" x2="%(x1)s" y2="%(y1)s" stroke="%(stroke_color)s" stroke-width="1"/>""" % {'x0': -52+x, 'y0': 20+y, 'x1': 29+x, 'y1': 20+y, 'stroke_color': colors['entity_attribute_text_color']}
lines += u"""\n</g>""" % {}
lines += u'\n</svg>'

with codecs.open("Livres.svg", "w", "utf8") as f:
    f.write(lines)
safe_print_for_PHP(u'Fichier de sortie "Livres.svg" généré avec succès.')