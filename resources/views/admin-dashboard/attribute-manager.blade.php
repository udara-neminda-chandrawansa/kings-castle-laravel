<!--**********************************
    Content body start
***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <!--select attr type-->
            <div class="col-12">
                <div class="p-4 mb-4 bg-white border rounded">
                    <label for="selectAttr">Select Attribute Type</label>
                    <!-- Dropdown -->
                    <select name="selectAttr" id="selectAttr" class="form-control">
                        <option value="years">Year</option>
                        <option value="conditions">Condition</option>
                        <option value="makes">Make</option>
                        <option value="transmissions">Transmission</option>
                        <option value="bodies">Body</option>
                        <option value="colors">Color</option>
                    </select>
                </div>
            </div>
            <!--form-->
            <div class="col-xl-3 col-xxl-12">
                <!-- Attribute Insert Form (Bootstrap) -->
                <form id="createAttributeForm" action="/years" method="POST" class="p-4 mb-4 bg-white border rounded">
                    @csrf
                    <h4 class="mb-4">Create Attribute</h4>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Name</label>
                            <input name="name" class="form-control" placeholder="Sample" required value="{{ old('name') }}" />
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Add Attribute
                            </button>
                        </div>
                    </div>
                </form>

            </div>
            <!--table-->
            <div class="col-xl-9 col-xxl-12">
                <div class="card">
                    <div class="p-0 card-body">
                        <div class="table-responsive active-projects">
                            <div class="tbl-caption">
                                <h4 class="mb-0 heading">Attributes List</h4>
                            </div>
                            <div id="attributeTableWrapper">
                                @include('admin-dashboard.partials.attribute-table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Attribute Modal (Bootstrap) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Attribute</h5>
                <button type="button" class="btn-close" onclick="closeEditModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" id="editAttributeForm" class="row g-3">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div class="col-md-12">
                        <label class="form-label">Name</label>
                        <input name="name" id="edit_name" class="form-control" required />
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Close</button>
                <button type="submit" form="editAttributeForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, name) {
        const form = document.getElementById('editAttributeForm');
        form.action = `/${document.getElementById('selectAttr').value}/${id}`;

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name || '';

        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    }

    function closeEditModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        modal.hide();
    }
</script>

<!--**********************************
    Content body end
***********************************-->

@push('page-ajax')
@include('admin-dashboard.partials.loading-modal')
@include('admin-dashboard.footer.attribute-ajax')
@endpush