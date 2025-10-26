@extends('layouts.public-site')

@section('content')

<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Room Details</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Room Details</li>
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
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama1">
                    <img src="assets/img/from-og/rooms/double/1.jpeg" alt="Double Room Panorama 1" class="w-100"/>
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama2">
                    <img src="assets/img/from-og/rooms/double/2.jpeg" alt="Double Room Panorama 1" class="w-100"/>
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama3">
                    <img src="assets/img/from-og/rooms/double/3.jpeg" alt="Double Room Panorama 1" class="w-100"/>
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img h-100 w-100" id="panorama4">
                    <img src="assets/img/from-og/rooms/double/4.jpeg" alt="Double Room Panorama 1" class="w-100"/>
                  </div>
                </div>
              </div>
              <div class="slider-prev">Prev</div>
              <div class="slider-next">Next</div>
            </div>
            <div class="swiper th-slider room-thumb-slider" id="panoramaSlide2"
              data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":2},"768":{"slidesPerView":3},"992":{"slidesPerView":3},"1200":{"slidesPerView":5}}}'>
              <div class="swiper-wrapper">
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="assets/img/from-og/rooms/double/1.jpeg" alt="Image" />
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="assets/img/from-og/rooms/double/2.jpeg" alt="Image" />
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="assets/img/from-og/rooms/double/3.jpeg" alt="Image" />
                  </div>
                </div>
                <!--slide-->
                <div class="swiper-slide">
                  <div class="room-slider-img">
                    <img src="assets/img/from-og/rooms/double/4.jpeg" alt="Image" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="page-content">
            <h2 class="box-title mt-50">About The Double Room</h2>
            <p class="box-text fs-18 mb-50">
              Home to 16 Superior Double Rooms, Good Luck Rest House offers every comfort to make your stay a memorable one. Each room is designed for relaxation and convenience, featuring a king size bed and modern amenities.
            </p>
            <h2 class="box-title mb-20">Room Features</h2>
            <div class="room-checklist mb-60">
              <div class="checklist style2 list-four-column">
                <ul>
                  <li>2 Guests</li>
                  <li>King Size Bed</li>
                  <li>256 sq. ft.</li>
                  <li>Private Bathroom</li>
                  <li>Free WiFi</li>
                  <li>Smart TV</li>
                  <li>Luxury Room</li>
                  <li>Room Bathroom</li>
                  <li>Room View</li>
                  <li>Room Workspace</li>
                </ul>
              </div>
            </div>
            <h2 class="box-title mb-20">Hotel Amenities</h2>
            <ul class="hotel-grid-list">
              <li><div class="hotel-grid-list-icon"><img src="assets/img/icon/hotel-icon1-1.svg" alt="img" /></div><div class="hotel-grid-list-details"><p class="box-text">Swimming Pool</p></div></li>
              <li><div class="hotel-grid-list-icon"><img src="assets/img/icon/hotel-icon1-2.svg" alt="img" /></div><div class="hotel-grid-list-details"><p class="box-text">Free Breakfast</p></div></li>
              <li><div class="hotel-grid-list-icon"><img src="assets/img/icon/hotel-icon1-5.svg" alt="img" /></div><div class="hotel-grid-list-details"><p class="box-text">Free High Speed WiFi</p></div></li>
              <li><div class="hotel-grid-list-icon"><img src="assets/img/icon/hotel-icon1-7.svg" alt="img" /></div><div class="hotel-grid-list-details"><p class="box-text">Well Furnished Rooms</p></div></li>
            </ul>
            <div class="location-map">
              <h3 class="page-title fs-28 mt-45 mb-30">Hotel Location</h3>
              <div class="">
                <iframe src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7915.435783991235!2d80.58628400000002!3d7.272908!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zN8KwMTYnMjIuNSJOIDgwwrAzNScxMC42IkU!5e0!3m2!1sen!2sus!4v1756963816508!5m2!1sen!2sus" allowfullscreen="" loading="lazy" height="500"></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!--left side-->
        <div class="col-xl-3 col-lg-4">
          <aside class="sidebar-area">
            <div class="widget widget_quote">
              <form action="https://html.themeholy.com/rotal/demo/mail.php" method="POST"
                class="booking-form2 style4 ajax-contact">
                <div class="input-wrap">
                  <div class="title-area mb-40">
                    <span class="sub-title2 style1 mb-15">RESERVATION</span>
                    <h2 class="box-title text-white">Check availablility</h2>
                  </div>
                  <div class="row gx-24 align-items-center justify-content-between">
                    <div class="form-group col-12">
                      <div class="form-item">
                        <label class="text-white">Check In</label>
                        <input type="date" class="form-control" name="date" id="date" value="2025-01-20" />
                        <i class="fa-solid fa-calendar-days"></i>
                      </div>
                    </div>
                    <div class="form-group col-12">
                      <div class="form-item">
                        <label class="text-white">CHECK - OUT</label>
                        <input type="date" class="form-control" name="date" id="date2" value="2025-01-26" />
                        <i class="fa-solid fa-calendar-days"></i>
                      </div>
                    </div>
                    <div class="col-12 form-group">
                      <div class="form-item">
                        <label class="text-white">ADULT</label>
                        <select name="subject" id="subject" class="form-select nice-select">
                          <option value="Adults" selected="selected" disabled="disabled">
                            Adult 01
                          </option>
                          <option value="2 Room">Adult 02</option>
                          <option value="3 Room">Adult 03</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-12 form-group">
                      <div class="form-item">
                        <label class="text-white">Children</label>
                        <select name="subject" id="subject2" class="form-select nice-select">
                          <option value="0" selected="selected" disabled="disabled">
                            Children 0
                          </option>
                          <option value="1">Children 1</option>
                          <option value="2">Children 2</option>
                        </select>
                      </div>
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