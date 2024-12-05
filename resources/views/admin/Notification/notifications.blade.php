@extends('layouts.sidebar')

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

                    <!-- Buttons Section -->
                    <div>
                        <!-- Send Email Button -->
                        <button 
                            data-event-id="{{ $eventData['event']->id }}"
                            class="send-email-btn text-white px-4 py-2 rounded hover:bg-blue-700"
                            style="background-color: blue;">
                            Send Email
                        </button>

                        <!-- View Users Button -->
                        <button 
                            class="btn btn-primary toggle-users-btn" 
                            data-target="#users-{{ $eventData['event']->id }}" 
                            style="background-color:blue; color: #fff; border: none; padding: 10px 20px; font-size: 14px; border-radius: 5px; cursor: pointer; text-align: center;">
                            View Users
                        </button>
                    </div>
                </div>

                <!-- Participants Table (Hidden by Default) -->
                <div id="users-{{ $eventData['event']->id }}" class="table-responsive mb-4" style="display: none;">
                    @if($eventData['count'] > 0)
                        <table class="table-auto w-full border border-gray-300 text-center">
                            <thead class="bg-blue-100 text-blue-700">
                                <tr>
                                    <th class="px-4 py-2 border">#</th>
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Email</th>
                                      <th class="px-4 py-2 border">Skill</th>
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
                                        <td class="px-4 py-2 border">{{ $userEvent->user->Skill_Level }}</td>
                                        
                                        <td class="px-4 py-2 border">{{ $userEvent->user->phone_number }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->city }}</td>
                                        <td class="px-4 py-2 border">{{ $userEvent->user->state }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mt-4 text-gray-600">No participants for this event.</p>
                    @endif
                </div>
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
            // Toggle View Users Section
            const toggleButtons = document.querySelectorAll('.toggle-users-btn');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = button.getAttribute('data-target');
                    const targetSection = document.querySelector(targetId);

                    // Hide all other sections
                    document.querySelectorAll('.table-responsive').forEach(section => {
                        if (section !== targetSection) {
                            section.style.display = 'none';
                        }
                    });

                    // Toggle the clicked section
                    if (targetSection.style.display === 'none') {
                        targetSection.style.display = 'block';
                    } else {
                        targetSection.style.display = 'none';
                    }
                });
            });

            // Send Email Modal Logic
            const sendEmailButtons = document.querySelectorAll('.send-email-btn');
            const sendEmailModal = document.getElementById('sendEmailModal');
            const closeModal = document.getElementById('close-modal');
            const emailList = document.getElementById('email-list');
            const emailMessage = document.getElementById('email-message');
            const sendEmailBtn = document.getElementById('send-email');
            let eventId = null;
            sendEmailButtons.forEach((button) => {
        button.addEventListener('click', function () {
            eventId = button.getAttribute('data-event-id');
            
            // Fetch participant emails for the selected event
            fetch(`/admin/events/${eventId}/participants`)
                .then(response => response.json())
                .then(data => {
                    console.log("data", data);
                    // Display participant emails in the modal
                    const emails = data.participants.map(participant => participant.user.email);
                    emailList.textContent = emails.join(', ');
                });

            sendEmailModal.classList.remove('hidden');
        });
    });

            closeModal.addEventListener('click', function () {
                sendEmailModal.classList.add('hidden');
            });

            sendEmailBtn.addEventListener('click', function () {
                const message = emailMessage.value;

                if (message.trim() === '') {
                    alert('Please enter a message.');
                    return;
                }
                sendEmailModal.classList.add('hidden');

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
@endsection
