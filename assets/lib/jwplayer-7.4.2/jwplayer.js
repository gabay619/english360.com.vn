! function(e, t) {
    "object" == typeof exports && "object" == typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define([], t) : "object" == typeof exports ? exports.jwplayer = t() : e.jwplayer = t()
}(this, function() {
    return function(e) {
        function t(n) {
            if (i[n]) return i[n].exports;
            var r = i[n] = {
                exports: {},
                id: n,
                loaded: !1
            };
            return e[n].call(r.exports, r, r.exports, t), r.loaded = !0, r.exports
        }
        var n = window.webpackJsonpjwplayer;
        window.webpackJsonpjwplayer = function(i, o) {
            for (var a, s, l = 0, c = []; l < i.length; l++) s = i[l], r[s] && c.push.apply(c, r[s]), r[s] = 0;
            for (a in o) e[a] = o[a];
            for (n && n(i, o); c.length;) c.shift().call(null, t)
        };
        var i = {},
                r = {
                    2: 0
                };
        return t.e = function(e, n) {
            if (0 === r[e]) return n.call(null, t);
            if (void 0 !== r[e]) r[e].push(n);
            else {
                r[e] = [n];
                var i = document.getElementsByTagName("head")[0],
                        o = document.createElement("script");
                o.type = "text/javascript", o.charset = "utf-8", o.async = !0, o.src = t.p + "" + ({
                            0: "provider.youtube",
                            1: "provider.caterpillar",
                            3: "provider.shaka",
                            4: "provider.cast",
                            5: "polyfills.promise",
                            6: "polyfills.base64"
                        }[e] || e) + ".js", i.appendChild(o)
            }
        }, t.m = e, t.c = i, t.p = "", t(0)
    }([function(e, t, n) {
        e.exports = n(319)
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            var e = {},
                    t = Array.prototype,
                    n = Object.prototype,
                    i = Function.prototype,
                    r = t.slice,
                    o = t.concat,
                    a = n.toString,
                    s = n.hasOwnProperty,
                    l = t.map,
                    c = t.reduce,
                    u = t.forEach,
                    d = t.filter,
                    p = t.every,
                    f = t.some,
                    h = t.indexOf,
                    g = Array.isArray,
                    m = Object.keys,
                    v = i.bind,
                    w = function(e) {
                        return e instanceof w ? e : this instanceof w ? void 0 : new w(e)
                    },
                    y = w.each = w.forEach = function(t, n, i) {
                        if (null == t) return t;
                        if (u && t.forEach === u) t.forEach(n, i);
                        else if (t.length === +t.length) {
                            for (var r = 0, o = t.length; o > r; r++)
                                if (n.call(i, t[r], r, t) === e) return
                        } else
                            for (var a = w.keys(t), r = 0, o = a.length; o > r; r++)
                                if (n.call(i, t[a[r]], a[r], t) === e) return; return t
                    };
            w.map = w.collect = function(e, t, n) {
                var i = [];
                return null == e ? i : l && e.map === l ? e.map(t, n) : (y(e, function(e, r, o) {
                    i.push(t.call(n, e, r, o))
                }), i)
            };
            var j = "Reduce of empty array with no initial value";
            w.reduce = w.foldl = w.inject = function(e, t, n, i) {
                var r = arguments.length > 2;
                if (null == e && (e = []), c && e.reduce === c) return i && (t = w.bind(t, i)), r ? e.reduce(t, n) : e.reduce(t);
                if (y(e, function(e, o, a) {
                            r ? n = t.call(i, n, e, o, a) : (n = e, r = !0)
                        }), !r) throw new TypeError(j);
                return n
            }, w.find = w.detect = function(e, t, n) {
                var i;
                return b(e, function(e, r, o) {
                    return t.call(n, e, r, o) ? (i = e, !0) : void 0
                }), i
            }, w.filter = w.select = function(e, t, n) {
                var i = [];
                return null == e ? i : d && e.filter === d ? e.filter(t, n) : (y(e, function(e, r, o) {
                    t.call(n, e, r, o) && i.push(e)
                }), i)
            }, w.reject = function(e, t, n) {
                return w.filter(e, function(e, i, r) {
                    return !t.call(n, e, i, r)
                }, n)
            }, w.compact = function(e) {
                return w.filter(e, w.identity)
            }, w.every = w.all = function(t, n, i) {
                n || (n = w.identity);
                var r = !0;
                return null == t ? r : p && t.every === p ? t.every(n, i) : (y(t, function(t, o, a) {
                    return (r = r && n.call(i, t, o, a)) ? void 0 : e
                }), !!r)
            };
            var b = w.some = w.any = function(t, n, i) {
                n || (n = w.identity);
                var r = !1;
                return null == t ? r : f && t.some === f ? t.some(n, i) : (y(t, function(t, o, a) {
                    return r || (r = n.call(i, t, o, a)) ? e : void 0
                }), !!r)
            };
            w.size = function(e) {
                return null == e ? 0 : e.length === +e.length ? e.length : w.keys(e).length
            }, w.last = function(e, t, n) {
                return null != e ? null == t || n ? e[e.length - 1] : r.call(e, Math.max(e.length - t, 0)) : void 0
            }, w.after = function(e, t) {
                return function() {
                    return --e < 1 ? t.apply(this, arguments) : void 0
                }
            }, w.before = function(e, t) {
                var n;
                return function() {
                    return --e > 0 && (n = t.apply(this, arguments)), 1 >= e && (t = null), n
                }
            };
            var E = function(e) {
                        return null == e ? w.identity : w.isFunction(e) ? e : w.property(e)
                    },
                    k = function(e) {
                        return function(t, n, i) {
                            var r = {};
                            return n = E(n), y(t, function(o, a) {
                                var s = n.call(i, o, a, t);
                                e(r, s, o)
                            }), r
                        }
                    };
            w.groupBy = k(function(e, t, n) {
                w.has(e, t) ? e[t].push(n) : e[t] = [n]
            }), w.indexBy = k(function(e, t, n) {
                e[t] = n
            }), w.sortedIndex = function(e, t, n, i) {
                n = E(n);
                for (var r = n.call(i, t), o = 0, a = e.length; a > o;) {
                    var s = o + a >>> 1;
                    n.call(i, e[s]) < r ? o = s + 1 : a = s
                }
                return o
            };
            var b = w.some = w.any = function(t, n, i) {
                n || (n = w.identity);
                var r = !1;
                return null == t ? r : f && t.some === f ? t.some(n, i) : (y(t, function(t, o, a) {
                    return r || (r = n.call(i, t, o, a)) ? e : void 0
                }), !!r)
            };
            w.contains = w.include = function(e, t) {
                return null == e ? !1 : (e.length !== +e.length && (e = w.values(e)), w.indexOf(e, t) >= 0)
            }, w.pluck = function(e, t) {
                return w.map(e, w.property(t))
            }, w.where = function(e, t) {
                return w.filter(e, w.matches(t))
            }, w.findWhere = function(e, t) {
                return w.find(e, w.matches(t))
            }, w.max = function(e, t, n) {
                if (!t && w.isArray(e) && e[0] === +e[0] && e.length < 65535) return Math.max.apply(Math, e);
                var i = -(1 / 0),
                        r = -(1 / 0);
                return y(e, function(e, o, a) {
                    var s = t ? t.call(n, e, o, a) : e;
                    s > r && (i = e, r = s)
                }), i
            }, w.difference = function(e) {
                var n = o.apply(t, r.call(arguments, 1));
                return w.filter(e, function(e) {
                    return !w.contains(n, e)
                })
            }, w.without = function(e) {
                return w.difference(e, r.call(arguments, 1))
            }, w.indexOf = function(e, t, n) {
                if (null == e) return -1;
                var i = 0,
                        r = e.length;
                if (n) {
                    if ("number" != typeof n) return i = w.sortedIndex(e, t), e[i] === t ? i : -1;
                    i = 0 > n ? Math.max(0, r + n) : n
                }
                if (h && e.indexOf === h) return e.indexOf(t, n);
                for (; r > i; i++)
                    if (e[i] === t) return i;
                return -1
            };
            var A = function() {};
            w.bind = function(e, t) {
                var n, i;
                if (v && e.bind === v) return v.apply(e, r.call(arguments, 1));
                if (!w.isFunction(e)) throw new TypeError;
                return n = r.call(arguments, 2), i = function() {
                    if (!(this instanceof i)) return e.apply(t, n.concat(r.call(arguments)));
                    A.prototype = e.prototype;
                    var o = new A;
                    A.prototype = null;
                    var a = e.apply(o, n.concat(r.call(arguments)));
                    return Object(a) === a ? a : o
                }
            }, w.partial = function(e) {
                var t = r.call(arguments, 1);
                return function() {
                    for (var n = 0, i = t.slice(), r = 0, o = i.length; o > r; r++) i[r] === w && (i[r] = arguments[n++]);
                    for (; n < arguments.length;) i.push(arguments[n++]);
                    return e.apply(this, i)
                }
            }, w.once = w.partial(w.before, 2), w.memoize = function(e, t) {
                var n = {};
                return t || (t = w.identity),
                        function() {
                            var i = t.apply(this, arguments);
                            return w.has(n, i) ? n[i] : n[i] = e.apply(this, arguments)
                        }
            }, w.delay = function(e, t) {
                var n = r.call(arguments, 2);
                return setTimeout(function() {
                    return e.apply(null, n)
                }, t)
            }, w.defer = function(e) {
                return w.delay.apply(w, [e, 1].concat(r.call(arguments, 1)))
            }, w.throttle = function(e, t, n) {
                var i, r, o, a = null,
                        s = 0;
                n || (n = {});
                var l = function() {
                    s = n.leading === !1 ? 0 : w.now(), a = null, o = e.apply(i, r), i = r = null
                };
                return function() {
                    var c = w.now();
                    s || n.leading !== !1 || (s = c);
                    var u = t - (c - s);
                    return i = this, r = arguments, 0 >= u ? (clearTimeout(a), a = null, s = c, o = e.apply(i, r), i = r = null) : a || n.trailing === !1 || (a = setTimeout(l, u)), o
                }
            }, w.keys = function(e) {
                if (!w.isObject(e)) return [];
                if (m) return m(e);
                var t = [];
                for (var n in e) w.has(e, n) && t.push(n);
                return t
            }, w.invert = function(e) {
                for (var t = {}, n = w.keys(e), i = 0, r = n.length; r > i; i++) t[e[n[i]]] = n[i];
                return t
            }, w.defaults = function(e) {
                return y(r.call(arguments, 1), function(t) {
                    if (t)
                        for (var n in t) void 0 === e[n] && (e[n] = t[n])
                }), e
            }, w.extend = function(e) {
                return y(r.call(arguments, 1), function(t) {
                    if (t)
                        for (var n in t) e[n] = t[n]
                }), e
            }, w.pick = function(e) {
                var n = {},
                        i = o.apply(t, r.call(arguments, 1));
                return y(i, function(t) {
                    t in e && (n[t] = e[t])
                }), n
            }, w.omit = function(e) {
                var n = {},
                        i = o.apply(t, r.call(arguments, 1));
                for (var a in e) w.contains(i, a) || (n[a] = e[a]);
                return n
            }, w.clone = function(e) {
                return w.isObject(e) ? w.isArray(e) ? e.slice() : w.extend({}, e) : e
            }, w.isArray = g || function(e) {
                        return "[object Array]" == a.call(e)
                    }, w.isObject = function(e) {
                return e === Object(e)
            }, y(["Arguments", "Function", "String", "Number", "Date", "RegExp"], function(e) {
                w["is" + e] = function(t) {
                    return a.call(t) == "[object " + e + "]"
                }
            }), w.isArguments(arguments) || (w.isArguments = function(e) {
                return !(!e || !w.has(e, "callee"))
            }), w.isFunction = function(e) {
                return "function" == typeof e
            }, w.isFinite = function(e) {
                return isFinite(e) && !isNaN(parseFloat(e))
            }, w.isNaN = function(e) {
                return w.isNumber(e) && e != +e
            }, w.isBoolean = function(e) {
                return e === !0 || e === !1 || "[object Boolean]" == a.call(e)
            }, w.isNull = function(e) {
                return null === e
            }, w.isUndefined = function(e) {
                return void 0 === e
            }, w.has = function(e, t) {
                return s.call(e, t)
            }, w.identity = function(e) {
                return e
            }, w.constant = function(e) {
                return function() {
                    return e
                }
            }, w.property = function(e) {
                return function(t) {
                    return t[e]
                }
            }, w.propertyOf = function(e) {
                return null == e ? function() {} : function(t) {
                    return e[t]
                }
            }, w.matches = function(e) {
                return function(t) {
                    if (t === e) return !0;
                    for (var n in e)
                        if (e[n] !== t[n]) return !1;
                    return !0
                }
            }, w.now = Date.now || function() {
                        return (new Date).getTime()
                    }, w.result = function(e, t) {
                if (null != e) {
                    var n = e[t];
                    return w.isFunction(n) ? n.call(e) : n
                }
            };
            var L = 0;
            return w.uniqueId = function(e) {
                var t = ++L + "";
                return e ? e + t : t
            }, w
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14), n(1), n(129), n(130), n(45), n(86), n(58), n(284), n(87), n(132), n(134)], r = function(e, t, n, i, r, o, a, s, l, c, u) {
            var d = {};
            return d.log = function() {
                window.console && ("object" == typeof console.log ? console.log(Array.prototype.slice.call(arguments, 0)) : console.log.apply(console, arguments))
            }, d.between = function(e, t, n) {
                return Math.max(Math.min(e, n), t)
            }, d.foreach = function(e, t) {
                var n, i;
                for (n in e) "function" === d.typeOf(e.hasOwnProperty) ? e.hasOwnProperty(n) && (i = e[n], t(n, i)) : (i = e[n], t(n, i))
            }, d.indexOf = t.indexOf, d.noop = function() {}, d.seconds = e.seconds, d.prefix = e.prefix, d.suffix = e.suffix, t.extend(d, o, a, l, n, s, i, r, c, u), d
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = [],
                    n = t.slice,
                    i = {
                        on: function(e, t, n) {
                            if (!o(this, "on", e, [t, n]) || !t) return this;
                            this._events || (this._events = {});
                            var i = this._events[e] || (this._events[e] = []);
                            return i.push({
                                callback: t,
                                context: n
                            }), this
                        },
                        once: function(t, n, i) {
                            if (!o(this, "once", t, [n, i]) || !n) return this;
                            var r = this,
                                    a = e.once(function() {
                                        r.off(t, a), n.apply(this, arguments)
                                    });
                            return a._callback = n, this.on(t, a, i)
                        },
                        off: function(t, n, i) {
                            var r, a, s, l, c, u, d, p;
                            if (!this._events || !o(this, "off", t, [n, i])) return this;
                            if (!t && !n && !i) return this._events = void 0, this;
                            for (l = t ? [t] : e.keys(this._events), c = 0, u = l.length; u > c; c++)
                                if (t = l[c], s = this._events[t]) {
                                    if (this._events[t] = r = [], n || i)
                                        for (d = 0, p = s.length; p > d; d++) a = s[d], (n && n !== a.callback && n !== a.callback._callback || i && i !== a.context) && r.push(a);
                                    r.length || delete this._events[t]
                                }
                            return this
                        },
                        trigger: function(e) {
                            if (!this._events) return this;
                            var t = n.call(arguments, 1);
                            if (!o(this, "trigger", e, t)) return this;
                            var i = this._events[e],
                                    r = this._events.all;
                            return i && a(i, t, this), r && a(r, arguments, this), this
                        },
                        triggerSafe: function(e) {
                            if (!this._events) return this;
                            var t = n.call(arguments, 1);
                            if (!o(this, "trigger", e, t)) return this;
                            var i = this._events[e],
                                    r = this._events.all;
                            return i && s(i, t, this), r && s(r, arguments, this), this
                        }
                    },
                    r = /\s+/,
                    o = function(e, t, n, i) {
                        if (!n) return !0;
                        if ("object" == typeof n) {
                            for (var o in n) e[t].apply(e, [o, n[o]].concat(i));
                            return !1
                        }
                        if (r.test(n)) {
                            for (var a = n.split(r), s = 0, l = a.length; l > s; s++) e[t].apply(e, [a[s]].concat(i));
                            return !1
                        }
                        return !0
                    },
                    a = function(e, t, n) {
                        var i, r = -1,
                                o = e.length,
                                a = t[0],
                                s = t[1],
                                l = t[2];
                        switch (t.length) {
                            case 0:
                                for (; ++r < o;)(i = e[r]).callback.call(i.context || n);
                                return;
                            case 1:
                                for (; ++r < o;)(i = e[r]).callback.call(i.context || n, a);
                                return;
                            case 2:
                                for (; ++r < o;)(i = e[r]).callback.call(i.context || n, a, s);
                                return;
                            case 3:
                                for (; ++r < o;)(i = e[r]).callback.call(i.context || n, a, s, l);
                                return;
                            default:
                                for (; ++r < o;)(i = e[r]).callback.apply(i.context || n, t);
                                return
                        }
                    },
                    s = function(e, t, n) {
                        for (var i, r = -1, o = e.length; ++r < o;) try {
                            (i = e[r]).callback.apply(i.context || n, t)
                        } catch (a) {}
                    };
            return i
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            var e = {
                        DRAG: "drag",
                        DRAG_START: "dragStart",
                        DRAG_END: "dragEnd",
                        CLICK: "click",
                        DOUBLE_CLICK: "doubleClick",
                        TAP: "tap",
                        DOUBLE_TAP: "doubleTap",
                        OVER: "over",
                        MOVE: "move",
                        OUT: "out"
                    },
                    t = {
                        COMPLETE: "complete",
                        ERROR: "error",
                        JWPLAYER_AD_CLICK: "adClick",
                        JWPLAYER_AD_COMPANIONS: "adCompanions",
                        JWPLAYER_AD_COMPLETE: "adComplete",
                        JWPLAYER_AD_ERROR: "adError",
                        JWPLAYER_AD_IMPRESSION: "adImpression",
                        JWPLAYER_AD_META: "adMeta",
                        JWPLAYER_AD_PAUSE: "adPause",
                        JWPLAYER_AD_PLAY: "adPlay",
                        JWPLAYER_AD_SKIPPED: "adSkipped",
                        JWPLAYER_AD_TIME: "adTime",
                        JWPLAYER_CAST_AD_CHANGED: "castAdChanged",
                        JWPLAYER_MEDIA_COMPLETE: "complete",
                        JWPLAYER_READY: "ready",
                        JWPLAYER_MEDIA_SEEK: "seek",
                        JWPLAYER_MEDIA_BEFOREPLAY: "beforePlay",
                        JWPLAYER_MEDIA_BEFORECOMPLETE: "beforeComplete",
                        JWPLAYER_MEDIA_BUFFER_FULL: "bufferFull",
                        JWPLAYER_DISPLAY_CLICK: "displayClick",
                        JWPLAYER_PLAYLIST_COMPLETE: "playlistComplete",
                        JWPLAYER_CAST_SESSION: "cast",
                        JWPLAYER_MEDIA_ERROR: "mediaError",
                        JWPLAYER_MEDIA_FIRST_FRAME: "firstFrame",
                        JWPLAYER_MEDIA_PLAY_ATTEMPT: "playAttempt",
                        JWPLAYER_MEDIA_LOADED: "loaded",
                        JWPLAYER_MEDIA_SEEKED: "seeked",
                        JWPLAYER_SETUP_ERROR: "setupError",
                        JWPLAYER_ERROR: "error",
                        JWPLAYER_PLAYER_STATE: "state",
                        JWPLAYER_CAST_AVAILABLE: "castAvailable",
                        JWPLAYER_MEDIA_BUFFER: "bufferChange",
                        JWPLAYER_MEDIA_TIME: "time",
                        JWPLAYER_MEDIA_TYPE: "mediaType",
                        JWPLAYER_MEDIA_VOLUME: "volume",
                        JWPLAYER_MEDIA_MUTE: "mute",
                        JWPLAYER_MEDIA_META: "meta",
                        JWPLAYER_MEDIA_LEVELS: "levels",
                        JWPLAYER_MEDIA_LEVEL_CHANGED: "levelsChanged",
                        JWPLAYER_CONTROLS: "controls",
                        JWPLAYER_FULLSCREEN: "fullscreen",
                        JWPLAYER_RESIZE: "resize",
                        JWPLAYER_PLAYLIST_ITEM: "playlistItem",
                        JWPLAYER_PLAYLIST_LOADED: "playlist",
                        JWPLAYER_AUDIO_TRACKS: "audioTracks",
                        JWPLAYER_AUDIO_TRACK_CHANGED: "audioTrackChanged",
                        JWPLAYER_LOGO_CLICK: "logoClick",
                        JWPLAYER_CAPTIONS_LIST: "captionsList",
                        JWPLAYER_CAPTIONS_CHANGED: "captionsChanged",
                        JWPLAYER_PROVIDER_CHANGED: "providerChanged",
                        JWPLAYER_PROVIDER_FIRST_FRAME: "providerFirstFrame",
                        JWPLAYER_USER_ACTION: "userAction",
                        JWPLAYER_PROVIDER_CLICK: "providerClick",
                        JWPLAYER_VIEW_TAB_FOCUS: "tabFocus",
                        JWPLAYER_CONTROLBAR_DRAGGING: "scrubbing",
                        JWPLAYER_INSTREAM_CLICK: "instreamClick"
                    };
            return t.touchEvents = e, t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , function(e, t, n) {
        var i, r;
        i = [], r = function() {
            return {
                BUFFERING: "buffering",
                IDLE: "idle",
                COMPLETE: "complete",
                PAUSED: "paused",
                PLAYING: "playing",
                ERROR: "error",
                LOADING: "loading",
                STALLED: "stalled"
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , function(e, t, n) {
        var i, r;
        i = [n(3), n(4), n(1), n(2)], r = function(e, t, n, i) {
            function r(e, t) {
                return /touch/.test(e.type) ? (e.originalEvent || e).changedTouches[0]["page" + t] : e["page" + t]
            }

            function o(e) {
                var t = e || window.event;
                return e instanceof MouseEvent ? "which" in t ? 3 === t.which : "button" in t ? 2 === t.button : !1 : !1
            }

            function a(e, t, n) {
                var i;
                return i = t instanceof MouseEvent || !t.touches && !t.changedTouches ? t : t.touches && t.touches.length ? t.touches[0] : t.changedTouches[0], {
                    type: e,
                    target: t.target,
                    currentTarget: n,
                    pageX: i.pageX,
                    pageY: i.pageY
                }
            }

            function s(e) {
                (e instanceof MouseEvent || e instanceof window.TouchEvent) && (e.preventManipulation && e.preventManipulation(), e.cancelable && e.preventDefault && e.preventDefault())
            }
            var l = !n.isUndefined(window.PointerEvent),
                    c = !l && i.isMobile(),
                    u = !l && !c,
                    d = i.isFF() && i.isOSX(),
                    p = function(e, i) {
                        function c(e) {
                            (u || l && "touch" !== e.pointerType) && v(t.touchEvents.OVER, e)
                        }

                        function p(e) {
                            (u || l && "touch" !== e.pointerType) && v(t.touchEvents.MOVE, e)
                        }

                        function f(n) {
                            (u || l && "touch" !== n.pointerType && !e.contains(document.elementFromPoint(n.x, n.y))) && v(t.touchEvents.OUT, n)
                        }

                        function h(t) {
                            w = t.target, E = r(t, "X"), k = r(t, "Y"), o(t) || (l ? t.isPrimary && (i.preventScrolling && (y = t.pointerId, e.setPointerCapture(y)), e.addEventListener("pointermove", g), e.addEventListener("pointercancel", m), e.addEventListener("pointerup", m)) : u && (document.addEventListener("mousemove", g), d && "object" === t.target.nodeName.toLowerCase() ? e.addEventListener("click", m) : document.addEventListener("mouseup", m)), w.addEventListener("touchmove", g), w.addEventListener("touchcancel", m), w.addEventListener("touchend", m))
                        }

                        function g(e) {
                            var n = t.touchEvents,
                                    o = 6;
                            if (b) v(n.DRAG, e);
                            else {
                                var a = r(e, "X"),
                                        l = r(e, "Y"),
                                        c = a - E,
                                        u = l - k;
                                c * c + u * u > o * o && (v(n.DRAG_START, e), b = !0, v(n.DRAG, e))
                            }
                            i.preventScrolling && s(e)
                        }

                        function m(n) {
                            var r = t.touchEvents;
                            l ? (i.preventScrolling && e.releasePointerCapture(y), e.removeEventListener("pointermove", g), e.removeEventListener("pointercancel", m), e.removeEventListener("pointerup", m)) : u && (document.removeEventListener("mousemove", g), document.removeEventListener("mouseup", m)), w.removeEventListener("touchmove", g), w.removeEventListener("touchcancel", m), w.removeEventListener("touchend", m), b ? v(r.DRAG_END, n) : i.directSelect && n.target !== e || -1 !== n.type.indexOf("cancel") || (l && n instanceof window.PointerEvent ? "touch" === n.pointerType ? v(r.TAP, n) : v(r.CLICK, n) : u ? v(r.CLICK, n) : (v(r.TAP, n), s(n))), w = null, b = !1
                        }

                        function v(e, r) {
                            var o;
                            if (i.enableDoubleTap && (e === t.touchEvents.CLICK || e === t.touchEvents.TAP))
                                if (n.now() - A < L) {
                                    var s = e === t.touchEvents.CLICK ? t.touchEvents.DOUBLE_CLICK : t.touchEvents.DOUBLE_TAP;
                                    o = a(s, r, j), _.trigger(s, o), A = 0
                                } else A = n.now();
                            o = a(e, r, j), _.trigger(e, o)
                        }
                        var w, y, j = e,
                                b = !1,
                                E = 0,
                                k = 0,
                                A = 0,
                                L = 300;
                        i = i || {}, l ? (e.addEventListener("pointerdown", h), i.useHover && (e.addEventListener("pointerover", c), e.addEventListener("pointerout", f)), i.useMove && e.addEventListener("pointermove", p)) : u && (e.addEventListener("mousedown", h), i.useHover && (e.addEventListener("mouseover", c), e.addEventListener("mouseout", f)), i.useMove && e.addEventListener("mousemove", p)), e.addEventListener("touchstart", h);
                        var _ = this;
                        return this.triggerEvent = v, this.destroy = function() {
                            e.removeEventListener("touchstart", h), e.removeEventListener("mousedown", h), w && (w.removeEventListener("touchmove", g), w.removeEventListener("touchcancel", m), w.removeEventListener("touchend", m)), l && (i.preventScrolling && e.releasePointerCapture(y), e.removeEventListener("pointerover", c), e.removeEventListener("pointerdown", h), e.removeEventListener("pointermove", g), e.removeEventListener("pointermove", p), e.removeEventListener("pointercancel", m), e.removeEventListener("pointerout", f), e.removeEventListener("pointerup", m)), e.removeEventListener("click", m), e.removeEventListener("mouseover", c), e.removeEventListener("mousemove", p), e.removeEventListener("mouseout", f), document.removeEventListener("mousemove", g), document.removeEventListener("mouseup", m)
                        }, this
                    };
            return n.extend(p.prototype, e), p
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            function t(e) {
                return /[\(,]format=m3u8-/i.test(e) ? "m3u8" : !1
            }
            var n = function(e) {
                        return e.replace(/^\s+|\s+$/g, "")
                    },
                    i = function(e, t, n) {
                        for (e = "" + e, n = n || "0"; e.length < t;) e = n + e;
                        return e
                    },
                    r = function(e, t) {
                        for (var n = 0; n < e.attributes.length; n++)
                            if (e.attributes[n].name && e.attributes[n].name.toLowerCase() === t.toLowerCase()) return e.attributes[n].value.toString();
                        return ""
                    },
                    o = function(e) {
                        if (!e || "rtmp" === e.substr(0, 4)) return "";
                        var n = t(e);
                        return n ? n : (e = e.split("?")[0].split("#")[0], e.lastIndexOf(".") > -1 ? e.substr(e.lastIndexOf(".") + 1, e.length).toLowerCase() : void 0)
                    },
                    a = function(e) {
                        var t = parseInt(e / 3600),
                                n = parseInt(e / 60) % 60,
                                r = e % 60;
                        return i(t, 2) + ":" + i(n, 2) + ":" + i(r.toFixed(3), 6)
                    },
                    s = function(t) {
                        if (e.isNumber(t)) return t;
                        t = t.replace(",", ".");
                        var n = t.split(":"),
                                i = 0;
                        return "s" === t.slice(-1) ? i = parseFloat(t) : "m" === t.slice(-1) ? i = 60 * parseFloat(t) : "h" === t.slice(-1) ? i = 3600 * parseFloat(t) : n.length > 1 ? (i = parseFloat(n[n.length - 1]), i += 60 * parseFloat(n[n.length - 2]), 3 === n.length && (i += 3600 * parseFloat(n[n.length - 3]))) : i = parseFloat(t), i
                    },
                    l = function(t, n) {
                        return e.map(t, function(e) {
                            return n + e
                        })
                    },
                    c = function(t, n) {
                        return e.map(t, function(e) {
                            return e + n
                        })
                    };
            return {
                trim: n,
                pad: i,
                xmlAttribute: r,
                extension: o,
                hms: a,
                seconds: s,
                suffix: c,
                prefix: l
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , function(e, t, n) {
        e.exports = n(247)["default"]
    }, , , , function(e, t) {
        "use strict";

        function n(e) {
            return u[e]
        }

        function i(e) {
            for (var t = 1; t < arguments.length; t++)
                for (var n in arguments[t]) Object.prototype.hasOwnProperty.call(arguments[t], n) && (e[n] = arguments[t][n]);
            return e
        }

        function r(e, t) {
            for (var n = 0, i = e.length; i > n; n++)
                if (e[n] === t) return n;
            return -1
        }

        function o(e) {
            if ("string" != typeof e) {
                if (e && e.toHTML) return e.toHTML();
                if (null == e) return "";
                if (!e) return e + "";
                e = "" + e
            }
            return p.test(e) ? e.replace(d, n) : e
        }

        function a(e) {
            return e || 0 === e ? !(!g(e) || 0 !== e.length) : !0
        }

        function s(e) {
            var t = i({}, e);
            return t._parent = e, t
        }

        function l(e, t) {
            return e.path = t, e
        }

        function c(e, t) {
            return (e ? e + "." : "") + t
        }
        t.__esModule = !0, t.extend = i, t.indexOf = r, t.escapeExpression = o, t.isEmpty = a, t.createFrame = s, t.blockParams = l, t.appendContextPath = c;
        var u = {
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#x27;",
                    "`": "&#x60;",
                    "=": "&#x3D;"
                },
                d = /[&<>"'`=]/g,
                p = /[&<>"'`=]/,
                f = Object.prototype.toString;
        t.toString = f;
        var h = function(e) {
            return "function" == typeof e
        };
        h(/x/) && (t.isFunction = h = function(e) {
            return "function" == typeof e && "[object Function]" === f.call(e)
        }), t.isFunction = h;
        var g = Array.isArray || function(e) {
                    return e && "object" == typeof e ? "[object Array]" === f.call(e) : !1
                };
        t.isArray = g
    }, , , , , , , , , , , function(e, t, n) {
        var i, r;
        i = [n(2), n(4), n(6), n(1)], r = function(e, t, n, i) {
            var r = e.noop,
                    o = i.constant(!1),
                    a = {
                        supports: o,
                        play: r,
                        load: r,
                        stop: r,
                        volume: r,
                        mute: r,
                        seek: r,
                        resize: r,
                        remove: r,
                        destroy: r,
                        setVisibility: r,
                        setFullscreen: o,
                        getFullscreen: r,
                        getContainer: r,
                        setContainer: o,
                        getName: r,
                        getQualityLevels: r,
                        getCurrentQuality: r,
                        setCurrentQuality: r,
                        getAudioTracks: r,
                        getCurrentAudioTrack: r,
                        setCurrentAudioTrack: r,
                        checkComplete: r,
                        setControls: r,
                        attachMedia: r,
                        detachMedia: r,
                        setState: function(e) {
                            var i = this.state || n.IDLE;
                            this.state = e, e !== i && this.trigger(t.JWPLAYER_PLAYER_STATE, {
                                newstate: e
                            })
                        },
                        sendMediaType: function(e) {
                            var n = e[0].type,
                                    i = "oga" === n || "aac" === n || "mp3" === n || "mpeg" === n || "vorbis" === n;
                            this.trigger(t.JWPLAYER_MEDIA_TYPE, {
                                mediaType: i ? "audio" : "video"
                            })
                        }
                    };
            return a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(4), n(3), n(1)], r = function(e, t, n) {
            var i = {},
                    r = {
                        NEW: 0,
                        LOADING: 1,
                        ERROR: 2,
                        COMPLETE: 3
                    },
                    o = function(o, a) {
                        function s(t) {
                            u = r.ERROR, c.trigger(e.ERROR, t)
                        }

                        function l(t) {
                            u = r.COMPLETE, c.trigger(e.COMPLETE, t)
                        }
                        var c = n.extend(this, t),
                                u = r.NEW;
                        this.addEventListener = this.on, this.removeEventListener = this.off, this.makeStyleLink = function(e) {
                            var t = document.createElement("link");
                            return t.type = "text/css", t.rel = "stylesheet", t.href = e, t
                        }, this.makeScriptTag = function(e) {
                            var t = document.createElement("script");
                            return t.src = e, t
                        }, this.makeTag = a ? this.makeStyleLink : this.makeScriptTag, this.load = function() {
                            if (u === r.NEW) {
                                var t = i[o];
                                if (t && (u = t.getStatus(), 2 > u)) return t.on(e.ERROR, s), void t.on(e.COMPLETE, l);
                                var n = document.getElementsByTagName("head")[0] || document.documentElement,
                                        c = this.makeTag(o),
                                        d = !1;
                                c.onload = c.onreadystatechange = function(e) {
                                    d || this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (d = !0, l(e), c.onload = c.onreadystatechange = null, n && c.parentNode && !a && n.removeChild(c))
                                }, c.onerror = s, n.insertBefore(c, n.firstChild), u = r.LOADING, i[o] = this
                            }
                        }, this.getStatus = function() {
                            return u
                        }
                    };
            return o.loaderstatus = r, o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            return "7.4.2+commercial_v7-4-2.97.commercial.2c216b.jwplayer.391ff1.googima.94075d.vast.b46e78.analytics.3acedf.plugin-gapro.4c6bfd.plugin-related.180896.plugin-sharing.c16f4f"
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , function(e, t) {
        "use strict";

        function n(e, t) {
            var r = t && t.loc,
                    o = void 0,
                    a = void 0;
            r && (o = r.start.line, a = r.start.column, e += " - " + o + ":" + a);
            for (var s = Error.prototype.constructor.call(this, e), l = 0; l < i.length; l++) this[i[l]] = s[i[l]];
            Error.captureStackTrace && Error.captureStackTrace(this, n), r && (this.lineNumber = o, this.column = a)
        }
        t.__esModule = !0;
        var i = ["description", "fileName", "lineNumber", "message", "name", "number", "stack"];
        n.prototype = new Error, t["default"] = n, e.exports = t["default"]
    }, function(e, t, n) {
        var i, r;
        i = [n(14)], r = function(e) {
            return {
                localName: function(e) {
                    return e ? e.localName ? e.localName : e.baseName ? e.baseName : "" : ""
                },
                textContent: function(t) {
                    return t ? t.textContent ? e.trim(t.textContent) : t.text ? e.trim(t.text) : "" : ""
                },
                getChildNode: function(e, t) {
                    return e.childNodes[t]
                },
                numChildren: function(e) {
                    return e.childNodes ? e.childNodes.length : 0
                }
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(280), n(281), n(125), n(56)], r = function(e, t, n, i) {
            var r = {},
                    o = {},
                    a = function(n, i) {
                        return o[n] = new e(new t(r), i), o[n]
                    },
                    s = function(e, t, o, a) {
                        var s = i.getPluginName(e);
                        r[s] || (r[s] = new n(e)), r[s].registerPlugin(e, t, o, a)
                    };
            return {
                loadPlugins: a,
                registerPlugin: s
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(1), n(4), n(6), n(285), n(31), n(3)], r = function(e, t, n, i, r, o, a) {
            function s(e) {
                return e + "_swf_" + u++
            }

            function l(t) {
                var n = document.createElement("a");
                n.href = t.flashplayer;
                var i = n.hostname === window.location.host;
                return e.isChrome() && !i
            }

            function c(c, u) {
                function d(e) {
                    if (I)
                        for (var t = 0; t < e.length; t++) {
                            var n = e[t];
                            if (n.bitrate) {
                                var i = Math.round(n.bitrate / 1e3);
                                n.label = p(i)
                            }
                        }
                }

                function p(e) {
                    var t = I[e];
                    if (!t) {
                        for (var n = 1 / 0, i = I.bitrates.length; i--;) {
                            var r = Math.abs(I.bitrates[i] - e);
                            if (r > n) break;
                            n = r
                        }
                        t = I.labels[I.bitrates[i + 1]], I[e] = t
                    }
                    return t
                }

                function f() {
                    var e = u.hlslabels;
                    if (!e) return null;
                    var t = {},
                            n = [];
                    for (var i in e) {
                        var r = parseFloat(i);
                        if (!isNaN(r)) {
                            var o = Math.round(r);
                            t[o] = e[i], n.push(o)
                        }
                    }
                    return 0 === n.length ? null : (n.sort(function(e, t) {
                        return e - t
                    }), {
                        labels: t,
                        bitrates: n
                    })
                }

                function h() {
                    b = setTimeout(function() {
                        a.trigger.call(P, "flashBlocked")
                    }, 4e3), w.once("embedded", function() {
                        m(), a.trigger.call(P, "flashUnblocked")
                    }, P)
                }

                function g() {
                    m(), h()
                }

                function m() {
                    clearTimeout(b), window.removeEventListener("focus", g)
                }
                var v, w, y, j = null,
                        b = -1,
                        E = !1,
                        k = -1,
                        A = null,
                        L = -1,
                        _ = null,
                        x = !0,
                        C = !1,
                        P = this,
                        T = function() {
                            return w && w.__ready
                        },
                        R = function() {
                            w && w.triggerFlash.apply(w, arguments)
                        },
                        I = f();
                t.extend(this, a, {
                    init: function(e) {
                        e.preload && "none" !== e.preload && !u.autostart && (j = e)
                    },
                    load: function(e) {
                        j = e, E = !1, this.setState(i.LOADING), R("load", e), e.sources.length && "hls" !== e.sources[0].type && this.sendMediaType(e.sources)
                    },
                    play: function() {
                        R("play")
                    },
                    pause: function() {
                        R("pause"), this.setState(i.PAUSED)
                    },
                    stop: function() {
                        R("stop"), k = -1, j = null, this.setState(i.IDLE)
                    },
                    seek: function(e) {
                        R("seek", e)
                    },
                    volume: function(e) {
                        if (t.isNumber(e)) {
                            var n = Math.min(Math.max(0, e), 100);
                            T() && R("volume", n)
                        }
                    },
                    mute: function(e) {
                        T() && R("mute", e)
                    },
                    setState: function() {
                        return o.setState.apply(this, arguments)
                    },
                    checkComplete: function() {
                        return E
                    },
                    attachMedia: function() {
                        x = !0, E && (this.setState(i.COMPLETE), this.trigger(n.JWPLAYER_MEDIA_COMPLETE), E = !1)
                    },
                    detachMedia: function() {
                        return x = !1, null
                    },
                    getSwfObject: function(e) {
                        var t = e.getElementsByTagName("object")[0];
                        return t ? (t.off(null, null, this), t) : r.embed(u.flashplayer, e, s(c), u.wmode)
                    },
                    getContainer: function() {
                        return v
                    },
                    setContainer: function(r) {
                        if (v !== r) {
                            v = r, w = this.getSwfObject(r), document.hasFocus() ? h() : window.addEventListener("focus", g), w.once("ready", function() {
                                m(), w.once("pluginsLoaded", function() {
                                    w.queueCommands = !1, R("setupCommandQueue", w.__commandQueue), w.__commandQueue = []
                                });
                                var e = t.extend({}, u),
                                        i = w.triggerFlash("setup", e);
                                i === w ? w.__ready = !0 : this.trigger(n.JWPLAYER_MEDIA_ERROR, i), j && R("init", j)
                            }, this);
                            var o = [n.JWPLAYER_MEDIA_META, n.JWPLAYER_MEDIA_ERROR, n.JWPLAYER_MEDIA_SEEK, n.JWPLAYER_MEDIA_SEEKED, "subtitlesTracks", "subtitlesTrackChanged", "subtitlesTrackData", "mediaType"],
                                    s = [n.JWPLAYER_MEDIA_BUFFER, n.JWPLAYER_MEDIA_TIME],
                                    c = [n.JWPLAYER_MEDIA_BUFFER_FULL];
                            w.on(n.JWPLAYER_MEDIA_LEVELS, function(e) {
                                d(e.levels), k = e.currentQuality, A = e.levels, this.trigger(e.type, e)
                            }, this), w.on(n.JWPLAYER_MEDIA_LEVEL_CHANGED, function(e) {
                                d(e.levels), k = e.currentQuality, A = e.levels, this.trigger(e.type, e)
                            }, this), w.on(n.JWPLAYER_AUDIO_TRACKS, function(e) {
                                L = e.currentTrack, _ = e.tracks, this.trigger(e.type, e)
                            }, this), w.on(n.JWPLAYER_AUDIO_TRACK_CHANGED, function(e) {
                                L = e.currentTrack, _ = e.tracks, this.trigger(e.type, e)
                            }, this), w.on(n.JWPLAYER_PLAYER_STATE, function(e) {
                                var t = e.newstate;
                                t !== i.IDLE && this.setState(t)
                            }, this), w.on(s.join(" "), function(e) {
                                "Infinity" === e.duration && (e.duration = 1 / 0), this.trigger(e.type, e)
                            }, this), w.on(o.join(" "), function(e) {
                                this.trigger(e.type, e)
                            }, this), w.on(c.join(" "), function(e) {
                                this.trigger(e.type)
                            }, this), w.on(n.JWPLAYER_MEDIA_BEFORECOMPLETE, function(e) {
                                E = !0, this.trigger(e.type), x === !0 && (E = !1)
                            }, this), w.on(n.JWPLAYER_MEDIA_COMPLETE, function(e) {
                                E || (this.setState(i.COMPLETE), this.trigger(e.type))
                            }, this), w.on("visualQuality", function(e) {
                                e.reason = e.reason || "api", this.trigger("visualQuality", e), this.trigger(n.JWPLAYER_PROVIDER_FIRST_FRAME, {})
                            }, this), w.on(n.JWPLAYER_PROVIDER_CHANGED, function(e) {
                                y = e.message, this.trigger(n.JWPLAYER_PROVIDER_CHANGED, e)
                            }, this), w.on(n.JWPLAYER_ERROR, function(t) {
                                e.log("Error playing media: %o %s", t.code, t.message, t), this.trigger(n.JWPLAYER_MEDIA_ERROR, t)
                            }, this), l(u) && w.on("throttle", function(e) {
                                m(), "resume" === e.state ? a.trigger.call(P, "flashThrottle", e) : b = setTimeout(function() {
                                    a.trigger.call(P, "flashThrottle", e)
                                }, 250)
                            }, this)
                        }
                    },
                    remove: function() {
                        k = -1, A = null, r.remove(w)
                    },
                    setVisibility: function(e) {
                        e = !!e, v.style.opacity = e ? 1 : 0
                    },
                    resize: function(e, t, n) {
                        n && R("stretch", n)
                    },
                    setControls: function(e) {
                        R("setControls", e)
                    },
                    setFullscreen: function(e) {
                        C = e, R("fullscreen", e)
                    },
                    getFullScreen: function() {
                        return C
                    },
                    setCurrentQuality: function(e) {
                        R("setCurrentQuality", e)
                    },
                    getCurrentQuality: function() {
                        return k
                    },
                    setSubtitlesTrack: function(e) {
                        R("setSubtitlesTrack", e)
                    },
                    getName: function() {
                        return y ? {
                            name: "flash_" + y
                        } : {
                            name: "flash"
                        }
                    },
                    getQualityLevels: function() {
                        return A || j.sources
                    },
                    getAudioTracks: function() {
                        return _
                    },
                    getCurrentAudioTrack: function() {
                        return L
                    },
                    setCurrentAudioTrack: function(e) {
                        R("setCurrentAudioTrack", e)
                    },
                    destroy: function() {
                        m(), this.remove(), w && (w.off(), w = null), v = null, j = null, this.off()
                    }
                }), this.trigger = function(e, t) {
                    return x ? a.trigger.call(this, e, t) : void 0
                }
            }
            var u = 0,
                    d = function() {};
            return d.prototype = o, c.prototype = new d, c.getName = function() {
                return {
                    name: "flash"
                }
            }, c
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(45), n(2), n(130), n(1), n(4), n(6), n(31), n(3)], r = function(e, t, n, i, r, o, a, s) {
            function l(e, n) {
                t.foreach(e, function(e, t) {
                    n.addEventListener(e, t, !1)
                })
            }

            function c(e, n) {
                t.foreach(e, function(e, t) {
                    n.removeEventListener(e, t, !1)
                })
            }

            function u(e, t, n) {
                "addEventListener" in e ? e.addEventListener(t, n) : e["on" + t] = n
            }

            function d(e, t, n) {
                e && ("removeEventListener" in e ? e.removeEventListener(t, n) : e["on" + t] = null)
            }

            function p(e) {
                if ("hls" === e.type)
                    if (e.androidhls !== !1) {
                        var n = t.isAndroidNative;
                        if (n(2) || n(3) || n("4.0")) return !1;
                        if (t.isAndroid()) return !0
                    } else if (t.isAndroid()) return !1;
                return null
            }

            function f(f, A) {
                function L() {
                    Me && (fe(Ge.audioTracks), ve(Ge.textTracks), Ge.setAttribute("jw-loaded", "data"))
                }

                function _() {
                    Me && Ge.setAttribute("jw-loaded", "started")
                }

                function x(e) {
                    xe.trigger("click", e)
                }

                function C() {
                    Me && !Oe && (O(S()), I(ie(), Ae, ke))
                }

                function P() {
                    Me && I(ie(), Ae, ke)
                }

                function T() {
                    h(Re), Pe = !0, Me && (xe.state === o.STALLED ? xe.setState(o.PLAYING) : xe.state === o.PLAYING && (Re = setTimeout(ne, g)), Oe && Ge.duration === 1 / 0 && 0 === Ge.currentTime || (O(S()), M(Ge.currentTime), I(ie(), Ae, ke), xe.state === o.PLAYING && (xe.trigger(r.JWPLAYER_MEDIA_TIME, {
                        position: Ae,
                        duration: ke
                    }), R())))
                }

                function R() {
                    var e = He.level;
                    if (e.width !== Ge.videoWidth || e.height !== Ge.videoHeight) {
                        if (e.width = Ge.videoWidth, e.height = Ge.videoHeight, je(), !e.width || !e.height) return;
                        He.reason = He.reason || "auto", He.mode = "hls" === _e[Se].type ? "auto" : "manual", He.bitrate = 0, e.index = Se, e.label = _e[Se].label, xe.trigger("visualQuality", He), He.reason = ""
                    }
                }

                function I(e, t, n) {
                    e === Ie && n === ke || (Ie = e, xe.trigger(r.JWPLAYER_MEDIA_BUFFER, {
                        bufferPercent: 100 * e,
                        position: t,
                        duration: n
                    }))
                }

                function M(e) {
                    0 > ke && (e = -(Z() - e)), Ae = e
                }

                function S() {
                    var e = Ge.duration,
                            t = Z();
                    if (e === 1 / 0 && t) {
                        var n = t - Ge.seekable.start(0);
                        n !== 1 / 0 && n > 120 && (e = -n)
                    }
                    return e
                }

                function O(e) {
                    ke = e, Te && e && e !== 1 / 0 && xe.seek(Te)
                }

                function D() {
                    var e = S();
                    Oe && e === 1 / 0 && (e = 0), xe.trigger(r.JWPLAYER_MEDIA_META, {
                        duration: e,
                        height: Ge.videoHeight,
                        width: Ge.videoWidth
                    }), O(e)
                }

                function Y() {
                    Me && (Pe = !0, Oe || je(), W())
                }

                function N() {
                    Me && (Ge.muted && (Ge.muted = !1, Ge.muted = !0), Ge.setAttribute("jw-loaded", "meta"), D())
                }

                function W() {
                    Le || (Le = !0, xe.trigger(r.JWPLAYER_MEDIA_BUFFER_FULL))
                }

                function F() {
                    xe.setState(o.PLAYING), Ge.hasAttribute("jw-played") || Ge.setAttribute("jw-played", ""), xe.trigger(r.JWPLAYER_PROVIDER_FIRST_FRAME, {})
                }

                function J() {
                    xe.state !== o.COMPLETE && Ge.currentTime !== Ge.duration && xe.setState(o.PAUSED)
                }

                function V() {
                    Oe || Ge.paused || Ge.ended || xe.state !== o.LOADING && xe.state !== o.ERROR && (xe.seeking || xe.setState(o.STALLED))
                }

                function B() {
                    Me && (t.log("Error playing media: %o %s", Ge.error, Ge.src), xe.trigger(r.JWPLAYER_MEDIA_ERROR, {
                        message: "Error loading media: File could not be played"
                    }))
                }

                function U(e) {
                    var n;
                    return "array" === t.typeOf(e) && e.length > 0 && (n = i.map(e, function(e, t) {
                        return {
                            label: e.label || t
                        }
                    })), n
                }

                function H(e) {
                    _e = e, Se = z(e);
                    var t = U(e);
                    t && xe.trigger(r.JWPLAYER_MEDIA_LEVELS, {
                        levels: t,
                        currentQuality: Se
                    })
                }

                function z(e) {
                    var t = Math.max(0, Se),
                            n = A.qualityLabel;
                    if (e)
                        for (var i = 0; i < e.length; i++)
                            if (e[i]["default"] && (t = i), n && e[i].label === n) return i;
                    return He.reason = "initial choice", He.level = {}, t
                }

                function G(e, n) {
                    Te = 0, h(Re);
                    var i = document.createElement("source");
                    i.src = _e[Se].file;
                    var r = Ge.src !== i.src,
                            a = Ge.getAttribute("jw-loaded"),
                            s = Ge.hasAttribute("jw-played");
                    r || "none" === a || "started" === a ? (ke = n, K(_e[Se]), q(Ue), Ge.load()) : (0 === e && Ge.currentTime > 0 && (Te = -1, xe.seek(e)), Ge.play()), Ae = Ge.currentTime, w && !s && (W(), Ge.paused || xe.state === o.PLAYING || xe.setState(o.LOADING)), t.isIOS() && xe.getFullScreen() && (Ge.controls = !0), e > 0 && xe.seek(e)
                }

                function K(e) {
                    We = null, Fe = null, Ve = -1, Je = -1, Be = -1, He.reason || (He.reason = "initial choice", He.level = {}), Pe = !1, Le = !1, Oe = p(e), e.preload && e.preload !== Ge.getAttribute("preload") && Ge.setAttribute("preload", e.preload);
                    var t = document.createElement("source");
                    t.src = e.file;
                    var n = Ge.src !== t.src;
                    n && (Ge.setAttribute("jw-loaded", "none"), Ge.src = e.file)
                }

                function Q() {
                    Ge && (be(), Ge.removeAttribute("crossorigin"), Ge.removeAttribute("preload"), Ge.removeAttribute("src"), Ge.removeAttribute("jw-loaded"), Ge.removeAttribute("jw-played"), n.emptyElement(Ge), Se = -1, Ue = null, !v && "load" in Ge && Ge.load())
                }

                function q(e) {
                    var i = t.isChrome() || t.isIOS() || t.isSafari();
                    !De && i && (e !== Ue || e.length && !Ge.textTracks.length) && (be(), n.emptyElement(Ge), Ue = e, X(e))
                }

                function X(e) {
                    if (e)
                        for (var n = !1, i = 0; i < e.length; i++) {
                            var r = e[i];
                            if (/\.(?:web)?vtt(?:\?.*)?$/i.test(r.file) && /subtitles|captions|descriptions|chapters|metadata/i.test(r.kind)) {
                                n || !Ge.hasAttribute("crossorigin") && t.crossdomain(r.file) && (Ge.setAttribute("crossorigin", "anonymous"), n = !0);
                                var o = document.createElement("track");
                                o.src = r.file, o.kind = r.kind, o.srclang = r.language || "", o.label = r.label, o.mode = "disabled", o.id = r["default"] || r.defaulttrack ? "default" : "", Ge.appendChild(o)
                            }
                        }
                }

                function $() {
                    for (var e = Ge.seekable ? Ge.seekable.length : 0, t = 1 / 0; e--;) t = Math.min(t, Ge.seekable.start(e));
                    return t
                }

                function Z() {
                    for (var e = Ge.seekable ? Ge.seekable.length : 0, t = 0; e--;) t = Math.max(t, Ge.seekable.end(e));
                    return t
                }

                function ee() {
                    xe.seeking = !1, xe.trigger(r.JWPLAYER_MEDIA_SEEKED)
                }

                function te() {
                    xe.trigger("volume", {
                        volume: Math.round(100 * Ge.volume)
                    }), xe.trigger("mute", {
                        mute: Ge.muted
                    })
                }

                function ne() {
                    Ge.currentTime === Ae && V()
                }

                function ie() {
                    var e = Ge.buffered,
                            n = Ge.duration;
                    return !e || 0 === e.length || 0 >= n || n === 1 / 0 ? 0 : t.between(e.end(e.length - 1) / n, 0, 1)
                }

                function re() {
                    if (Me && xe.state !== o.IDLE && xe.state !== o.COMPLETE) {
                        if (h(Re), Se = -1, Ye = !0, xe.trigger(r.JWPLAYER_MEDIA_BEFORECOMPLETE), !Me) return;
                        oe()
                    }
                }

                function oe() {
                    h(Re), xe.setState(o.COMPLETE), Ye = !1, xe.trigger(r.JWPLAYER_MEDIA_COMPLETE)
                }

                function ae(e) {
                    Ne = !0, pe(e), t.isIOS() && (Ge.controls = !1)
                }

                function se() {
                    var e = -1,
                            t = 0;
                    if (We)
                        for (t; t < We.length; t++)
                            if ("showing" === We[t].mode) {
                                e = t;
                                break
                            }
                    we(e + 1)
                }

                function le() {
                    for (var e = -1, t = 0; t < Ge.audioTracks.length; t++)
                        if (Ge.audioTracks[t].enabled) {
                            e = t;
                            break
                        }
                    he(e)
                }

                function ce(e) {
                    ue(e.currentTarget.activeCues)
                }

                function ue(e) {
                    if (e && e.length && Be !== e[0].startTime) {
                        var n = t.parseID3(e);
                        Be = e[0].startTime, xe.trigger("meta", {
                            metadataTime: Be,
                            metadata: n
                        })
                    }
                }

                function de(e) {
                    Ne = !1, pe(e), t.isIOS() && (Ge.controls = !1)
                }

                function pe(e) {
                    xe.trigger("fullscreenchange", {
                        target: e.target,
                        jwstate: Ne
                    })
                }

                function fe(e) {
                    if (Fe = null, e) {
                        if (e.length) {
                            for (var t = 0; t < e.length; t++)
                                if (e[t].enabled) {
                                    Ve = t;
                                    break
                                } - 1 === Ve && (Ve = 0, e[Ve].enabled = !0), Fe = i.map(e, function(e) {
                                var t = {
                                    name: e.label || e.language,
                                    language: e.language
                                };
                                return t
                            })
                        }
                        u(e, "change", le), Fe && xe.trigger("audioTracks", {
                            currentTrack: Ve,
                            tracks: Fe
                        })
                    }
                }

                function he(e) {
                    Ge && Ge.audioTracks && Fe && e > -1 && e < Ge.audioTracks.length && e !== Ve && (Ge.audioTracks[Ve].enabled = !1, Ve = e, Ge.audioTracks[Ve].enabled = !0, xe.trigger("audioTrackChanged", {
                        currentTrack: Ve,
                        tracks: Fe
                    }))
                }

                function ge() {
                    return Fe || []
                }

                function me() {
                    return Ve
                }

                function ve(e) {
                    if (We = null, e) {
                        if (e.length) {
                            var t = 0,
                                    n = e.length;
                            for (t; n > t; t++) "metadata" === e[t].kind ? (e[t].oncuechange = ce, e[t].mode = "showing") : "subtitles" !== e[t].kind && "captions" !== e[t].kind || (e[t].mode = "disabled", We || (We = []), We.push(e[t]))
                        }
                        u(e, "change", se), We && We.length && xe.trigger("subtitlesTracks", {
                            tracks: We
                        })
                    }
                }

                function we(e) {
                    We && Je !== e - 1 && (Je > -1 && Je < We.length ? We[Je].mode = "disabled" : i.each(We, function(e) {
                        e.mode = "disabled"
                    }), e > 0 && e <= We.length ? (Je = e - 1, We[Je].mode = "showing") : Je = -1, xe.trigger("subtitlesTrackChanged", {
                        currentTrack: Je + 1,
                        tracks: We
                    }))
                }

                function ye() {
                    return Je
                }

                function je() {
                    if ("hls" === _e[0].type) {
                        var e = "video";
                        0 === Ge.videoHeight && (e = "audio"), xe.trigger("mediaType", {
                            mediaType: e
                        })
                    }
                }

                function be() {
                    We && We[Je] && (We[Je].mode = "disabled")
                }
                this.state = o.IDLE, this.seeking = !1, i.extend(this, s), this.trigger = function(e, t) {
                    return Me ? s.trigger.call(this, e, t) : void 0
                }, this.setState = function(e) {
                    return Me ? a.setState.call(this, e) : void 0
                };
                var Ee, ke, Ae, Le, _e, xe = this,
                        Ce = {
                            click: x,
                            durationchange: C,
                            ended: re,
                            error: B,
                            loadstart: _,
                            loadeddata: L,
                            loadedmetadata: N,
                            canplay: Y,
                            playing: F,
                            progress: P,
                            pause: J,
                            seeked: ee,
                            timeupdate: T,
                            volumechange: te,
                            webkitbeginfullscreen: ae,
                            webkitendfullscreen: de
                        },
                        Pe = !1,
                        Te = 0,
                        Re = -1,
                        Ie = -1,
                        Me = !0,
                        Se = -1,
                        Oe = null,
                        De = !!A.sdkplatform,
                        Ye = !1,
                        Ne = !1,
                        We = null,
                        Fe = null,
                        Je = -1,
                        Ve = -1,
                        Be = -1,
                        Ue = null,
                        He = {
                            level: {}
                        },
                        ze = document.getElementById(f),
                        Ge = ze ? ze.querySelector("video") : void 0;
                Ge = Ge || document.createElement("video"), Ge.className = "jw-video jw-reset", i.isObject(A.cast) && A.cast.appid && Ge.setAttribute("disableRemotePlayback", ""), l(Ce, Ge), b || (Ge.controls = !0, Ge.controls = !1), Ge.setAttribute("x-webkit-airplay", "allow"), Ge.setAttribute("webkit-playsinline", ""), this.stop = function() {
                    h(Re), Me && (Q(), t.isIETrident() && Ge.pause(), this.setState(o.IDLE))
                }, this.destroy = function() {
                    c(Ce, Ge), d(Ge.audioTracks, "change", le), d(Ge.textTracks, "change", se), this.remove(), this.off()
                }, this.init = function(e) {
                    Me && (Ue = null, _e = e.sources, Se = z(e.sources), e.sources.length && "hls" !== e.sources[0].type && this.sendMediaType(e.sources), Ae = e.starttime || 0, ke = e.duration || 0, He.reason = "", K(_e[Se]), q(e.tracks))
                }, this.load = function(e) {
                    Me && (H(e.sources), e.sources.length && "hls" !== e.sources[0].type && this.sendMediaType(e.sources), w && !Ge.hasAttribute("jw-played") || xe.setState(o.LOADING), G(e.starttime || 0, e.duration || 0))
                }, this.play = function() {
                    return xe.seeking ? (xe.setState(o.LOADING), void xe.once(r.JWPLAYER_MEDIA_SEEKED, xe.play)) : void Ge.play()
                }, this.pause = function() {
                    h(Re), Ge.pause(), this.setState(o.PAUSED)
                }, this.seek = function(e) {
                    if (Me)
                        if (0 > e && (e += $() + Z()), 0 === Te && this.trigger(r.JWPLAYER_MEDIA_SEEK, {
                                    position: Ge.currentTime,
                                    offset: e
                                }), Pe || (Pe = !!Z()), Pe) {
                            Te = 0;
                            try {
                                xe.seeking = !0, Ge.currentTime = e
                            } catch (t) {
                                xe.seeking = !1, Te = e
                            }
                        } else Te = e, y && Ge.paused && Ge.play()
                }, this.volume = function(e) {
                    e = t.between(e / 100, 0, 1), Ge.volume = e
                }, this.mute = function(e) {
                    Ge.muted = !!e
                }, this.checkComplete = function() {
                    return Ye
                }, this.detachMedia = function() {
                    return h(Re), be(), Me = !1, Ge
                }, this.attachMedia = function() {
                    Me = !0, Pe = !1, this.seeking = !1, Ge.loop = !1, Ye && oe()
                }, this.setContainer = function(e) {
                    Ee = e, e.appendChild(Ge)
                }, this.getContainer = function() {
                    return Ee
                }, this.remove = function() {
                    Q(), h(Re), Ee === Ge.parentNode && Ee.removeChild(Ge)
                }, this.setVisibility = function(t) {
                    t = !!t, t || j ? e.style(Ee, {
                        visibility: "visible",
                        opacity: 1
                    }) : e.style(Ee, {
                        visibility: "",
                        opacity: 0
                    })
                }, this.resize = function(t, n, i) {
                    if (!(t && n && Ge.videoWidth && Ge.videoHeight)) return !1;
                    var r = {
                        objectFit: ""
                    };
                    if ("uniform" === i) {
                        var o = t / n,
                                a = Ge.videoWidth / Ge.videoHeight;
                        Math.abs(o - a) < .09 && (r.objectFit = "fill", i = "exactfit")
                    }
                    var s = m || j || b || E;
                    if (s) {
                        var l = -Math.floor(Ge.videoWidth / 2 + 1),
                                c = -Math.floor(Ge.videoHeight / 2 + 1),
                                u = Math.ceil(100 * t / Ge.videoWidth) / 100,
                                d = Math.ceil(100 * n / Ge.videoHeight) / 100;
                        "none" === i ? u = d = 1 : "fill" === i ? u = d = Math.max(u, d) : "uniform" === i && (u = d = Math.min(u, d)), r.width = Ge.videoWidth, r.height = Ge.videoHeight, r.top = r.left = "50%", r.margin = 0, e.transform(Ge, "translate(" + l + "px, " + c + "px) scale(" + u.toFixed(2) + ", " + d.toFixed(2) + ")")
                    }
                    return e.style(Ge, r), !1
                }, this.setFullscreen = function(e) {
                    if (e = !!e) {
                        var n = t.tryCatch(function() {
                            var e = Ge.webkitEnterFullscreen || Ge.webkitEnterFullScreen;
                            e && e.apply(Ge)
                        });
                        return n instanceof t.Error ? !1 : xe.getFullScreen()
                    }
                    var i = Ge.webkitExitFullscreen || Ge.webkitExitFullScreen;
                    return i && i.apply(Ge), e
                }, xe.getFullScreen = function() {
                    return Ne || !!Ge.webkitDisplayingFullscreen
                }, this.setCurrentQuality = function(e) {
                    if (Se !== e && e >= 0 && _e && _e.length > e) {
                        Se = e, He.reason = "api", He.level = {}, this.trigger(r.JWPLAYER_MEDIA_LEVEL_CHANGED, {
                            currentQuality: e,
                            levels: U(_e)
                        }), A.qualityLabel = _e[e].label;
                        var t = Ge.currentTime || 0,
                                n = Ge.duration || 0;
                        0 >= n && (n = ke), xe.setState(o.LOADING), G(t, n)
                    }
                }, this.getCurrentQuality = function() {
                    return Se
                }, this.getQualityLevels = function() {
                    return U(_e)
                }, this.getName = function() {
                    return {
                        name: k
                    }
                }, this.setCurrentAudioTrack = he, this.getAudioTracks = ge, this.getCurrentAudioTrack = me, this.setSubtitlesTrack = we, this.getSubtitlesTrack = ye
            }
            var h = window.clearTimeout,
                    g = 256,
                    m = t.isIE(),
                    v = t.isMSIE(),
                    w = t.isMobile(),
                    y = t.isFF(),
                    j = t.isAndroidNative(),
                    b = t.isIOS(7),
                    E = t.isIOS(8),
                    k = "html5",
                    A = function() {};
            return A.prototype = a, f.prototype = new A, f.getName = function() {
                return {
                    name: "html5"
                }
            }, f
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            return {
                repo: "/assets/lib/jwplayer-7.4.2/",
                SkinsIncluded: ["seven"],
                SkinsLoadable: ["beelden", "bekle", "five", "glow", "roundster", "six", "stormtrooper", "vapor"],
                dvrSeekLimit: -25
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14)], r = function(e) {
            function t(e) {
                e = e.split("-");
                for (var t = 1; t < e.length; t++) e[t] = e[t].charAt(0).toUpperCase() + e[t].slice(1);
                return e.join("")
            }

            function n(t, n, i) {
                if ("" === n || void 0 === n || null === n) return "";
                var r = i ? " !important" : "";
                return "string" == typeof n && isNaN(n) ? /png|gif|jpe?g/i.test(n) && n.indexOf("url") < 0 ? "url(" + n + ")" : n + r : 0 === n || "z-index" === t || "opacity" === t ? "" + n + r : /color/i.test(t) ? "#" + e.pad(n.toString(16).replace(/^0x/i, ""), 6) + r : Math.ceil(n) + "px" + r
            }
            var i, r = {},
                    o = function(e, t) {
                        i || (i = document.createElement("style"), i.type = "text/css", document.getElementsByTagName("head")[0].appendChild(i));
                        var n = "";
                        if ("object" == typeof t) {
                            var o = document.createElement("div");
                            a(o, t), n = "{" + o.style.cssText + "}"
                        } else "string" == typeof t && (n = t);
                        var s = document.createTextNode(e + n);
                        r[e] && i.removeChild(r[e]), r[e] = s, i.appendChild(s)
                    },
                    a = function(e, i) {
                        if (void 0 !== e && null !== e) {
                            void 0 === e.length && (e = [e]);
                            var r, o = {};
                            for (r in i) o[r] = n(r, i[r]);
                            for (var a = 0; a < e.length; a++) {
                                var s, l = e[a];
                                if (void 0 !== l && null !== l)
                                    for (r in o) s = t(r), l.style[s] !== o[r] && (l.style[s] = o[r])
                            }
                        }
                    },
                    s = function(e) {
                        for (var t in r) t.indexOf(e) >= 0 && (i.removeChild(r[t]), delete r[t])
                    },
                    l = function(e, t) {
                        a(e, {
                            transform: t,
                            webkitTransform: t,
                            msTransform: t,
                            mozTransform: t,
                            oTransform: t
                        })
                    },
                    c = function(e, t) {
                        var n = "rgb";
                        e ? (e = String(e).replace("#", ""), 3 === e.length && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2])) : e = "000000";
                        var i = [parseInt(e.substr(0, 2), 16), parseInt(e.substr(2, 2), 16), parseInt(e.substr(4, 2), 16)];
                        return void 0 !== t && 100 !== t && (n += "a", i.push(t / 100)), n + "(" + i.join(",") + ")"
                    };
            return {
                css: o,
                style: a,
                clearCss: s,
                transform: l,
                hexToRgba: c
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(131), n(2)], r = function(e, t) {
            var n = e.extend({
                constructor: function(e) {
                    this.el = document.createElement("div"), this.el.className = "jw-icon jw-icon-tooltip " + e + " jw-button-color jw-reset jw-hidden", this.container = document.createElement("div"), this.container.className = "jw-overlay jw-reset", this.openClass = "jw-open", this.componentType = "tooltip", this.el.appendChild(this.container)
                },
                addContent: function(e) {
                    this.content && this.removeContent(), this.content = e, this.container.appendChild(e)
                },
                removeContent: function() {
                    this.content && (this.container.removeChild(this.content), this.content = null)
                },
                hasContent: function() {
                    return !!this.content
                },
                element: function() {
                    return this.el
                },
                openTooltip: function(e) {
                    this.trigger("open-" + this.componentType, e, {
                        isOpen: !0
                    }), this.isOpen = !0, t.toggleClass(this.el, this.openClass, this.isOpen)
                },
                closeTooltip: function(e) {
                    this.trigger("close-" + this.componentType, e, {
                        isOpen: !1
                    }), this.isOpen = !1, t.toggleClass(this.el, this.openClass, this.isOpen)
                },
                toggleOpenState: function(e) {
                    this.isOpen ? this.closeTooltip(e) : this.openTooltip(e)
                }
            });
            return n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(283), n(1)], r = function(e, t) {
            var i = e.prototype.reorderProviders;
            return e.prototype.reorderProviders = function() {
                if (i.apply(this), "flash" !== this.config.primary && this.config.hlshtml === !0) {
                    var e = t.indexOf(this.providers, t.findWhere(this.providers, {
                                name: "caterpillar"
                            })),
                            n = this.providers.splice(e, 1)[0],
                            r = t.indexOf(this.providers, t.findWhere(this.providers, {
                                name: "flash"
                            }));
                    this.providers.splice(r, 0, n)
                }
            }, e.prototype.providerSupports = function(e, t) {
                return e.supports(t, this.config.edition)
            }, e.load = function(i, r) {
                return Promise.all(t.map(i, function(t) {
                    return new Promise(function(e) {
                        switch (t.name) {
                            case "caterpillar":
                                n.e(1, function(require) {
                                    e(n(139))
                                });
                                break;
                            case "html5":
                                ! function(require) {
                                    e(n(43))
                                }(n);
                                break;
                            case "flash":
                                ! function(require) {
                                    e(n(42))
                                }(n);
                                break;
                            case "shaka":
                                n.e(3, function(require) {
                                    e(n(140))
                                });
                                break;
                            case "youtube":
                                n.e(0, function(require) {
                                    e(n(57))
                                });
                                break;
                            default:
                                e()
                        }
                    }).then(function(t) {
                                t && (t.setEdition && t.setEdition(r), e.registerProvider(t))
                            })
                }))
            }, e
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = "free",
                    n = "premium",
                    i = "enterprise",
                    r = "ads",
                    o = "unlimited",
                    a = "trial",
                    s = {
                        setup: [t, n, i, r, o, a],
                        dash: [n, i, r, o, a],
                        drm: [i, r, o, a],
                        hls: [n, r, i, o, a],
                        ads: [r, o, a],
                        casting: [n, i, r, o, a],
                        jwpsrv: [t, n, i, r, a]
                    },
                    l = function(t) {
                        return function(n) {
                            return e.contains(s[n], t)
                        }
                    };
            return l
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , , function(e, t, n) {
        var i, r;
        i = [n(2), n(47), n(120), n(273), n(1), n(3), n(287), n(4), n(6)], r = function(e, t, n, i, r, o, a, s, l) {
            var c = ["volume", "mute", "captionLabel", "qualityLabel"],
                    u = function() {
                        function a(e, t) {
                            switch (e) {
                                case "flashThrottle":
                                    var n = "resume" !== t.state;
                                    this.set("flashThrottle", n), this.set("flashBlocked", n);
                                    break;
                                case "flashBlocked":
                                    return void this.set("flashBlocked", !0);
                                case "flashUnblocked":
                                    return void this.set("flashBlocked", !1);
                                case "volume":
                                case "mute":
                                    return void this.set(e, t[e]);
                                case s.JWPLAYER_MEDIA_TYPE:
                                    this.mediaModel.set("mediaType", t.mediaType);
                                    break;
                                case s.JWPLAYER_PLAYER_STATE:
                                    return void this.mediaModel.set("state", t.newstate);
                                case s.JWPLAYER_MEDIA_BUFFER:
                                    this.set("buffer", t.bufferPercent);
                                case s.JWPLAYER_MEDIA_META:
                                    var i = t.duration;
                                    r.isNumber(i) && (this.mediaModel.set("duration", i), this.set("duration", i));
                                    break;
                                case s.JWPLAYER_MEDIA_BUFFER_FULL:
                                    this.mediaModel.get("playAttempt") ? this.playVideo() : this.mediaModel.on("change:playAttempt", function() {
                                        this.playVideo()
                                    }, this);
                                    break;
                                case s.JWPLAYER_MEDIA_TIME:
                                    this.mediaModel.set("position", t.position), this.set("position", t.position), r.isNumber(t.duration) && (this.mediaModel.set("duration", t.duration), this.set("duration", t.duration));
                                    break;
                                case s.JWPLAYER_PROVIDER_CHANGED:
                                    this.set("provider", p.getName());
                                    break;
                                case s.JWPLAYER_MEDIA_LEVELS:
                                    this.setQualityLevel(t.currentQuality, t.levels), this.mediaModel.set("levels", t.levels);
                                    break;
                                case s.JWPLAYER_MEDIA_LEVEL_CHANGED:
                                    this.setQualityLevel(t.currentQuality, t.levels), this.persistQualityLevel(t.currentQuality, t.levels);
                                    break;
                                case s.JWPLAYER_AUDIO_TRACKS:
                                    this.setCurrentAudioTrack(t.currentTrack, t.tracks), this.mediaModel.set("audioTracks", t.tracks);
                                    break;
                                case s.JWPLAYER_AUDIO_TRACK_CHANGED:
                                    this.setCurrentAudioTrack(t.currentTrack, t.tracks);
                                    break;
                                case "subtitlesTrackChanged":
                                    this.setVideoSubtitleTrack(t.currentTrack, t.tracks);
                                    break;
                                case "visualQuality":
                                    var o = r.extend({}, t);
                                    this.mediaModel.set("visualQuality", o)
                            }
                            var a = r.extend({}, t, {
                                type: e
                            });
                            this.mediaController.trigger(e, a)
                        }
                        var u, p, f = this,
                                h = e.noop;
                        this.mediaController = r.extend({}, o), this.mediaModel = new d, i.model(this), this.set("mediaModel", this.mediaModel), this.setup = function(t) {
                            var i = new n;
                            return i.track(c, this), r.extend(this.attributes, i.getAllItems(), t, {
                                item: 0,
                                state: l.IDLE,
                                flashBlocked: !1,
                                fullscreen: !1,
                                compactUI: !1,
                                scrubbing: !1,
                                duration: 0,
                                position: 0,
                                buffer: 0
                            }), e.isMobile() && !t.mobileSdk && this.set("autostart", !1), this.updateProviders(), this
                        }, this.getConfiguration = function() {
                            return r.omit(this.clone(), ["mediaModel"])
                        }, this.updateProviders = function() {
                            u = new t(this.getConfiguration())
                        }, this.setQualityLevel = function(e, t) {
                            e > -1 && t.length > 1 && "youtube" !== p.getName().name && this.mediaModel.set("currentLevel", parseInt(e))
                        }, this.persistQualityLevel = function(e, t) {
                            var n = t[e] || {},
                                    i = n.label;
                            this.set("qualityLabel", i)
                        }, this.setCurrentAudioTrack = function(e, t) {
                            e > -1 && t.length > 0 && e < t.length && this.mediaModel.set("currentAudioTrack", parseInt(e))
                        }, this.onMediaContainer = function() {
                            var e = this.get("mediaContainer");
                            h.setContainer(e)
                        }, this.changeVideoProvider = function(e) {
                            this.off("change:mediaContainer", this.onMediaContainer), p && (p.off(null, null, this), p.getContainer() && p.remove()), h = new e(f.get("id"), f.getConfiguration());
                            var t = this.get("mediaContainer");
                            t ? h.setContainer(t) : this.once("change:mediaContainer", this.onMediaContainer), this.set("provider", h.getName()), -1 === h.getName().name.indexOf("flash") && (this.set("flashThrottle", void 0), this.set("flashBlocked", !1)), p = h, p.volume(f.get("volume")), p.mute(f.get("mute")), p.on("all", a, this)
                        }, this.destroy = function() {
                            this.off(), p && (p.off(null, null, this), p.destroy())
                        }, this.getVideo = function() {
                            return p
                        }, this.setFullscreen = function(e) {
                            e = !!e, e !== f.get("fullscreen") && f.set("fullscreen", e)
                        }, this.chooseProvider = function(e) {
                            return u.choose(e).provider
                        }, this.setActiveItem = function(e) {
                            this.mediaModel.off(), this.mediaModel = new d, this.set("mediaModel", this.mediaModel);
                            var t = e && e.sources && e.sources[0];
                            if (void 0 !== t) {
                                var n = this.chooseProvider(t);
                                if (!n) throw new Error("No suitable provider found");
                                h instanceof n || f.changeVideoProvider(n), h.init && h.init(e), this.trigger("itemReady", e)
                            }
                        }, this.getProviders = function() {
                            return u
                        }, this.resetProvider = function() {
                            h = null
                        }, this.setVolume = function(e) {
                            e = Math.round(e), f.set("volume", e), p && p.volume(e);
                            var t = 0 === e;
                            t !== f.get("mute") && f.setMute(t)
                        }, this.setMute = function(t) {
                            if (e.exists(t) || (t = !f.get("mute")), f.set("mute", t), p && p.mute(t), !t) {
                                var n = Math.max(10, f.get("volume"));
                                this.setVolume(n)
                            }
                        }, this.loadVideo = function(e) {
                            if (this.mediaModel.set("playAttempt", !0), this.mediaController.trigger(s.JWPLAYER_MEDIA_PLAY_ATTEMPT, {
                                        playReason: this.get("playReason")
                                    }), !e) {
                                var t = this.get("item");
                                e = this.get("playlist")[t]
                            }
                            this.set("position", e.starttime || 0), this.set("duration", e.duration || 0), p.load(e)
                        }, this.stopVideo = function() {
                            p && p.stop()
                        }, this.playVideo = function() {
                            p.play()
                        }, this.persistCaptionsTrack = function() {
                            var e = this.get("captionsTrack");
                            e ? this.set("captionLabel", e.label) : this.set("captionLabel", "Off")
                        }, this.setVideoSubtitleTrack = function(e, t) {
                            this.set("captionsIndex", e), e && t && e <= t.length && t[e - 1].data && this.set("captionsTrack", t[e - 1]), p && p.setSubtitlesTrack && p.setSubtitlesTrack(e)
                        }, this.persistVideoSubtitleTrack = function(e) {
                            this.setVideoSubtitleTrack(e), this.persistCaptionsTrack()
                        }
                    },
                    d = u.MediaModel = function() {
                        this.set("state", l.IDLE)
                    };
            return r.extend(u.prototype, a), r.extend(d.prototype, a), u
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14)], r = function(e) {
            var t = {},
                    n = t.pluginPathType = {
                        ABSOLUTE: 0,
                        RELATIVE: 1,
                        CDN: 2
                    };
            return t.getPluginPathType = function(t) {
                if ("string" == typeof t) {
                    t = t.split("?")[0];
                    var i = t.indexOf("://");
                    if (i > 0) return n.ABSOLUTE;
                    var r = t.indexOf("/"),
                            o = e.extension(t);
                    return !(0 > i && 0 > r) || o && isNaN(o) ? n.RELATIVE : n.CDN
                }
            }, t.getPluginName = function(e) {
                return e.replace(/^(.*\/)?([^-]*)-?.*\.(swf|js)$/, "$2")
            }, t.getPluginVersion = function(e) {
                return e.replace(/[^-]*-?([^\.]*).*$/, "$1")
            }, t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = {},
                    n = {
                        TIT2: "title",
                        TT2: "title",
                        WXXX: "url",
                        TPE1: "artist",
                        TP1: "artist",
                        TALB: "album",
                        TAL: "album"
                    };
            return t.utf8ArrayToStr = function(e, t) {
                var n, i, r, o, a, s;
                for (n = "", r = e.length, i = t || 0; r > i;)
                    if (o = e[i++], 0 !== o && 3 !== o) switch (o >> 4) {
                        case 0:
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                        case 7:
                            n += String.fromCharCode(o);
                            break;
                        case 12:
                        case 13:
                            a = e[i++], n += String.fromCharCode((31 & o) << 6 | 63 & a);
                            break;
                        case 14:
                            a = e[i++], s = e[i++], n += String.fromCharCode((15 & o) << 12 | (63 & a) << 6 | (63 & s) << 0)
                    }
                return n
            }, t.utf16BigEndianArrayToStr = function(e, t) {
                var n, i, r;
                for (n = "", r = e.length - 1, i = t || 0; r > i;) 254 === e[i] && 255 === e[i + 1] || (n += String.fromCharCode((e[i] << 8) + e[i + 1])), i += 2;
                return n
            }, t.syncSafeInt = function(e) {
                var n = t.arrayToInt(e);
                return 127 & n | (32512 & n) >> 1 | (8323072 & n) >> 2 | (2130706432 & n) >> 3
            }, t.arrayToInt = function(e) {
                for (var t = "0x", n = 0; n < e.length; n++) t += e[n].toString(16);
                return parseInt(t)
            }, t.parseID3 = function(i) {
                return e.reduce(i, function(i, r) {
                    if (!("value" in r) && "data" in r && r.data instanceof ArrayBuffer) {
                        var o = r,
                                a = new Uint8Array(o.data),
                                s = a.length;
                        r = {
                            value: {
                                key: "",
                                data: ""
                            }
                        };
                        for (var l = 10; 14 > l && l < a.length && 0 !== a[l];) r.value.key += String.fromCharCode(a[l]), l++;
                        var c = 19,
                                u = a[c];
                        3 !== u && 0 !== u || (u = a[++c], s--);
                        var d = 0;
                        if (1 !== u && 2 !== u)
                            for (var p = c + 1; s > p; p++)
                                if (0 === a[p]) {
                                    d = p - c;
                                    break
                                }
                        if (d > 0) {
                            var f = t.utf8ArrayToStr(a.subarray(c, c += d), 0);
                            if ("PRIV" === r.value.key) {
                                if ("com.apple.streaming.transportStreamTimestamp" === f) {
                                    var h = 1 & t.syncSafeInt(a.subarray(c, c += 4)),
                                            g = t.syncSafeInt(a.subarray(c, c += 4));
                                    h && (g += 4294967296), r.value.data = g
                                } else r.value.data = t.utf8ArrayToStr(a, c + 1);
                                r.value.info = f
                            } else r.value.info = f, r.value.data = t.utf8ArrayToStr(a, c + 1)
                        } else {
                            var m = a[c];
                            1 === m || 2 === m ? r.value.data = t.utf16BigEndianArrayToStr(a, c + 1) : r.value.data = t.utf8ArrayToStr(a, c + 1)
                        }
                    }
                    if (n.hasOwnProperty(r.value.key) && (i[n[r.value.key]] = r.value.data), r.value.info) {
                        var v = i[r.value.key];
                        e.isObject(v) || (v = {}, i[r.value.key] = v), v[r.value.info] = r.value.data
                    } else i[r.value.key] = r.value.data;
                    return i
                }, {})
            }, t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            var e = window.chrome,
                    t = {};
            return t.NS = "urn:x-cast:com.longtailvideo.jwplayer", t.debug = !1, t.availability = null, t.available = function(n) {
                n = n || t.availability;
                var i = "available";
                return e && e.cast && e.cast.ReceiverAvailability && (i = e.cast.ReceiverAvailability.AVAILABLE), n === i
            }, t.log = function() {
                if (t.debug) {
                    var e = Array.prototype.slice.call(arguments, 0);
                    console.log.apply(console, e)
                }
            }, t.error = function() {
                var e = Array.prototype.slice.call(arguments, 0);
                console.error.apply(console, e)
            }, t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , , , , , , , , , , , , , , , , , , , function(e, t, n) {
        var i, r;
        i = [n(6)], r = function(e) {
            function t(t) {
                return t === e.COMPLETE || t === e.ERROR ? e.IDLE : t
            }
            return function(e, n, i) {
                if (n = t(n), i = t(i), n !== i) {
                    var r = n.replace(/(?:ing|d)$/, ""),
                            o = {
                                type: r,
                                newstate: n,
                                oldstate: i,
                                reason: e.mediaModel.get("state")
                            };
                    "play" === r && (o.playReason = e.get("playReason")), this.trigger(r, o)
                }
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(14)], r = function(e, t) {
            function n(e) {
                var t = {},
                        n = e.split("\r\n");
                1 === n.length && (n = e.split("\n"));
                var r = 1;
                if (n[0].indexOf(" --> ") > 0 && (r = 0), n.length > r + 1 && n[r + 1]) {
                    var o = n[r],
                            a = o.indexOf(" --> ");
                    a > 0 && (t.begin = i(o.substr(0, a)), t.end = i(o.substr(a + 5)), t.text = n.slice(r + 1).join("<br/>"))
                }
                return t
            }
            var i = e.seconds;
            return function(e) {
                var i = [];
                e = t.trim(e);
                var r = e.split("\r\n\r\n");
                1 === r.length && (r = e.split("\n\n"));
                for (var o = 0; o < r.length; o++)
                    if ("WEBVTT" !== r[o]) {
                        var a = n(r[o]);
                        a.text && i.push(a)
                    }
                if (!i.length) throw new Error("Invalid SRT file");
                return i
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(124), n(279)], r = function(e, t, n) {
            var i = {
                        sources: [],
                        tracks: []
                    },
                    r = function(r) {
                        r = r || {}, e.isArray(r.tracks) || delete r.tracks;
                        var o = e.extend({}, i, r);
                        e.isObject(o.sources) && !e.isArray(o.sources) && (o.sources = [t(o.sources)]), e.isArray(o.sources) && 0 !== o.sources.length || (r.levels ? o.sources = r.levels : o.sources = [t(r)]);
                        for (var a = 0; a < o.sources.length; a++) {
                            var s = o.sources[a];
                            if (s) {
                                var l = s["default"];
                                l ? s["default"] = "true" === l.toString() : s["default"] = !1, o.sources[a].label || (o.sources[a].label = a.toString()), o.sources[a] = t(o.sources[a])
                            }
                        }
                        return o.sources = e.compact(o.sources), e.isArray(o.tracks) || (o.tracks = []), e.isArray(o.captions) && (o.tracks = o.tracks.concat(o.captions), delete o.captions), o.tracks = e.compact(e.map(o.tracks, n)), o
                    };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(87)], r = function(e, t) {
            function n(e) {
                return /^(?:(?:https?|file)\:)?\/\//.test(e)
            }

            function i(t) {
                return e.some(t, function(e) {
                    return "parsererror" === e.nodeName
                })
            }
            var r = {};
            return r.getAbsolutePath = function(e, i) {
                if (t.exists(i) || (i = document.location.href), t.exists(e)) {
                    if (n(e)) return e;
                    var r, o = i.substring(0, i.indexOf("://") + 3),
                            a = i.substring(o.length, i.indexOf("/", o.length + 1));
                    if (0 === e.indexOf("/")) r = e.split("/");
                    else {
                        var s = i.split("?")[0];
                        s = s.substring(o.length + a.length + 1, s.lastIndexOf("/")), r = s.split("/").concat(e.split("/"))
                    }
                    for (var l = [], c = 0; c < r.length; c++) r[c] && t.exists(r[c]) && "." !== r[c] && (".." === r[c] ? l.pop() : l.push(r[c]));
                    return o + a + "/" + l.join("/")
                }
            }, r.getScriptPath = e.memoize(function(e) {
                for (var t = document.getElementsByTagName("script"), n = 0; n < t.length; n++) {
                    var i = t[n].src;
                    if (i && i.indexOf(e) >= 0) return i.substr(0, i.indexOf(e))
                }
                return ""
            }), r.parseXML = function(e) {
                var t = null;
                try {
                    "DOMParser" in window ? (t = (new window.DOMParser).parseFromString(e, "text/xml"), (i(t.childNodes) || t.childNodes && i(t.childNodes[0].childNodes)) && (t = null)) : (t = new window.ActiveXObject("Microsoft.XMLDOM"), t.async = "false", t.loadXML(e))
                } catch (n) {}
                return t
            }, r.serialize = function(e) {
                if (void 0 === e) return null;
                if ("string" == typeof e && e.length < 6) {
                    var t = e.toLowerCase();
                    if ("true" === t) return !0;
                    if ("false" === t) return !1;
                    if (!isNaN(Number(e)) && !isNaN(parseFloat(e))) return Number(e)
                }
                return e
            }, r.parseDimension = function(e) {
                return "string" == typeof e ? "" === e ? 0 : e.lastIndexOf("%") > -1 ? e : parseInt(e.replace("px", ""), 10) : e
            }, r.timeFormat = function(e, t) {
                if (0 >= e && !t) return "00:00";
                var n = 0 > e ? "-" : "";
                e = Math.abs(e);
                var i = Math.floor(e / 3600),
                        r = Math.floor((e - 3600 * i) / 60),
                        o = Math.floor(e % 60);
                return n + (i ? i + ":" : "") + (10 > r ? "0" : "") + r + ":" + (10 > o ? "0" : "") + o
            }, r.adaptiveType = function(e) {
                if (0 !== e) {
                    var t = -120;
                    if (t >= e) return "DVR";
                    if (0 > e || e === 1 / 0) return "LIVE"
                }
                return "VOD"
            }, r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = {};
            return t.exists = function(e) {
                switch (typeof e) {
                    case "string":
                        return e.length > 0;
                    case "object":
                        return null !== e;
                    case "undefined":
                        return !1
                }
                return !0
            }, t.isHTTPS = function() {
                return 0 === window.location.href.indexOf("https")
            }, t.isRtmp = function(e, t) {
                return 0 === e.indexOf("rtmp") || "rtmp" === t
            }, t.isYouTube = function(e, t) {
                return "youtube" === t || /^(http|\/\/).*(youtube\.com|youtu\.be)\/.+/.test(e)
            }, t.youTubeID = function(e) {
                var t = /v[=\/]([^?&]*)|youtu\.be\/([^?]*)|^([\w-]*)$/i.exec(e);
                return t ? t.slice(1).join("").replace("?", "") : ""
            }, t.typeOf = function(t) {
                if (null === t) return "null";
                var n = typeof t;
                return "object" === n && e.isArray(t) ? "array" : n
            }, t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(131), n(12), n(245), n(2)], r = function(e, t, n, i) {
            var r = e.extend({
                constructor: function(e, t) {
                    this.className = e + " jw-background-color jw-reset", this.orientation = t, this.dragStartListener = this.dragStart.bind(this), this.dragMoveListener = this.dragMove.bind(this), this.dragEndListener = this.dragEnd.bind(this), this.tapListener = this.tap.bind(this), this.setup()
                },
                setup: function() {
                    var e = {
                        "default": this["default"],
                        className: this.className,
                        orientation: "jw-slider-" + this.orientation
                    };
                    this.el = i.createElement(n(e)), this.elementRail = this.el.getElementsByClassName("jw-slider-container")[0], this.elementBuffer = this.el.getElementsByClassName("jw-buffer")[0], this.elementProgress = this.el.getElementsByClassName("jw-progress")[0], this.elementThumb = this.el.getElementsByClassName("jw-knob")[0], this.userInteract = new t(this.element(), {
                        preventScrolling: !0
                    }), this.userInteract.on("dragStart", this.dragStartListener), this.userInteract.on("drag", this.dragMoveListener), this.userInteract.on("dragEnd", this.dragEndListener), this.userInteract.on("tap click", this.tapListener)
                },
                dragStart: function() {
                    this.trigger("dragStart"), this.railBounds = i.bounds(this.elementRail)
                },
                dragEnd: function(e) {
                    this.dragMove(e), this.trigger("dragEnd")
                },
                dragMove: function(e) {
                    var t, n, r = this.railBounds = this.railBounds ? this.railBounds : i.bounds(this.elementRail);
                    "horizontal" === this.orientation ? (t = e.pageX, n = t < r.left ? 0 : t > r.right ? 100 : 100 * i.between((t - r.left) / r.width, 0, 1)) : (t = e.pageY, n = t >= r.bottom ? 0 : t <= r.top ? 100 : 100 * i.between((r.height - (t - r.top)) / r.height, 0, 1));
                    var o = this.limit(n);
                    return this.render(o), this.update(o), !1
                },
                tap: function(e) {
                    this.railBounds = i.bounds(this.elementRail), this.dragMove(e)
                },
                limit: function(e) {
                    return e
                },
                update: function(e) {
                    this.trigger("update", {
                        percentage: e
                    })
                },
                render: function(e) {
                    e = Math.max(0, Math.min(e, 100)), "horizontal" === this.orientation ? (this.elementThumb.style.left = e + "%", this.elementProgress.style.width = e + "%") : (this.elementThumb.style.bottom = e + "%", this.elementProgress.style.height = e + "%")
                },
                updateBuffer: function(e) {
                    this.elementBuffer.style.width = e + "%"
                },
                element: function() {
                    return this.el
                }
            });
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(129), n(48), n(1), n(282)], r = function(e, t, n, i) {
            function r() {
                return !!navigator.requestMediaKeySystemAccess && !!MediaKeySystemAccess.prototype.getConfiguration || !!HTMLMediaElement.prototype.webkitGenerateKeyRequest || !!window.MSMediaKeys
            }

            function o(t) {
                return !!t.clearkey || !!t.widevine && e.isChrome() || !!t.playready && e.isIE()
            }

            function a(i, a) {
                var s = t(a);
                if (!e.isChrome() && !e.isIETrident(11) && !e.isFF()) return !1;
                if (!s("dash")) return !1;
                if (i.drm && (!s("drm") || !o(i.drm) || !r())) return !1;
                var l = window.MediaSource;
                if (!window.HTMLVideoElement || !l) return !1;
                var c = !0;
                return i.mediaTypes && (c = n.all(i.mediaTypes, function(e) {
                    return l.isTypeSupported(e)
                })), c && ("dash" === i.type || "mpd" === i.type || (i.file || "").indexOf("mpd-time-csf") > -1)
            }
            var s = n.find(i, n.matches({
                        name: "flash"
                    })),
                    l = s.supports;
            return s.supports = function(n, i) {
                if (!e.isFlashSupported()) return !1;
                var r = n && n.type;
                if ("hls" === r || "m3u8" === r) {
                    var o = t(i);
                    return o("hls")
                }
                return l.apply(this, arguments)
            }, i.push({
                name: "shaka",
                supports: a
            }), i.push({
                name: "caterpillar",
                supports: function(n, i) {
                    if (e.isChrome() && !e.isMobile()) {
                        var r = n && n.type,
                                o = n && n.file;
                        if (o.indexOf(".m3u8") > -1 || "hls" === r || "m3u8" === r) {
                            var a = t(i);
                            return a("hls")
                        }
                    }
                }
            }), i
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , , , , , , , , , , , , , , , , , , , , , , , , function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }

        function r(e, t, n) {
            this.helpers = e || {}, this.partials = t || {}, this.decorators = n || {}, l.registerDefaultHelpers(this), c.registerDefaultDecorators(this)
        }
        t.__esModule = !0, t.HandlebarsEnvironment = r;
        var o = n(20),
                a = n(39),
                s = i(a),
                l = n(250),
                c = n(248),
                u = n(258),
                d = i(u),
                p = "4.0.5";
        t.VERSION = p;
        var f = 7;
        t.COMPILER_REVISION = f;
        var h = {
            1: "<= 1.0.rc.2",
            2: "== 1.0.0-rc.3",
            3: "== 1.0.0-rc.4",
            4: "== 1.x.x",
            5: "== 2.0.0-alpha.x",
            6: ">= 2.0.0-beta.1",
            7: ">= 4.0.0"
        };
        t.REVISION_CHANGES = h;
        var g = "[object Object]";
        r.prototype = {
            constructor: r,
            logger: d["default"],
            log: d["default"].log,
            registerHelper: function(e, t) {
                if (o.toString.call(e) === g) {
                    if (t) throw new s["default"]("Arg not supported with multiple helpers");
                    o.extend(this.helpers, e)
                } else this.helpers[e] = t
            },
            unregisterHelper: function(e) {
                delete this.helpers[e]
            },
            registerPartial: function(e, t) {
                if (o.toString.call(e) === g) o.extend(this.partials, e);
                else {
                    if ("undefined" == typeof t) throw new s["default"]('Attempting to register a partial called "' + e + '" as undefined');
                    this.partials[e] = t
                }
            },
            unregisterPartial: function(e) {
                delete this.partials[e]
            },
            registerDecorator: function(e, t) {
                if (o.toString.call(e) === g) {
                    if (t) throw new s["default"]("Arg not supported with multiple decorators");
                    o.extend(this.decorators, e)
                } else this.decorators[e] = t
            },
            unregisterDecorator: function(e) {
                delete this.decorators[e]
            }
        };
        var m = d["default"].log;
        t.log = m, t.createFrame = o.createFrame, t.logger = d["default"]
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(1)], r = function(e, t) {
            function i(n) {
                t.each(n, function(t, i) {
                    n[i] = e.serialize(t)
                })
            }

            function r(e) {
                return e.slice && "px" === e.slice(-2) && (e = e.slice(0, -2)), e
            }

            function o(t, n) {
                if (-1 === n.toString().indexOf("%")) return 0;
                if ("string" != typeof t || !e.exists(t)) return 0;
                if (/^\d*\.?\d+%$/.test(t)) return t;
                var i = t.indexOf(":");
                if (-1 === i) return 0;
                var r = parseFloat(t.substr(0, i)),
                        o = parseFloat(t.substr(i + 1));
                return 0 >= r || 0 >= o ? 0 : o / r * 100 + "%"
            }
            var a = {
                        autostart: !1,
                        controls: !0,
                        displaytitle: !0,
                        displaydescription: !0,
                        mobilecontrols: !1,
                        repeat: !1,
                        castAvailable: !1,
                        skin: "seven",
                        stretching: "uniform",
                        mute: !1,
                        volume: 90,
                        width: 480,
                        height: 270
                    },
                    s = function(s) {
                        var l = t.extend({}, (window.jwplayer || {}).defaults, s);
                        i(l);
                        var c = t.extend({}, a, l);
                        if ("." === c.base && (c.base = e.getScriptPath("jwplayer.js")), c.base = (c.base || e.loadFrom()).replace(/\/?$/, "/"), n.p = c.base, c.width = r(c.width), c.height = r(c.height), c.flashplayer = c.flashplayer || e.getScriptPath("jwplayer.js") + "jwplayer.flash.swf", "http:" === window.location.protocol && (c.flashplayer = c.flashplayer.replace("https", "http")), c.aspectratio = o(c.aspectratio, c.width), t.isObject(c.skin) && (c.skinUrl = c.skin.url, c.skinColorInactive = c.skin.inactive, c.skinColorActive = c.skin.active, c.skinColorBackground = c.skin.background, c.skin = t.isString(c.skin.name) ? c.skin.name : a.skin), t.isString(c.skin) && c.skin.indexOf(".xml") > 0 && (console.log("JW Player does not support XML skins, please update your config"), c.skin = c.skin.replace(".xml", "")), c.aspectratio || delete c.aspectratio, !c.playlist) {
                            var u = t.pick(c, ["title", "description", "type", "mediaid", "image", "file", "sources", "tracks", "preload"]);
                            c.playlist = [u]
                        }
                        return c
                    };
            return s
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2)], r = function(e, t) {
            function n(e) {
                return "jwplayer." + e
            }

            function i() {
                return e.reduce(this.persistItems, function(e, i) {
                    var r = c[n(i)];
                    return r && (e[i] = t.serialize(r)),
                            e
                }, {})
            }

            function r(e, t) {
                try {
                    c[n(e)] = t
                } catch (i) {
                    l && l.debug && console.error(i)
                }
            }

            function o() {
                e.each(this.persistItems, function(e) {
                    c.removeItem(n(e))
                })
            }

            function a() {}

            function s(t, n) {
                this.persistItems = t, e.each(this.persistItems, function(e) {
                    n.on("change:" + e, function(t, n) {
                        r(e, n)
                    })
                })
            }
            var l = window.jwplayer,
                    c = {
                        removeItem: t.noop
                    };
            try {
                c = window.localStorage
            } catch (u) {}
            return e.extend(a.prototype, {
                getAllItems: i,
                track: s,
                clear: o
            }), a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14), n(40), n(277), n(278), n(85)], r = function(e, t, n, i, r) {
            function o(t) {
                for (var o = {}, s = 0; s < t.childNodes.length; s++) {
                    var l = t.childNodes[s],
                            u = c(l);
                    if (u) switch (u.toLowerCase()) {
                        case "enclosure":
                            o.file = e.xmlAttribute(l, "url");
                            break;
                        case "title":
                            o.title = a(l);
                            break;
                        case "guid":
                            o.mediaid = a(l);
                            break;
                        case "pubdate":
                            o.date = a(l);
                            break;
                        case "description":
                            o.description = a(l);
                            break;
                        case "link":
                            o.link = a(l);
                            break;
                        case "category":
                            o.tags ? o.tags += a(l) : o.tags = a(l)
                    }
                }
                return o = i(t, o), o = n(t, o), new r(o)
            }
            var a = t.textContent,
                    s = t.getChildNode,
                    l = t.numChildren,
                    c = t.localName,
                    u = {};
            return u.parse = function(e) {
                for (var t = [], n = 0; n < l(e); n++) {
                    var i = s(e, n),
                            r = c(i).toLowerCase();
                    if ("channel" === r)
                        for (var a = 0; a < l(i); a++) {
                            var u = s(i, a);
                            "item" === c(u).toLowerCase() && t.push(o(u))
                        }
                }
                return t
            }, u
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(40), n(121), n(2), n(4), n(3), n(1)], r = function(e, t, n, i, r, o) {
            var a = function() {
                function a(r) {
                    var a = n.tryCatch(function() {
                        var n, a = r.responseXML ? r.responseXML.childNodes : null,
                                s = "";
                        if (a) {
                            for (var u = 0; u < a.length && (s = a[u], 8 === s.nodeType); u++);
                            "xml" === e.localName(s) && (s = s.nextSibling), "rss" === e.localName(s) && (n = {
                                playlist: t.parse(s)
                            })
                        }
                        if (!n) try {
                            var d = JSON.parse(r.responseText);
                            if (o.isArray(d)) n = {
                                playlist: d
                            };
                            else {
                                if (!o.isArray(d.playlist)) throw null;
                                n = d
                            }
                        } catch (p) {
                            return void l("Not a valid RSS/JSON feed")
                        }
                        c.trigger(i.JWPLAYER_PLAYLIST_LOADED, n)
                    });
                    a instanceof n.Error && l()
                }

                function s(e) {
                    l("Playlist load error: " + e)
                }

                function l(e) {
                    c.trigger(i.JWPLAYER_ERROR, {
                        message: e ? e : "Error loading file"
                    })
                }
                var c = o.extend(this, r);
                this.load = function(e) {
                    n.ajax(e, a, s)
                }, this.destroy = function() {
                    this.off()
                }
            };
            return a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(85), n(124), n(1), n(47)], r = function(e, t, n, i) {
            function r(e, t) {
                for (var n = 0; n < e.length; n++) {
                    var i = e[n],
                            r = t.choose(i);
                    if (r) return i.type
                }
                return null
            }
            var o = function(t) {
                return t = n.isArray(t) ? t : [t], n.compact(n.map(t, e))
            };
            o.filterPlaylist = function(e, t, i, r, o, l) {
                var c = [];
                return n.each(e, function(e) {
                    e = n.extend({}, e), e.allSources = a(e.sources, i, e.drm || r, e.preload || o), e.sources = s(e.allSources, t), e.sources.length && (e.file = e.sources[0].file, (e.preload || o) && (e.preload = e.preload || o), (e.feedid || l) && (e.feedid = e.feedid || l), c.push(e))
                }), c
            };
            var a = function(e, i, r, o) {
                        return n.compact(n.map(e, function(e) {
                            return n.isObject(e) ? (void 0 !== i && null !== i && (e.androidhls = i), (e.drm || r) && (e.drm = e.drm || r), (e.preload || o) && (e.preload = e.preload || o), t(e)) : void 0
                        }))
                    },
                    s = function(e, t) {
                        t && t.choose || (t = new i({
                            primary: t ? "flash" : null
                        }));
                        var o = r(e, t);
                        return n.where(e, {
                            type: o
                        })
                    };
            return o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(14), n(1)], r = function(e, t, n) {
            var i = {
                        "default": !1
                    },
                    r = function(r) {
                        if (r && r.file) {
                            var o = n.extend({}, i, r);
                            o.file = t.trim("" + o.file);
                            var a = /^[^\/]+\/(?:x-)?([^\/]+)$/;
                            if (e.isYouTube(o.file) ? o.type = "youtube" : e.isRtmp(o.file) ? o.type = "rtmp" : a.test(o.type) ? o.type = o.type.replace(a, "$1") : o.type || (o.type = t.extension(o.file)), o.type) {
                                switch (o.type) {
                                    case "m3u8":
                                    case "vnd.apple.mpegurl":
                                        o.type = "hls";
                                        break;
                                    case "dash+xml":
                                        o.type = "dash";
                                        break;
                                    case "smil":
                                        o.type = "rtmp";
                                        break;
                                    case "m4a":
                                        o.type = "aac"
                                }
                                return n.each(o, function(e, t) {
                                    "" === e && delete o[t]
                                }), o
                            }
                        }
                    };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(56), n(4), n(3), n(32), n(1)], r = function(e, t, n, i, r, o) {
            var a = {
                        FLASH: 0,
                        JAVASCRIPT: 1,
                        HYBRID: 2
                    },
                    s = function(s) {
                        function l() {
                            switch (t.getPluginPathType(s)) {
                                case t.pluginPathType.ABSOLUTE:
                                    return s;
                                case t.pluginPathType.RELATIVE:
                                    return e.getAbsolutePath(s, window.location.href)
                            }
                        }

                        function c() {
                            o.defer(function() {
                                m = r.loaderstatus.COMPLETE, g.trigger(n.COMPLETE)
                            })
                        }

                        function u() {
                            m = r.loaderstatus.ERROR, g.trigger(n.ERROR, {
                                url: s
                            })
                        }
                        var d, p, f, h, g = o.extend(this, i),
                                m = r.loaderstatus.NEW;
                        this.load = function() {
                            if (m === r.loaderstatus.NEW) {
                                if (s.lastIndexOf(".swf") > 0) return d = s, m = r.loaderstatus.COMPLETE, void g.trigger(n.COMPLETE);
                                if (t.getPluginPathType(s) === t.pluginPathType.CDN) return m = r.loaderstatus.COMPLETE, void g.trigger(n.COMPLETE);
                                m = r.loaderstatus.LOADING;
                                var e = new r(l());
                                e.on(n.COMPLETE, c), e.on(n.ERROR, u), e.load()
                            }
                        }, this.registerPlugin = function(e, t, i, o) {
                            h && (clearTimeout(h), h = void 0), f = t, i && o ? (d = o, p = i) : "string" == typeof i ? d = i : "function" == typeof i ? p = i : i || o || (d = e), m = r.loaderstatus.COMPLETE, g.trigger(n.COMPLETE)
                        }, this.getStatus = function() {
                            return m
                        }, this.getPluginName = function() {
                            return t.getPluginName(s)
                        }, this.getFlashPath = function() {
                            if (d) switch (t.getPluginPathType(d)) {
                                case t.pluginPathType.ABSOLUTE:
                                    return d;
                                case t.pluginPathType.RELATIVE:
                                    return s.lastIndexOf(".swf") > 0 ? e.getAbsolutePath(d, window.location.href) : e.getAbsolutePath(d, l())
                            }
                            return null
                        }, this.getJS = function() {
                            return p
                        }, this.getTarget = function() {
                            return f
                        }, this.getPluginmode = function() {
                            return void 0 !== typeof d && void 0 !== typeof p ? a.HYBRID : void 0 !== typeof d ? a.FLASH : void 0 !== typeof p ? a.JAVASCRIPT : void 0
                        }, this.getNewInstance = function(e, t, n) {
                            return new p(e, t, n)
                        }, this.getURL = function() {
                            return s
                        }
                    };
            return s
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , function(e, t, n) {
        var i, r;
        i = [n(43), n(42)], r = function(e, t) {
            var n = {
                html5: e,
                flash: t
            };
            return n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            function t(e) {
                return function() {
                    return i(e)
                }
            }
            var n = {},
                    i = e.memoize(function(e) {
                        var t = navigator.userAgent.toLowerCase();
                        return null !== t.match(e)
                    }),
                    r = n.isInt = function(e) {
                        return parseFloat(e) % 1 === 0
                    };
            n.isFlashSupported = function() {
                var e = n.flashVersion();
                return e && e >= 11.2
            }, n.isFF = t(/firefox/i), n.isIPod = t(/iP(hone|od)/i), n.isIPad = t(/iPad/i), n.isSafari602 = t(/Macintosh.*Mac OS X 10_8.*6\.0\.\d* Safari/i), n.isOSX = t(/Mac OS X/i), n.isEdge = t(/\sedge\/\d+/i);
            var o = n.isIETrident = function(e) {
                        return n.isEdge() ? !0 : e ? (e = parseFloat(e).toFixed(1), i(new RegExp("trident/.+rv:\\s*" + e, "i"))) : i(/trident/i)
                    },
                    a = n.isMSIE = function(e) {
                        return e ? (e = parseFloat(e).toFixed(1), i(new RegExp("msie\\s*" + e, "i"))) : i(/msie/i)
                    },
                    s = t(/chrome/i);
            n.isChrome = function() {
                return s() && !n.isEdge()
            }, n.isIE = function(e) {
                return e ? (e = parseFloat(e).toFixed(1), e >= 11 ? o(e) : a(e)) : a() || o()
            }, n.isSafari = function() {
                return i(/safari/i) && !i(/chrome/i) && !i(/chromium/i) && !i(/android/i)
            };
            var l = n.isIOS = function(e) {
                return i(e ? new RegExp("iP(hone|ad|od).+\\s(OS\\s" + e + "|.*\\sVersion/" + e + ")", "i") : /iP(hone|ad|od)/i)
            };
            n.isAndroidNative = function(e) {
                return c(e, !0)
            };
            var c = n.isAndroid = function(e, t) {
                return t && i(/chrome\/[123456789]/i) && !i(/chrome\/18/) ? !1 : e ? (r(e) && !/\./.test(e) && (e = "" + e + "."), i(new RegExp("Android\\s*" + e, "i"))) : i(/Android/i)
            };
            return n.isMobile = function() {
                return l() || c()
            }, n.isIframe = function() {
                return window.frameElement && "IFRAME" === window.frameElement.nodeName
            }, n.flashVersion = function() {
                if (n.isAndroid()) return 0;
                var e, t = navigator.plugins;
                if (t && (e = t["Shockwave Flash"], e && e.description)) return parseFloat(e.description.replace(/\D+(\d+\.?\d*).*/, "$1"));
                if ("undefined" != typeof window.ActiveXObject) {
                    try {
                        if (e = new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash")) return parseFloat(e.GetVariable("$version").split(" ")[1].replace(/\s*,\s*/, "."))
                    } catch (i) {
                        return 0
                    }
                    return e
                }
                return 0
            }, n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14), n(1), n(286)], r = function(e, t, n) {
            var i = {};
            i.createElement = function(e) {
                var t = document.createElement("div");
                return t.innerHTML = e, t.firstChild
            }, i.styleDimension = function(e) {
                return e + (e.toString().indexOf("%") > 0 ? "" : "px")
            };
            var r = function(e) {
                        return t.isString(e.className) ? e.className.split(" ") : []
                    },
                    o = function(t, n) {
                        n = e.trim(n), t.className !== n && (t.className = n)
                    };
            return i.classList = function(e) {
                return e.classList ? e.classList : r(e)
            }, i.hasClass = n.hasClass, i.addClass = function(e, n) {
                var i = r(e),
                        a = t.isArray(n) ? n : n.split(" ");
                t.each(a, function(e) {
                    t.contains(i, e) || i.push(e)
                }), o(e, i.join(" "))
            }, i.removeClass = function(e, n) {
                var i = r(e),
                        a = t.isArray(n) ? n : n.split(" ");
                o(e, t.difference(i, a).join(" "))
            }, i.replaceClass = function(e, t, n) {
                var i = e.className || "";
                t.test(i) ? i = i.replace(t, n) : n && (i += " " + n), o(e, i)
            }, i.toggleClass = function(e, n, r) {
                var o = i.hasClass(e, n);
                r = t.isBoolean(r) ? r : !o, r !== o && (r ? i.addClass(e, n) : i.removeClass(e, n))
            }, i.emptyElement = function(e) {
                for (; e.firstChild;) e.removeChild(e.firstChild)
            }, i.addStyleSheet = function(e) {
                var t = document.createElement("link");
                t.rel = "stylesheet", t.href = e, document.getElementsByTagName("head")[0].appendChild(t)
            }, i.empty = function(e) {
                if (e)
                    for (; e.childElementCount > 0;) e.removeChild(e.children[0])
            }, i.bounds = function(e) {
                var t = {
                    left: 0,
                    right: 0,
                    width: 0,
                    height: 0,
                    top: 0,
                    bottom: 0
                };
                if (!e || !document.body.contains(e)) return t;
                var n = e.getBoundingClientRect(e),
                        i = window.pageYOffset,
                        r = window.pageXOffset;
                return n.width || n.height || n.left || n.top ? (t.left = n.left + r, t.right = n.right + r, t.top = n.top + i, t.bottom = n.bottom + i, t.width = n.right - n.left, t.height = n.bottom - n.top, t) : t
            }, i
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(3), n(1)], r = function(e, t) {
            function n() {}
            var i = function(e, n) {
                var i, r = this;
                i = e && t.has(e, "constructor") ? e.constructor : function() {
                    return r.apply(this, arguments)
                }, t.extend(i, r, n);
                var o = function() {
                    this.constructor = i
                };
                return o.prototype = r.prototype, i.prototype = new o, e && t.extend(i.prototype, e), i.__super__ = r.prototype, i
            };
            return n.extend = i, t.extend(n.prototype, e), n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(44), n(1), n(87), n(86), n(33)], r = function(e, t, n, i, r) {
            var o = {};
            return o.repo = t.memoize(function() {
                var t = r.split("+")[0],
                        i = e.repo + t + "/";
                return n.isHTTPS() ? i.replace(/^http:/, "https:") : i
            }), o.versionCheck = function(e) {
                var t = ("0" + e).split(/\W/),
                        n = r.split(/\W/),
                        i = parseFloat(t[0]),
                        o = parseFloat(n[0]);
                return i > o ? !1 : !(i === o && parseFloat("0" + t[1]) > parseFloat(n[1]))
            }, o.loadFrom = function() {
                return o.repo()
            }, o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = function() {
                var t = {},
                        n = {},
                        i = {},
                        r = {};
                return {
                    start: function(n) {
                        t[n] = e.now(), i[n] = i[n] + 1 || 1
                    },
                    end: function(i) {
                        if (t[i]) {
                            var r = e.now() - t[i];
                            n[i] = n[i] + r || r
                        }
                    },
                    dump: function() {
                        return {
                            counts: i,
                            sums: n,
                            events: r
                        }
                    },
                    tick: function(t, n) {
                        r[t] = n || e.now()
                    },
                    between: function(e, t) {
                        return r[t] && r[e] ? r[t] - r[e] : -1
                    }
                }
            };
            return t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            var e = function(e, n, i) {
                        if (n = n || this, i = i || [], window.jwplayer && window.jwplayer.debug) return e.apply(n, i);
                        try {
                            return e.apply(n, i)
                        } catch (r) {
                            return new t(e.name, r)
                        }
                    },
                    t = function(e, t) {
                        this.name = e, this.message = t.message || t.toString(), this.error = t
                    };
            return {
                tryCatch: e,
                Error: t
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            return document.createElement("video")
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , function(e, t, n) {
        var i, r;
        i = [n(266), n(41), n(1)], r = function(e, t, n) {
            var i = e.selectPlayer,
                    r = function() {
                        var e = i.apply(this, arguments);
                        return e ? e : {
                            registerPlugin: function(e, n, i) {
                                "jwpsrv" !== e && t.registerPlugin(e, n, i)
                            }
                        }
                    };
            return n.extend(e, {
                selectPlayer: r
            })
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , function(e, t, n) {
        var i, r;
        i = [n(2), n(142), n(48)], r = function(e, t, n) {
            var i = "invalid",
                    r = "RnXcsftYjWRDA^Uy",
                    o = function(o) {
                        function a(o) {
                            e.exists(o) || (o = "");
                            try {
                                o = t.decrypt(o, r);
                                var a = o.split("/");
                                s = a[0], "pro" === s && (s = "premium");
                                var u = n(s);
                                if (a.length > 2 && u("setup")) {
                                    l = a[1];
                                    var d = parseInt(a[2]);
                                    d > 0 && (c = new Date, c.setTime(d))
                                } else s = i
                            } catch (p) {
                                s = i
                            }
                        }
                        var s, l, c;
                        this.edition = function() {
                            return c && c.getTime() < (new Date).getTime() ? i : s
                        }, this.token = function() {
                            return l
                        }, this.expiration = function() {
                            return c
                        }, a(o)
                    };
            return o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            var e = function(e) {
                        return window.atob(e)
                    },
                    t = function(e) {
                        return unescape(encodeURIComponent(e))
                    },
                    n = function(e) {
                        try {
                            return decodeURIComponent(escape(e))
                        } catch (t) {
                            return e
                        }
                    },
                    i = function(e) {
                        for (var t = new Array(Math.ceil(e.length / 4)), n = 0; n < t.length; n++) t[n] = e.charCodeAt(4 * n) + (e.charCodeAt(4 * n + 1) << 8) + (e.charCodeAt(4 * n + 2) << 16) + (e.charCodeAt(4 * n + 3) << 24);
                        return t
                    },
                    r = function(e) {
                        for (var t = new Array(e.length), n = 0; n < e.length; n++) t[n] = String.fromCharCode(255 & e[n], e[n] >>> 8 & 255, e[n] >>> 16 & 255, e[n] >>> 24 & 255);
                        return t.join("")
                    };
            return {
                decrypt: function(o, a) {
                    if (o = String(o), a = String(a), 0 == o.length) return "";
                    for (var s, l, c = i(e(o)), u = i(t(a).slice(0, 16)), d = c.length, p = c[d - 1], f = c[0], h = 2654435769, g = Math.floor(6 + 52 / d), m = g * h; 0 != m;) {
                        l = m >>> 2 & 3;
                        for (var v = d - 1; v >= 0; v--) p = c[v > 0 ? v - 1 : d - 1], s = (p >>> 5 ^ f << 2) + (f >>> 3 ^ p << 4) ^ (m ^ f) + (u[3 & v ^ l] ^ p), f = c[v] -= s;
                        m -= h
                    }
                    var w = r(c);
                    return w = w.replace(/\0+$/, ""), n(w)
                }
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(305), n(4), n(321)], r = function(e, t, n) {
            var i = function(i, r) {
                var o = new e(i, r),
                        a = o.setup;
                return o.setup = function() {
                    if (a.call(this), "trial" === r.get("edition")) {
                        var e = document.createElement("div");
                        e.className = "jw-icon jw-watermark", this.element().appendChild(e)
                    }
                    r.on("change:skipButton", this.onSkipButton, this), r.on("change:castActive change:playlistItem", this.showDisplayIconImage, this)
                }, o.showDisplayIconImage = function(e) {
                    var t = e.get("castActive"),
                            n = e.get("playlistItem"),
                            i = o.controlsContainer().getElementsByClassName("jw-display-icon-container")[0];
                    t && n && n.image ? (i.style.backgroundImage = 'url("' + n.image + '")', i.style.backgroundSize = "contain") : (i.style.backgroundImage = "", i.style.backgroundSize = "")
                }, o.onSkipButton = function(e, t) {
                    t ? this.addSkipButton() : this._skipButton && (this._skipButton.destroy(), this._skipButton = null)
                }, o.addSkipButton = function() {
                    this._skipButton = new n(this.instreamModel), this._skipButton.on(t.JWPLAYER_AD_SKIPPED, function() {
                        this.api.skipAd()
                    }, this), this.controlsContainer().appendChild(this._skipButton.element())
                }, o
            };
            return i
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , function(e, t, n) {
        t = e.exports = n(233)(), t.push([e.id, ".jw-reset{color:inherit;background-color:transparent;padding:0;margin:0;float:none;font-family:Arial,Helvetica,sans-serif;font-size:1em;line-height:1em;list-style:none;text-align:left;text-transform:none;vertical-align:baseline;border:0;direction:ltr;font-variant:inherit;font-stretch:inherit;-webkit-tap-highlight-color:rgba(255,255,255,0)}@font-face{font-family:jw-icons;src:url(" + n(235) + ") format('woff'),url(" + n(234) + ') format(\'truetype\');font-weight:400;font-style:normal}.jw-controlbar .jw-menu .jw-option:before,.jw-icon-display,.jw-icon-inline,.jw-icon-tooltip{font-family:jw-icons;-webkit-font-smoothing:antialiased;font-style:normal;font-weight:400;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}.jw-icon-audio-tracks:before{content:"\\E600"}.jw-icon-buffer:before{content:"\\E601"}.jw-icon-cast:before{content:"\\E603"}.jw-icon-cast.jw-off:before{content:"\\E602"}.jw-icon-cc:before{content:"\\E605"}.jw-icon-cue:before,.jw-icon-menu-bullet:before{content:"\\E606"}.jw-icon-error:before{content:"\\E607"}.jw-icon-fullscreen:before{content:"\\E608"}.jw-icon-fullscreen.jw-off:before{content:"\\E613"}.jw-icon-hd:before{content:"\\E60A"}.jw-rightclick-logo:before,.jw-watermark:before{content:"\\E60B"}.jw-icon-next:before{content:"\\E60C"}.jw-icon-pause:before{content:"\\E60D"}.jw-icon-play:before{content:"\\E60E"}.jw-icon-prev:before{content:"\\E60F"}.jw-icon-replay:before{content:"\\E610"}.jw-icon-volume:before{content:"\\E612"}.jw-icon-volume.jw-off:before{content:"\\E611"}.jw-icon-more:before{content:"\\E614"}.jw-icon-close:before{content:"\\E615"}.jw-icon-playlist:before{content:"\\E616"}.jwplayer{width:100%;font-size:16px;position:relative;display:block;min-height:0;overflow:hidden;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif;background-color:#000;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.jwplayer *{box-sizing:inherit}.jwplayer.jw-flag-aspect-mode{height:auto!important}.jwplayer.jw-flag-aspect-mode .jw-aspect{display:block}.jwplayer .jw-aspect{display:none}.jwplayer.jw-no-focus:focus,.jwplayer .jw-swf{outline:none}.jwplayer.jw-ie:focus{outline:1px dotted #585858}.jwplayer:hover .jw-display-icon-container{background-color:#333;background:#333;background-size:#333}.jw-controls,.jw-media,.jw-overlays,.jw-preview{position:absolute;width:100%;height:100%;top:0;left:0;bottom:0;right:0}.jw-media{overflow:hidden;cursor:pointer}.jw-overlays{cursor:auto}.jw-media.jw-media-show{visibility:visible;opacity:1}.jw-controls.jw-controls-disabled{display:none}.jw-controls .jw-controls-right{position:absolute;top:0;right:0;left:0;bottom:2em}.jw-text{height:1em;font-family:Arial,Helvetica,sans-serif;font-size:.75em;font-style:normal;font-weight:400;color:#fff;text-align:center;font-variant:normal;font-stretch:normal}.jw-plugin{position:absolute;bottom:2.5em}.jw-plugin .jw-banner{max-width:100%;opacity:0;cursor:pointer;position:absolute;margin:auto auto 0;left:0;right:0;bottom:0;display:block}.jw-cast-screen{width:100%;height:100%}.jw-instream{position:absolute;top:0;right:0;bottom:0;left:0;display:none}.jw-icon-playback:before{content:"\\E60E"}.jw-captions,.jw-controls,.jw-overlays,.jw-preview,.jw-title{pointer-events:none}.jw-controlbar,.jw-display-icon-container,.jw-dock,.jw-logo,.jw-media,.jw-overlays>div,.jw-skip{pointer-events:all}.jwplayer video{position:absolute;top:0;right:0;bottom:0;left:0;width:100%;height:100%;margin:auto;background:transparent}.jwplayer video::-webkit-media-controls-start-playback-button{display:none}.jwplayer video::-webkit-media-text-track-display{-webkit-transform:translateY(-1.5em);transform:translateY(-1.5em)}.jwplayer.jw-flag-user-inactive.jw-state-playing video::-webkit-media-text-track-display{-webkit-transform:translateY(0);transform:translateY(0)}.jwplayer.jw-stretch-uniform video{-o-object-fit:contain;object-fit:contain}.jwplayer.jw-stretch-none video{-o-object-fit:none;object-fit:none}.jwplayer.jw-stretch-fill video{-o-object-fit:cover;object-fit:cover}.jwplayer.jw-stretch-exactfit video{-o-object-fit:fill;object-fit:fill}.jw-click,.jw-preview{position:absolute;width:100%;height:100%}.jw-preview{display:none;opacity:1;visibility:visible;background:#000 no-repeat 50% 50%}.jw-error .jw-preview,.jw-stretch-uniform .jw-preview,.jwplayer .jw-preview{background-size:contain}.jw-stretch-none .jw-preview{background-size:auto auto}.jw-stretch-fill .jw-preview{background-size:cover}.jw-stretch-exactfit .jw-preview{background-size:100% 100%}.jw-display-icon-container{position:relative;top:50%;display:table;height:3.5em;width:3.5em;margin:-1.75em auto 0;cursor:pointer}.jw-display-icon-container .jw-icon-display{position:relative;display:table-cell;text-align:center;vertical-align:middle!important;background-position:50% 50%;background-repeat:no-repeat;font-size:2em}.jw-flag-audio-player .jw-display-icon-container,.jw-flag-dragging .jw-display-icon-container{display:none}.jw-icon{font-family:jw-icons;-webkit-font-smoothing:antialiased;font-style:normal;font-weight:400;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}.jw-controlbar{display:table;position:absolute;right:0;left:0;bottom:0;height:2em;padding:0 .25em}.jw-controlbar .jw-hidden{display:none}.jw-controlbar.jw-drawer-expanded .jw-controlbar-center-group,.jw-controlbar.jw-drawer-expanded .jw-controlbar-left-group{opacity:0}.jw-background-color{background-color:#414040}.jw-group{display:table-cell}.jw-controlbar-center-group{width:100%;padding:0 .25em}.jw-controlbar-center-group .jw-slider-time,.jw-controlbar-center-group .jw-text-alt{padding:0}.jw-controlbar-center-group .jw-text-alt{display:none}.jw-controlbar-left-group,.jw-controlbar-right-group{white-space:nowrap}.jw-icon-display:hover,.jw-icon-inline:hover,.jw-icon-tooltip:hover,.jw-knob:hover,.jw-option:before:hover{color:#eee}.jw-icon-inline,.jw-icon-tooltip,.jw-slider-horizontal,.jw-text-duration,.jw-text-elapsed{display:inline-block;height:2em;position:relative;line-height:2em;vertical-align:middle;cursor:pointer}.jw-icon-inline,.jw-icon-tooltip{min-width:1.25em;text-align:center}.jw-icon-playback{min-width:2.25em}.jw-icon-volume{min-width:1.75em;text-align:left}.jw-time-tip{line-height:1em;pointer-events:none}.jw-icon-inline:after,.jw-icon-tooltip:after{width:100%;height:100%;font-size:1em}.jw-icon-cast,.jw-icon-inline.jw-icon-volume,.jw-slider-volume.jw-slider-horizontal{display:none}.jw-dock{margin:.75em;display:block;opacity:1;clear:right}.jw-dock:after{content:\'\';clear:both;display:block}.jw-dock-button{cursor:pointer;float:right;position:relative;width:2.5em;height:2.5em;margin:.5em}.jw-dock-button .jw-arrow{display:none;position:absolute;bottom:-.2em;width:.5em;height:.2em;left:50%;margin-left:-.25em}.jw-dock-button .jw-overlay{display:none;position:absolute;top:2.5em;right:0;margin-top:.25em;padding:.5em;white-space:nowrap}.jw-dock-button:hover .jw-arrow,.jw-dock-button:hover .jw-overlay{display:block}.jw-dock-image{width:100%;height:100%;background-position:50% 50%;background-repeat:no-repeat;opacity:.75}.jw-title{display:none;position:absolute;top:0;width:100%;font-size:.875em;height:8em;background:-webkit-linear-gradient(top,#000,#000 18%,transparent);background:linear-gradient(180deg,#000 0,#000 18%,transparent)}.jw-title-primary,.jw-title-secondary{padding:.75em 1.5em;min-height:2.5em;width:100%;color:#fff;white-space:nowrap;text-overflow:ellipsis;overflow-x:hidden}.jw-title-primary{font-weight:700}.jw-title-secondary{margin-top:-.5em}.jw-slider-container{display:inline-block;height:1em;position:relative;touch-action:none}.jw-buffer,.jw-progress,.jw-rail{position:absolute;cursor:pointer}.jw-progress{background-color:#fff}.jw-rail{background-color:#aaa}.jw-buffer{background-color:#202020}.jw-cue,.jw-knob{position:absolute;cursor:pointer}.jw-cue{background-color:#fff;width:.1em;height:.4em}.jw-knob{background-color:#aaa;width:.4em;height:.4em}.jw-slider-horizontal{width:4em;height:1em}.jw-slider-horizontal.jw-slider-volume{margin-right:5px}.jw-slider-horizontal .jw-buffer,.jw-slider-horizontal .jw-progress,.jw-slider-horizontal .jw-rail{width:100%;height:.4em}.jw-slider-horizontal .jw-buffer,.jw-slider-horizontal .jw-progress{width:0}.jw-slider-horizontal .jw-progress,.jw-slider-horizontal .jw-rail,.jw-slider-horizontal .jw-slider-container{width:100%}.jw-slider-horizontal .jw-knob{left:0;margin-left:-.325em}.jw-slider-vertical{width:.75em;height:4em;bottom:0;position:absolute;padding:1em}.jw-slider-vertical .jw-buffer,.jw-slider-vertical .jw-progress,.jw-slider-vertical .jw-rail{bottom:0;height:100%}.jw-slider-vertical .jw-buffer,.jw-slider-vertical .jw-progress{height:0}.jw-slider-vertical .jw-progress,.jw-slider-vertical .jw-rail,.jw-slider-vertical .jw-slider-container{bottom:0;width:.75em;height:100%;left:0;right:0;margin:0 auto}.jw-slider-vertical .jw-slider-container{height:4em;position:relative}.jw-slider-vertical .jw-knob{bottom:0;left:0;right:0;margin:0 auto}.jw-slider-time{right:0;left:0;width:100%}.jw-tooltip-time{position:absolute}.jw-slider-volume .jw-buffer{display:none}.jw-captions{position:absolute;display:none;margin:0 auto;width:100%;left:0;bottom:3em;right:0;max-width:90%;text-align:center}.jw-captions.jw-captions-enabled{display:block}.jw-captions-window{display:none;padding:.25em;border-radius:.25em}.jw-captions-text,.jw-captions-window.jw-captions-window-active{display:inline-block}.jw-captions-text{color:#fff;background-color:#000;word-wrap:break-word;white-space:pre-line;font-style:normal;font-weight:400;text-align:center;text-decoration:none;line-height:1.3em;padding:.1em .8em}.jwplayer video::-webkit-media-text-track-container{bottom:1.5em}.jwplayer.jw-flag-compact-player video::-webkit-media-text-track-container{bottom:2.5em}.jw-rightclick{display:none;position:absolute;white-space:nowrap}.jw-rightclick.jw-open{display:block}.jw-rightclick ul{list-style:none;font-weight:700;border-radius:.15em;margin:0;border:1px solid #444;padding:0}.jw-rightclick .jw-rightclick-logo{font-size:2em;color:#ff0147;vertical-align:middle;padding-right:.3em;margin-right:.3em;border-right:1px solid #444}.jw-rightclick li{background-color:#000;border-bottom:1px solid #444;margin:0}.jw-rightclick a{color:#fff;text-decoration:none;padding:1em;display:block;font-size:.6875em}.jw-rightclick li:last-child{border-bottom:none}.jw-rightclick li:hover{background-color:#1a1a1a;cursor:pointer}.jw-rightclick .jw-featured{background-color:#252525;vertical-align:middle}.jw-rightclick .jw-featured a{color:#777}.jw-logo{position:absolute;margin:.75em;cursor:pointer;pointer-events:all;background-repeat:no-repeat;background-size:contain;top:auto;right:auto;left:auto;bottom:auto}.jw-logo .jw-flag-audio-player{display:none}.jw-logo-top-right{top:0;right:0}.jw-logo-top-left{top:0;left:0}.jw-logo-bottom-left{bottom:0;left:0}.jw-logo-bottom-right,.jw-watermark{bottom:0;right:0}.jw-watermark{position:absolute;top:50%;left:0;text-align:center;font-size:14em;color:#eee;opacity:.33;pointer-events:none}.jw-icon-tooltip.jw-open .jw-overlay{opacity:1;visibility:visible}.jw-icon-tooltip.jw-hidden,.jw-icon-tooltip.jw-open-drawer:before,.jw-overlay-horizontal{display:none}.jw-icon-tooltip.jw-open-drawer .jw-overlay-horizontal{opacity:1;display:inline-block;vertical-align:top}.jw-overlay:before{position:absolute;top:0;bottom:0;left:-50%;width:100%;background-color:transparent;content:" "}.jw-slider-time .jw-overlay:before{height:1em;top:auto}.jw-menu,.jw-time-tip,.jw-volume-tip{position:relative;left:-50%;border:1px solid #000;margin:0}.jw-volume-tip{width:100%;height:100%;display:block}.jw-time-tip{text-align:center;font-family:inherit;color:#aaa;bottom:1em;border:4px solid #000}.jw-time-tip .jw-text{line-height:1em}.jw-controlbar .jw-overlay{margin:0;position:absolute;bottom:2em;left:50%;opacity:0;visibility:hidden}.jw-controlbar .jw-overlay .jw-contents{position:relative}.jw-controlbar .jw-option{position:relative;white-space:nowrap;cursor:pointer;list-style:none;height:1.5em;font-family:inherit;line-height:1.5em;color:#aaa;padding:0 .5em;font-size:.8em}.jw-controlbar .jw-option:before:hover,.jw-controlbar .jw-option:hover{color:#eee}.jw-controlbar .jw-option:before{padding-right:.125em}.jw-playlist-container ::-webkit-scrollbar-track{background-color:#333;border-radius:10px}.jw-playlist-container ::-webkit-scrollbar{width:5px;border:10px solid #000;border-bottom:0;border-top:0}.jw-playlist-container ::-webkit-scrollbar-thumb{background-color:#fff;border-radius:5px}.jw-tooltip-title{border-bottom:1px solid #444;text-align:left;padding-left:.7em}.jw-playlist{max-height:11em;min-height:4.5em;overflow-x:hidden;overflow-y:scroll;width:calc(100% - 4px)}.jw-playlist .jw-option{height:3em;margin-right:5px;color:#fff;padding-left:1em;font-size:.8em}.jw-playlist .jw-label,.jw-playlist .jw-name{display:inline-block;line-height:3em;text-align:left;overflow:hidden;white-space:nowrap}.jw-playlist .jw-label{width:1em}.jw-playlist .jw-name{width:11em}.jw-skip{cursor:default;position:absolute;float:right;display:inline-block;right:.75em;bottom:3em}.jw-skip.jw-skippable{cursor:pointer}.jw-skip.jw-hidden{visibility:hidden}.jw-skip .jw-skip-icon{display:none;margin-left:-.75em}.jw-skip .jw-skip-icon:before{content:"\\E60C"}.jw-skip .jw-skip-icon,.jw-skip .jw-text{color:#aaa;vertical-align:middle;line-height:1.5em;font-size:.7em}.jw-skip.jw-skippable:hover{cursor:pointer}.jw-skip.jw-skippable:hover .jw-skip-icon,.jw-skip.jw-skippable:hover .jw-text{color:#eee}.jw-skip.jw-skippable .jw-skip-icon{display:inline;margin:0}.jwplayer.jw-state-paused.jw-flag-casting .jw-display-icon-container,.jwplayer.jw-state-playing.jw-flag-casting .jw-display-icon-container{display:table}.jwplayer.jw-flag-casting .jw-display-icon-container{border-radius:0;border:1px solid #fff;position:absolute;top:auto;left:.5em;right:.5em;bottom:50%;margin-bottom:-12.5%;height:50%;width:50%;padding:0;background-repeat:no-repeat;background-position:50%}.jwplayer.jw-flag-casting .jw-display-icon-container .jw-icon{font-size:3em}.jwplayer.jw-flag-casting.jw-state-complete .jw-preview{display:none}.jw-cast{position:absolute;width:100%;height:100%;background-repeat:no-repeat;background-size:auto;background-position:50% 50%}.jw-cast-label{position:absolute;left:.5em;right:.5em;bottom:75%;margin-bottom:1.5em;text-align:center}.jw-cast-name{color:#ccc}.jw-state-idle .jw-preview{display:block}.jw-state-idle .jw-icon-display:before{content:"\\E60E"}.jw-state-idle .jw-captions,.jw-state-idle .jw-controlbar{display:none}.jw-state-idle .jw-title{display:block}.jwplayer.jw-state-playing .jw-display-icon-container{display:none}.jwplayer.jw-state-playing .jw-display-icon-container .jw-icon-display:before,.jwplayer.jw-state-playing .jw-icon-playback:before{content:"\\E60D"}.jwplayer.jw-state-paused .jw-display-icon-container{display:none}.jwplayer.jw-state-paused .jw-display-icon-container .jw-icon-display:before,.jwplayer.jw-state-paused .jw-icon-playback:before{content:"\\E60E"}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-icon-display{-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-icon-display:before{content:"\\E601"}@-webkit-keyframes spin{to{-webkit-transform:rotate(1turn)}}@keyframes spin{to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.jwplayer.jw-state-buffering .jw-display-icon-container .jw-text{display:none}.jwplayer.jw-state-buffering .jw-icon-playback:before{content:"\\E60D"}.jwplayer.jw-state-complete .jw-preview{display:block}.jwplayer.jw-state-complete .jw-display-icon-container .jw-icon-display:before{content:"\\E610"}.jwplayer.jw-state-complete .jw-display-icon-container .jw-text{display:none}.jwplayer.jw-state-complete .jw-icon-playback:before{content:"\\E60E"}.jwplayer.jw-state-complete .jw-captions{display:none}.jwplayer.jw-state-error .jw-title,body .jw-error .jw-title{display:block}.jwplayer.jw-state-error .jw-title .jw-title-primary,body .jw-error .jw-title .jw-title-primary{white-space:normal}.jwplayer.jw-state-error .jw-preview,body .jw-error .jw-preview{display:block}.jwplayer.jw-state-error .jw-captions,.jwplayer.jw-state-error .jw-controlbar,body .jw-error .jw-captions,body .jw-error .jw-controlbar{display:none}.jwplayer.jw-state-error:hover .jw-display-icon-container,body .jw-error:hover .jw-display-icon-container{cursor:default;color:#fff;background:#000}.jwplayer.jw-state-error .jw-icon-display,body .jw-error .jw-icon-display{cursor:default;font-family:jw-icons;-webkit-font-smoothing:antialiased;font-style:normal;font-weight:400;text-transform:none;background-color:transparent;font-variant:normal;-webkit-font-feature-settings:"liga";-ms-font-feature-settings:"liga" 1;-o-font-feature-settings:"liga";font-feature-settings:"liga";-moz-osx-font-smoothing:grayscale}.jwplayer.jw-state-error .jw-icon-display:before,body .jw-error .jw-icon-display:before{content:"\\E607"}.jwplayer.jw-state-error .jw-icon-display:hover,body .jw-error .jw-icon-display:hover{color:#fff}body .jw-error{font-size:16px;background-color:#000;color:#eee;width:100%;height:100%;display:table;opacity:1;position:relative}body .jw-error .jw-icon-container{position:absolute;width:100%;height:100%;top:0;left:0;bottom:0;right:0}.jwplayer.jw-flag-cast-available .jw-controlbar{display:table}.jwplayer.jw-flag-cast-available .jw-icon-cast{display:inline-block}.jwplayer.jw-flag-skin-loading .jw-captions,.jwplayer.jw-flag-skin-loading .jw-controls,.jwplayer.jw-flag-skin-loading .jw-title{display:none}.jwplayer.jw-flag-fullscreen{width:100%!important;height:100%!important;top:0;right:0;bottom:0;left:0;z-index:1000;margin:0;position:fixed}.jwplayer.jw-flag-live .jw-controlbar .jw-slider-time,.jwplayer.jw-flag-live .jw-controlbar .jw-text-duration,.jwplayer.jw-flag-live .jw-controlbar .jw-text-elapsed{display:none}.jwplayer.jw-flag-live .jw-controlbar .jw-text-alt{display:inline}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-controlbar,.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-dock,.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-logo.jw-hide{display:none}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-captions,.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-plugin{bottom:.5em}.jwplayer.jw-flag-user-inactive.jw-state-playing .jw-media{cursor:none;-webkit-cursor-visibility:auto-hide}.jwplayer.jw-flag-user-inactive.jw-state-playing video::-webkit-media-text-track-container{bottom:.5em}.jwplayer.jw-flag-user-inactive.jw-state-buffering .jw-controlbar{display:none}.jwplayer.jw-flag-media-audio .jw-controlbar{display:table}.jwplayer.jw-flag-media-audio.jw-flag-user-inactive .jw-controlbar{display:none}.jwplayer.jw-flag-media-audio.jw-flag-user-inactive.jw-state-playing .jw-captions,.jwplayer.jw-flag-media-audio.jw-flag-user-inactive.jw-state-playing .jw-plugin{bottom:3em}.jwplayer.jw-flag-media-audio.jw-flag-user-inactive.jw-state-playing video::-webkit-media-text-track-container{bottom:3em}.jw-flag-media-audio .jw-preview{display:block}.jwplayer.jw-flag-ads .jw-captions.jw-captions-enabled,.jwplayer.jw-flag-ads .jw-dock,.jwplayer.jw-flag-ads .jw-logo,.jwplayer.jw-flag-ads .jw-preview{display:none}.jwplayer.jw-flag-ads video::-webkit-media-text-track-container{display:none}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-inline,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-tooltip,.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-horizontal,.jwplayer.jw-flag-ads .jw-controlbar .jw-text{display:none}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-fullscreen,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-playback,.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-volume,.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-volume{display:inline-block}.jwplayer.jw-flag-ads .jw-controlbar .jw-text-alt{display:inline}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-inline.jw-icon-volume,.jwplayer.jw-flag-ads .jw-controlbar .jw-slider-volume.jw-slider-horizontal{display:inline-block}.jwplayer.jw-flag-ads .jw-controlbar .jw-icon-tooltip.jw-icon-volume{display:none}.jwplayer.jw-flag-ads-googleima .jw-controlbar{display:table;bottom:0}.jwplayer.jw-flag-ads-googleima.jw-flag-touch .jw-controlbar{font-size:1em}.jwplayer.jw-flag-ads-googleima.jw-flag-touch.jw-state-paused .jw-display-icon-container{display:none}.jwplayer.jw-flag-ads-googleima.jw-skin-seven .jw-controlbar{font-size:.9em}.jwplayer.jw-flag-ads-vpaid .jw-controlbar{display:none}.jwplayer.jw-flag-ads-hide-controls .jw-controls{display:none!important}.jwplayer.jw-flag-ads.jw-flag-touch .jw-controlbar{display:table}.jwplayer.jw-flag-overlay-open-related .jw-controls,.jwplayer.jw-flag-overlay-open-related .jw-title,.jwplayer.jw-flag-overlay-open-sharing .jw-controls,.jwplayer.jw-flag-overlay-open-sharing .jw-title,.jwplayer.jw-flag-overlay-open .jw-controls-right .jw-logo,.jwplayer.jw-flag-overlay-open .jw-title{display:none}.jwplayer.jw-flag-rightclick-open{overflow:visible}.jwplayer.jw-flag-rightclick-open .jw-rightclick{z-index:16777215}.jw-flag-controls-disabled .jw-controls{visibility:hidden}.jw-flag-controls-disabled .jw-logo{visibility:visible}.jw-flag-controls-disabled .jw-media{cursor:auto}body .jwplayer.jw-flag-flash-blocked .jw-title{display:block}body .jwplayer.jw-flag-flash-blocked .jw-controls,body .jwplayer.jw-flag-flash-blocked .jw-overlays,body .jwplayer.jw-flag-flash-blocked .jw-preview{display:none}.jw-flag-touch .jw-controlbar,.jw-flag-touch .jw-plugin,.jw-flag-touch .jw-skip{font-size:1.5em}.jw-flag-touch .jw-captions{bottom:4.25em}.jw-flag-touch video::-webkit-media-text-track-container{bottom:4.25em}.jw-flag-touch .jw-icon-tooltip.jw-open-drawer:before{display:inline;content:"\\E615"}.jw-flag-touch .jw-display-icon-container{pointer-events:none}.jw-flag-touch.jw-state-paused .jw-display-icon-container{display:table}.jw-flag-compact-player .jw-icon-playlist,.jw-flag-compact-player .jw-text-duration,.jw-flag-compact-player .jw-text-elapsed,.jw-flag-touch.jw-state-paused.jw-flag-dragging .jw-display-icon-container{display:none}.jwplayer.jw-flag-audio-player{background-color:transparent}.jwplayer.jw-flag-audio-player .jw-media{visibility:hidden}.jwplayer.jw-flag-audio-player .jw-media object{width:1px;height:1px}.jwplayer.jw-flag-audio-player .jw-display-icon-container,.jwplayer.jw-flag-audio-player .jw-preview{display:none}.jwplayer.jw-flag-audio-player .jw-controlbar{display:table;height:auto;left:0;bottom:0;margin:0;width:100%;min-width:100%;opacity:1}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-fullscreen,.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-tooltip{display:none}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-inline.jw-icon-volume,.jwplayer.jw-flag-audio-player .jw-controlbar .jw-slider-volume.jw-slider-horizontal{display:inline-block}.jwplayer.jw-flag-audio-player .jw-controlbar .jw-icon-tooltip.jw-icon-volume{display:none}.jwplayer.jw-flag-audio-player.jw-flag-user-inactive .jw-controlbar{display:table}.jw-skin-seven .jw-background-color{background:#000}.jw-skin-seven .jw-controlbar{border-top:1px solid #333;height:2.5em}.jw-skin-seven .jw-group{vertical-align:middle}.jw-skin-seven .jw-playlist{background-color:rgba(0,0,0,.5)}.jw-skin-seven .jw-playlist-container{left:-43%;background-color:rgba(0,0,0,.5)}.jw-skin-seven .jw-playlist-container .jw-option{border-bottom:1px solid #444}.jw-skin-seven .jw-playlist-container .jw-option.jw-active-option,.jw-skin-seven .jw-playlist-container .jw-option:hover{background-color:#000}.jw-skin-seven .jw-playlist-container .jw-option:hover .jw-label{color:#ff0046}.jw-skin-seven .jw-playlist-container .jw-icon-playlist{margin-left:0}.jw-skin-seven .jw-playlist-container .jw-label .jw-icon-play{color:#ff0046}.jw-skin-seven .jw-playlist-container .jw-label .jw-icon-play:before{padding-left:0}.jw-skin-seven .jw-tooltip-title{background-color:#000;color:#fff}.jw-skin-seven .jw-button-color,.jw-skin-seven .jw-text{color:#fff}.jw-skin-seven .jw-button-color:hover,.jw-skin-seven .jw-toggle{color:#ff0046}.jw-skin-seven .jw-toggle.jw-off{color:#fff}.jw-skin-seven .jw-controlbar .jw-icon:before,.jw-skin-seven .jw-text-duration,.jw-skin-seven .jw-text-elapsed{padding:0 .7em}.jw-skin-seven .jw-controlbar .jw-icon-prev:before{padding-right:.25em}.jw-skin-seven .jw-controlbar .jw-icon-playlist:before{padding:0 .45em}.jw-skin-seven .jw-controlbar .jw-icon-next:before{padding-left:.25em}.jw-skin-seven .jw-icon-next,.jw-skin-seven .jw-icon-prev{font-size:.7em}.jw-skin-seven .jw-icon-prev:before{border-left:1px solid #666}.jw-skin-seven .jw-icon-next:before{border-right:1px solid #666}.jw-skin-seven .jw-icon-display{color:#fff}.jw-skin-seven .jw-icon-display:before{padding-left:0}.jw-skin-seven .jw-display-icon-container{border-radius:50%;border:1px solid #333}.jw-skin-seven .jw-rail{background-color:#384154;box-shadow:none}.jw-skin-seven .jw-buffer{background-color:#666f82}.jw-skin-seven .jw-progress{background:#ff0046}.jw-skin-seven .jw-knob{width:.6em;height:.6em;background-color:#fff;box-shadow:0 0 0 1px #000;border-radius:1em}.jw-skin-seven .jw-slider-horizontal .jw-slider-container{height:.95em}.jw-skin-seven .jw-slider-horizontal .jw-buffer,.jw-skin-seven .jw-slider-horizontal .jw-progress,.jw-skin-seven .jw-slider-horizontal .jw-rail{height:.2em;border-radius:0}.jw-skin-seven .jw-slider-horizontal .jw-knob{top:-.2em}.jw-skin-seven .jw-slider-horizontal .jw-cue{top:-.05em;width:.3em;height:.3em;background-color:#fff;border-radius:50%}.jw-skin-seven .jw-slider-vertical .jw-buffer,.jw-skin-seven .jw-slider-vertical .jw-progress,.jw-skin-seven .jw-slider-vertical .jw-rail{width:.2em}.jw-skin-seven .jw-slider-vertical .jw-knob{margin-bottom:-.3em}.jw-skin-seven .jw-volume-tip{width:100%;left:-45%;padding-bottom:.7em}.jw-skin-seven .jw-text-duration{color:#666f82}.jw-skin-seven .jw-controlbar-right-group .jw-icon-inline:before,.jw-skin-seven .jw-controlbar-right-group .jw-icon-tooltip:before{border-left:1px solid #666}.jw-skin-seven .jw-controlbar-right-group .jw-icon-inline:first-child:before{border:none}.jw-skin-seven .jw-dock .jw-dock-button{border-radius:50%;border:1px solid #333}.jw-skin-seven .jw-dock .jw-overlay{border-radius:2.5em}.jw-skin-seven .jw-icon-tooltip .jw-active-option{background-color:#ff0046;color:#fff}.jw-skin-seven .jw-icon-volume{min-width:2.6em}.jw-skin-seven .jw-menu,.jw-skin-seven .jw-skip,.jw-skin-seven .jw-time-tip,.jw-skin-seven .jw-volume-tip{border:1px solid #333}.jw-skin-seven .jw-time-tip{padding:.2em;bottom:1.3em}.jw-skin-seven .jw-menu,.jw-skin-seven .jw-volume-tip{bottom:.24em}.jw-skin-seven .jw-skip{padding:.4em;border-radius:1.75em}.jw-skin-seven .jw-skip .jw-icon-inline,.jw-skin-seven .jw-skip .jw-text{color:#fff;line-height:1.75em}.jw-skin-seven .jw-skip.jw-skippable:hover .jw-icon-inline,.jw-skin-seven .jw-skip.jw-skippable:hover .jw-text{color:#ff0046}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon:before,.jw-skin-seven.jw-flag-touch .jw-text-duration,.jw-skin-seven.jw-flag-touch .jw-text-elapsed{padding:0 .35em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-prev:before{padding:0 .125em 0 .7em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-next:before{padding:0 .7em 0 .125em}.jw-skin-seven.jw-flag-touch .jw-controlbar .jw-icon-playlist:before{padding:0 .225em}', ""]);
    }, function(e, t) {
        e.exports = function() {
            var e = [];
            return e.toString = function() {
                for (var e = [], t = 0; t < this.length; t++) {
                    var n = this[t];
                    n[2] ? e.push("@media " + n[2] + "{" + n[1] + "}") : e.push(n[1])
                }
                return e.join("")
            }, e.i = function(t, n) {
                "string" == typeof t && (t = [
                    [null, t, ""]
                ]);
                for (var i = {}, r = 0; r < this.length; r++) {
                    var o = this[r][0];
                    "number" == typeof o && (i[o] = !0)
                }
                for (r = 0; r < t.length; r++) {
                    var a = t[r];
                    "number" == typeof a[0] && i[a[0]] || (n && !a[2] ? a[2] = n : n && (a[2] = "(" + a[2] + ") and (" + n + ")"), e.push(a))
                }
            }, e
        }
    }, function(e, t, n) {
        e.exports = n.p + "jw-icons.ttf"
    }, function(e, t, n) {
        e.exports = n.p + "jw-icons.woff"
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                return '<div class="jw-skip jw-background-color jw-hidden jw-reset">\n    <span class="jw-text jw-skiptext jw-reset"></span>\n    <span class="jw-icon-inline jw-skip-icon jw-reset"></span>\n</div>'
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                return '<div class="jw-display-icon-container jw-background-color jw-reset">\n    <div class="jw-icon jw-icon-display jw-button-color jw-reset"></div>\n</div>\n'
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            1: function(e, t, n, i, r) {
                var o, a, s = null != t ? t : {};
                return '    <div class="jw-dock-button jw-background-color jw-reset' + (null != (o = n["if"].call(s, null != t ? t.btnClass : t, {
                            name: "if",
                            hash: {},
                            fn: e.program(2, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + '" button="' + e.escapeExpression((a = null != (a = n.id || (null != t ? t.id : t)) ? a : n.helperMissing, "function" == typeof a ? a.call(s, {
                            name: "id",
                            hash: {},
                            data: r
                        }) : a)) + '">\n        <div class="jw-icon jw-dock-image jw-reset" ' + (null != (o = n["if"].call(s, null != t ? t.img : t, {
                            name: "if",
                            hash: {},
                            fn: e.program(4, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + '></div>\n        <div class="jw-arrow jw-reset"></div>\n' + (null != (o = n["if"].call(s, null != t ? t.tooltip : t, {
                            name: "if",
                            hash: {},
                            fn: e.program(6, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "    </div>\n"
            },
            2: function(e, t, n, i, r) {
                var o;
                return " " + e.escapeExpression((o = null != (o = n.btnClass || (null != t ? t.btnClass : t)) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "btnClass",
                            hash: {},
                            data: r
                        }) : o))
            },
            4: function(e, t, n, i, r) {
                var o;
                return "style='background-image: url(\"" + e.escapeExpression((o = null != (o = n.img || (null != t ? t.img : t)) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "img",
                            hash: {},
                            data: r
                        }) : o)) + "\")'"
            },
            6: function(e, t, n, i, r) {
                var o;
                return '        <div class="jw-overlay jw-background-color jw-reset">\n            <span class="jw-text jw-dock-text jw-reset">' + e.escapeExpression((o = null != (o = n.tooltip || (null != t ? t.tooltip : t)) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "tooltip",
                            hash: {},
                            data: r
                        }) : o)) + "</span>\n        </div>\n"
            },
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o;
                return '<div class="jw-dock jw-reset">\n' + (null != (o = n.each.call(null != t ? t : {}, t, {
                            name: "each",
                            hash: {},
                            fn: e.program(1, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "</div>"
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o, a = null != t ? t : {},
                        s = n.helperMissing,
                        l = "function",
                        c = e.escapeExpression;
                return '<div id="' + c((o = null != (o = n.id || (null != t ? t.id : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "id",
                            hash: {},
                            data: r
                        }) : o)) + '"class="jw-skin-' + c((o = null != (o = n.skin || (null != t ? t.skin : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "skin",
                            hash: {},
                            data: r
                        }) : o)) + ' jw-error jw-reset">\n    <div class="jw-title jw-reset">\n        <div class="jw-title-primary jw-reset">' + c((o = null != (o = n.title || (null != t ? t.title : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "title",
                            hash: {},
                            data: r
                        }) : o)) + '</div>\n        <div class="jw-title-secondary jw-reset">' + c((o = null != (o = n.body || (null != t ? t.body : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "body",
                            hash: {},
                            data: r
                        }) : o)) + '</div>\n    </div>\n\n    <div class="jw-icon-container jw-reset">\n        <div class="jw-display-icon-container jw-background-color jw-reset">\n            <div class="jw-icon jw-icon-display jw-reset"></div>\n        </div>\n    </div>\n</div>\n'
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                return '<div class="jw-logo jw-reset"></div>'
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            1: function(e, t, n, i, r) {
                var o, a = e.escapeExpression;
                return "        <li class='jw-text jw-option jw-item-" + a((o = null != (o = n.index || r && r.index) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "index",
                            hash: {},
                            data: r
                        }) : o)) + " jw-reset'>" + a(e.lambda(null != t ? t.label : t, t)) + "</li>\n"
            },
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o;
                return '<ul class="jw-menu jw-background-color jw-reset">\n' + (null != (o = n.each.call(null != t ? t : {}, t, {
                            name: "each",
                            hash: {},
                            fn: e.program(1, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "</ul>"
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o;
                return '<div id="' + e.escapeExpression((o = null != (o = n.id || (null != t ? t.id : t)) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "id",
                            hash: {},
                            data: r
                        }) : o)) + '" class="jwplayer jw-reset" tabindex="0">\n    <div class="jw-aspect jw-reset"></div>\n    <div class="jw-media jw-reset"></div>\n    <div class="jw-preview jw-reset"></div>\n    <div class="jw-title jw-reset">\n        <div class="jw-title-primary jw-reset"></div>\n        <div class="jw-title-secondary jw-reset"></div>\n    </div>\n    <div class="jw-overlays jw-reset"></div>\n    <div class="jw-controls jw-reset"></div>\n</div>'
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            1: function(e, t, n, i, r) {
                var o;
                return null != (o = n["if"].call(null != t ? t : {}, null != t ? t.active : t, {
                    name: "if",
                    hash: {},
                    fn: e.program(2, r, 0),
                    inverse: e.program(4, r, 0),
                    data: r
                })) ? o : ""
            },
            2: function(e, t, n, i, r) {
                var o, a = e.escapeExpression;
                return "                <li class='jw-option jw-text jw-active-option jw-item-" + a((o = null != (o = n.index || r && r.index) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "index",
                            hash: {},
                            data: r
                        }) : o)) + ' jw-reset\'>\n                    <span class="jw-label jw-reset"><span class="jw-icon jw-icon-play jw-reset"></span></span>\n                    <span class="jw-name jw-reset">' + a(e.lambda(null != t ? t.title : t, t)) + "</span>\n                </li>\n"
            },
            4: function(e, t, n, i, r) {
                var o, a = e.escapeExpression,
                        s = e.lambda;
                return "                <li class='jw-option jw-text jw-item-" + a((o = null != (o = n.index || r && r.index) ? o : n.helperMissing, "function" == typeof o ? o.call(null != t ? t : {}, {
                            name: "index",
                            hash: {},
                            data: r
                        }) : o)) + ' jw-reset\'>\n                    <span class="jw-label jw-reset">' + a(s(null != t ? t.label : t, t)) + '</span>\n                    <span class="jw-name jw-reset">' + a(s(null != t ? t.title : t, t)) + "</span>\n                </li>\n"
            },
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o;
                return '<div class="jw-menu jw-playlist-container jw-background-color jw-reset">\n\n    <div class="jw-tooltip-title jw-reset">\n        <span class="jw-icon jw-icon-inline jw-icon-playlist jw-reset"></span>\n        <span class="jw-text jw-reset">PLAYLIST</span>\n    </div>\n\n    <ul class="jw-playlist jw-reset">\n' + (null != (o = n.each.call(null != t ? t : {}, t, {
                            name: "each",
                            hash: {},
                            fn: e.program(1, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "    </ul>\n</div>"
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            1: function(e, t, n, i, r) {
                var o, a, s = null != t ? t : {},
                        l = n.helperMissing,
                        c = "function",
                        u = e.escapeExpression;
                return '        <li class="jw-reset' + (null != (o = n["if"].call(s, null != t ? t.featured : t, {
                            name: "if",
                            hash: {},
                            fn: e.program(2, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + '">\n            <a href="' + u((a = null != (a = n.link || (null != t ? t.link : t)) ? a : l, typeof a === c ? a.call(s, {
                            name: "link",
                            hash: {},
                            data: r
                        }) : a)) + '" class="jw-reset" target="_top">\n' + (null != (o = n["if"].call(s, null != t ? t.showLogo : t, {
                            name: "if",
                            hash: {},
                            fn: e.program(4, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "                " + u((a = null != (a = n.title || (null != t ? t.title : t)) ? a : l, typeof a === c ? a.call(s, {
                            name: "title",
                            hash: {},
                            data: r
                        }) : a)) + "\n            </a>\n        </li>\n"
            },
            2: function(e, t, n, i, r) {
                return " jw-featured"
            },
            4: function(e, t, n, i, r) {
                return '                <span class="jw-icon jw-rightclick-logo jw-reset"></span>\n'
            },
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o;
                return '<div class="jw-rightclick jw-reset">\n    <ul class="jw-reset">\n' + (null != (o = n.each.call(null != t ? t : {}, null != t ? t.items : t, {
                            name: "each",
                            hash: {},
                            fn: e.program(1, r, 0),
                            inverse: e.noop,
                            data: r
                        })) ? o : "") + "    </ul>\n</div>"
            },
            useData: !0
        })
    }, function(e, t, n) {
        var i = n(16);
        e.exports = (i["default"] || i).template({
            compiler: [7, ">= 4.0.0"],
            main: function(e, t, n, i, r) {
                var o, a = null != t ? t : {},
                        s = n.helperMissing,
                        l = "function",
                        c = e.escapeExpression;
                return '<div class="' + c((o = null != (o = n.className || (null != t ? t.className : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "className",
                            hash: {},
                            data: r
                        }) : o)) + " " + c((o = null != (o = n.orientation || (null != t ? t.orientation : t)) ? o : s, typeof o === l ? o.call(a, {
                            name: "orientation",
                            hash: {},
                            data: r
                        }) : o)) + ' jw-reset">\n    <div class="jw-slider-container jw-reset">\n        <div class="jw-rail jw-reset"></div>\n        <div class="jw-buffer jw-reset"></div>\n        <div class="jw-progress jw-reset"></div>\n        <div class="jw-knob jw-reset"></div>\n    </div>\n</div>'
            },
            useData: !0
        })
    }, , function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }

        function r(e) {
            if (e && e.__esModule) return e;
            var t = {};
            if (null != e)
                for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
            return t["default"] = e, t
        }

        function o() {
            var e = new s.HandlebarsEnvironment;
            return f.extend(e, s), e.SafeString = c["default"], e.Exception = d["default"], e.Utils = f, e.escapeExpression = f.escapeExpression, e.VM = g, e.template = function(t) {
                return g.template(t, e)
            }, e
        }
        t.__esModule = !0;
        var a = n(118),
                s = r(a),
                l = n(261),
                c = i(l),
                u = n(39),
                d = i(u),
                p = n(20),
                f = r(p),
                h = n(260),
                g = r(h),
                m = n(259),
                v = i(m),
                w = o();
        w.create = o, v["default"](w), w["default"] = w, t["default"] = w, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }

        function r(e) {
            a["default"](e)
        }
        t.__esModule = !0, t.registerDefaultDecorators = r;
        var o = n(249),
                a = i(o)
    }, function(e, t, n) {
        "use strict";
        t.__esModule = !0;
        var i = n(20);
        t["default"] = function(e) {
            e.registerDecorator("inline", function(e, t, n, r) {
                var o = e;
                return t.partials || (t.partials = {}, o = function(r, o) {
                    var a = n.partials;
                    n.partials = i.extend({}, a, t.partials);
                    var s = e(r, o);
                    return n.partials = a, s
                }), t.partials[r.args[0]] = r.fn, o
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }

        function r(e) {
            a["default"](e), l["default"](e), u["default"](e), p["default"](e), h["default"](e), m["default"](e), w["default"](e)
        }
        t.__esModule = !0, t.registerDefaultHelpers = r;
        var o = n(251),
                a = i(o),
                s = n(252),
                l = i(s),
                c = n(253),
                u = i(c),
                d = n(254),
                p = i(d),
                f = n(255),
                h = i(f),
                g = n(256),
                m = i(g),
                v = n(257),
                w = i(v)
    }, function(e, t, n) {
        "use strict";
        t.__esModule = !0;
        var i = n(20);
        t["default"] = function(e) {
            e.registerHelper("blockHelperMissing", function(t, n) {
                var r = n.inverse,
                        o = n.fn;
                if (t === !0) return o(this);
                if (t === !1 || null == t) return r(this);
                if (i.isArray(t)) return t.length > 0 ? (n.ids && (n.ids = [n.name]), e.helpers.each(t, n)) : r(this);
                if (n.data && n.ids) {
                    var a = i.createFrame(n.data);
                    a.contextPath = i.appendContextPath(n.data.contextPath, n.name), n = {
                        data: a
                    }
                }
                return o(t, n)
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }
        t.__esModule = !0;
        var r = n(20),
                o = n(39),
                a = i(o);
        t["default"] = function(e) {
            e.registerHelper("each", function(e, t) {
                function n(t, n, o) {
                    c && (c.key = t, c.index = n, c.first = 0 === n, c.last = !!o, u && (c.contextPath = u + t)), l += i(e[t], {
                        data: c,
                        blockParams: r.blockParams([e[t], t], [u + t, null])
                    })
                }
                if (!t) throw new a["default"]("Must pass iterator to #each");
                var i = t.fn,
                        o = t.inverse,
                        s = 0,
                        l = "",
                        c = void 0,
                        u = void 0;
                if (t.data && t.ids && (u = r.appendContextPath(t.data.contextPath, t.ids[0]) + "."), r.isFunction(e) && (e = e.call(this)), t.data && (c = r.createFrame(t.data)), e && "object" == typeof e)
                    if (r.isArray(e))
                        for (var d = e.length; d > s; s++) s in e && n(s, s, s === e.length - 1);
                    else {
                        var p = void 0;
                        for (var f in e) e.hasOwnProperty(f) && (void 0 !== p && n(p, s - 1), p = f, s++);
                        void 0 !== p && n(p, s - 1, !0)
                    }
                return 0 === s && (l = o(this)), l
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }
        t.__esModule = !0;
        var r = n(39),
                o = i(r);
        t["default"] = function(e) {
            e.registerHelper("helperMissing", function() {
                if (1 !== arguments.length) throw new o["default"]('Missing helper: "' + arguments[arguments.length - 1].name + '"')
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";
        t.__esModule = !0;
        var i = n(20);
        t["default"] = function(e) {
            e.registerHelper("if", function(e, t) {
                return i.isFunction(e) && (e = e.call(this)), !t.hash.includeZero && !e || i.isEmpty(e) ? t.inverse(this) : t.fn(this)
            }), e.registerHelper("unless", function(t, n) {
                return e.helpers["if"].call(this, t, {
                    fn: n.inverse,
                    inverse: n.fn,
                    hash: n.hash
                })
            })
        }, e.exports = t["default"]
    }, function(e, t) {
        "use strict";
        t.__esModule = !0, t["default"] = function(e) {
            e.registerHelper("log", function() {
                for (var t = [void 0], n = arguments[arguments.length - 1], i = 0; i < arguments.length - 1; i++) t.push(arguments[i]);
                var r = 1;
                null != n.hash.level ? r = n.hash.level : n.data && null != n.data.level && (r = n.data.level), t[0] = r, e.log.apply(e, t)
            })
        }, e.exports = t["default"]
    }, function(e, t) {
        "use strict";
        t.__esModule = !0, t["default"] = function(e) {
            e.registerHelper("lookup", function(e, t) {
                return e && e[t]
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";
        t.__esModule = !0;
        var i = n(20);
        t["default"] = function(e) {
            e.registerHelper("with", function(e, t) {
                i.isFunction(e) && (e = e.call(this));
                var n = t.fn;
                if (i.isEmpty(e)) return t.inverse(this);
                var r = t.data;
                return t.data && t.ids && (r = i.createFrame(t.data), r.contextPath = i.appendContextPath(t.data.contextPath, t.ids[0])), n(e, {
                    data: r,
                    blockParams: i.blockParams([e], [r && r.contextPath])
                })
            })
        }, e.exports = t["default"]
    }, function(e, t, n) {
        "use strict";
        t.__esModule = !0;
        var i = n(20),
                r = {
                    methodMap: ["debug", "info", "warn", "error"],
                    level: "info",
                    lookupLevel: function(e) {
                        if ("string" == typeof e) {
                            var t = i.indexOf(r.methodMap, e.toLowerCase());
                            e = t >= 0 ? t : parseInt(e, 10)
                        }
                        return e
                    },
                    log: function(e) {
                        if (e = r.lookupLevel(e), "undefined" != typeof console && r.lookupLevel(r.level) <= e) {
                            var t = r.methodMap[e];
                            console[t] || (t = "log");
                            for (var n = arguments.length, i = Array(n > 1 ? n - 1 : 0), o = 1; n > o; o++) i[o - 1] = arguments[o];
                            console[t].apply(console, i)
                        }
                    }
                };
        t["default"] = r, e.exports = t["default"]
    }, function(e, t) {
        (function(n) {
            "use strict";
            t.__esModule = !0, t["default"] = function(e) {
                var t = "undefined" != typeof n ? n : window,
                        i = t.Handlebars;
                e.noConflict = function() {
                    return t.Handlebars === e && (t.Handlebars = i), e
                }
            }, e.exports = t["default"]
        }).call(t, function() {
                    return this
                }())
    }, function(e, t, n) {
        "use strict";

        function i(e) {
            return e && e.__esModule ? e : {
                "default": e
            }
        }

        function r(e) {
            if (e && e.__esModule) return e;
            var t = {};
            if (null != e)
                for (var n in e) Object.prototype.hasOwnProperty.call(e, n) && (t[n] = e[n]);
            return t["default"] = e, t
        }

        function o(e) {
            var t = e && e[0] || 1,
                    n = v.COMPILER_REVISION;
            if (t !== n) {
                if (n > t) {
                    var i = v.REVISION_CHANGES[n],
                            r = v.REVISION_CHANGES[t];
                    throw new m["default"]("Template was precompiled with an older version of Handlebars than the current runtime. Please update your precompiler to a newer version (" + i + ") or downgrade your runtime to an older version (" + r + ").")
                }
                throw new m["default"]("Template was precompiled with a newer version of Handlebars than the current runtime. Please update your runtime to a newer version (" + e[1] + ").")
            }
        }

        function a(e, t) {
            function n(n, i, r) {
                r.hash && (i = h.extend({}, i, r.hash), r.ids && (r.ids[0] = !0)), n = t.VM.resolvePartial.call(this, n, i, r);
                var o = t.VM.invokePartial.call(this, n, i, r);
                if (null == o && t.compile && (r.partials[r.name] = t.compile(n, e.compilerOptions, t), o = r.partials[r.name](i, r)), null != o) {
                    if (r.indent) {
                        for (var a = o.split("\n"), s = 0, l = a.length; l > s && (a[s] || s + 1 !== l); s++) a[s] = r.indent + a[s];
                        o = a.join("\n")
                    }
                    return o
                }
                throw new m["default"]("The partial " + r.name + " could not be compiled when running in runtime-only mode")
            }

            function i(t) {
                function n(t) {
                    return "" + e.main(r, t, r.helpers, r.partials, a, l, s)
                }
                var o = arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1],
                        a = o.data;
                i._setup(o), !o.partial && e.useData && (a = d(t, a));
                var s = void 0,
                        l = e.useBlockParams ? [] : void 0;
                return e.useDepths && (s = o.depths ? t !== o.depths[0] ? [t].concat(o.depths) : o.depths : [t]), (n = p(e.main, n, r, o.depths || [], a, l))(t, o)
            }
            if (!t) throw new m["default"]("No environment passed to template");
            if (!e || !e.main) throw new m["default"]("Unknown template object: " + typeof e);
            e.main.decorator = e.main_d, t.VM.checkRevision(e.compiler);
            var r = {
                strict: function(e, t) {
                    if (!(t in e)) throw new m["default"]('"' + t + '" not defined in ' + e);
                    return e[t]
                },
                lookup: function(e, t) {
                    for (var n = e.length, i = 0; n > i; i++)
                        if (e[i] && null != e[i][t]) return e[i][t]
                },
                lambda: function(e, t) {
                    return "function" == typeof e ? e.call(t) : e
                },
                escapeExpression: h.escapeExpression,
                invokePartial: n,
                fn: function(t) {
                    var n = e[t];
                    return n.decorator = e[t + "_d"], n
                },
                programs: [],
                program: function(e, t, n, i, r) {
                    var o = this.programs[e],
                            a = this.fn(e);
                    return t || r || i || n ? o = s(this, e, a, t, n, i, r) : o || (o = this.programs[e] = s(this, e, a)), o
                },
                data: function(e, t) {
                    for (; e && t--;) e = e._parent;
                    return e
                },
                merge: function(e, t) {
                    var n = e || t;
                    return e && t && e !== t && (n = h.extend({}, t, e)), n
                },
                noop: t.VM.noop,
                compilerInfo: e.compiler
            };
            return i.isTop = !0, i._setup = function(n) {
                n.partial ? (r.helpers = n.helpers, r.partials = n.partials, r.decorators = n.decorators) : (r.helpers = r.merge(n.helpers, t.helpers), e.usePartial && (r.partials = r.merge(n.partials, t.partials)), (e.usePartial || e.useDecorators) && (r.decorators = r.merge(n.decorators, t.decorators)))
            }, i._child = function(t, n, i, o) {
                if (e.useBlockParams && !i) throw new m["default"]("must pass block params");
                if (e.useDepths && !o) throw new m["default"]("must pass parent depths");
                return s(r, t, e[t], n, 0, i, o)
            }, i
        }

        function s(e, t, n, i, r, o, a) {
            function s(t) {
                var r = arguments.length <= 1 || void 0 === arguments[1] ? {} : arguments[1],
                        s = a;
                return a && t !== a[0] && (s = [t].concat(a)), n(e, t, e.helpers, e.partials, r.data || i, o && [r.blockParams].concat(o), s)
            }
            return s = p(n, s, e, a, i, o), s.program = t, s.depth = a ? a.length : 0, s.blockParams = r || 0, s
        }

        function l(e, t, n) {
            return e ? e.call || n.name || (n.name = e, e = n.partials[e]) : e = "@partial-block" === n.name ? n.data["partial-block"] : n.partials[n.name], e
        }

        function c(e, t, n) {
            n.partial = !0, n.ids && (n.data.contextPath = n.ids[0] || n.data.contextPath);
            var i = void 0;
            if (n.fn && n.fn !== u && (n.data = v.createFrame(n.data), i = n.data["partial-block"] = n.fn, i.partials && (n.partials = h.extend({}, n.partials, i.partials))), void 0 === e && i && (e = i), void 0 === e) throw new m["default"]("The partial " + n.name + " could not be found");
            return e instanceof Function ? e(t, n) : void 0
        }

        function u() {
            return ""
        }

        function d(e, t) {
            return t && "root" in t || (t = t ? v.createFrame(t) : {}, t.root = e), t
        }

        function p(e, t, n, i, r, o) {
            if (e.decorator) {
                var a = {};
                t = e.decorator(t, a, n, i && i[0], r, o, i), h.extend(t, a)
            }
            return t
        }
        t.__esModule = !0, t.checkRevision = o, t.template = a, t.wrapProgram = s, t.resolvePartial = l, t.invokePartial = c, t.noop = u;
        var f = n(20),
                h = r(f),
                g = n(39),
                m = i(g),
                v = n(118)
    }, function(e, t) {
        "use strict";

        function n(e) {
            this.string = e
        }
        t.__esModule = !0, n.prototype.toString = n.prototype.toHTML = function() {
            return "" + this.string
        }, t["default"] = n, e.exports = t["default"]
    }, function(e, t, n) {
        var i, r;
        i = [n(41), n(1)], r = function(e, t) {
            return function(n, i) {
                var r = ["seek", "skipAd", "stop", "playlistNext", "playlistPrev", "playlistItem", "resize", "addButton", "removeButton", "registerPlugin", "attachMedia"];
                t.each(r, function(e) {
                    n[e] = function() {
                        return i[e].apply(i, arguments), n
                    }
                }), n.registerPlugin = e.registerPlugin
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            return function(t, n) {
                var i = ["buffer", "controls", "position", "duration", "fullscreen", "volume", "mute", "item", "stretching", "playlist"];
                e.each(i, function(e) {
                    var i = e.slice(0, 1).toUpperCase() + e.slice(1);
                    t["get" + i] = function() {
                        return n._model.get(e)
                    }
                });
                var r = ["getAudioTracks", "getCaptionsList", "getWidth", "getHeight", "getCurrentAudioTrack", "setCurrentAudioTrack", "getCurrentCaptions", "setCurrentCaptions", "getCurrentQuality", "setCurrentQuality", "getQualityLevels", "getVisualQuality", "getConfig", "getState", "getSafeRegion", "isBeforeComplete", "isBeforePlay", "getProvider", "detachMedia"],
                        o = ["setControls", "setFullscreen", "setVolume", "setMute", "setCues"];
                e.each(r, function(e) {
                    t[e] = function() {
                        return n[e] ? n[e].apply(n, arguments) : null
                    }
                }), e.each(o, function(e) {
                    t[e] = function() {
                        return n[e].apply(n, arguments), t
                    }
                }), t.getPlaylistIndex = t.getItem
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(4), n(6), n(3), n(2), n(133), n(134), n(1), n(317), n(262), n(263), n(265), n(33)], r = function(e, t, n, i, r, o, a, s, l, c, u, d) {
            var p = function(o, p) {
                var f, h = this,
                        g = !1,
                        m = {};
                a.extend(this, n), this.utils = i, this._ = a, this.Events = n, this.version = d, this.trigger = function(e, t) {
                    return t = a.isObject(t) ? a.extend({}, t) : {}, t.type = e, window.jwplayer && window.jwplayer.debug ? n.trigger.call(h, e, t) : n.triggerSafe.call(h, e, t)
                }, this.dispatchEvent = this.trigger, this.removeEventListener = this.off.bind(this);
                var v = function() {
                    f = new s(o), l(h, f), c(h, f), f.on(e.JWPLAYER_PLAYLIST_ITEM, function() {
                        m = {}
                    }), f.on(e.JWPLAYER_MEDIA_META, function(e) {
                        a.extend(m, e.metadata)
                    }), f.on(e.JWPLAYER_READY, function(e) {
                        g = !0, w.tick("ready"), e.setupTime = w.between("setup", "ready")
                    }), f.on("all", h.trigger)
                };
                v(), u(this), this.id = o.id;
                var w = this._qoe = new r;
                w.tick("init");
                var y = function() {
                    g = !1, m = {}, h.off(), f && f.off(), f && f.playerDestroy && f.playerDestroy()
                };
                return this.getPlugin = function(e) {
                    return h.plugins && h.plugins[e]
                }, this.addPlugin = function(e, t) {
                    this.plugins = this.plugins || {}, this.plugins[e] = t, this.onReady(t.addToPlayer), t.resize && this.onResize(t.resizeHandler)
                }, this.setup = function(e) {
                    return w.tick("setup"), y(), v(), i.foreach(e.events, function(e, t) {
                        var n = h[e];
                        "function" == typeof n && n.call(h, t)
                    }), e.id = h.id, f.setup(e, this), h
                }, this.qoe = function() {
                    var t = f.getItemQoe(),
                            n = w.between("setup", "ready"),
                            i = t.between(e.JWPLAYER_MEDIA_PLAY_ATTEMPT, e.JWPLAYER_MEDIA_FIRST_FRAME);
                    return {
                        setupTime: n,
                        firstFrame: i,
                        player: w.dump(),
                        item: t.dump()
                    }
                }, this.getContainer = function() {
                    return f.getContainer ? f.getContainer() : o
                }, this.getMeta = this.getItemMeta = function() {
                    return m
                }, this.getPlaylistItem = function(e) {
                    if (!i.exists(e)) return f._model.get("playlistItem");
                    var t = h.getPlaylist();
                    return t ? t[e] : null
                }, this.getRenderingMode = function() {
                    return "html5"
                }, this.load = function(e) {
                    var t = this.getPlugin("vast") || this.getPlugin("googima");
                    return t && t.destroy(), f.load(e), h
                }, this.play = function(e, n) {
                    if (a.isBoolean(e) || (n = e), n || (n = {
                                reason: "external"
                            }), e === !0) return f.play(n), h;
                    if (e === !1) return f.pause(), h;
                    switch (e = h.getState()) {
                        case t.PLAYING:
                        case t.BUFFERING:
                            f.pause();
                            break;
                        default:
                            f.play(n)
                    }
                    return h
                }, this.pause = function(e) {
                    return a.isBoolean(e) ? this.play(!e) : this.play()
                }, this.createInstream = function() {
                    return f.createInstream()
                }, this.castToggle = function() {
                    f && f.castToggle && f.castToggle()
                }, this.playAd = this.pauseAd = i.noop, this.remove = function() {
                    return p(h), h.trigger("remove"), y(), h
                }, this
            };
            return p
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(4)], r = function(e, t) {
            return function(n) {
                var i = {
                            onBufferChange: t.JWPLAYER_MEDIA_BUFFER,
                            onBufferFull: t.JWPLAYER_MEDIA_BUFFER_FULL,
                            onError: t.JWPLAYER_ERROR,
                            onSetupError: t.JWPLAYER_SETUP_ERROR,
                            onFullscreen: t.JWPLAYER_FULLSCREEN,
                            onMeta: t.JWPLAYER_MEDIA_META,
                            onMute: t.JWPLAYER_MEDIA_MUTE,
                            onPlaylist: t.JWPLAYER_PLAYLIST_LOADED,
                            onPlaylistItem: t.JWPLAYER_PLAYLIST_ITEM,
                            onPlaylistComplete: t.JWPLAYER_PLAYLIST_COMPLETE,
                            onReady: t.JWPLAYER_READY,
                            onResize: t.JWPLAYER_RESIZE,
                            onComplete: t.JWPLAYER_MEDIA_COMPLETE,
                            onSeek: t.JWPLAYER_MEDIA_SEEK,
                            onTime: t.JWPLAYER_MEDIA_TIME,
                            onVolume: t.JWPLAYER_MEDIA_VOLUME,
                            onBeforePlay: t.JWPLAYER_MEDIA_BEFOREPLAY,
                            onBeforeComplete: t.JWPLAYER_MEDIA_BEFORECOMPLETE,
                            onDisplayClick: t.JWPLAYER_DISPLAY_CLICK,
                            onControls: t.JWPLAYER_CONTROLS,
                            onQualityLevels: t.JWPLAYER_MEDIA_LEVELS,
                            onQualityChange: t.JWPLAYER_MEDIA_LEVEL_CHANGED,
                            onCaptionsList: t.JWPLAYER_CAPTIONS_LIST,
                            onCaptionsChange: t.JWPLAYER_CAPTIONS_CHANGED,
                            onAdError: t.JWPLAYER_AD_ERROR,
                            onAdClick: t.JWPLAYER_AD_CLICK,
                            onAdImpression: t.JWPLAYER_AD_IMPRESSION,
                            onAdTime: t.JWPLAYER_AD_TIME,
                            onAdComplete: t.JWPLAYER_AD_COMPLETE,
                            onAdCompanions: t.JWPLAYER_AD_COMPANIONS,
                            onAdSkipped: t.JWPLAYER_AD_SKIPPED,
                            onAdPlay: t.JWPLAYER_AD_PLAY,
                            onAdPause: t.JWPLAYER_AD_PAUSE,
                            onAdMeta: t.JWPLAYER_AD_META,
                            onCast: t.JWPLAYER_CAST_SESSION,
                            onAudioTrackChange: t.JWPLAYER_AUDIO_TRACK_CHANGED,
                            onAudioTracks: t.JWPLAYER_AUDIO_TRACKS
                        },
                        r = {
                            onBuffer: "buffer",
                            onPause: "pause",
                            onPlay: "play",
                            onIdle: "idle"
                        };
                e.each(r, function(t, i) {
                    n[i] = e.partial(n.on, t, e)
                }), e.each(i, function(t, i) {
                    n[i] = e.partial(n.on, t, e)
                })
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(264), n(1), n(47), n(128), n(89), n(41)], r = function(e, t, n, i, r, o) {
            var a = [],
                    s = 0,
                    l = function(t) {
                        var n, i;
                        return t ? "string" == typeof t ? (n = c(t), n || (i = document.getElementById(t))) : "number" == typeof t ? n = a[t] : t.nodeType && (i = t, n = c(i.id)) : n = a[0], n ? n : i ? u(new e(i, d)) : {
                            registerPlugin: o.registerPlugin
                        }
                    },
                    c = function(e) {
                        for (var t = 0; t < a.length; t++)
                            if (a[t].id === e) return a[t];
                        return null
                    },
                    u = function(e) {
                        return s++, e.uniqueId = s, a.push(e), e
                    },
                    d = function(e) {
                        for (var t = a.length; t--;)
                            if (a[t].uniqueId === e.uniqueId) {
                                a.splice(t, 1);
                                break
                            }
                    },
                    p = {
                        selectPlayer: l,
                        registerProvider: n.registerProvider,
                        availableProviders: r,
                        registerPlugin: o.registerPlugin
                    };
            return l.api = p, p
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(318), n(3), n(1), n(4)], r = function(e, t, n, i) {
            var r = function(t, r, o, a) {
                function s() {
                    p("Setup Timeout Error", "Setup took longer than " + m + " seconds to complete.")
                }

                function l() {
                    n.each(g, function(e) {
                        e.complete !== !0 && e.running !== !0 && null !== t && u(e.depends) && (e.running = !0, c(e))
                    })
                }

                function c(e) {
                    var n = function(t) {
                        t = t || {}, d(e, t)
                    };
                    e.method(n, r, t, o, a)
                }

                function u(e) {
                    return n.all(e, function(e) {
                        return g[e].complete
                    })
                }

                function d(e, t) {
                    "error" === t.type ? p(t.msg, t.reason) : "complete" === t.type ? (clearTimeout(f), h.trigger(i.JWPLAYER_READY)) : (e.complete = !0, l())
                }

                function p(e, t) {
                    clearTimeout(f), h.trigger(i.JWPLAYER_SETUP_ERROR, {
                        message: e + ": " + t
                    }), h.destroy()
                }
                var f, h = this,
                        g = e.getQueue(),
                        m = 30;
                this.start = function() {
                    f = setTimeout(s, 1e3 * m), l()
                }, this.destroy = function() {
                    clearTimeout(f), this.off(), g.length = 0, t = null, r = null, o = null
                }
            };
            return r.prototype = t, r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(40), n(84), n(276), n(2)], r = function(e, t, n, i) {
            var r = function(r, o) {
                function a(e) {
                    if (e.tracks.length) {
                        o.mediaController.off("meta", s), j = [], b = {}, E = {}, k = 0;
                        for (var t = e.tracks || [], n = 0; n < t.length; n++) {
                            var i = t[n];
                            i.id = i.name, i.label = i.name || i.language, p(i)
                        }
                        var r = g();
                        this.setCaptionsList(r), m()
                    }
                }

                function s(e) {
                    var t = e.metadata;
                    if (t && "textdata" === t.type) {
                        if (!t.text) return;
                        var n = b[t.trackid];
                        if (!n) {
                            n = {
                                kind: "captions",
                                id: t.trackid,
                                data: []
                            }, p(n);
                            var i = g();
                            this.setCaptionsList(i)
                        }
                        var r, a;
                        t.useDTS ? (n.source || (n.source = t.source || "mpegts"), r = t.begin, a = t.begin + "_" + t.text) : (r = e.position || o.get("position"), a = "" + Math.round(10 * r) + "_" + t.text);
                        var s = E[a];
                        s || (s = {
                            begin: r,
                            text: t.text
                        }, t.end && (s.end = t.end), E[a] = s, n.data.push(s))
                    }
                }

                function l(e) {
                    i.log("CAPTIONS(" + e + ")")
                }

                function c(e, t) {
                    y = t, j = [], b = {}, E = {}, k = 0
                }

                function u(e) {
                    c(o, e), o.mediaController.off("meta", s), o.mediaController.off("subtitlesTracks", a);
                    var t, n, r, l, u = e.tracks,
                            d = "html5" === o.get("provider").name,
                            h = i.isChrome() || i.isIOS() || i.isSafari();
                    for (l = 0; l < u.length; l++) t = u[l], r = t.file && /\.(?:web)?vtt(?:\?.*)?$/i.test(t.file), d && r && !w && h || (n = t.kind.toLowerCase(), "captions" !== n && "subtitles" !== n || (t.file ? (p(t), f(t)) : t.data && p(t)));
                    j.length || (o.mediaController.on("meta", s, this), o.mediaController.on("subtitlesTracks", a, this));
                    var v = g();
                    this.setCaptionsList(v), m()
                }

                function d(e, t) {
                    var n = null;
                    0 !== t && (n = j[t - 1]), e.set("captionsTrack", n)
                }

                function p(e) {
                    "number" != typeof e.id && (e.id = e.name || e.file || "cc" + j.length), e.data = e.data || [], e.label || (e.label = "Unknown CC", k++, k > 1 && (e.label += " (" + k + ")")), j.push(e), b[e.id] = e
                }

                function f(e) {
                    i.ajax(e.file, function(t) {
                        h(t, e)
                    }, l)
                }

                function h(r, o) {
                    var a, s = r.responseXML ? r.responseXML.firstChild : null;
                    if (s)
                        for ("xml" === e.localName(s) && (s = s.nextSibling); s.nodeType === s.COMMENT_NODE;) s = s.nextSibling;
                    a = s && "tt" === e.localName(s) ? i.tryCatch(function() {
                        o.data = n(r.responseXML)
                    }) : i.tryCatch(function() {
                        o.data = t(r.responseText)
                    }), a instanceof i.Error && l(a.message + ": " + o.file)
                }

                function g() {
                    for (var e = [{
                        id: "off",
                        label: "Off"
                    }], t = 0; t < j.length; t++) e.push({
                        id: j[t].id,
                        label: j[t].label || "Unknown CC"
                    });
                    return e
                }

                function m() {
                    var e = 0,
                            t = o.get("captionLabel");
                    if ("Off" === t) return void o.set("captionsIndex", 0);
                    for (var n = 0; n < j.length; n++) {
                        var i = j[n];
                        if (t && t === i.label) {
                            e = n + 1;
                            break
                        }
                        i["default"] || i.defaulttrack || "default" === i.id ? e = n + 1 : i.autoselect
                    }
                    v(e)
                }

                function v(e) {
                    j.length ? o.setVideoSubtitleTrack(e, j) : o.set("captionsIndex", e)
                }
                o.on("change:playlistItem", c, this), o.on("change:captionsIndex", d, this), o.on("itemReady", u, this), o.mediaController.on("subtitlesTracks", a, this), o.mediaController.on("subtitlesTrackData", function(e) {
                    var t = b[e.name];
                    if (t) {
                        t.source = e.source;
                        for (var n = e.captions || [], i = !1, r = 0; r < n.length; r++) {
                            var o = n[r],
                                    a = e.name + "_" + o.begin + "_" + o.end;
                            E[a] || (E[a] = o, t.data.push(o), i = !0)
                        }
                        i && t.data.sort(function(e, t) {
                            return e.begin - t.begin
                        })
                    }
                }, this), o.mediaController.on("meta", s, this);
                var w = !!o.get("sdkplatform"),
                        y = {},
                        j = [],
                        b = {},
                        E = {},
                        k = 0;
                this.getCurrentIndex = function() {
                    return o.get("captionsIndex")
                }, this.getCaptionsList = function() {
                    return o.get("captionsList")
                }, this.setCaptionsList = function(e) {
                    o.set("captionsList", e)
                }
            };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(119), n(270), n(1), n(267), n(268), n(55), n(123), n(122), n(2), n(143), n(3), n(83), n(6), n(4), n(300)], r = function(e, t, n, i, r, o, a, s, l, c, u, d, p, f, h) {
            function g(e) {
                return function() {
                    var t = Array.prototype.slice.call(arguments, 0);
                    this.eventsQueue.push([e, t])
                }
            }

            function m(e) {
                return e === p.LOADING || e === p.STALLED ? p.BUFFERING : e
            }
            var v = function(e) {
                this.originalContainer = this.currentContainer = e, this.eventsQueue = [], n.extend(this, u), this._model = new o
            };
            return v.prototype = {
                play: g("play"),
                pause: g("pause"),
                setVolume: g("setVolume"),
                setMute: g("setMute"),
                seek: g("seek"),
                stop: g("stop"),
                load: g("load"),
                playlistNext: g("playlistNext"),
                playlistPrev: g("playlistPrev"),
                playlistItem: g("playlistItem"),
                setFullscreen: g("setFullscreen"),
                setCurrentCaptions: g("setCurrentCaptions"),
                setCurrentQuality: g("setCurrentQuality"),
                setup: function(o, u) {
                    function h() {
                        H.mediaModel.on("change:state", function(e, t) {
                            var n = m(t);
                            H.set("state", n)
                        })
                    }

                    function g() {
                        K = null, C(H.get("item")), H.on("change:state", d, this), H.on("change:castState", function(e, t) {
                            Z.trigger(f.JWPLAYER_CAST_SESSION, t)
                        }), H.on("change:fullscreen", function(e, t) {
                            Z.trigger(f.JWPLAYER_FULLSCREEN, {
                                fullscreen: t
                            })
                        }), H.on("itemReady", function() {
                            Z.trigger(f.JWPLAYER_PLAYLIST_ITEM, {
                                index: H.get("item"),
                                item: H.get("playlistItem")
                            })
                        }), H.on("change:playlist", function(e, t) {
                            t.length && Z.trigger(f.JWPLAYER_PLAYLIST_LOADED, {
                                playlist: t
                            })
                        }), H.on("change:volume", function(e, t) {
                            Z.trigger(f.JWPLAYER_MEDIA_VOLUME, {
                                volume: t
                            })
                        }), H.on("change:mute", function(e, t) {
                            Z.trigger(f.JWPLAYER_MEDIA_MUTE, {
                                mute: t
                            })
                        }), H.on("change:controls", function(e, t) {
                            Z.trigger(f.JWPLAYER_CONTROLS, {
                                controls: t
                            })
                        }), H.on("change:scrubbing", function(e, t) {
                            t ? k() : b()
                        }), H.on("change:captionsList", function(e, t) {
                            Z.trigger(f.JWPLAYER_CAPTIONS_LIST, {
                                tracks: t,
                                track: J()
                            })
                        }), H.mediaController.on("all", Z.trigger.bind(Z)), z.on("all", Z.trigger.bind(Z)), this.showView(z.element()), window.addEventListener("beforeunload", function() {
                            K && K.destroy(), H && H.destroy()
                        }), n.defer(v)
                    }

                    function v() {
                        for (Z.trigger(f.JWPLAYER_READY, {
                            setupTime: 0
                        }), Z.trigger(f.JWPLAYER_PLAYLIST_LOADED, {
                            playlist: H.get("playlist")
                        }), Z.trigger(f.JWPLAYER_PLAYLIST_ITEM, {
                            index: H.get("item"),
                            item: H.get("playlistItem")
                        }), Z.trigger(f.JWPLAYER_CAPTIONS_LIST, {
                            tracks: H.get("captionsList"),
                            track: H.get("captionsIndex")
                        }), H.get("autostart") && b({
                            reason: "autostart"
                        }); Z.eventsQueue.length > 0;) {
                            var e = Z.eventsQueue.shift(),
                                    t = e[0],
                                    n = e[1] || [];
                            Z[t].apply(Z, n)
                        }
                    }

                    function w(e) {
                        switch (H.get("state") === p.ERROR && H.set("state", p.IDLE), E(!0), H.get("autostart") && H.once("itemReady", b), typeof e) {
                            case "string":
                                y(e);
                                break;
                            case "object":
                                var t = x(e);
                                t && C(0);
                                break;
                            case "number":
                                C(e)
                        }
                    }

                    function y(e) {
                        var t = new s;
                        t.on(f.JWPLAYER_PLAYLIST_LOADED, function(e) {
                            w(e.playlist)
                        }), t.on(f.JWPLAYER_ERROR, function(e) {
                            e.message = "Error loading playlist: " + e.message, this.triggerError(e)
                        }, this), t.load(e)
                    }

                    function j() {
                        var e = Z._instreamAdapter && Z._instreamAdapter.getState();
                        return n.isString(e) ? e : H.get("state")
                    }

                    function b(e) {
                        var t;
                        if (e && H.set("playReason", e.reason), H.get("state") !== p.ERROR) {
                            var i = Z._instreamAdapter && Z._instreamAdapter.getState();
                            if (n.isString(i)) return u.pauseAd(!1);
                            if (H.get("state") === p.COMPLETE && (E(!0), C(0)), !X && (X = !0, Z.trigger(f.JWPLAYER_MEDIA_BEFOREPLAY, {
                                        playReason: H.get("playReason")
                                    }), X = !1, q)) return q = !1, void(Q = null);
                            if (A()) {
                                if (0 === H.get("playlist").length) return !1;
                                t = l.tryCatch(function() {
                                    H.loadVideo()
                                })
                            } else H.get("state") === p.PAUSED && (t = l.tryCatch(function() {
                                H.playVideo()
                            }));
                            return t instanceof l.Error ? (Z.triggerError(t), Q = null, !1) : !0
                        }
                    }

                    function E(e) {
                        H.off("itemReady", b);
                        var t = !e;
                        Q = null;
                        var n = l.tryCatch(function() {
                            H.stopVideo()
                        }, Z);
                        return n instanceof l.Error ? (Z.triggerError(n), !1) : (t && ($ = !0), X && (q = !0), !0)
                    }

                    function k() {
                        Q = null;
                        var e = Z._instreamAdapter && Z._instreamAdapter.getState();
                        if (n.isString(e)) return u.pauseAd(!0);
                        switch (H.get("state")) {
                            case p.ERROR:
                                return !1;
                            case p.PLAYING:
                            case p.BUFFERING:
                                var t = l.tryCatch(function() {
                                    ee().pause()
                                }, this);
                                if (t instanceof l.Error) return Z.triggerError(t), !1;
                                break;
                            default:
                                X && (q = !0)
                        }
                        return !0
                    }

                    function A() {
                        var e = H.get("state");
                        return e === p.IDLE || e === p.COMPLETE || e === p.ERROR
                    }

                    function L(e) {
                        H.get("state") !== p.ERROR && (H.get("scrubbing") || H.get("state") === p.PLAYING || b(!0), ee().seek(e))
                    }

                    function _(e, t) {
                        E(!0), C(e), b(t)
                    }

                    function x(e) {
                        var t = a(e);
                        return t = a.filterPlaylist(t, H.getProviders(), H.get("androidhls"), H.get("drm"), H.get("preload"), H.get("feedid")), H.set("playlist", t), n.isArray(t) && 0 !== t.length ? !0 : (Z.triggerError({
                            message: "Error loading playlist: No playable sources found"
                        }), !1)
                    }

                    function C(e) {
                        var t = H.get("playlist");
                        e = parseInt(e, 10) || 0, e = (e + t.length) % t.length, H.set("item", e), H.set("playlistItem", t[e]), H.setActiveItem(t[e])
                    }

                    function P(e) {
                        _(H.get("item") - 1, e || {
                                    reason: "external"
                                })
                    }

                    function T(e) {
                        _(H.get("item") + 1, e || {
                                    reason: "external"
                                })
                    }

                    function R() {
                        if (A()) {
                            if ($) return void($ = !1);
                            Q = R;
                            var e = H.get("item");
                            return e === H.get("playlist").length - 1 ? void(H.get("repeat") ? T({
                                reason: "repeat"
                            }) : (H.set("state", p.COMPLETE), Z.trigger(f.JWPLAYER_PLAYLIST_COMPLETE, {}))) : void T({
                                reason: "playlist"
                            })
                        }
                    }

                    function I(e) {
                        ee() && (e = parseInt(e, 10) || 0, ee().setCurrentQuality(e))
                    }

                    function M() {
                        return ee() ? ee().getCurrentQuality() : -1
                    }

                    function S() {
                        return this._model ? this._model.getConfiguration() : void 0
                    }

                    function O() {
                        if (this._model.mediaModel) return this._model.mediaModel.get("visualQuality");
                        var e = D();
                        if (e) {
                            var t = M(),
                                    i = e[t];
                            if (i) return {
                                level: n.extend({
                                    index: t
                                }, i),
                                mode: "",
                                reason: ""
                            }
                        }
                        return null
                    }

                    function D() {
                        return ee() ? ee().getQualityLevels() : null
                    }

                    function Y(e) {
                        ee() && (e = parseInt(e, 10) || 0, ee().setCurrentAudioTrack(e))
                    }

                    function N() {
                        return ee() ? ee().getCurrentAudioTrack() : -1
                    }

                    function W() {
                        return ee() ? ee().getAudioTracks() : null
                    }

                    function F(e) {
                        e = parseInt(e, 10) || 0, H.persistVideoSubtitleTrack(e), Z.trigger(f.JWPLAYER_CAPTIONS_CHANGED, {
                            tracks: V(),
                            track: e
                        })
                    }

                    function J() {
                        return G.getCurrentIndex()
                    }

                    function V() {
                        return G.getCaptionsList()
                    }

                    function B() {
                        var e = H.getVideo();
                        if (e) {
                            var t = e.detachMedia();
                            if (t instanceof HTMLVideoElement) return t
                        }
                        return null
                    }

                    function U() {
                        var e = l.tryCatch(function() {
                            H.getVideo().attachMedia()
                        });
                        return e instanceof l.Error ? void l.log("Error calling _attachMedia", e) : void("function" == typeof Q && Q())
                    }
                    var H, z, G, K, Q, q, X = !1,
                            $ = !1,
                            Z = this,
                            ee = function() {
                                return H.getVideo()
                            },
                            te = new e(o);
                    H = this._model.setup(te), z = this._view = new c(u, H), G = new r(u, H), K = new i(u, H, z, x), K.on(f.JWPLAYER_READY, g, this), K.on(f.JWPLAYER_SETUP_ERROR, this.setupError, this), H.mediaController.on(f.JWPLAYER_MEDIA_COMPLETE, function() {
                        n.defer(R)
                    }), H.mediaController.on(f.JWPLAYER_MEDIA_ERROR, this.triggerError, this), H.on("change:flashBlocked", function(e, t) {
                        if (!t) return void this._model.set("errorEvent", void 0);
                        var n = !!e.get("flashThrottle"),
                                i = {
                                    message: n ? "Click to run Flash" : "Flash plugin failed to load"
                                };
                        n || this.trigger(f.JWPLAYER_ERROR, i), this._model.set("errorEvent", i)
                    }, this), h(), H.on("change:mediaModel", h), this.play = b, this.pause = k, this.seek = L, this.stop = E, this.load = w, this.playlistNext = T, this.playlistPrev = P, this.playlistItem = _, this.setCurrentCaptions = F, this.setCurrentQuality = I, this.detachMedia = B, this.attachMedia = U, this.getCurrentQuality = M, this.getQualityLevels = D, this.setCurrentAudioTrack = Y, this.getCurrentAudioTrack = N, this.getAudioTracks = W, this.getCurrentCaptions = J, this.getCaptionsList = V, this.getVisualQuality = O, this.getConfig = S, this.getState = j, this.setVolume = H.setVolume, this.setMute = H.setMute, this.getProvider = function() {
                        return H.get("provider")
                    }, this.getWidth = function() {
                        return H.get("containerWidth")
                    }, this.getHeight = function() {
                        return H.get("containerHeight")
                    }, this.getContainer = function() {
                        return this.currentContainer
                    }, this.resize = z.resize, this.getSafeRegion = z.getSafeRegion, this.setCues = z.addCues, this.setFullscreen = function(e) {
                        n.isBoolean(e) || (e = !H.get("fullscreen")), H.set("fullscreen", e), this._instreamAdapter && this._instreamAdapter._adModel && this._instreamAdapter._adModel.set("fullscreen", e)
                    }, this.addButton = function(e, t, i, r, o) {
                        var a = {
                                    img: e,
                                    tooltip: t,
                                    callback: i,
                                    id: r,
                                    btnClass: o
                                },
                                s = H.get("dock");
                        s = s ? s.slice(0) : [], s = n.reject(s, n.matches({
                            id: a.id
                        })), s.push(a), H.set("dock", s)
                    }, this.removeButton = function(e) {
                        var t = H.get("dock") || [];
                        t = n.reject(t, n.matches({
                            id: e
                        })), H.set("dock", t)
                    }, this.checkBeforePlay = function() {
                        return X
                    }, this.getItemQoe = function() {
                        return H._qoeItem
                    }, this.setControls = function(e) {
                        n.isBoolean(e) || (e = !H.get("controls")), H.set("controls", e);
                        var t = H.getVideo();
                        t && t.setControls(e)
                    }, this.playerDestroy = function() {
                        this.stop(), this.showView(this.originalContainer), z && z.destroy(), H && H.destroy(), K && (K.destroy(), K = null)
                    }, this.isBeforePlay = this.checkBeforePlay, this.isBeforeComplete = function() {
                        return H.getVideo().checkComplete()
                    }, this.createInstream = function() {
                        return this.instreamDestroy(), this._instreamAdapter = new t(this, H, z), this._instreamAdapter
                    }, this.skipAd = function() {
                        this._instreamAdapter && this._instreamAdapter.skipAd()
                    }, this.instreamDestroy = function() {
                        Z._instreamAdapter && Z._instreamAdapter.destroy()
                    }, K.start()
                },
                showView: function(e) {
                    (document.documentElement.contains(this.currentContainer) || (this.currentContainer = document.getElementById(this._model.get("id")), this.currentContainer)) && (this.currentContainer.parentElement && this.currentContainer.parentElement.replaceChild(e, this.currentContainer), this.currentContainer = e)
                },
                triggerError: function(e) {
                    this._model.set("errorEvent", e), this._model.set("state", p.ERROR), this._model.once("change:state", function() {
                        this._model.set("errorEvent", void 0)
                    }, this), this.trigger(f.JWPLAYER_ERROR, e)
                },
                setupError: function(e) {
                    var t = e.message,
                            i = l.createElement(h(this._model.get("id"), this._model.get("skin"), t)),
                            r = this._model.get("width"),
                            o = this._model.get("height");
                    l.style(i, {
                        width: r.toString().indexOf("%") > 0 ? r : r + "px",
                        height: o.toString().indexOf("%") > 0 ? o : o + "px"
                    }), this.showView(i);
                    var a = this;
                    n.defer(function() {
                        a.trigger(f.JWPLAYER_SETUP_ERROR, {
                            message: t
                        })
                    })
                }
            }, v
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(272), n(271), n(4), n(6), n(2), n(3), n(1)], r = function(e, t, n, i, r, o, a) {
            function s(n) {
                var i = n.get("provider").name || "";
                return i.indexOf("flash") >= 0 ? t : e
            }
            var l = {
                        skipoffset: null,
                        tag: null
                    },
                    c = function(e, t, o) {
                        function c(e, t) {
                            t = t || {}, j.tag && !t.tag && (t.tag = j.tag), this.trigger(e, t)
                        }

                        function u(e) {
                            w._adModel.set("duration", e.duration), w._adModel.set("position", e.position)
                        }

                        function d(e) {
                            if (p && y + 1 < p.length) {
                                w._adModel.set("state", "buffering"), t.set("skipButton", !1), y++;
                                var i, r = p[y];
                                f && (i = f[y]), this.loadItem(r, i)
                            } else e.type === n.JWPLAYER_MEDIA_COMPLETE && (c.call(this, e.type, e), this.trigger(n.JWPLAYER_PLAYLIST_COMPLETE, {})), this.destroy()
                        }
                        var p, f, h, g, m, v = s(t),
                                w = new v(e, t),
                                y = 0,
                                j = {},
                                b = a.bind(function(e) {
                                    e = e || {}, e.hasControls = !!t.get("controls"), this.trigger(n.JWPLAYER_INSTREAM_CLICK, e), w && w._adModel && (w._adModel.get("state") === i.PAUSED ? e.hasControls && w.instreamPlay() : w.instreamPause())
                                }, this),
                                E = a.bind(function() {
                                    w && w._adModel && w._adModel.get("state") === i.PAUSED && t.get("controls") && (e.setFullscreen(), e.play())
                                }, this);
                        this.type = "instream", this.init = function() {
                            h = t.getVideo(), g = t.get("position"), m = t.get("playlist")[t.get("item")], w.on("all", c, this), w.on(n.JWPLAYER_MEDIA_TIME, u, this), w.on(n.JWPLAYER_MEDIA_COMPLETE, d, this), w.init(), h.detachMedia(), t.mediaModel.set("state", i.BUFFERING), e.checkBeforePlay() || 0 === g && !h.checkComplete() ? (g = 0, t.set("preInstreamState", "instream-preroll")) : h && h.checkComplete() || t.get("state") === i.COMPLETE ? t.set("preInstreamState", "instream-postroll") : t.set("preInstreamState", "instream-midroll");
                            var a = t.get("state");
                            return a !== i.PLAYING && a !== i.BUFFERING || h.pause(), o.setupInstream(w._adModel), w._adModel.set("state", i.BUFFERING), o.clickHandler().setAlternateClickHandlers(r.noop, null), this.setText("Loading ad"), this
                        }, this.loadItem = function(e, i) {
                            if (r.isAndroid(2.3)) return void this.trigger({
                                type: n.JWPLAYER_ERROR,
                                message: "Error loading instream: Cannot play instream on Android 2.3"
                            });
                            a.isArray(e) && (p = e, f = i, e = p[y], f && (i = f[y])), this.trigger(n.JWPLAYER_PLAYLIST_ITEM, {
                                index: y,
                                item: e
                            }), j = a.extend({}, l, i), w.load(e), this.addClickHandler();
                            var o = e.skipoffset || j.skipoffset;
                            o && (w._adModel.set("skipMessage", j.skipMessage), w._adModel.set("skipText", j.skipText), w._adModel.set("skipOffset", o), t.set("skipButton", !0))
                        }, this.applyProviderListeners = function(e) {
                            w.applyProviderListeners(e), this.addClickHandler()
                        }, this.play = function() {
                            w.instreamPlay()
                        }, this.pause = function() {
                            w.instreamPause()
                        }, this.hide = function() {
                            w.hide()
                        }, this.addClickHandler = function() {
                            o.clickHandler().setAlternateClickHandlers(b, E), w.on(n.JWPLAYER_MEDIA_META, this.metaHandler, this)
                        }, this.skipAd = function(e) {
                            var t = n.JWPLAYER_AD_SKIPPED;
                            this.trigger(t, e), d.call(this, {
                                type: t
                            })
                        }, this.metaHandler = function(e) {
                            e.width && e.height && o.resizeMedia()
                        }, this.destroy = function() {
                            if (this.off(), t.set("skipButton", !1), w) {
                                o.clickHandler() && o.clickHandler().revertAlternateClickHandlers(), w.instreamDestroy(), o.destroyInstream(), w = null, e.attachMedia();
                                var n = t.get("preInstreamState");
                                switch (n) {
                                    case "instream-preroll":
                                    case "instream-midroll":
                                        var s = a.extend({}, m);
                                        s.starttime = g, t.loadVideo(s), r.isMobile() && t.mediaModel.get("state") === i.BUFFERING && h.setState(i.BUFFERING), h.play();
                                        break;
                                    case "instream-postroll":
                                    case "instream-idle":
                                        h.stop()
                                }
                            }
                        }, this.getState = function() {
                            return w && w._adModel ? w._adModel.get("state") : !1
                        }, this.setText = function(e) {
                            o.setAltText(e ? e : "")
                        }, this.hide = function() {
                            o.useExternalControls()
                        }
                    };
            return a.extend(c.prototype, o), c
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(3), n(55), n(83), n(4), n(6), n(2), n(1)], r = function(e, t, n, i, r, o, a) {
            var s = function(e, i) {
                this.model = i, this._adModel = (new t).setup({
                    id: i.get("id"),
                    volume: i.get("volume"),
                    fullscreen: i.get("fullscreen"),
                    mute: i.get("mute")
                }), this._adModel.on("change:state", n, this);
                var r = e.getContainer();
                this.swf = r.querySelector("object")
            };
            return s.prototype = a.extend({
                init: function() {
                    if (o.isChrome()) {
                        var e = -1,
                                t = !1;
                        this.swf.on("throttle", function(n) {
                            if (clearTimeout(e), "resume" === n.state) t && (t = !1, this.instreamPlay());
                            else {
                                var i = this;
                                e = setTimeout(function() {
                                    i._adModel.get("state") === r.PLAYING && (t = !0, i.instreamPause())
                                }, 250)
                            }
                        }, this)
                    }
                    this.swf.on("instream:state", function(e) {
                        switch (e.newstate) {
                            case r.PLAYING:
                                this._adModel.set("state", e.newstate);
                                break;
                            case r.PAUSED:
                                this._adModel.set("state", e.newstate)
                        }
                    }, this).on("instream:time", function(e) {
                        this._adModel.set("position", e.position), this._adModel.set("duration", e.duration), this.trigger(i.JWPLAYER_MEDIA_TIME, e)
                    }, this).on("instream:complete", function(e) {
                        this.trigger(i.JWPLAYER_MEDIA_COMPLETE, e)
                    }, this).on("instream:error", function(e) {
                        this.trigger(i.JWPLAYER_MEDIA_ERROR, e)
                    }, this), this.swf.triggerFlash("instream:init"), this.applyProviderListeners = function(e) {
                        this.model.on("change:volume", function(t, n) {
                            e.volume(n)
                        }, this), this.model.on("change:mute", function(t, n) {
                            e.mute(n)
                        }, this)
                    }
                },
                instreamDestroy: function() {
                    this._adModel && (this.off(), this.swf.off(null, null, this), this.swf.triggerFlash("instream:destroy"), this.swf = null, this._adModel.off(), this._adModel = null, this.model = null)
                },
                load: function(e) {
                    this.swf.triggerFlash("instream:load", e)
                },
                instreamPlay: function() {
                    this.swf.triggerFlash("instream:play")
                },
                instreamPause: function() {
                    this.swf.triggerFlash("instream:pause")
                }
            }, e), s
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(3), n(83), n(4), n(6), n(55)], r = function(e, t, n, i, r, o) {
            var a = function(a, s) {
                function l(t) {
                    var r = t || p.getVideo();
                    if (f !== r) {
                        if (f = r, !r) return;
                        r.off(), r.on("all", function(t, n) {
                            n = e.extend({}, n, {
                                type: t
                            }), this.trigger(t, n)
                        }, h), r.on(i.JWPLAYER_MEDIA_BUFFER_FULL, d), r.on(i.JWPLAYER_PLAYER_STATE, c), r.attachMedia(), r.volume(s.get("volume")), r.mute(s.get("mute")), p.on("change:state", n, h)
                    }
                }

                function c(e) {
                    switch (e.newstate) {
                        case r.PLAYING:
                            p.set("state", e.newstate);
                            break;
                        case r.PAUSED:
                            p.set("state", e.newstate)
                    }
                }

                function u(e) {
                    s.trigger(e.type, e), h.trigger(i.JWPLAYER_FULLSCREEN, {
                        fullscreen: e.jwstate
                    })
                }

                function d() {
                    p.getVideo().play()
                }
                var p, f, h = e.extend(this, t);
                return a.on(i.JWPLAYER_FULLSCREEN, function(e) {
                    this.trigger(i.JWPLAYER_FULLSCREEN, e)
                }, h), this.init = function() {
                    p = (new o).setup({
                        id: s.get("id"),
                        volume: s.get("volume"),
                        fullscreen: s.get("fullscreen"),
                        mute: s.get("mute")
                    }), p.on("fullscreenchange", u), this._adModel = p
                }, h.load = function(e) {
                    p.set("item", 0), p.set("playlistItem", e), p.setActiveItem(e), l(), p.off(i.JWPLAYER_ERROR), p.on(i.JWPLAYER_ERROR, function(e) {
                        this.trigger(i.JWPLAYER_ERROR, e)
                    }, h), p.loadVideo(e)
                }, h.applyProviderListeners = function(e) {
                    l(e), e.off(i.JWPLAYER_ERROR), e.on(i.JWPLAYER_ERROR, function(e) {
                        this.trigger(i.JWPLAYER_ERROR, e)
                    }, h), s.on("change:volume", function(e, t) {
                        f.volume(t)
                    }, h), s.on("change:mute", function(e, t) {
                        f.mute(t)
                    }, h)
                }, this.instreamDestroy = function() {
                    p && (p.off(), this.off(), f && (f.detachMedia(), f.off(), p.getVideo() && f.destroy()), p = null, a.off(null, null, this), a = null)
                }, h.instreamPlay = function() {
                    p.getVideo() && p.getVideo().play(!0)
                }, h.instreamPause = function() {
                    p.getVideo() && p.getVideo().pause(!0)
                }, h
            };
            return a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(133), n(4), n(1)], r = function(e, t, n) {
            function i(e) {
                e.mediaController.off(t.JWPLAYER_MEDIA_PLAY_ATTEMPT, e._onPlayAttempt), e.mediaController.off(t.JWPLAYER_PROVIDER_FIRST_FRAME, e._triggerFirstFrame), e.mediaController.off(t.JWPLAYER_MEDIA_TIME, e._onTime)
            }

            function r(e) {
                i(e), e._triggerFirstFrame = n.once(function() {
                    var n = e._qoeItem;
                    n.tick(t.JWPLAYER_MEDIA_FIRST_FRAME);
                    var r = n.between(t.JWPLAYER_MEDIA_PLAY_ATTEMPT, t.JWPLAYER_MEDIA_FIRST_FRAME);
                    e.mediaController.trigger(t.JWPLAYER_MEDIA_FIRST_FRAME, {
                        loadTime: r
                    }), i(e)
                }), e._onTime = a(e._triggerFirstFrame), e._onPlayAttempt = function() {
                    e._qoeItem.tick(t.JWPLAYER_MEDIA_PLAY_ATTEMPT)
                }, e.mediaController.on(t.JWPLAYER_MEDIA_PLAY_ATTEMPT, e._onPlayAttempt), e.mediaController.once(t.JWPLAYER_PROVIDER_FIRST_FRAME, e._triggerFirstFrame), e.mediaController.on(t.JWPLAYER_MEDIA_TIME, e._onTime)
            }

            function o(n) {
                function i(n, i, o) {
                    n._qoeItem && o && n._qoeItem.end(o.get("state")), n._qoeItem = new e, n._qoeItem.tick(t.JWPLAYER_PLAYLIST_ITEM), n._qoeItem.start(i.get("state")), r(n), i.on("change:state", function(e, t, i) {
                        n._qoeItem.end(i), n._qoeItem.start(t)
                    })
                }
                n.on("change:mediaModel", i)
            }
            var a = function(e) {
                var t = Number.MIN_VALUE;
                return function(n) {
                    n.position > t && e(), t = n.position
                }
            };
            return {
                model: o
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(47), n(41), n(122), n(32), n(44), n(1), n(2), n(4)], r = function(e, t, i, r, o, a, s, l) {
            function c() {
                var e = {
                    LOAD_PROMISE_POLYFILL: {
                        method: u,
                        depends: []
                    },
                    LOAD_BASE64_POLYFILL: {
                        method: d,
                        depends: []
                    },
                    LOADED_POLYFILLS: {
                        method: p,
                        depends: ["LOAD_PROMISE_POLYFILL", "LOAD_BASE64_POLYFILL"]
                    },
                    LOAD_PLUGINS: {
                        method: f,
                        depends: ["LOADED_POLYFILLS"]
                    },
                    INIT_PLUGINS: {
                        method: h,
                        depends: ["LOAD_PLUGINS", "SETUP_VIEW"]
                    },
                    LOAD_PROVIDERS: {
                        method: E,
                        depends: ["FILTER_PLAYLIST"]
                    },
                    LOAD_SKIN: {
                        method: b,
                        depends: ["LOADED_POLYFILLS"]
                    },
                    LOAD_PLAYLIST: {
                        method: m,
                        depends: ["LOADED_POLYFILLS"]
                    },
                    FILTER_PLAYLIST: {
                        method: v,
                        depends: ["LOAD_PLAYLIST"]
                    },
                    SETUP_VIEW: {
                        method: k,
                        depends: ["LOAD_SKIN"]
                    },
                    SEND_READY: {
                        method: A,
                        depends: ["INIT_PLUGINS", "LOAD_PROVIDERS", "SETUP_VIEW"]
                    }
                };
                return e
            }

            function u(e) {
                window.Promise ? e() : n.e(5, function(require) {
                    n(127), e()
                })
            }

            function d(e) {
                window.btoa && window.atob ? e() : n.e(6, function(require) {
                    n(126), e()
                })
            }

            function p(e) {
                e()
            }

            function f(e, n) {
                _ = t.loadPlugins(n.get("id"), n.get("plugins")), _.on(l.COMPLETE, e), _.on(l.ERROR, a.partial(g, e)), _.load()
            }

            function h(e, t, n) {
                _.setupPlugins(n, t), e()
            }

            function g(e, t) {
                L(e, "Could not load plugin", t.message)
            }

            function m(e, t) {
                var n = t.get("playlist");
                a.isString(n) ? (x = new i, x.on(l.JWPLAYER_PLAYLIST_LOADED, function(n) {
                    t.set("playlist", n.playlist), t.set("feedid", n.feedid), e()
                }), x.on(l.JWPLAYER_ERROR, a.partial(w, e)), x.load(n)) : e()
            }

            function v(e, t, n, i, r) {
                var o = t.get("playlist"),
                        a = r(o);
                a ? e() : w(e)
            }

            function w(e, t) {
                t && t.message ? L(e, "Error loading playlist", t.message) : L(e, "Error loading player", "No playable sources found")
            }

            function y(e, t) {
                return a.contains(o.SkinsLoadable, e) ? t + "skins/" + e + ".css" : void 0
            }

            function j(e) {
                for (var t = document.styleSheets, n = 0, i = t.length; i > n; n++)
                    if (t[n].href === e) return !0;
                return !1
            }

            function b(e, t) {
                var n = t.get("skin"),
                        i = t.get("skinUrl");
                if (a.contains(o.SkinsIncluded, n)) return void e();
                if (i || (i = y(n, t.get("base"))), a.isString(i) && !j(i)) {
                    t.set("skin-loading", !0);
                    var s = !0,
                            c = new r(i, s);
                    c.addEventListener(l.COMPLETE, function() {
                        t.set("skin-loading", !1)
                    }), c.addEventListener(l.ERROR, function() {
                        t.set("skin", "seven"), t.set("skin-loading", !1)
                    }), c.load()
                }
                a.defer(function() {
                    e()
                })
            }

            function E(t, n) {
                var i = n.getProviders(),
                        r = n.get("playlist"),
                        o = i.required(r);
                e.load(o).then(t)
            }

            function k(e, t, n, i) {
                i.setup(), e()
            }

            function A(e) {
                e({
                    type: "complete"
                })
            }

            function L(e, t, n) {
                e({
                    type: "error",
                    msg: t,
                    reason: n
                })
            }
            var _, x;
            return {
                getQueue: c,
                error: L
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(137), n(2)], r = function(e, t) {
            return n.p = t.loadFrom(), e.selectPlayer
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(14)], r = function(e) {
            function t(e) {
                e || n()
            }

            function n() {
                throw new Error("Invalid DFXP file")
            }
            var i = e.seconds;
            return function(r) {
                t(r);
                var o = [],
                        a = r.getElementsByTagName("p");
                t(a), a.length || (a = r.getElementsByTagName("tt:p"), a.length || (a = r.getElementsByTagName("tts:p")));
                for (var s = 0; s < a.length; s++) {
                    var l = a[s],
                            c = l.innerHTML || l.textContent || l.text || "",
                            u = e.trim(c).replace(/>\s+</g, "><").replace(/tts?:/g, "");
                    if (u) {
                        var d = l.getAttribute("begin"),
                                p = l.getAttribute("dur"),
                                f = l.getAttribute("end"),
                                h = {
                                    begin: i(d),
                                    text: u
                                };
                        f ? h.end = i(f) : p && (h.end = h.begin + i(p)), o.push(h)
                    }
                }
                return o.length || n(), o
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(40), n(14), n(2)], r = function(e, t, n) {
            var i = "jwplayer",
                    r = function(r, o) {
                        for (var a = [], s = [], l = t.xmlAttribute, c = "default", u = "label", d = "file", p = "type", f = 0; f < r.childNodes.length; f++) {
                            var h = r.childNodes[f];
                            if (h.prefix === i) {
                                var g = e.localName(h);
                                "source" === g ? (delete o.sources, a.push({
                                    file: l(h, d),
                                    "default": l(h, c),
                                    label: l(h, u),
                                    type: l(h, p)
                                })) : "track" === g ? (delete o.tracks, s.push({
                                    file: l(h, d),
                                    "default": l(h, c),
                                    kind: l(h, "kind"),
                                    label: l(h, u)
                                })) : (o[g] = n.serialize(e.textContent(h)), "file" === g && o.sources && delete o.sources)
                            }
                            o[d] || (o[d] = o.link)
                        }
                        if (a.length)
                            for (o.sources = [], f = 0; f < a.length; f++) a[f].file.length > 0 && (a[f][c] = "true" === a[f][c], a[f].label.length || delete a[f].label, o.sources.push(a[f]));
                        if (s.length)
                            for (o.tracks = [], f = 0; f < s.length; f++) s[f].file.length > 0 && (s[f][c] = "true" === s[f][c], s[f].kind = s[f].kind.length ? s[f].kind : "captions", s[f].label.length || delete s[f].label, o.tracks.push(s[f]));
                        return o
                    };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(40), n(14), n(2)], r = function(e, t, n) {
            var i = t.xmlAttribute,
                    r = e.localName,
                    o = e.textContent,
                    a = e.numChildren,
                    s = "media",
                    l = function(e, t) {
                        function c(e) {
                            var t = {
                                zh: "Chinese",
                                nl: "Dutch",
                                en: "English",
                                fr: "French",
                                de: "German",
                                it: "Italian",
                                ja: "Japanese",
                                pt: "Portuguese",
                                ru: "Russian",
                                es: "Spanish"
                            };
                            return t[e] ? t[e] : e
                        }
                        var u, d, p = "tracks",
                                f = [];
                        for (d = 0; d < a(e); d++)
                            if (u = e.childNodes[d], u.prefix === s) {
                                if (!r(u)) continue;
                                switch (r(u).toLowerCase()) {
                                    case "content":
                                        i(u, "duration") && (t.duration = n.seconds(i(u, "duration"))), a(u) > 0 && (t = l(u, t)), i(u, "url") && (t.sources || (t.sources = []), t.sources.push({
                                            file: i(u, "url"),
                                            type: i(u, "type"),
                                            width: i(u, "width"),
                                            label: i(u, "label")
                                        }));
                                        break;
                                    case "title":
                                        t.title = o(u);
                                        break;
                                    case "description":
                                        t.description = o(u);
                                        break;
                                    case "guid":
                                        t.mediaid = o(u);
                                        break;
                                    case "thumbnail":
                                        t.image || (t.image = i(u, "url"));
                                        break;
                                    case "player":
                                        break;
                                    case "group":
                                        l(u, t);
                                        break;
                                    case "subtitle":
                                        var h = {};
                                        h.file = i(u, "url"), h.kind = "captions", i(u, "lang").length > 0 && (h.label = c(i(u, "lang"))), f.push(h)
                                }
                            }
                        for (t.hasOwnProperty(p) || (t[p] = []), d = 0; d < f.length; d++) t[p].push(f[d]);
                        return t
                    };
            return l
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1)], r = function(e) {
            var t = {
                        kind: "captions",
                        "default": !1
                    },
                    n = function(n) {
                        return n && n.file ? e.extend({}, t, n) : void 0
                    };
            return n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(56), n(2), n(4), n(3), n(1), n(32)], r = function(e, t, n, i, r, o) {
            function a(e, t, n) {
                return function() {
                    var i = e.getContainer().getElementsByClassName("jw-overlays")[0];
                    i && (i.appendChild(n), n.left = i.style.left, n.top = i.style.top, t.displayArea = i)
                }
            }

            function s(e) {
                function t() {
                    var t = e.displayArea;
                    t && e.resize(t.clientWidth, t.clientHeight)
                }
                return function() {
                    t(), setTimeout(t, 400)
                }
            }
            var l = function(l, c) {
                function u() {
                    m || (m = !0, g = o.loaderstatus.COMPLETE, h.trigger(n.COMPLETE))
                }

                function d() {
                    if (!w && (c && 0 !== r.keys(c).length || u(), !m)) {
                        var i = l.getPlugins();
                        f = r.after(v, u), r.each(c, function(r, a) {
                            var s = e.getPluginName(a),
                                    l = i[s],
                                    c = l.getJS(),
                                    u = l.getTarget(),
                                    d = l.getStatus();
                            d !== o.loaderstatus.LOADING && d !== o.loaderstatus.NEW && (c && !t.versionCheck(u) && h.trigger(n.ERROR, {
                                message: "Incompatible player version"
                            }), f())
                        })
                    }
                }

                function p(e) {
                    if (!w) {
                        var i = "File not found";
                        e.url && t.log(i, e.url), this.off(), this.trigger(n.ERROR, {
                            message: i
                        }), d()
                    }
                }
                var f, h = r.extend(this, i),
                        g = o.loaderstatus.NEW,
                        m = !1,
                        v = r.size(c),
                        w = !1;
                this.setupPlugins = function(n, i) {
                    var o = [],
                            c = l.getPlugins(),
                            u = i.get("plugins");
                    r.each(u, function(i, l) {
                        var d = e.getPluginName(l),
                                p = c[d],
                                f = p.getFlashPath(),
                                h = p.getJS(),
                                g = p.getURL();
                        if (f) {
                            var m = r.extend({
                                name: d,
                                swf: f,
                                pluginmode: p.getPluginmode()
                            }, i);
                            o.push(m)
                        }
                        var v = t.tryCatch(function() {
                            if (h && u[g]) {
                                var e = document.createElement("div");
                                e.id = n.id + "_" + d, e.className = "jw-plugin jw-reset";
                                var t = r.extend({}, u[g]),
                                        i = p.getNewInstance(n, t, e);
                                i.addToPlayer = a(n, i, e), i.resizeHandler = s(i), n.addPlugin(d, i, e)
                            }
                        });
                        v instanceof t.Error && t.log("ERROR: Failed to load " + d + ".")
                    }), i.set("flashPlugins", o)
                }, this.load = function() {
                    if (t.exists(c) && "object" !== t.typeOf(c)) return void d();
                    g = o.loaderstatus.LOADING, r.each(c, function(e, i) {
                        if (t.exists(i)) {
                            var r = l.addPlugin(i);
                            r.on(n.COMPLETE, d), r.on(n.ERROR, p)
                        }
                    });
                    var e = l.getPlugins();
                    r.each(e, function(e) {
                        e.load()
                    }), d()
                }, this.destroy = function() {
                    w = !0, this.off()
                }, this.getStatus = function() {
                    return g
                }
            };
            return l
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(56), n(125)], r = function(e, t) {
            var n = function(n) {
                this.addPlugin = function(i) {
                    var r = e.getPluginName(i);
                    return n[r] || (n[r] = new t(i)), n[r]
                }, this.getPlugins = function() {
                    return n
                }
            };
            return n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(1), n(135)], r = function(e, t, n) {
            function i(t) {
                if ("hls" === t.type)
                    if (t.androidhls !== !1) {
                        var n = e.isAndroidNative;
                        if (n(2) || n(3) || n("4.0")) return !1;
                        if (e.isAndroid()) return !0
                    } else if (e.isAndroid()) return !1;
                return null
            }
            var r = [{
                name: "youtube",
                supports: function(t) {
                    return e.isYouTube(t.file, t.type)
                }
            }, {
                name: "html5",
                supports: function(t) {
                    var r = {
                                aac: "audio/mp4",
                                mp4: "video/mp4",
                                f4v: "video/mp4",
                                m4v: "video/mp4",
                                mov: "video/mp4",
                                mp3: "audio/mpeg",
                                mpeg: "audio/mpeg",
                                ogv: "video/ogg",
                                ogg: "video/ogg",
                                oga: "video/ogg",
                                vorbis: "video/ogg",
                                webm: "video/webm",
                                f4a: "video/aac",
                                m3u8: "application/vnd.apple.mpegurl",
                                m3u: "application/vnd.apple.mpegurl",
                                hls: "application/vnd.apple.mpegurl"
                            },
                            o = t.file,
                            a = t.type,
                            s = i(t);
                    if (null !== s) return s;
                    if (e.isRtmp(o, a)) return !1;
                    if (!r[a]) return !1;
                    if (n.canPlayType) {
                        var l = n.canPlayType(r[a]);
                        return !!l
                    }
                    return !1
                }
            }, {
                name: "flash",
                supports: function(n) {
                    var i = {
                                flv: "video",
                                f4v: "video",
                                mov: "video",
                                m4a: "video",
                                m4v: "video",
                                mp4: "video",
                                aac: "video",
                                f4a: "video",
                                mp3: "sound",
                                mpeg: "sound",
                                smil: "rtmp"
                            },
                            r = t.keys(i);
                    if (!e.isFlashSupported()) return !1;
                    var o = n.file,
                            a = n.type;
                    return e.isRtmp(o, a) ? !0 : t.contains(r, a)
                }
            }];
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(31), n(89), n(128), n(1)], r = function(e, t, i, r) {
            function o(e) {
                this.providers = t.slice(), this.config = e || {}, this.reorderProviders()
            }
            return o.registerProvider = function(n) {
                var o = n.getName().name;
                if (!i[o]) {
                    if (!r.find(t, r.matches({
                                name: o
                            }))) {
                        if (!r.isFunction(n.supports)) throw {
                            message: "Tried to register a provider with an invalid object"
                        };
                        t.unshift({
                            name: o,
                            supports: n.supports
                        })
                    }
                    var a = function() {};
                    a.prototype = e, n.prototype = new a, i[o] = n
                }
            }, o.load = function(e) {
                return Promise.all(r.map(e, function(e) {
                    return new Promise(function(t) {
                        switch (e.name) {
                            case "html5":
                                ! function(require) {
                                    t(n(43))
                                }(n);
                                break;
                            case "flash":
                                ! function(require) {
                                    t(n(42))
                                }(n);
                                break;
                            case "youtube":
                                n.e(0, function(require) {
                                    t(n(57))
                                });
                                break;
                            default:
                                t()
                        }
                    }).then(function(e) {
                                e && o.registerProvider(e)
                            })
                }))
            }, r.extend(o.prototype, {
                reorderProviders: function() {
                    if ("flash" === this.config.primary) {
                        var e = r.indexOf(this.providers, r.findWhere(this.providers, {
                                    name: "flash"
                                })),
                                t = this.providers.splice(e, 1)[0],
                                n = r.indexOf(this.providers, r.findWhere(this.providers, {
                                    name: "html5"
                                }));
                        this.providers.splice(n, 0, t)
                    }
                },
                providerSupports: function(e, t) {
                    return e.supports(t)
                },
                required: function(e, t) {
                    return e = e.slice(), r.compact(r.map(this.providers, function(n) {
                        for (var i = !1, r = e.length; r--;) {
                            var o = e[r],
                                    a = n.supports(o.sources[0], t);
                            a && e.splice(r, 1), i = i || a
                        }
                        return i ? n : void 0
                    }))
                },
                choose: function(e) {
                    e = r.isObject(e) ? e : {};
                    for (var t = this.providers.length, n = 0; t > n; n++) {
                        var o = this.providers[n];
                        if (this.providerSupports(o, e)) {
                            var a = t - n - 1;
                            return {
                                priority: a,
                                name: o.name,
                                type: e.type,
                                provider: i[o.name]
                            }
                        }
                    }
                    return null
                }
            }), o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(86)], r = function(e, t) {
            function n(e) {
                e.onload = null, e.onprogress = null, e.onreadystatechange = null, e.onerror = null, "abort" in e && e.abort()
            }

            function i(t, i) {
                return function(r) {
                    var o = r.currentTarget || i.xhr;
                    if (clearTimeout(i.timeoutId), i.retryWithoutCredentials && i.xhr.withCredentials) {
                        n(o);
                        var a = e.extend({}, i, {
                            xhr: null,
                            withCredentials: !1,
                            retryWithoutCredentials: !1
                        });
                        return void d(a)
                    }
                    i.onerror(t, i.url, o)
                }
            }

            function r(e) {
                return function(t) {
                    var n = t.currentTarget || e.xhr;
                    if (4 === n.readyState) {
                        if (clearTimeout(e.timeoutId), n.status >= 400) {
                            var i;
                            return i = 404 === n.status ? "File not found" : "" + n.status + "(" + n.statusText + ")", e.onerror(i, e.url, n)
                        }
                        if (200 === n.status) return o(e)(t)
                    }
                }
            }

            function o(e) {
                return function(n) {
                    var i = n.currentTarget || e.xhr;
                    if (clearTimeout(e.timeoutId), e.responseType) {
                        if ("json" === e.responseType) return a(i, e)
                    } else {
                        var r, o = i.responseXML;
                        if (o) try {
                            r = o.firstChild
                        } catch (l) {}
                        if (o && r) return s(i, o, e);
                        if (c && i.responseText && !o && (o = t.parseXML(i.responseText), o && o.firstChild)) return s(i, o, e);
                        if (e.requireValidXML) return void e.onerror("Invalid XML", e.url, i)
                    }
                    e.oncomplete(i)
                }
            }

            function a(t, n) {
                if (!t.response || e.isString(t.response) && '"' !== t.responseText.substr(1)) try {
                    t = e.extend({}, t, {
                        response: JSON.parse(t.responseText)
                    })
                } catch (i) {
                    return void n.onerror("Invalid JSON", n.url, t)
                }
                return n.oncomplete(t)
            }

            function s(t, n, i) {
                var r = n.documentElement;
                return i.requireValidXML && ("parsererror" === r.nodeName || r.getElementsByTagName("parsererror").length) ? void i.onerror("Invalid XML", i.url, t) : (t.responseXML || (t = e.extend({}, t, {
                    responseXML: n
                })), i.oncomplete(t))
            }
            var l = function() {},
                    c = !1,
                    u = function(e) {
                        var t = document.createElement("a"),
                                n = document.createElement("a");
                        t.href = location.href;
                        try {
                            return n.href = e, n.href = n.href, t.protocol + "//" + t.host != n.protocol + "//" + n.host
                        } catch (i) {}
                        return !0
                    },
                    d = function(t, a, s, d) {
                        e.isObject(t) && (d = t, t = d.url);
                        var p, f = e.extend({
                            xhr: null,
                            url: t,
                            withCredentials: !1,
                            retryWithoutCredentials: !1,
                            timeout: 6e4,
                            timeoutId: -1,
                            oncomplete: a || l,
                            onerror: s || l,
                            mimeType: d && !d.responseType ? "text/xml" : "",
                            requireValidXML: !1,
                            responseType: d && d.plainText ? "text" : ""
                        }, d);
                        if ("XDomainRequest" in window && u(t)) p = f.xhr = new window.XDomainRequest, p.onload = o(f), p.ontimeout = p.onprogress = l, c = !0;
                        else {
                            if (!("XMLHttpRequest" in window)) return void f.onerror("", t);
                            p = f.xhr = new window.XMLHttpRequest, p.onreadystatechange = r(f)
                        }
                        var h = i("Error loading file", f);
                        p.onerror = h, "overrideMimeType" in p ? f.mimeType && p.overrideMimeType(f.mimeType) : c = !0;
                        try {
                            t = t.replace(/#.*$/, ""), p.open("GET", t, !0)
                        } catch (g) {
                            return h(g), p
                        }
                        if (f.responseType) try {
                            p.responseType = f.responseType
                        } catch (g) {}
                        f.timeout && (f.timeoutId = setTimeout(function() {
                            n(p), f.onerror("Timeout", t, p)
                        }, f.timeout));
                        try {
                            f.withCredentials && "withCredentials" in p && (p.withCredentials = !0), p.send()
                        } catch (g) {
                            h(g)
                        }
                        return p
                    };
            return {
                ajax: d,
                crossdomain: u
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(3), n(1)], r = function(e, t, n) {
            function i(e, t, n) {
                var i = document.createElement("param");
                i.setAttribute("name", t), i.setAttribute("value", n), e.appendChild(i)
            }

            function r(r, o, l, c) {
                var u;
                if (c = c || "opaque", e.isMSIE()) {
                    var d = document.createElement("div");
                    o.appendChild(d), d.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%" id="' + l + '" name="' + l + '" tabindex="0"><param name="movie" value="' + r + '"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="wmode" value="' + c + '"><param name="bgcolor" value="' + s + '"><param name="menu" value="false"></object>';
                    for (var p = o.getElementsByTagName("object"), f = p.length; f--;) p[f].id === l && (u = p[f])
                } else u = document.createElement("object"), u.setAttribute("type", "application/x-shockwave-flash"), u.setAttribute("data", r), u.setAttribute("width", "100%"), u.setAttribute("height", "100%"), u.setAttribute("bgcolor", s), u.setAttribute("id", l), u.setAttribute("name", l), i(u, "allowfullscreen", "true"), i(u, "allowscriptaccess", "always"), i(u, "wmode", c), i(u, "menu", "false"), o.appendChild(u, o);
                return u.className = "jw-swf jw-reset", u.style.display = "block", u.style.position = "absolute", u.style.left = 0, u.style.right = 0, u.style.top = 0, u.style.bottom = 0, n.extend(u, t), u.queueCommands = !0, u.triggerFlash = function(t) {
                    var i = this;
                    if ("setup" !== t && i.queueCommands || !i.__externalCall) {
                        for (var r = i.__commandQueue, o = r.length; o--;) r[o][0] === t && r.splice(o, 1);
                        return r.push(Array.prototype.slice.call(arguments)), i
                    }
                    var s = Array.prototype.slice.call(arguments, 1),
                            l = e.tryCatch(function() {
                                if (s.length) {
                                    for (var e = s.length; e--;) "object" == typeof s[e] && n.each(s[e], a);
                                    var r = JSON.stringify(s);
                                    i.__externalCall(t, r)
                                } else i.__externalCall(t)
                            });
                    return l instanceof e.Error && (console.error(t, l), "setup" === t) ? (l.name = "Failed to setup flash", l) : i
                }, u.__commandQueue = [], u
            }

            function o(e) {
                e && e.parentNode && (e.style.display = "none", e.parentNode.removeChild(e))
            }

            function a(e, t, n) {
                e instanceof window.HTMLElement && delete n[t]
            }
            var s = "#000000";
            return {
                embed: r,
                remove: o
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            return {
                hasClass: function(e, t) {
                    var n = " " + t + " ";
                    return 1 === e.nodeType && (" " + e.className + " ").replace(/[\t\r\n\f]/g, " ").indexOf(n) >= 0
                }
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(3)], r = function(e, t) {
            var n = e.extend({
                get: function(e) {
                    return this.attributes = this.attributes || {}, this.attributes[e]
                },
                set: function(e, t) {
                    if (this.attributes = this.attributes || {}, this.attributes[e] !== t) {
                        var n = this.attributes[e];
                        this.attributes[e] = t, this.trigger("change:" + e, this, t, n)
                    }
                },
                clone: function() {
                    return e.clone(this.attributes)
                }
            }, t);
            return n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(45), n(6), n(1)], r = function(e, t, n, i) {
            var r = t.style,
                    o = {
                        back: !0,
                        fontSize: 15,
                        fontFamily: "Arial,sans-serif",
                        fontOpacity: 100,
                        color: "#FFF",
                        backgroundColor: "#000",
                        backgroundOpacity: 100,
                        edgeStyle: null,
                        windowColor: "#FFF",
                        windowOpacity: 0,
                        preprocessor: i.identity
                    },
                    a = function(a) {
                        function s(t) {
                            t = t || "";
                            var n = "jw-captions-window jw-reset";
                            t ? (y.innerHTML = t, w.className = n + " jw-captions-window-active") : (w.className = n, e.empty(y))
                        }

                        function l(e) {
                            m = e, u(h, m)
                        }

                        function c(e, t) {
                            var n = e.source,
                                    r = t.metadata;
                            return n ? r && i.isNumber(r[n]) ? r[n] : !1 : t.position
                        }

                        function u(e, t) {
                            if (e && e.data && t) {
                                var n = c(e, t);
                                if (n !== !1) {
                                    var i = e.data;
                                    if (!(g >= 0 && d(i, g, n))) {
                                        for (var r = -1, o = 0; o < i.length; o++)
                                            if (d(i, o, n)) {
                                                r = o;
                                                break
                                            } - 1 === r ? s("") : r !== g && (g = r, s(j.preprocessor(i[g].text)))
                                    }
                                }
                            }
                        }

                        function d(e, t, n) {
                            return e[t].begin <= n && (!e[t].end || e[t].end >= n) && (t === e.length - 1 || e[t + 1].begin >= n)
                        }

                        function p(e, n, i) {
                            if (t.css("#" + e + " .jw-video::-webkit-media-text-track-display", n), t.css("#" + e + " .jw-video::cue", i), i.backgroundColor) {
                                var r = "{background-color: " + i.backgroundColor + " !important;}";
                                t.css("#" + e + " .jw-video::-webkit-media-text-track-display-backdrop", r)
                            }
                        }

                        function f(e, n, i) {
                            var r = t.hexToRgba("#000000", i);
                            "dropshadow" === e ? n.textShadow = "0 2px 1px " + r : "raised" === e ? n.textShadow = "0 0 5px " + r + ", 0 1px 5px " + r + ", 0 2px 5px " + r : "depressed" === e ? n.textShadow = "0 -2px 1px " + r : "uniform" === e && (n.textShadow = "-2px 0 1px " + r + ",2px 0 1px " + r + ",0 -2px 1px " + r + ",0 2px 1px " + r + ",-1px 1px 1px " + r + ",1px 1px 1px " + r + ",1px -1px 1px " + r + ",1px 1px 1px " + r)
                        }
                        var h, g, m, v, w, y, j = {};
                        v = document.createElement("div"), v.className = "jw-captions jw-reset", this.show = function() {
                            v.className = "jw-captions jw-captions-enabled jw-reset"
                        }, this.hide = function() {
                            v.className = "jw-captions jw-reset"
                        }, this.populate = function(e) {
                            return g = -1, h = e, e ? void u(e, m) : void s("")
                        }, this.resize = function() {
                            var e = v.clientWidth,
                                    t = Math.pow(e / 400, .6);
                            if (t) {
                                var n = j.fontSize * t;
                                r(v, {
                                    fontSize: Math.round(n) + "px"
                                })
                            }
                        }, this.setup = function(e, n) {
                            if (w = document.createElement("div"), y = document.createElement("span"), w.className = "jw-captions-window jw-reset", y.className = "jw-captions-text jw-reset", j = i.extend({}, o, n), n) {
                                var s = j.fontOpacity,
                                        l = j.windowOpacity,
                                        c = j.edgeStyle,
                                        u = j.backgroundColor,
                                        d = {},
                                        h = {
                                            color: t.hexToRgba(j.color, s),
                                            fontFamily: j.fontFamily,
                                            fontStyle: j.fontStyle,
                                            fontWeight: j.fontWeight,
                                            textDecoration: j.textDecoration
                                        };
                                l && (d.backgroundColor = t.hexToRgba(j.windowColor, l)), f(c, h, s), j.back ? h.backgroundColor = t.hexToRgba(u, j.backgroundOpacity) : null === c && f("uniform", h), r(w, d), r(y, h), p(e, d, h)
                            }
                            w.appendChild(y), v.appendChild(w), this.populate(a.get("captionsTrack"))
                        }, this.element = function() {
                            return v
                        }, a.on("change:playlistItem", function() {
                            m = null, g = -1, s("")
                        }, this), a.on("change:captionsTrack", function(e, t) {
                            this.populate(t)
                        }, this), a.mediaController.on("seek", function() {
                            g = -1
                        }, this), a.mediaController.on("time seek", l, this), a.mediaController.on("subtitlesTrackData", function() {
                            u(h, m)
                        }, this), a.on("change:state", function(e, t) {
                            switch (t) {
                                case n.IDLE:
                                case n.ERROR:
                                case n.COMPLETE:
                                    this.hide();
                                    break;
                                default:
                                    this.show()
                            }
                        }, this)
                    };
            return a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(12), n(4), n(3), n(1)], r = function(e, t, n, i) {
            var r = function(r, o, a) {
                function s(e) {
                    return r.get("flashBlocked") ? void 0 : u ? void u(e) : void h.trigger(e.type === t.touchEvents.CLICK ? "click" : "tap")
                }

                function l() {
                    return d ? void d() : void h.trigger("doubleClick")
                }
                var c, u, d, p = {
                    enableDoubleTap: !0,
                    useMove: !0
                };
                i.extend(this, n), c = o, this.element = function() {
                    return c
                };
                var f = new e(c, i.extend(p, a));
                f.on("click tap", s), f.on("doubleClick doubleTap", l), f.on("move", function() {
                    h.trigger("move")
                }), f.on("over", function() {
                    h.trigger("over")
                }), f.on("out", function() {
                    h.trigger("out")
                }), this.clickHandler = s;
                var h = this;
                this.setAlternateClickHandlers = function(e, t) {
                    u = e, d = t || null
                }, this.revertAlternateClickHandlers = function() {
                    u = null, d = null
                }
            };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2), n(84)], r = function(e, t, n) {
            function i(e, t) {
                this.time = e, this.text = t, this.el = document.createElement("div"), this.el.className = "jw-cue jw-reset"
            }
            e.extend(i.prototype, {
                align: function(e) {
                    if ("%" === this.time.toString().slice(-1)) this.pct = this.time;
                    else {
                        var t = this.time / e * 100;
                        this.pct = t + "%"
                    }
                    this.el.style.left = this.pct
                }
            });
            var r = {
                loadChapters: function(e) {
                    t.ajax(e, this.chaptersLoaded.bind(this), this.chaptersFailed, {
                        plainText: !0
                    })
                },
                chaptersLoaded: function(t) {
                    var i = n(t.responseText);
                    e.isArray(i) && (e.each(i, this.addCue, this), this.drawCues())
                },
                chaptersFailed: function() {},
                addCue: function(e) {
                    this.cues.push(new i(e.begin, e.text))
                },
                drawCues: function() {
                    var t = this._model.mediaModel.get("duration");
                    if (!t || 0 >= t) return void this._model.mediaModel.once("change:duration", this.drawCues, this);
                    var n = this;
                    e.each(this.cues, function(e) {
                        e.align(t), e.el.addEventListener("mouseover", function() {
                            n.activeCue = e
                        }), e.el.addEventListener("mouseout", function() {
                            n.activeCue = null
                        }), n.elementRail.appendChild(e.el)
                    })
                },
                resetChapters: function() {
                    e.each(this.cues, function(e) {
                        e.el.parentNode && e.el.parentNode.removeChild(e.el)
                    }, this), this.cues = []
                }
            };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(46), n(2), n(1), n(12)], r = function(e, t, n, i) {
            var r = e.extend({
                constructor: function(t) {
                    e.call(this, t), this.container.className = "jw-overlay-horizontal jw-reset", this.openClass = "jw-open-drawer", this.componentType = "drawer"
                },
                setup: function(e, r) {
                    this.iconUI || (this.iconUI = new i(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this)), this.reset(), e = n.isArray(e) ? e : [], this.activeContents = n.filter(e, function(e) {
                        return e.isActive
                    }), t.toggleClass(this.el, "jw-hidden", !r || this.activeContents.length < 2), r && this.activeContents.length > 1 && (t.removeClass(this.el, "jw-off"), this.iconUI.on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener), n.each(e, function(e) {
                        this.container.appendChild(e.el)
                    }, this))
                },
                reset: function() {
                    t.addClass(this.el, "jw-off"), this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(46), n(2), n(1), n(12), n(241)], r = function(e, t, n, i, r) {
            var o = e.extend({
                setup: function(e, o, a) {
                    this.iconUI || (this.iconUI = new i(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }), this.toggleValueListener = this.toggleValue.bind(this), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this), this.selectListener = this.select.bind(this)), this.reset(), e = n.isArray(e) ? e : [], t.toggleClass(this.el, "jw-hidden", e.length < 2);
                    var s = e.length > 2 || 2 === e.length && a && a.toggle === !1,
                            l = !s && 2 === e.length;
                    if (t.toggleClass(this.el, "jw-toggle", l), t.toggleClass(this.el, "jw-button-color", !l), this.isActive = s || l, s) {
                        t.removeClass(this.el, "jw-off"), this.iconUI.on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener);
                        var c = r(e),
                                u = t.createElement(c);
                        this.addContent(u), this.contentUI = new i(this.content).on("click tap", this.selectListener)
                    } else l && this.iconUI.on("click tap", this.toggleValueListener);
                    this.selectItem(o)
                },
                toggleValue: function() {
                    this.trigger("toggleValue")
                },
                select: function(e) {
                    if (e.target.parentElement === this.content) {
                        var i = t.classList(e.target),
                                r = n.find(i, function(e) {
                                    return 0 === e.indexOf("jw-item")
                                });
                        r && (this.trigger("select", parseInt(r.split("-")[2])), this.closeTooltipListener())
                    }
                },
                selectItem: function(e) {
                    if (this.content)
                        for (var n = 0; n < this.content.children.length; n++) t.toggleClass(this.content.children[n], "jw-active-option", e === n);
                    else t.toggleClass(this.el, "jw-off", 0 === e)
                },
                reset: function() {
                    t.addClass(this.el, "jw-off"), this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(1), n(46), n(12), n(243)], r = function(e, t, n, i, r) {
            var o = n.extend({
                setup: function(n, r) {
                    if (this.iconUI || (this.iconUI = new i(this.el, {
                                useHover: !0
                            }), this.toggleOpenStateListener = this.toggleOpenState.bind(this), this.openTooltipListener = this.openTooltip.bind(this), this.closeTooltipListener = this.closeTooltip.bind(this), this.selectListener = this.onSelect.bind(this)), this.reset(), n = t.isArray(n) ? n : [], e.toggleClass(this.el, "jw-hidden", n.length < 2), n.length >= 2) {
                        this.iconUI = new i(this.el, {
                            useHover: !0
                        }).on("tap", this.toggleOpenStateListener).on("over", this.openTooltipListener).on("out", this.closeTooltipListener);
                        var o = this.menuTemplate(n, r),
                                a = e.createElement(o);
                        this.addContent(a), this.contentUI = new i(this.content), this.contentUI.on("click tap", this.selectListener)
                    }
                    this.originalList = n
                },
                menuTemplate: function(n, i) {
                    var o = t.map(n, function(t, n) {
                        var r = t.title ? e.createElement(t.title).textContent : "";
                        return {
                            active: n === i,
                            label: n + 1 + ".",
                            title: r
                        }
                    });
                    return r(o)
                },
                onSelect: function(n) {
                    var i = n.target;
                    if ("UL" !== i.tagName) {
                        "LI" !== i.tagName && (i = i.parentElement);
                        var r = e.classList(i),
                                o = t.find(r, function(e) {
                                    return 0 === e.indexOf("jw-item")
                                });
                        o && (this.trigger("select", parseInt(o.split("-")[2])), this.closeTooltip())
                    }
                },
                selectItem: function(e) {
                    this.setup(this.originalList, e)
                },
                reset: function() {
                    this.iconUI.off(), this.contentUI && this.contentUI.off().destroy(), this.removeContent()
                }
            });
            return o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2), n(84)], r = function(e, t, n) {
            function i(e) {
                this.begin = e.begin, this.end = e.end, this.img = e.text
            }
            var r = {
                loadThumbnails: function(e) {
                    e && (this.vttPath = e.split("?")[0].split("/").slice(0, -1).join("/"), this.individualImage = null, t.ajax(e, this.thumbnailsLoaded.bind(this), this.thumbnailsFailed.bind(this), {
                        plainText: !0
                    }))
                },
                thumbnailsLoaded: function(t) {
                    var r = n(t.responseText);
                    e.isArray(r) && (e.each(r, function(e) {
                        this.thumbnails.push(new i(e))
                    }, this), this.drawCues())
                },
                thumbnailsFailed: function() {},
                chooseThumbnail: function(t) {
                    var n = e.sortedIndex(this.thumbnails, {
                        end: t
                    }, e.property("end"));
                    n >= this.thumbnails.length && (n = this.thumbnails.length - 1);
                    var i = this.thumbnails[n].img;
                    return i.indexOf("://") < 0 && (i = this.vttPath ? this.vttPath + "/" + i : i), i
                },
                loadThumbnail: function(t) {
                    var n = this.chooseThumbnail(t),
                            i = {
                                display: "block",
                                margin: "0 auto",
                                backgroundPosition: "0 0"
                            },
                            r = n.indexOf("#xywh");
                    if (r > 0) try {
                        var o = /(.+)\#xywh=(\d+),(\d+),(\d+),(\d+)/.exec(n);
                        n = o[1], i.backgroundPosition = -1 * o[2] + "px " + -1 * o[3] + "px", i.width = o[4], i.height = o[5]
                    } catch (a) {
                        return
                    } else this.individualImage || (this.individualImage = new Image, this.individualImage.onload = e.bind(function() {
                        this.individualImage.onload = null, this.timeTip.image({
                            width: this.individualImage.width,
                            height: this.individualImage.height
                        })
                    }, this), this.individualImage.src = n);
                    return i.backgroundImage = 'url("' + n + '")', i
                },
                showThumbnail: function(e) {
                    this.thumbnails.length < 1 || this.timeTip.image(this.loadThumbnail(e))
                },
                resetThumbnails: function() {
                    this.timeTip.image({
                        backgroundImage: "",
                        width: 0,
                        height: 0
                    }), this.thumbnails = []
                }
            };
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2), n(44), n(88), n(46), n(290), n(294)], r = function(e, t, n, i, r, o, a) {
            var s = r.extend({
                        setup: function() {
                            this.text = document.createElement("span"), this.text.className = "jw-text jw-reset", this.img = document.createElement("div"), this.img.className = "jw-reset";
                            var e = document.createElement("div");
                            e.className = "jw-time-tip jw-background-color jw-reset", e.appendChild(this.img), e.appendChild(this.text), t.removeClass(this.el, "jw-hidden"), this.addContent(e)
                        },
                        image: function(e) {
                            t.style(this.img, e)
                        },
                        update: function(e) {
                            this.text.innerHTML = e
                        }
                    }),
                    l = i.extend({
                        constructor: function(t, n) {
                            this._model = t, this._api = n, this.timeTip = new s("jw-tooltip-time"), this.timeTip.setup(), this.cues = [], this.seekThrottled = e.throttle(this.performSeek, 400), this._model.on("change:playlistItem", this.onPlaylistItem, this).on("change:position", this.onPosition, this).on("change:duration", this.onDuration, this).on("change:buffer", this.onBuffer, this), i.call(this, "jw-slider-time", "horizontal")
                        },
                        setup: function() {
                            i.prototype.setup.apply(this, arguments), this._model.get("playlistItem") && this.onPlaylistItem(this._model, this._model.get("playlistItem")), this.elementRail.appendChild(this.timeTip.element()), this.el.addEventListener("mousemove", this.showTimeTooltip.bind(this), !1), this.el.addEventListener("mouseout", this.hideTimeTooltip.bind(this), !1)
                        },
                        limit: function(i) {
                            if (this.activeCue && e.isNumber(this.activeCue.pct)) return this.activeCue.pct;
                            var r = this._model.get("duration"),
                                    o = t.adaptiveType(r);
                            if ("DVR" === o) {
                                var a = (1 - i / 100) * r,
                                        s = this._model.get("position"),
                                        l = Math.min(a, Math.max(n.dvrSeekLimit, s)),
                                        c = 100 * l / r;
                                return 100 - c
                            }
                            return i
                        },
                        update: function(e) {
                            this.seekTo = e, this.seekThrottled(), i.prototype.update.apply(this, arguments)
                        },
                        dragStart: function() {
                            this._model.set("scrubbing", !0), i.prototype.dragStart.apply(this, arguments)
                        },
                        dragEnd: function() {
                            i.prototype.dragEnd.apply(this, arguments), this._model.set("scrubbing", !1)
                        },
                        onSeeked: function() {
                            this._model.get("scrubbing") && this.performSeek()
                        },
                        onBuffer: function(e, t) {
                            this.updateBuffer(t)
                        },
                        onPosition: function(e, t) {
                            this.updateTime(t, e.get("duration"))
                        },
                        onDuration: function(e, t) {
                            this.updateTime(e.get("position"), t)
                        },
                        updateTime: function(e, n) {
                            var i = 0;
                            if (n) {
                                var r = t.adaptiveType(n);
                                "DVR" === r ? i = (n - e) / n * 100 : "VOD" === r && (i = e / n * 100)
                            }
                            this.render(i)
                        },
                        onPlaylistItem: function(t, n) {
                            this.reset(), t.mediaModel.on("seeked", this.onSeeked, this);
                            var i = n.tracks;
                            e.each(i, function(e) {
                                e && e.kind && "thumbnails" === e.kind.toLowerCase() ? this.loadThumbnails(e.file) : e && e.kind && "chapters" === e.kind.toLowerCase() && this.loadChapters(e.file)
                            }, this)
                        },
                        performSeek: function() {
                            var e, n = this.seekTo,
                                    i = this._model.get("duration"),
                                    r = t.adaptiveType(i);
                            0 === i ? this._api.play() : "DVR" === r ? (e = (100 - n) / 100 * i, this._api.seek(e)) : (e = n / 100 * i, this._api.seek(Math.min(e, i - .25)))
                        },
                        showTimeTooltip: function(e) {
                            var i = this._model.get("duration");
                            if (0 !== i) {
                                var r = t.bounds(this.elementRail),
                                        o = e.pageX ? e.pageX - r.left : e.x;
                                o = t.between(o, 0, r.width);
                                var a = o / r.width,
                                        s = i * a;
                                0 > i && (s = i - s);
                                var l;
                                if (this.activeCue) l = this.activeCue.text;
                                else {
                                    var c = !0;
                                    l = t.timeFormat(s, c), 0 > i && s > n.dvrSeekLimit && (l = "Live")
                                }
                                this.timeTip.update(l), this.showThumbnail(s), t.addClass(this.timeTip.el, "jw-open"), this.timeTip.el.style.left = 100 * a + "%"
                            }
                        },
                        hideTimeTooltip: function() {
                            t.removeClass(this.timeTip.el, "jw-open")
                        },
                        reset: function() {
                            this.resetChapters(), this.resetThumbnails()
                        }
                    });
            return e.extend(l.prototype, o, a), l
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(46), n(88), n(12), n(2)], r = function(e, t, n, i) {
            var r = e.extend({
                constructor: function(r, o) {
                    this._model = r, e.call(this, o), this.volumeSlider = new t("jw-slider-volume jw-volume-tip", "vertical"), this.addContent(this.volumeSlider.element()), this.volumeSlider.on("update", function(e) {
                        this.trigger("update", e)
                    }, this), i.removeClass(this.el, "jw-hidden"), new n(this.el, {
                        useHover: !0,
                        directSelect: !0
                    }).on("click", this.toggleValue, this).on("tap", this.toggleOpenState, this).on("over", this.openTooltip, this).on("out", this.closeTooltip, this), this._model.on("change:volume", this.onVolume, this)
                },
                toggleValue: function() {
                    this.trigger("toggleValue")
                }
            });
            return r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(1), n(3), n(44), n(12), n(88), n(295), n(292), n(293), n(296), n(291)], r = function(e, t, n, i, r, o, a, s, l, c, u) {
            function d(e, t) {
                var n = document.createElement("div");
                return n.className = "jw-icon jw-icon-inline jw-button-color jw-reset " + e, n.style.display = "none", t && new r(n).on("click tap", function() {
                    t()
                }), {
                    element: function() {
                        return n
                    },
                    toggle: function(e) {
                        e ? this.show() : this.hide()
                    },
                    show: function() {
                        n.style.display = ""
                    },
                    hide: function() {
                        n.style.display = "none"
                    }
                }
            }

            function p(e) {
                var t = document.createElement("span");
                return t.className = "jw-text jw-reset " + e, t
            }

            function f(e) {
                var t = new s(e);
                return t
            }

            function h(e, n) {
                var i = document.createElement("div");
                return i.className = "jw-group jw-controlbar-" + e + "-group jw-reset", t.each(n, function(e) {
                    e.element && (e = e.element()), i.appendChild(e)
                }), i
            }

            function g(t, n) {
                this._api = t, this._model = n, this._isMobile = e.isMobile(), this._compactModeMaxSize = 400, this._maxCompactWidth = -1, this.setup()
            }
            return t.extend(g.prototype, n, {
                setup: function() {
                    this.build(), this.initialize()
                },
                build: function() {
                    var e, n, i, r, s = new a(this._model, this._api),
                            g = new u("jw-icon-more");
                    this._model.get("visualplaylist") !== !1 && (e = new l("jw-icon-playlist")), this._isMobile || (r = d("jw-icon-volume", this._api.setMute), n = new o("jw-slider-volume", "horizontal"), i = new c(this._model, "jw-icon-volume")), this.elements = {
                        alt: p("jw-text-alt"),
                        play: d("jw-icon-playback", this._api.play.bind(this, {
                            reason: "interaction"
                        })),
                        prev: d("jw-icon-prev", this._api.playlistPrev.bind(this, {
                            reason: "interaction"
                        })),
                        next: d("jw-icon-next", this._api.playlistNext.bind(this, {
                            reason: "interaction"
                        })),
                        playlist: e,
                        elapsed: p("jw-text-elapsed"),
                        time: s,
                        duration: p("jw-text-duration"),
                        drawer: g,
                        hd: f("jw-icon-hd"),
                        cc: f("jw-icon-cc"),
                        audiotracks: f("jw-icon-audio-tracks"),
                        mute: r,
                        volume: n,
                        volumetooltip: i,
                        cast: d("jw-icon-cast jw-off", this._api.castToggle),
                        fullscreen: d("jw-icon-fullscreen", this._api.setFullscreen)
                    }, this.layout = {
                        left: [this.elements.play, this.elements.prev, this.elements.playlist, this.elements.next, this.elements.elapsed],
                        center: [this.elements.time, this.elements.alt],
                        right: [this.elements.duration, this.elements.hd, this.elements.cc, this.elements.audiotracks, this.elements.drawer, this.elements.mute, this.elements.cast, this.elements.volume, this.elements.volumetooltip, this.elements.fullscreen],
                        drawer: [this.elements.hd, this.elements.cc, this.elements.audiotracks]
                    }, this.menus = t.compact([this.elements.playlist, this.elements.hd, this.elements.cc, this.elements.audiotracks, this.elements.volumetooltip]), this.layout.left = t.compact(this.layout.left), this.layout.center = t.compact(this.layout.center), this.layout.right = t.compact(this.layout.right), this.layout.drawer = t.compact(this.layout.drawer), this.el = document.createElement("div"), this.el.className = "jw-controlbar jw-background-color jw-reset", this.elements.left = h("left", this.layout.left), this.elements.center = h("center", this.layout.center), this.elements.right = h("right", this.layout.right), this.el.appendChild(this.elements.left), this.el.appendChild(this.elements.center), this.el.appendChild(this.elements.right)
                },
                initialize: function() {
                    this.elements.play.show(), this.elements.fullscreen.show(), this.elements.mute && this.elements.mute.show(), this.onVolume(this._model, this._model.get("volume")), this.onPlaylist(this._model, this._model.get("playlist")), this.onPlaylistItem(this._model, this._model.get("playlistItem")), this.onMediaModel(this._model, this._model.get("mediaModel")), this.onCastAvailable(this._model, this._model.get("castAvailable")), this.onCastActive(this._model, this._model.get("castActive")), this.onCaptionsList(this._model, this._model.get("captionsList")), this._model.on("change:volume", this.onVolume, this), this._model.on("change:mute", this.onMute, this), this._model.on("change:playlist", this.onPlaylist, this), this._model.on("change:playlistItem", this.onPlaylistItem, this), this._model.on("change:mediaModel", this.onMediaModel, this), this._model.on("change:castAvailable", this.onCastAvailable, this), this._model.on("change:castActive", this.onCastActive, this), this._model.on("change:duration", this.onDuration, this), this._model.on("change:position", this.onElapsed, this), this._model.on("change:fullscreen", this.onFullscreen, this), this._model.on("change:captionsList", this.onCaptionsList, this), this._model.on("change:captionsIndex", this.onCaptionsIndex, this), this._model.on("change:compactUI", this.onCompactUI, this), this.elements.volume && this.elements.volume.on("update", function(e) {
                        var t = e.percentage;
                        this._api.setVolume(t)
                    }, this), this.elements.volumetooltip && (this.elements.volumetooltip.on("update", function(e) {
                        var t = e.percentage;
                        this._api.setVolume(t)
                    }, this), this.elements.volumetooltip.on("toggleValue", function() {
                        this._api.setMute()
                    }, this)), this.elements.playlist && this.elements.playlist.on("select", function(e) {
                        this._model.once("itemReady", function() {
                            this._api.play({
                                reason: "interaction"
                            })
                        }, this), this._api.load(e)
                    }, this), this.elements.hd.on("select", function(e) {
                        this._model.getVideo().setCurrentQuality(e)
                    }, this), this.elements.hd.on("toggleValue", function() {
                        this._model.getVideo().setCurrentQuality(0 === this._model.getVideo().getCurrentQuality() ? 1 : 0)
                    }, this), this.elements.cc.on("select", function(e) {
                        this._api.setCurrentCaptions(e)
                    }, this), this.elements.cc.on("toggleValue", function() {
                        var e = this._model.get("captionsIndex");
                        this._api.setCurrentCaptions(e ? 0 : 1)
                    }, this), this.elements.audiotracks.on("select", function(e) {
                        this._model.getVideo().setCurrentAudioTrack(e)
                    }, this), new r(this.elements.duration).on("click tap", function() {
                        if ("DVR" === e.adaptiveType(this._model.get("duration"))) {
                            var t = this._model.get("position");
                            this._api.seek(Math.max(i.dvrSeekLimit, t))
                        }
                    }, this), new r(this.el).on("click tap drag", function() {
                        this.trigger("userAction")
                    }, this), this.elements.drawer.on("open-drawer close-drawer", function(t, n) {
                        e.toggleClass(this.el, "jw-drawer-expanded", n.isOpen), n.isOpen || this.closeMenus()
                    }, this), t.each(this.menus, function(e) {
                        e.on("open-tooltip", this.closeMenus, this)
                    }, this)
                },
                onCaptionsList: function(e, t) {
                    var n = e.get("captionsIndex");
                    this.elements.cc.setup(t, n), this.clearCompactMode()
                },
                onCaptionsIndex: function(e, t) {
                    this.elements.cc.selectItem(t)
                },
                onPlaylist: function(e, t) {
                    var n = t.length > 1;
                    this.elements.next.toggle(n), this.elements.prev.toggle(n), this.elements.playlist && this.elements.playlist.setup(t, e.get("item"))
                },
                onPlaylistItem: function(e) {
                    this.elements.time.updateBuffer(0), this.elements.time.render(0), this.elements.duration.innerHTML = "00:00", this.elements.elapsed.innerHTML = "00:00", this.clearCompactMode();
                    var t = e.get("item");
                    this.elements.playlist && this.elements.playlist.selectItem(t), this.elements.audiotracks.setup()
                },
                onMediaModel: function(n, i) {
                    i.on("change:levels", function(e, t) {
                        this.elements.hd.setup(t, e.get("currentLevel")), this.clearCompactMode()
                    }, this), i.on("change:currentLevel", function(e, t) {
                        this.elements.hd.selectItem(t)
                    }, this), i.on("change:audioTracks", function(e, n) {
                        var i = t.map(n, function(e) {
                            return {
                                label: e.name
                            }
                        });
                        this.elements.audiotracks.setup(i, e.get("currentAudioTrack"), {
                            toggle: !1
                        }), this.clearCompactMode()
                    }, this), i.on("change:currentAudioTrack", function(e, t) {
                        this.elements.audiotracks.selectItem(t)
                    }, this), i.on("change:state", function(t, n) {
                        "complete" === n && (this.elements.drawer.closeTooltip(), e.removeClass(this.el, "jw-drawer-expanded"))
                    }, this)
                },
                onVolume: function(e, t) {
                    this.renderVolume(e.get("mute"), t)
                },
                onMute: function(e, t) {
                    this.renderVolume(t, e.get("volume"))
                },
                renderVolume: function(t, n) {
                    this.elements.mute && e.toggleClass(this.elements.mute.element(), "jw-off", t), this.elements.volume && this.elements.volume.render(t ? 0 : n), this.elements.volumetooltip && (this.elements.volumetooltip.volumeSlider.render(t ? 0 : n), e.toggleClass(this.elements.volumetooltip.element(), "jw-off", t))
                },
                onCastAvailable: function(e, t) {
                    this.elements.cast.toggle(t), this.clearCompactMode()
                },
                onCastActive: function(t, n) {
                    e.toggleClass(this.elements.cast.element(), "jw-off", !n)
                },
                onElapsed: function(t, n) {
                    var i, r = t.get("duration");
                    i = "DVR" === e.adaptiveType(r) ? "-" + e.timeFormat(-r) : e.timeFormat(n), this.elements.elapsed.innerHTML = i
                },
                onDuration: function(t, n) {
                    var i;
                    "DVR" === e.adaptiveType(n) ? (i = "Live", this.clearCompactMode()) : i = e.timeFormat(n), this.elements.duration.innerHTML = i
                },
                onFullscreen: function(t, n) {
                    e.toggleClass(this.elements.fullscreen.element(), "jw-off", n)
                },
                element: function() {
                    return this.el
                },
                getVisibleBounds: function() {
                    var t, n = this.el,
                            i = getComputedStyle ? getComputedStyle(n) : n.currentStyle;
                    return "table" === i.display ? e.bounds(n) : (n.style.visibility = "hidden", n.style.display = "table", t = e.bounds(n), n.style.visibility = n.style.display = "", t)
                },
                setAltText: function(e) {
                    this.elements.alt.innerHTML = e
                },
                addCues: function(e) {
                    this.elements.time && (t.each(e, function(e) {
                        this.elements.time.addCue(e)
                    }, this), this.elements.time.drawCues())
                },
                closeMenus: function(e) {
                    t.each(this.menus, function(t) {
                        e && e.target === t.el || t.closeTooltip(e)
                    })
                },
                hideComponents: function() {
                    this.closeMenus(), this.elements.drawer.closeTooltip(), e.removeClass(this.el, "jw-drawer-expanded")
                },
                clearCompactMode: function() {
                    this._maxCompactWidth = -1, this._model.set("compactUI", !1), this._containerWidth && this.checkCompactMode(this._containerWidth)
                },
                setCompactModeBounds: function() {
                    if (this.element().offsetWidth > 0) {
                        var t = this.elements.left.offsetWidth + this.elements.right.offsetWidth;
                        if ("LIVE" === e.adaptiveType(this._model.get("duration"))) this._maxCompactWidth = t + this.elements.alt.offsetWidth;
                        else {
                            var n = t + (this.elements.center.offsetWidth - this.elements.time.el.offsetWidth),
                                    i = .2;
                            this._maxCompactWidth = n / (1 - i)
                        }
                    }
                },
                checkCompactMode: function(e) {
                    -1 === this._maxCompactWidth && this.setCompactModeBounds(), this._containerWidth = e, -1 !== this._maxCompactWidth && (e >= this._compactModeMaxSize && e > this._maxCompactWidth ? this._model.set("compactUI", !1) : (e < this._compactModeMaxSize || e <= this._maxCompactWidth) && this._model.set("compactUI", !0))
                },
                onCompactUI: function(n, i) {
                    e.removeClass(this.el, "jw-drawer-expanded"), this.elements.drawer.setup(this.layout.drawer, i), (!i || this.elements.drawer.activeContents.length < 2) && t.each(this.layout.drawer, function(e) {
                        this.elements.right.insertBefore(e.el, this.elements.drawer.el)
                    }, this)
                }
            }), g
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(3), n(12), n(237), n(1)], r = function(e, t, n, i, r) {
            var o = function(o) {
                r.extend(this, t), this.model = o, this.el = e.createElement(i({}));
                var a = this;
                this.iconUI = new n(this.el).on("click tap", function(e) {
                    a.trigger(e.type)
                })
            };
            return r.extend(o.prototype, {
                element: function() {
                    return this.el
                }
            }), o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(238), n(2), n(1), n(12)], r = function(e, t, n, i) {
            var r = function(e) {
                this.model = e, this.setup(), this.model.on("change:dock", this.render, this)
            };
            return n.extend(r.prototype, {
                setup: function() {
                    var n = this.model.get("dock"),
                            r = this.click.bind(this),
                            o = e(n);
                    this.el = t.createElement(o), new i(this.el).on("click tap", r)
                },
                getDockButton: function(e) {
                    return t.hasClass(e.target, "jw-dock-button") ? e.target : t.hasClass(e.target, "jw-dock-text") ? e.target.parentElement.parentElement : e.target.parentElement
                },
                click: function(e) {
                    var t = this.getDockButton(e),
                            i = t.getAttribute("button"),
                            r = this.model.get("dock"),
                            o = n.findWhere(r, {
                                id: i
                            });
                    o && o.callback && o.callback(e)
                },
                render: function() {
                    var n = this.model.get("dock"),
                            i = e(n),
                            r = t.createElement(i);
                    this.el.innerHTML = r.innerHTML
                },
                element: function() {
                    return this.el
                }
            }), r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(239)], r = function(e) {
            function t(t, n, i, r) {
                return e({
                    id: t,
                    skin: n,
                    title: i,
                    body: r
                })
            }
            return t
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(12), n(2), n(4), n(1), n(3), n(240)], r = function(e, t, n, i, r, o) {
            var a = t.style,
                    s = {
                        linktarget: "_blank",
                        margin: 8,
                        hide: !1,
                        position: "top-right"
                    },
                    l = function(l) {
                        var c, u, d = new Image,
                                p = i.extend({}, l.get("logo"));
                        return i.extend(this, r), this.setup = function(r) {
                            if (u = i.extend({}, s, p), u.hide = "true" === u.hide.toString(), c = t.createElement(o()), u.file) {
                                u.hide && t.addClass(c, "jw-hide"), t.addClass(c, "jw-logo-" + (u.position || s.position)), "top-right" === u.position && (l.on("change:dock", this.topRight, this), l.on("change:controls", this.topRight, this), this.topRight(l)), l.set("logo", u), d.onload = function() {
                                    var e = {
                                        backgroundImage: 'url("' + this.src + '")',
                                        width: this.width,
                                        height: this.height
                                    };
                                    if (u.margin !== s.margin) {
                                        var t = /(\w+)-(\w+)/.exec(u.position);
                                        3 === t.length && (e["margin-" + t[1]] = u.margin, e["margin-" + t[2]] = u.margin)
                                    }
                                    a(c, e), l.set("logoWidth", e.width)
                                }, d.src = u.file;
                                var f = new e(c);
                                f.on("click tap", function(e) {
                                    t.exists(e) && e.stopPropagation && e.stopPropagation(), this.trigger(n.JWPLAYER_LOGO_CLICK, {
                                        link: u.link,
                                        linktarget: u.linktarget
                                    })
                                }, this), r.appendChild(c)
                            }
                        }, this.topRight = function(e) {
                            var t = e.get("controls"),
                                    n = e.get("dock"),
                                    i = t && (n && n.length || e.get("sharing") || e.get("related"));
                            a(c, {
                                top: i ? "3.5em" : 0
                            })
                        }, this.element = function() {
                            return c
                        }, this.position = function() {
                            return u.position
                        }, this.destroy = function() {
                            d.onload = null
                        }, this
                    };
            return l
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2)], r = function(e, t) {
            function n(e, t) {
                t.off("change:mediaType", null, this), t.on("change:mediaType", function(t, n) {
                    "audio" === n && this.setImage(e.get("playlistItem").image)
                }, this)
            }

            function i(e, n) {
                var i = e.get("autostart") && !t.isMobile() || e.get("item") > 0;
                return i ? (this.setImage(null), e.off("change:state", null, this), void e.on("change:state", function(e, t) {
                    "complete" !== t && "idle" !== t && "error" !== t || this.setImage(n.image)
                }, this)) : void this.setImage(n.image)
            }
            var r = function(e) {
                this.model = e, e.on("change:playlistItem", i, this), e.on("change:mediaModel", n, this)
            };
            return e.extend(r.prototype, {
                setup: function(e) {
                    this.el = e;
                    var t = this.model.get("playlistItem");
                    t && this.setImage(t.image)
                },
                setImage: function(n) {
                    this.model.off("change:state", null, this);
                    var i = "";
                    e.isString(n) && (i = 'url("' + n + '")'), t.style(this.el, {
                        backgroundImage: i
                    })
                },
                element: function() {
                    return this.el
                }
            }), r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(244), n(1), n(12), n(33)], r = function(e, t, n, i, r) {
            var o = function() {};
            return n.extend(o.prototype, {
                buildArray: function() {
                    var t = r.split("+"),
                            n = t[0],
                            i = {
                                items: [{
                                    title: "Powered by JW Player " + n,
                                    featured: !0,
                                    showLogo: !0,
                                    link: "https://jwplayer.com/learn-more/?m=h&e=o&v=" + r
                                }]
                            },
                            o = n.indexOf("-") > 0,
                            a = t[1];
                    if (o && a) {
                        var s = a.split(".");
                        i.items.push({
                            title: "build: (" + s[0] + "." + s[1] + ")",
                            link: "#"
                        })
                    }
                    var l = this.model.get("provider").name;
                    if (l.indexOf("flash") >= 0) {
                        var c = "Flash Version " + e.flashVersion();
                        i.items.push({
                            title: c,
                            link: "http://www.adobe.com/software/flash/about/"
                        })
                    }
                    return i
                },
                buildMenu: function() {
                    var n = this.buildArray();
                    return e.createElement(t(n))
                },
                updateHtml: function() {
                    this.el.innerHTML = this.buildMenu().innerHTML
                },
                rightClick: function(e) {
                    return this.lazySetup(), this.mouseOverContext ? !1 : (this.hideMenu(), this.showMenu(e), !1)
                },
                getOffset: function(e) {
                    for (var t = e.target, n = e.offsetX || e.layerX, i = e.offsetY || e.layerY; t !== this.playerElement;) n += t.offsetLeft, i += t.offsetTop, t = t.parentNode;
                    return {
                        x: n,
                        y: i
                    }
                },
                showMenu: function(t) {
                    var n = this.getOffset(t);
                    return this.el.style.left = n.x + "px", this.el.style.top = n.y + "px", e.addClass(this.playerElement, "jw-flag-rightclick-open"), e.addClass(this.el, "jw-open"), !1
                },
                hideMenu: function() {
                    this.mouseOverContext || (e.removeClass(this.playerElement, "jw-flag-rightclick-open"), e.removeClass(this.el, "jw-open"))
                },
                lazySetup: function() {
                    this.el || (this.el = this.buildMenu(), this.layer.appendChild(this.el), this.hideMenuHandler = this.hideMenu.bind(this), this.addOffListener(this.playerElement), this.addOffListener(document), this.model.on("change:provider", this.updateHtml, this), this.elementUI = new i(this.el, {
                        useHover: !0
                    }).on("over", function() {
                                this.mouseOverContext = !0
                            }, this).on("out", function() {
                                this.mouseOverContext = !1
                            }, this))
                },
                setup: function(e, t, n) {
                    this.playerElement = t, this.model = e, this.mouseOverContext = !1, this.layer = n, t.oncontextmenu = this.rightClick.bind(this)
                },
                addOffListener: function(e) {
                    e.addEventListener("mousedown", this.hideMenuHandler), e.addEventListener("touchstart", this.hideMenuHandler), e.addEventListener("pointerdown", this.hideMenuHandler)
                },
                removeOffListener: function(e) {
                    e.removeEventListener("mousedown", this.hideMenuHandler), e.removeEventListener("touchstart", this.hideMenuHandler), e.removeEventListener("pointerdown", this.hideMenuHandler)
                },
                destroy: function() {
                    this.el && (this.hideMenu(), this.elementUI.off(), this.removeOffListener(this.playerElement), this.removeOffListener(document), this.hideMenuHandler = null, this.el = null), this.playerElement && (this.playerElement.oncontextmenu = null, this.playerElement = null), this.model && (this.model.off("change:provider", this.updateHtml), this.model = null)
                }
            }), o
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(1), n(2)], r = function(e, t) {
            var n = function(e) {
                this.model = e, this.model.on("change:playlistItem", this.playlistItem, this)
            };
            return e.extend(n.prototype, {
                hide: function() {
                    this.el.style.display = "none"
                },
                show: function() {
                    this.el.style.display = ""
                },
                setup: function(e) {
                    this.el = e;
                    var t = this.el.getElementsByTagName("div");
                    this.title = t[0], this.description = t[1], this.model.get("playlistItem") && this.playlistItem(this.model, this.model.get("playlistItem")), this.model.on("change:logoWidth", this.update, this), this.model.on("change:dock", this.update, this)
                },
                update: function(e) {
                    var n = {
                                paddingLeft: 0,
                                paddingRight: 0
                            },
                            i = e.get("controls"),
                            r = e.get("dock"),
                            o = e.get("logo");
                    if (o) {
                        var a = 1 * ("" + o.margin).replace("px", ""),
                                s = e.get("logoWidth") + (isNaN(a) ? 0 : a);
                        "top-left" === o.position ? n.paddingLeft = s : "top-right" === o.position && (n.paddingRight = s)
                    }
                    if (i && r && r.length) {
                        var l = 56 * r.length;
                        n.paddingRight = Math.max(n.paddingRight, l)
                    }
                    t.style(this.el, n)
                },
                playlistItem: function(e, t) {
                    if (e.get("displaytitle") || e.get("displaydescription")) {
                        var n = "",
                                i = "";
                        t.title && e.get("displaytitle") && (n = t.title), t.description && e.get("displaydescription") && (i = t.description), this.updateText(n, i)
                    } else this.hide()
                },
                updateText: function(e, t) {
                    this.title.innerHTML = e, this.description.innerHTML = t, this.title.firstChild || this.description.firstChild ? this.show() : this.hide()
                },
                element: function() {
                    return this.el
                }
            }), n
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(4), n(3), n(44), n(6), n(288), n(289), n(298), n(299), n(301), n(297), n(302), n(322), n(304), n(1), n(242)], r = function(e, t, i, r, o, a, s, l, c, u, d, p, f, h, g, m) {
            var v = e.style,
                    w = e.bounds,
                    y = e.isMobile(),
                    j = ["fullscreenchange", "webkitfullscreenchange", "mozfullscreenchange", "MSFullscreenChange"],
                    b = function(b, E) {
                        function k(t) {
                            var n = 0,
                                    i = E.get("duration"),
                                    o = E.get("position");
                            "DVR" === e.adaptiveType(i) && (n = i, i = Math.max(o, r.dvrSeekLimit));
                            var a = e.between(o + t, n, i);
                            b.seek(a)
                        }

                        function A(t) {
                            var n = e.between(E.get("volume") + t, 0, 100);
                            b.setVolume(n)
                        }

                        function L(e) {
                            return e.ctrlKey || e.metaKey ? !1 : !!E.get("controls")
                        }

                        function _(e) {
                            if (!L(e)) return !0;
                            switch (Me || te(), e.keyCode) {
                                case 27:
                                    b.setFullscreen(!1);
                                    break;
                                case 13:
                                case 32:
                                    b.play({
                                        reason: "interaction"
                                    });
                                    break;
                                case 37:
                                    Me || k(-5);
                                    break;
                                case 39:
                                    Me || k(5);
                                    break;
                                case 38:
                                    A(10);
                                    break;
                                case 40:
                                    A(-10);
                                    break;
                                case 77:
                                    b.setMute();
                                    break;
                                case 70:
                                    b.setFullscreen();
                                    break;
                                default:
                                    if (e.keyCode >= 48 && e.keyCode <= 59) {
                                        var t = e.keyCode - 48,
                                                n = t / 10 * E.get("duration");
                                        b.seek(n)
                                    }
                            }
                            return /13|32|37|38|39|40/.test(e.keyCode) ? (e.preventDefault(), !1) : void 0
                        }

                        function x() {
                            Ne = !1, e.removeClass(ue, "jw-no-focus")
                        }

                        function C() {
                            Ne = !0, e.addClass(ue, "jw-no-focus")
                        }

                        function P() {
                            Ne || x(), Me || te()
                        }

                        function T() {
                            var e = w(ue),
                                    n = Math.round(e.width),
                                    i = Math.round(e.height);
                            return document.body.contains(ue) ? n && i && (n === fe && i === he || (fe = n, he = i, clearTimeout(Oe), Oe = setTimeout(q, 50), E.set("containerWidth", n), E.set("containerHeight", i), We.trigger(t.JWPLAYER_RESIZE, {
                                width: n,
                                height: i
                            }))) : (window.removeEventListener("resize", T), y && window.removeEventListener("orientationchange", T)), e
                        }

                        function R(t, n) {
                            n = n || !1, e.toggleClass(ue, "jw-flag-casting", n)
                        }

                        function I(t, n) {
                            e.toggleClass(ue, "jw-flag-cast-available", n), e.toggleClass(de, "jw-flag-cast-available", n)
                        }

                        function M(t, n) {
                            e.replaceClass(ue, /jw-stretch-\S+/, "jw-stretch-" + n)
                        }

                        function S(t, n) {
                            e.toggleClass(ue, "jw-flag-compact-player", n)
                        }

                        function O(e) {
                            e && !y && (e.element().addEventListener("mousemove", N, !1), e.element().addEventListener("mouseout", W, !1))
                        }

                        function D() {
                            E.get("state") !== o.IDLE && E.get("state") !== o.COMPLETE && E.get("state") !== o.PAUSED || !E.get("controls") || b.play({
                                reason: "interaction"
                            }), Se ? ee() : te()
                        }

                        function Y(e) {
                            e.link ? (b.pause(!0), b.setFullscreen(!1), window.open(e.link, e.linktarget)) : E.get("controls") && b.play({
                                reason: "interaction"
                            })
                        }

                        function N() {
                            clearTimeout(Te)
                        }

                        function W() {
                            te()
                        }

                        function F(e) {
                            We.trigger(e.type, e)
                        }

                        function J(t, n) {
                            n ? (Le && Le.destroy(), e.addClass(ue, "jw-flag-flash-blocked")) : (Le && Le.setup(E, ue, ue), e.removeClass(ue, "jw-flag-flash-blocked"))
                        }

                        function V() {
                            E.get("controls") && b.setFullscreen()
                        }

                        function B() {
                            var n = ue.getElementsByClassName("jw-overlays")[0];
                            n.addEventListener("mousemove", te), we = new s(E, pe, {
                                useHover: !0
                            }), we.on("click", function() {
                                F({
                                    type: t.JWPLAYER_DISPLAY_CLICK
                                }), E.get("controls") && b.play({
                                    reason: "interaction"
                                })
                            }), we.on("tap", function() {
                                F({
                                    type: t.JWPLAYER_DISPLAY_CLICK
                                }), D()
                            }), we.on("doubleClick", V), we.on("move", te), we.on("over", te);
                            var i = new l(E);
                            i.on("click", function() {
                                F({
                                    type: t.JWPLAYER_DISPLAY_CLICK
                                }), b.play({
                                    reason: "interaction"
                                })
                            }), i.on("tap", function() {
                                F({
                                    type: t.JWPLAYER_DISPLAY_CLICK
                                }), D()
                            }), e.isChrome() && i.el.addEventListener("mousedown", function() {
                                var e = E.getVideo(),
                                        t = e && 0 === e.getName().name.indexOf("flash");
                                if (t) {
                                    var n = function() {
                                        document.removeEventListener("mouseup", n), i.el.style.pointerEvents = "auto"
                                    };
                                    this.style.pointerEvents = "none", document.addEventListener("mouseup", n)
                                }
                            }), de.appendChild(i.element()), je = new c(E), be = new u(E), be.on(t.JWPLAYER_LOGO_CLICK, Y);
                            var r = document.createElement("div");
                            r.className = "jw-controls-right jw-reset", be.setup(r), r.appendChild(je.element()), de.appendChild(r), ke = new a(E), ke.setup(ue.id, E.get("captions")), de.parentNode.insertBefore(ke.element(), Ee.element());
                            var o = E.get("height");
                            y && ("string" == typeof o || o >= 1.5 * Ie) ? e.addClass(ue, "jw-flag-touch") : (Le = new f, Le.setup(E, ue, ue)), me = new d(b, E), me.on(t.JWPLAYER_USER_ACTION, te), E.on("change:scrubbing", H), E.on("change:compactUI", S), de.appendChild(me.element()), ue.addEventListener("focus", P), ue.addEventListener("blur", x), ue.addEventListener("keydown", _), ue.onmousedown = C
                        }

                        function U(t) {
                            return t.get("state") === o.PAUSED ? void t.once("change:state", U) : void(t.get("scrubbing") === !1 && e.removeClass(ue, "jw-flag-dragging"))
                        }

                        function H(t, n) {
                            t.off("change:state", U), n ? e.addClass(ue, "jw-flag-dragging") : U(t)
                        }

                        function z(t, n, i) {
                            var r, o = ue.className;
                            i = !!i, i && (o = o.replace(/\s*aspectMode/, ""), ue.className !== o && (ue.className = o), v(ue, {
                                display: "block"
                            }, i)), e.exists(t) && e.exists(n) && (E.set("width", t), E.set("height", n)), r = {
                                width: t
                            }, e.hasClass(ue, "jw-flag-aspect-mode") || (r.height = n), v(ue, r, !0), G(n), q(t, n)
                        }

                        function G(t) {
                            if (Ae = K(t), me && !Ae) {
                                var n = Me ? ge : E;
                                ce(n, n.get("state"))
                            }
                            e.toggleClass(ue, "jw-flag-audio-player", Ae)
                        }

                        function K(e) {
                            if (E.get("aspectratio")) return !1;
                            if (g.isString(e) && e.indexOf("%") > -1) return !1;
                            var t = g.isNumber(e) ? e : E.get("containerHeight");
                            return Q(t)
                        }

                        function Q(e) {
                            return e && Ie * (y ? 1.75 : 1) >= e
                        }

                        function q(t, n) {
                            if (!t || isNaN(Number(t))) {
                                if (!pe) return;
                                t = pe.clientWidth
                            }
                            if (!n || isNaN(Number(n))) {
                                if (!pe) return;
                                n = pe.clientHeight
                            }
                            e.isMSIE(9) && document.all && !window.atob && (t = n = "100%");
                            var i = E.getVideo();
                            if (i) {
                                var r = i.resize(t, n, E.get("stretching"));
                                r && (clearTimeout(Oe), Oe = setTimeout(q, 250)), ke.resize(), me.checkCompactMode(t)
                            }
                        }

                        function X() {
                            if (Ye) {
                                var e = document.fullscreenElement || document.webkitCurrentFullScreenElement || document.mozFullScreenElement || document.msFullscreenElement;
                                return !(!e || e.id !== E.get("id"))
                            }
                            return Me ? ge.getVideo().getFullScreen() : E.getVideo().getFullScreen()
                        }

                        function $(e) {
                            var t = E.get("fullscreen"),
                                    n = void 0 !== e.jwstate ? e.jwstate : X();
                            t !== n && E.set("fullscreen", n), clearTimeout(Oe), Oe = setTimeout(q, 200)
                        }

                        function Z(t, n) {
                            n ? (e.addClass(t, "jw-flag-fullscreen"), v(document.body, {
                                "overflow-y": "hidden"
                            }), te()) : (e.removeClass(t, "jw-flag-fullscreen"), v(document.body, {
                                "overflow-y": ""
                            })), q()
                        }

                        function ee() {
                            Se = !1, clearTimeout(Te), me.hideComponents(), e.addClass(ue, "jw-flag-user-inactive")
                        }

                        function te() {
                            Se || (e.removeClass(ue, "jw-flag-user-inactive"), me.checkCompactMode(pe.clientWidth)), Se = !0, clearTimeout(Te), Te = setTimeout(ee, Re)
                        }

                        function ne() {
                            b.setFullscreen(!1)
                        }

                        function ie() {
                            ye && ye.setState(E.get("state")), re(E, E.mediaModel.get("mediaType")), E.mediaModel.on("change:mediaType", re, this)
                        }

                        function re(t, n) {
                            var i = "audio" === n,
                                    r = E.getVideo(),
                                    o = r && 0 === r.getName().name.indexOf("flash");
                            e.toggleClass(ue, "jw-flag-media-audio", i), i && !o ? ue.insertBefore(ve.el, pe) : ue.insertBefore(ve.el, ke.element())
                        }

                        function oe(t, n) {
                            var i = "LIVE" === e.adaptiveType(n);
                            e.toggleClass(ue, "jw-flag-live", i), We.setAltText(i ? "Live Broadcast" : "")
                        }

                        function ae(e, t) {
                            return t ? void(t.name ? Ee.updateText(t.name, t.message) : Ee.updateText(t.message, "")) : void Ee.playlistItem(e, e.get("playlistItem"))
                        }

                        function se() {
                            var e = E.getVideo();
                            return e ? e.isCaster : !1
                        }

                        function le() {
                            e.replaceClass(ue, /jw-state-\S+/, "jw-state-" + _e)
                        }

                        function ce(t, n) {
                            if (_e = n, clearTimeout(De), n === o.COMPLETE || n === o.IDLE ? De = setTimeout(le, 100) : le(), se()) return void e.addClass(pe, "jw-media-show");
                            switch (n) {
                                case o.PLAYING:
                                    q();
                                    break;
                                case o.PAUSED:
                                    te()
                            }
                        }
                        var ue, de, pe, fe, he, ge, me, ve, we, ye, je, be, Ee, ke, Ae, Le, _e, xe, Ce, Pe, Te = -1,
                                Re = y ? 4e3 : 2e3,
                                Ie = 40,
                                Me = !1,
                                Se = !1,
                                Oe = -1,
                                De = -1,
                                Ye = !1,
                                Ne = !1,
                                We = g.extend(this, i);
                        window.webpackJsonpjwplayer && n(309), this.model = E, this.api = b, ue = e.createElement(m({
                            id: E.get("id")
                        })), e.isIE() && e.addClass(ue, "jw-ie");
                        var Fe = E.get("width"),
                                Je = E.get("height");
                        v(ue, {
                            width: Fe.toString().indexOf("%") > 0 ? Fe : Fe + "px",
                            height: Je.toString().indexOf("%") > 0 ? Je : Je + "px"
                        }), Ce = ue.requestFullscreen || ue.webkitRequestFullscreen || ue.webkitRequestFullScreen || ue.mozRequestFullScreen || ue.msRequestFullscreen, Pe = document.exitFullscreen || document.webkitExitFullscreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.msExitFullscreen, Ye = Ce && Pe, this.onChangeSkin = function(t, n) {
                            e.replaceClass(ue, /jw-skin-\S+/, n ? "jw-skin-" + n : "")
                        }, this.handleColorOverrides = function() {
                            function t(t, i, r) {
                                if (r) {
                                    t = e.prefix(t, "#" + n + " ");
                                    var o = {};
                                    o[i] = r, e.css(t.join(", "), o)
                                }
                            }
                            var n = E.get("id"),
                                    i = E.get("skinColorActive"),
                                    r = E.get("skinColorInactive"),
                                    o = E.get("skinColorBackground");
                            t([".jw-toggle", ".jw-button-color:hover"], "color", i), t([".jw-active-option", ".jw-progress", ".jw-playlist-container .jw-option.jw-active-option", ".jw-playlist-container .jw-option:hover"], "background", i), t([".jw-text", ".jw-option", ".jw-button-color", ".jw-toggle.jw-off", ".jw-tooltip-title", ".jw-skip .jw-skip-icon", ".jw-playlist-container .jw-icon"], "color", r), t([".jw-cue", ".jw-knob"], "background", r), t([".jw-playlist-container .jw-option"], "border-bottom-color", r), t([".jw-background-color", ".jw-tooltip-title", ".jw-playlist", ".jw-playlist-container .jw-option"], "background", o), t([".jw-playlist-container ::-webkit-scrollbar"], "border-color", o)
                        }, this.setup = function() {
                            this.handleColorOverrides(), E.get("skin-loading") === !0 && (e.addClass(ue, "jw-flag-skin-loading"), E.once("change:skin-loading", function() {
                                e.removeClass(ue, "jw-flag-skin-loading")
                            })), this.onChangeSkin(E, E.get("skin"), ""), E.on("change:skin", this.onChangeSkin, this), pe = ue.getElementsByClassName("jw-media")[0], de = ue.getElementsByClassName("jw-controls")[0];
                            var n = ue.getElementsByClassName("jw-preview")[0];
                            ve = new p(E), ve.setup(n);
                            var i = ue.getElementsByClassName("jw-title")[0];
                            Ee = new h(E), Ee.setup(i), B(), te(), E.set("mediaContainer", pe), E.mediaController.on("fullscreenchange", $);
                            for (var r = j.length; r--;) document.addEventListener(j[r], $, !1);
                            window.removeEventListener("resize", T), window.addEventListener("resize", T, !1), y && (window.removeEventListener("orientationchange", T), window.addEventListener("orientationchange", T, !1)), E.on("change:errorEvent", ae), E.on("change:controls", Ve), Ve(E, E.get("controls")), E.on("change:state", ce), E.on("change:duration", oe, this), E.on("change:flashBlocked", J), J(E, E.get("flashBlocked")), b.onPlaylistComplete(ne), b.onPlaylistItem(ie), E.on("change:castAvailable", I), I(E, E.get("castAvailable")), E.on("change:castActive", R), R(E, E.get("castActive")), E.get("stretching") && M(E, E.get("stretching")), E.on("change:stretching", M), ce(E, o.IDLE), E.on("change:fullscreen", Be), O(me), O(be);
                            var a = E.get("aspectratio");
                            if (a) {
                                e.addClass(ue, "jw-flag-aspect-mode");
                                var s = ue.getElementsByClassName("jw-aspect")[0];
                                v(s, {
                                    paddingTop: a
                                })
                            }
                            b.on(t.JWPLAYER_READY, function() {
                                T(), z(E.get("width"), E.get("height"))
                            })
                        };
                        var Ve = function(t, n) {
                                    if (n) {
                                        var i = Me ? ge.get("state") : E.get("state");
                                        ce(t, i)
                                    }
                                    e.toggleClass(ue, "jw-flag-controls-disabled", !n)
                                },
                                Be = function(t, n) {
                                    var i = E.getVideo();
                                    Ye ? (n ? Ce.apply(ue) : Pe.apply(document), Z(ue, n)) : e.isIE() ? Z(ue, n) : (ge && ge.getVideo() && ge.getVideo().setFullscreen(n), i.setFullscreen(n)), i && 0 === i.getName().name.indexOf("flash") && i.setFullscreen(n)
                                };
                        this.resize = function(e, t) {
                            var n = !0;
                            z(e, t, n), T()
                        }, this.resizeMedia = q, this.reset = function() {
                            document.contains(ue) && ue.parentNode.replaceChild(xe, ue), e.emptyElement(ue)
                        }, this.setupInstream = function(t) {
                            this.instreamModel = ge = t, ge.on("change:controls", Ve, this), ge.on("change:state", ce, this), Me = !0, e.addClass(ue, "jw-flag-ads"), te()
                        }, this.setAltText = function(e) {
                            me.setAltText(e)
                        }, this.useExternalControls = function() {
                            e.addClass(ue, "jw-flag-ads-hide-controls")
                        }, this.destroyInstream = function() {
                            if (Me = !1, ge && (ge.off(null, null, this), ge = null), this.setAltText(""), e.removeClass(ue, "jw-flag-ads"), e.removeClass(ue, "jw-flag-ads-hide-controls"), E.getVideo) {
                                var t = E.getVideo();
                                t.setContainer(pe)
                            }
                            oe(E, E.get("duration")), we.revertAlternateClickHandlers()
                        }, this.addCues = function(e) {
                            me && me.addCues(e)
                        }, this.clickHandler = function() {
                            return we
                        }, this.controlsContainer = function() {
                            return de
                        }, this.getContainer = this.element = function() {
                            return ue
                        }, this.getSafeRegion = function(t) {
                            var n = {
                                        x: 0,
                                        y: 0,
                                        width: E.get("containerWidth") || 0,
                                        height: E.get("containerHeight") || 0
                                    },
                                    i = E.get("dock");
                            return i && i.length && E.get("controls") && (n.y = je.element().clientHeight, n.height -= n.y), t = t || !e.exists(t), t && E.get("controls") && (n.height -= me.element().clientHeight), n
                        }, this.destroy = function() {
                            window.removeEventListener("resize", T), window.removeEventListener("orientationchange", T);
                            for (var t = j.length; t--;) document.removeEventListener(j[t], $, !1);
                            E.mediaController && E.mediaController.off("fullscreenchange", $), ue.removeEventListener("keydown", _, !1), Le && Le.destroy(), ye && (E.off("change:state", ye.statusDelegate), ye.destroy(), ye = null), Me && this.destroyInstream(), be && be.destroy(), e.clearCss("#" + E.get("id"))
                        }
                    };
            return b
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , function(e, t, n) {
        function i(e, t) {
            for (var n = 0; n < e.length; n++) {
                var i = e[n],
                        r = d[i.id];
                if (r) {
                    r.refs++;
                    for (var o = 0; o < r.parts.length; o++) r.parts[o](i.parts[o]);
                    for (; o < i.parts.length; o++) r.parts.push(l(i.parts[o], t))
                } else {
                    for (var a = [], o = 0; o < i.parts.length; o++) a.push(l(i.parts[o], t));
                    d[i.id] = {
                        id: i.id,
                        refs: 1,
                        parts: a
                    }
                }
            }
        }

        function r(e) {
            for (var t = [], n = {}, i = 0; i < e.length; i++) {
                var r = e[i],
                        o = r[0],
                        a = r[1],
                        s = r[2],
                        l = {
                            css: a,
                            media: s
                        };
                n[o] ? n[o].parts.push(l) : t.push(n[o] = {
                    id: o,
                    parts: [l]
                })
            }
            return t
        }

        function o(e, t) {
            var n = h(),
                    i = v[v.length - 1];
            if ("top" === e.insertAt) i ? i.nextSibling ? n.insertBefore(t, i.nextSibling) : n.appendChild(t) : n.insertBefore(t, n.firstChild), v.push(t);
            else {
                if ("bottom" !== e.insertAt) throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
                n.appendChild(t)
            }
        }

        function a(e) {
            e.parentNode.removeChild(e);
            var t = v.indexOf(e);
            t >= 0 && v.splice(t, 1)
        }

        function s(e) {
            var t = document.createElement("style");
            return t.type = "text/css", o(e, t), t
        }

        function l(e, t) {
            var n, i, r;
            if (t.singleton) {
                var o = m++;
                n = g || (g = s(t)), i = c.bind(null, n, o, !1), r = c.bind(null, n, o, !0)
            } else n = s(t), i = u.bind(null, n), r = function() {
                a(n)
            };
            return i(e),
                    function(t) {
                        if (t) {
                            if (t.css === e.css && t.media === e.media) return;
                            i(e = t)
                        } else r()
                    }
        }

        function c(e, t, n, i) {
            var r = n ? "" : i.css;
            if (e.styleSheet) e.styleSheet.cssText = w(t, r);
            else {
                var o = document.createTextNode(r),
                        a = e.childNodes;
                a[t] && e.removeChild(a[t]), a.length ? e.insertBefore(o, a[t]) : e.appendChild(o)
            }
        }

        function u(e, t) {
            var n = t.css,
                    i = t.media;
            if (i && e.setAttribute("media", i), e.styleSheet) e.styleSheet.cssText = n;
            else {
                for (; e.firstChild;) e.removeChild(e.firstChild);
                e.appendChild(document.createTextNode(n))
            }
        }
        var d = {},
                p = function(e) {
                    var t;
                    return function() {
                        return "undefined" == typeof t && (t = e.apply(this, arguments)), t
                    }
                },
                f = p(function() {
                    return /msie [6-9]\b/.test(window.navigator.userAgent.toLowerCase())
                }),
                h = p(function() {
                    return document.head || document.getElementsByTagName("head")[0]
                }),
                g = null,
                m = 0,
                v = [];
        e.exports = function(e, t) {
            t = t || {}, "undefined" == typeof t.singleton && (t.singleton = f()), "undefined" == typeof t.insertAt && (t.insertAt = "bottom");
            var n = r(e);
            return i(n, t),
                    function(e) {
                        for (var o = [], a = 0; a < n.length; a++) {
                            var s = n[a],
                                    l = d[s.id];
                            l.refs--, o.push(l)
                        }
                        if (e) {
                            var c = r(e);
                            i(c, t)
                        }
                        for (var a = 0; a < o.length; a++) {
                            var l = o[a];
                            if (0 === l.refs) {
                                for (var u = 0; u < l.parts.length; u++) l.parts[u]();
                                delete d[l.id]
                            }
                        }
                    }
        };
        var w = function() {
            var e = [];
            return function(t, n) {
                return e[t] = n, e.filter(Boolean).join("\n")
            }
        }()
    }, function(e, t, n) {
        var i = n(232);
        "string" == typeof i && (i = [
            [e.id, i, ""]
        ]);
        n(308)(i, {});
        i.locals && (e.exports = i.locals)
    }, , , function(e, t, n) {
        var i, r;
        i = [n(137), n(1), n(33), n(2), n(120), n(14), n(12), n(141), n(32), n(142), n(135), n(4), n(6), n(123), n(85), n(59), n(121), n(41)], r = function(e, t, n, i, r, o, a, s, l, c, u, d, p, f, h, g, m, v) {
            var w = {};
            return w.api = e, w._ = t, w.version = n, w.utils = t.extend(i, o, {
                canCast: g.available,
                key: s,
                extend: t.extend,
                scriptloader: l,
                rssparser: m,
                tea: c,
                UI: a
            }), w.utils.css.style = w.utils.style, w.vid = u, w.events = t.extend({}, d, {
                state: p
            }), w.playlist = t.extend({}, f, {
                item: h
            }), w.plugins = v, w.cast = g, w
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, , , , , function(e, t, n) {
        var i, r;
        i = [n(269), n(48), n(320)], r = function(e, t, i) {
            var r = e.prototype.setup;
            return e.prototype.setup = function(e, o) {
                e.analytics && (e.sdkplatform = e.sdkplatform || e.analytics.sdkplatform), r.apply(this, arguments);
                var a = this._model.get("edition"),
                        s = t(a),
                        l = this._model.get("cast"),
                        c = this;
                s("casting") && l && l.appid && n.e(4, function(require) {
                    var e = n(138);
                    c._castController = new e(c, c._model), c.castToggle = c._castController.castToggle.bind(c._castController)
                });
                var u = i.setup();
                this.once("ready", u.onReady, this), o.getAdBlock = u.checkAdBlock
            }, e
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(141), n(48), n(47), n(89), n(1), n(2), n(132), n(274)], r = function(e, t, i, r, o, a, s, l) {
            function c(e, t, n) {
                if (t) {
                    var i = t.client;
                    delete t.client, /\.(js|swf)$/.test(i || "") || (i = s.repo() + n), e[i] = t
                }
            }

            function u(e, n) {
                var i = o.clone(n.get("plugins")) || {},
                        r = n.get("edition"),
                        a = t(r),
                        l = /^(vast|googima)$/,
                        u = /\.(js|swf)$/,
                        d = s.repo(),
                        p = n.get("advertising");
                if (a("ads") && p && (u.test(p.client) ? i[p.client] = p : l.test(p.client) && (i[d + p.client + ".js"] = p), delete p.client), a("jwpsrv")) {
                    var f = n.get("analytics");
                    o.isObject(f) || (f = {}), c(i, f, "jwpsrv.js")
                }
                c(i, n.get("ga"), "gapro.js"), c(i, n.get("sharing"), "sharing.js"), c(i, n.get("related"), "related.js"), n.set("plugins", i), e()
            }

            function d(t, i) {
                var r = i.get("key") || window.jwplayer && window.jwplayer.key,
                        o = new e(r),
                        c = o.edition();
                if (i.set("key", r), i.set("edition", c), "unlimited" === c) {
                    var u = a.getScriptPath("jwplayer.js");
                    if (!u) return void l.error(t, "Error setting up player", "Could not locate jwplayer.js script tag");
                    n.p = u, a.repo = s.repo = s.loadFrom = function() {
                        return u
                    }
                }
                i.updateProviders(), "invalid" === c ? l.error(t, "Error setting up player", (void 0 === r ? "Missing" : "Invalid") + " license key") : t()
            }

            function p(e, t) {
                var n = t.getProviders(),
                        r = t.get("playlist"),
                        o = t.get("edition"),
                        a = n.required(r, o);
                i.load(a, o).then(e)
            }

            function f() {
                var e = l.getQueue();
                return e.LOAD_PROVIDERS = {
                    method: p,
                    depends: ["CHECK_KEY", "FILTER_PLAYLIST"]
                }, e.CHECK_KEY = {
                    method: d,
                    depends: ["LOADED_POLYFILLS"]
                }, e.FILTER_PLUGINS = {
                    method: u,
                    depends: ["CHECK_KEY"]
                }, e.FILTER_PLAYLIST.depends.push("CHECK_KEY"), e.LOAD_PLUGINS.depends.push("FILTER_PLUGINS"), e.SETUP_VIEW.depends.push("CHECK_KEY"), e.SEND_READY.depends.push("LOAD_PROVIDERS"), e
            }
            return {
                getQueue: f
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(275), n(312), n(1)], r = function(e, t, n) {
            return window.jwplayer ? window.jwplayer : n.extend(e, t)
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [], r = function() {
            function e() {
                var e = document.createElement("div");
                return e.className = n, e.innerHTML = "&nbsp;", e.style.width = "1px", e.style.height = "1px", e.style.position = "absolute", e.style.background = "transparent", e
            }

            function t() {
                function t() {
                    var e = this,
                            t = e._view.element();
                    t.appendChild(o), i() && e.trigger("adBlock")
                }

                function i() {
                    return r ? !0 : ("" !== o.innerHTML && o.className === n && null !== o.offsetParent && 0 !== o.clientHeight || (r = !0), r)
                }
                var r = !1,
                        o = e();
                return {
                    onReady: t,
                    checkAdBlock: i
                }
            }
            var n = "afs_ads";
            return {
                setup: t
            }
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(2), n(4), n(12), n(3), n(1), n(236)], r = function(e, t, n, i, r, o) {
            var a = function(e) {
                this.model = e, this.setup()
            };
            return r.extend(a.prototype, i, {
                setup: function() {
                    this.destroy(), this.skipMessage = this.model.get("skipText"), this.skipMessageCountdown = this.model.get("skipMessage"), this.setWaitTime(this.model.get("skipOffset"));
                    var t = o();
                    this.el = e.createElement(t), this.skiptext = this.el.getElementsByClassName("jw-skiptext")[0], this.skipAdOnce = r.once(this.skipAd.bind(this)), new n(this.el).on("click tap", r.bind(function() {
                        this.skippable && this.skipAdOnce()
                    }, this)), this.model.on("change:duration", this.onChangeDuration, this), this.model.on("change:position", this.onChangePosition, this), this.onChangeDuration(this.model, this.model.get("duration")), this.onChangePosition(this.model, this.model.get("position"))
                },
                updateMessage: function(e) {
                    this.skiptext.innerHTML = e
                },
                updateCountdown: function(e) {
                    this.updateMessage(this.skipMessageCountdown.replace(/xx/gi, Math.ceil(this.waitTime - e)))
                },
                onChangeDuration: function(t, n) {
                    if (n) {
                        if (this.waitPercentage) {
                            if (!n) return;
                            this.itemDuration = n, this.setWaitTime(this.waitPercentage), delete this.waitPercentage
                        }
                        e.removeClass(this.el, "jw-hidden")
                    }
                },
                onChangePosition: function(t, n) {
                    this.waitTime - n > 0 ? this.updateCountdown(n) : (this.updateMessage(this.skipMessage), this.skippable = !0, e.addClass(this.el, "jw-skippable"))
                },
                element: function() {
                    return this.el
                },
                setWaitTime: function(t) {
                    if (r.isString(t) && "%" === t.slice(-1)) {
                        var n = parseFloat(t);
                        return void(this.itemDuration && !isNaN(n) ? this.waitTime = this.itemDuration * n / 100 : this.waitPercentage = t)
                    }
                    r.isNumber(t) ? this.waitTime = t : "string" === e.typeOf(t) ? this.waitTime = e.seconds(t) : isNaN(Number(t)) ? this.waitTime = 0 : this.waitTime = Number(t)
                },
                skipAd: function() {
                    this.trigger(t.JWPLAYER_AD_SKIPPED)
                },
                destroy: function() {
                    this.el && (this.el.removeEventListener("click", this.skipAdOnce), this.el.parentElement && this.el.parentElement.removeChild(this.el)), delete this.skippable, delete this.itemDuration, delete this.waitPercentage
                }
            }), a
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }, function(e, t, n) {
        var i, r;
        i = [n(303), n(1), n(33)], r = function(e, t, n) {
            var i = {
                        free: "f",
                        premium: "r",
                        enterprise: "e",
                        ads: "a",
                        unlimited: "u",
                        trial: "t"
                    },
                    r = function() {};
            return t.extend(r.prototype, e.prototype, {
                buildArray: function() {
                    var t = e.prototype.buildArray.apply(this, arguments),
                            r = this.model.get("edition"),
                            o = "https://jwplayer.com/learn-more/?m=h&e=" + (i[r] || r) + "&v=" + n;
                    if (t.items[0].link = o, this.model.get("abouttext")) {
                        t.items[0].showLogo = !1, t.items.push(t.items.shift());
                        var a = {
                            title: this.model.get("abouttext"),
                            link: this.model.get("aboutlink") || o
                        };
                        t.items.unshift(a)
                    }
                    return t
                }
            }), r
        }.apply(t, i), !(void 0 !== r && (e.exports = r))
    }])
});