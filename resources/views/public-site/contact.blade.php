@extends('layouts.public-site')

@section('content')

<style>
  .box-title,
  .box-text {
    color: white;
  }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
  <div class="breadcumb-wrapper" data-bg-src="assets/img/drive-images-2-webp/kc1.webp">
    <div
      style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
    </div>
    <div class="container relative" style="z-index: 10;">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title">Contact Us</h1>
        <ul class="breadcumb-menu">
          <li><a href="/">Home</a></li>
          <li>Contact Us</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--contact-->
<div class="contact-info-area space-top">
  <div class="container">
    <div class="contact-info-wrapp">
      <div class="team-contact-title">
        <h3 class="box-title">Contact Info:</h3>
      </div>
      <div class="contact-info">
        <div class="team-contact">
          <div class="icon-btn"><i class="fas fa-location-dot"></i></div>
          <div class="media-body">
            <h5 class="box-title">Our Address</h5>
            <p class="box-text">
              No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka
            </p>
          </div>
        </div>
        <div class="team-contact">
          <div class="icon-btn"><i class="fas fa-phone"></i></div>
          <div class="media-body">
            <h5 class="box-title">Phone Number</h5>
            <p class="box-text">
              <a href="tel:+94767799721">+94 76 779 9721</a>
            </p>
          </div>
        </div>
        <div class="team-contact">
          <div class="icon-btn"><i class="fas fa-envelope"></i></div>
          <div class="media-body">
            <h5 class="box-title">Email Address</h5>
            <p class="box-text">
              <a href="mailto:reservations@kingscastle.com">reservations@kingscastle.com</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="mt-5">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63367.84192343795!2d80.780947!3d6.9513662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae380434e1554c7%3A0x291608404c937d9c!2sNuwara%20Eliya!5e0!3m2!1sen!2slk!4v1743590053666!5m2!1sen!2slk"
    allowfullscreen="" loading="lazy" height="500px" style="z-index: 10;"></iframe>
  <!--
    <div class="contact-icon">
      <img src="assets/img/icon/location-dot.svg" alt="" />
    </div>
    -->
</div>
<!--form-->
<div class="space">
  <div class="container">
    <div class="row gx-0">
      <div class="col-xl-6">
        <form action="#" method="POST" class="contact-form ajax-contact">
          <div class="title-area mb-45 text-center text-lg-start">
            <span class="sub-title2 style1 text-white">CONTACT US</span>
            <h2 class="sec-title text-white">Do you have questions?</h2>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" name="name" id="name" placeholder="Name*" />
            </div>
            <div class="form-group col-md-6">
              <input type="tel" class="form-control" name="number" id="number" placeholder="Phone*" />
            </div>
            <div class="form-group col-12">
              <input type="email" class="form-control" name="email" id="email*" placeholder="Email Address*" />
            </div>
            <div class="form-group col-12">
              <select name="subject" id="subject" class="form-select nice-select">
                <option value="" disabled="disabled" selected="selected" hidden>
                  Subject
                </option>
                <option value="Luxury Hotel">Luxury Hotel</option>
                <option value="Rooms">Rooms</option>
                <option value="Hotel">Hotel</option>
              </select>
            </div>
            <div class="form-group col-12">
              <textarea name="message" id="message" cols="30" rows="3" class="form-control"
                placeholder="Your Message"></textarea>
            </div>
            <div class="form-btn col-12">
              <button class="th-btn">SEND MESSAGE</button>
            </div>
          </div>
          <p class="form-messages mb-0 mt-3"></p>
        </form>
      </div>
      <div class="col-xl-6">
        <div class="contact-image global-img">
          <img src="assets/img/drive-images-2-webp/kc1.webp" alt="" />
        </div>
      </div>
    </div>
  </div>
</div>
<div class="space-bottom">
  <div class="brand-area4 bg-black2">
    <div class="dot-shape1" data-mask-src="assets/img/shape/brand-dot1.png"></div>
    <div class="dot-shape2" data-mask-src="assets/img/shape/brand-dot2.png"></div>
    <div class="container">
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
</div>

@endsection