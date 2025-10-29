@extends('layouts.public-site')

@section('content')
<!--breadcrumb-->
<div class="breadcumb-banner">
    <div class="breadcumb-wrapper" data-bg-src="assets/img/drive-images-2-webp/kc5.jpg">
        <div
            style="position: absolute; width: 100%; height: 100%; left: 0%; top: 0%; background-color: black; opacity: .6;">
        </div>
        <div class="container" style="position: relative; z-index: 10;">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Terms & Conditions</h1>
                <ul class="breadcumb-menu">
                    <li><a href="/">Home</a></li>
                    <li>Terms & Conditions</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Terms & Conditions Section Start -->
<section class="about-section fix section-padding py-5 py-md-6">
    <div class="container">
        <div class="about-wrapper">
            <div class="row g-4 align-items-start">
                <div class="col-12">
                    <div class="about-content">
                        <div class="section-title">
                            <h2 class="wow fadeInUp" data-wow-delay=".3s">Terms & Conditions</h2>
                        </div>

                        <p class="mt-3 wow fadeInUp" data-wow-delay=".4s">
                            Welcome to <strong>Kings Castle Hotels</strong>. By accessing or using our website
                            (<a href="{{ url('/') }}">{{ url('/') }}</a>), you agree to comply with the following
                            Terms and Conditions. Please read them carefully before making a reservation or using
                            our hospitality services.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay=".5s">1. General Information</h4>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Kings Castle Hotels operates premium accommodation and hospitality services located in
                            Nuwara Eliya, Sri Lanka. All content, images, and materials on this website are owned or
                            licensed by Kings Castle Hotels and are protected under intellectual property laws.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay=".7s">2. Use of Website</h4>
                        <p class="wow fadeInUp" data-wow-delay=".8s">
                            You agree to use this website solely for lawful purposes, such as browsing rooms,
                            checking availability, and making legitimate reservations. You may not:
                        </p>
                        <ul class="wow fadeInUp" data-wow-delay=".8s">
                            <li>Use our website in a way that violates any applicable local or international law.</li>
                            <li>Attempt to gain unauthorized access to our systems or user data.</li>
                            <li>Use content or images from our website for commercial purposes without written consent.</li>
                        </ul>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay=".9s">3. Room Reservations</h4>
                        <p class="wow fadeInUp" data-wow-delay="1s">
                            All reservations made through our website or partner booking platforms are subject to
                            availability and confirmation. You are responsible for providing accurate guest details
                            during booking.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="1.1s">4. Pricing and Payments</h4>
                        <p class="wow fadeInUp" data-wow-delay="1.2s">
                            All rates displayed are in Sri Lankan Rupees (LKR) and are inclusive of applicable taxes
                            unless stated otherwise. Full or partial payment may be required at the time of booking
                            to secure your reservation.
                        </p>
                        <p class="wow fadeInUp" data-wow-delay="1.3s">
                            Kings Castle Hotels reserves the right to revise prices, promotional offers, or room
                            availability at any time without prior notice.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="1.4s">5. Check-In and Check-Out</h4>
                        <p class="wow fadeInUp" data-wow-delay="1.5s">
                            Check-in time is from 2:00 PM and check-out is until 11:00 AM unless otherwise arranged
                            in advance. Early check-in or late check-out requests are subject to availability and
                            additional charges.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="1.6s">6. Cancellations and Refunds</h4>
                        <p class="wow fadeInUp" data-wow-delay="1.7s">
                            Cancellations made within the timeframe stated on your booking confirmation are eligible
                            for a refund based on our cancellation policy. No-shows or late cancellations may be
                            charged the full room rate. Please refer to our
                            <a href="{{ route('return.policy') }}">Cancellation & Refund Policy</a> for details.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="1.8s">7. Guest Conduct</h4>
                        <p class="wow fadeInUp" data-wow-delay="1.9s">
                            Guests are expected to respect hotel property, staff, and other guests. Any damage caused
                            intentionally or through negligence will result in additional charges. The management
                            reserves the right to deny service or remove guests violating hotel policies.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="2s">8. Liability</h4>
                        <p class="wow fadeInUp" data-wow-delay="2.1s">
                            Kings Castle Hotels is not liable for loss or damage to personal belongings, accidents,
                            or injuries that occur on the premises. We strongly recommend safeguarding your valuables
                            and following all safety guidelines during your stay.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="2.2s">9. Force Majeure</h4>
                        <p class="wow fadeInUp" data-wow-delay="2.3s">
                            The hotel shall not be held responsible for delays, cancellations, or service interruptions
                            due to circumstances beyond our control, including natural disasters, political unrest, or
                            transportation disruptions.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="2.4s">10. Governing Law</h4>
                        <p class="wow fadeInUp" data-wow-delay="2.5s">
                            These Terms & Conditions shall be governed by and interpreted in accordance with the laws
                            of the Democratic Socialist Republic of Sri Lanka. Any disputes will be subject to the
                            exclusive jurisdiction of the courts in Sri Lanka.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="2.6s">11. Amendments to Terms</h4>
                        <p class="wow fadeInUp" data-wow-delay="2.7s">
                            Kings Castle Hotels reserves the right to update or modify these Terms & Conditions at any
                            time. Updates will be posted on this page, and continued use of our website implies
                            acceptance of the latest terms.
                        </p>

                        <h4 class="mt-4 wow fadeInUp" data-wow-delay="2.8s">12. Contact Us</h4>
                        <p class="wow fadeInUp" data-wow-delay="2.9s">
                            For questions, special requests, or clarifications regarding our Terms & Conditions,
                            please contact:
                        </p>

                        <ul class="wow fadeInUp" data-wow-delay="2.9s">
                            <li><strong>Kings Castle Hotels</strong></li>
                            <li>Address: No:30, Gemunu Pura, Magasthota, Nuwara Eliya, Sri Lanka</li>
                            <li>Email: <a href="mailto:reservation@kingcastle.com">reservation@kingcastle.com</a></li>
                            <li>Phone: <a href="tel:+94767799721">+94 777 611 290</a></li>
                        </ul>

                        <p class="mt-4 wow fadeInUp" data-wow-delay="3s">
                            Thank you for choosing <strong>Kings Castle Hotels</strong>. By staying with us, you agree
                            to these terms and enjoy a premium, transparent, and memorable hospitality experience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
