<header id="page-header" class="page-header bg-white border-bottom p-20">
    <div class="page-header-content d-flex">
        <div class="col-3 items-align-vertical-center">
            <div class="page-header-title d-flex">
                <div class="page-header-icon">
                    <i class="fa-regular fa-layer-group text-gray"></i>
                </div>
                <span class="fw-semibold ml-10">Danh sách danh mục</span>
            </div>
        </div>
        <?php _require('categories.components.actions-manage-category') ?>
    </div>
</header>

<main id="page-main-content" class="page-main-content">
    <?php _require('components.adm.modal-dialog') ?>
    <?php require _namespace('categories.components.table-manage-category') ?>
</main>