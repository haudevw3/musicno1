<header id="page-header" class="page-header bg-white border-bottom p-20">
    <div class="page-header-content d-flex">
        <div class="col-3 items-align-vertical-center">
            <div class="page-header-title d-flex">
                <div class="page-header-icon">
                    <i class="fa-regular fa-compact-disc text-gray"></i>
                </div>
                <span class="fw-semibold ml-10">Danh sách bài hát</span>
            </div>
        </div>
        <?php _require('song.components.actions-manage-song') ?>
    </div>
</header>

<main id="page-main-content" class="page-main-content">
    <?php _require('components.adm.modal-dialog') ?>
    <?php require _namespace('song.components.table-manage-song') ?>
</main>