@extends('layouts.sidebar')

@section('admin-content')
<div class="container-fuild mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-center mb-12">Your Participated Events</h1>

    <div class="grid gap-8">
        @foreach ($eventsWithNearbyUsers as $data)
        <div class="rounded-lg shadow-md overflow-hidden">
            <!-- Event Header -->
            <div class="bg-blue-700 text-white px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold">{{ $data['event']->name }}</h2>

                <div class="flex gap-2">
                        @if ($data['event']->game_start_date > date("Y-m-d"))
                        <a
                            href="{{ route('event.remove.player', $data['event']->userevent->user_id) }}"
                            class="bg-[#B95B00] text-[#FFE7B4] font-medium py-2 px-4 rounded focus:ring-2 focus:ring-blue-500"
                            onclick="return confirm('Are you sure?')">
                            Refund Request
                        </a>
                        @endif

                        <button
                            class="bg-[#B95B00] text-[#FFE7B4] font-medium py-2 px-4 rounded focus:ring-2 focus:ring-blue-500"
                            data-target="#users-{{ $data['event']->id }}">
                            Nearby Users
                        </button>
                </div>
            </div>

            <!-- Event Body -->
            <div class="px-6 py-4">
                <p class="text-gray-600 mb-2"><strong>Location:</strong> {{ $data['event']->location }}</p>
                <p class="text-gray-600 mb-2"><strong>Game:</strong> {{ $data['event']->name }}</p>
                <p class="text-gray-600"><strong>Date:</strong> {{ \Carbon\Carbon::parse($data['event']->game_start_date)->format('m-d-Y') }}</p>
            </div>

            <!-- Nearby Users Section -->
            <div id="users-{{ $data['event']->id }}" class="hidden transition-all duration-300 ease-in-out">
                <div class="p-6 border-t">
                    <h3 class="text-lg font-semibold mb-4">Nearby Users:</h3>
                    @if (count($data['nearby_users']) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-[#553D1D] text-[#FFE7B4]">
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
                                <tr class="hover:bg-gray-50">
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
                    <p class="text-red-500 mt-4">No users found within 10 Miles with matching skill level.</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('[data-target]');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const target = document.querySelector(targetId);

                // Hide other sections
                document.querySelectorAll('.hidden').forEach(section => {
                    if (section !== target) {
                        section.classList.add('hidden');
                    }
                });

                // Toggle the selected section
                target.classList.toggle('hidden');
            });
        });
    });
</script>
@endsection