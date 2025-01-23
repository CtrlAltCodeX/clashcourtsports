@extends('layouts.sidebar')

@section('admin-content')
<div class="container-fuild">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-medium">Event List</h5>
        <a href="{{ route('events.create') }}" style="background-color: #B95B00;; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
            Add New
        </a>
    </div>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-[#553D1D] text-[#FFE7B4]">
                <tr>
                    <th class="py-2 border">#</th>
                    <th class=" py-2 border">Name</th>
                    <th class=" py-2 border">Game Name</th>
                    <th class=" py-2 border">More Info</th>
                    <th class=" py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $index => $event)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $events->firstItem() + $index }}</td>

                    <td class=" py-2 border">{{ $event->name }}</td>
                    <td class=" py-2 border">{{ $event->game_name }}</td>
                    <td class=" py-2 border">
                        <button class="toggle-details text-blue-500 underline">Show Details</button>
                    </td>

                    <td class="py-2 border">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('events.edit', $event) }}" style="background-color: #10B981" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-teal-600 focus:outline-none">
                                <i class="fas fa-edit mr-1"></i>
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #f56565; margin-left: 10px;" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-red-600 focus:outline-none" onclick="return confirm('Are you sure you want to delete?')">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr class="details-row hidden">
                    <td colspan="9" class="p-6 bg-gradient-to-r from-blue-50 via-white to-blue-50">
                        <div class="p-6 bg-white shadow-lg rounded-xl border border-gray-200">
                            <h3 class="text-lg font-semibold text-blue-600 mb-4 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13 7H7v6h6V7z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2H4zm12 10H4a4 4 0 01-4-4V7a4 4 0 014-4h12a4 4 0 014 4v4a4 4 0 01-4 4z" clip-rule="evenodd" />
                                </svg>
                                Event Details
                            </h3>
                            <ul class="grid grid-cols-2 gap-4">
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">📍 Location:</span>
                                    <span class="text-gray-900">{{ $event->location }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">👥 Capacity:</span>
                                    <span class="text-gray-900">{{ $event->capacity }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">⏳ Session Start:</span>
                                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($event->game_start_date)->format('m-d-Y H:i') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">⏳ Session End:</span>
                                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($event->game_end_date)->format('m-d-Y H:i') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">📅 Registration Start:</span>
                                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($event->date)->format('m-d-Y H:i') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">📅 Registration End:</span>
                                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($event->enddate)->format('m-d-Y H:i') }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">💵 Single Pricing:</span>
                                    <span class="text-green-600 font-bold">${{ number_format($event->pricing, 2) }}</span>
                                </li>
                                <li class="flex items-center">
                                    <span class="text-gray-700 font-medium w-1/3">💵 Double Pricing:</span>
                                    <span class="text-green-600 font-bold">${{ number_format($event->double_price, 2) }}</span>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">No events available.</td> <!-- Adjusted colspan -->
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $events->links('pagination::tailwind') }} <!-- Use TailwindCSS pagination links -->
    </div>
</div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        $(".toggle-details").on("click", function() {
            $(this).closest("tr").next(".details-row").toggleClass("hidden");
        });
    });
</script>
@endpush