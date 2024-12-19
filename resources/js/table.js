const TABLE = (function() {

    var controls = {};
    var length = 0;
    var changed = false;

    const bindControls = function () {
        var self = {};

        self.overlay = $('#overlay');
        self.checkbox = $('#checkbox');
        self.datatable = $('.datatable');

        return self;
    }

    const bindFunctions = function () {
        controls.checkbox.on('click', changeCheckboxesState);
        controls.datatable.find('.show-options').on('click', showOptions);
        controls.overlay.on('click', hideOptions);
    }

    const changeCheckboxesState = function () {

        changed = ! changed ? true : false;
        
        setCheckboxesState(changed);
    }

    const setCheckboxesState = function (value) {
        controls.checkbox.prop('checked', value);
        
        for (var i = 1; i <= length; i++) {
            $(`#checkbox-${i}`).prop('checked', value);
        }
    }

    const showOptions = function () {
        var id =  '#row-' + $(this).attr('data-index');

        $(id).find('.dropdown-menu').addClass('d-block');

        controls.overlay.addClass('d-block');
    }

    const hideOptions = function () {
        controls.overlay.removeClass('d-block');
        controls.datatable.find('.dropdown-menu').removeClass('d-block');
    }

    const hasMoreCheckboxes = function () {
        var hasMore = false;

        if (changed) {
            hasMore = true;
        }

        for (var i = 1; i <= length; i++) {
            if ($(`#checkbox-${i}`).prop('checked')) {
                hasMore = true;

                break;
            }
        }

        return hasMore;
    }

    const getCheckboxesValue = function (name, needArray = false) {
        var values = controls.datatable.find(`[name='${name}[]']:checkbox:checked`)
            .map(function () {
                return $(this).val();
            }).get();

        if (needArray) {
            return values;
        }

        return $.extend({}, values);
    }

    const createFormData = function (name) {
        var values = getCheckboxesValue(name);

        var formData = new FormData;

        $.each(values, function (key, value) {
            formData.append(`${name}[${key}]`, value);
        });

        return formData;
    }

    $(document).ready(function () {
        length = controls.datatable.find('tbody tr').length; 
    });

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
        hasMoreCheckboxes: hasMoreCheckboxes,
        getCheckboxesValue: getCheckboxesValue,
        setCheckboxesState: setCheckboxesState,
        createFormData: createFormData,
    }

})();

TABLE.init();