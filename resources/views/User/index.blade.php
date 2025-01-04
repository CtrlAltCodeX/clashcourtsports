<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports- Home">
  <meta name="description" content="Clash Court Sports">
  <meta name="keywords" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
  <div class="body_main">
    @include('layouts.header')
    @if(session('alert'))
    <div class="alert alert-warning">
      {{ session('alert') }}
    </div>
    @endif

    <div class="banner_section">
      <div class="container sports_container">
        <div class="banner_content">
          <h1 class="banner_headng">Clash Court Sports</h1>
          <p class="banner_content">Long Island’s Premier Pick-Up Tennis & Pickleball League </p>
          <div class="demo_btn_group">
            <a href="{{ route('clashsports.events') }}" class="btn join_now_btn">Join Now</a>
            <a href="{{ route('user.auth.faq') }}" class="btn faq_btn">FAQ</a>
          </div>
        </div>
      </div>
    </div>
    <div class="about_section">
      <div class="container sports_container">
        <div class="about_box">
          <ul class="work_list">
            <li>
              <div class="about_content">
                <h2>Welcome to Clash Court Sports</h2>
                <p>At Clash Court Sports, we are dedicated to providing everyone with tennis  and pickleball partners.
                  It’s simple…. Register, Connect with Opponents, Play and Record Scores.</p>
                <p>Whether you’re a beginner or a seasoned player looking to compete, we have something for you.</p>
                <p>Come join us and be a part of our tennis and
                  pickleball community. Meet new friends, challenge yourself and have a blast. We can’t wait to see you
                  on the courts!</p>
              </div>
            </li>
            <li>
              <div class="work_box_img"><img src="{{ asset('assets/images/welcome_img.png') }}" alt=""></div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="registration_section">
      <div class="container sports_container">
        <div class="registration_box">
          <h2 class="registration_heading">Registration</h2>
          <ul class="registration_list">
            <li>
              <div class="registration_box_card">
                <div class="registration_box_inner">
                  <h6>Play Singles - $50</h6>
                  <a href="{{ route('clashsports.events') }}" class="btn registration_for_btn">Register for Spring 2025</a>
                </div>
              </div>
            </li>
            <li>
              <div class="registration_box_card bg_two">
                <div class="registration_box_inner">
                  <h6>Play Doubles - $40</h6>
                  <a href="{{ route('clashsports.events') }}" class="btn registration_for_btn">Register for Spring 2025</a>
                </div>
              </div>
            </li>
            <li>
              <div class="registration_box_card bg_three">
                <div class="registration_box_inner">
                  <h6>Rules & FAQ</h6>
                  <a href="{{ route('user.auth.faq') }}" class="btn registration_for_btn">Know More</a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="back_section">
      <div class="container sports_container">
        <div class="back_section_box">
          <h3>Giving Back</h3>
          <p>Your contributions play a direct role in maintaining our school’s tennis courts. By donating, you’re
            ensuring
            that our students have a well-kept space to develop their skills and love for
            the sport. Your support goes straight to the school, empowering our youth and fostering
            a community of enthusiastic athletes. Thank you for considering this cause and
            for your invaluable support!</p>
          <a href="{{ route('user.auth.donation') }}" class="btn back_btn">Donate To A School Of Your Choice</a>
        </div>
      </div>
    </div>
    <div class="work_section">
      <div class="container sports_container">
        <div class="work_box">
          <ul class="work_list">
            <li>
              <div class="work_list_box">
                <h4>How It Works</h4>
                <div class="work_list_media">
                  <div class="work_icon">
                    1
                  </div>
                  <div class="work_list_media_body">
                    <h5>Register</h5>
                  </div>
                </div>
                <div class="work_list_media">
                  <div class="work_icon">
                    2
                  </div>
                  <div class="work_list_media_body">
                    <h5>Connect With Opponents</h5>
                  </div>
                </div>
                <div class="work_list_media">
                  <div class="work_icon">
                    3
                  </div>
                  <div class="work_list_media_body">
                    <h5>Play</h5>
                  </div>
                </div>
                <div class="work_list_media">
                  <div class="work_icon">
                    4
                  </div>
                  <div class="work_list_media_body">
                    <h5>Record Scores</h5>
                  </div>
                </div>
                <a href="member.html" class="btn join_now_btn mt_32">Join Now</a>
              </div>
            </li>
            <li>
              <div class="work_box_img"><img src="{{ asset('assets/images/work_box_img.svg') }}" alt=""></div>
            </li>
        </div>
      </div>
    </div>
    <div class="testimonial_section">
      <div class="container sports_container">
        <div id="Happy_customer" class="owl-carousel owl-theme">
          <div class="item">
            <div class="testimonial_box">
              <h5>Bringing all Long Island tennis and pickleball players together.
                Hope to see you on the courts.</h5>
              <p>– Tribby (Founder)</p>
            </div>
          </div>
          <div class="item">
            <div class="testimonial_box">
              <h5>Bringing all Long Island tennis and pickleball players together.
                Hope to see you on the courts.</h5>
              <p>– Tribby (Founder)</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="contact_section">
      <div class="container sports_container">
        <div class="contact_box">
          <div class="contact_box_left">
            <h6>Contact Us Now</h6>
            <p>Fill out the form below to get in touch with us. We are here to answer any questions you may have and
              provide you with the best tennis experience.</p>
          </div>
          <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="contact_box_right">
              <div class="info_group">
                <p class="info_label">First Name</p>
                <input type="text" name="first_name" class="form-control info_form_control" placeholder="E.g Nishtha" required>
              </div>
              <div class="info_group">
                <p class="info_label">Email Address</p>
                <input type="email" name="email" class="form-control info_form_control" placeholder="abc@gmail.com" required>
              </div>
              <div class="info_group">
                <p class="info_label">Message</p>
                <textarea name="message" class="form-control info_form_control" rows="6" placeholder="Type your Message" required></textarea>
              </div>
              <button type="submit" class="btn join_now_btn">Send</button>
            </div>
          </form>

        </div>
      </div>
    </div>
    @include('layouts.footer')
  </div>
  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>