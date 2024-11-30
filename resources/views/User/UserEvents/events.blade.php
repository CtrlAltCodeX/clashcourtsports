@extends('layouts.Sidebar')

@section('admin-content')
    <div class="container-fluid py-4">
        <h1 class="mb-4 text-center text-blue-600 font-semibold">Your Participated Events</h1>

        @foreach ($eventsWithNearbyUsers as $data)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-blue-600 text-white">
                    <h3 class="mb-0">{{ $data['event']->name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Location:</strong> {{ $data['event']->location }}</p>
                            <p><strong>Game:</strong> {{ $data['event']->name }}</p>
                            <p><strong>Date:</strong> {{ $data['event']->date }}</p>
                        </div>
                    </div>

                    <h5 class="text-blue-600 font-medium">Users Within 10km:</h5>

                    @if (count($data['nearby_users']) > 0)
                        <div class="table-responsive">
                            <table class="table-auto w-full border border-gray-300 text-center">
                                <thead class="bg-blue-100 text-blue-700">
                                    <tr>
                                        <th class="px-4 py-2 border">#</th>
                                        <th class="px-4 py-2 border">Name</th>
                                        <th class="px-4 py-2 border">Email</th>
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
                                            <td class="px-4 py-2 border">{{ $user->latitude }}</td>
                                            <td class="px-4 py-2 border">{{ $user->longitude }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-red-500">No users found within 10km.</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
