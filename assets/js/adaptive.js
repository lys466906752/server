
(function (win, lib) {
    var doc = win.document;
    var docEl = doc.documentElement;

    var devicePixelRatio = win.devicePixelRatio;
    var dpr = 1; // 鐗╃悊鍍忕礌涓庨€昏緫鍍忕礌鐨勫搴斿叧绯�
    var scale = 1; // css鍍忕礌缂╂斁姣旂巼
    // 璁剧疆viewport
    function setViewport() {
        dpr = 1;
        win.devicePixelRatioValue = dpr;
        //win.devicePixelRatio = win.devicePixelRatio*win.devicePixelRatio;
        scale = 1 / dpr;
        var metaEl = doc.createElement('meta');
        metaEl.setAttribute('name', 'viewport');
        metaEl.setAttribute('content', 'initial-scale=' + scale + ', maximum-scale=' + scale + ', minimum-scale=' + scale + ', user-scalable=no');
        if (docEl.firstElementChild) {
            docEl.firstElementChild.appendChild(metaEl);
        }
        else {
            var wrap = doc.createElement('div');
            wrap.appendChild(metaEl);
            doc.write(wrap.innerHTML);
        }
    }
    setViewport();
    var newBase = 100;
 lib.baseFont = 18;
    function setRem() {
        var visualView = Math.min(docEl.getBoundingClientRect().width, lib.maxWidth); // visual viewport
        newBase = 100 * visualView / lib.desinWidth;
        docEl.style.fontSize = newBase + 'px';
    }
    var tid;
    lib.desinWidth = 640;
   
    lib.maxWidth = 540;
    lib.init = function () {
        win.addEventListener('resize', function () {
            clearTimeout(tid);
            tid = setTimeout(setRem, 300);
        }, false);
        /*win.addEventListener('onorientationchange', function () {
            clearTimeout(tid);
            tid = setTimeout(setRem, 300);
        }, false);*/
        win.addEventListener('pageshow', function (e) {
            if (e.persisted) {
                clearTimeout(tid);
                tid = setTimeout(setRem, 300);
            }
        }, false);
        if (doc.readyState === 'complete') {
            doc.body.style.fontSize = lib.baseFont * dpr + 'px';
        }
        else {
            doc.addEventListener('DOMContentLoaded', function (e) {
                doc.body.style.fontSize = lib.baseFont * dpr + 'px';
            }, false);
        }
        setRem();
        docEl.setAttribute('data-dpr', dpr);
    };
})(window, window['adaptive'] || (window['adaptive'] = {}));
window['adaptive'].desinWidth = 640;
window['adaptive'].baseFont = 28;
window['adaptive'].maxWidth = 640;
window['adaptive'].init();