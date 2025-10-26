<!--**********************************
    Content body start
***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <!--form-->
            <div class="col-xl-3 col-xxl-12">
                <!-- Vehicle Insert Form (Bootstrap) -->
                <form id="createCarForm" action="/vehicles" method="POST" enctype="multipart/form-data" class="p-4 mb-4 bg-white border rounded">
                    @csrf
                    <h4 class="mb-4">Create Vehicle</h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Model</label>
                            <input name="model" class="form-control" placeholder="e.g. Corolla" required value="{{ old('model') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <select name="year" class="form-control">
                                @foreach ($years as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Make</label>
                            <select name="make" class="form-control">
                                @foreach ($makes as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Body</label>
                            <select name="body" class="form-control">
                                @foreach ($bodies as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Transmission</label>
                            <select name="transmission" class="form-control">
                                @foreach ($transmissions as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Condition</label>
                            <select name="condition" class="form-control">
                                @foreach ($conditions as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mileage</label>
                            <input name="mileage" type="number" step="0.01" class="form-control" placeholder="e.g. 12345.67" required value="{{ old('mileage') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Exterior Color</label>
                            <select name="exterior_color" class="form-control">
                                @foreach ($colors as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Interior Color</label>
                            <select name="interior_color" class="form-control">
                                @foreach ($colors as $attribute)
                                <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Price</label>
                            <input name="price" type="number" step="0.01" class="form-control" placeholder="e.g. 25000.00" required value="{{ old('price') }}" />
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter vehicle description here..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Main Image <span class="text-danger">*</span></label>
                            <input type="file" name="main_image" class="form-control" accept="image/*" required />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image 2</label>
                            <input type="file" name="image_2" class="form-control" accept="image/*" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image 3</label>
                            <input type="file" name="image_3" class="form-control" accept="image/*" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image 4</label>
                            <input type="file" name="image_4" class="form-control" accept="image/*" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image 5</label>
                            <input type="file" name="image_5" class="form-control" accept="image/*" />
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i> Add Vehicle
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
                                <h4 class="mb-0 heading">Vehicles List</h4>
                            </div>
                            <div id="vehicleTableWrapper">
                                @include('admin-dashboard.partials.vehicle-table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Vehicle Modal (Bootstrap) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Vehicle</h5>
                <button type="button" class="btn-close" onclick="closeEditModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" id="editVehicleForm" class="row g-3">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div class="col-md-6">
                        <label class="form-label">Model</label>
                        <input name="model" id="edit_model" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price</label>
                        <input name="price" id="edit_price" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Year</label>
                        <select name="year" id="edit_year" class="form-control">
                            @foreach ($years as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Make</label>
                        <select name="make" id="edit_make" class="form-control">
                            @foreach ($makes as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Body</label>
                        <select name="body" id="edit_body" class="form-control">
                            @foreach ($bodies as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Exterior Color</label>
                        <select name="exterior_color" id="edit_exterior_color" class="form-control">
                            @foreach ($colors as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Interior Color</label>
                        <select name="interior_color" id="edit_interior_color" class="form-control">
                            @foreach ($colors as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mileage</label>
                        <input name="mileage" id="edit_mileage" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Transmission</label>
                        <select name="transmission" id="edit_transmission" class="form-control">
                            @foreach ($transmissions as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Condition</label>
                        <select name="condition" id="edit_condition" class="form-control">
                            @foreach ($conditions as $attribute)
                            <option value="{{ $attribute->name }}">{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">New Main Image</label>
                        <input type="file" name="main_image" class="form-control" accept="image/*" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">New Image [2]</label>
                        <input type="file" name="image_2" class="form-control" accept="image/*" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">New Image [3]</label>
                        <input type="file" name="image_3" class="form-control" accept="image/*" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">New Image [4]</label>
                        <input type="file" name="image_4" class="form-control" accept="image/*" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">New Image [5]</label>
                        <input type="file" name="image_5" class="form-control" accept="image/*" />
                    </div>

                    <div class="col-md-12">
                        <label class="form-label" id="existing_image_label">Current Images</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <img src="" alt="Not Uploaded" class="img-thumbnail h-100" id="img_1">
                            </div>
                            <div class="col-4">
                                <img src="" alt="Not Uploaded" class="img-thumbnail h-100" id="img_2">
                            </div>
                            <div class="col-4">
                                <img src="" alt="Not Uploaded" class="img-thumbnail h-100" id="img_3">
                            </div>
                            <div class="col-4">
                                <img src="" alt="Not Uploaded" class="img-thumbnail h-100" id="img_4">
                            </div>
                            <div class="col-4">
                                <img src="" alt="Not Uploaded" class="img-thumbnail h-100" id="img_5">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Close</button>
                <button type="submit" form="editVehicleForm" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openEditModal(id, model, description, year, make, body, exterior_color, interior_color, mileage, transmission, condition, price, main_image, image_2, image_3, image_4, image_5) {
        const form = document.getElementById('editVehicleForm');
        form.action = `/vehicles/${id}`;

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_model').value = model || '';
        document.getElementById('edit_price').value = price || '';
        document.getElementById('edit_year').value = year || '';
        document.getElementById('edit_make').value = make || '';
        document.getElementById('edit_body').value = body || '';
        document.getElementById('edit_exterior_color').value = exterior_color || '';
        document.getElementById('edit_interior_color').value = interior_color || '';
        document.getElementById('edit_mileage').value = mileage || '';
        document.getElementById('edit_transmission').value = transmission || '';
        document.getElementById('edit_condition').value = condition || '';
        document.getElementById('edit_description').value = description || '';

        const img_1 = document.getElementById('img_1');
        const img_2 = document.getElementById('img_2');
        const img_3 = document.getElementById('img_3');
        const img_4 = document.getElementById('img_4');
        const img_5 = document.getElementById('img_5');

        main_image ? img_1.src = "uploads/vehicles/" + main_image : img_1.src = "images/card-image.svg";
        image_2 ? img_2.src = "uploads/vehicles/" + image_2 : img_2.src = "images/card-image.svg";
        image_3 ? img_3.src = "uploads/vehicles/" + image_3 : img_3.src = "images/card-image.svg";
        image_4 ? img_4.src = "uploads/vehicles/" + image_4 : img_4.src = "images/card-image.svg";
        image_5 ? img_5.src = "uploads/vehicles/" + image_5 : img_5.src = "images/card-image.svg";

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
@include('admin-dashboard.footer.vehicle-ajax')
@endpush