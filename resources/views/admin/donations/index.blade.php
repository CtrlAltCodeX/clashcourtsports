@extends('layouts.sidebar')

@section('admin-content')
<div class="container-fuild">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-medium">Donations List</h5>
     
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-[#553D1D] text-[#FFE7B4]">
                <tr>
                    <th class="py-2 border">#</th>
                    <th class="py-2 border">Name</th>
                    <th class="py-2 border">School Name</th>
                    <th class="py-2 border">Email</th>
                    <th class="py-2 border">City</th>
                    <th class="py-2 border">State</th>
                    <th class="py-2 border">Zip Code</th>
                    <th class="py-2 border">Plan</th>
                    <th class="py-2 border">Amount</th>
                    <th class="py-2 border">Payment Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($donations as $index => $donation)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 border">{{ $donations->firstItem() + $index }}</td>
                        <td class="py-2 border">{{ $donation->name }}</td>
                        <td class="py-2 border">{{ $donation->school_name }}</td>
                        <td class="py-2 border">{{ $donation->email }}</td>
                        <td class="py-2 border">{{ $donation->city }}</td>
                        <td class="py-2 border">{{ $donation->state }}</td>
                        <td class="py-2 border">{{ $donation->zip_code }}</td>
                        <td class="py-2 border">{{ $donation->plan }}</td>
                        <td class="py-2 border">${{ number_format($donation->amount, 2) }}</td>
                        <td class="py-2 border">{{ ucfirst($donation->payment_status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">No donations available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $donations->links('pagination::tailwind') }} <!-- Use TailwindCSS pagination links -->
    </div>
</div>
@endsection
