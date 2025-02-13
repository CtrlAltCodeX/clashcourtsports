<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Clash Court Sports</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports- FAQ">
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
    <div class="faq_section bg_img_login bg_img_faq">
      <div class="container sports_container">
        <div class="faq_box">
          <h2 class="faq_heading text-white">FAQ</h2>
          <div class="accordion" id="accordionExample">
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  RULES, ETIQUETTE & DISCLAIMERS
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>1. Communicate with other players in your group, this way you can schedule your matches ahead of time.</p>
                  <p>2. Respond to emails/ calls within 24 hours. Understand that everyone is as busy as you.</p>
                  <p>3. Honor all calls. Most times your opponent has a better view. Keep it honest.</p>
                  <p>4. Clash Court Sports does not promote betting of any kind. We will not be responsible for any form of gambling.</p>
                  <p>5. Know your body, limitations, and skillset. This is supposed to be fun. Clash Court Sports will not be responsible for any injuries during play.</p>
                  <p>6. Tennis courts and Pickleball courts are not the same courts. Do NOT alter any lines on public courts.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  How Are Opponents Picked?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>We group players based upon their skill level.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Where Do I Play?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>You will need to coordinate with your opponent on when and where you play. Some players decide to use private courts, while others may choose courts open to the public. There is no limit on how many matches a person can play in a day.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                  How Long Is A Match?
                </button>
              </h2>
              <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>Tennis matches will be played in a pro 10 system. This includes “add scoring” on all deuces and tie breakers on 9-9 games.</p>
                  <p>Pickleball matches will be played in a three set format. Each set will be 11 points.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                  How Are Players Ranked?
                </button>
              </h2>
              <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>We follow USTA’s NRTP Rating system.</p>
                  1.0 - 1.5: Complete beginner who can hit the ball occasionally but struggles with control and rallies. <br>
                  2.0 - 2.5: Can sustain short rallies, understands basic rules, and is improving consistency. Can start a rally with serve and return; some control over direction but still inconsistent. <br>
                  3.0 Can rally with moderate consistency; developing placement, serves, and volleys.<br>
                  3.5 Can hit with depth and control; starts using strategy and is comfortable at the net. <br>
                  4.0 Reliable strokes, good footwork, and can execute spin and directional shots under pressure.
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                  What Happens After A Season?
                </button>
              </h2>
              <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>After a season ends, there will be a single elimination style playoff tournament.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                  What Do We Do With Your Information?
                </button>
              </h2>
              <div id="collapseSeven" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>Clash Court Sports will NEVER sell your information. All information attained is to be shared with fellow players for appropriate communication. Any form of harassment from any member will not be tolerated.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                  Do You Issue Refunds?
                </button>
              </h2>
              <div id="collapseEight" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>We understand that life happens or sometimes injuries get in the way. We will issue a 100% refund before the season begins. Once a season (session) has started, no refunds can be given. For extenuating circumstances, please email us at support@clashcourtsports.com. Please note, if you are found harassing other members, we will not issue any refunds.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item accordion_item">
              <h2 class="accordion-header">
                <button class="accordion-button accordion_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                  How can I contact your customer support?
                </button>
              </h2>
              <div id="collapseNine" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body accordion_body">
                  <p>You can reach our customer support team by email at support@clashcourtsports.com.</p>
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