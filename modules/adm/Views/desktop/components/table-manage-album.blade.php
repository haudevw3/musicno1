<div id="datatable" class="datatable card shadow">
    <div class="card-header fw-semibold">Bảng dữ liệu</div>

    <div class="card-body">
        <div class="datatable-top d-flex justify-content-between">
            @include('adm::components.table-header')
        </div>

        <div class="datatable-container mt-20">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <x-core::check-box id="checkbox"></x-core::check-box>
                        </th>
                        <th>STT</th>
                        <th>Tên album</th>
                        <th>Loại album</th>
                        <th>Nghệ sĩ</th>
                        <th>Bài hát</th>
                        <th>Tổng số bài hát</th>
                        <th>Cập nhật gần đây</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($albums as $key => $album)
                        @php $key++ @endphp

                        <tr id="row-{{ $key }}">
                            <th>
                                <x-core::checkbox id="checkbox-{{ $key }}" name="album_ids[]" value="{{ $album->_id }}"></x-core::checkbox>
                            </th>
                            <td>{{ $key }}</td>
                            <td>{{ $album->name }}</td>
                            <td>{!! $album->badge() !!}</td>
                            <td>{!! $album->badges() !!}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $album->updated_at }}</td>
                            <td>
                                @include('adm::components.table-action-manage-album')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="datatable-bottom items-align-vertical-center-end mt-20">
            <x-core::pagination :paginator="$paginator"></x-core::pagination>
        </div>
    </div>
</div>