<table id="vehicles-tbl" class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Vehicle</th>
            <th>Price</th>
            <th>Year</th>
            <th class="text-center">Main Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="vehiclesTableBody">
        @foreach($vehicles as $vehicle)
        <tr class="border-bottom">
            <td class="align-middle text-start">{{ $vehicle->id }}</td>
            <td class="align-middle text-start">
                <div class="fw-bold">{{ $vehicle->model }}</div>
            </td>
            <td class="align-middle text-start">
                Rs. {{ number_format($vehicle->price, 2) }}
            </td>
            <td class="align-middle text-start">
                {{ $vehicle->manufactured_year }}
            </td>
            <td class="text-center align-middle">
                @if($vehicle->main_image)
                <img src="{{ asset('/uploads/vehicles/' . $vehicle->main_image) }}"
                     alt="{{ $vehicle->model }}"
                     class="img-thumbnail" style="width: 48px; height: 48px; object-fit: cover;">
                @else
                <div class="d-flex align-items-center justify-content-center bg-light" style="width: 48px; height: 48px;">
                    <svg class="text-muted" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
            </td>
            <td class="text-center align-middle">
                <div class="gap-2 d-flex justify-content-end">
                    <button class="btn btn-sm btn-outline-primary"
                        onclick="openEditModal(
                            '{{ $vehicle->id }}',
                            '{{ addslashes($vehicle->model) }}',
                            '{{ addslashes($vehicle->description) }}',
                            '{{ $vehicle->year }}',
                            '{{ addslashes($vehicle->make) }}',
                            '{{ addslashes($vehicle->body) }}',
                            '{{ addslashes($vehicle->exterior_color) }}',
                            '{{ addslashes($vehicle->interior_color) }}',
                            '{{ $vehicle->mileage }}',
                            '{{ addslashes($vehicle->transmission) }}',
                            '{{ addslashes($vehicle->condition) }}',
                            '{{ $vehicle->price }}',
                            '{{ addslashes($vehicle->main_image) }}',
                            '{{ addslashes($vehicle->image_2) }}',
                            '{{ addslashes($vehicle->image_3) }}',
                            '{{ addslashes($vehicle->image_4) }}',
                            '{{ addslashes($vehicle->image_5) }}'
                        )">
                        Edit
                    </button>

                    <form method="POST" action="{{ route('vehicles.destroy', $vehicle->id) }}" class="d-inline delete-vehicle-form" data-vehicle-id="{{ $vehicle->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-2 px-3">
    {{ $vehicles->links('pagination::bootstrap-5') }}
</div>
