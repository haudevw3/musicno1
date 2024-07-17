const STATE = (function () {

    var ctrls = {};

    const bindControl = function () {

    }

    const bindFunction = function () {

    }

    const push = function (state = {}, url, unused = "") {
        history.pushState(state, unused, url);
    }

    const get = function () {
        var state = history.state;
        return (state !== null && typeof state === "object") ? state : null;
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        push: push,
        get: get,
    }

})();

STATE.init();