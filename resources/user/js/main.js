const MAIN = (function () {

    var ctrls = {};

    const bindControl = function () {
        var self = {};
        self.mainContent = $("#main-content");
        self.style01 = self.mainContent.find(".music-style-01");
        self.style02 = self.mainContent.find(".music-style-02");
        self.style03 = self.mainContent.find(".music-style-03");
        return self;
    }

    const bindFunction = function () {

    }

    const style01Html = function (data) {
        var tags = data.subs.map(function (value, key) {
            return `<div class="card-wrapper"><a href="${BASE_URL + data.slug + '/' + value.slug}"><img src="${value.image}"></a></div>`;
        }).join('');
        return `<div id="music-style-01" class="music-style-01"><div class="card-container d-flex justify-content-between">${tags}</div></div>`;
    }

    const style02Html = function (data) {
        var tags = data.songs.map(function (song, key) {
            return `
                    <div class="card-wrapper">
                        <div class="song-detail d-flex">
                            <div class="song-info d-flex cursor-pointer" data-position="${key}">
                                <div class="song-image"><img src="${song.image}"></div>
                                <div class="ml-10 vertical-center-items">
                                    <div class="box-common">
                                        <div class="box-text song-name fw-500 text-color-white text-overflow-01">${song.name}</div>
                                        <div class="box-text song-composer fs-12 fw-500 text-color-dark-05 text-overflow-01 mt-5">${song.artist_name}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="song-interact ml-10 center-items">
                                <div class="box-icon center-items rounded-circle text-color-white"><i class="fa-regular fa-heart"></i></div>
                                <div class="box-icon center-items rounded-circle text-color-white ml-20"><i class="fa-regular fa-ellipsis"></i></div>
                            </div>
                        </div>
                    </div>
                `;
        }).join('');
        return `<div id="music-style-02" class="music-style-02">
                    <div class="box-common"><div class="box-text text-color-white fw-600 fs-20">${data.name}</div></div>
                    <div class="card-container">${tags}</div>
                </div>`;
    }

    const style03Html = function (data) {
        var tags = data.map(function (value, key) {
            var temp = $.map(value.subs, function (_value, _key) {
                return `
                    <a href="${BASE_URL + value.slug + '/' + _value.slug}" class="card-wrapper">
                        <div class="card-image"><img src="${_value.image}"></div>
                        <div class="card-text fw-600 text-color-dark-04 text-overflow-02 mt-10">${_value.name}</div>
                    </a>
                `;
            }).join('');

            return `
                <div class="box-common d-flex justify-content-between mt-20">
                    <div class="box-text text-color-white fw-600 fs-20">${value.name}</div>
                    <a href="#" class="box-text mt-5 fw-600 text-color-dark-04">Hiển thị tất cả</a>
                </div>
                <div class="card-container">${temp}</div>
            `;
        }).join('');
        return `<div id="music-style-03" class="music-style-03">${tags}</div>`;
    }

    const setContent = function (html) {
        ctrls.mainContent.html(html);
    }

    function init() {
        ctrls = bindControl();
        bindFunction();
    }

    return {
        init: init,
        setContent: setContent,
        style01Html: style01Html,
        style02Html: style02Html,
        style03Html: style03Html,
    }
})();

MAIN.init();