@extends('layouts.public-site')

@section('content')

<style>
  .form-item label {
    color: white !important;
  }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
  <div class="breadcumb-wrapper" data-bg-src="assets/img/drive-images-2-webp/kc21.webp">
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
      <div class="col-lg-6">
        <div class="room-box">
          <div class="box-img">
            <img src="assets/img/drive-images-2-webp/kc14.webp" alt="" style="height: 100%;" />
          </div>
          <span class="discount">Rs 30,000.00</span>
          <div class="box-title-area">
            <div class="box-number">01</div>
            <h3 class="box-title">
              <a href="#">Double Room</a>
            </h3>
            <div class="mt-10">
              <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
            </div>
          </div>
          <div class="box-content">
            <div class="box-wrapp">
              <div class="box-number">01</div>
              <h3 class="box-title">
                <a href="#">Double Room</a>
              </h3>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="room-card-meta">
                <span class="hidden"><img src="assets/img/icon/cat_2.svg" alt="icon" />2 King
                  Beds</span>
                <span class="hidden"><img src="assets/img/icon/cat_3.svg" alt="icon" />1500
                  sqft/Room</span>
                <span><img src="assets/img/icon/cat_4.svg" alt="icon" />2
                  Person</span>
              </div>
              <div class="mt-10">
                <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="room-box">
          <div class="box-img">
            <img src="assets/img/drive-images-2-webp/kc1.webp" alt="" />
          </div>
          <span class="discount">Rs 37,000.00</span>
          <div class="box-title-area">
            <div class="box-number">02</div>
            <h3 class="box-title">
              <a href="#">Triple Room</a>
            </h3>
            <div class="mt-10">
              <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
            </div>
          </div>
          <div class="box-content">
            <div class="box-wrapp">
              <div class="box-number">02</div>
              <h3 class="box-title">
                <a href="#">Triple Room</a>
              </h3>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="room-card-meta">
                <span class="hidden"><img src="assets/img/icon/cat_2.svg" alt="icon" />2 King
                  Beds</span>
                <span class="hidden"><img src="assets/img/icon/cat_3.svg" alt="icon" />1500
                  sqft/Room</span>
                <span><img src="assets/img/icon/cat_4.svg" alt="icon" />3
                  Person</span>
              </div>
              <div class="mt-10">
                <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="room-box">
          <div class="box-img">
            <img src="assets/img/drive-images-2-webp/kc32.webp" alt="" style="object-position: center;" />
          </div>
          <span class="discount">Rs 65,000.00</span>
          <div class="box-title-area">
            <div class="box-number">03</div>
            <h3 class="box-title">
              <a href="#">Sweet Double Room</a>
            </h3>
            <div class="mt-10">
              <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
            </div>
          </div>
          <div class="box-content">
            <div class="box-wrapp">
              <div class="box-number">03</div>
              <h3 class="box-title">
                <a href="#">Sweet Double Room</a>
              </h3>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="room-card-meta">
                <span class="hidden"><img src="assets/img/icon/cat_2.svg" alt="icon" />King & Single
                  Bed</span>
                <span class="hidden"><img src="assets/img/icon/cat_3.svg" alt="icon" />1500
                  sqft/Room</span>
                <span><img src="assets/img/icon/cat_4.svg" alt="icon" />2
                  Person</span>
              </div>
              <div class="mt-10">
                <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="room-box">
          <div class="box-img">
            <img src="assets/img/drive-images-2-webp/kc31.webp" alt="" />
          </div>
          <span class="discount">Rs 75,000.00</span>
          <div class="box-title-area">
            <div class="box-number">04</div>
            <h3 class="box-title">
              <a href="#">Sweet Triple Room</a>
            </h3>
            <div class="mt-10">
              <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
            </div>
          </div>
          <div class="box-content">
            <div class="box-wrapp">
              <div class="box-number">04</div>
              <h3 class="box-title">
                <a href="#">Sweet Triple Room</a>
              </h3>
              <div class="box-review">
                <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                  class="fa-sharp fa-solid fa-star"></i>
              </div>
              <div class="room-card-meta">
                <span class="hidden"><img src="assets/img/icon/cat_2.svg" alt="icon" />King
                  Bed</span>
                <span class="hidden"><img src="assets/img/icon/cat_3.svg" alt="icon" />1500
                  sqft/Room</span>
                <span><img src="assets/img/icon/cat_4.svg" alt="icon" />3
                  Person</span>
              </div>
              <div class="mt-10">
                <a href="#" class="th-btn2 style2">VIEW DETAILS</a>
              </div>
            </div>
          </div>
        </div>
      </div>
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
          <form action="#" method="POST" class="booking-form2 style3 ajax-contact">
            <div class="hero-wrap">
              <div class="title-area mb-40">
                <span class="sub-title2 style1 mb-15">ROOMS RESERVATION</span>
                <h2 class="sec-title text-white">Check availablility</h2>
              </div>
              <div class="row gx-24 align-items-center justify-content-between">
                <div class="form-group col-12">
                  <div class="form-item">
                    <label>Check In</label>
                    <input type="date" class="form-control" name="date" id="date" value="2025-01-20" />
                    <i class="fa-solid fa-calendar-days"></i>
                  </div>
                </div>
                <div class="form-group col-12">
                  <div class="form-item">
                    <label>CHECK - OUT</label>
                    <input type="date" class="form-control" name="date" id="date2" value="2025-01-26" />
                    <i class="fa-solid fa-calendar-days"></i>
                  </div>
                </div>
                <div class="col-12 form-group">
                  <div class="form-item">
                    <label>ADULT</label>
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
                    <label>Children</label>
                    <select name="subject" id="subject2" class="form-select nice-select">
                      <option value="0" selected="selected" disabled="disabled">
                        Children 0
                      </option>
                      <option value="1">Children 1</option>
                      <option value="2">Children 2</option>
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

@endsection