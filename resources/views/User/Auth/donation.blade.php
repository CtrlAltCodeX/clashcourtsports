<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports - Donation">
  <meta name="description" content="Clash Court Sports">
  <meta name="keywords" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
</head>

<body>
  <div class="body_main">
    @include('layouts.header')

    <div class="donation_section">
      <div class="container sports_container">
        <div class="donation_box">
          <h1>Help them to build their better future</h1>
        </div>
      </div>
    </div>

    <div class="donation_about_section">
      <div class="container sports_container">
        <div class="donation_box_card">
          <ul class="nav nav-tabs donation_box_card_header" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="montly-tab" data-bs-toggle="tab" data-bs-target="#montly-tab-pane"
                type="button" role="tab" aria-controls="montly-tab-pane" aria-selected="true">Give Monthly</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="once-tab" data-bs-toggle="tab" data-bs-target="#once-tab-pane"
                type="button" role="tab" aria-controls="once-tab-pane" aria-selected="false">Give Once</button>
            </li>
          </ul>
          <div class="donation_box_body">
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="montly-tab-pane" role="tabpanel" aria-labelledby="montly-tab"
                tabindex="0">
                <div class="monthly_box">
                  <a type="button" class="btn donation_monthly_btn">Choose a Monthly Plan</a>
                  <ul class="translate_price_list">
                    <li><a type="button" class="btn price_list_btn">$15</a> </li>
                    <li><a type="button" class="btn price_list_btn">$30</a> </li>
                    <li><a type="button" class="btn price_list_btn">$50</a> </li>
                    <li><a type="button" class="btn price_list_btn">$75</a> </li>
                    <li><a type="button" class="btn price_list_btn">$100</a> </li>
                    <li><a type="button" class="btn price_list_btn">Other</a> </li>
                  </ul>
                  <div class="gift_box text-center">
                    <p class="gift_text">Your Gift Amount</p>
                    <p class="gift_amount_text">$15</p>
                  </div>
                  <div class="donat_btn_group text-center">
                    <a type="button" class="btn pay_btn"><img src="{{ asset('assets/images/paypal_btn.svg') }}" alt=""></a>
                    <a type="button" class="btn pay_btn"><img src="{{ asset('assets/images/pay_card_btn.svg') }}" alt=""></a>
                  </div>
                  <div class="continue_box text-center">
                    <a type="button" class="btn continue_btn">Continue</a>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="once-tab-pane" role="tabpanel" aria-labelledby="once-tab"
                tabindex="0">
                <div class="monthly_box">
                  <a type="button" class="btn donation_monthly_btn">Choose a Monthly Plan</a>
                  <ul class="translate_price_list">
                    <li><a type="button" class="btn price_list_btn">$15</a> </li>
                    <li><a type="button" class="btn price_list_btn">$30</a> </li>
                    <li><a type="button" class="btn price_list_btn">$50</a> </li>
                    <li><a type="button" class="btn price_list_btn">$75</a> </li>
                    <li><a type="button" class="btn price_list_btn">$100</a> </li>
                    <li><a type="button" class="btn price_list_btn">Other</a> </li>
                  </ul>
                  <div class="gift_box text-center">
                    <p class="gift_text">Your Gift Amount</p>
                    <p class="gift_amount_text">$15</p>
                  </div>
                  <div class="donat_btn_group text-center">
                    <a type="button" class="btn pay_btn"><img src="{{ asset('assets/images/paypal_btn.svg') }}" alt=""></a>
                    <a type="button" class="btn pay_btn"><img src="{{ asset('assets/images/pay_card_btn.svg') }}" alt=""></a>
                  </div>
                  <div class="continue_box text-center">
                    <a type="button" class="btn continue_btn">Continue</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('layouts.footer')
  </div>

  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>
