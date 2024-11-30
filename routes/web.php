<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ManagePlayersController;
use App\Http\Controllers\OfficialsRegistrationController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ManageScoreController;
use App\Models\UserEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEventEmail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/events/{eventId}/participants', [NotificationController::class, 'getParticipants']);
Route::post('/admin/events/{eventId}/send-email', [NotificationController::class, 'sendEmail']);


// user route section 
Route::get('/clashsports', function () {
    return view('user.index');
})->name('clashsports');

Route::get('/clashsports/login', function () {
    return view('user.auth.login');
})->name('user.auth.login');

// Route::get('/clashsports/join-now', function () {
//     return view('user.auth.joinNow');
// })->name('user.auth.joinNow');

Route::get('/clashsports/faq', function () {
    return view('user.auth.faq');
})->name('user.auth.faq');

Route::get('/clashsports/donation', function () {
    return view('user.auth.donation');
})->name('user.auth.donation');

Route::get('clashsports/join-now/{id}', [ManagePlayersController::class, 'JoinNow'])->name('user.auth.joinNow');
Route::post('clashsports/join-now/{id}', [ManagePlayersController::class, 'StripeCheckout'])->name('stripe.checkout.joinNow');
Route::get('stripe/checkout/success', [ManagePlayersController::class, 'StripeCheckoutSuccess'])->name('stripe.checkout.success');
Route::post('clashsports/Login', [ManagePlayersController::class, 'login'])->name('userPost.auth.login');


Route::get('clashsports/events', [ManagePlayersController::class, 'index'])->name('clashsports.events');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');


// user events 
Route::get('/user-events', [UserEventController::class, 'index'])->name('user.events')->middleware('auth');
Route::get('/events-Score', [UserEventController::class, 'AddScore'])->name('user.events.score')->middleware('auth');
Route::post('/events-score/save', [UserEventController::class, 'SaveScore'])->name('user.events.save_score')->middleware('auth');

Route::get('/manage-scores', [ManageScoreController::class, 'index'])->name('admin.manage_scores.index');
Route::post('/manage-scores/{id}/update-status', [ManageScoreController::class, 'updateStatus'])->name('admin.manage_scores.update_status');


Route::resource('events', EventController::class);
Route::resource('officials_registration', OfficialsRegistrationController::class);

require __DIR__.'/auth.php';
