@extends('layouts.public-site')

@section('content')

<!--breadcrumb-->
<div class="breadcumb-banner">
  <div class="breadcumb-wrapper" data-bg-src="/assets/img/drive-images-2-webp/kc5.webp">
    <div
      style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
    </div>
    <div class="container" style="position: relative; z-index: 10;">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">{{ $roomType->name }}</h1>
        <ul class="breadcumb-menu">
          <li><a href="/">Home</a></li>
          <li><a href="/services">Rooms</a></li>
          <li>{{ $roomType->name }}</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!--double details-->
<section class="room-area space-top space-extra-bottom overflow-hidden">
  <div class="container">
    <div class="row flex-row-reverse">
      <div class="col-xl-9 col-lg-8">
        <div class="room-page-single">
          <div class="main-container">
            <div class="swiper th-slider panoramaSlide1" id="panoramaSlide1"
              data-slider-options='{"autoplay": true, "loop": true, "speed": 1000, "allowTouchMove": false, "simulateTouch": false, "thumbs":{"swiper":".room-thumb-slider"}}'>
              <div class="swiper-wrapper">
                <!--main image-->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama0">
                    <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" class="w-100" />
                  </div>
                </div>
                <!--secondary images-->
                @if($roomType->roomImages && $roomType->roomImages->count() > 0)
                @foreach($roomType->roomImages as $image)
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama{{ $loop->iteration }}">
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" class="w-100" />
                  </div>
                </div>
                @endforeach
                @else
                <!-- Fallback image if no images available -->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama1">
                    <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" class="w-100" />
                  </div>
                </div>
                @endif
              </div>
              <div class="slider-prev">Prev</div>
              <div class="slider-next">Next</div>
            </div>
            <div class="swiper th-slider room-thumb-slider" id="panoramaSlide2"
              data-slider-options='{"effect":"slide","spaceBetween":3,"loop":true,"breakpoints":{"0":{"slidesPerView":3},"576":{"slidesPerView":3},"768":{"slidesPerView":3},"992":{"slidesPerView":3},"1200":{"slidesPerView":5}}}'>
              <div class="swiper-wrapper">
                <!--main image-->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" class="w-100" />
                  </div>
                </div>
                <!--secondary images-->
                @if($roomType->roomImages)
                @foreach($roomType->roomImages as $image)
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->alt_text }}" class="w-100" />
                  </div>
                </div>
                @endforeach
                @else
                <!-- Fallback thumbnail if no images available -->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" class="w-100" />
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-30">
              <h2 class="box-title mt-50 mb-0">About The {{ $roomType->name }}</h2>
              <span class="badge fs-14 {{ $roomType->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $roomType->is_active ? 'Available for Booking' : 'Currently Unavailable' }}
              </span>
            </div>
            <p class="box-text fs-18 mb-50">
              {{ $roomType->description }}
            </p>

            <div class="row mb-50">
              <div class="col-md-6">
                <h3 class="box-title mb-20">Room Details</h3>
                <ul class="list-unstyled">
                  <li><strong>Room Type:</strong> {{ $roomType->name }}</li>
                  <li><strong>Max Occupancy:</strong> {{ $roomType->max_occupancy }} {{ $roomType->max_occupancy == 1 ?
                    'Guest' : 'Guests' }}</li>
                  <li><strong>Price per Night:</strong> <span class="text-theme">{{ $roomType->formatted_price }}</span>
                  </li>
                </ul>
              </div>
              <div class="col-md-6">
                @if($roomType->amenities && count($roomType->amenities) > 0)
                <h3 class="box-title mb-20">Room Amenities</h3>
                <div class="room-checklist">
                  <div class="checklist style2">
                    <ul>
                      @foreach($roomType->amenities as $amenity)
                      @if(!empty(trim($amenity)))
                      <li style="color: black !important;">{{ $amenity }}</li>
                      @endif
                      @endforeach
                    </ul>
                  </div>
                </div>
                @endif
              </div>
            </div>

            @if($roomType->roomImages->count() > 0)
            <div class="mb-50">
              <h3 class="box-title mb-20">Gallery</h3>
              <p class="box-text">This room features {{ $roomType->roomImages->count() }} additional {{
                $roomType->roomImages->count() == 1 ? 'image' : 'images' }} in our gallery above, showcasing different
                angles and details of the room.</p>
            </div>
            @endif

            <h2 class="box-title mb-20">Hotel Amenities</h2>
            <ul class="hotel-grid-list">
              <li>
                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-1.svg" alt="img" /></div>
                <div class="hotel-grid-list-details">
                  <p class="box-text">Swimming Pool</p>
                </div>
              </li>
              <li>
                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-2.svg" alt="img" /></div>
                <div class="hotel-grid-list-details">
                  <p class="box-text">Free Breakfast</p>
                </div>
              </li>
              <li>
                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-5.svg" alt="img" /></div>
                <div class="hotel-grid-list-details">
                  <p class="box-text">Free High Speed WiFi</p>
                </div>
              </li>
              <li>
                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-7.svg" alt="img" /></div>
                <div class="hotel-grid-list-details">
                  <p class="box-text">Well Furnished Rooms</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--left side-->
      <div class="col-xl-3 col-lg-4">
        <aside class="sidebar-area">
          <div class="widget widget_quote">
            <form action="{{ route('booking.create') }}" method="GET" class="booking-form2 style4">
              <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
              <div class="input-wrap">
                <div class="title-area mb-40">
                  <span class="sub-title2 style1 mb-15">RESERVATION</span>
                  <h2 class="box-title text-white">{{ $roomType->name }}</h2>
                  <p class="text-white mb-0">{{ $roomType->formatted_price }} per night</p>
                  <p class="text-white small mb-0">Max {{ $roomType->max_occupancy }} {{ $roomType->max_occupancy == 1 ?
                    'guest' : 'guests' }}</p>
                </div>
                <div class="row gx-24 align-items-center justify-content-between">
                  <div class="form-group col-12">
                    <div class="form-item">
                      <label class="text-white">Check In</label>
                      <input type="date" class="form-control" name="check_in" id="check_in"
                        value="{{ old('check_in', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d') }}" />
                      <i class="fa-solid fa-calendar-days"></i>
                    </div>
                  </div>
                  <div class="form-group col-12">
                    <div class="form-item">
                      <label class="text-white">CHECK - OUT</label>
                      <input type="date" class="form-control" name="check_out" id="check_out"
                        value="{{ old('check_out', date('Y-m-d', strtotime('+2 days'))) }}"
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                      <i class="fa-solid fa-calendar-days"></i>
                    </div>
                  </div>
                  <div class="col-12 form-group">
                    <div class="form-item">
                      <label class="text-white">ADULT</label>
                      <select name="adults" id="adults" class="form-select nice-select">
                        <option value="" selected="selected" disabled="disabled">
                          Select Adults
                        </option>
                        @for($i = 1; $i <= $roomType->max_occupancy; $i++)
                          <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Adult' : 'Adults' }}</option>
                          @endfor
                      </select>
                    </div>
                  </div>
                  <div class="col-12 form-group">
                    <div class="form-item">
                      <label class="text-white">Children</label>
                      <select name="children" id="children" class="form-select nice-select">
                        <option value="0" selected="selected">
                          No Children
                        </option>
                        @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Child' : 'Children'
                          }}</option>
                          @endfor
                      </select>
                    </div>
                  </div>
                  <div class="col-12 form-group">
                    <button type="submit" class="th-btn w-100" {{ !$roomType->is_active ? 'disabled' : '' }}>
                      {{ $roomType->is_active ? 'Check Availability' : 'Currently Unavailable' }}
                    </button>
                  </div>
                </div>
                <p class="form-messages mb-0 mt-3"></p>
              </div>
            </form>
          </div>
        </aside>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    // Update check-out minimum date when check-in changes
    checkInInput.addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        const nextDay = new Date(checkInDate);
        nextDay.setDate(checkInDate.getDate() + 1);
        
        const minCheckOut = nextDay.toISOString().split('T')[0];
        checkOutInput.setAttribute('min', minCheckOut);
        
        // If current check-out is before new minimum, update it
        if (checkOutInput.value && checkOutInput.value <= this.value) {
            checkOutInput.value = minCheckOut;
        }
    });
    
    // Validate that check-out is after check-in
    checkOutInput.addEventListener('change', function() {
        if (checkInInput.value && this.value <= checkInInput.value) {
            alert('Check-out date must be after check-in date');
            this.value = '';
        }
    });
});
</script>
@endpush