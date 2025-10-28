@props(['roomTypes', 'title' => 'Featured rooms & suits', 'subtitle' => 'LUXURY COMFORT'])

<!--room types cards-->
<section class="overflow-hidden space" style="padding-bottom: 0px;">
  <div class="container">
    <div class="title-area text-center">
      <span class="sub-title2 style1">{{ $subtitle }}</span>
      <h2 class="sec-title">{{ $title }}</h2>
    </div>
    <div class="row gy-4">
      @if($roomTypes && $roomTypes->count() > 0)
        @foreach($roomTypes as $roomType)
        <div class="col-lg-6">
          <div class="room-box">
            <div class="box-img">
              <img src="{{ asset($roomType->image_path) }}" alt="{{ $roomType->name }}" style="height: 100%;" />
            </div>
            <span class="discount">{{ $roomType->formatted_price }} per night</span>
            <div class="box-title-area">
              <div class="box-number">{{ $roomType->id }}</div>
              <h3 class="box-title">
                <a href="{{ route('room-details', $roomType->id) }}">{{ $roomType->name }}</a>
              </h3>
            </div>
            <div class="box-content">
              <div class="box-wrapp">
                <div class="box-number">{{ $roomType->id }}</div>
                <h3 class="box-title">
                  <a href="{{ route('room-details', $roomType->id) }}">{{ $roomType->name }}</a>
                </h3>
                <div class="box-review mb-3 text-white">
                  <i class="fa-sharp fa-solid fa-star"></i>
                  <i class="fa-sharp fa-solid fa-star"></i>
                  <i class="fa-sharp fa-solid fa-star"></i>
                  <i class="fa-sharp fa-solid fa-star"></i>
                  <i class="fa-sharp fa-solid fa-star"></i>
                </div>
                @if($roomType->amenities && count($roomType->amenities) > 0)
                <div class="room-card-meta m-0 mb-2">
                  @foreach(array_slice($roomType->amenities, 0, 3) as $amenity)
                  <span>{{ $amenity }}</span>
                  @endforeach
                  @if(count($roomType->amenities) > 3)
                  <span class="text-muted">+{{ count($roomType->amenities) - 3 }} more</span>
                  @endif
                </div>
                @endif
                <p class="room-card-text text-white">{{ Str::limit($roomType->description, 120) }}</p>
                <div class="room-card-info">
                  <span class="me-2 text-white"><i class="fas fa-users"></i> Max {{ $roomType->max_occupancy }} {{ $roomType->max_occupancy == 1 ? 'Guest' : 'Guests' }}</span>
                  @if($roomType->is_active)
                    <span class="text-success"><i class="fas fa-check-circle"></i> Available</span>
                  @else
                    <span class="text-danger"><i class="fas fa-times-circle"></i> Not Available</span>
                  @endif
                </div>
                <div class="box-btn mt-30">
                  <a href="{{ route('room-details', $roomType->id) }}" class="th-btn">View Details</a>
                  {{-- @if($roomType->is_active)
                    <a href="{{ route('booking.create', ['room_type_id' => $roomType->id]) }}" class="th-btn style4 ms-2">Book Now</a>
                  @endif --}}
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      @else
        <div class="col-12">
          <div class="text-center py-5">
            <h4>No rooms available at the moment</h4>
            <p class="text-muted">Please check back later or contact us for more information.</p>
          </div>
        </div>
      @endif
    </div>
  </div>
</section>
