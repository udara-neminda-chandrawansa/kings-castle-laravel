@extends('layouts.public-site')

@section('content')

<style>
    .form-item label {
        color: white !important;
    }

    .room-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .room-card:hover {
        /* transform: translateY(-5px); */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .room-card.selected {
        border: 3px solid #007bff;
        background: rgba(0, 123, 255, 0.1);
    }
    .font-serif,
    .font-serif input,
    .font-serif select,
    .font-serif textarea {
        font-family: serif !important;
    }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/drive-images-2-webp/kc21.webp') }}">
        <div
            style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
        </div>
        <div class="container relative" style="z-index: 10;">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Book Your Room</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Book Room</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="overflow-hidden space">
    <div class="container">

        <!-- Booking Parameters Display -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <strong>Check-in:</strong><br>
                            <span class="fs-5">{{ \Carbon\Carbon::parse($bookingData['check_in'])->format('M d, Y')
                                }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Check-out:</strong><br>
                            <span class="fs-5">{{ \Carbon\Carbon::parse($bookingData['check_out'])->format('M d, Y')
                                }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Guests:</strong><br>
                            <span class="fs-5">{{ $bookingData['adults'] }} Adults{{ $bookingData['children'] > 0 ? ', '
                                . $bookingData['children'] . ' Children' : '' }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Duration:</strong><br>
                            <span class="fs-5">
                                @php
                                $nights =
                                \Carbon\Carbon::parse($bookingData['check_out'])->diffInDays(\Carbon\Carbon::parse($bookingData['check_in']));
                                @endphp
                                {{ $nights }} {{ $nights == 1 ? 'Night' : 'Nights' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Selection -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="title-area text-center mb-4">
                    <h2 class="sec-title">Select Your Room</h2>
                    <p>Choose from our available room types for your stay</p>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            @foreach($roomTypes as $roomType)
            <div class="col-lg-6">
                <div class="room-box room-card card h-100 {{ $selectedRoom && $selectedRoom->id == $roomType->id ? 'selected' : '' }}"
                    onclick="selectRoom({{ $roomType->id }})" data-room-id="{{ $roomType->id }}">
                    <div class="box-img">
                        <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" style="height: 100%;" />
                    </div>
                    <span class="discount">{{ $roomType->formatted_price }} per night</span>
                    <div class="box-title-area">
                        <div class="box-number">{{ $roomType->id }}</div>
                        <h3 class="box-title">
                            <a href="#">{{ $roomType->name }}</a>
                        </h3>
                    </div>
                    <div class="box-content">
                        <div class="box-wrapp">
                            <div class="box-number">{{ $roomType->id }}</div>
                            <h3 class="box-title">
                                <a href="#">{{ $roomType->name }}</a>
                            </h3>
                            <div class="box-review">
                                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                                    class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                                    class="fa-sharp fa-solid fa-star"></i>
                            </div>
                            @if($roomType->amenities)
                            <div class="room-card-meta">
                                @foreach(array_slice($roomType->amenities, 0, 3) as $amenity)
                                <span>
                                    {{ $amenity }}
                                </span>
                                @endforeach
                                @if(count($roomType->amenities) > 3)
                                    <span class="text-muted">+{{ count($roomType->amenities) - 3 }} more</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Booking Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Booking Details</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                            @csrf
                            <input type="hidden" name="room_type_id" id="selectedRoomType"
                                value="{{ $selectedRoom->id ?? '' }}">

                            <div class="row font-serif">
                                <!-- Guest Information -->
                                <div class="col-12">
                                    <h5 class="mb-3">Guest Information</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guest_name" class="form-label">Full Name *</label>
                                    <input type="text" name="guest_name" id="guest_name" class="form-control"
                                        value="{{ old('guest_name') }}" required>
                                    @error('guest_name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guest_email" class="form-label">Email Address *</label>
                                    <input type="email" name="guest_email" id="guest_email" class="form-control"
                                        value="{{ old('guest_email') }}" required>
                                    @error('guest_email')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guest_phone" class="form-label">Phone Number *</label>
                                    <input type="tel" name="guest_phone" id="guest_phone" class="form-control"
                                        value="{{ old('guest_phone') }}" required>
                                    @error('guest_phone')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guest_address" class="form-label">Address 1*</label>
                                    <input type="text" name="guest_address" id="guest_address" class="form-control"
                                        value="{{ old('guest_address') }}" required>
                                    @error('guest_address')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="guest_address_2" class="form-label">Address 2</label>
                                    <input type="text" name="guest_address_2" id="guest_address_2" class="form-control"
                                        value="{{ old('guest_address_2') }}">
                                    @error('guest_address_2')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <!-- Stay Details -->
                                <div class="col-12 mt-4">
                                    <h5 class="mb-3">Stay Details</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="check_in_date" class="form-label">Check-in Date *</label>
                                    <input type="date" name="check_in_date" id="check_in_date" class="form-control"
                                        value="{{ old('check_in_date', $bookingData['check_in']) }}"
                                        min="{{ date('Y-m-d') }}" required readonly>
                                    @error('check_in_date')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="check_out_date" class="form-label">Check-out Date *</label>
                                    <input type="date" name="check_out_date" id="check_out_date" class="form-control"
                                        value="{{ old('check_out_date', $bookingData['check_out']) }}" required readonly>
                                    @error('check_out_date')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="adults" class="form-label">Adults *</label>
                                    <select name="adults" id="adults" class="form-select" required readonly>
                                        <option value="">Select Adults</option>
                                        @for($i = 1; $i <= 4; $i++) <option value="{{ $i }}" {{ (old('adults',
                                            $bookingData['adults'])==$i) ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                    @error('adults')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="children" class="form-label">Children</label>
                                    <select name="children" id="children" class="form-select" readonly>
                                        @for($i = 0; $i <= 3; $i++) <option value="{{ $i }}" {{ (old('children',
                                            $bookingData['children'])==$i) ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                    </select>
                                    @error('children')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="special_requests" class="form-label">Special Requests</label>
                                    <textarea name="special_requests" id="special_requests" class="form-control"
                                        rows="3"
                                        placeholder="Any special requests or requirements...">{{ old('special_requests') }}</textarea>
                                    @error('special_requests')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            <!-- Booking Summary -->
                            <div class="row mt-4" id="bookingSummary" style="display: none;">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h5>Booking Summary</h5>
                                        <p id="summaryText"></p>
                                        <h4 id="totalAmount"></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                    <i class="fas fa-calendar-check me-2"></i>Book Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let selectedRoom = null;
const roomTypes = @json($roomTypes);

function selectRoom(roomId) {
  // Remove previous selection
  document.querySelectorAll('.room-card').forEach(card => {
    card.classList.remove('selected');
  });
  
  // Add selection to clicked room
  const selectedCard = document.querySelector(`[data-room-id="${roomId}"]`);
  selectedCard.classList.add('selected');
  
  // Set the hidden input value
  document.getElementById('selectedRoomType').value = roomId;
  
  // Store selected room data
  selectedRoom = roomTypes.find(room => room.id === roomId);
  
  // Enable form submission
  updateBookingSummary();
  document.getElementById('submitBtn').disabled = false;
}

function updateBookingSummary() {
  if (!selectedRoom) return;
  
  const checkIn = document.getElementById('check_in_date').value;
  const checkOut = document.getElementById('check_out_date').value;
  
  if (checkIn && checkOut) {
    const checkInDate = new Date(checkIn);
    const checkOutDate = new Date(checkOut);
    const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
    
    if (nights > 0) {
      const total = selectedRoom.price_per_night * nights;
      
      document.getElementById('summaryText').innerHTML = `
        <strong>${selectedRoom.name}</strong><br>
        Check-in: ${checkInDate.toLocaleDateString()}<br>
        Check-out: ${checkOutDate.toLocaleDateString()}<br>
        Nights: ${nights}<br>
        Rate: Rs ${selectedRoom.price_per_night.toLocaleString()} per night
      `;
      
      document.getElementById('totalAmount').innerHTML = `Total: Rs ${total.toLocaleString()}`;
      document.getElementById('bookingSummary').style.display = 'block';
    }
  }
}

// Add event listeners
document.getElementById('check_in_date').addEventListener('change', function() {
  // Set minimum check-out date to day after check-in
  const checkIn = new Date(this.value);
  checkIn.setDate(checkIn.getDate() + 1);
  document.getElementById('check_out_date').min = checkIn.toISOString().split('T')[0];
  updateBookingSummary();
});

document.getElementById('check_out_date').addEventListener('change', updateBookingSummary);

// Auto-select room if passed from URL
@if($selectedRoom)
  selectRoom({{ $selectedRoom->id }});
@endif

// Initialize form with URL parameters if available
document.addEventListener('DOMContentLoaded', function() {
  // Update summary on page load if dates are pre-filled
  updateBookingSummary();
  
  // If room is already selected and dates are filled, enable submit button
  const roomSelected = document.getElementById('selectedRoomType').value;
  const checkIn = document.getElementById('check_in_date').value;
  const checkOut = document.getElementById('check_out_date').value;
  
  if (roomSelected && checkIn && checkOut) {
    document.getElementById('submitBtn').disabled = false;
  }
});
</script>

@endsection