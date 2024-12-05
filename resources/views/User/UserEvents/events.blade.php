@extends('layouts.sidebar')

@section('admin-content')
    <div class="container-fluid py-4">
        <h1 class="mb-4 text-center text-blue-600 font-semibold">Your Participated Events</h1>

        <div class="row">
            <!-- List of Events -->
            <div class="col-md-12">
                @foreach ($eventsWithNearbyUsers as $data)
                    <div class="card shadow-sm mb-4">
                        <!-- Event Details -->
                        <div class="card-header bg-blue-600 text-white">
                            <h3 class="mb-0">{{ $data['event']->name }}</h3>
                        </div>
                        <div class="card-body" style="display: flex; justify-content: space-between; align-items: center;">
                            <!-- Event Details Section (Left Side) -->
                            <div style="flex: 2; text-align: left;">
                                <p><strong>Location:</strong> {{ $data['event']->location }}</p>
                                <p><strong>Game:</strong> {{ $data['event']->name }}</p>
                                <p><strong>Date:</strong> {{ $data['event']->date }}</p>
                            </div>

                            <!-- Button Section (Right Side) -->
                            <div style="flex: 1; text-align: right;">
                                <button 
                                    class="btn btn-primary toggle-users-btn" 
                                    data-target="#users-{{ $data['event']->id }}" 
                                    style="background-color: #007bff; color: #fff; border: none; padding: 10px 20px; font-size: 14px; border-radius: 5px; cursor: pointer; text-align: center;">
                                    Nearby Users
                                </button>
                            </div>
                        </div>




                        <!-- Nearby Users Section (Hidden Initially) -->
                        <div id="users-{{ $data['event']->id }}" class="users-section" style="display: none;">
                            <div class="card-body">
                                <h5 class="text-blue-600 font-medium">Nearby Users:</h5>
                                @if (count($data['nearby_users']) > 0)
                                    <div class="table-responsive">
                                        <table class="table-auto w-full border border-gray-300 text-center">
                                            <thead class="bg-blue-100 text-blue-700">
                                                <tr>
                                                    <th class="px-4 py-2 border">#</th>
                                                    <th class="px-4 py-2 border">Name</th>
                                                    <th class="px-4 py-2 border">Email</th>
                                                    <th class="px-4 py-2 border">Skill</th>
                                                    <th class="px-4 py-2 border">Type</th>
                                                    <th class="px-4 py-2 border">Latitude</th>
                                                    <th class="px-4 py-2 border">Longitude</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['nearby_users'] as $index => $user)
                                                    <tr class="hover:bg-gray-100">
                                                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->Skill_Level }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->selected_game }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->latitude }}</td>
                                                        <td class="px-4 py-2 border">{{ $user->longitude }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-red-500">No users found within 10km with matching skill level.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle the visibility of user sections
        window.toggleUserSection = function(targetId) {
            console.log("toggleUserSection called with targetId:", targetId);
            const targetSection = document.querySelector(targetId);

            // Hide all other user sections
            document.querySelectorAll('.users-section').forEach(section => {
                section.style.display = 'none'; // Hide all sections
            });

            // Toggle visibility of the clicked section
            if (targetSection) {
                if (targetSection.style.display === 'none') {
                    targetSection.style.display = 'block'; // Show the section
                } else {
                    targetSection.style.display = 'none'; // Hide the section
                }
            }
        };

        // Add click event listeners dynamically to each "View Users" button
        const toggleButtons = document.querySelectorAll('.toggle-users-btn');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = button.getAttribute('data-target'); // Get target section ID
                toggleUserSection(targetId);
            });
        });
    });
</script>


@endsection


