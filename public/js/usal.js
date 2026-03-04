"use strict";
var __temp = (() => {
  var K = Object.defineProperty, Ve = Object.defineProperties, Be = Object.getOwnPropertyDescriptor, Ke = Object.getOwnPropertyDescriptors, Ze = Object.getOwnPropertyNames, B = Object.getOwnPropertySymbols;
  var pe = Object.prototype.hasOwnProperty, De = Object.prototype.propertyIsEnumerable;
  var xe = (_, o, T) => o in _ ? K(_, o, { enumerable: true, configurable: true, writable: true, value: T }) : _[o] = T, N = (_, o) => {
    for (var T in o || (o = {})) pe.call(o, T) && xe(_, T, o[T]);
    if (B) for (var T of B(o)) De.call(o, T) && xe(_, T, o[T]);
    return _;
  }, he = (_, o) => Ve(_, Ke(o));
  var ke = (_, o) => {
    var T = {};
    for (var w in _) pe.call(_, w) && o.indexOf(w) < 0 && (T[w] = _[w]);
    if (_ != null && B) for (var w of B(_)) o.indexOf(w) < 0 && De.call(_, w) && (T[w] = _[w]);
    return T;
  };
  var Je = (_, o) => {
    for (var T in o) K(_, T, { get: o[T], enumerable: true });
  }, Qe = (_, o, T, w) => {
    if (o && typeof o == "object" || typeof o == "function") for (let S of Ze(o)) !pe.call(_, S) && S !== T && K(_, S, { get: () => o[S], enumerable: !(w = Be(o, S)) || w.enumerable });
    return _;
  };
  var et = (_) => Qe(K({}, "__esModule", { value: true }), _);
  var v = (_, o, T) => new Promise((w, S) => {
    var Z = (E) => {
      try {
        k(T.next(E));
      } catch (F) {
        S(F);
      }
    }, L = (E) => {
      try {
        k(T.throw(E));
      } catch (F) {
        S(F);
      }
    }, k = (E) => E.done ? w(E.value) : Promise.resolve(E.value).then(Z, L);
    k((T = T.apply(_, o)).next());
  });
  var nt = {};
  Je(nt, { default: () => tt });
  var Fe = (() => {
    if (typeof window != "undefined" && window.USAL) return window.USAL;
    if (typeof window == "undefined") return { config: function() {
      return arguments.length === 0 ? {} : this;
    }, destroy: () => v(null, null, function* () {
    }), restart: function() {
      return v(this, null, function* () {
        return this;
      });
    }, initialized: () => false, version: "1.3.1" };
    let o = { destroying: null, restarting: null, initialized: false, observers: () => {
    }, elements: /* @__PURE__ */ new Map(), config: N({}, { defaults: { animation: "fade", direction: "u", duration: 1e3, delay: 0, threshold: 10, splitDelay: 30, forwards: false, easing: "ease-out", blur: false, loop: "mirror" }, observersDelay: 50, once: false }) }, T = "*:not(:is(area,base,br,col,embed,hr,img,input,link,meta,param,source,track,wbr,textarea,select,option,optgroup,script,style,title,iframe,object,video,audio,canvas,map,svg,math))", w = "data-usal", S = `${w}-id`, Z = `[${w}]`, L = 0, k = 1, E = 2, F = 3, ge = 4, z = 5, J = 6, ye = 7, M = 8, G = 9, W = 10, R = 11, be = 12, Q = 13, P = 14, ee = 15, $ = 1, X = 2, Y = 4, q = 8, H = "opacity", te = "transform", ne = "filter", se = "perspective", j = "display", ie = "fontWeight", re = "none", ae = "inline-block", Re = [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1], ve = 0, _e = 1, Le = 2, Te = 3, Ge = 4, Pe = ["fade", "zoomin", "zoomout", "flip", "slide"], oe = () => `__usal${Date.now()}_${Math.random().toString(36).slice(2)}`;
    function $e(e) {
      let t = e.getBoundingClientRect(), s = window.innerHeight, u = window.innerWidth;
      if (t.bottom <= 0 || t.top >= s || t.right <= 0 || t.left >= u) return 0;
      let c = Math.min(t.bottom, s) - Math.max(t.top, 0), n = Math.min(t.right, u) - Math.max(t.left, 0);
      return c / t.height * (n / t.width);
    }
    function Ie(e) {
      let t = window.getComputedStyle(e);
      return { [H]: t[H] || "1", [te]: t[te] || re, [ne]: t[ne] || re, [se]: t[se] || re, [ie]: t[ie] || "400" };
    }
    function x(e, t, s = false) {
      if (!e) return;
      let d = t, { offset: u, composite: c, easing: n } = d, i = ke(d, ["offset", "composite", "easing"]);
      e.animate([i], { duration: 0, fill: "forwards", iterations: 1, id: oe() }), o.destroying == null && !s ? e.__usalFragment = 1 : (delete e.__usalFragment, delete e.__usalOGStyle, delete e.__usalID);
    }
    let Ye = (e, t, s) => new Promise((u) => {
      requestAnimationFrame(() => {
        if (!t) {
          u();
          return;
        }
        t.getAnimations().filter((c) => c.id && c.id.startsWith("__usal")).forEach((c) => {
          var n;
          c.cancel(), c.effect = null, c.timeline = null, s && ((n = e == null ? void 0 : e.config) != null && n[M] && !e.config[M].includes("item") && (s = he(N({}, s), { [j]: ae })), x(t, s));
        }), u();
      });
    });
    function Oe(e) {
      if (e.config[R]) return;
      let t = e.element.__usalOGStyle;
      if (e.countData) {
        let s = e.countData.span;
        x(s, { [j]: "inline" });
      } else e.config[M] ? e.targets && e.targets().forEach(([s]) => {
        x(s, ce(e.splitConfig || e.config, s.__usalOGStyle || t)[0]);
      }) : x(e.element, ce(e.config, t)[0]);
      e.stop = false;
    }
    function le(e, t, s, u) {
      let c = new RegExp(`${e}-\\[[^\\]]+\\]`), n = u.match(c);
      return n ? (t[s] = n[0].slice(e.length + 2, -1), u.replace(n[0], "")) : u;
    }
    let we = (e, t = null) => {
      let s = Pe.indexOf(e);
      return s !== -1 ? s : t;
    }, Ae = (e, t = null) => {
      if (!e) return t;
      let s = 0;
      for (let u of e) switch (u) {
        case "u":
          s |= $;
          break;
        case "d":
          s |= X;
          break;
        case "l":
          s |= Y;
          break;
        case "r":
          s |= q;
          break;
      }
      return s > 0 ? s : t;
    };
    function Ne() {
      let e = new Array(16).fill(null);
      return e[Q] = [], e[ee] = "index", e;
    }
    function Se(e) {
      var u;
      let t = Ne();
      e = le("count", t, G, e), e = le("easing", t, z, e), e = le("line", t, P, e);
      let s = e.split(/\s+/).filter(Boolean);
      for (let c of s) {
        let n = c.split("-"), i = n[0];
        if (t[L] === null && (t[L] = we(i), t[L] !== null)) {
          t[k] = Ae(n[1]), t[Q] = n.slice(1 + (t[k] ? 1 : 0)).filter((d) => !isNaN(d) && d !== "").map((d) => +d);
          continue;
        }
        switch (c) {
          case "once":
            t[ye] = true;
            break;
          case "forwards":
            t[be] = true;
            break;
          case "linear":
          case "ease":
          case "ease-in":
          case "ease-out":
          case "ease-in-out":
          case "step-start":
          case "step-end":
            t[z] = c;
            break;
          default:
            switch (i) {
              case "split":
                n[1] && (t[M] = ((u = t[M]) != null ? u : "") + " " + c.slice(6));
                break;
              case "blur":
                n[1] ? t[J] = +n[1] : t[J] = true;
                break;
              case "loop":
                n[1] === "mirror" || n[1] === "jump" ? t[R] = n[1] : t[R] = true;
                break;
              case "text":
                (n[1] === "shimmer" || n[1] === "fluid") && (t[W] = n[1]);
                break;
              case "duration":
                n[1] && (t[E] = +n[1]);
                break;
              case "delay":
                n[1] && (t[F] = +n[1]), n[2] && (t[ee] = n[2]);
                break;
              case "threshold":
                n[1] && (t[ge] = +n[1]);
                break;
            }
        }
      }
      return t;
    }
    function Ce(e, t, s = false) {
      let u = e.replace(/\s/g, "").toLowerCase();
      function c(r, l, p, y) {
        let m = l && ["x", "y", "z"].includes(l) ? l.toUpperCase() : r === "rotate" ? "Z" : "";
        return `${r}${m}(${p}${y})`;
      }
      function n(r) {
        let l = /(\w|\w\w)([+-]\d+(?:\.\d+)?)/g, p = "", y = null, m = null, h = null, f = null, I = null, O;
        for (; (O = l.exec(r)) !== null; ) {
          let [, C, He] = O, D = parseFloat(He), je = C[0], me = C[1];
          switch (je) {
            case "t":
              p += " " + c("translate", me, D, "%");
              break;
            case "r":
              p += " " + c("rotate", me, D, "deg");
              break;
            case "s":
              p += " " + c("scale", me, D, "");
              break;
            case "o":
              y = Math.max(0, Math.min(100, D)) / 100;
              break;
            case "b":
              m = `blur(${Math.max(0, D)}rem)`;
              break;
            case "g":
              f = `brightness(${Math.max(0, D) / 100})`;
              break;
            case "w":
              I = Math.max(0, D).toString();
              break;
            case "p":
              h = `${D}rem`;
              break;
          }
        }
        let A = {};
        return p && (A[te] = p.trim()), y !== null && (A[H] = y), (m || f) && (A[ne] = [m, f].filter(Boolean).join(" ")), I && (A[ie] = I), h && (A[se] = h), A;
      }
      let i = /* @__PURE__ */ new Map();
      if (u.split("|").forEach((r, l) => {
        let p = r.match(/^(\d+)/), y = l === 0 ? 0 : p ? Math.max(0, Math.min(100, parseInt(p[1]))) : 100;
        i.set(y, n(r.replace(/^\d+/, "")));
      }), Object.keys(i.get(0)).length === 0 && i.set(0, t), i.size === 1) i.set(100, t);
      else {
        let r = [...i.keys()];
        if (i.size >= 3) {
          let p = Math.min(...r);
          i.set(0, i.get(p));
        }
        let l = Math.max(...r);
        i.set(100, i.get(l));
      }
      let d = Array.from(i.entries()).filter(([r, l]) => Object.keys(l).length > 0).sort((r, l) => r[0] - l[0]), b = d.map(([r, l]) => N(N({ offset: (5 + r * 0.9) / 100 }, l), s && { display: "inline-block" })), g = N(N({}, d[0][1]), s && { display: "inline-block" }), a = N(N({}, d[d.length - 1][1]), s && { display: "inline-block" });
      return [N({ offset: 0 }, g), ...b, N({ offset: 1 }, a)];
    }
    function ce(e, t) {
      var p, y, m, h, f, I;
      if (!t) return;
      let s = e[M] && !((p = e[M]) != null && p.includes("item"));
      if (e[W] === "shimmer" ? e[P] = "o+50g+100|50o+100g+130|o+50g+100" : e[W] === "fluid" && (e[P] = "w+100|50w+900|w+100"), e[P]) return Ce(e[P], t, s);
      let u = (y = e[L]) != null ? y : we(o.config.defaults.animation, ve), c = (m = e[k]) != null ? m : Ae(o.config.defaults.direction, 1), n = (h = e[J]) != null ? h : o.config.defaults.blur, i = e[Q], d = i == null ? void 0 : i.at(0), b = i == null ? void 0 : i.at(-1), g = i == null ? void 0 : i.at(1), a = "o+0";
      u === Ge && (a = `o+${parseFloat(t[H]) * 100}`);
      let r = s ? 50 : 15, l = (b != null ? b : r) / 100;
      if (u === _e || u === Le) a += `s+${1 + (u === _e ? -l : l)}`, d = null, g = (i == null ? void 0 : i.length) === 2 ? null : g;
      else if (u === Te) {
        let O = d != null ? d : 90;
        if (c & ($ | X)) {
          let C = c & $ ? O : -O;
          a += `rx${C > 0 ? "+" : ""}${C}`;
        }
        if (c & (Y | q)) {
          let C = c & Y ? -O : O;
          a += `ry${C > 0 ? "+" : ""}${C}`;
        }
        c & ($ | X | Y | q) || (a += `ry+${O}`);
        let A = (i == null ? void 0 : i.length) === 2 ? b : 25;
        a += `p+${A != null ? A : 25}`;
      }
      if (u !== Te && c && (c & q ? a += `tx-${d != null ? d : r}` : c & Y && (a += `tx+${d != null ? d : r}`), c & X ? a += `ty-${(f = g != null ? g : d) != null ? f : r}` : c & $ && (a += `ty+${(I = g != null ? g : d) != null ? I : r}`)), n) {
        let O = n === true ? 0.625 : typeof n == "number" && !isNaN(n) ? Math.max(0, n) : 0.625;
        a += `b+${O}`;
      }
      return Ce(a, t, s);
    }
    function Ee(e, t = "index") {
      let s = e.map((a) => {
        let r = a.getBoundingClientRect();
        return { target: a, x: r.left + r.width / 2, y: r.top + r.height / 2 };
      }), u = s.reduce((a, r) => ({ minX: Math.min(a.minX, r.x), maxX: Math.max(a.maxX, r.x), minY: Math.min(a.minY, r.y), maxY: Math.max(a.maxY, r.y) }), { minX: 1 / 0, maxX: -1 / 0, minY: 1 / 0, maxY: -1 / 0 }), c = (u.minX + u.maxX) / 2, n = (u.minY + u.maxY) / 2, i = s.map((a, r) => {
        let l;
        switch (t) {
          case "linear":
            l = Math.hypot(a.x, a.y);
            break;
          case "center":
            l = Math.hypot(a.x - c, a.y - n);
            break;
          case "edges":
            l = Math.min(Math.abs(a.x - u.minX), Math.abs(a.x - u.maxX), Math.abs(a.y - u.minY), Math.abs(a.y - u.maxY));
            break;
          case "random":
            l = Math.random();
            break;
          default:
            l = r;
        }
        return l;
      }), d = Math.min(...i), g = Math.max(...i) - d || 1;
      return (a = 50) => s.map((r, l) => {
        let p = (i[l] - d) / g, y;
        return t === "index" ? y = l * a : y = p * (e.length - 1) * a, [r.target, y];
      });
    }
    function Ue(e, t, s, u) {
      let c = [];
      if (t === "item") return Array.from(e.children).forEach((r) => {
        r.__usalOGStyle = Ie(r), c.push(r);
      }), [Ee(c, s), null];
      function n(r) {
        let l = document.createElement("span");
        return l.textContent = r, l;
      }
      function i(r) {
        if (!(r != null && r.trim())) return r ? document.createTextNode(r) : null;
        let l = document.createElement("span");
        return r.split(/(\s+)/).forEach((y) => {
          if (!y) return;
          if (/\s/.test(y)) {
            l.appendChild(document.createTextNode(y));
            return;
          }
          if (t === "word") {
            let f = n(y);
            x(f, { [j]: ae }), l.appendChild(f), c.push(f);
            return;
          }
          let m = document.createElement("span");
          x(m, { [j]: ae, whiteSpace: "nowrap" });
          let h;
          if (typeof Intl != "undefined" && Intl.Segmenter) {
            let f = new Intl.Segmenter(void 0, { granularity: "grapheme" });
            h = Array.from(f.segment(y), (I) => I.segment);
          } else h = y.match(new RegExp("\\p{RI}\\p{RI}|(?:\\p{Emoji}(?:\\u200D\\p{Emoji})*)|(?:\\P{M}\\p{M}*)|.", "gsu")) || [y];
          h.forEach((f) => {
            let I = n(f);
            m.appendChild(I), c.push(I);
          }), l.appendChild(m);
        }), l;
      }
      let d = [], b = 0, g = null, a = document.createTreeWalker(e, NodeFilter.SHOW_TEXT, null, false);
      for (; a.nextNode(); ) a.currentNode.textContent.trim() && (d.push(a.currentNode), b++);
      return d.length && (g = []), d.forEach((r) => {
        if (!r.parentNode || !r.isConnected) {
          b--, b === 0 && u();
          return;
        }
        let l = i(r.textContent);
        g.push(l), requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            try {
              r.parentNode && r.parentNode.replaceChild(l, r);
            } finally {
              b--, b === 0 && u();
            }
          });
        });
      }), [Ee(c, s), g];
    }
    function ze(e, t, s, u) {
      let c = t[G].trim(), n = c.replace(/[^\d\s,.]/g, ""), i = [",", ".", " "].filter((m) => n.includes(m)), d = i.map((m) => ({ s: m, p: n.lastIndexOf(m) })).sort((m, h) => h.p - m.p), b, g = 0, a = "", r = "";
      if (i.length === 0) b = parseFloat(n);
      else if (i.length === 1) {
        let m = i[0], h = n.substring(n.lastIndexOf(m) + 1);
        h.length <= 3 && h.length > 0 && m !== " " ? (r = m, g = h.length, b = parseFloat(n.replace(m, "."))) : (a = m, b = parseFloat(n.replace(new RegExp(`\\${a}`, "g"), "")));
      } else {
        r = d[0].s, a = d[1].s;
        let m = n.replace(new RegExp(`\\${a}`, "g"), "").replace(r, ".");
        b = parseFloat(m), g = n.substring(d[0].p + 1).replace(/\D/g, "").length;
      }
      let l = null, p = null;
      function y(m) {
        if (!l) if (m.nodeType === Node.TEXT_NODE) {
          let h = m.textContent, f = h.indexOf(t[G]);
          if (f !== -1) {
            let I = h.substring(0, f), O = h.substring(f + t[G].length);
            p = document.createElement("span"), I && p.appendChild(document.createTextNode(I)), l = document.createElement("span"), l.textContent = c, p.appendChild(l), O && p.appendChild(document.createTextNode(O)), s.textWrappers = [p], requestAnimationFrame(() => {
              requestAnimationFrame(() => {
                try {
                  m.parentNode && m.parentNode.replaceChild(p, m);
                } finally {
                  u();
                }
              });
            });
          }
        } else m.nodeType === Node.ELEMENT_NODE && Array.from(m.childNodes).forEach(y);
      }
      return y(e), l ? (s.countData = { value: b, decimals: g, span: l, thousandSep: a, decimalSep: r }, true) : (u(), false);
    }
    function We(e, t) {
      let { duration: s, easing: u } = t, { value: c, decimals: n, span: i, thousandSep: d, decimalSep: b } = e, g = 0, a = "idle", r = 1;
      function l(h) {
        switch (h) {
          case "linear":
            return (f) => f;
          case "ease":
            return (f) => f === 0 ? 0 : f === 1 ? 1 : f < 0.5 ? 4 * f * f * f : 1 - Math.pow(-2 * f + 2, 3) / 2;
          case "ease-in":
            return (f) => f * f * f;
          case "ease-out":
            return (f) => 1 - Math.pow(1 - f, 3);
          case "ease-in-out":
            return (f) => f < 0.5 ? 4 * f * f * f : 1 - Math.pow(-2 * f + 2, 3) / 2;
          default:
            return (f) => f < 0.5 ? 4 * f * f * f : 1 - Math.pow(-2 * f + 2, 3) / 2;
        }
      }
      let p = l(u);
      function y(h) {
        let f = (n > 0 ? h.toFixed(n) : Math.floor(h).toString()).split(".");
        if (d && f[0].length > 3) {
          let I = f[0].split("").reverse();
          f[0] = I.reduce((O, A, C) => C > 0 && C % 3 === 0 ? A + d + O : A + O, "");
        }
        return f.length > 1 && b ? f[0] + b + f[1] : f[0];
      }
      function m(h) {
        let f = Math.max(0, Math.min(1, h / s));
        if (f <= 0.06) i.textContent = y(0);
        else if (f >= 0.94) i.textContent = y(c);
        else {
          let I = (f - 0.05) / 0.9, O = p(I), A = c * O;
          i.textContent = y(A);
        }
        (f >= 1 && r > 0 || f <= 0 && r < 0) && (a = "finished");
      }
      return { tick(h, f = false) {
        (f && a !== "paused" || a === "running") && (a = "running", g = g + (r > 0 ? h : -h), g = Math.max(0, Math.min(s, g)), m(g));
      }, play() {
        a === "finished" || a === "running" || (a = "running");
      }, pause() {
        a === "running" && (a = "paused");
      }, cancel() {
        g = s * 0.95, m(g), a = "finished";
      }, persist() {
      }, get playState() {
        return a;
      }, get currentTime() {
        return g;
      }, set currentTime(h) {
        g = Math.max(0, Math.min(s, h)), m(g);
      }, get playbackRate() {
        return r;
      }, set playbackRate(h) {
        r = h;
      } };
    }
    class Xe {
      reset() {
        this.rafId = null, this.lastTickTime = null, this.virtualTime = 0, this.animations = /* @__PURE__ */ new Map();
      }
      constructor(t) {
        this.data = t, this.reset();
      }
      timeToSayGoodbye() {
        return this.animations.size !== 0 ? false : (cancelAnimationFrame(this.rafId), this.reset(), this.data.resolve(), true);
      }
      cleanupAnimation(t) {
        t.forEach(([s, u]) => {
          let c = () => {
            this.animations.delete(s), this.timeToSayGoodbye();
          };
          this.data.countData ? (s.cancel(), c()) : Ye(this.data, u.element, u.originalStyle).then(() => {
            c();
          });
        });
      }
      prepare(t) {
        var c;
        let s = [], u = [];
        for (let [n, i] of this.animations) {
          if (this.data.stop) {
            s.push([n, i]);
            continue;
          }
          (c = n.tick) == null || c.call(n, t, i.loop);
          let d = n.currentTime / i.duration;
          if (!i.loop && (d >= 0.95 || n.playState === "finished")) {
            s.push([n, i]);
            continue;
          } else !i.waiting && !i.pendingPlay && (d >= 0.95 && i.playbackRate > 0 || d <= 0.05 && i.playbackRate < 0) && (i.playbackRate < 0 ? n.currentTime = i.duration * 0.03 : n.currentTime = i.duration * 0.97, n.pause(), i.waiting = true);
          i.pendingPlay && this.virtualTime >= i.playAt && (i.pendingPlay = false, n.play()), u.push(i);
        }
        return { toCleanup: s, toAnimate: u };
      }
      animate(t) {
        if (t.length > 0 && t.every((s) => s.waiting)) {
          let s = t[0].loop === "jump", u = s ? 1 : -t[0].playbackRate, c = t.map((i) => i.staggerDelay), n = Math.max(...c);
          t.forEach((i) => {
            s && (i.animation.currentTime = i.duration * 0.03), i.animation.playbackRate = u, i.playbackRate = u, i.waiting = false;
            let d = i.staggerDelay;
            u < 0 && (d = n - i.staggerDelay), !i.hasStarted && i.initialDelay > 0 && (i.hasStarted = true, d += i.initialDelay), d === 0 ? i.animation.play() : (i.playAt = this.virtualTime + d, i.pendingPlay = true);
          });
        }
      }
      tick() {
        var n;
        let t = performance.now(), s = Math.min(t - ((n = this.lastTickTime) != null ? n : t), 16.67);
        this.virtualTime += s, this.lastTickTime = t;
        let { toCleanup: u, toAnimate: c } = this.prepare(s);
        this.cleanupAnimation(u), this.animate(c), this.timeToSayGoodbye() || (this.rafId = requestAnimationFrame(() => this.tick()));
      }
      add(t, s, u, c = 0, n = 0) {
        var y, m, h, f, I, O, A;
        let i = Math.max(0, (((m = (y = this.data.config[E]) != null ? y : o.config.defaults.duration) != null ? m : 1e3) + 1) / 0.9), d = (h = this.data.config[z]) != null ? h : o.config.defaults.easing, b = (I = (f = this.data.config[be]) != null ? f : o.config.defaults.forwards) != null ? I : false, g = (O = o.config.defaults.loop) != null ? O : "mirror", a = this.data.config[R] === true ? g : this.data.config[R], r = { duration: i, easing: d, fill: "forwards" }, l = [];
        this.data.config[W] && (a = a != null ? a : g, r.easing = (A = this.data.config[z]) != null ? A : "linear"), l = ce(s, u), b && (u = l[l.length - 1]), r = he(N({}, r), { delay: 0, id: oe() });
        let p = this.data.countData ? We(this.data.countData, r) : t.animate(l, r);
        p.persist(), p.currentTime = i * 0.03, p.pause(), this.animations.set(p, { animation: p, element: t, duration: i, staggerDelay: n, initialDelay: c, originalStyle: u, loop: a, playbackRate: -1, waiting: true, hasStarted: false });
      }
      letsGo() {
        var g, a, r, l, p;
        let { element: t, config: s, targets: u, splitConfig: c } = this.data, n = Math.max(0, (a = (g = s[F]) != null ? g : o.config.defaults.delay) != null ? a : 0), i = t.__usalOGStyle, d = Math.max(0, (l = (r = c[F]) != null ? r : o.config.defaults.splitDelay) != null ? l : 0), b = ((p = u == null ? void 0 : u()) == null ? void 0 : p.length) || (i ? 0 : 1);
        u ? u(d).forEach(([y, m]) => {
          let h = y.__usalOGStyle || i;
          h && (b--, this.add(y, this.data.splitConfig, h, n, parseInt(m)));
        }) : i && this.add(t, s, i, n), b === 0 && !this.rafId && this.tick();
      }
    }
    function Me(e) {
      e.stop || (e.hasAnimated = true, e.processing = new Promise((t) => {
        e.resolve = t, e.controller.letsGo();
      }).then(() => {
        e.onfinish(), e.processing = null, e.stop = true;
      }));
    }
    function ue(e, t = null) {
      var c, n;
      if (e.config[R] || e.processing !== null || e.hasAnimated && ((c = e.config[ye]) != null ? c : o.config.once)) return;
      let s = t != null ? t : $e(e.element);
      if (e.stop && s < 0.01) {
        Oe(e);
        return;
      }
      let u = Math.max(0, Math.min(1, ((n = e.config[ge]) != null ? n : o.config.defaults.threshold) / 100));
      s >= u && Me(e);
    }
    let fe = (e) => new Promise((t) => {
      e.onfinish = () => {
        e.onfinish = () => {
        }, requestAnimationFrame(() => requestAnimationFrame(() => {
          e.targets && e.targets().forEach(([s]) => {
            s.__usalOGStyle && x(s, s.__usalOGStyle, true);
          }), e.textWrappers && e.textWrappers.forEach((s) => {
            s != null && s.parentNode && s.parentNode.replaceChild(document.createTextNode(s.textContent), s);
          }), e.element.__usalOGStyle && x(e.element, e.element.__usalOGStyle, true), t();
        }));
      }, e.processing === null ? e.onfinish() : e.stop = true;
    });
    function de(e, t) {
      var d, b;
      if (e.__usalProcessing) return;
      let s = e.getAttribute(w) || "";
      s = s.replace(/\/\/[^\n\r]*/g, "").replace(new RegExp("\\/\\*.*?\\*\\/", "gs"), "").trim().toLowerCase(), !e.__usalID && s !== "" && (e.__usalOGStyle = Ie(e), e.__usalID = (d = e.getAttribute(S)) != null ? d : oe());
      let u = o.elements.get(e.__usalID);
      if (u) {
        s !== u.configString && (e.__usalProcessing = true, o.elements.delete(e.__usalID), t.unobserve(e), fe(u).then(() => {
          delete e.__usalProcessing, de(e, t);
        }));
        return;
      }
      if (s === "") return;
      e.__usalFragment = 1;
      let c = Se(s), n = { element: e, config: c, splitConfig: [...c], configString: s, targets: null, state: null, stop: false, hasAnimated: false, processing: null, countData: null, onfinish: () => {
      }, controller: null, resolve: () => {
      }, textWrappers: null };
      o.elements.set(e.__usalID, { configString: s });
      let i = (b = c[M]) == null ? void 0 : b.split(" ").find((g) => ["word", "letter", "item"].includes(g));
      n.processing = new Promise((g) => {
        let a = false;
        if (c[G]) ze(e, c, n, g);
        else if (i) {
          let r = Se(c[M]), l = Ne();
          n.splitConfig = c.map((m, h) => {
            let f = r[h], I = l[h];
            return Array.isArray(f) && Array.isArray(I) ? f.length > 0 ? f : m : f !== I ? f : m;
          });
          let [p, y] = Ue(e, i, n.splitConfig[ee], g);
          n.targets = p, n.textWrappers = y, a = y === null;
        } else a = true;
        a && g();
      }).then(() => {
        n.stop ? n.onfinish() : (o.elements.set(e.__usalID, n), n.controller = new Xe(n), Oe(n), requestAnimationFrame(() => v(null, null, function* () {
          c[R] ? Me(n) : (ue(n), t.observe(e));
        }))), n.processing = null;
      });
    }
    function qe() {
      let e = /* @__PURE__ */ new Set(), t = /* @__PURE__ */ new Set(), s = /* @__PURE__ */ new Set(), u = 0, c = null, n = new IntersectionObserver((a) => {
        for (let r of a) {
          let l = o.elements.get(r.target.__usalID || r.target.getAttribute(S));
          l && ue(l, r.intersectionRatio);
        }
      }, { threshold: Re });
      function i(a = document.body, r = /* @__PURE__ */ new Set()) {
        if (r.has(a)) return r;
        r.add(a);
        for (let l of a.querySelectorAll(T)) l.shadowRoot && !r.has(l.shadowRoot) && i(l.shadowRoot, r);
        return r;
      }
      function d(a) {
        let r = new MutationObserver(g);
        r.observe(a, { childList: true, subtree: true, attributes: true }), e.add(r);
        let l = new ResizeObserver(g);
        (a === document.body || a.host) && (l.observe(a === document.body ? a : a.host), t.add(l));
      }
      function b() {
        var r;
        for (let [l, p] of o.elements) {
          if (!p || !p.element) {
            o.elements.delete(l);
            continue;
          }
          p.element.isConnected ? ue(p) : (n.unobserve(p.element), fe(p).then(() => {
            o.elements.delete(l);
          }));
        }
        let a = i();
        for (let l of a) {
          s.has(l) || (d(l), s.add(l));
          let p = (r = l.querySelectorAll) == null ? void 0 : r.call(l, Z);
          for (let y of p) de(y, n);
        }
        u = Date.now();
      }
      function g(a) {
        let r = Array.isArray(a) ? a : [a], l = (m) => !!m.__usalFragment, p = null;
        for (let m of r) {
          if (m.type === "attributes") {
            let h = m.attributeName;
            (h === w || h === S) && (de(m.target, n), p = true);
          }
          p === null && (l(m.target) && (p = true), m.type === "childList" && [...m.addedNodes, ...m.removedNodes].some(l) && (p = true));
        }
        if (p) return;
        let y = Date.now() - u;
        y >= o.config.observersDelay ? b() : (c && clearTimeout(c), c = setTimeout(() => {
          b();
        }, Math.max(0, o.config.observersDelay - y)));
      }
      return b(), () => {
        clearTimeout(c), e.forEach((a) => a.disconnect()), t.forEach((a) => a.disconnect()), n.disconnect(), e.clear(), t.clear(), s.clear();
      };
    }
    function V() {
      o.initialized || (o.initialized = true, o.observers = qe());
    }
    let U = { config(e = {}) {
      return arguments.length === 0 ? N({}, o.config) : (e.defaults && (e.defaults = N(N({}, o.config.defaults), e.defaults)), Object.assign(o.config, e), U);
    }, destroy() {
      return v(this, null, function* () {
        return o.initialized ? (o.destroying != null || (o.destroyTimer && clearTimeout(o.destroyTimer), o.destroying = new Promise((e) => {
          o.destroyTimer = setTimeout(() => v(null, null, function* () {
            o.destroyTimer = null, o.observers();
            let t = Array.from(o.elements.values());
            yield Promise.all(t.map((s) => fe(s))), o.elements.clear(), o.observers = () => {
            }, o.initialized = false, o.destroying = null, e();
          }), 50);
        })), o.destroying) : Promise.resolve();
      });
    }, restart() {
      return v(this, null, function* () {
        return o.restarting != null || (o.destroyTimer && (clearTimeout(o.destroyTimer), o.destroyTimer = null), o.restartTimer && clearTimeout(o.restartTimer), o.restarting = new Promise((e) => {
          o.restartTimer = setTimeout(() => {
            o.restartTimer = null, U.destroy().then(() => new Promise((t) => {
              requestAnimationFrame(() => {
                document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", () => {
                  V(), t(U);
                }, { once: true }) : (V(), t(U));
              });
            })).then(e).finally(() => {
              o.restarting = null;
            });
          }, 50);
        })), o.restarting;
      });
    }, initialized: () => o.initialized, version: "1.3.1" };
    return document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", V, { once: true }) : requestAnimationFrame(V), U;
  })();
  typeof window != "undefined" && !window.USAL && (window.USAL = Fe);
  var tt = Fe;
  return et(nt);
})();
;
!(function() {
  var L = __temp.default || __temp;
  "undefined" != typeof window && (window.USAL = L), "undefined" != typeof global && (global.USAL = L);
})();
