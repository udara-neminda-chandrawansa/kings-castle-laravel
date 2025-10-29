@extends('admin-dashboard.layouts.admin-dash-layout')

@section('content')

<style>
    .gallery-item {
        transition: transform 0.2s;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
    }

    .gallery-image {
        transition: opacity 0.2s;
    }

    .gallery-item:hover .gallery-image {
        opacity: 0.9;
    }

    .sortable-ghost {
        opacity: 0.5;
    }

    .sort-handle:hover {
        background-color: #495057 !important;
    }
    
    #gallery-container{
        user-select: none;
    }
</style>

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close p-0" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close p-0" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0">Room Gallery: {{ $roomType->name }}</h4>
                            <small class="text-muted">Manage additional images for this room type</small>
                        </div>
                        <div>
                            <a href="{{ route('room-types.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Room Types
                            </a>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadImagesModal">
                                <i class="fas fa-plus me-2"></i>Add Images
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Room Type Info -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" 
                                         class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">Main Image</h6>
                                        <small class="text-muted">Primary room photo</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <h5>{{ $roomType->name }}</h5>
                                <p class="text-muted">{{ $roomType->description }}</p>
                                <p><strong>Price:</strong> {{ $roomType->formatted_price }}/night | 
                                   <strong>Max Occupancy:</strong> {{ $roomType->max_occupancy }} guests</p>
                                <p><strong>Gallery Images:</strong> {{ $roomType->roomImages->count() }} images</p>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        @if($roomType->roomImages->count() > 0)
                        <div class="row" id="gallery-container">
                            @foreach($roomType->roomImages as $image)
                            <div class="col-lg-3 col-md-4 col-sm-6" data-image-id="{{ $image->id }}">
                                <div class="card gallery-item">
                                    <div class="position-relative">
                                        <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" 
                                             class="card-img-top gallery-image" style="height: 200px; object-fit: cover;">
                                        
                                        <!-- Overlay with actions -->
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <div class="">
                                                <button class="btn btn-sm btn-warning edit-image-btn" 
                                                        data-image-id="{{ $image->id }}"
                                                        data-alt-text="{{ $image->alt_text }}"
                                                        data-sort-order="{{ $image->sort_order }}"
                                                        title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                {{-- <button class="btn btn-sm btn-danger delete-image-btn" 
                                                        data-image-id="{{ $image->id }}"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button> --}}

                                                <form action="{{ route('room-images.destroy', [$roomType, $image]) }}" method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger delete-btn"
                                                        title="Delete Booking">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Sort handle -->
                                        {{-- <div class="position-absolute top-0 start-0 p-2">
                                            <span class="badge bg-dark sort-handle" style="cursor: move;" title="Drag to reorder">
                                                <i class="fas fa-arrows-alt"></i> {{ $image->sort_order }}
                                            </span>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="card-body">
                                        <small class="text-muted d-block">{{ $image->alt_text ?: 'No description' }}</small>
                                        <small class="text-info">Order: {{ $image->sort_order }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- @if($roomType->roomImages->count() > 1)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tip:</strong> You can drag and drop images to reorder them. The order will be saved automatically.
                        </div>
                        @endif --}}

                        @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5>No Gallery Images</h5>
                            <p class="text-muted">This room type doesn't have any additional images yet.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadImagesModal">
                                <i class="fas fa-plus me-2"></i>Add First Images
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Images Modal -->
<div class="modal fade" id="uploadImagesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Room Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="uploadForm" action="{{ route('room-images.store', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="images" class="form-label">Select Images <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple 
                               accept="image/*" required>
                        <small class="text-muted">Select up to 10 images (JPG, PNG, GIF, WebP - Max 5MB each)</small>
                    </div>

                    <!-- Image Previews -->
                    <div id="imagePreviewContainer" class="row" style="display: none;">
                        <div class="col-12">
                            <h6>Selected Images:</h6>
                            <div id="imagePreviews" class="row"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                        <i class="fas fa-upload me-2"></i>Upload Images
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editImageForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_alt_text" class="form-label">Image Description</label>
                        <input type="text" name="alt_text" id="edit_alt_text" class="form-control" 
                               placeholder="Enter image description...">
                    </div>
                    <div class="mb-3">
                        <label for="edit_sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="form-control" min="0">
                        <small class="text-muted">Lower numbers appear first</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Sortable.js -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomTypeId = {{ $roomType->id }};
    
    // Image upload preview
    document.getElementById('images').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const container = document.getElementById('imagePreviewContainer');
        const previews = document.getElementById('imagePreviews');
        
        if (files.length > 0) {
            previews.innerHTML = '';
            container.style.display = 'block';
            
            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" alt="Preview" style="height: 120px; object-fit: cover;" class="card-img-top">
                                <div class="card-body p-2">
                                    <input type="text" name="alt_texts[${index}]" class="form-control form-control-sm" 
                                           placeholder="Image description...">
                                </div>
                            </div>
                        `;
                        previews.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            container.style.display = 'none';
        }
    });

    // Upload form submission
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const uploadBtn = document.getElementById('uploadBtn');
        const originalText = uploadBtn.innerHTML;
        
        uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
        uploadBtn.disabled = true;
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                return response.text().then(text => {
                    console.error('Expected JSON but got:', text.substring(0, 500));
                    throw new Error('Server returned non-JSON response');
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Success response:', data);
            if (data.success) {
                location.reload(); // Reload to show new images
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('An error occurred while uploading images: ' + error.message);
        })
        .finally(() => {
            uploadBtn.innerHTML = originalText;
            uploadBtn.disabled = false;
        });
    });

    // Edit image functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-image-btn')) {
            const btn = e.target.closest('.edit-image-btn');
            const imageId = btn.dataset.imageId;
            const altText = btn.dataset.altText;
            const sortOrder = btn.dataset.sortOrder;
            
            document.getElementById('edit_alt_text').value = altText;
            document.getElementById('edit_sort_order').value = sortOrder;
            
            const form = document.getElementById('editImageForm');
            form.action = `{{ route('room-images.update', [$roomType->id, ':imageId']) }}`.replace(':imageId', imageId);
            
            console.log('Edit form action URL:', form.action);
            console.log('Room Type ID:', roomTypeId);
            console.log('Image ID:', imageId);
            
            new bootstrap.Modal(document.getElementById('editImageModal')).show();
        }
    });

    // Edit form submission
    document.getElementById('editImageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        // Add the _method field for Laravel to recognize this as a PUT request
        formData.append('_method', 'PUT');
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Edit response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                return response.text().then(text => {
                    console.error('Expected JSON but got:', text.substring(0, 500));
                    throw new Error('Server returned non-JSON response');
                });
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Edit success response:', data);
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Edit error:', error);
            alert('An error occurred while updating the image: ' + error.message);
        });
    });

    // Delete image functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-image-btn')) {
            const btn = e.target.closest('.delete-image-btn');
            const imageId = btn.dataset.imageId;
            
            if (confirm('Are you sure you want to delete this image? This action cannot be undone.')) {
                const deleteUrl = `{{ route('room-images.destroy', [$roomType->id, ':imageId']) }}`.replace(':imageId', imageId);
                
                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Delete response status:', response.status);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            console.error('Expected JSON but got:', text.substring(0, 500));
                            throw new Error('Server returned non-JSON response');
                        });
                    }
                    
                    return response.json();
                })
                .then(data => {
                    console.log('Delete success response:', data);
                    if (data.success) {
                        // Remove the image from DOM
                        btn.closest('[data-image-id]').remove();
                        
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    alert('An error occurred while deleting the image: ' + error.message);
                });
            }
        }
    });

    // Handle delete confirmation with SweetAlert2
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this booking? This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

{{-- 
    // Initialize sortable for drag and drop reordering
    @if($roomType->roomImages->count() > 1)
    const galleryContainer = document.getElementById('gallery-container');
    if (galleryContainer) {
        Sortable.create(galleryContainer, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.sort-handle',
            onEnd: function(evt) {
                const imageOrders = {};
                const items = galleryContainer.children;
                
                for (let i = 0; i < items.length; i++) {
                    const imageId = items[i].dataset.imageId;
                    imageOrders[imageId] = i + 1;
                }
                
                // Update sort order on server
                fetch(`/admin/room-types/${roomTypeId}/images/sort-order`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ image_orders: imageOrders })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update sort order badges
                        Object.entries(imageOrders).forEach(([imageId, order]) => {
                            const item = document.querySelector(`[data-image-id="${imageId}"]`);
                            const badge = item.querySelector('.sort-handle');
                            badge.innerHTML = `<i class="fas fa-arrows-alt"></i> ${order}`;
                            
                            const orderText = item.querySelector('.text-info');
                            orderText.textContent = `Order: ${order}`;
                        });
                    } else {
                        console.error('Failed to update sort order');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    }
    @endif
--}}

@endsection
