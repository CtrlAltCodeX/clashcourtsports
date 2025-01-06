<!DOCTYPE html>
<html lang="en">

<head>
    <title>Clash Court Sports</title>
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
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif
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
                    <form action="{{ route('donation.submit') }}" method="POST" id="donationForm">
                        @csrf
                        <input type="hidden" name="plan" id="plan" value="monthly">

                        <ul class="nav nav-tabs donation_box_card_header" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="monthly-tab" data-bs-toggle="tab"
                                    data-bs-target="#monthly-tab-pane" type="button" role="tab"
                                    aria-controls="monthly-tab-pane" aria-selected="true">Give Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="once-tab" data-bs-toggle="tab"
                                    data-bs-target="#once-tab-pane" type="button" role="tab"
                                    aria-controls="once-tab-pane" aria-selected="false">Give Once</button>
                            </li>
                        </ul>
                        <div class="donation_box_body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="monthly-tab-pane" role="tabpanel"
                                    aria-labelledby="monthly-tab" tabindex="0">
                                    <div class="monthly_box">
                                        <p class="gift_text">Select a Plan</p>
                                        <ul class="translate_price_list">
                                            @foreach ([15, 30, 50, 75, 100] as $amount)
                                            <li>
                                                <input type="radio" name="amount" id="amount-{{ $amount }}"
                                                    value="{{ $amount }}">
                                                <label for="amount-{{ $amount }}"
                                                    class="btn price_list_btn">${{ $amount }}</label>
                                            </li>
                                            @endforeach
                                            <li>
                                                <input type="radio" name="amount" id="amount-other-monthly"
                                                    value="other">
                                                <label for="amount-other-monthly"
                                                    class="btn price_list_btn">Other</label>
                                            </li>
                                        </ul>
                                        <div id="customAmountFieldMonthly" style="display: none;">
                                            <input type="number" name="custom_amount_monthly" class="form-control"
                                                placeholder="Enter your amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="once-tab-pane" role="tabpanel" aria-labelledby="once-tab"
                                    tabindex="0">
                                    <div class="monthly_box">
                                        <p class="gift_text">Select a Plan</p>
                                        <ul class="translate_price_list">
                                            @foreach ([15, 30, 50, 75, 100] as $amount)
                                            <li>
                                                <input type="radio" name="amount" id="amount-once-{{ $amount }}"
                                                    value="{{ $amount }}">
                                                <label for="amount-once-{{ $amount }}"
                                                    class="btn price_list_btn">${{ $amount }}</label>
                                            </li>
                                            @endforeach
                                            <li>
                                                <input type="radio" name="amount" id="amount-other-once" value="other">
                                                <label for="amount-other-once" class="btn price_list_btn">Other</label>
                                            </li>
                                        </ul>
                                        <div id="customAmountFieldOnce" style="display: none;">
                                            <input type="number" name="custom_amount_once" class="form-control"
                                                placeholder="Enter your amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="gift_box text-center">
                            <p class="gift_text">Your Gift Amount</p>
                            <p class="gift_amount_text" id="giftAmount">$0</p> <!-- Default amount -->
                        </div>
                        <div class="continue_box text-center">
                            <button type="submit" class="btn continue_btn">Donate Now</button>
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
    <script>
        $(document).ready(function() {
            // Update plan field on tab click
            $('#monthly-tab').on('click', function() {
                $('#plan').val('monthly');
                resetCustomAmountFields();
            });

            $('#once-tab').on('click', function() {
                $('#plan').val('once');
                resetCustomAmountFields();
            });

            // Handle amount selection
            $('input[name="amount"]').on('change', function() {
                const selectedTab = $('#plan').val();
                if ($(this).val() === 'other') {
                    if (selectedTab === 'monthly') {
                        $('#customAmountFieldMonthly').show();
                        $('#customAmountFieldOnce').hide();
                    } else {
                        $('#customAmountFieldOnce').show();
                        $('#customAmountFieldMonthly').hide();
                    }
                    $('#giftAmount').text('$0'); // Reset amount
                } else {
                    resetCustomAmountFields();
                    $('#giftAmount').text('$' + $(this).val()); // Update gift amount
                }
            });

            // Update the gift amount when entering a custom amount
            $('input[name="custom_amount_monthly"], input[name="custom_amount_once"]').on('input', function() {
                const customAmount = $(this).val();
                $('#giftAmount').text(customAmount ? `$${customAmount}` : '$0'); // Update dynamically
            });

            // Reset custom amount fields
            function resetCustomAmountFields() {
                $('#customAmountFieldMonthly').hide();
                $('#customAmountFieldOnce').hide();
                $('input[name="custom_amount_monthly"], input[name="custom_amount_once"]').val('');
            }
        });
    </script>
</body>

</html>