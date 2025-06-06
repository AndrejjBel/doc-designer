"use strict";
function _classCallCheck(e, t) {
    if (!(e instanceof t))
        throw new TypeError("Cannot call a class as a function")
}
function _defineProperties(e, t) {
    for (var n = 0; n < t.length; n++) {
        var a = t[n];
        a.enumerable = a.enumerable || !1,
        a.configurable = !0,
        "value"in a && (a.writable = !0),
        Object.defineProperty(e, a.key, a)
    }
}
function _createClass(e, t, n) {
    return t && _defineProperties(e.prototype, t),
    n && _defineProperties(e, n),
    Object.defineProperty(e, "prototype", {
        writable: !1
    }),
    e
}
function _toConsumableArray(e) {
    return _arrayWithoutHoles(e) || _iterableToArray(e) || _unsupportedIterableToArray(e) || _nonIterableSpread()
}
function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
}
function _unsupportedIterableToArray(e, t) {
    if (e) {
        if ("string" == typeof e)
            return _arrayLikeToArray(e, t);
        var n = Object.prototype.toString.call(e).slice(8, -1);
        return "Map" === (n = "Object" === n && e.constructor ? e.constructor.name : n) || "Set" === n ? Array.from(e) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? _arrayLikeToArray(e, t) : void 0
    }
}
function _iterableToArray(e) {
    if ("undefined" != typeof Symbol && null != e[Symbol.iterator] || null != e["@@iterator"])
        return Array.from(e)
}
function _arrayWithoutHoles(e) {
    if (Array.isArray(e))
        return _arrayLikeToArray(e)
}
function _arrayLikeToArray(e, t) {
    (null == t || t > e.length) && (t = e.length);
    for (var n = 0, a = new Array(t); n < t; n++)
        a[n] = e[n];
    return a
}
!function(o) {
    function e() {
        o(window).on("load", function() {
            o("#status").fadeOut(),
            o("#preloader").delay(350).fadeOut("slow")
        });
        _toConsumableArray(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e) {
            return new bootstrap.Popover(e)
        }),
        _toConsumableArray(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(e) {
            return new bootstrap.Tooltip(e)
        }),
        _toConsumableArray(document.querySelectorAll(".offcanvas")).map(function(e) {
            return new bootstrap.Offcanvas(e)
        });
        var e = document.getElementById("toastPlacement");
        e && document.getElementById("selectToastPlacement").addEventListener("change", function() {
            e.dataset.originalClass || (e.dataset.originalClass = e.className),
            e.className = e.dataset.originalClass + " " + this.value
        });
        [].slice.call(document.querySelectorAll(".toast")).map(function(e) {
            return new bootstrap.Toast(e)
        });
        var a = document.getElementById("liveAlertPlaceholder")
          , t = document.getElementById("liveAlertBtn");
        t && t.addEventListener("click", function() {
            var e, t, n;
            e = "Nice, you triggered this alert message!",
            t = "success",
            (n = document.createElement("div")).innerHTML = ['<div class="alert alert-'.concat(t, ' alert-dismissible" role="alert">'), "   <div>".concat(e, "</div>"), '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>', "</div>"].join(""),
            a.append(n)
        }),
        document.getElementById("app-style").href.includes("rtl.min.css") && (document.getElementsByTagName("html")[0].dir = "rtl")
    }
    function t() {
        var s, e;
        o(".side-nav").length && (s = function(e, t, n, a) {
            return (e /= a / 2) < 1 ? n / 2 * e * e + t : -n / 2 * (--e * (e - 2) - 1) + t
        }
        ,
        e = o(".side-nav li .collapse"),
        o(".side-nav li [data-bs-toggle='collapse']").on("click", function(e) {
            return !1
        }),
        e.on({
            "show.bs.collapse": function(e) {
                var t = o(e.target).parents(".collapse.show");
                o(".side-nav .collapse.show").not(e.target).not(t).collapse("hide")
            }
        }),
        o(".side-nav a").each(function() {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e && (o(this).addClass("active"),
            o(this).parent().addClass("menuitem-active"),
            o(this).parent().parent().parent().addClass("show"),
            o(this).parent().parent().parent().parent().addClass("menuitem-active"),
            "sidebar-menu" !== (e = o(this).parent().parent().parent().parent().parent().parent()).attr("id") && e.addClass("show"),
            o(this).parent().parent().parent().parent().parent().parent().parent().addClass("menuitem-active"),
            "wrapper" !== (e = o(this).parent().parent().parent().parent().parent().parent().parent().parent().parent()).attr("id") && e.addClass("show"),
            (e = o(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent()).is("body") || e.addClass("menuitem-active"))
        }),
        setTimeout(function() {
            var e, n, a, o, r, i, t = document.querySelector("li.menuitem-active .active");
            null != t && (e = document.querySelector(".leftside-menu .simplebar-content-wrapper"),
            t = t.offsetTop - 300,
            e && 100 < t && (a = 600,
            o = (n = e).scrollTop,
            r = t - o,
            i = 0,
            function e() {
                var t = s(i += 20, o, r, a);
                n.scrollTop = t,
                i < a && setTimeout(e, 20)
            }()))
        }, 200))
    }
    var n, a, r, i, s;
    e(),
    n = ".card",
    o(document).on("click", '.card a[data-bs-toggle="remove"]', function(e) {
        e.preventDefault();
        var e = o(this).closest(n)
          , t = e.parent();
        e.remove(),
        0 == t.children().length && t.remove()
    }),
    o(document).on("click", '.card a[data-bs-toggle="reload"]', function(e) {
        e.preventDefault();
        var e = o(this).closest(n)
          , t = (e.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>'),
        e.find(".card-disabled"));
        setTimeout(function() {
            t.fadeOut("fast", function() {
                t.remove()
            })
        }, 500 + 5 * Math.random() * 300)
    }),
    o(".dropdown-menu a.dropdown-toggle").on("click", function() {
        var e = o(this).next(".dropdown-menu")
          , e = o(this).parent().parent().find(".dropdown-menu").not(e);
        return e.removeClass("show"),
        e.parent().find(".dropdown-toggle").removeClass("show"),
        !1
    }),
    t(),
    a = o(".navbar-custom .dropdown:not(.app-search)"),
    o(document).on("click", function(e) {
        return "top-search" == e.target.id || e.target.closest("#search-dropdown") ? o("#search-dropdown").addClass("d-block") : o("#search-dropdown").removeClass("d-block"),
        !0
    }),
    o("#top-search").on("focus", function(e) {
        return e.preventDefault(),
        a.children(".dropdown-menu.show").removeClass("show"),
        o("#search-dropdown").addClass("d-block"),
        !1
    }),
    a.on("show.bs.dropdown", function() {
        o("#search-dropdown").removeClass("d-block")
    }),
    (r = document.querySelector('[data-toggle="fullscreen"]')) && r.addEventListener("click", function(e) {
        e.preventDefault(),
        document.body.classList.toggle("fullscreen-enable"),
        document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement ? document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen() : document.documentElement.requestFullscreen ? document.documentElement.requestFullscreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullscreen && document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)
    }),
    o("[data-password]").on("click", function() {
        "false" == o(this).attr("data-password") ? (o(this).siblings("input").attr("type", "text"),
        o(this).attr("data-password", "true"),
        o(this).addClass("show-password")) : (o(this).siblings("input").attr("type", "password"),
        o(this).attr("data-password", "false"),
        o(this).removeClass("show-password"))
    }),
    document.querySelectorAll(".needs-validation").forEach(function(t) {
        t.addEventListener("submit", function(e) {
            t.checkValidity() || (e.preventDefault(),
            e.stopPropagation()),
            t.classList.add("was-validated")
        }, !1)
    }),
    jQuery().select2 && o('[data-toggle="select2"]').select2(),
    jQuery().mask && o('[data-toggle="input-mask"]').each(function(e, t) {
        var n = o(t).data("maskFormat")
          , a = o(t).data("reverse");
        null != a ? o(t).mask(n, {
            reverse: a
        }) : o(t).mask(n)
    }),
    jQuery().daterangepicker && (i = {
        startDate: moment().subtract(29, "days"),
        endDate: moment(),
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
            "Last 7 Days": [moment().subtract(6, "days"), moment()],
            "Last 30 Days": [moment().subtract(29, "days"), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        }
    },
    o('[data-toggle="date-picker-range"]').each(function(e, t) {
        var n = o.extend({}, i, o(t).data())
          , a = n.targetDisplay;
        o(t).daterangepicker(n, function(e, t) {
            a && o(a).html(e.format("MMMM D, YYYY") + " - " + t.format("MMMM D, YYYY"))
        })
    }),
    s = {
        cancelClass: "btn-light",
        applyButtonClasses: "btn-success"
    },
    o('[data-toggle="date-picker"]').each(function(e, t) {
        var n = o.extend({}, s, o(t).data());
        o(t).daterangepicker(n)
    })),
    jQuery().timepicker && (s = {
        showSeconds: !0,
        icons: {
            up: "mdi-chevron-up",
            down: "mdi-chevron-down"
        }
    },
    o('[data-toggle="timepicker"]').each(function(e, t) {
        var n = o.extend({}, s, o(t).data());
        o(t).timepicker(n)
    })),
    jQuery().TouchSpin && (s = {},
    o('[data-toggle="touchspin"]').each(function(e, t) {
        var n = o.extend({}, s, o(t).data());
        o(t).TouchSpin(n)
    })),
    jQuery().maxlength && (s = {
        warningClass: "badge bg-success",
        limitReachedClass: "badge bg-danger",
        separator: " out of ",
        preText: "You typed ",
        postText: " chars available.",
        placement: "bottom"
    },
    o('[data-toggle="maxlength"]').each(function(e, t) {
        var n = o.extend({}, s, o(t).data());
        o(t).maxlength(n)
    }))
}(jQuery);
var ThemeCustomizer = function() {
    function e() {
        _classCallCheck(this, e),
        this.html = document.getElementsByTagName("html")[0],
        this.config = {},
        this.defaultConfig = window.config
    }
    return _createClass(e, [{
        key: "initConfig",
        value: function() {
            this.defaultConfig = JSON.parse(JSON.stringify(window.defaultConfig)),
            this.config = JSON.parse(JSON.stringify(window.config)),
            this.setSwitchFromConfig()
        }
    }, {
        key: "changeMenuColor",
        value: function(e) {
            this.config.menu.color = e,
            this.html.setAttribute("data-menu-color", e),
            this.setSwitchFromConfig()
        }
    }, {
        key: "changeLeftbarSize",
        value: function(e) {
            var t = !(1 < arguments.length && void 0 !== arguments[1]) || arguments[1];
            this.html.setAttribute("data-sidenav-size", e),
            t && (this.config.sidenav.size = e,
            this.setSwitchFromConfig())
        }
    }, {
        key: "changeLayoutPosition",
        value: function(e) {
            this.config.layout.position = e,
            this.html.setAttribute("data-layout-position", e),
            this.setSwitchFromConfig()
        }
    }, {
        key: "changeLayoutColor",
        value: function(e) {
            this.config.theme = e,
            this.html.setAttribute("data-bs-theme", e),
            this.setSwitchFromConfig()
        }
    }, {
        key: "changeTopbarColor",
        value: function(e) {
            this.config.topbar.color = e,
            this.html.setAttribute("data-topbar-color", e),
            this.setSwitchFromConfig()
        }
    }, {
        key: "changeSidebarUser",
        value: function(e) {
            (this.config.sidenav.user = e) ? this.html.setAttribute("data-sidenav-user", e) : this.html.removeAttribute("data-sidenav-user"),
            this.setSwitchFromConfig()
        }
    }, {
        key: "resetTheme",
        value: function() {
            this.config = JSON.parse(JSON.stringify(window.defaultConfig)),
            this.changeMenuColor(this.config.menu.color),
            this.changeLeftbarSize(this.config.sidenav.size),
            this.changeLayoutColor(this.config.theme),
            this.changeLayoutPosition(this.config.layout.position),
            this.changeTopbarColor(this.config.topbar.color),
            this.changeSidebarUser(this.config.sidenav.user),
            this._adjustLayout()
        }
    }, {
        key: "initSwitchListener",
        value: function() {
            var n = this
              , e = (document.querySelectorAll("input[name=data-menu-color]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeMenuColor(t.value)
                })
            }),
            document.querySelectorAll("input[name=data-sidenav-size]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeLeftbarSize(t.value)
                })
            }),
            document.querySelectorAll("input[name=data-bs-theme]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeLayoutColor(t.value)
                })
            }),
            document.querySelectorAll("input[name=data-layout-position]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeLayoutPosition(t.value)
                })
            }),
            document.querySelectorAll("input[name=data-topbar-color]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeTopbarColor(t.value)
                })
            }),
            document.querySelectorAll("input[name=sidebar-user]").forEach(function(t) {
                t.addEventListener("change", function(e) {
                    n.changeSidebarUser(t.checked)
                })
            }),
            document.getElementById("light-dark-mode"))
              , e = (e && e.addEventListener("click", function(e) {
                "light" === n.config.theme ? n.changeLayoutColor("dark") : n.changeLayoutColor("light")
            }),
            document.querySelector("#reset-layout"))
              , e = (e && e.addEventListener("click", function(e) {
                n.resetTheme()
            }),
            document.querySelector(".button-toggle-menu"))
              , e = (e && e.addEventListener("click", function() {
                var e = n.config.sidenav.size
                  , t = n.html.getAttribute("data-sidenav-size", e);
                "full" === t ? n.showBackdrop() : "fullscreen" == e ? "fullscreen" === t ? n.changeLeftbarSize("fullscreen" == e ? "default" : e, !1) : n.changeLeftbarSize("fullscreen", !1) : "condensed" === t ? n.changeLeftbarSize("condensed" == e ? "default" : e, !1) : n.changeLeftbarSize("condensed", !1),
                n.html.classList.toggle("sidebar-enable")
            }),
            document.querySelector(".button-close-fullsidebar"));
            e && e.addEventListener("click", function() {
                n.html.classList.remove("sidebar-enable"),
                n.hideBackdrop()
            })
        }
    }, {
        key: "showBackdrop",
        value: function() {
            var e = document.createElement("div")
              , t = (e.id = "custom-backdrop",
            e.classList = "offcanvas-backdrop fade show",
            document.body.appendChild(e),
            document.body.style.overflow = "hidden",
            767 < window.innerWidth && (document.body.style.paddingRight = "15px"),
            this);
            e.addEventListener("click", function(e) {
                t.html.classList.remove("sidebar-enable"),
                t.hideBackdrop()
            })
        }
    }, {
        key: "hideBackdrop",
        value: function() {
            var e = document.getElementById("custom-backdrop");
            e && (document.body.removeChild(e),
            document.body.style.overflow = null,
            document.body.style.paddingRight = null)
        }
    }, {
        key: "initWindowSize",
        value: function() {
            var t = this;
            window.addEventListener("resize", function(e) {
                t._adjustLayout()
            })
        }
    }, {
        key: "_adjustLayout",
        value: function() {
            var e = this;
            window.innerWidth <= 767.98 ? e.changeLeftbarSize("full", !1) : 767 <= window.innerWidth && window.innerWidth <= 1140 ? "full" !== e.config.sidenav.size && "fullscreen" !== e.config.sidenav.size && ("sm-hover" === e.config.sidenav.size ? e.changeLeftbarSize("condensed") : e.changeLeftbarSize("condensed", !1)) : e.changeLeftbarSize(e.config.sidenav.size)
        }
    }, {
        key: "setSwitchFromConfig",
        value: function() {
            sessionStorage.setItem("__SITE_CONFIG__", JSON.stringify(this.config)),
            document.querySelectorAll("#theme-settings-offcanvas input[type=checkbox]").forEach(function(e) {
                e.checked = !1
            });
            var e, t, n, a, o, r, i = this.config;
            i && (e = document.querySelector("input[type=checkbox][name=data-bs-theme][value=" + i.theme + "]"),
            t = document.querySelector("input[type=checkbox][name=data-topbar-color][value=" + i.topbar.color + "]"),
            n = document.querySelector("input[type=checkbox][name=data-menu-color][value=" + i.menu.color + "]"),
            a = document.querySelector("input[type=checkbox][name=data-sidenav-size][value=" + i.sidenav.size + "]"),
            o = document.querySelector("input[type=radio][name=data-layout-position][value=" + i.layout.position + "]"),
            r = document.querySelector("input[type=checkbox][name=sidebar-user]"),
            e && (e.checked = !0),
            t && (t.checked = !0),
            n && (n.checked = !0),
            a && (a.checked = !0),
            o && (o.checked = !0),
            r && "true" === i.sidenav.user.toString() && (r.checked = !0))
        }
    }, {
        key: "init",
        value: function() {
            this.initConfig(),
            this.initSwitchListener(),
            this.initWindowSize(),
            this._adjustLayout(),
            this.setSwitchFromConfig()
        }
    }]),
    e
}();
(new ThemeCustomizer).init();
