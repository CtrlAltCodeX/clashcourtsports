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
                    <th class="py-2 border">Reply</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $contact->first_name }}</td>
                    <td class="py-2 border">{{ $contact->email }}</td>
                    <td class="py-2 border">{{ Str::limit($contact->message, 50) }}</td>
                    <td class="py-2 border">
                        {{ $contact->created_at->setTimezone('America/New_York')->format('m-d-Y H:i A') }}
                    </td>
                    <td class="py-2 border">
                        @if (!$contact->is_replied)
                        <button class="bg-blue-500 text-white px-4 py-1 rounded"
                            onclick="openReplyModal('{{ $contact->email }}')">
                            Reply
                        </button>
                        @else
                        <button class="bg-green-500 text-white px-4 py-1 rounded" disabled>
                            Replied
                        </button>
                        @endif
                    </td>
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

<!-- Reply Modal -->
<div id="replyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-lg font-bold mb-4">Reply to Email</h2>
        <form id="replyForm" method="POST" action="{{ route('contacts.reply') }}">
            @csrf
            <input type="hidden" id="emailField" name="email">
            <div class="mb-4">
                <textarea name="reply_message" id="replyMessage" rows="4"
                    class="w-full border border-gray-300 rounded p-2"
                    placeholder="Write your reply here..." required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-gray-300 px-4 py-2 rounded mr-2" onclick="closeReplyModal()">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReplyModal(email) {
        document.getElementById('replyModal').classList.remove('hidden');
        document.getElementById('emailField').value = email;
    }

    function closeReplyModal() {
        document.getElementById('replyModal').classList.add('hidden');
        document.getElementById('replyMessage').value = '';
    }
</script>
@endsection