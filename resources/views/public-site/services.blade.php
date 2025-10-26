@extends('layouts.public-site')

@section('content')

<style>
  .form-item label {
    color: white !important;
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
        <h1 class="breadcumb-title">King's Castle rooms & suits</h1>
        <ul class="breadcumb-menu">
          <li><a href="/">Home</a></li>
          <li>King's Castle rooms & suits</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<section class="overflow-hidden space">
  <div class="container">
    <div class="row gy-4">
      @foreach($roomTypes as $roomType)
      <div class="col-lg-6">
        <div
          class="room-box">
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
  </div>
</section>
<div style="height: 60px;"></div>
<!--form-->
<div class="booking-area2 position-relative bg-fixed" data-bg-src="assets/img/drive-images-2-webp/kc3.webp">
  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-xl-5">
        <div class="me-xl-4 pe-xl-3 space">
          <form action="{{ route('booking.check-availability') }}" method="POST" class="booking-form2 style3"
            id="availabilityForm">
            <div class="hero-wrap">
              <div class="title-area mb-40">
                <span class="sub-title2 style1 mb-15">ROOMS RESERVATION</span>
                <h2 class="sec-title text-white">Check availablility</h2>
              </div>
              <div class="row gx-24 align-items-center justify-content-between">
                @csrf
                <div class="form-group col-12">
                  <div class="form-item">
                    <label>Check In</label>
                    <input type="date" class="form-control" name="check_in" id="check_in" min="{{ date('Y-m-d') }}"
                      required />
                    <i class="fa-solid fa-calendar-days"></i>
                  </div>
                </div>
                <div class="form-group col-12">
                  <div class="form-item">
                    <label>CHECK - OUT</label>
                    <input type="date" class="form-control" name="check_out" id="check_out" required />
                    <i class="fa-solid fa-calendar-days"></i>
                  </div>
                </div>
                <div class="col-12 form-group">
                  <div class="form-item">
                    <label>ADULTS</label>
                    <select name="adults" id="adults" class="form-select nice-select" required>
                      <option value="1">Adult 01</option>
                      <option value="2">Adult 02</option>
                      <option value="3">Adult 03</option>
                      <option value="4">Adult 04</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 form-group">
                  <div class="form-item">
                    <label>Children</label>
                    <select name="children" id="children" class="form-select nice-select">
                      <option value="0">Children 0</option>
                      <option value="1">Children 1</option>
                      <option value="2">Children 2</option>
                      <option value="3">Children 3</option>
                    </select>
                  </div>
                </div>
                <div class="btn-form">
                  <button type="submit" class="th-btn style1">
                    CHECK AVAILABILITY
                  </button>
                </div>
              </div>
              <p class="form-messages mb-0 mt-3"></p>
            </div>
          </form>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="ps-xl-5 space-extra2-bottom">
          <div class="title-area mb-45 pe-xxl-5">
            <span class="sub-title2 text-white style1">BOOKING ROOM</span>
            <h2 class="sec-title text-white">
              Excellence In Every Moment Of Your Stay
            </h2>
          </div>
          <div class="awards">
            <img src="assets/img/normal/awards.png" alt="" />
          </div>
          <div class="call-info">
            <div class="call-icon">
              <a href="tel:+94771200180"><img src="assets/img/icon/call-icon2.svg" alt="" /></a>
            </div>
            <div class="media-body">
              <span class="call-label text-white">Booking Now</span>
              <p class="call-link text-white">
                <a href="tel:+94767799721">+94 76 779 9721</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3">
        <div class="booking-img">
          <img src="assets/img/normal/booking-img.png" alt="" />
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('check_in').addEventListener('change', function() {
  const checkIn = new Date(this.value);
  checkIn.setDate(checkIn.getDate() + 1);
  document.getElementById('check_out').min = checkIn.toISOString().split('T')[0];
});

document.getElementById('availabilityForm').addEventListener('submit', function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn.innerHTML;
  
  submitBtn.innerHTML = 'Checking...';
  submitBtn.disabled = true;
  
  fetch(this.action, {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.available_rooms && data.available_rooms.length > 0) {
      // Redirect to booking form with dates
      const params = new URLSearchParams({
        check_in: data.check_in,
        check_out: data.check_out,
        adults: formData.get('adults'),
        children: formData.get('children')
      });
      window.location.href = `/book-room?${params.toString()}`;
    } else {
      alert('No rooms available for the selected dates. Please try different dates.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error checking availability. Please try again.');
  })
  .finally(() => {
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  });
});
</script>

@endsection