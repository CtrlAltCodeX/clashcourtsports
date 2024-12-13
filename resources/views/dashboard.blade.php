@extends('layouts.sidebar')

@section('admin-content')
<div class="container my-5">
    <div style="display: flex; flex-direction: row; gap: 20px; margin-bottom: 40px;">
        <!-- Total Events Card -->
        <div class="card shadow-lg border-0 text-center" style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border-radius: 15px; width: 300px;">
            <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 200px;">
                <h5 class="card-title text-uppercase font-weight-bold mb-3">Total Events</h5>
                <p class="display-4 font-weight-bold mb-1">15</p>
                <small class="text-white-50">Number of Events</small>
                <i class="fas fa-calendar-alt fa-3x mt-3"></i> <!-- Event icon -->
            </div>
        </div>

        <!-- Total Officials Card -->
        <div class="card shadow-lg border-0 text-center" style="background: linear-gradient(135deg, #ff6a00, #ee0979); color: #fff; border-radius: 15px; width: 300px;">
            <div class="card-body d-flex flex-column justify-content-center align-items-center" style="min-height: 200px;">
                <h5 class="card-title text-uppercase font-weight-bold mb-3">Total Officials</h5>
                <p class="display-4 font-weight-bold mb-1">100</p>
                <small class="text-white-50">Number of Officials Registered</small>
                <i class="fas fa-users fa-3x mt-3"></i> <!-- Officials icon -->
            </div>
        </div>
    </div>
</div>

@endsection