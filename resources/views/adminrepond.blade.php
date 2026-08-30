
@extends('layout.app')

@section('content')

<style>

    .admin-chat-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .admin-chat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        overflow: hidden;
        height: 650px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
    }


    /* ==============================
       HEADER
    ============================== */

    .admin-chat-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px 22px;
        border-bottom: 1px solid #e5e7eb;
        background: #fff;
    }

    .back-button {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #334155;
        background: #f1f5f9;
        transition: .2s;
    }

    .back-button:hover {
        background: #e2e8f0;
    }

    .student-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #2563eb;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .student-info h5 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .student-info span {
        font-size: 12px;
        color: #64748b;
    }


    /* ==============================
       BODY
    ============================== */

    .admin-chat-body {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
        background: #f8fafc;
    }

    .message-wrapper {
        display: flex;
        margin-bottom: 14px;
    }

    .message-wrapper.student {
        justify-content: flex-start;
    }

    .message-wrapper.admin {
        justify-content: flex-end;
    }

    .message {
        max-width: 70%;
        padding: 11px 15px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.5;
        word-break: break-word;
    }

    .student-message {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #334155;
        border-bottom-left-radius: 4px;
    }

    .admin-message {
        background: #2563eb;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message-time {
        display: block;
        text-align: right;
        font-size: 10px;
        margin-top: 5px;
        opacity: .7;
    }


    /* ==============================
       FOOTER
    ============================== */

    .admin-chat-footer {
        padding: 14px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
    }

    .message-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .message-input {
        flex: 1;
        resize: none;
        min-height: 45px;
        max-height: 100px;
        border: 1px solid #d1d5db;
        border-radius: 25px;
        padding: 11px 18px;
        outline: none;
        font-size: 14px;
    }

    .message-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,.08);
    }

    .send-button {
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 50%;
        background: #2563eb;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .send-button:hover {
        background: #1d4ed8;
    }


    /* ==============================
       EMPTY
    ============================== */

    .empty-chat {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #64748b;
    }

    .empty-chat i {
        font-size: 50px;
        color: #94a3b8;
    }

    .empty-chat h6 {
        margin-top: 10px;
        color: #334155;
        font-weight: 700;
    }


    @media(max-width: 768px) {

        .admin-chat-card {
            height: calc(100vh - 100px);
        }

        .admin-chat-body {
            padding: 15px;
        }

        .message {
            max-width: 82%;
        }

    }

</style>


<div class="admin-chat-container">

    <div class="admin-chat-card">


        {{-- =====================================
             HEADER
        ====================================== --}}

        <div class="admin-chat-header">

            <a
                href="{{ route('admin.chats') }}"
                class="back-button"
            >
                <i class="bi bi-arrow-left"></i>
            </a>


            @php

                $initials =
                    strtoupper(
                        substr(
                            $student->firstname ?? 'S',
                            0,
                            1
                        )
                        .
                        substr(
                            $student->lastname ?? '',
                            0,
                            1
                        )
                    );

            @endphp


            <div class="student-avatar">

                {{ $initials }}

            </div>


            <div class="student-info">

                <h5>

                    {{ $student->firstname }}
                    {{ $student->middlename }}
                    {{ $student->lastname }}

                </h5>

                <span>
                    Student
                </span>

            </div>

        </div>


        {{-- =====================================
             MESSAGES
        ====================================== --}}

        <div
            class="admin-chat-body"
            id="adminChatBody"
        >

            @if($messages->isEmpty())

                <div class="empty-chat">

                    <div>

                        <i class="bi bi-chat-dots"></i>

                        <h6>
                            No messages yet
                        </h6>

                        <p>
                            Start a conversation with this student.
                        </p>

                    </div>

                </div>

            @else

                @foreach($messages as $message)

                    <div
                        class="message-wrapper
                        {{ $message->sender_type === 'admin'
                            ? 'admin'
                            : 'student' }}"
                    >

                        <div
                            class="message
                            {{ $message->sender_type === 'admin'
                                ? 'admin-message'
                                : 'student-message' }}"
                        >

                            {{ $message->message }}

                            <span class="message-time">

                                {{ $message->created_at
                                    ->format('h:i A') }}

                            </span>

                        </div>

                    </div>

                @endforeach

            @endif

        </div>


        {{-- =====================================
             SEND MESSAGE
        ====================================== --}}

        <div class="admin-chat-footer">

            <form
                action="{{ route(
                    'admin.chat.send',
                    $student->id
                ) }}"
                method="POST"
                class="message-form"
                id="adminMessageForm"
            >

                @csrf

                <textarea
                    name="message"
                    id="adminMessageInput"
                    class="message-input"
                    placeholder="Write a message..."
                    rows="1"
                    required
                ></textarea>


                <button
                    type="submit"
                    class="send-button"
                >

                    <i class="bi bi-send-fill"></i>

                </button>

            </form>

        </div>

    </div>

</div>


<script>

    const adminChatBody =
        document.getElementById('adminChatBody');

    const adminMessageInput =
        document.getElementById('adminMessageInput');

    const adminMessageForm =
        document.getElementById('adminMessageForm');


    /*
    |--------------------------------------------------------------------------
    | Scroll to bottom
    |--------------------------------------------------------------------------
    */

    function scrollToBottom() {

        adminChatBody.scrollTop =
            adminChatBody.scrollHeight;

    }


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            scrollToBottom();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Enter to send
    |--------------------------------------------------------------------------
    */

    adminMessageInput.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Enter' &&
                !event.shiftKey
            ) {

                event.preventDefault();

                if (
                    adminMessageInput.value.trim() !== ''
                ) {

                    adminMessageForm.submit();

                }

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Auto resize
    |--------------------------------------------------------------------------
    */

    adminMessageInput.addEventListener(
        'input',
        function() {

            this.style.height = 'auto';

            this.style.height =
                Math.min(
                    this.scrollHeight,
                    100
                ) + 'px';

        }
    );

</script>

@endsection

