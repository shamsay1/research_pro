@extends('layout.app')

@section('content')

<style>
    .chat-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .chat-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.08);
        border: 1px solid #e5e7eb;
        overflow: hidden;
        height: 650px;
        display: flex;
        flex-direction: column;
    }

    /* ==============================
       CHAT HEADER
    ============================== */

    .chat-header {
        padding: 18px 22px;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .admin-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #2563eb;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        font-weight: 700;
    }

    .admin-info h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
    }

    .admin-info span {
        display: block;
        margin-top: 3px;
        font-size: 12px;
        color: #22c55e;
    }

    .online-dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
        margin-right: 4px;
    }

    /* ==============================
       CHAT BODY
    ============================== */

    .chat-body {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
        background: #f8fafc;
    }

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
        display: block;
        margin-bottom: 10px;
    }

    .empty-chat h6 {
        font-weight: 700;
        color: #334155;
    }

    /* ==============================
       MESSAGE
    ============================== */

    .message-wrapper {
        display: flex;
        margin-bottom: 14px;
    }

    .message-wrapper.student {
        justify-content: flex-end;
    }

    .message-wrapper.admin {
        justify-content: flex-start;
    }

    .message {
        max-width: 70%;
        padding: 11px 15px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.5;
        position: relative;
        word-wrap: break-word;
    }

    .message.student-message {
        background: #2563eb;
        color: #fff;
        border-bottom-right-radius: 4px;
    }

    .message.admin-message {
        background: #fff;
        color: #334155;
        border: 1px solid #e2e8f0;
        border-bottom-left-radius: 4px;
    }

    .message-time {
        display: block;
        margin-top: 5px;
        font-size: 10px;
        text-align: right;
        opacity: .7;
    }

    .message-status {
        margin-left: 3px;
    }

    /* ==============================
       CHAT FOOTER
    ============================== */

    .chat-footer {
        padding: 15px;
        background: #fff;
        border-top: 1px solid #e5e7eb;
    }

    .message-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .message-input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 25px;
        padding: 11px 18px;
        outline: none;
        font-size: 14px;
        resize: none;
        min-height: 45px;
        max-height: 100px;
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
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: .2s;
    }

    .send-button:hover {
        background: #1d4ed8;
        transform: scale(1.03);
    }

    .send-button:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    /* ==============================
       DATE
    ============================== */

    .chat-date {
        text-align: center;
        margin: 15px 0;
        color: #94a3b8;
        font-size: 11px;
    }

    /* ==============================
       MOBILE
    ============================== */

    @media(max-width: 768px) {

        .chat-container {
            width: 100%;
        }

        .chat-card {
            height: calc(100vh - 100px);
            border-radius: 10px;
        }

        .chat-body {
            padding: 15px;
        }

        .message {
            max-width: 82%;
        }

    }
</style>


<div class="chat-container">

    {{-- =========================================
         CHAT CARD
    ========================================== --}}

    <div class="chat-card">

        {{-- =========================================
             HEADER
        ========================================== --}}

        <div class="chat-header">

            <div class="admin-avatar">

                <i class="bi bi-person-fill"></i>

            </div>

            <div class="admin-info">

                <h5>
                    @if($admin)
                        {{ $admin->firstname }}
                        {{ $admin->lastname }}
                    @else
                        Administrator
                    @endif
                </h5>

                <span>
                    <span class="online-dot"></span>
                    Administrator
                </span>

            </div>

        </div>


        {{-- =========================================
             CHAT BODY
        ========================================== --}}

        <div
            class="chat-body"
            id="chatBody"
        >

            @if($messages->isEmpty())

                <div class="empty-chat">

                    <div>

                        <i class="bi bi-chat-dots"></i>

                        <h6>
                            Start a conversation
                        </h6>

                        <p>
                            Send a message to the administrator.
                        </p>

                    </div>

                </div>

            @else

                @php
                    $lastDate = null;
                @endphp

                @foreach($messages as $message)

                    {{-- DATE SEPARATOR --}}

                    @if(
                        $lastDate !==
                        $message->created_at->format('Y-m-d')
                    )

                        <div class="chat-date">

                            {{ $message->created_at->format('d F Y') }}

                        </div>

                        @php
                            $lastDate =
                                $message->created_at->format('Y-m-d');
                        @endphp

                    @endif


                    {{-- MESSAGE --}}

                    <div
                        class="message-wrapper
                        {{ $message->sender_type === 'student'
                            ? 'student'
                            : 'admin' }}"
                    >

                        <div
                            class="message
                            {{ $message->sender_type === 'student'
                                ? 'student-message'
                                : 'admin-message' }}"
                        >

                            {{ $message->message }}

                            <span class="message-time">

                                {{ $message->created_at->format('h:i A') }}

                                @if($message->sender_type === 'student')

                                    <span class="message-status">

                                        @if($message->is_read)

                                            <i class="bi bi-check2-all"></i>

                                        @else

                                            <i class="bi bi-check2"></i>

                                        @endif

                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>

                @endforeach

            @endif

        </div>


        {{-- =========================================
             CHAT FOOTER
        ========================================== --}}

        <div class="chat-footer">

            <form
                action="{{ route('student.chat.send') }}"
                method="POST"
                class="message-form"
                id="messageForm"
            >

                @csrf

                <textarea
                    name="message"
                    id="messageInput"
                    class="message-input"
                    placeholder="Write a message..."
                    rows="1"
                    required
                ></textarea>


                <button
                    type="submit"
                    class="send-button"
                    id="sendButton"
                    title="Send message"
                >

                    <i class="bi bi-send-fill"></i>

                </button>

            </form>

        </div>

    </div>

</div>


{{-- =========================================
     JAVASCRIPT
========================================== --}}

<script>

    const chatBody = document.getElementById('chatBody');

    const messageInput =
        document.getElementById('messageInput');

    const messageForm =
        document.getElementById('messageForm');


    /*
    =========================================
    SCROLL CHAT TO BOTTOM
    =========================================
    */

    function scrollChatToBottom() {

        chatBody.scrollTop =
            chatBody.scrollHeight;

    }


    /*
    =========================================
    INITIAL SCROLL
    =========================================
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            scrollChatToBottom();

        }
    );


    /*
    =========================================
    ENTER TO SEND
    SHIFT + ENTER = NEW LINE
    =========================================
    */

    messageInput.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Enter' &&
                !event.shiftKey
            ) {

                event.preventDefault();

                if (messageInput.value.trim() !== '') {

                    messageForm.submit();

                }

            }

        }
    );


    /*
    =========================================
    AUTO RESIZE TEXTAREA
    =========================================
    */

    messageInput.addEventListener(
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

