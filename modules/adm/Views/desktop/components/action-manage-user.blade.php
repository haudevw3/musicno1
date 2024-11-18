<div class="col-9 items-align-vertical-center-end">
    <x-core::button tag="a" icon="user-plus" name="Thêm thành viên" url="{{ route('adm-add-user') }}"
    class="btn-sm btn-light text-primary mr-10"></x-core::button>

    <x-core::button tag="button" icon="trash" name="Xóa nhanh" id="btn-delete-many-user"
    class="btn-sm btn-red mr-10"></x-core::button>
</div>