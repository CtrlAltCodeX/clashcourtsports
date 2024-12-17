<!-- resources/views/admin/contact_us/index.blade.php -->
@extends('layouts.sidebar')

@section('admin-content')
<div class="container">
  
    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="py-2 border">First Name</th>
                    <th class="py-2 border">Email</th>
                    <th class="py-2 border">Message</th>
                    <th class="py-2 border">Send Date</th>
                 
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $contact->first_name }}</td>
                    <td class="py-2 border">{{ $contact->email }}</td>
                    <td class="py-2 border">{{ Str::limit($contact->message, 50) }}</td>
                    <td class="py-2 border">{{ $contact->created_at->format('m-d-Y H:i') }}</td>
                
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-4">No contact messages available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
