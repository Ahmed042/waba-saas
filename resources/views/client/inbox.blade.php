@extends('client.app')

@section('content')
<style>
.whatsapp-app-bg {
    background: #ece5dd;
    min-height: 80vh;
}
.wa-sidebar {
    background: #f8f9fa;
    border-right: 1px solid #e3e6ea;
    min-height: 75vh;
    max-height: 80vh;
    overflow-y: auto;
}
.wa-sidebar .active {
    background: #e1f3fb !important;
}
.wa-chat-main {
    background: #ece5dd;
    min-height: 75vh;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}
.wa-chat-header {
    background: #075e54;
    color: #fff;
    padding: 16px 20px;
    border-top-right-radius: 8px;
    border-top-left-radius: 8px;
    min-height: 62px;
    display: flex;
    align-items: center;
}
.wa-chat-messages {
    padding: 24px;
    flex: 1;
    overflow-y: auto;
    background: #ece5dd;
}
.wa-msg-bubble {
    max-width: 70%;
    padding: 8px 16px;
    border-radius: 18px;
    margin-bottom: 8px;
    font-size: 15px;
    word-break: break-word;
    position: relative;
    min-width: 64px;
}
.wa-msg-sent {
    background: #dcf8c6;
    align-self: flex-end;
    margin-left: auto;
}
.wa-msg-received {
    background: #fff;
    border: 1px solid #d1d7db;
    align-self: flex-start;
    margin-right: auto;
}
.wa-msg-time {
    font-size: 11px;
    color: #a9a9a9;
    position: absolute;
    right: 8px;
    bottom: 2px;
}
.wa-chat-input {
    background: #f7f9fa;
    padding: 14px 18px;
    border-bottom-right-radius: 8px;
    border-bottom-left-radius: 8px;
    border-top: 1px solid #eee;
}
</style>
<div class="whatsapp-app-bg rounded-4 shadow-sm" style="overflow:hidden;">
    <div class="row gx-0">
        <!-- Sidebar (Chats List) -->
        <div class="col-12 col-md-4 wa-sidebar">
            <div class="px-3 py-2">
                <input type="text" class="form-control mb-3" placeholder="Search or start new chat" style="border-radius:20px;">
                @foreach($contacts as $contact)
                    @php
                        $lastMsg = $contact->messages->first();
                        $isActive = isset($selectedContact) && $selectedContact && $selectedContact->id == $contact->id;
                    @endphp
                    <a href="{{ route('client.inbox.chat', ['company'=>$company, 'contact'=>$contact->id]) }}"
                       class="d-flex align-items-center py-2 px-2 mb-1 rounded-3 text-decoration-none {{ $isActive ? 'active' : '' }}">
                        <div class="me-3">
                            <span class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:38px;height:38px;font-size:18px;">
                                <i class="bi bi-person"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <div class="fw-bold small">{{ $contact->name ?: $contact->phone }}</div>
                            <div class="text-muted small" style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->message, 30) : '' }}
                            </div>
                        </div>
                        <div class="ms-2 text-muted small" style="min-width:44px;">
                            {{ $lastMsg ? $lastMsg->created_at->format('H:i') : '' }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat area -->
        <div class="col-12 col-md-8 wa-chat-main d-flex flex-column">
            @if(!$selectedContact)
                <div class="h-100 d-flex flex-column justify-content-center align-items-center" style="min-height:60vh;">
                    <i class="bi bi-whatsapp" style="font-size:54px;color:#22d165;"></i>
                    <div class="fs-4 fw-bold mt-2">Select a chat to start messaging</div>
                    <div class="text-muted mt-1">Your conversations appear here.</div>
                </div>
            @else
                <!-- Chat Header -->
                <div class="wa-chat-header">
                    <div class="fw-bold fs-5">{{ $selectedContact->name ?: $selectedContact->phone }}</div>
                    <span class="ms-3 text-light small">{{ $selectedContact->phone }}</span>
                </div>
                <!-- Messages -->
                <div class="wa-chat-messages d-flex flex-column">
                    @foreach($messages as $msg)
                        <div class="wa-msg-bubble {{ $msg->direction == 'sent' ? 'wa-msg-sent' : 'wa-msg-received' }}">
                            <span>{{ $msg->message }}</span>
                            <span class="wa-msg-time">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    @endforeach
                </div>
                <!-- Input -->
                <div class="wa-chat-input">
                    <form class="d-flex" method="POST" action="{{ route('client.inbox.chat.send', ['company'=>$company, 'contact'=>$selectedContact->id]) }}">
                        @csrf
                        <input type="text" name="message" class="form-control me-2" style="border-radius:18px;" required maxlength="2000" placeholder="Type a message...">
                        <button class="btn btn-success" style="border-radius:50%;width:44px;height:44px;" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
