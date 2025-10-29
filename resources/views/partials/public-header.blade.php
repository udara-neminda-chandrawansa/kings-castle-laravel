  <!--mobile nav-->
  <div class="th-menu-wrapper">
    <div class="th-menu-area text-center">
      <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
      <div class="mobile-logo">
        <a href="/"><img src="{{ asset('assets/img/logo.png') }}" alt="King Castle" style="width: 100px;" /></a>
      </div>
      <div class="th-mobile-menu">
        <ul>
          <li class="">
            <a href="/">Home</a>
          </li>
          <li class="">
            <a href="/about">About Us</a>
          </li>
          <li class="">
            <a href="/services">Our Services</a>
          </li>
          <li class="">
            <a href="/packages">Tour Packages</a>
          </li>
          <li><a href="/gallery">Gallery</a></li>
          <li><a href="/contact">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </div>
  <!--normal nav-->
  <header class="th-header header-layout1">
    <!--top bar-->
    <div class="header-top">
      <div class="container">
        <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
          <div class="col-auto">
            <div class="header-links">
              <ul>
                <li>
                  <i class="fas fa-location-dot"></i>No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka
                </li>
                <li>
                  <i class="fas fa-clock"></i> 24 Hours Open
                </li>
              </ul>
            </div>
          </div>
          <div class="col-auto">
            <div class="header-links">
              <ul>
                <li class="d-none d-md-inline-block">
                  <i class="fa-sharp fa-solid fa-clock"></i>Local Time:
                  01:15PM
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--sticky nav (also normal nav)-->
    <div class="sticky-wrapper">
      <div class="container">
        <div class="menu-area">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
              <div class="header-logo">
                <a href="/"><img src="{{ asset('assets/img/logo.png') }}" alt="King Castle" style="width: 100px;" /></a>
              </div>
            </div>
            <div class="col-auto">
              <nav class="main-menu d-none d-lg-inline-block">
                <ul>
                  <li class="">
                    <a href="/">Home</a>

                  </li>
                  <li class="">
                    <a href="/about">About Us</a>

                  </li>
                  <li class="">
                    <a href="/services">Our Services</a>

                  </li>
                  <li class="">
                    <a href="/packages">Tour Packages</a>

                  </li>
                  <li><a href="/gallery">Gallery</a></li>
                  <li><a href="/contact">Contact Us</a></li>
                </ul>
              </nav>
              <button type="button" class="th-menu-toggle d-block d-lg-none">
                <i class="far fa-bars"></i>
              </button>
            </div>
            <div class="col-auto d-none d-xl-block">
              <a href="/services" class="th-btn2 border">CHECK IN NOW <img src="{{ asset('assets/img/icon/calender.svg') }}" alt="" /></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
