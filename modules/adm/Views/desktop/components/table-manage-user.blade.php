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
                        <th>Họ và tên</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        @php $key++ @endphp
                        <tr id="row-{{ $key }}">
                            <th>
                                <x-core::checkbox id="checkbox-{{ $key }}" name="user_ids[]" value="{{ $user->_id }}"></x-core::checkbox>
                            </th>
                            <td>{{ $key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{!! $user->badge() !!}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                @include('adm::components.table-action-manage-user')
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