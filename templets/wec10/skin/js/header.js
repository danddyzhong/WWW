define("newsmedia:widget/header/header.js", function (e, n) {
    var a = {
        init: function () {
            this.header = $("#Header"), this.menuCount = serverData.menuCount, this.logoheight = serverData.logoheight, this.channelname = serverData.channelname, this.header.find(".logo img").css("top", (60 - this.logoheight) / 2), this.ulwidth = 135, this.render()
        }, render: function () {
            var e = [], n = this;
            if ($.each(serverData.menu, function (n, a) {
                    if (e.push('<li class="menu">'), e.push(a.url.length ? '<a href="' + a.url + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>" : '<a href="/' + a.enname + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>"), a.list.length) {
                        e.push('<div class="submenulist nodis">');
                        for (var n = 0; n < Math.ceil(a.list.length / 5); n++) {
                            e.push("<ul>");
                            for (var s = 0; 5 > s; s++)a.list[5 * n + s] && e.push('<li class="submenu"><a href="/' + a.list[5 * n + s].enname + '" class="submenua"><span class="ename">' + a.list[5 * n + s].name + "</span></a></li>");
                            e.push("</ul>")
                        }
                        e.push("</div>")
                    }
                    e.push("</li>")
                }), this.header.find(".menulist.large ul").html(e.join("")), $.each(this.header.find(".menu"), function (e, a) {
                    $(a).data("enname") == n.channelname && $(a).addClass("active")
                }), this.header.find(".menulist.large .menu").width(Math.floor(100 / this.menuCount) + "%"), e = "", serverData.menu.length < 6 && ($.each(serverData.menu, function (n, a) {
                    e += ['<li class="menu">', a.url.length ? '<a href="' + a.url + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>" : '<a href="/' + a.enname + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>", "</li>"].join("")
                }), e += "</ul></div>", this.header.find(".menulist.medium ul").append(e), this.header.find(".menulist.medium .menu").width(Math.floor(100 / this.menuCount) + "%")), serverData.menu.length > 5) {
                var a = serverData.menu.splice(4, serverData.menu.length - 4);
                $.each(serverData.menu, function (n, a) {
                    e += ['<li class="menu">', a.url.length ? '<a href="' + a.url + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>" : '<a href="/' + a.enname + '" data-enname="' + a.enname + '" class="menua">' + a.name + "</a>", "</li>"].join("")
                }), e += ['<li class="menu">', '<a href="javascript:;" class="menua">更多</a>', '<div class="submenulist nodis">', "<ul>"].join(""), $.each(a, function (n, a) {
                    e += ['<li class="submenu">', a.url.length ? '<a href="' + a.url + '" data-enname="' + a.enname + '" class="menua">' : '<a href="/' + a.enname + '" data-enname="' + a.enname + '" class="menua">', '<span class="ename">' + a.name + "</span>", "</a>", "</li>"].join("")
                }), e += "</ul></div></li>", this.header.find(".menulist.medium ul").append(e), this.header.find(".menulist.medium .menu").width(this.menuCount > 5 ? Math.floor(20) + "%" : Math.floor(100 / this.menuCount) + "%")
            }
            this.addEvent()
        }, addEvent: function () {
            this.header.on("mouseover", ".menu", $.proxy(this.showSubmenu, this)), this.header.on("mouseout", ".menu", $.proxy(this.hideSubmenu, this)), this.header.on("click", ".searchA", $.proxy(this.showSearchbar, this)), this.header.on("click", ".sub-menu", $.proxy(this.showSubmenuInSmallScreen, this)), this.header.find("input").on("keyup", $.proxy(this.toSearch, this)), $("body").on("click", $.proxy(this.hideSearchbar, this))
        }, showSubmenu: function (e) {
            var n = $(e.currentTarget);
            if (n.find(".submenulist").length) {
                var a, s = n.find(".submenulist ul").length, i = n.width(), t = n[0].getBoundingClientRect().left;
                n.find(".submenulist").width(this.ulwidth * s + "px"), s > 1 && t + this.ulwidth * s + 30 > window.innerWidth ? (a = this.ulwidth * s - i + (i - this.ulwidth) / 2, n.find(".submenulist").css("left", "-" + a + "px")) : (a = (i - this.ulwidth) / 2, n.find(".submenulist").css("left", a + "px")), n.find(".submenulist").removeClass("nodis")
            }
            n.addClass("hover")
        }, hideSubmenu: function (e) {
            var n = $(e.currentTarget);
            n.find(".submenulist").length && n.find(".submenulist").addClass("nodis"), n.removeClass("hover")
        }, showSearchbar: function (e) {
            var n = $(e.currentTarget);
            n.closest(".headerSearch").hasClass("showbar") || (n.closest(".headerSearch").addClass("showbar"), -1 == navigator.userAgent.indexOf("MSIE") ? setTimeout(function () {
                n.closest(".searchbar").find("input").removeClass("nodis").focus(), n.closest(".searchbar").find(".txt .i").removeClass("nodis")
            }, 200) : (n.closest(".searchbar").find("input").removeClass("nodis").focus(), n.closest(".searchbar").find(".txt .i").removeClass("nodis")))
        }, hideSearchbar: function (e) {
            $(e.target).closest(".searchbar").length || (this.header.find(".headerSearch").removeClass("showbar"), this.header.find("input").addClass("nodis"), this.header.find(".txt .i").addClass("nodis"))
        }, toSearch: function (e) {

        }, showSubmenuInSmallScreen: function () {
            var e = $(".wrap"), n = $(".mod-sidebar");
            this.changeSubmenuBtnStyle(), e.hasClass("slideLeft") ? (e.removeClass("slideLeft"), setTimeout(function () {
                n.css("visibility", "hidden")
            }, 500)) : (e.addClass("slideLeft"), n.css("visibility", "visible"))
        }, changeSubmenuBtnStyle: function () {
            var e = $("#Header .icon-submenu");
            e.addClass("icon-submenu-active"), setTimeout(function () {
                e.removeClass("icon-submenu-active")
            }, 500)
        }
    };
    n.header = a
});