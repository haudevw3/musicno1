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
                            <x-core::checkbox id="checkbox"></x-core::checkbox>
                        </th>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Tên đường dẫn</th>
                        <th>Loại danh mục</th>
                        <th>Danh mục phụ thuộc</th>
                        <th>Cập nhật gần đây</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key => $category)
                        @php $key++ @endphp

                        <tr id="row-{{ $key }}">
                            <th>
                                <x-core::checkbox id="checkbox-{{ $key }}" name="category_ids[]" value="{{ $category->_id }}"></x-core::checkbox>
                            </th>
                            <td>{{ $key }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td> {!! $category->badge() !!} </td>
                            <td>{!! $category->badges !!}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                @include('adm::components.table-action-manage-category')
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