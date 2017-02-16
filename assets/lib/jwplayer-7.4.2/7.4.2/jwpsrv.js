! function(t) {
    function e(i) {
        if (n[i]) return n[i].exports;
        var o = n[i] = {
            exports: {},
            id: i,
            loaded: !1
        };
        return t[i].call(o.exports, o, o.exports, e), o.loaded = !0, o.exports
    }
    var n = {};
    return e.m = t, e.c = n, e.p = "", e(0)
}([function(t, e, n) {
    t.exports = n(1)
}, function(t, e, n) {
    function i() {
        var t, e;
        if (navigator.plugins && "object" == typeof navigator.plugins["Shockwave Flash"]) {
            if (e = navigator.plugins["Shockwave Flash"].description) return e
        } else if ("undefined" != typeof window.ActiveXObject) try {
            if (t = new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash"), t && (e = t.GetVariable("$version"))) return e
        } catch (n) {}
        return ""
    }
    var o = n(2),
        r = n(5),
        a = n(3),
        u = n(4),
        s = n(6),
        c = n(7),
        l = function(t, e) {
            function n() {
                var t = g().preload;
                return fe[t] || 0
            }

            function i() {
                return le[Ae] || 0
            }

            function l() {
                var e = a._.some(g().tracks, function(t) {
                    var e = t.type;
                    return "thumbnails" !== e && "chapters" !== e
                });
                if (e) return 1;
                var n = t.getCaptionsList();
                return n.length > 1 ? 2 : 0
            }

            function f() {
                var t = g(),
                    e = t.sources[0],
                    n = e.type;
                if (!n) {
                    var i = e.file;
                    n = a.extension(i)
                }
                return n
            }

            function p() {
                var t = g(),
                    e = t.tracks;
                return a._.some(e, function(t) {
                    return "thumbnails" === t.kind
                })
            }

            function h() {
                return de[Le] || 0
            }

            function g(e) {
                try {
                    return t.getPlaylistItem(e)
                } catch (n) {}
                return e = e || ce, this.getConfig().playlist[e] || null
            }

            function v() {
                return !!t.getConfig().autostart
            }

            function m() {
                return t.getAdBlock ? t.getAdBlock() : -1
            }

            function w(e) {
                return oe || re.calculate(), [Xt(W, Pe, 21), Xt(Z, v(), 11), Xt(X, ue, 21), Xt(ht, se, 28), Xt(gt, te, 28), Xt(ut, !0, 10), Xt(et, oe.bucket, 21), Xt(it, oe.width, 21), Xt(ot, oe.height, 21), Xt(Kt, t.getVolume(), 20), Xt(Ot, t.getMute(), 28), Xt(Bt, Te.getViewablePercentage(oe), 30), Xt(Nt, Te.getPosition(), 31), Xt(st, ee || R(e), 101), Xt(G, M(e), 20), Xt(lt, m(), 100)]
            }

            function y(t) {
                return [Xt($, L(t), 100)].concat(w(t))
            }

            function k(t, e) {
                return [Xt(at, e, 23)].concat(y(t))
            }

            function b(t) {
                Le = t.playReason || "", j()
            }

            function C(e) {
                t.off("beforePlay", b), ee = R(e.item), ee && t.once("beforePlay", b), P(), te = U(12), ce = e.index, Oe = Be = !1, Ae = null
            }

            function P() {
                Ee = {}, Fe = !1, Me = 0
            }

            function _(e) {
                return function(n) {
                    if (!Ne) {
                        var i = Ee[e];
                        if (e === Se) {
                            n = n.metadata || n;
                            var o = n.segment;
                            o && (Oe = !0, Be = o.encryption);
                            var r = n.drm;
                            if (r && (Ae = r), i && (n.width = n.width || i.width, n.height = n.height || i.height, n.duration = n.duration || i.duration), (100 === n.duration || 0 === n.duration) && 0 === n.width && 0 === n.height) return
                        }
                        if (Ee[e] = n, e === Re && (i || (Ue = 0), qe = t.getPosition()), Ee[Re] && Ee[Se] && Ee[je] && Ee[De]) {
                            var a = x();
                            "flash_adaptive" === a ? !Fe && Oe && (Fe = !0, Oe = !1, q(a)) : Fe || (Fe = !0, q(a))
                        }
                    }
                }
            }

            function x() {
                if (a._.isFunction(t.getProvider)) {
                    var e = t.getProvider();
                    return e ? e.name : ""
                }
                return ""
            }

            function I() {
                var e = t.getDuration();
                if (0 >= e) {
                    var n = Ee[Se];
                    n && (e = n.duration)
                }
                return 0 | e
            }

            function T(t) {
                return t = 0 | t, 0 >= t || t === 1 / 0 ? 0 : 30 > t ? 1 : 60 > t ? 4 : 180 > t ? 8 : 300 > t ? 16 : 32
            }

            function E(t) {
                return t = 0 | t, 0 >= t || t === 1 / 0 ? 0 : 15 > t ? 1 : 300 >= t ? 2 : 1200 >= t ? 3 : 4
            }

            function F() {
                qe = t.getPosition(), Me = 0
            }

            function L(t) {
                var e;
                if (!t) return null;
                var n = t.sources;
                if (n) {
                    for (var i = [], o = n.length; o--;) n[o].file && i.push(n[o].file);
                    i.sort(), e = i[0]
                } else e = t.file;
                return a.getAbsolutePath(e)
            }

            function M(t) {
                return t ? t.title : null
            }

            function A(t) {
                var e = /^[a-zA-Z0-9]{8}$/;
                return e.test(t)
            }

            function V(t) {
                var e = t || g();
                if (!e) return null;
                var n = e.feedid || Yt.feedid;
                return A(n) ? n : null
            }

            function R(t) {
                var e = t || g();
                if (!e) return null;
                var n = e.mediaid;
                return A(n) ? n : (n = a.getMediaId(e.file), A(n) ? n : null)
            }

            function S(e) {
                if (!e) return null;
                var n = 1,
                    i = 2,
                    o = 3,
                    r = 4,
                    u = 5,
                    s = 6,
                    c = 0,
                    l = Ee[je];
                if (l && l.levels && l.levels.length) {
                    var d = l.levels[0];
                    if (d && "auto" === ("" + d.label).toLowerCase()) return u
                }
                var f, p = e.sources;
                if (f = p[0].type, a.hasClass(t.getContainer(), "jw-flag-audio-player")) return s;
                var h = Ee[Se] || {},
                    g = 0 | h.width,
                    v = 0 | h.height;
                return 0 === g && 0 === v ? "rtmp" === f ? s : c : 320 >= g ? n : 640 >= g ? i : 1280 >= g ? o : r
            }

            function j() {
                var t = x();
                Ve.track(ne, J, [Xt(pt, t, 21), Xt(Qt, Yt.hlshtml, 21), Xt(_t, h(), 22), Xt(vt, V(), 22)].concat(y(g())))
            }

            function D(e, i) {
                e = e || g();
                var o = !t.getControls(),
                    r = -1;
                i && i.setupTime && (r = i.setupTime), re.calculate(), Ve.track(ne, Q, [Xt(ct, d(), 22), Xt(dt, r, 24), Xt(mt, pe, 22), Xt(Ut, me, 22), Xt(wt, ge, 22), Xt(yt, we, 23), Xt(kt, ye, 23), Xt(bt, ve, 22), Xt(Lt, n(), 22), Xt(qt, Yt.pad, 22), Xt(Ct, ke, 23), Xt(Pt, be, 23), Xt(St, Ce, 21), Xt(jt, he, 22), Xt(Qt, Yt.hlshtml, 24), Xt(Dt, o, 24)].concat(y(e)))
            }

            function U(t) {
                return new Array(t + 1).join((Math.random().toString(36) + "00000000000000000").slice(2, 18)).slice(0, t)
            }

            function q(e) {
                var n = I(),
                    o = g(),
                    r = -1;
                "function" == typeof t.qoe && (r = t.qoe().firstFrame);
                var a = f(),
                    u = p(),
                    s = l(),
                    c = i() || Be;
                re.calculate(), Ve.track(ne, z, [Xt(nt, S(o), 21), Xt(rt, E(n), 22), Xt(xt, n, 22), Xt(vt, V(o), 22), Xt(It, a, 22), Xt(Rt, t.getPlaylist().length, 22), Xt(Tt, u, 23), Xt(Et, s, 23), Xt(Ft, c, 23), Xt(ft, r, 23), Xt(pt, e, 24), Xt(Qt, Yt.hlshtml, 24), Xt(_t, h(), 25)].concat(k(o, T(n))).concat(O()))
            }

            function N(e, n, i) {
                if (ee) {
                    var o = n + .5 | 0;
                    o > 0 && (re.calculate(), Ve.track(ne, H, [Xt(Y, o, 21), Xt(tt, 0 | e, 22), Xt(vt, V(), 22), Xt(Mt, a.getActiveTab(), 31), Xt(At, a.getDocumentFocus(), 31), Xt(Vt, a.getTabFocus(t.getContainer()), 31)].concat(k(g(), i)).concat(B())))
                }
            }

            function O() {
                return ie ? [Xt(zt, Zt.cx, 30), Xt(Ht, Zt.o, 30)] : []
            }

            function B() {
                return ie ? [Xt(Ht, Zt.o, 30), Xt(Jt, Zt.cs, 30), Xt(Wt, Zt.pip, 30)] : []
            }

            function K(t) {
                Ne = !!t.active
            }
            a._ || t._.extend(a, t.utils, {
                _: t._
            });
            var Q = "e",
                z = "s",
                H = "t",
                J = "pa",
                W = "ed",
                Z = "d",
                X = "ph",
                $ = "mu",
                G = "t",
                Y = "ti",
                tt = "pw",
                et = "ps",
                nt = "vs",
                it = "wd",
                ot = "pl",
                rt = "l",
                at = "q",
                ut = "m",
                st = "id",
                ct = "fv",
                lt = "eb",
                dt = "st",
                ft = "ff",
                pt = "pp",
                ht = "emi",
                gt = "pli",
                vt = "fed",
                mt = "vp",
                wt = "po",
                yt = "s",
                kt = "r",
                bt = "sn",
                Ct = "cb",
                Pt = "ga",
                _t = "pr",
                xt = "vd",
                It = "mk",
                Tt = "tt",
                Et = "cct",
                Ft = "drm",
                Lt = "pd",
                Mt = "at",
                At = "df",
                Vt = "tf",
                Rt = "plc",
                St = "pid",
                jt = "dd",
                Dt = "cp",
                Ut = "ab",
                qt = "pad",
                Nt = "ap",
                Ot = "mt",
                Bt = "vi",
                Kt = "vl",
                Qt = "hls",
                zt = "cx",
                Ht = "o",
                Jt = "cs",
                Wt = "pip",
                Zt = {
                    cx: 0,
                    o: 0,
                    cs: 0,
                    pip: 0
                },
                Xt = function(t, e, n) {
                    return new u(t, e, n)
                },
                $t = 128,
                Gt = e.debug === !0,
                Yt = t.getConfig();
            e.version = a.simpleSemver(t.version);
            var te, ee, ne, ie = parseInt(e.sdkplatform, 10),
                oe = null,
                re = this,
                ae = a._.isObject(window.jwplayer) ? window.jwplayer.defaults || {} : {},
                ue = Yt[X] || ae[X] || 0,
                se = U(12),
                ce = 0,
                le = {
                    aes: 1,
                    widevine: 2,
                    playready: 3
                },
                de = {
                    interaction: 1,
                    "related-interaction": 1,
                    autostart: 2,
                    repeat: 3,
                    external: 4,
                    "related-auto": 5,
                    playlist: 6
                },
                fe = {
                    none: 1,
                    metadata: 2,
                    auto: 3
                },
                pe = Yt.visualplaylist !== !1,
                he = Yt.displaydescription !== !1,
                ge = !!Yt.image,
                ve = Yt.skin,
                me = !!Yt.advertising,
                we = !!Yt.sharing,
                ye = !!Yt.related,
                ke = !!Yt.cast,
                be = !!Yt.ga,
                Ce = Yt.pid,
                Pe = 0,
                _e = Yt.key;
            if (_e) {
                var xe = new a.key(_e),
                    Ie = xe.edition();
                "invalid" !== Ie && (ne = xe.token()), "enterprise" === Ie ? Pe = 6 : "trial" === Ie ? Pe = 7 : "invalid" === Ie ? Pe = 4 : "ads" === Ie ? Pe = 3 : "premium" === Ie ? Pe = 2 : "pro" === Ie && (Pe = 1)
            }
            ne || (ne = "_"), re.getCommonAdTrackingParameters = function() {
                return w(g(), !1)
            }, re.calculate = function() {
                oe = function() {
                    var e = 1,
                        n = 2,
                        i = 3,
                        o = 4,
                        r = 5,
                        u = 0,
                        s = t.getConfig(),
                        c = t.getWidth(),
                        l = t.getHeight(),
                        d = /\d+%/.test(c);
                    if (d) {
                        var f = a.bounds(t.getContainer());
                        c = Math.ceil(f.width), l = Math.ceil(f.height)
                    }
                    return c = 0 | c, /\d+%/.test(s.width || c) && s.aspectratio ? {
                        bucket: o,
                        width: c,
                        height: l
                    } : a.hasClass(t.getContainer(), "jw-flag-audio-player") ? {
                        bucket: r,
                        width: c,
                        height: l
                    } : 0 === c ? {
                        bucket: u,
                        width: c,
                        height: l
                    } : 320 >= c ? {
                        bucket: e,
                        width: c,
                        height: l
                    } : 640 >= c ? {
                        bucket: n,
                        width: c,
                        height: l
                    } : {
                        bucket: i,
                        width: c,
                        height: l
                    }
                }()
            }, re.getPlayerSize = function() {
                return oe
            };
            var Te = new r(t, 2e3);
            s(re, e, ne, Gt, t, Te), c(re, t, e, ne, Gt, Te);
            var Ee, Fe, Le, Me, Ae, Ve = new o(e, Gt, "jwplayer6", Te),
                Re = "play",
                Se = "meta",
                je = "levels",
                De = "firstFrame",
                Ue = 0,
                qe = null,
                Ne = !1,
                Oe = !1,
                Be = !1;
            t.on("mobile-sdk-lt", function(t) {
                a._.extend(Zt, t)
            }), t.onReady(function(t) {
                D(g(), t)
            }), t.onPlay(_(Re)), t.on("firstFrame", _(De)), t.onMeta(_(Se)), t.onQualityLevels(_(je)), t.onCast(K), t.onTime(function(e) {
                if (!Ne) {
                    var n = e.position,
                        i = e.duration;
                    if (n) {
                        if (n > 1) {
                            if (!Ee[Se]) {
                                var o = {
                                        duration: i
                                    },
                                    r = t.getContainer(),
                                    a = r.getElementsByTagName("video"),
                                    u = a.length ? a[0] : null;
                                u && (o.width = u.videoWidth, o.height = u.videoHeight), _(Se)(o)
                            }
                            Ee[je] || _(je)({})
                        }
                        var s = T(i),
                            c = i / s,
                            l = n / c + 1 | 0;
                        0 === Me && (Me = l), null === qe && (qe = n);
                        var d = n - qe;
                        if (qe = n, d = Math.min(Math.max(0, d), 4), Ue += d, l === Me + 1) {
                            var f = $t * Me / s;
                            if (Me = 0, l > s) return;
                            N(f, Ue, s), Ue = 0
                        }
                    }
                }
            }), t.onComplete(function() {
                if (!Ne) {
                    var t = I();
                    if (!(0 >= t || t === 1 / 0)) {
                        var e = T(t);
                        N($t, Ue, e), Ue = 0
                    }
                }
            }), t.onSeek(F), t.onIdle(P), t.onPlaylistItem(C), P()
        },
        d = function() {
            var t = i().replace("Shockwave Flash", "").replace(/ /g, "");
            return function() {
                return t
            }
        }();
    window.jwplayer && jwplayer() && jwplayer().registerPlugin("jwpsrv", "6.0", l)
}, function(t, e, n) {
    var i = n(3),
        o = n(4),
        r = function(t, e, n, o) {
            i._.isFunction(t.onping) && (this.onping = t.onping);
            var r = parseInt(t.sdkplatform, 10),
                a = 1 === r || 2 === r,
                u = "complete" === document.readyState,
                s = {
                    trackerVersion: "2.4.0",
                    serverURL: "english360.vn",
                    serverPath: "/assets/lib/jwplayer-7.4.2/v1/" + n + "/ping.gif?",
                    playerVersion: t.version,
                    config: t,
                    SDKPlatform: t.sdkplatform || "0",
                    isMobileSDK: a,
                    iFrame: void 0,
                    pageURL: void 0,
                    pageTitle: void 0,
                    pageLoaded: u,
                    queue: [],
                    debug: e,
                    positionUtils: o
                };
            if (!a) {
                if (s.iFrame = window.top !== window.self, s.iFrame) {
                    s.pageURL = document.referrer;
                    try {
                        s.pageURL = s.pageURL || window.top.location.href, s.pageTitle = window.top.document.title
                    } catch (c) {}
                }
                s.pageURL = s.pageURL || window.location.href, s.pageTitle = s.pageTitle || document.title
            }
            var l = i._.extend(this, s);
            if (!u) {
                var d = function() {
                    for (l.pageLoaded = !0; l.queue.length;) l.ping(l.queue.shift())
                };
                window.addEventListener ? window.addEventListener("load", d) : window.attachEvent("onload", d)
            }
        };
    r.prototype.track = function(t, e, n) {
        this.ping(this.buildTrackingURL(t, e, n))
    };
    var a = "tv",
        u = "n",
        s = "aid",
        c = "e",
        l = "i",
        d = "ifd",
        f = "pv",
        p = "pu",
        h = "pt",
        g = "sdk",
        v = "sv",
        m = "bi",
        w = "an",
        y = "did",
        k = "dm",
        b = "sc",
        C = "ts",
        P = "ha",
        _ = function(t, e, n) {
            return new o(t, e, n)
        },
        x = function(t) {
            var e, n, i = 0;
            if (t = decodeURIComponent(t), !t.length) return i;
            for (e = 0; e < t.length; e++) n = t.charCodeAt(e), i = (i << 5) - i + n, i &= i;
            return i
        };
    r.prototype.buildTrackingURL = function(t, e, n) {
        var i = [_(a, this.trackerVersion, 0), _(u, Math.random().toFixed(16).substr(2, 16), 2), _(s, t, 4), _(c, e, 5), _(l, this.iFrame, 6), _(d, this.positionUtils.getIFrameDepth(), 6), _(f, this.playerVersion, 7), _(p, this.pageURL, 101), _(h, this.pageTitle, 103), _(g, this.SDKPlatform, 25)].concat(n);
        this.isMobileSDK && i.push(_(y, this.config.mobiledeviceid || "", 26), _(v, this.config.iossdkversion || "", 27), _(k, this.config.mobiledevicemodel || "", 28), _(m, this.config.bundleid || "", 29), _(w, this.config.applicationname || "", 30), _(b, this.config.systemcaptions || "", 31), _(C, this.config.texttospeech || "", 32), _(P, this.config.hardwareacceleration || "", 33)), i.sort(function(t, e) {
            return t.priority - e.priority
        });
        for (var o = [], r = 0; r < i.length; r++) o.push(i[r].getKey() + "=" + encodeURIComponent(i[r].getValue()));
        var I = o.join("&"),
            T = "h=" + x(I) + "&" + I,
            E = ["//", this.serverURL, "/", this.serverPath, T];
        return "file:" === window.location.protocol && E.unshift("https:"), E.join("")
    }, r.prototype.ping = function(t) {
        if (!this.pageLoaded) return void this.queue.push(t);
        var e = new Image;
        if (e.src = t, this.debug && this.onping) try {
            this.onping.call(this, t)
        } catch (n) {
            console.error("jwpsrv.onping:", n.message)
        }
    }, t.exports = r
}, function(t, e) {
    var n = {};
    n.getAdClientValue = function(t) {
        if (t) {
            if (/vast/.test(t)) return 0;
            if (/googima/.test(t)) return 1
        }
        return -1
    }, n.getMediaId = function(t) {
        var e = /.*\/(?:manifests|videos)\/([a-zA-Z0-9]{8})[\.-].*/,
            n = e.exec(t);
        return n && 2 === n.length ? n[1] : null
    }, n.getActiveTab = function(t, e) {
        for (var n = 0; n < e.length && (n && (t = e[n] + "Hidden"), !(t in document)); n++);
        return t ? function() {
            return !document[t]
        } : function() {
            return null
        }
    }("", ["hidden", "webkit", "moz", "ms", "o"]), n.getDocumentFocus = function() {
        return document.hasFocus && "function" == typeof document.hasFocus && document.hasFocus()
    }, n.getTabFocus = function(t) {
        for (var e = document.activeElement; e;) {
            if (e === t) return !0;
            e = e.parentNode
        }
        return !1
    }, n.isAbsolutePath = function(t) {
        return t.match(/^[a-zA-Z]+:\/\//)
    }, n.simpleSemver = function(t) {
        return t.split("+")[0]
    }, n.hasClass = function(t, e) {
        var n = " " + e + " ";
        return 1 === t.nodeType && (" " + t.className + " ").replace(/[\t\r\n\f]/g, " ").indexOf(n) >= 0
    }, t.exports = n
}, function(t, e) {
    var n = function(t, e, n) {
        e === !0 || e === !1 ? e = e ? 1 : 0 : null !== e && void 0 !== e || (e = ""), this.key = t, this.value = e, this.priority = n
    };
    n.prototype.getKey = function() {
        return this.key
    }, n.prototype.getValue = function() {
        return this.value
    }, t.exports = n
}, function(t, e) {
    function n(t, e) {
        var n = t.top + t.height < e.top || t.top > e.top + e.height || t.left + t.width < e.left || t.left > e.left + e.width,
            i = {
                top: 0,
                left: 0,
                width: 0,
                height: 0
            };
        return n === !1 && (i = {
            top: Math.max(t.top, e.top),
            left: Math.max(t.left, e.left),
            width: Math.min(Math.abs(t.left - (e.left + e.width)), Math.abs(e.left - (t.left + t.width)), t.width, e.width),
            height: Math.min(Math.abs(t.top - (e.top + e.height)), Math.abs(e.top - (t.top + t.height)), t.height, e.height)
        }), i
    }

    function i(t, e) {
        for (var i, o = t, r = e; null !== o.parentElement && "undefined" != typeof o.parentElement.tagName;) i = s(o.parentElement), r = n(r, i), o = o.parentElement;
        var a = s(o.ownerDocument.body).width,
            u = s(o.ownerDocument.body).height;
        return r = n(r, {
            top: 0,
            left: 0,
            width: a,
            height: u
        })
    }

    function o(t, e) {
        for (var n = t, i = e; null !== n && "undefined" != typeof n.tagName;) null !== n.offsetParent && n.offsetParent === n.parentElement.offsetParent ? (i.top += n.offsetTop - n.parentElement.offsetTop, i.left += n.offsetLeft - n.parentElement.offsetLeft) : (i.top += n.offsetTop, i.left += n.offsetLeft), null !== n.parentElement && "BODY" !== n.parentElement.tagName && (i.top -= "undefined" != typeof n.parentElement.scrollTop ? n.parentElement.scrollTop : 0, i.left -= "undefined" != typeof n.parentElement.scrollLeft ? n.parentElement.scrollLeft : 0), n = n.parentElement;
        return i
    }

    function r(t, e) {
        for (var n = {
            top: 0,
            left: 0
        }, i = t.getContainer(); null !== i;) {
            if (n = o(i, n), e || c(i) === window.top) return n;
            i = c(i).frameElement
        }
        return n
    }

    function a(t) {
        for (var e = t.getContainer(), n = s(e); null !== e;) {
            if (n = i(e, n), c(e) === window.top) return n;
            try {
                e = c(e).frameElement, n.top += e.offsetTop, n.left += e.offsetLeft
            } catch (o) {
                e = null
            }
        }
        return n
    }

    function u(t, e) {
        for (var n = t.getContainer(), r = s(n), a = {
            top: 0,
            left: 0
        }; null !== n;) {
            r = i(n, r), a = o(n, a);
            var u = c(n);
            if (u === window.top) {
                u.parent.postMessage(JSON.stringify({
                    type: "jwpsrv_position_response",
                    playerId: t.id,
                    rect: {
                        top: r.top,
                        left: r.left,
                        width: r.width,
                        height: r.height
                    },
                    iframeDepth: 0,
                    coords: a,
                    responseChain: e
                }), "*"), n = null;
                break
            }
            try {
                n = u.frameElement
            } catch (l) {
                n = null
            }
            null === n ? parent.postMessage(JSON.stringify({
                type: "jwpsrv_position",
                playerId: t.id,
                rect: {
                    top: r.top,
                    left: r.left,
                    width: r.width,
                    height: r.height
                },
                iframeDepth: 0,
                coords: a,
                responseChain: e
            }), "*") : (r.top += n.offsetTop, r.left += n.offsetLeft)
        }
    }

    function s(t) {
        if (!t.getBoundingClientRect) throw new Error("Cannot get bounds: " + t);
        var e = t.getBoundingClientRect(),
            n = {
                left: e.left,
                top: e.top,
                width: e.width,
                height: e.height
            };
        return "width" in e || (n.width = e.right - e.left), "height" in e || (n.height = e.bottom - e.top), n
    }

    function c(t) {
        var e = t.ownerDocument;
        return e.defaultView || e.parentWindow
    }
    var l = function(t, e) {
        function n() {
            var e = t.getContainer();
            return e ? t.getState() === o && !e.parentNode : !0
        }
        this.playerAPI = t, this.lastViewRect = void 0, this.lastViewPos = void 0, this.iframeDepth = 0;
        var i, o = "idle",
            r = window.location;
        try {
            i = !(window.top.location.protocol === r.protocol && window.top.location.host === r.host && window.top.location.port === r.port)
        } catch (a) {
            i = !0
        }
        if (this.isPolling = i, i) {
            var s = this,
                c = "" + Math.floor(1e11 * Math.random()),
                l = function(t) {
                    var e;
                    try {
                        e = JSON.parse(t.data)
                    } catch (n) {}
                    e && e.type && "jwpsrv_position_response" === e.type && s.playerAPI.id === e.playerId && (s.lastViewRect = e.rect, s.lastViewPos = e.coords, s.iframeDepth = e.iframeDepth)
                };
            window.addEventListener ? window.addEventListener("message", l) : window.attachEvent("onmessage", l), u(t, c);
            var d = setInterval(function() {
                n() ? clearInterval(d) : s.isPolling && u(t, c)
            }, e)
        }
    };
    l.prototype.getPosition = function() {
        if (this.playerAPI.getFullscreen()) return "0,0";
        if (this.isPolling) return this.lastViewPos ? this.lastViewPos.left + "," + this.lastViewPos.top : null;
        var t = r(this.playerAPI, this.isPolling);
        return t.left + "," + t.top
    }, l.prototype.getViewablePercentage = function(t) {
        if (this.playerAPI.getFullscreen()) return 1;
        if (this.isPolling) return this.lastViewRect ? Math.round(1e3 * (this.lastViewRect.width * this.lastViewRect.height / (t.width * t.height))) / 1e3 : null;
        var e = a(this.playerAPI);
        return Math.round(1e3 * (e.width * e.height / (t.width * t.height))) / 1e3
    }, l.prototype.getIFrameDepth = function() {
        if (this.isPolling === !0) return this.iframeDepth ? this.iframeDepth : null;
        for (var t = c(this.playerAPI.getContainer()), e = 0; t !== window.top;) t = c(t.frameElement), e++;
        return e
    }, t.exports = l
}, function(t, e, n) {
    function i(t, e, n) {
        return new r(t, e, n)
    }
    var o = n(2),
        r = n(4),
        a = n(3);
    t.exports = function(t, e, n, r, u, s) {
        function c(t, e) {
            k.track(n, t, e)
        }

        function l(t) {
            -1 === C && t && (C = a.getAdClientValue(t.client)), d(t, "adbreakid"), d(t, "adtagid"), d(t, "offset"), d(t, "witem"), d(t, "wcount"), d(t, "skipoffset"), d(t, "linear", function(t, e) {
                return e === t
            }), d(t, "adposition", function(t, e) {
                return {
                    pre: 0,
                    mid: 1,
                    post: 2,
                    api: 3
                }[e]
            }), d(t, "creativetype", function(t, e) {
                return y.adCreativeType = {
                    "static": 0,
                    video: 1,
                    vpaid: 2,
                    "vpaid-swf": 2,
                    "vpaid-js": 3
                }[e], e
            }), d(t, "tag", function(t, e) {
                return y.tagdomain = h(a.getAbsolutePath(e)), e
            }), y.adSystem = t.adsystem || y.adSystem, y.vastVersion = t.vastversion || y.vastVersion, y.podIndex = t.sequence || y.podIndex, y.podCount = t.podcount || y.podCount
        }

        function d(t, e, n) {
            t.hasOwnProperty(e) && (n = n || f, y[e] = n(e, t[e]))
        }

        function f(t, e) {
            return e
        }

        function p(t, e) {
            if (!(e > 4)) {
                if (b.adscheduleid && e > y.previousQuartile) {
                    l(t);
                    var n = [i(U, y.duration, 1), i(J, e, 1)].concat(m());
                    c(T, n)
                }
                y.previousQuartile = e
            }
        }

        function h(t) {
            if (t) {
                var e = t.match(new RegExp(/^[^\/]*:\/\/\/?([^\/]*)/));
                if (e && e.length > 1) return e[1]
            }
            return ""
        }

        function g() {
            return [i(L, y.adId, 1), i(A, C, 19), i(M, u.getMute(), 28), i(Q, y.tagdomain, 29), i(R, y.adposition, 31), i(W, y.witem, 32), i(Z, y.wcount, 32)].concat(t.getCommonAdTrackingParameters())
        }

        function v() {
            return [i(X, b.adscheduleid, 20), i($, y.adbreakid, 21), i(G, y.adtagid, 21), i(Y, y.skipoffset, 22), i(tt, y.offset, 23)]
        }

        function m() {
            return t.calculate(), [i(B, y.podCount, 22), i(K, y.podIndex, 23), i(j, y.adCreativeType, 24), i(V, y.adLinear, 25), i(S, y.vastVersion, 26), i(D, y.adSystem, 27), i(N, a.getActiveTab(), 31), i(O, a.getDocumentFocus(), 31), i(q, a.getTabFocus(u.getContainer()), 31)].concat(g())
        }
        var w = {
                numCompanions: -1,
                podCount: 0,
                podIndex: 0,
                adLinear: -1,
                vastVersion: -1,
                adSystem: "",
                adCreativeType: -1,
                adposition: -1,
                tagdomain: "",
                position: "",
                previousQuartile: 0,
                duration: "",
                witem: 1,
                wcount: 1
            },
            y = null,
            k = new o(e, r, "clienta", s),
            b = (u.getConfig() || {}).advertising || {},
            C = a.getAdClientValue(b.client),
            P = "i",
            _ = "as",
            x = "c",
            I = "s",
            T = "v",
            E = "ae",
            F = "ar",
            L = "adi",
            M = "mt",
            A = "c",
            V = "al",
            R = "p",
            S = "vv",
            j = "ct",
            D = "ad",
            U = "du",
            q = "tf",
            N = "at",
            O = "df",
            B = "pc",
            K = "pi",
            Q = "vu",
            z = "ec",
            H = "tw",
            J = "qt",
            W = "awi",
            Z = "awc",
            X = "ask",
            $ = "abk",
            G = "atk",
            Y = "sko",
            tt = "abo";
        u.on("adRequest adMeta adImpression adComplete adSkipped adError adTime", function(t) {
            y && y.adId === t.id && -1 !== t.id || (y = a._.extend({
                adId: t.id
            }, w))
        }).on("adRequest adMeta adImpression adComplete adSkipped adError", l).on("adRequest", function() {
            b.adscheduleid && c(F, g().concat(v()))
        }).on("adImpression", function() {
            c(P, [i(Y, y.skipoffset, 1)].concat(m()).concat(v()))
        }).on("adStarted", function() {
            c(_, m().concat(v()))
        }).on("adComplete", function(t) {
            p(t, 4)
        }).on("adSkipped", function() {
            var t = [i(H, y.position, 1), i(J, y.previousQuartile, 1), i(U, y.duration, 1)].concat(v()).concat(m());
            c(I, t)
        }).on("adError", function(t) {
            if (b.adscheduleid) {
                var e = 1;
                "object" == typeof t && t && void 0 !== t.code && (e = t.code);
                var n = [i(z, e, 1)].concat(g().concat(v()));
                c(E, n)
            }
        }).on("adClick", function() {
            var t = [i(H, y.position, 1), i(U, y.duration, 1), i(J, y.previousQuartile, 1)].concat(m().concat(v()));
            c(x, t)
        }).on("adTime", function(t) {
            if (y.position = t.position, y.duration = y.duration || t.duration, y.duration) {
                var e = Math.floor((4 * y.position + .05) / y.duration);
                p(t, e)
            }
        })
    }
}, function(t, e, n) {
    function i(t, e, n, i) {
        function l(t) {
            return function(o) {
                t(o, e, n, i)
            }
        }
        if (t.getPlugin) {
            var d = t.getPlugin("related");
            d && (d.on("setup", l(r)), d.on("playlist", l(c)), d.on("open", l(a)), d.on("close", l(u)), d.on("play", l(s)))
        } else t.on(w, l(o)), t.on(v, l(o)), t.on(g, l(o)), t.on(m, l(o))
    }

    function o(t, e, n, i) {
        var o = [];
        e.calculate(), p.foreach(t, function(e) {
            "type" !== e && o.push(A(e, t[e].value, t[e].priority))
        }), i.track(n, t.type, o.concat(e.getCommonAdTrackingParameters()))
    }

    function r(t, e, n, i) {
        l(w, t, [], e, n, i)
    }

    function a(t, e, n, i) {
        l(v, t, [], e, n, i)
    }

    function u(t, e, n, i) {
        "play" !== t.method && l(m, t, [], e, n, i)
    }

    function s(t, e, n, i) {
        var o = [];
        if (p._.has(t, "item")) {
            var r;
            r = "play" === t.onclick ? t.item.mediaid : t.item.link, o.push(A(E, r, 5))
        }
        p._.has(t, "autoplaytimer") && o.push(A(L, t.autoplaytimer, 5)), l(g, t, o, e, n, i)
    }

    function c(t, e, n, i) {
        null !== t.playlist && l(y, t, [], e, n, i)
    }

    function l(t, e, n, i, o, r) {
        n = d(n, e, i), r.track(o, t, n.concat(i.getCommonAdTrackingParameters()))
    }

    function d(t, e, n) {
        if (n.calculate(), p._.has(e, "relatedFile") && t.push(A(T, e.relatedFile, 21)), p._.has(e, "onclick") && t.push(A(k, "play" === e.onclick ? 1 : 0, 21)), p._.has(e, "relatedCount") && t.push(A(I, e.relatedCount, 5)), p._.has(e, "method")) {
            var i = M[e.method] || 0;
            t.push(A(x, i, 5))
        }
        return p._.has(e, "method_group_id") && t.push(A(b, e.method_group_id, 5)), p._.has(e, "method_group_code") && t.push(A(C, e.method_group_code, 5)), p._.has(e, "selected_method_group_code") && t.push(A(P, e.selected_method_group_code, 5)), p._.has(e, "rec_id") && t.push(A(_, e.rec_id, 6)), p._.has(e, "position") && t.push(A(F, e.position + 1, 6)), t
    }
    var f = n(2),
        p = n(3),
        h = n(4),
        g = "c",
        v = "sh",
        m = "l",
        w = "em",
        y = "bs",
        k = "os",
        b = "mgi",
        C = "mgc",
        P = "smgc",
        _ = "ri",
        x = "rm",
        I = "ns",
        T = "rf",
        E = "rn",
        F = "oc",
        L = "rat",
        M = {
            play: 1,
            api: 2,
            interaction: 3,
            complete: 4,
            auto: 5,
            manual: 6,
            link: 7
        };
    t.exports = function(t, e, n, o, r, a) {
        function u() {
            i(e, t, o, s)
        }
        var s = new f(n, r, "aanbevolen", a);
        e.onReady(u)
    };
    var A = function(t, e, n) {
        return new h(t, e, n)
    }
}]);