const MANAGE_ALBUM = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formSaveAlbum = $('#form-save-album');
        self.btnSaveAlbum = $('#btn-save-album');
        self.btnDeleteAlbum = $('.btn-delete-album');

        return self;
    }

    const bindFunctions = function() {
        controls.btnSaveAlbum.on('click', saveAlbum);
        controls.btnDeleteAlbum.on('click', deleteAlbum);
        controls.formSaveAlbum.find('[name=name]').on('change', changeSlugIf);
    }

    const saveAlbum = function() {
        var id = controls.formSaveAlbum.attr('data-album-id');

        var data = {
            name: getInputVal(controls.formSaveAlbum.find('[name=name]')),
            slug: getInputVal(controls.formSaveAlbum.find('[name=slug]')),
            album_type: getInputVal(controls.formSaveAlbum.find('[name=album_type]')),
            release_year: getInputVal(controls.formSaveAlbum.find('[name=release_year]')),
            images: {
                url: getInputVal(controls.formSaveAlbum.find('[name=image]'), false)
            },
            artists: TEXT_EDITOR.getMentionData(),
        }

        if (data.artists == '') {
            isInvalid(controls.formSaveAlbum.find('[name=text-editor]'));
        } else {
            isInvalid(controls.formSaveAlbum.find('[name=text-editor]'), false);
        }

        const required = [data.name, data.slug, data.type, data.release_year, data.artists];
        
        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }

        else if(id == '') {
            apiCreate('/api/v1/albums/create', data, {useInvalidFeedback: true})
                .then(function(response) {
                    if (response.success) {
                        showToast(response.success, toastOptions.success);

                        setTimeout(function() {
                            window.location.reload();
                        }, 500);
                    }
                });
        }
    }

    const deleteAlbum = function() {  
        var id = $(this).attr('data-album-id');
        
        showDialog('Xóa album',
        'Bạn có muốn xóa album này không. Khi xóa mọi dữ liệu liên quan đến album này sẽ được xóa vĩnh viễn.')
            .then(function () {
                apiDelete('/api/v1/albums/delete', {id: id}).then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-album/page-1';

                        sessionStorage.setItem('success', response.success);
                    }
                });
            });
    }


    const changeSlugIf = function() {
        controls.formSaveAlbum.find('[name=slug]').val(
            renderSlug($(this).val())
        );
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            saveAlbum();
        }
    });

    function init() {
        controls = bindControls();

        bindFunctions();

        TEXT_EDITOR.init({url: '/api/v1/artists/search/?name='});
    }

    return {
        init: init,
    }

})();

MANAGE_ALBUM.init();