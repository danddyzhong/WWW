xheditor_settings = { skin: 'default', tools: 'full', clickCancelDialog: true, linkTag: false, internalScript: false, inlineScript: false, internalStyle: true, inlineStyle: true, showBlocktag: false, forcePtag: true, upLinkExt: "zip,rar,txt", upImgExt: "jpg,jpeg,gif,png", upFlashExt: "swf", upMediaExt: "wmv,avi,wma,mp3,mid", modalWidth: 350, modalHeight: 220, modalTitle: true, defLinkText: '点击打开链接', layerShadow: 3, emotMark: false, upBtnText: '上传', cleanPaste: 1, hoverExecDelay: 100, html5Upload: true, upMultiple: 99, localUrlTest: /^https?:\/\/[^\/]*?(xheditor\.com)\//i, remoteImgSaveUrl: '../upload/saveremoteimg.php', imgPath: '../images' };
//window.xheditor=xheditor;
var _this = this, _jTools, _jArea, _win = window, _jWin, _doc, _jDoc;
_jWin = $(window);
_doc = window.document;
var settings = $.extend({}, xheditor_settings);
var bookmark;
var bInit = false, bSource = false, bFullscreen = false, bCleanPaste = false, outerScroll, bShowBlocktag = false, sLayoutStyle = '', ev = null, timer, bDisableHoverExec = false, bQuickHoverExec = false;
var lastPoint = null, lastAngle = null;//鼠标悬停显示
var editorHeight = 0;
var agent = navigator.userAgent.toLowerCase();
var bMobile = agent.indexOf('mobile') !== -1, browser = $.browser, browerVer = parseFloat(browser.version), isIE = browser.msie, isMozilla = browser.mozilla, isSafari = browser.safari, isOpera = browser.opera;
var bAir = agent.indexOf(' adobeair/') > -1;
var bIOS5 = /OS 5(_\d)+ like Mac OS X/i.test(agent);
var urlType = settings.urlType, urlBase = settings.urlBase;

$(function () {

    var jBody = $(document);
    //自动清理粘贴内容
    if (isOpera) jBody.bind('keydown', function (e) {
        if (e.ctrlKey && e.which === 86) cleanPaste();
    });
    else
        jBody.bind('paste', cleanPaste);
    //jBody.bind(isIe() ? 'beforepaste' : 'paste', cleanPaste);


});

function isIe() {
    if (!!window.ActiveXObject || "ActiveXObject" in window)
        return true;
    else
        return false;
}

function cleanPaste(ev) {
    if (ev.target.id != 'Msg'&&ev.target.id!='layim_write') return;
    var clipboardData, items, item; //for chrome
    if (ev && (clipboardData = ev.originalEvent.clipboardData) && (items = clipboardData.items) && (item = items[0]) && item.kind == 'file' && item.type.match(/^image\//i)) {
        var blob = item.getAsFile(), reader = new FileReader();
        reader.onload = function () {
            var sHtml = '<img src="' + event.target.result + '" style="display:none;">';
            sHtml = replaceRemoteImg(sHtml, ev.target.id);
            pasteHTML(sHtml, false, ev.target.id);
        }
        reader.readAsDataURL(blob);
        return false;
    }else if(isIe()){

        return false;
    }
    return;
}

//远程图片转本地
function replaceRemoteImg(sHtml, targetId) {
    var localUrlTest = settings.localUrlTest, remoteImgSaveUrl = settings.remoteImgSaveUrl;
    if (localUrlTest && remoteImgSaveUrl) {
        var arrRemoteImgs = [], count = 0;
        sHtml = sHtml.replace(/(<img)((?:\s+[^>]*?)?(?:\s+src="\s*([^"]+)\s*")(?: [^>]*)?)(\/?>)/ig, function (all, left, attr, url, right) {
            if (/^(https?|data:image)/i.test(url) && !/_xhe_temp/.test(attr) && !localUrlTest.test(url)) {
                count = $('#' + targetId).find('img[remoteimg]').length;
                arrRemoteImgs[count] = url;
                attr = attr.replace(/\s+(width|height)="[^"]*"/ig, '').replace(/\s+src="[^"]*"/ig, ' src="../images/loading.gif" remoteimg="' + (count++) + '"');

            }
            return left + attr + right;
        });
        if (arrRemoteImgs.length > 0) {
            $.post(remoteImgSaveUrl, { urls: arrRemoteImgs.join('|') }, function (data) {
                data = data.split('|');
                if (data) {
                    $('img[remoteimg]', '#' + targetId).each(function () {
                        var $this = $(this);
                        var strArr = data.toString().split(';');
                        if (strArr.length > 0) {
                            if (strArr[$this.attr('remoteimg')]) {
                                var temp = strArr[$this.attr('remoteimg')].split('#');
                                if (temp.length > 0) {
                                    xheAttr($this, 'src', temp[0]);
                                }
                            }
                            $this.removeAttr('remoteimg');
                            $this.show();
                        }
                    });
                }
            }).error();
        }
    }
    return sHtml;
}
function xheAttr(jObj, n, v) {
    if (!n) return false;
    var kn = '_xhe_' + n;
    if (v)//设置属性
    {
        if (urlType) v = getLocalUrl(v, urlType, urlBase);
        jObj.attr(n, urlBase ? getLocalUrl(v, 'abs', urlBase) : v).removeAttr(kn)//.attr(kn, v);
    }
    return jObj.attr(kn) || jObj.attr(n);
}
var pasteHTML = function (sHtml, bStart, targetId) {
    if (bSource) return false;
    focus(targetId);
    sHtml = processHTML(sHtml, 'write');
    var sel = getSel(), rng = getRng();
    if (bStart !== undefined)//非覆盖式插入
    {
        if (rng.item) {
            var item = rng.item(0);
            rng = _this.getRng(true);
            rng.moveToElementText(item);
            rng.select();
        }
        rng.collapse(bStart);
    }
    sHtml += '<' + (isIe() ? 'img' : 'span') + ' id="_xhe_temp" width="0" height="0" />';
    if (rng.insertNode) {
        if ($(rng.startContainer).closest('style,script').length > 0) return false;//防止粘贴在style和script内部
        rng.deleteContents();
        rng.insertNode(rng.createContextualFragment(sHtml));
    }
    else {
        if (sel.type.toLowerCase() === 'control') { sel.clear(); rng = _this.getRng(); };
        rng.pasteHTML(sHtml);
    }
    var jTemp = $('#_xhe_temp', _doc), temp = jTemp[0];
    if (isIe()) {
        rng.moveToElementText(temp);
        rng.select();
    }
    else {
        rng.selectNode(temp);
        sel.removeAllRanges();
        sel.addRange(rng);
    }
    jTemp.remove();
}

var saveBookmark = function () {
    if (!bSource) {
        focus();
        var rng = getRng();
        rng = rng.cloneRange ? rng.cloneRange() : rng;
        bookmark = { 'top': _jWin.scrollTop(), 'rng': rng };
    }
}
var loadBookmark = function () {
    if (bSource || !bookmark) return;
    _this.focus();
    var rng = bookmark.rng;
    if (isIe()) rng.select();
    else {
        var sel = _this.getSel();
        sel.removeAllRanges();
        sel.addRange(rng);
    }
    _jWin.scrollTop(bookmark.top);
    bookmark = null;
}
var focus = function (targetId) {
    if (!bSource) {
        $('#' + targetId).focus();
    }
    else $('#sourceCode', _doc).focus();
    if (isIe()) {
        var rng = getRng();
        if (rng.parentElement && rng.parentElement().ownerDocument !== _doc) setTextCursor();//修正IE初始焦点问题
    }
    return false;
}
var getRng = function (bNew) {
    var sel, rng;
    try {
        if (!bNew) {
            sel = getSel();
            rng = sel.createRange ? sel.createRange() : sel.rangeCount > 0 ? sel.getRangeAt(0) : null;
        }
        if (!rng) rng = $('#Msg').createTextRange ? $('#Msg').createTextRange() : $('#Msg').createRange();
    } catch (ex) { }
    return rng;
}
var setTextCursor = function (bLast) {
    var rng = _this.getRng(true), cursorNode = _doc.body;
    if (isIe()) rng.moveToElementText(cursorNode);
    else {
        var chileName = bLast ? 'lastChild' : 'firstChild';
        while (cursorNode.nodeType != 3 && cursorNode[chileName]) { cursorNode = cursorNode[chileName]; }
        rng.selectNode(cursorNode);
    }
    rng.collapse(bLast ? false : true);
    if (isIe()) rng.select();
    else { var sel = _this.getSel(); sel.removeAllRanges(); sel.addRange(rng); }
}
var getSel = function () {
    var _doc = $('#Msg');
    return _doc.selection ? _doc.selection : _win.getSelection();
}
var processHTML = function (sHtml, mode) {
    return sHtml;
}
function getLocalUrl(url, urlType, urlBase)//绝对地址：abs,根地址：root,相对地址：rel
{
    if ((url.match(/^(\w+):\/\//i) && !url.match(/^https?:/i)) || /^#/i.test(url) || /^data:/i.test(url)) return url;//非http和https协议，或者页面锚点不转换，或者base64编码的图片等
    var baseUrl = urlBase ? $('<a href="' + urlBase + '" />')[0] : location, protocol = baseUrl.protocol, host = baseUrl.host, hostname = baseUrl.hostname, port = baseUrl.port, path = baseUrl.pathname.replace(/\\/g, '/').replace(/[^\/]+$/i, '');
    if (port === '') port = '80';
    if (path === '') path = '/';
    else if (path.charAt(0) !== '/') path = '/' + path;//修正IE path
    url = $.trim(url);
    //删除域路径
    if (urlType !== 'abs') url = url.replace(new RegExp(protocol + '\\/\\/' + hostname.replace(/\./g, '\\.') + '(?::' + port + ')' + (port === '80' ? '?' : '') + '(\/|$)', 'i'), '/');
    //删除根路径
    if (urlType === 'rel') url = url.replace(new RegExp('^' + path.replace(/([\/\.\+\[\]\(\)])/g, '\\$1'), 'i'), '');
    //加上根路径
    if (urlType !== 'rel') {
        if (!url.match(/^(https?:\/\/|\/)/i)) url = path + url;
        if (url.charAt(0) === '/')//处理根路径中的..
        {
            var arrPath = [], arrFolder = url.split('/'), folder, i, l = arrFolder.length;
            for (i = 0; i < l; i++) {
                folder = arrFolder[i];
                if (folder === '..') arrPath.pop();
                else if (folder !== '' && folder !== '.') arrPath.push(folder);
            }
            if (arrFolder[l - 1] === '') arrPath.push('');
            url = '/' + arrPath.join('/');
        }
    }
    //加上域路径
    if (urlType === 'abs' && !url.match(/^https?:\/\//i)) url = protocol + '//' + host + url;
    url = url.replace(/(https?:\/\/[^:\/?#]+):80(\/|$)/i, '$1$2');//省略80端口
    return url;
}