const MANAGE_CATEGORY = (function() {

    var controls = {};

    const bindControls = function() {
        var self = {};

        self.formSaveCategory = $('#form-save-category');
        self.btnSaveCategory = $('#btn-save-category');
        self.btnDeleteCategory = $('.btn-delete-category');

        return self;
    }

    const bindFunctions = function() {
        controls.btnSaveCategory.on('click', saveCategory);
        controls.btnDeleteCategory.on('click', deleteCategory);
        controls.formSaveCategory.find('[name=name]').on('change', changeSlugIf);
    }

    const saveCategory = function() {
        var id = controls.formSaveCategory.attr('data-category-id');

        var data = {
            name: getInputVal(controls.formSaveCategory.find('[name=name]')),
            slug: getInputVal(controls.formSaveCategory.find('[name=slug]')),
            priority: getInputVal(controls.formSaveCategory.find('[name=priority]')),
            parent_id: getInputVal(controls.formSaveCategory.find('[name=parent_id]'), false),
            tag_type: getInputVal(controls.formSaveCategory.find('[name=tag_type')),
            images: getInputVal(controls.formSaveCategory.find('[name=images]'), false),
        };

        if (data.images != '') {
            data.images = data.images.split('|');
        }

        const required = [data.name, data.slug];

        if (required.includes('')) {
            showAlert('danger', 'Vui lòng nhập đầy đủ thông tin vào các ô bên dưới.');
        }

        else if (id == '') {
            apiCreate('/api/v1/categories/create', data, {useInvalidFeedback: true, useAlert: true})
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

            apiUpdate('/api/v1/categories/update', data, {useInvalidFeedback: true, useAlert: true})
                .then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-category/page-1';
                        
                        sessionStorage.setItem('success', response.success);
                    }
                });
        }
    }

    const deleteCategory = function() {  
        var id = $(this).attr('data-category-id');
        
        showDialog('Xóa danh mục',
        'Bạn có muốn xóa danh mục này không. Khi xóa mọi dữ liệu liên quan đến danh mục này sẽ được đặt lại mặc định.')
            .then(function () {
                apiDelete('/api/v1/categories/delete', {id: id}).then(function(response) {
                    if (response.success) {
                        window.location = '/adm/manage-category/page-1';

                        sessionStorage.setItem('success', response.success);
                    }
                });
            });
    }

    const changeSlugIf = function() {
        controls.formSaveCategory.find('[name=slug]').val(
            renderSlug($(this).val())
        );
    }

    $(document).on('keydown', function(event) {
        if (event.originalEvent.keyCode === 13) {
            saveCategory();
        }
    });

    function init() {
        controls = bindControls();

        bindFunctions();
    }

    return {
        init: init,
    }

})();

MANAGE_CATEGORY.init();