@extends('layout')
@section('body')
    <!-- Start Breadcrumb Area  -->
    <div class="axil-breadcrumb-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8">
                    <div class="inner">
                        <ul class="axil-breadcrumb">
                            <li class="axil-breadcrumb-item"><a href="{{route('home')}}">خانه</a></li>
                            <li class="separator"></li>
                            <li class="axil-breadcrumb-item active" aria-current="page">تماس با ما</li>
                        </ul>
                        <h1 class="title">تماس با ما</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4">
                    <div class="inner">
                        <div class="bradcrumb-thumb">
                            <img src="assets/images/product/product-45.png" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area  -->

    <!-- Start Contact Area  -->
    <div class="axil-contact-page-area axil-section-gap">
        <div class="container">
            <div class="axil-contact-page">
                <div class="row row--30">
                    <div class="col-lg-8">
                        <div class="contact-form">
                            <h3 class="title mb--10">ما علاقه مندیم از شما بشنویم</h3>
                            <p>اگه محصولات فوق‌العاده‌ای داری که می‌سازی یا می‌خواهی با ما کار کنی، به ما مراجعه کن.</p>
                            <form id="contact-form" method="POST" action="/contact"  class="axil-contact-form">
                                @csrf
                                <div class="row row--10">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-name">نام <span>*</span></label>
                                            <input type="text" name="name" id="contact-name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-phone">شماره تماس <span>*</span></label>
                                            <input type="text" name="phone" id="contact-phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="contact-email">ایمل <span>*</span></label>
                                            <input type="email" name="email" id="contact-email" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contact-message">متن پیام</label>
                                            <textarea name="message" id="contact-message" cols="1" rows="2" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb--0">
                                            <button name="submit" type="submit" id="submit" class="axil-btn btn-bg-primary">ارسال پیام</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-location mb--40">
                            <h4 class="title mb--20">Our Store</h4>
                            <span class="address mb--20">8212 E. Glen Creek Street Orchard Park, NY 14127, United States of America</span>
                            <span class="phone">Phone: +123 456 7890</span>
                            <span class="email">Email: Hello@etrade.com</span>
                        </div>
                        <div class="contact-career mb--40">
                            <h4 class="title mb--20">Careers</h4>
                            <p>Instead of buying six things, one that you really like.</p>
                        </div>
                        <div class="opening-hour">
                            <h4 class="title mb--20">Opening Hours:</h4>
                            <p>Monday to Saturday: 9am - 10pm
                                <br> Sundays: 10am - 6pm
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Google Map Area  -->
            <div class="axil-google-map-wrap axil-section-gap pb--0">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe width="1080" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=melbourne&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
                    </div>
                </div>
            </div>
            <!-- End Google Map Area  -->
        </div>
    </div>
    <!-- End Contact Area  -->
@endsection