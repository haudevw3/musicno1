const CONVERT_SLUG = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.name = $(".need-convert-to-slug");
        self.slug = $(".converted-slug");
        return self;
    }

    const bindFunction = function () {
        ctrls.name.on("change", eventOnChangeName);
    }

    const eventOnChangeName = function () {
        var val = $(this).val();
        ctrls.slug.val(convertSlug(val));
    }

    const convertSlug = function (val) {
        return val
                .toString()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, "")
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/&/g, '-and-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init
    }

})();

CONVERT_SLUG.init();