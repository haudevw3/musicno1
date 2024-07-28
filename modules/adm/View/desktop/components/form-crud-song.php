<div class="d-flex">
    <div class="form-container box-shadow-01 rounded-6 bg-color-white">
        <div class="form-top">
            <div class="box-text bg-color-white-01 vertical-center-items pl-20 pr-20 fs-16 fw-600 text-color-blue"><?php echo $title ?></div>
            <div class="divider-01"></div>
        </div>
        <div class="form-body p-20">
            <form method="post" action="<?php echo isset($song) ? route('adm-update-song') : route('adm-create-song') ?>" enctype="multipart/form-data">
                <input name="<?php echo isset($song) ? 'id' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($song) ? $song['id'] : null ?>" />

                <input name="<?php echo isset($song) ? 'duration' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($song) ? $song['duration'] : null ?>" />

                <input name="<?php echo isset($song) ? 'image_url' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($song) ? $song['image'] : null ?>" />

                <input name="<?php echo isset($song) ? 'audio_url' : null ?>" type="text" class="d-none"
                       value="<?php echo isset($song) ? $song['audio'] : null ?>" />

                <div class="mb-3">
                    <label for="name" class="form-label fw-600">Tên bài hát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-pen"></i>
                        <input name="name" type="text" id="name" class="form-control need-convert-to-slug" placeholder="Nhập tên bài hát"
                               value="<?php echo isset($song) ? $song['name'] : old('name') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('name') ?></div>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-600">Đường dẫn hiển thị:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-link"></i>
                        <input name="slug" type="text" id="slug" class="form-control converted-slug" placeholder="Nhập đường dẫn hiển thị"
                               value="<?php echo isset($song) ? $song['slug'] : old('slug') ?>">
                    </div>
                    <div class="form-text text-color-red"><?php echo error('slug') ?></div>
                </div>

                <div class="mb-3">
                    <label for="file-upload" class="form-label fw-600">Ảnh bài hát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-regular fa-camera"></i>
                        <input name="image" type="file" class="col-12 file-upload" id="file-upload">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="audio-upload" class="form-label fw-600">Âm thanh bài hát:</label>
                    <div class="form-group input-md-01">
                        <i class="fa-sharp fa-regular fa-volume"></i>
                        <input name="audio" type="file" class="col-12 file-upload" id="audio-upload">
                    </div>
                </div>

                <div class="form-bottom mt-20 col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-md-01 bg-color-blue-01"><?php echo isset($song) ? 'Cập nhật bài hát' : 'Tạo bài hát' ?></button>
                </div>
            </form>
        </div>
    </div>
</div>