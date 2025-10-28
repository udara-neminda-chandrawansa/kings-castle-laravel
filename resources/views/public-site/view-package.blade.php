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
                <h1 class="breadcumb-title">{{ $tourPackage->name }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/packages">Tour Packages</a></li>
                    <li>{{ $tourPackage->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--tour package details-->
<section class="room-area space-top space-extra-bottom overflow-hidden">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-xl-9 col-lg-8">
                <div class="room-page-single">
                    <div class="main-container">
                        <div class="swiper th-slider panoramaSlide1" id="panoramaSlide1"
                            data-slider-options='{"autoplay": true, "loop": false, "speed": 1000, "allowTouchMove": true}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="room-slider-img h-100 w-100">
                                        <img src="{{ asset($tourPackage->image_path) }}" alt="{{ $tourPackage->name }}"
                                            class="w-100" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="d-flex justify-content-between align-items-center mb-30">
                            <h2 class="box-title mt-50 mb-0">{{ $tourPackage->name }}</h2>
                            <span class="p-1 text-white fs-14 bg-{{ $tourPackage->difficulty_badge }}">
                                {{ ucfirst($tourPackage->difficulty_level) }}
                            </span>
                        </div>

                        @if($tourPackage->subtitle)
                        <h4 class="text-theme mb-20">{{ $tourPackage->subtitle }}</h4>
                        @endif

                        <p class="box-text fs-18 mb-50">
                            {{ $tourPackage->description }}
                        </p>

                        <div class="row mb-50">
                            <div class="col-md-6">
                                <h3 class="box-title mb-20">Tour Details</h3>
                                <ul class="list-unstyled" style="line-height: 2.5;">
                                    <li><strong>Package:</strong> {{ $tourPackage->name }}</li>
                                    @if($tourPackage->duration)
                                    <li><strong>Duration:</strong> {{ $tourPackage->duration }}</li>
                                    @endif
                                    <li><strong>Price:</strong> <span class="text-theme">{{
                                            $tourPackage->formatted_price }}</span></li>
                                    <li><strong>Min Participants:</strong> {{ $tourPackage->min_participants }}</li>
                                    @if($tourPackage->max_participants)
                                    <li><strong>Max Participants:</strong> {{ $tourPackage->max_participants }}</li>
                                    @endif
                                    <li><strong>Difficulty:</strong>
                                        <span class="ms-1 p-1 text-white bg-{{ $tourPackage->difficulty_badge }}">
                                            {{ ucfirst($tourPackage->difficulty_level) }}
                                        </span>
                                    </li>
                                    <li><strong>Status:</strong>
                                        <span
                                            class="ms-1 p-1 text-white {{ $tourPackage->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $tourPackage->is_active ? 'Available' : 'Not Available' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                @if($tourPackage->includes && count($tourPackage->includes) > 0)
                                <h3 class="box-title mb-20">What's Included</h3>
                                <div class="room-checklist">
                                    <div class="checklist style2">
                                        <ul>
                                            @foreach($tourPackage->includes as $include)
                                            @if(!empty(trim($include)))
                                            <li style="color: black;">{{ $include }}</li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($tourPackage->notes)
                        <div class="mb-50">
                            <h3 class="box-title mb-20">Important Notes</h3>
                            <div class="alert alert-info">
                                <p class="box-text mb-0">{{ $tourPackage->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <h2 class="box-title mb-20">Hotel Amenities</h2>
                        <ul class="hotel-grid-list">
                            <li>
                                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-1.svg"
                                        alt="img" /></div>
                                <div class="hotel-grid-list-details">
                                    <p class="box-text">Swimming Pool</p>
                                </div>
                            </li>
                            <li>
                                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-2.svg"
                                        alt="img" /></div>
                                <div class="hotel-grid-list-details">
                                    <p class="box-text">Free Breakfast</p>
                                </div>
                            </li>
                            <li>
                                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-5.svg"
                                        alt="img" /></div>
                                <div class="hotel-grid-list-details">
                                    <p class="box-text">Free High Speed WiFi</p>
                                </div>
                            </li>
                            <li>
                                <div class="hotel-grid-list-icon"><img src="/assets/img/icon/hotel-icon1-7.svg"
                                        alt="img" /></div>
                                <div class="hotel-grid-list-details">
                                    <p class="box-text">Well Furnished Rooms</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--booking sidebar-->
            <div class="col-xl-3 col-lg-4">
                <aside class="sidebar-area">
                    <div class="widget widget_quote">
                        <form action="{{ route('tour-booking.store') }}" method="POST" class="booking-form2 style4">
                            @csrf
                            <input type="hidden" name="tour_package_id" value="{{ $tourPackage->id }}">
                            <div class="input-wrap">
                                <div class="title-area mb-40">
                                    <span class="sub-title2 style1 mb-15">BOOK THIS TOUR</span>
                                    <h2 class="box-title text-white">{{ $tourPackage->name }}</h2>
                                </div>
                                <div class="row gx-24 align-items-center justify-content-between">
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Guest Name</label>
                                            <input type="text" class="form-control" name="guest_name" required
                                                value="{{ old('guest_name') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Email</label>
                                            <input type="email" class="form-control" name="guest_email" required
                                                value="{{ old('guest_email') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Phone</label>
                                            <input type="tel" class="form-control" name="guest_phone" required
                                                value="{{ old('guest_phone') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Address</label>
                                            <textarea class="form-control" name="guest_address" rows="2"
                                                required>{{ old('guest_address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Address Line 2 (Optional)</label>
                                            <input type="text" class="form-control" name="guest_address_2"
                                                value="{{ old('guest_address_2') }}" />
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <div class="form-item">
                                            <label class="text-white">Tour Date</label>
                                            <input type="date" class="form-control" name="tour_date" required
                                                value="{{ old('tour_date', date('Y-m-d', strtotime('+1 day'))) }}"
                                                min="{{ date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <div class="form-item">
                                            <label class="text-white">Participants</label>
                                            <select name="participants" id="participants"
                                                class="form-select nice-select" required>
                                                <option value="" disabled selected>Select Participants</option>
                                                @for($i = $tourPackage->min_participants; $i <= ($tourPackage->
                                                    max_participants ?: 20); $i++)
                                                    <option value="{{ $i }}" {{ old('participants')==$i ? 'selected'
                                                        : '' }}>
                                                        {{ $i }} {{ $i == 1 ? 'Participant' : 'Participants' }}
                                                    </option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <div class="form-item">
                                            <label class="text-white">Special Requests</label>
                                            <textarea class="form-control" name="special_requests" rows="3"
                                                placeholder="Any special requests or requirements...">{{ old('special_requests') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <button type="submit" class="th-btn w-100" {{ !$tourPackage->is_active ?
                                            'disabled' : '' }}>
                                            {{ $tourPackage->is_active ? 'Book This Tour' : 'Currently Unavailable' }}
                                        </button>
                                    </div>
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

@endsection