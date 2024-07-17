const SESSION = (function () {

    var ctrls = {};

    const bindControl = function () {

    }

    const bindFunction = function () {

    }

    const set = function (key, value) {
        sessionStorage.setItem(key, value);
    }

    const get = function (key) {
        return sessionStorage.getItem(key);
    }

    const remove = function (key) {
        sessionStorage.removeItem(key);
    }

    const flush = function () {
        sessionStorage.clear();
    }

    const name = function (index) {
        return sessionStorage.key(index);
    }

    const size = function () {
        sessionStorage.length;
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        get: get,
        set: set,
        remove: remove,
        flush: flush,
        name: name,
        size: size,
    }

})();

SESSION.init();