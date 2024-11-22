<div class="d-flex position-relative">
    <x-adm::table-button class="me-2" icon="ellipsis-vertical" extra="data-index={{ $key }}"></x-adm::table-button>

    <x-adm::table-button tag="a" class="me-2" icon="pen-to-square" url="{{ route('adm-edit-category', $category->_id) }}"></x-adm::table-button>

    <x-adm::table-button class="btn-delete-category" icon="trash-can" extra="data-category-id={{ $category->_id }}"></x-adm::table-button>

    <div class="dropdown-menu animated-fade-in-up shadow">
        
    </div>
</div>