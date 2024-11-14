@extends('layouts.Sidebar')


@section('admin-content')
    <div class="card shadow-sm">
        <div class="card-header bg-blue-600 text-white text-center py-3">
            <h2 class="text-xl font-semibold">Officials Registration</h2>
        </div>

        <div class="card-body px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-medium">Officials List</h5>
                <a href="{{ route('officials_registration.create') }}" style="background-color: #10B981; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                    Add New Official
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table-auto w-full border border-gray-300 text-center">
                    <thead class="bg-blue-100 text-blue-700">
                        <tr>
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
                        @forelse ($officials as $official)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border">{{ $official->name }}</td>
                                <td class="px-4 py-2 border">{{ $official->phone_number }}</td>
                                <td class="px-4 py-2 border">{{ $official->email }}</td>
                                <td class="px-4 py-2 border">{{ $official->city }}</td>
                                <td class="px-4 py-2 border">{{ $official->state }}</td>
                                <td class="px-4 py-2 border">{{ $official->zip_code }}</td>
                                <td class="px-4 py-2 border">
                                    <div class="flex justify-center space-x-3">
                                   <!-- Edit button -->


<a href="{{ route('officials_registration.edit', $official->id) }}" style="background-color: #10B981" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-teal-600 focus:outline-none">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
<!-- Delete form -->
<form action="{{ route('officials_registration.destroy', ['officials_registration' => $official->id]) }}" 
      method="POST" 
      class="inline-block" 
      onsubmit="return confirm('Are you sure?')">
    @csrf
    @method('DELETE')
    <button type="submit" 
            style="background-color: #f56565;" 
            class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-red-600 focus:outline-none">
        <i class="fas fa-trash-alt mr-1"></i> Delete
    </button>
</form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">No officials available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
