@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Tour Package: {{ $tourPackage->name }}</h4>
                        <a href="{{ route('tour-packages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tour Packages
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('tour-packages.update', $tourPackage) }}" method="POST"
                            id="tourPackageForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                                    <label for="name" class="form-label">Package Name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control"
                                                        value="{{ old('name', $tourPackage->name) }}" required>
                                                    @error('name')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="subtitle" class="form-label">Subtitle <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="subtitle" id="subtitle"
                                                        class="form-control"
                                                        value="{{ old('subtitle', $tourPackage->subtitle) }}"
                                                        placeholder="Short catchy description" required>
                                                    @error('subtitle')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="price" class="form-label">Price (USD)</label>
                                                    <input type="number" name="price" id="price" class="form-control"
                                                        value="{{ old('price', $tourPackage->price) }}" step="0.01"
                                                        min="0" placeholder="Leave empty for 'Contact for price'">
                                                    @error('price')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="price_unit" class="form-label">Price Unit <span
                                                            class="text-danger">*</span></label>
                                                    <select name="price_unit" id="price_unit" class="form-select"
                                                        required>
                                                        <option value="per pax" {{ old('price_unit', $tourPackage->
                                                            price_unit) == 'per pax' ? 'selected' : '' }}>per pax
                                                        </option>
                                                        <option value="per group" {{ old('price_unit', $tourPackage->
                                                            price_unit) == 'per group' ? 'selected' : '' }}>per group
                                                        </option>
                                                        <option value="per hour" {{ old('price_unit', $tourPackage->
                                                            price_unit) == 'per hour' ? 'selected' : '' }}>per hour
                                                        </option>
                                                        <option value="per day" {{ old('price_unit', $tourPackage->
                                                            price_unit) == 'per day' ? 'selected' : '' }}>per day
                                                        </option>
                                                        <option value="per activity" {{ old('price_unit', $tourPackage->
                                                            price_unit) == 'per activity' ? 'selected' : '' }}>per
                                                            activity</option>
                                                    </select>
                                                    @error('price_unit')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label for="duration" class="form-label">Duration <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="duration" id="duration"
                                                        class="form-control"
                                                        value="{{ old('duration', $tourPackage->duration) }}"
                                                        placeholder="e.g., 1 Hour, Half Day, Full Day" required>
                                                    @error('duration')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="image_file" class="form-label">Package Image</label>
                                                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                                                    @error('image_file')<small class="text-danger">{{ $message }}</small>@enderror
                                                    <small class="text-muted">Upload JPG, PNG, GIF (Max: 2MB) - Leave empty to keep current image</small>
                                                    @if($tourPackage->image_path)
                                                        <div class="mt-2">
                                                            <small class="text-info">Current: {{ basename($tourPackage->image_path) }}</small>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="difficulty_level" class="form-label">Difficulty Level
                                                        <span class="text-danger">*</span></label>
                                                    <select name="difficulty_level" id="difficulty_level"
                                                        class="form-select" required>
                                                        <option value="easy" {{ old('difficulty_level', $tourPackage->
                                                            difficulty_level) == 'easy' ? 'selected' : '' }}>Easy
                                                        </option>
                                                        <option value="moderate" {{ old('difficulty_level',
                                                            $tourPackage->difficulty_level) == 'moderate' ? 'selected' :
                                                            '' }}>Moderate</option>
                                                        <option value="challenging" {{ old('difficulty_level',
                                                            $tourPackage->difficulty_level) == 'challenging' ?
                                                            'selected' : '' }}>Challenging</option>
                                                    </select>
                                                    @error('difficulty_level')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="min_participants" class="form-label">Minimum
                                                        Participants <span class="text-danger">*</span></label>
                                                    <select name="min_participants" id="min_participants"
                                                        class="form-select" required>
                                                        @for($i = 1; $i <= 10; $i++) <option value="{{ $i }}" {{
                                                            old('min_participants', $tourPackage->min_participants) ==
                                                            $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                    @error('min_participants')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="max_participants" class="form-label">Maximum
                                                        Participants <span class="text-danger">*</span></label>
                                                    <select name="max_participants" id="max_participants"
                                                        class="form-select" required>
                                                        @for($i = 1; $i <= 20; $i++) <option value="{{ $i }}" {{
                                                            old('max_participants', $tourPackage->max_participants) ==
                                                            $i ? 'selected' : '' }}>{{ $i }}</option>
                                                            @endfor
                                                    </select>
                                                    @error('max_participants')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="description" class="form-label">Description <span
                                                            class="text-danger">*</span></label>
                                                    <textarea name="description" id="description" class="form-control"
                                                        rows="4" placeholder="Describe this tour package..."
                                                        required>{{ old('description', $tourPackage->description) }}</textarea>
                                                    @error('description')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="notes" class="form-label">Notes</label>
                                                    <input type="text" name="notes" id="notes" class="form-control"
                                                        value="{{ old('notes', $tourPackage->notes) }}"
                                                        placeholder="Additional notes or conditions">
                                                    @error('notes')<small class="text-danger">{{ $message
                                                        }}</small>@enderror
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
                                                <label class="form-label">Package Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="is_active"
                                                        id="is_active" value="1" {{ old('is_active',
                                                        $tourPackage->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active (Available for booking)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Includes Section -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">What's Included</h5>
                                        </div>
                                        <div class="card-body">
                                            <div id="includes-container">
                                                @if($tourPackage->includes && count($tourPackage->includes) > 0)
                                                @foreach($tourPackage->includes as $include)
                                                <div class="row include-row">
                                                    <div class="col-md-10 mb-2">
                                                        <input type="text" name="includes[]" class="form-control"
                                                            value="{{ $include }}" placeholder="Enter what's included">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-danger remove-include">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <div class="row include-row">
                                                    <div class="col-md-10 mb-2">
                                                        <input type="text" name="includes[]" class="form-control"
                                                            placeholder="Enter what's included (e.g., Professional guide, Transportation)">
                                                    </div>
                                                    <div class="col-md-2 mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-danger remove-include" disabled>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            <button type="button" id="add-include"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-plus me-1"></i>Add Another Item
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
                                                <img id="preview-image" src="{{ asset($tourPackage->image_path) }}"
                                                    alt="Tour Preview" class="img-fluid rounded mb-2"
                                                    style="height: 120px; object-fit: cover; width: 100%;">
                                                <h6 id="preview-name" class="mb-1">{{ $tourPackage->name }}</h6>
                                                <p id="preview-subtitle" class="text-muted small mb-1">{{
                                                    $tourPackage->subtitle }}</p>
                                                <p id="preview-price" class="text-success mb-1">
                                                    <strong>
                                                        @if($tourPackage->price)
                                                        ${{ number_format($tourPackage->price) }} {{
                                                        $tourPackage->price_unit }}
                                                        @else
                                                        Contact for price
                                                        @endif
                                                    </strong>
                                                </p>
                                                <p id="preview-duration" class="mb-1"><small><i
                                                            class="fas fa-clock me-1"></i>{{ $tourPackage->duration
                                                        }}</small></p>
                                                <p id="preview-difficulty" class="mb-2">
                                                    <small>
                                                        <span
                                                            class="badge badge-{{ $tourPackage->difficulty_level == 'easy' ? 'success' : ($tourPackage->difficulty_level == 'moderate' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($tourPackage->difficulty_level) }}
                                                        </span>
                                                    </small>
                                                </p>
                                                <p id="preview-description" class="text-muted small">{{
                                                    Str::limit($tourPackage->description, 100) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('tour-packages.index') }}"
                                            class="btn btn-light me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>Update Tour Package
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
    // Add include functionality
    let includeCount = document.querySelectorAll('.include-row').length;
    
    document.getElementById('add-include').addEventListener('click', function() {
        includeCount++;
        const container = document.getElementById('includes-container');
        const newRow = document.createElement('div');
        newRow.className = 'row include-row';
        newRow.innerHTML = `
            <div class="col-md-10 mb-2">
                <input type="text" name="includes[]" class="form-control" placeholder="Enter what's included">
            </div>
            <div class="col-md-2 mb-2">
                <button type="button" class="btn btn-outline-danger remove-include">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    // Remove include functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-include')) {
            e.target.closest('.include-row').remove();
            includeCount--;
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.include-row');
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-include');
            removeBtn.disabled = rows.length === 1;
        });
    }

    // Live preview functionality
    function updatePreview() {
        const name = document.getElementById('name').value || '{{ $tourPackage->name }}';
        const subtitle = document.getElementById('subtitle').value || '{{ $tourPackage->subtitle }}';
        const price = document.getElementById('price').value;
        const priceUnit = document.getElementById('price_unit').value || 'per pax';
        const duration = document.getElementById('duration').value || '{{ $tourPackage->duration }}';
        const difficulty = document.getElementById('difficulty_level').value || 'easy';
        const description = document.getElementById('description').value || '{{ $tourPackage->description }}';
        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-subtitle').textContent = subtitle;
        
        if (price) {
            document.getElementById('preview-price').innerHTML = `<strong>$${parseFloat(price).toLocaleString()} ${priceUnit}</strong>`;
        } else {
            document.getElementById('preview-price').innerHTML = `<strong>Contact for price</strong>`;
        }
        
        document.getElementById('preview-duration').innerHTML = `<small><i class="fas fa-clock me-1"></i>${duration}</small>`;
        
        const difficultyClasses = {
            'easy': 'badge-success',
            'moderate': 'badge-warning', 
            'challenging': 'badge-danger'
        };
        document.getElementById('preview-difficulty').innerHTML = `<small><span class="badge ${difficultyClasses[difficulty]}">${difficulty.charAt(0).toUpperCase() + difficulty.slice(1)}</span></small>`;
        
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
    ['name', 'subtitle', 'price', 'price_unit', 'duration', 'difficulty_level', 'description'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
        }
    });

    // Initialize
    updateRemoveButtons();
});
</script>

@endsection