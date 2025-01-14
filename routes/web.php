<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ManagePlayersController;
use App\Http\Controllers\OfficialsRegistrationController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ManageScoreController;
use App\Http\Controllers\DonationController;

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('events', EventController::class);

    Route::resource('officials_registration', OfficialsRegistrationController::class);

    Route::get('/user-events', [UserEventController::class, 'index'])
        ->name('user.events')->middleware('auth');

    Route::get('dashboard', [UserEventController::class, 'dashboard'])
        ->name('user.dashboard')->middleware('auth');

    Route::get('/events-score', [UserEventController::class, 'AddScore'])
        ->name('user.events.score')->middleware('auth');

    Route::post('/events-score/save', [UserEventController::class, 'SaveScore'])
        ->name('user.events.save_score');

    // Route for showing the "Add Match Manually" page
    Route::get('/user/events/add-manually', [UserEventController::class, 'showAddMatchForm'])
        ->name('user.events.add.manually');

    // Route to save the manually added match
    Route::post('/user/events/save-match', [UserEventController::class, 'SaveManualMatch'])
        ->name('user.events.save.match');

    Route::post('/events/update-status/{event}', [UserEventController::class, 'updateStatus'])->name('user.userevents.updateStatus');

    Route::get('/manage-scores', [ManageScoreController::class, 'index'])
        ->name('admin.manage_scores.index');

    Route::post('/manage-scores/{id}/update-status', [ManageScoreController::class, 'updateStatus'])
        ->name('admin.manage_scores.update_status');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('events/{eventId}/participants', [NotificationController::class, 'getParticipants']);

    Route::post('events/{eventId}/send-email', [NotificationController::class, 'sendEmail']);

    Route::get('events/group/wise', [EventController::class, 'playerGroupWise'])
        ->name('events.group.wise');

    Route::get('upcoming/events', [EventController::class, 'upcomingEvents'])
        ->name('events.upcoming');

    Route::get('/contact', [ContactController::class, 'index'])
        ->name('admin.contact.index');

    Route::post('/contacts/reply', [ContactController::class, 'reply'])
        ->name('contacts.reply');

    Route::get('event/player/remove/{id}', [UserEventController::class, 'removePlayer'])
        ->name('event.remove.player');
});

Route::get('/', function () {
    return view('user.index');
})->name('clashsports');

Route::get('login', function () {
    return view('user.auth.login');
})->name('user.auth.login');

Route::get('faq', function () {
    return view('user.auth.faq');
})->name('user.auth.faq');

Route::get('donation', function () {
    return view('user.auth.donation');
})->name('user.auth.donation');

Route::post('/donation', [DonationController::class, 'submitDonation'])
    ->name('donation.submit');

Route::get('donation/checkout/success', [DonationController::class, 'DonationCheckoutSuccess'])
    ->name('donation.checkout.success');

Route::get('donation/checkout/cancel', [DonationController::class, 'DonationCheckoutCancel'])
    ->name('donation.checkout.cancel');

Route::get('show/donations', [DonationController::class, 'index'])
    ->name('show.donations.index');


Route::get('join-now/{id}', [ManagePlayersController::class, 'JoinNow'])
    ->name('user.auth.joinNow');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::post('join-now/{id}', [ManagePlayersController::class, 'StripeCheckout'])
    ->name('stripe.checkout.joinNow');

Route::get('stripe/checkout/success', [ManagePlayersController::class, 'StripeCheckoutSuccess'])
    ->name('stripe.checkout.success');

Route::post('login', [ManagePlayersController::class, 'login'])
    ->name('userPost.auth.login');

Route::get('events', [ManagePlayersController::class, 'index'])
    ->name('clashsports.events');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
