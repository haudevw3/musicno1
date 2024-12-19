const FILE_MANAGER = (function() {

    var controls = {};
    var inputName = null;

    const imageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    const audioTypes = ['audio/mpeg', 'audio/mp3'];

    const bindControls = function() {
        var self = {};

        self.fileManager = $('#fm');
        self.open = $('.ofm');
        self.btnCancle = $('#btn-fm-cancle');
        self.btnDestroy = $('#btn-fm-destroy');
        self.btnConfirm = $('#btn-fm-confirm');
        self.btnUpload = $('#btn-fm-upload');
        self.btnCheck = $('#btn-fm-check');
        self.table = $('#file-manager-table');
        self.filesWaitingConfirm = $('#files-waiting-confirm');

        return self;
    }

    const bindFunctions = function() {
        controls.open.on('click', open);
        controls.btnCancle.on('click', cancle);
        controls.btnDestroy.on('click', destroyFileUploaded);
        controls.btnUpload.on('change', uploadFilesAndWaitingConfirm);
        controls.btnCheck.on('click', checkedCheckboxAndWaitingConfirm);
    }

    const uploadFilesAndWaitingConfirm = function (e) {
        var files = e.target.files;
        var formData = new FormData;
        
        if (files.length > 0) {
            controls
                .table
                .addClass('d-none');

            controls
                .filesWaitingConfirm
                .addClass('d-grid')
                .removeClass('d-none')
                .empty();


            $.each(files, function (index, file) {
                var fileReader = new FileReader;

                fileReader.onload = function (e) {
                    var src = e.target.result;

                    var html = `<img class="thumbnail card" src="${src}"></img>`;

                    controls.filesWaitingConfirm.append(html);
                }

                fileReader.readAsDataURL(file);

                formData.append(`files[${index}]`, file);
            });
            
            controls
                .btnConfirm
                .addClass('d-block')
                .removeClass('d-none');

            controls
                .btnDestroy
                .addClass('d-block')
                .removeClass('d-none');

            controls.btnConfirm.off('click').on('click', function() {
                apiUpload('/api/v1/files/upload', formData).then(function(response) {
                    if (response.success) {
                        showToast(response.success);

                        showTable();
                    }
                    
                });
            });
        }
    }

    const showTable = function() {
        controls
            .table
            .addClass('d-block')
            .removeClass('d-none');

        controls
            .btnConfirm
            .addClass('d-none')
            .removeClass('d-block');

        controls
            .btnDestroy
            .addClass('d-none')
            .removeClass('d-block');
        
        controls
            .filesWaitingConfirm
            .addClass('d-none')
            .removeClass('d-block');

        apiGet('/api/v1/files/list').then(function(response) {
            if (response) {
                var html = '';

                $.each(response, function (key, value) {
                    html += `
                    <tr>
                        <td class="col-1">
                            <div class="form-check">
                                <input class="form-check-input" id="fm-checkbox-${key}" type="checkbox" value="${value.url}" name="fm_urls[]">
                                <label class="form-check-label" for="fm-checkbox-${key}"></label>
                            </div>
                        </td>
                        <td class="col-4"><div style="width: 200px;" class="text-overflow-1line">${value.name}</div></td>
                        <td class="col-2">${value.type}</td>
                        <td class="col-3">${value.updated_at}</td>
                        <td class="col-2">
                            <div class="d-flex">
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="/${value.url}" target="_blank">
                                    <i class="fa-regular fa-link"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                });
            
                controls.table.find('tbody').html(html);
            }
        });
    }

    const checkedCheckboxAndWaitingConfirm = function() {
        var array = TABLE.getCheckboxesValue('fm_urls', true);
        
        if (array.length == 0) {
            showToast('Vui lòng tích vào các ô để sử dụng chức năng này.', toastOptions.warning);
        } else {
            var invalid = false;

            if (inputName == 'audio' && array.length > 1) {
                showToast('Chỉ được chọn tối đa một tệp âm thanh.', toastOptions.warning);

                return;
            }

            $.each(array, function (key, value) {
                const segments = value.split('.');
                const mimeType = inputName + '/' + segments[1];
                
                if ((inputName == 'image' && imageTypes.indexOf(mimeType) == -1) ||
                    (inputName == 'audio' && audioTypes.indexOf(mimeType) == -1)) {
                        invalid = true;

                        showToast('Loại tệp tin không đúng định dạng. Vui lòng kiểm tra lại.', toastOptions.warning);
                }
            });

            if (invalid) {
                return;
            }

            $('#' + inputName).find('input').val(array.join('|'));

            cancle();
        }
    }

    const open = function() {
        inputName = $(this).attr('name');

        controls
            .fileManager
            .removeClass('d-none')
            .addClass('d-block');

        showTable();
    }

    const cancle = function() {
        controls
            .filesWaitingConfirm
            .empty();

        controls
            .fileManager
            .addClass('d-none')
            .removeClass('d-block');

        controls
            .table
            .find('tbody')
            .empty();
    }

    const destroyFileUploaded = function() {
        controls.filesWaitingConfirm.empty();
    }

    function init() {
        controls = bindControls();
        
        bindFunctions();
    }

    return {
        init: init,
    }

})();

FILE_MANAGER.init();