@extends('layouts.Sidebar')

@section('admin-content')
    <div class="card shadow-sm mb-6">
        <div class="card-header bg-blue-600 text-white text-center py-3">
            <h2 class="text-xl font-semibold">Event Participants</h2>
        </div>

        <div class="card-body px-6 py-4">
            @foreach($eventParticipants as $eventData)
                <div class="mb-4 flex justify-between items-center">
                    <!-- Event Title -->
                     <div>
                     <h3 class="text-xl font-bold mb-2">{{ $eventData['event']->name }}</h3>
                     <p class="text-gray-600">Participants: {{ $eventData['count'] }}</p>
                     </div>
                 

                    <!-- Send Email Button -->
                    <button 
                        data-event-id="{{ $eventData['event']->id }}"
                        style="background-color: blue;" 
                        class="send-email-btn text-white px-4 py-2 rounded hover:bg-blue-700">
                        Send Email
                    </button>
                </div>

                <!-- Participants Table -->
                @if($eventData['count'] > 0)
                    <div class="table-responsive mb-4">
                        <table class="table-auto w-full border border-gray-300 text-center">
                            <thead class="bg-blue-100 text-blue-700">
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Email</th>
                                    <th class="px-4 py-2 border">Phone Number</th>
                                    <th class="px-4 py-2 border">City</th>
                                    <th class="px-4 py-2 border">State</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventData['participants'] as $index => $userEvent)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>  
                                        <td class="px-4 py-2 border">{{ $userEvent->user->name }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->email }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->phone_number }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->city }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->state }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4 text-gray-600">No participants for this event.</p>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Modal to Send Email -->
    <div id="sendEmailModal" class="hidden fixed inset-0 flex justify-center items-start z-50 p-4" style="animation: slideDown 0.3s ease;">
        <div class="bg-white p-8 rounded-lg w-3/4 max-w-4xl ml-12" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);padding:20px;margin-top:55px;margin-left:155px">
            <h3 class="text-2xl font-semibold mb-6">Send Email to Participants</h3>
            <div id="email-list" class="mb-6" style="max-height: 400px; overflow-y-auto;"></div>
            <textarea id="email-message" class="w-full p-2 border border-gray-300 rounded mb-4" rows="4" placeholder="Enter your message..."></textarea>
            <div class="mt-4 flex justify-end">
                <button id="send-email" style="background-color: blue;" class="text-white px-4 py-2 rounded hover:bg-blue-700">
                    Send
                </button>
                <button id="close-modal" style="background-color: gray;" class="ml-3 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sendEmailButtons = document.querySelectorAll('.send-email-btn');
            const sendEmailModal = document.getElementById('sendEmailModal');
            const closeModal = document.getElementById('close-modal');
            const emailList = document.getElementById('email-list');
            const emailMessage = document.getElementById('email-message');
            const sendEmailBtn = document.getElementById('send-email');
            let eventId = null;

            // Open modal on "Send Email" button click
            sendEmailButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    eventId = button.getAttribute('data-event-id');
                    
                    // Fetch participant emails for the selected event
                    fetch(`/admin/events/${eventId}/participants`)
                        .then(response => response.json())
                        .then(data => {
                        console.log("data",data)
                            // Display participant emails in the modal
                            emailList.innerHTML = '';
                            data.participants.forEach((participant) => {
                                emailList.innerHTML += `<p><strong>Email</strong>: ${participant.user.email}</p>`;
                            });
                        });

                    sendEmailModal.classList.remove('hidden');
                });
            });

            // Close modal
            closeModal.addEventListener('click', function () {
                sendEmailModal.classList.add('hidden');
            });

            // Handle email sending
            sendEmailBtn.addEventListener('click', function () {
                const message = emailMessage.value;

                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }

                // Send email to participants
                fetch(`/admin/events/${eventId}/send-email`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Email sent successfully!');
                        sendEmailModal.classList.add('hidden');
                    } else {
                        alert('Failed to send email.');
                    }
                });
            });
        });
    </script>
    
    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
