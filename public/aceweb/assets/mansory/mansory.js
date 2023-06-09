!(function (t, i) {
  "object" == typeof exports && "undefined" != typeof module
    ? (module.exports = i())
    : "function" == typeof define && define.amd
    ? define(i)
    : (t.MagicGrid = i());
})(this, function () {
  "use strict";
  var t = function (t) {
      if (!t) throw new Error("No config object has been provided.");
      t.container || i("container"),
        t.items || t.static || i("items or static");
    },
    i = function (t) {
      throw new Error("Missing property '" + t + "' in MagicGrid config");
    },
    e = function (t) {
      var i = t[0];
      for (var e of t) e.height < i.height && (i = e);
      return i;
    },
    n = function (i) {
      t(i),
        i.container instanceof HTMLElement
          ? ((this.container = i.container),
            (this.containerClass = i.container.className))
          : ((this.containerClass = i.container),
            (this.container = document.querySelector(i.container))),
        (this.items = this.container.children),
        (this.static = i.static || !1),
        (this.size = i.items),
        (this.gutter = i.gutter || 25),
        (this.maxColumns = i.maxColumns || !1),
        (this.useMin = i.useMin || !1),
        (this.animate = i.animate || !1),
        (this.started = !1),
        this.init();
    };
  return (
    (n.prototype.init = function () {
      if (this.ready() && !this.started) {
        this.container.style.position = "relative";
        for (var t = 0; t < this.items.length; t++)
          (this.items[t].style.position = "absolute"),
            this.animate &&
              (this.items[t].style.transition = "top,left 0.2s ease");
        this.started = !0;
      }
    }),
    (n.prototype.colWidth = function () {
      return this.items[0].getBoundingClientRect().width + this.gutter;
    }),
    (n.prototype.setup = function () {
      var t = this.container.getBoundingClientRect().width,
        i = this.colWidth(),
        e = Math.floor(t / i) || 1,
        n = [];
      this.maxColumns && e > this.maxColumns && (e = this.maxColumns);
      for (var s = 0; s < e; s++) n[s] = { height: 0, index: s };
      return { cols: n, wSpace: t - e * i + this.gutter };
    }),
    (n.prototype.nextCol = function (t, i) {
      return this.useMin ? e(t) : t[i % t.length];
    }),
    (n.prototype.positionItems = function () {
      var t = this.setup(),
        i = t.cols,
        e = t.wSpace,
        n = 0,
        s = this.colWidth();
      e = Math.floor(e / 2);
      for (var o = 0; o < this.items.length; o++) {
        var r = this.nextCol(i, o),
          h = r.index * s + e,
          a = this.items[o],
          c = r.height ? this.gutter : 0;
        (a.style.left = h + "px"),
          (a.style.top = r.height + c + "px"),
          (r.height += a.getBoundingClientRect().height + c),
          r.height > n && (n = r.height);
      }
      this.container.style.height = n + "px";
    }),
    (n.prototype.ready = function () {
      return !!this.static || this.items.length >= this.size;
    }),
    (n.prototype.getReady = function () {
      var t = this,
        i = setInterval(function () {
          (t.container = document.querySelector(t.containerClass)),
            (t.items = t.container.children),
            t.ready() && (clearInterval(i), t.init(), t.listen());
        }, 100);
    }),
    (n.prototype.listen = function () {
      var t = this;
      if (this.ready()) {
        var i;
        window.addEventListener("resize", function () {
          i ||
            (i = setTimeout(function () {
              t.positionItems(), (i = null);
            }, 200));
        }),
          this.positionItems();
      } else this.getReady();
    }),
    n
  );
});
