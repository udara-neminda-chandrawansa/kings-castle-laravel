@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add New Room Type</h4>
                        <a href="{{ route('room-types.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Room Types
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('room-types.store') }}" method="POST" id="roomTypeForm" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="name" class="form-label">Room Type Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control" 
                                                           value="{{ old('name') }}" required>
                                                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="price_per_night" class="form-label">Price per Night (Rs) <span class="text-danger">*</span></label>
                                                    <input type="number" name="price_per_night" id="price_per_night" class="form-control" 
                                                           value="{{ old('price_per_night') }}" step="0.01" min="0" required>
                                                    @error('price_per_night')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="max_occupancy" class="form-label">Maximum Occupancy <span class="text-danger">*</span></label>
                                                    <select name="max_occupancy" id="max_occupancy" class="form-select" required>
                                                        <option value="">Select Maximum Guests</option>
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ old('max_occupancy') == $i ? 'selected' : '' }}>
                                                                {{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    @error('max_occupancy')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="image_file" class="form-label">Room Image</label>
                                                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                                                    @error('image_file')<small class="text-danger">{{ $message }}</small>@enderror
                                                    <small class="text-muted">Upload JPG, PNG, GIF (Max: 2MB)</small>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                                    <textarea name="description" id="description" class="form-control" rows="4" 
                                                              placeholder="Describe this room type..." required>{{ old('description') }}</textarea>
                                                    @error('description')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status & Preview -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Status & Settings</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Room Type Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="is_active" 
                                                           id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active (Available for booking)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Amenities Section -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Amenities</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="amenities-container">
                                                <div class="row amenity-row">
                                                    <div class="col-md-10 mb-2">
                                                        <input type="text" name="amenities[]" class="form-control" 
                                                               placeholder="Enter amenity (e.g., WiFi, Air Conditioning)">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <button type="button" class="btn btn-outline-danger remove-amenity" disabled>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button type="button" id="add-amenity" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Add Another Amenity
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Card -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Preview</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="preview-card" class="border rounded p-3">
                                                <img id="preview-image" src="{{ asset('assets/img/drive-images-2-webp/kc1.webp') }}" 
                                                     alt="Room Preview" class="img-fluid rounded mb-2" style="height: 120px; object-fit: cover; width: 100%;">
                                                <h6 id="preview-name" class="mb-1">Room Type Name</h6>
                                                <p id="preview-price" class="text-success mb-1"><strong>Rs 0/night</strong></p>
                                                <p id="preview-occupancy" class="mb-2"><small>Max 0 guests</small></p>
                                                <p id="preview-description" class="text-muted small">Description will appear here...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('room-types.index') }}" class="btn btn-light me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Create Room Type
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add amenity functionality
    let amenityCount = 1;
    
    document.getElementById('add-amenity').addEventListener('click', function() {
        amenityCount++;
        const container = document.getElementById('amenities-container');
        const newRow = document.createElement('div');
        newRow.className = 'row amenity-row';
        newRow.innerHTML = `
            <div class="col-md-10 mb-2">
                <input type="text" name="amenities[]" class="form-control" placeholder="Enter amenity">
            </div>
            <div class="col-md-2 mb-2">
                <button type="button" class="btn btn-outline-danger remove-amenity">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    // Remove amenity functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-amenity')) {
            e.target.closest('.amenity-row').remove();
            amenityCount--;
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.amenity-row');
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-amenity');
            removeBtn.disabled = rows.length === 1;
        });
    }

    // Live preview functionality
    function updatePreview() {
        const name = document.getElementById('name').value || 'Room Type Name';
        const price = document.getElementById('price_per_night').value || '0';
        const occupancy = document.getElementById('max_occupancy').value || '0';
        const description = document.getElementById('description').value || 'Description will appear here...';

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-price').innerHTML = `<strong>Rs ${parseFloat(price).toLocaleString()}/night</strong>`;
        document.getElementById('preview-occupancy').innerHTML = `<small>Max ${occupancy} ${occupancy == 1 ? 'guest' : 'guests'}</small>`;
        document.getElementById('preview-description').textContent = description.length > 100 ? description.substring(0, 100) + '...' : description;
    }

    // Handle image file preview
    document.getElementById('image_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Add event listeners for live preview
    ['name', 'price_per_night', 'max_occupancy', 'description'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
        document.getElementById(id).addEventListener('change', updatePreview);
    });

    // Initialize
    updateRemoveButtons();
    updatePreview();
});
</script>

@endsection
