
@extends('layout.app')

@section('content')

<style>

    .chat-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .chat-list-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
    }

    .chat-list-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .chat-list-header h4 {
        margin: 0;
        font-weight: 700;
        color: #111827;
    }

    .chat-list-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .student-chat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 17px 22px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        color: inherit;
        transition: .2s;
    }

    .student-chat-item:hover {
        background: #f8fafc;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 50%;
        background: #2563eb;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .student-chat-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }

    .latest-message {
        margin-top: 4px;
        color: #64748b;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 600px;
    }

    .chat-meta {
        text-align: right;
        min-width: 70px;
    }

    .message-time {
        font-size: 11px;
        color: #94a3b8;
    }

    .unread-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        padding: 0 6px;
        margin-top: 5px;
        border-radius: 50px;
        background: #dc2626;
        color: white;
        font-size: 11px;
        font-weight: 700;
    }

    .empty-chats {
        padding: 70px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-chats i {
        font-size: 50px;
        color: #94a3b8;
    }

    .empty-chats h5 {
        margin-top: 12px;
        color: #334155;
        font-weight: 700;
    }

    @media(max-width: 768px) {

        .student-chat-item {
            padding: 14px;
        }

        .latest-message {
            max-width: 200px;
        }

        .student-avatar {
            width: 42px;
            height: 42px;
            min-width: 42px;
        }
    }

</style>


<div class="chat-page">

    <div class="chat-list-card">

        {{-- HEADER --}}

        <div class="chat-list-header">

            <h4>
                <i class="bi bi-chat-dots me-2"></i>
                Student Messages
            </h4>

            <p>
                View and respond to messages from students.
            </p>

        </div>


        {{-- CHAT LIST --}}

        @if(count($chatStudents) > 0)

            @foreach($chatStudents as $chat)

                @php

                    $student = $chat['student'];

                    $latestMessage =
                        $chat['latest_message'];

                    $unreadCount =
                        $chat['unread_count'];

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


                <a
                    href="{{ route(
                        'admin.chat',
                        $student->id
                    ) }}"
                    class="student-chat-item"
                >

                    {{-- AVATAR --}}

                    <div class="student-avatar">

                        {{ $initials }}

                    </div>


                    {{-- INFORMATION --}}

                    <div class="student-chat-info">

                        <div class="student-name">

                            {{ $student->firstname }}
                            {{ $student->middlename }}
                            {{ $student->lastname }}

                        </div>


                        @if($latestMessage)

                            <div class="latest-message">

                                @if(
                                    $latestMessage->sender_type
                                    === 'admin'
                                )
                                    You:
                                @endif

                                {{ $latestMessage->message }}

                            </div>

                        @else

                            <div class="latest-message">
                                No messages yet
                            </div>

                        @endif

                    </div>


                    {{-- META --}}

                    <div class="chat-meta">

                        @if($latestMessage)

                            <div class="message-time">

                                {{ $latestMessage
                                    ->created_at
                                    ->format('h:i A') }}

                            </div>

                        @endif


                        @if($unreadCount > 0)

                            <span class="unread-badge">

                                {{ $unreadCount }}

                            </span>

                        @endif

                    </div>

                </a>

            @endforeach

        @else

            <div class="empty-chats">

                <i class="bi bi-chat-square-text"></i>

                <h5>
                    No messages yet
                </h5>

                <p>
                    Students who send you messages
                    will appear here.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection

