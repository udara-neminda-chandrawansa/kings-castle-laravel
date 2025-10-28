@extends('layouts.public-site')

@section('content')

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css">

<style>
    * {
        font-family: "Cinzel", sans-serif;
    }

    .row.gy-2 .col-md-6.col-lg-4 {
        padding: 0px 3px;
        margin-top: 6px;
        aspect-ratio: 16/9;
    }

    .slider-container {
        max-width: 400px !important;
        margin: 0 auto;
        padding: 0 20px;
    }

    .section-title {
        text-align: center;
        color: white;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .section-title p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .box-text {
        color: white;
        max-width: 100% !important;
        margin-bottom: 0px !important;
    }

    .my-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: #fff;
        margin-top: 15px;
    }

    .tour-card {
        position: relative;
        overflow: hidden;
        border-radius: 16px;
        height: 320px;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s ease;
        border: 3px solid var(--theme-color);
    }

    /* 
        .tour-card:hover {
        transform: translateY(-6px);
        } */

    .tour-image {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .tour-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .tour-card:hover .tour-image img {
        transform: scale(1.15);
    }

    /* Overlay text area */
    .tour-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.8) 90%);
        color: #fff;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        opacity: 1;
        transition: background 0.3s ease;
    }

    .tour-card:hover .tour-overlay {
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.85) 100%);
    }

    .tour-title {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .tour-desc {
        font-size: 0.95rem;
        color: #e5e7eb;
        line-height: 1.5;
        margin-bottom: 10px;
    }

    .tour-price {
        font-weight: 700;
        color: #facc15;
        font-size: 1.1rem;
    }

    .tour-price span {
        font-weight: 500;
        color: #d1d5db;
        font-size: 0.9rem;
    }

    .tour-subtitle {
        font-size: 0.92rem;
        color: #f3f4f6;
        margin: 0 0 8px 0;
        opacity: 0.95;
    }

    .tour-desc {
        font-size: 0.95rem;
        color: #e5e7eb;
        margin: 0 0 10px 0;
        line-height: 1.45;
    }

    .tour-price {
        font-weight: 800;
        color: #facc15;
        font-size: 1.02rem;
        margin-bottom: 6px;
    }

    .tour-price span {
        font-weight: 500;
        color: #d1d5db;
        font-size: 0.86rem;
        margin-left: 6px;
    }

    .tour-note {
        font-size: 0.82rem;
        color: #cbd5e1;
        margin-top: 6px;
    }
</style>

<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="assets/img/tours/gregorypark2.jpeg">
        <div
            style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
        </div>
        <div class="container relative" style="z-index: 10;">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Kings Castle Tours</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Kings Castle Tours</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--tours-->
<section class="space-top overflow-hidden bg-shape">
    <div class="container">
        <div class="title-area text-center">
            <span class="sub-title">EXPLORE SRI LANKA</span>
            <h2 class="sec-title">Things To Do</h2>
        </div>
        <div class="row gy-2">

            @foreach($tourPackages as $package)
            <div class="col-md-6 col-lg-4">
                <div class="tour-card" style="cursor: pointer;" onclick="window.location.href='{{ route('view-package', $package) }}'">
                    <div class="tour-image"><img src="{{ asset($package->image_path) }}" alt="{{ $package->name }}"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">{{ $package->name }}</h3>
                        <p class="tour-subtitle">"{{ $package->subtitle }}"</p>
                        <p class="tour-desc">
                            {{ Str::limit($package->description, 100) }}
                            @if($package->includes && count($package->includes) > 0)
                                <br><strong>Includes:</strong> {{ implode(', ', array_slice($package->includes, 0, 2)) }}{{ count($package->includes) > 2 ? ' & more' : '' }}.
                            @endif
                        </p>
                        @if($package->price)
                            <div class="tour-price">${{ number_format($package->price) }} <span>{{ $package->price_unit }}</span></div>
                        @endif

                        @if($package->notes)
                            <p class="tour-note mt-2">{{ Str::limit($package->notes, 80) }}</p>
                        @endif
                        <div class="tour-actions">
                            <a href="{{ route('view-package', $package) }}" class="th-btn2 border btn-sm me-2" onclick="event.stopPropagation();">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- 1) Helicopter Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/helicopter1.jpg" alt="Helicopter Tour"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Helicopter Tour</h3>
                        <p class="tour-subtitle">“Soar Above the Highlands”</p>
                        <p class="tour-desc">
                            Take to the skies on a <strong>15-minute</strong> helicopter ride and witness the magic
                            of Nuwara Eliya from above.<br>
                            <strong>Highlights:</strong> Lake Gregory, Nuwara Eliya City, Central Mountain Range,
                            Adam’s Peak, Kotmale Reservoir & waterfalls.
                        </p>
                        <div class="tour-price">$110 <span>per pax</span></div>
                        <p class="tour-note">Pre-booking Required | Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 2) City Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/GregoryLake.jpg" alt="City Tour"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">City Tour</h3>
                        <p class="tour-subtitle">“Explore the Queen of Hills”</p>
                        <p class="tour-desc">
                            Discover heritage streets and scenic spots of Nuwara
                            Eliya.<br><strong>Includes:</strong> city sightseeing, coffee break, Victoria Park, Lake
                            Gregory.
                        </p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 3) World’s End Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/worldsEnd.jpg" alt="World's End"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">World’s End Tour</h3>
                        <p class="tour-subtitle">“Where Earth Meets Sky”</p>
                        <p class="tour-desc">
                            Breathe in the clouds on this iconic journey.<br><strong>Highlights:</strong> hilltop
                            wind fans, New Zealand-style farm, World’s End viewpoint, Horton Plains trail.
                        </p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 4) Ella One-Day Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/waterfall1.jpg" alt="Ella One-Day Tour">
                    </div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Ella One-Day Tour</h3>
                        <p class="tour-subtitle">“Adventure & Serenity”</p>
                        <p class="tour-desc">
                            Explore Ella City, hike to Ella Rock, visit Nine Arch Bridge and try Flying Ravana
                            Adventure.<br>
                        </p>
                        <div class="tour-price">$60 <span>per pax</span></div>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 5) Lake Activities -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/jetski1.jpg" alt="Lake Activities"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Lake Activities</h3>
                        <p class="tour-subtitle">“Ride the Waters of Gregory”</p>
                        <p class="tour-desc">
                            <strong>Jet Ski – $30</strong><br>
                            <strong>Speed Boat – $15</strong><br>
                            <strong>Motor/Normal Boat – $10</strong><br>
                            <strong>Paddle Boat – $10</strong>
                        </p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 6) Horse Riding -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/horseRiding.jpg" alt="Horse Riding"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Horse Riding</h3>
                        <p class="tour-subtitle">“Gallop by the Lake”</p>
                        <p class="tour-desc">Breathe in the fresh highland air and enjoy scenic horseback rides
                            along Lake Gregory.</p>
                        <div class="tour-price">$10 <span>per pax</span></div>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 7) Bicycle Ride -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/cycling1.jpg" alt="Bicycle Ride"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Bicycle Ride</h3>
                        <p class="tour-subtitle">“Pedal Through Paradise”</p>
                        <p class="tour-desc">Cycle through misty paths and tea gardens. Relaxed pace.</p>
                        <div class="tour-price">$10 <span>per pax</span></div>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 8) Natural Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/loversLeap1.jpg" alt="Natural Tour"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Natural Tour</h3>
                        <p class="tour-subtitle">“The Soul of Nuwara Eliya”</p>
                        <p class="tour-desc">
                            <strong>Destinations:</strong> Lover’s Leap, Moon Plains, Bomburu Ella — waterfalls and
                            wide highland plains.
                        </p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 9) Tea Tasting & Workshop -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/teaTesting.jpg" alt="Tea Tasting"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Tea Tasting & Workshop</h3>
                        <p class="tour-subtitle">“From Leaf to Luxury”</p>
                        <p class="tour-desc">Experience Ceylon tea tasting and learn traditional brewing &
                            processing methods.</p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 10) Hiking Experience -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/shanthipura.jpg" alt="Hiking Experience">
                    </div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">Hiking Experience</h3>
                        <p class="tour-subtitle">“Step Into the Clouds”</p>
                        <p class="tour-desc"><strong>Trail:</strong> Santhipura View Point — guided hikes and
                            panoramic views.</p>
                        <p class="tour-note">Conditions Apply</p>
                    </div>
                </div>
            </div>

            <!-- 11) VIP Nuwara Eliya Tour -->
            <div class="col-md-6 col-lg-4">
                <div class="tour-card">
                    <div class="tour-image"><img src="assets/img/tours/nuwaraEliya.jpg" alt="VIP Tour"></div>
                    <div class="tour-overlay">
                        <h3 class="tour-title">VIP Nuwara Eliya Tour</h3>
                        <p class="tour-subtitle">“The Royal Experience”</p>
                        <p class="tour-desc">
                            Includes airport pickup, <strong>30-minute helicopter tour</strong>, and one-night stay
                            at King Kastle Lake Front.
                        </p>
                        <p class="tour-note">Pre-booking Essential | Conditions Apply</p>
                    </div>
                </div>
            </div>

        </div>

        <div style="height: 60px;"></div>
        <div class="">
            <h3>Included with All Services:</h3>
            <h4>
                Guests booking any of the above experiences will receive free transport from Nanu Oya to Nuwara
                Eliya
                hotels as part of our Compliments Package.</h4>
        </div>
    </div>
</section>

<div style="height: 60px;"></div>

@endsection