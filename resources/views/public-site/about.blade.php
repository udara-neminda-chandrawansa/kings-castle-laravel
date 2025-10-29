@extends('layouts.public-site')

@section('content')

<style>
  .service-box .box-text,
  .service-box .box-title a {
    color: white;
  }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
  <div class="breadcumb-wrapper" data-bg-src="assets/img/drive-images-2-webp/kc5.webp">
    <div
      style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
    </div>
    <div class="container" style="position: relative; z-index: 10;">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">About Us</h1>
        <ul class="breadcumb-menu">
          <li><a href="/">Home</a></li>
          <li>About Us</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--main about-->
<div class="overflow-hidden space-extra2-top space-bottom" id="about-sec">
  <div class="container">
    <div class="row">
      <div class="col-xl-5 mb-35 mb-xl-0">
        <div class="title-area mb-30 pe-xxl-5">
          <div class="d-flex justify-content-center">
            <img src="assets/img/logo.png" style="width: 230px;" alt="shape" />
          </div>
          <h2 class="sec-title text-center">About King Castle</h2>
          <p class="text-body fs-18 mt-25 mb-40" style="text-align: justify;">
            Located in the heart of the beautiful city Nuwara Eliya, King Castle offers the best cozy and comfortable
            rooms for a
            remarkable stay. Guests will make an easy access for Horton Plains, Tea Plantations and other
            numerous prominent traveling attractions in Nuwara Eliya, from the retreat.
          </p>
          <p class="text-body fs-18 mb-60" style="text-align: justify;">
            While offering the luxurious accommodation, the resort has included the essence of ancient Sri Lankan
            traditional arts into the ambience and interior of the hotel. The feeling will be sensational when you
            breathe inside the exquisite arrangements of regal colonial era. Frequent facilities such as free Wi-Fi,
            express check in and check out services, 24 hour front desk have made this place perfect and subtle for
            your next vacation destination. Indulge in this blissful serenity and make your best mesmerizing memory at
            King Castle.
          </p>
        </div>
        <!--counter-->
        <div class="counter-card-wrap style2">
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">10</span>+
              </h2>
              <p class="box-text text-center">Luxury Rooms</p>
            </div>
          </div>
          <div class="divider"></div>
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">20</span>+
              </h2>
              <p class="box-text text-center">Staffs</p>
            </div>
          </div>
          <div class="divider"></div>
          <div class="counter-card">
            <div class="media-body">
              <h2 class="box-number">
                <span class="counter-number">50</span>+
              </h2>
              <p class="box-text text-center">Menus</p>
            </div>
          </div>
          <div class="divider"></div>
        </div>
        <div class="btn-group mt-60">
          <a href="/about" class="th-btn extra-btn th-radius">LEARN MORE</a>
          <div class="call-info style2">
            <div class="call-icon">
              <a href="tel:+94771200180"><i class="fa-sharp fa-light fa-phone-volume"></i></a>
            </div>
            <div class="media-body">
              <span class="call-label">For Reservation</span>
              <p class="call-link">
                <a href="tel:+94767799721">+94 76 779 9721</a>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-7">
        <div class="img-box6">
          <div class="img2">
            <img src="assets/img/drive-images-2-webp/kc11.webp" alt=""
              style="width: 100%; height: 100%; object-fit: cover;" />
          </div>
          <div class="img2">
            <img src="assets/img/drive-images-2-webp/kc16.webp" alt=""
              style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 16/9;" />
          </div>
          <div class="img2">
            <img src="assets/img/drive-images-2-webp/kc12.webp" alt=""
              style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 16/9;" />
          </div>
          <div class="img2">
            <img src="assets/img/drive-images-2-webp/kc14.webp" alt=""
              style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 16/9;" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--ammenities-->
<section class="service-area3 overflow-hidden space">
  <div class="container">
    <div class="title-area text-center">
      <span class="sub-title2 style1 text-white">HOTEL AMENITIES</span>
      <h2 class="sec-title text-white">All Facilities at King Castle</h2>
    </div>
    <div class="row gy-4">
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_1.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Room Service</a>
            </h3>
            <p class="box-text">
              Enjoy 24-hour premium room service with a diverse menu of local and international cuisine delivered
              directly to your door.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_2.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Out Door Pool</a>
            </h3>
            <p class="box-text">
              Relax and unwind in our stunning infinity outdoor pool with panoramic views and dedicated attendants for
              your comfort.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_3.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Wellness & Pool</a>
            </h3>
            <p class="box-text">
              Experience rejuvenation at our wellness center featuring state-of-the-art facilities, spa treatments and
              indoor pool.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_4.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">24 Hour Check In</a>
            </h3>
            <p class="box-text">
              Arrive at your convenience with our flexible 24-hour check-in service and dedicated front desk staff
              always available.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_5.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Tours And Transport</a>
            </h3>
            <p class="box-text">
              Discover local attractions with our curated tours and convenient transportation services tailored to
              your preferences.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_6.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Garden</a>
            </h3>
            <p class="box-text">
              Wander through our meticulously maintained garden featuring native plants, tranquil seating areas and
              scenic walking paths.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_7.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Restaurant</a>
            </h3>
            <p class="box-text">
              Savor exceptional cuisine at our signature restaurant offering gourmet dishes prepared with locally
              sourced ingredients.
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xl-4 col-xxl-3">
        <div class="service-box">
          <div class="box-icon">
            <img src="assets/img/icon/service_2_8.svg" alt="Icon" />
          </div>
          <div class="box-content">
            <h3 class="box-title">
              <a href="#">Free WiFi</a>
            </h3>
            <p class="box-text">
              Stay connected with complimentary high-speed WiFi available throughout the property for seamless work
              and entertainment.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<x-room-grid :roomTypes="$roomTypes" />
<!--counter-->
<div class="space">
  <div class="container">
    <div class="counter-card-wrap style3 bg-theme" data-bg-src="">
      <div class="counter-card style2">
        <div class="media-body">
          <h2 class="box-number">
            <span class="counter-number">20</span>+
          </h2>
          <p class="box-text text-white">Years of Experience</p>
        </div>
      </div>
      <div class="divider"></div>
      <div class="counter-card style2">
        <div class="media-body">
          <h2 class="box-number">
            <span class="counter-number">50</span>+
          </h2>
          <p class="box-text text-white">Team Members</p>
        </div>
      </div>
      <div class="divider"></div>
      <div class="counter-card style2">
        <div class="media-body">
          <h2 class="box-number">
            <span class="counter-number">50</span>k+
          </h2>
          <p class="box-text text-white">Guests Serve</p>
        </div>
      </div>
      <div class="divider"></div>
      <div class="counter-card style2">
        <div class="media-body">
          <h2 class="box-number">
            <span class="counter-number">98</span>%
          </h2>
          <p class="box-text text-white">Annual Client Retention</p>
        </div>
      </div>
      <div class="divider"></div>
    </div>
  </div>
</div>
<!--testimonials-->
<section class="overflow-hidden testi-area4 space bg-black2" id="testi-sec">
  <div class="container">
    <div class="title-area text-center">
      <span class="sub-title2 style1 text-white">TESTIMONIALS</span>
      <h2 class="sec-title text-white">what Guests think about us</h2>
    </div>
    <div class="slider-wrap">
      <div class="swiper th-slider testiSlider4 has-shadow" id="testiSlider4"
        data-slider-options='{
                "paginationType": "progressbar","mousewheel": {"enabled": true,"sensitivity": 4},"breakpoints": {"0":{"slidesPerView": 1},"576": {"slidesPerView": 1},"768": {"slidesPerView": 1},"992": {"slidesPerView": 1},"1300": {"slidesPerView": 2}}}'>
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="testi-grid">
              <div class="box-profile">
                <div class="box-avater">
                  <img src="assets/img/testimonial/testi_4_1.jpg" alt="Avater" />
                </div>
                <p class="box-text">
                  Our week-long stay at King Castle was nothing short of exceptional. The attentive staff anticipated
                  our every need, while the elegantly appointed suite provided breathtaking city views. The rooftop
                  restaurant served culinary masterpieces that rivaled the best local establishments. The concierge's
                  recommendations for local attractions were spot-on, making our first visit to the city truly
                  memorable. We'll definitely return on our next trip.
                </p>
              </div>
              <div class="box-quote">
                <img src="assets/img/icon/quote2.svg" alt="" />
              </div>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="media-body">
                <h3 class="box-title">Marshell Jack</h3>
                <p class="box-desig">Guest</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-grid">
              <div class="box-profile">
                <div class="box-avater">
                  <img src="assets/img/testimonial/testi_4_2.jpg" alt="Avater" />
                </div>
                <p class="box-text">
                  King Castle has become my exclusive choice for business travel in the region. The seamless check-in
                  process, spacious workstations, and reliable high-speed internet make productivity effortless. The
                  executive lounge provides a perfect environment for impromptu meetings, while the well-equipped
                  fitness center helps maintain my routine while traveling. The convenient location near the business
                  district saves valuable time during packed itineraries.
                </p>
              </div>
              <div class="box-quote">
                <img src="assets/img/icon/quote2.svg" alt="" />
              </div>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="media-body">
                <h3 class="box-title">Edward Smith</h3>
                <p class="box-desig">Guest</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-grid">
              <div class="box-profile">
                <div class="box-avater">
                  <img src="assets/img/testimonial/testi_4_1.jpg" alt="Avater" />
                </div>
                <p class="box-text">
                  Our family celebration at King Castle exceeded all expectations from the moment we arrived. The
                  interconnecting rooms provided both togetherness and privacy for our multi-generational gathering.
                  The children's program kept our little ones entertained while adults enjoyed the spa facilities. The
                  banquet team executed our anniversary dinner flawlessly, with personalized menus and impeccable
                  service throughout the evening. Every detail was perfect!
                </p>
              </div>
              <div class="box-quote">
                <img src="assets/img/icon/quote2.svg" alt="" />
              </div>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="media-body">
                <h3 class="box-title">Jonathan Smith</h3>
                <p class="box-desig">Guest</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="testi-grid">
              <div class="box-profile">
                <div class="box-avater">
                  <img src="assets/img/testimonial/testi_4_2.jpg" alt="Avater" />
                </div>
                <p class="box-text">
                  King Castle offered the perfect balance of luxury and comfort during my recent conference stay. The
                  pillow menu ensured restful sleep, while the in-room coffee station provided necessary morning fuel.
                  The hotel's central location made exploring the city during breaks convenient and enjoyable. The
                  responsive housekeeping staff maintained immaculate surroundings, and the diverse breakfast buffet
                  energized each day with delicious options.
                </p>
              </div>
              <div class="box-quote">
                <img src="assets/img/icon/quote2.svg" alt="" />
              </div>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="media-body">
                <h3 class="box-title">Marshell Jack</h3>
                <p class="box-desig">Guest</p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider-controller">
          <button data-slider-prev="#testiSlider4" class="slider-arrow default slider-prev">
            <img src="assets/img/icon/left-arrow2.svg" alt="" />
          </button>
          <div class="slider-pagination" data-slider-id="#testiSlider2"></div>
          <button data-slider-next="#testiSlider4" class="slider-arrow default slider-next">
            <img src="assets/img/icon/right-arrow2.svg" alt="" />
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
