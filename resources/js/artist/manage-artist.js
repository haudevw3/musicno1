const MANAGE_ARTIST = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formSaveArtist = $('#form-save-artist');
        self.btnSaveArtist = $('#btn-save-artist');
        self.btnDeleteArtist = $('.btn-delete-artist');

        return self;
    }

    const bindFunctions = function() {
        controls.btnSaveArtist.on('click', saveArtist);
        controls.btnDeleteArtist.on('click', deleteArtist);
        controls.formSaveArtist.find('[name=name]').on('change', changeSlugIf);
    }

    const saveArtist = function() {
        var id = controls.formSaveArtist.attr('data-artist-id');

        var data = {
            name: getInputVal(controls.formSaveArtist.find('[name=name]')),
            slug: getInputVal(controls.formSaveArtist.find('[name=slug]')),
            image: getInputVal(controls.formSaveArtist.find('[name=image]')),
        }

        const required = [data.name, data.slug, data.image];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng điền đầy đủ thông tin nghệ sĩ vào các ô bên dưới.');
        }

        else if (id == '') {
            apiCreate('/api/v1/artists/create', data, {useInvalidFeedback: true})
                .then(function(response) {
                    if (response.success) {
                        showToast(response.success, toastOptions.success);

                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    }
                });
        }

        else {
            data.id = id;

            apiUpdate('/api/v1/artists/update', data, {useInvalidFeedback: true})
                .then(function(response) {
                    if (response.success) {
                        sessionStorage.setItem('success', response.success);

                        window.location = '/adm/manage-artist/page-1';
                    }
                });
        }
    }

    const deleteArtist = function() {  
        var id = $(this).attr('data-artist-id');
        
        showDialog('Xóa nghệ sĩ',
        'Bạn có muốn xóa nghệ sĩ này không. Khi xóa mọi dữ liệu liên quan đến nghệ sĩ này sẽ được xóa vĩnh viễn.')
            .then(function () {
                apiDelete('/api/v1/artists/delete', {id: id}).then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-artist/page-1';

                        sessionStorage.setItem('success', response.success);
                    }
                });
            });
    }

    const changeSlugIf = function() {
        controls.formSaveArtist.find('[name=slug]').val(
            renderSlug($(this).val())
        );
    }

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
    }

})();

MANAGE_ARTIST.init();