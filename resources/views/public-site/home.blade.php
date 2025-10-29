@extends('layouts.public-site')

@section('content')

<!--hero-->
<div class="th-hero-wrapper hero-1">
  <div class="heroSlide1-area">
    <div class="swiper th-slider heroSlide1" id="heroSlide1"
      data-slider-options='{"effect":"fade","loog":false, "speed": 2000,"thumbs":{"swiper":".hero-grid-thumb"}}'>
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="hero-inner">
            <div class="th-hero-bg" data-bg-src="assets/img/drive-images-2-webp/kc2.webp"></div>
            <div class="container">
              <div class="hero-style1">
                <div class="hero-logo" data-ani="slideinup" data-ani-delay="0.2s">
                  <img src="assets/img/logo.png" alt="" style="width: 100px;" />
                </div>
                <span class="hero-subtitle" data-ani="slideinup" data-ani-delay="0.3s">Best prices guaranteed</span>
                <div class="hero-review-wrapp" data-ani="slideinup" data-ani-delay="0.4s">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <span class="title">128k+ Reviews</span>
                </div>
                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.6s">
                  Stay in Our Luxury Hotels & Rooms
                </h1>
                <div class="btn-group justify-content-lg-start justify-content-center" data-ani="slideinup"
                  data-ani-delay="0.8s">
                  <a href="#" class="th-btn2 style3">BROWSE ROOMS <img src="assets/img/icon/bed.svg" alt="" /></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="hero-inner">
            <div class="th-hero-bg" data-bg-src="assets/img/drive-images-2-webp/kc3.webp"></div>
            <div class="container">
              <div class="hero-style1">
                <div class="hero-logo" data-ani="slideinup" data-ani-delay="0.2s">
                  <img src="assets/img/logo.png" alt="" style="width: 100px;" />
                </div>
                <span class="hero-subtitle" data-ani="slideinup" data-ani-delay="0.3s">Best prices guaranteed</span>
                <div class="hero-review-wrapp" data-ani="slideinup" data-ani-delay="0.4s">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <span class="title">128k+ Reviews</span>
                </div>
                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.6s">
                  Luxury Rooms for Discerning Travelers
                </h1>
                <div class="btn-group justify-content-lg-start justify-content-center" data-ani="slideinup"
                  data-ani-delay="0.8s">
                  <a href="#" class="th-btn2 style3">BROWSE ROOMS <img src="assets/img/icon/bed.svg" alt="" /></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="hero-inner">
            <div class="th-hero-bg" data-bg-src="{{ asset('assets/img/drive-images-2-webp/kc21.webp') }}"></div>
            <div class="container">
              <div class="hero-style1">
                <div class="hero-logo" data-ani="slideinup" data-ani-delay="0.2s">
                  <img src="assets/img/logo.png" alt="" style="width: 100px;" />
                </div>
                <span class="hero-subtitle" data-ani="slideinup" data-ani-delay="0.3s">Best prices guaranteed</span>
                <div class="hero-review-wrapp" data-ani="slideinup" data-ani-delay="0.4s">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <span class="title">128k+ Reviews</span>
                </div>
                <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.6s">
                  Timeless Elegance Luxury Hotels & Rooms
                </h1>
                <div class="btn-group justify-content-lg-start justify-content-center" data-ani="slideinup"
                  data-ani-delay="0.8s">
                  <a href="#" class="th-btn2 style3">BROWSE ROOMS <img src="assets/img/icon/bed.svg" alt="" /></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-area hero-slider-thumb-wrap">
      <div class="swiper th-slider hero-grid-thumb"
        data-slider-options='{"effect":"slide","loog":false,"slidesPerView":"3"}'>
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="box-img">
              <img src="assets/img/drive-images-2-webp/kc2.webp" alt="Image" />
              <span class="slider-number">01</span>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="box-img">
              <img src="assets/img/drive-images-2-webp/kc3.webp" alt="Image" />
              <span class="slider-number">02</span>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="box-img">
              <img src="{{ asset('assets/img/drive-images-2-webp/kc21.webp') }}" alt="Image" />
              <span class="slider-number">03</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--booking area (added from home-2.html)-->
<div class="booking-area" style="z-index: 50; margin-top: 30px; margin-bottom: 30px;">
  <div class="container">
    <form action="{{ route('booking.check-availability') }}" method="POST" class="booking-form ajax-contact" id="availabilityForm">
      @csrf
      <div class="hero-wrap">
        <div class="form-group">
          <label class="text-white">Check-in Date</label>
          <input type="date" class="form-control" name="check_in" id="check_in" min="{{ date('Y-m-d') }}" value="2025-02-23">
        </div>
        <div class="form-group">
          <label class="text-white">Check-out Date</label>
          <input type="date" class="form-control" name="check_out" id="check_out" value="2025-02-23">
        </div>
        <div class="form-group has-label">
          <label class="text-white">Adults</label>
          <select name="adults" id="adults" class="form-select">
            <option value="" disabled="disabled" selected="selected" hidden="">
              No of Adults guests
            </option>
            <option value="1">1 Adult Only</option>
            <option value="2">2 Adults</option>
            <option value="3">3 Adults</option>
            <option value="4">4 Adults</option>
          </select>
          <i class="fa-light fa-users text-white"></i>
        </div>
        <div class="form-group has-label">
          <label class="text-white">Children</label>
          <select name="children" id="children" class="form-select">
            <option value="" disabled="disabled" selected="selected" hidden="">
              No of Child guests
            </option>
            <option value="1">1 Child Only</option>
            <option value="2">2 Children</option>
          </select>
          <i class="fa-light fa-users text-white"></i>
        </div>
        <div class="form-btn">
          <button type="submit" class="th-btn btn-fw style1">
            CHECK AVAILABILITY
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
<!--main about-->
<div class="about-shape overflow-hidden bg-shape" id="about-sec">
  <div class="container">
    <div class="row gy-40 align-items-center">
      <div class="col-lg-6 col-xxl-4">
        <div class="title-area mb-30 pe-xxl-5">
          <img src="assets/img/logo.png" style="width: 250px;" alt="shape" />
          <h2 class="sec-title">About King Castle</h2>
          <img src="assets/img/theme-img/title_icon2.svg" alt="shape" />
          <p class="text-body fs-18 mt-25 mb-40">
            Planning a holiday escape to an ideal destination along with breathtaking nature setup? Looking for a
            family adventure featured with outdoor pool and much other facilities? Thinking of refreshing the taste
            buds with mouthwatering authentic local delicacies? Want to explore and visit the world’s most epic and
            renowned cultural pinnacle of all the time, Sri Lanka?
          </p>
          <p class="text-body fs-18 mb-60">
            That’s exactly why you should make a choice of staying at King Castle five star boutique resort.
          </p>
        </div>
        <!--counter-->
        <div class="counter-card-wrap">
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">10</span>+
              </h2>
              <p class="box-text">Luxury Rooms</p>
            </div>
          </div>
          <div class="divider"></div>
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">20</span>+
              </h2>
              <p class="box-text">Staffs</p>
            </div>
          </div>
          <div class="divider"></div>
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">50</span>+
              </h2>
              <p class="box-text">Menus</p>
            </div>
          </div>
          <div class="divider"></div>
        </div>
        <div class="btn-group mt-60">
          <a href="#" class="th-btn2 th-icon">LEARN MORE</a>
        </div>
      </div>
      <div class="col-lg-6 col-xxl-4">
        <div class="img-box1">
          <div class="img1">
            <img src="assets/img/drive-images-2-webp/kc28-se.jpg" alt="About"
              style="height: 700px;aspect-ratio: 9/16; object-fit: cover;" />
          </div>
          <div class="about-wrapp">
            <div class="curve-text">
              <div class="circle-text" data-text="* welcome to King Castle hotel* welcome to King Castle hotel*">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-xxl-4 text-center text-xl-start">
        <div class="about-feature-wrap">
          <div class="about-feature">
            <div class="box-icon">
              <div class="color-masking">
                <div class="masking-src" data-mask-src="assets/img/icon/about_feature_1.svg"></div>
                <img src="assets/img/icon/about_feature_1.svg" alt="Icon" />
              </div>
            </div>
            <div class="box-content">
              <h3 class="box-title">Serenity and bliss</h3>
              <p class="box-text">Your comfort zone away from home</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="box-icon">
              <div class="color-masking">
                <div class="masking-src" data-mask-src="assets/img/icon/about_feature_2.svg"></div>
                <img src="assets/img/icon/about_feature_2.svg" alt="Icon" />
              </div>
            </div>
            <div class="box-content">
              <h3 class="box-title">Store Luggage</h3>
              <p class="box-text">Hospitality Meets Home</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="box-icon">
              <div class="color-masking">
                <div class="masking-src" data-mask-src="assets/img/icon/about_feature_3.svg"></div>
                <img src="assets/img/icon/about_feature_3.svg" alt="Icon" />
              </div>
            </div>
            <div class="box-content">
              <h3 class="box-title">Room Services</h3>
              <p class="box-text">Hospitality meets home</p>
            </div>
          </div>
          <div class="about-feature">
            <div class="box-icon">
              <div class="color-masking">
                <div class="masking-src" data-mask-src="assets/img/icon/about_feature_4.svg"></div>
                <img src="assets/img/icon/about_feature_4.svg" alt="Icon" />
              </div>
            </div>
            <div class="box-content">
              <h3 class="box-title">Pick up & Drop</h3>
              <p class="box-text">Experience elegance stay distinctive</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--rooms section-->
<section class="overflow-hidden bg-shape space-top">
  <div class="container">
    <div class="row gx-0 justify-content-center">
      <div class="col-xxl-6 align-self-center">
        <div class="title-area pe-xl-5 me-xl-5">
          <span class="sub-title">ROOMS & SUITS</span>
          <h2 class="sec-title">
            Experience Top-Notch Best<span>
              On Hospitality At Our Hotels</span>
          </h2>
          <img src="assets/img/theme-img/title_icon.svg" alt="Icon" />
        </div>
      </div>

      @foreach($roomTypes as $roomType)
      <div class="col-xxl-6 room-card_wrapp">
        <div class="room-card style-flex">
          <div class="box-content">
            <div class="box-number text-white">
              {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
            </div>
            <h3 class="box-title"><a href="#">{{ $roomType->name }}</a></h3>

            <!-- Alternate star style for odd/even cards -->
            <div class="box-review text-white">
              <i class="fa-sharp fa-solid fa-star"></i>
              <i class="fa-sharp fa-solid fa-star"></i>
              <i class="fa-sharp fa-solid fa-star"></i>
              <i class="fa-sharp fa-solid fa-star"></i>
              <i class="fa-sharp fa-solid fa-star"></i>
            </div>

            <p class="box-text">
              We have the best rooms starting from {{ $roomType->formatted_price }} per night
              with King size bed.
            </p>

            @if($roomType->amenities)
              <div class="room-card-meta">
                @foreach(array_slice($roomType->amenities, 0, 2) as $amenity)
                <span>
                  <small>
                  {{ $amenity }}
                  </small>
                </span>
                @endforeach
                @if(count($roomType->amenities) > 2)
                <small class="text-white">+{{ count($roomType->amenities) - 2 }} more</small>
                @endif
              </div>
              @endif

            <div>
              <!-- Alternate button style for odd/even -->
              <a href="{{ route('room-details', $roomType->id) }}"
                 class="th-btn2 border">
                VIEW DETAILS
              </a>
            </div>
          </div>

          <div class="box-img global-img">
            <img src="{{ asset($roomType->image_path ?? 'assets/img/drive-images-2-webp/default.webp') }}"
                 alt="{{ $roomType->name }}"
                 style="aspect-ratio: 1/1; height: 468px;" />
            <span class="discount">{{ $roomType->formatted_price }} per night</span>
          </div>
        </div>
      </div>
      @endforeach

      <div class="col-xxl-6 align-self-center">
        <div class="room-btn text-center">
          <a href="/services" class="th-btn th-icon">EXPLORE ALL</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!--3 cards-->
<section class="space-top overflow-hidden bg-shape">
  <div class="container">
    <div class="row gy-4 justify-content-center">
      <div class="col-lg-6 col-xl-4">
        <div class="feature-card">
          <div class="feature-shape" data-bg-src="assets/img/shape/feature-shape.png"></div>
          <div class="box-icon">
            <img src="assets/img/icon/feature_card_1.svg" alt="Icon" />
          </div>
          <h3 class="box-title">
            <a href="#">Keeping your safe</a>
          </h3>
          <p class="box-text">
            The wellbeing of our guests and staff is of paramount
            importance. Our Covid-19 strategy includes deep cleaning rooms
            between guests and leaving rooms vacant for at least 24 hours
            for safety
          </p>
          <a href="/services" class="th-btn2 style3">BOOK NOW</a>
        </div>
      </div>
      <div class="col-lg-6 col-xl-4">
        <div class="feature-card">
          <div class="feature-shape" data-bg-src="assets/img/shape/feature-shape.png"></div>
          <div class="box-icon">
            <img src="assets/img/icon/feature_card_2.svg" alt="Icon" />
          </div>
          <h3 class="box-title">
            <a href="#">Cancellation within 24H</a>
          </h3>
          <p class="box-text">
            We understand that sometimes things do not go to plan. You can
            book your stay with confidence with our 24 hour cancellation
            policy. Cancellations are available on bookings up to 24 hours
          </p>
          <a href="/services" class="th-btn2 style3">BOOK NOW</a>
        </div>
      </div>
      <div class="col-lg-6 col-xl-4">
        <div class="feature-card">
          <div class="feature-shape" data-bg-src="assets/img/shape/feature-shape.png"></div>
          <div class="box-icon">
            <img src="assets/img/icon/feature_card_3.svg" alt="Icon" />
          </div>
          <h3 class="box-title">
            <a href="#">full room amenities</a>
          </h3>
          <p class="box-text">
            Our rooms are designed to give you maximum comfort and
            independence. You’ll find a microwave, fridge freezer, kettle
            and teas and coffees in every room.
          </p>
          <a href="/services" class="th-btn2 style3">BOOK NOW</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--brand slider-->
<div class="space bg-shape">
  <div class="container">
    <h2 class="sec-title" style="text-align: center;">Travel Platforms</h2>
    <div class="slider-area text-center">
      <div class="swiper th-slider" id="brandSlider1"
        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"476":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"4"},"1400":{"slidesPerView":"6"}}}'>
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/booking.svg" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/trip-advisior-new.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/agoda.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="brand-item">
              <a href="#"><img class="original" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" />
                <img class="gray" src="assets/img/travel-plat/expedia.png" alt="Brand Logo"
                  style="height: 100%; width: 100%; object-fit: contain;" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--word from manager-->
<div class="about-area2 overflow-hidden">
  <div class="shape-mockup d-none d-xxl-block" data-top="0%" data-right="0%">
    <img src="assets/img/shape/pattern-shape.png" alt="shape" />
  </div>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-xl-5 mb-35 mb-xl-0">
        <div class="img-box2">
          <div class="img1 th-parallax">
            {{-- <img src="assets/img/places/nuwa-eliya.webp" alt="Image" /> --}}
          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="ps-xl-5 space-extra2">
          <div class="title-area mb-37">
            {{-- <span class="sub-title">MANAGER</span --}}
            <h2 class="sec-title text-white">
              King Castle Lake Front by LAKSAM <span> Nuwara Eliya</span>
            </h2>
            <img src="assets/img/theme-img/title_icon2.svg" alt="shape" />
          </div>
          <p class="fs-18 text-white">
            King Castle Lake Front by LAKSAM is a modern, upscale hospitality company that
            is passionate about ‘making moments’, recognising that small
            gestures make a big difference to our guests, our owners and our
            people. We do ordinary things in an extraordinary way – a
            philosophy that has defined our brand’s success from the very
            start.
          </p>
          <p class="fs-18 text-white">
            We are delighted to welcome thousands of satisfied guests annually. Nestled in the misty highlands at an
            elevation of over 6,000 feet, our property offers unobstructed views of the rolling tea plantations and
            mountain landscapes. You can enjoy the refreshing cool climate and breathtaking scenery right from the
            comfort of your room.
          </p>
          <div class="btn-group about-btn justify-content-start">
            <a href="#" class="th-btn2 extra-btn">EXPLORE MORE</a>
            <div class="about-profile">
              <div class="avater">
                <img src="assets/img/normal/about_avater.jpg" alt="avater" />
              </div>
              <div>
                <div class="signature">
                  <img src="assets/img/normal/signature.svg" alt="signature" />
                </div>
                <span class="text">Dr Saman Edirisinghe - Chairmen</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--best offers-->
<section class="space-top overflow-hidden bg-shape">
  <div class="container">
    <div class="title-area text-center">
      <span class="sub-title">EXPLORE SRI LANKA</span>
      <h2 class="sec-title">Things To Do</h2>
    </div>
    <div class="row gy-4">
      <div class="12">
        <div class="room-card style2 style-flex" data-bg-src="assets/img/shape/room-shape.png">
          <div class="box-img global-img">
            <img src="assets/img/places/gregory.webp" alt="Gregory Lake" />
          </div>
          <div class="box-content">
            <div class="box-number">01</div>
            <h3 class="box-title">
              <a href="#">Gregory Lake</a>
            </h3>
            <p class="box-text">
              Gregory Lake is a picturesque man-made lake situated in the heart of Nuwara Eliya, Sri Lanka. It was
              created during the British colonial era by Governor Sir William Gregory in 1873 as a recreational facility
              for the British residents. The lake spans over 91 acres and offers stunning panoramic views of the
              surrounding hills and landscapes. Today, it serves as a popular tourist attraction where visitors can
              enjoy boat rides, jet skiing, and swan pedal boats. The well-maintained walking paths around the lake make
              it perfect for leisurely strolls while enjoying the cool climate that Nuwara Eliya is famous for. The lake
              area has been further developed with gardens, children's playgrounds, and food stalls, making it an ideal
              destination for families.
            </p>
            <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
          </div>
        </div>
      </div>
      <div class="12">
        <div class="room-card style2 style-flex" data-bg-src="assets/img/shape/room-shape.png">
          <div class="box-img global-img">
            <img src="assets/img/places/tea-estate.webp" alt="Tea Plantations and Factories" />
          </div>
          <div class="box-content">
            <div class="box-number">02</div>
            <h3 class="box-title">
              <a href="#">Tea Plantations and Factories</a>
            </h3>
            <p class="box-text">
              Nuwara Eliya, fondly known as "Little England," provides visitors with the opportunity to explore Sri
              Lanka's renowned tea industry up close. The lush green tea estates carpeting the hillsides create a
              mesmerizing landscape unique to this region. Visitors can tour working tea factories like Pedro Tea
              Estate, Damro Tea Factory, or Mackwoods Labookellie, where they can witness the fascinating process of tea
              production from plucking to packaging. Expert guides explain the meticulous steps of withering, rolling,
              fermenting, drying, and grading the world-famous Ceylon Tea. The experience typically concludes with a tea
              tasting session where you can savor different varieties of fresh mountain tea. The best time to visit is
              early morning until around 5 pm when the factories are in full operation.
            </p>
            <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
          </div>
        </div>
      </div>
      <div class="12">
        <div class="room-card style2 style-flex" data-bg-src="assets/img/shape/room-shape.png">
          <div class="box-img global-img">
            <img src="assets/img/places/horton-plains-national.webp" alt="Horton Plains National Park" />
          </div>
          <div class="box-content">
            <div class="box-number">03</div>
            <h3 class="box-title">
              <a href="#">Horton Plains National Park</a>
            </h3>
            <p class="box-text">
              Horton Plains National Park is an astounding protected area located about 32 kilometers from Nuwara Eliya
              town. This misty grassland plateau sits at an altitude of over 2,100 meters above sea level and serves as
              a biodiversity hotspot with numerous endemic species. The park is famous for its 9-kilometer circular
              hiking trail leading to "World's End," a sheer cliff with a breathtaking 880-meter drop offering
              spectacular panoramic views of the tea estates, villages, and distant mountains. Another highlight is the
              beautiful Baker's Falls, a picturesque waterfall named after the famous explorer Samuel Baker. Wildlife
              enthusiasts can spot sambar deer, purple-faced langur monkeys, and numerous bird species. It's advisable
              to start early around 6 am, as the views are often obscured by mist after mid-morning.
            </p>
            <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
          </div>
        </div>
      </div>
      <div class="12">
        <div class="room-card style2 style-flex" data-bg-src="assets/img/shape/room-shape.png">
          <div class="box-img global-img">
            <img src="assets/img/places/victoria.webp" alt="Victoria Park" />
          </div>
          <div class="box-content">
            <div class="box-number">04</div>
            <h3 class="box-title">
              <a href="#">Victoria Park</a>
            </h3>
            <p class="box-text">
              Victoria Park, located in the center of Nuwara Eliya, is a beautifully maintained English-style garden
              that stands as a testament to the colonial heritage of the region. Initially created as a research field
              for the Hakgala Botanical Garden, it was later named to commemorate Queen Victoria's Diamond Jubilee. The
              park spans approximately 27 acres and features well-manicured lawns, colorful flower beds, exotic plants,
              and towering trees. It houses more than 80 species of plants, including rare tree ferns and roses, plus a
              variety of orchids. The park is also a haven for bird watchers, with species like Kashmir flycatcher and
              Indian pitta making seasonal appearances. Families can enjoy the children's playground, miniature train
              ride, and the serene atmosphere that makes it perfect for relaxation and photography.
            </p>
            <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
          </div>
        </div>
      </div>
      <div class="12">
        <div class="room-card style2 style-flex" data-bg-src="assets/img/shape/room-shape.png">
          <div class="box-img global-img">
            <img src="assets/img/places/Ramboda-Falls.webp" alt="Ramboda Falls & Moon Plains" />
          </div>
          <div class="box-content">
            <div class="box-number">05</div>
            <h3 class="box-title">
              <a href="#">Ramboda Falls & Moon Plains</a>
            </h3>
            <p class="box-text">
              Ramboda Falls is a magnificent waterfall located approximately 30 kilometers from Nuwara Eliya on the A5
              highway. It's one of Sri Lanka's highest waterfalls, cascading from a height of 109 meters in two distinct
              tiers through the lush tea plantation landscape. The falls create a spectacular sight especially during
              the monsoon season when water volume is at its peak. Meanwhile, Moon Plains is a recently opened tourist
              attraction that was once a sanatorium during the British era. This vast open grassland offers 360-degree
              views of the surrounding mountains including a clear view of Sri Lanka's second-highest mountain,
              Thotupola. Visitors can take jeep safaris across the plains to spot wildlife including sambar deer, wild
              boar, and numerous bird species, while enjoying the ethereal landscape that earned the area its
              lunar-inspired name.
            </p>
            <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-60 text-center">
      <a href="#" class="th-btn2 ser-btn text-white">Explore More</a>
    </div>
  </div>
</section>
<!--insta grid (image masonry grid)-->
<div class="overflow-hidden bg-shape space-top">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-xxl-4">
        <div class="title-area text-center">
          {{-- <span class="sub-title">INSTAGRAM FEED</span> --}}
          <h2 class="sec-title">Relax In The Comfort Of Our Hotel</h2>
          <div class="title-img">
            <img src="assets/img/theme-img/title_icon.svg" alt="Icon" />
          </div>
        </div>
      </div>
    </div>
    <div class="row gallery-row">
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc1.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc2.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc3.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc4.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc5.jpg" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc6.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc7.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
      <div class="col-md-6 col-xxl-3">
        <div class="gallery-insta">
          <a target="_blank" href="#" class="box-btn"><i class="fab fa-instagram hidden"></i></a>
          <img src="assets/img/drive-images-2-webp/kc8.webp" alt="Image" style="aspect-ratio: 9/16;" />
        </div>
      </div>
    </div>
  </div>
</div>
<!--feedback-->
<section class="overflow-hidden space-top bg-shape" id="testi-sec">
  <div class="container-fluid p-0">
    <div class="title-area text-center">
      <span class="sub-title">Testimonials</span>
      <h2 class="sec-title">Customer’s Feedback</h2>
      <span class="title-img"><img src="assets/img/theme-img/title_icon.svg" alt="shape" /></span>
    </div>
    <div class="slider-area">
      <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1"
        data-slider-options='{
                    "paginationType": "progressbar","mousewheel": {"enabled": true,"sensitivity": 4},"breakpoints": {"0":{"slidesPerView": 1},"576": {"slidesPerView": 1},"768": {"slidesPerView": 1},"992": {"slidesPerView": 2},"1200": {"slidesPerView": 2}}}'>
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="testi-card">
              <div class="box-img th-parallax">
                <img src="assets/img/drive-images-2-webp/kc11.webp" alt="Image" />
              </div>
              <div class="box-wrapp">
                <div class="box-left">
                  <h3 class="box-title">LUXARIOUS HOTEL</h3>
                </div>
                <div class="box-content">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <p class="box-text">
                    “We loved our stay at King Castle! The room was
                    spotless, the staff was incredibly attentive, and the
                    view from our balcony was breathtaking!.”
                  </p>
                  <div class="box-profile">
                    <div class="box-avater">
                      <img src="assets/img/testimonial/testi_1_1.png" alt="Avater" />
                    </div>
                    <div class="media-body">
                      <h3 class="box-title">Andrew Simon</h3>
                      <p class="box-desig">Property Expert</p>
                    </div>
                  </div>
                  <div class="box-quote">
                    <img src="assets/img/icon/quote.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-card">
              <div class="box-img th-parallax">
                <img src="assets/img/drive-images-2-webp/kc17.webp" alt="Image" />
              </div>
              <div class="box-wrapp">
                <div class="box-left">
                  <h3 class="box-title">LUXARIOUS HOTEL</h3>
                </div>
                <div class="box-content">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <p class="box-text">
                    Home is where love resides, memories are created, and
                    dreams are nurtured. I've found my sanctuary in this
                    beautiful King Castle.
                  </p>
                  <div class="box-profile">
                    <div class="box-avater">
                      <img src="assets/img/testimonial/testi_1_2.png" alt="Avater" />
                    </div>
                    <div class="media-body">
                      <h3 class="box-title">Michel John</h3>
                      <p class="box-desig">Property Expert</p>
                    </div>
                  </div>
                  <div class="box-quote">
                    <img src="assets/img/icon/quote.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-card">
              <div class="box-img th-parallax">
                <img src="assets/img/drive-images-2-webp/kc19.webp" alt="Image" />
              </div>
              <div class="box-wrapp">
                <div class="box-left">
                  <h3 class="box-title">LUXARIOUS HOTEL</h3>
                </div>
                <div class="box-content">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <p class="box-text">
                    “We loved our stay at King Castle! The room was
                    spotless, the staff was incredibly attentive, and the
                    view from our balcony was breathtaking!.”
                  </p>
                  <div class="box-profile">
                    <div class="box-avater">
                      <img src="assets/img/testimonial/testi_1_1.png" alt="Avater" />
                    </div>
                    <div class="media-body">
                      <h3 class="box-title">Andrew Simon</h3>
                      <p class="box-desig">Property Expert</p>
                    </div>
                  </div>
                  <div class="box-quote">
                    <img src="assets/img/icon/quote.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-card">
              <div class="box-img th-parallax">
                <img src="assets/img/drive-images-2-webp/kc23.webp" alt="Image" />
              </div>
              <div class="box-wrapp">
                <div class="box-left">
                  <h3 class="box-title">LUXARIOUS HOTEL</h3>
                </div>
                <div class="box-content">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <p class="box-text">
                    Home is where love resides, memories are created, and
                    dreams are nurtured. I've found my sanctuary in this
                    beautiful King Castle.
                  </p>
                  <div class="box-profile">
                    <div class="box-avater">
                      <img src="assets/img/testimonial/testi_1_2.png" alt="Avater" />
                    </div>
                    <div class="media-body">
                      <h3 class="box-title">Michel John</h3>
                      <p class="box-desig">Property Expert</p>
                    </div>
                  </div>
                  <div class="box-quote">
                    <img src="assets/img/icon/quote.svg" alt="" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="slider-controller">
          <button data-slider-prev="#testiSlider1" class="slider-arrow default slider-prev">
            <img src="assets/img/icon/left-arrow2.svg" alt="" />
          </button>
          <div class="slider-pagination" data-slider-id="#testiSlider1"></div>
          <button data-slider-next="#testiSlider1" class="slider-arrow default slider-next">
            <img src="assets/img/icon/right-arrow2.svg" alt="" />
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

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
