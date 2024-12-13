@extends('layouts.sidebar')


@section('admin-content')
<div class="container">
    <div class="flex justify-between items-center mb-4">
        <h5 class="text-lg font-medium">Officials List</h5>
        <a href="{{ route('officials_registration.create') }}" style="background-color: #10B981; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
            Add New
        </a>
    </div>

    @if (session('success'))
    <div style="background-color: #d1fae5; color: #047857; padding: 0.75rem; border-radius: 0.375rem; margin-bottom: 1rem;">
        {{ session('success') }}
    </div>
    @endif

    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="px-4 py-2 border">Sr. No.</th>
                    <th class="px-4 py-2 border">Id</th>
                    <th class="px-4 py-2 border">Organization Name</th>
                    <th class="px-4 py-2 border">Phone Number</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">City</th>
                    <th class="px-4 py-2 border">State</th>
                    <th class="px-4 py-2 border">ZIP Code</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($officials as $key => $official)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">{{ ++$key }}</td>
                    <td class="px-4 py-2 border">{{ $official->id }}</td>
                    <td class="px-4 py-2 border">{{ $official->name??"N/A" }}</td>
                    <td class="px-4 py-2 border">{{ $official->phone_number??"N/A" }}</td>
                    <td class="px-4 py-2 border">{{ $official->email??"N/A" }}</td>
                    <td class="px-4 py-2 border">{{ $official->city??'N/A' }}</td>
                    <td class="px-4 py-2 border">{{ $official->state??'N/A' }}</td>

                    <td class="px-4 py-2 border">{{ $official->zip_code??'N/A' }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('officials_registration.edit', $official->id) }}" style="background-color: #10B981" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-teal-600 focus:outline-none">
                                <i class="fas fa-edit mr-1"></i>
                            </a>
                            <form action="{{ route('officials_registration.destroy', ['officials_registration' => $official->id]) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="background-color: #f56565;"
                                    class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-red-600 focus:outline-none">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">No Result Found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection