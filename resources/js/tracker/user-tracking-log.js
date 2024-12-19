const USER_TRACKING_LOG = (function() {

    var controls = {};
    var vals = {};

    const bindControls = function() {
        var self = {};

        return self;
    }

    const bindVals = function(values) {
        var self = $.extend({}, {}, values);

        return self;
    }

    const bindFunctions = function() {

    }

    const saveUserTrackingLog = function() {
        var data = {
            user_id: vals.user_id,
        }

        apiCreate('/api/v1/tracker/user-tracking-logs/create', data)
            .then(function(response) {
                console.log(response);
            });
    }

    function init(values) {
        controls = bindControls();
        vals = bindVals(values);

        bindFunctions();

        setInterval(function() {
            saveUserTrackingLog();
        }, 300000);
    }

    return {
        init: init,
    }

})();