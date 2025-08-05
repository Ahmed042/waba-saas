@extends('client.app-no-sidebar')

@section('content')
<!-- Gantari Font -->
<link href="https://fonts.googleapis.com/css2?family=Gantari:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    
html, body {
  height: 100%;
  min-height: 100vh;
  margin: 0;
  padding: 0;
}
body { font-family: 'Gantari', sans-serif; background: #ece5dd !important; }

.wa-app-container {
    display: flex;
    height: 100vh;
    background: #ece5dd !important;
}
.wa-mini-sidebar {
    width: 60px; background: #202c33;
    min-height: 100vh; padding: 10px 0; border-right: 1.5px solid #181f24;
    z-index: 20; box-shadow: 0 0 8px #191c2020;
    display: flex; flex-direction: column; align-items: center;
}
.wa-mini-sidebar-icon {
    width: 38px; height: 38px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 6px;
    font-size: 1.25em;
    color: #aebac1;
    border-radius: 12px;
    transition: background 0.16s, color 0.15s;
    text-decoration: none; position: relative;
}
.wa-mini-sidebar-icon.active,
.wa-mini-sidebar-icon:hover { background: #111b21; color: #25d366; }
.wa-mini-sidebar-icon[title]:hover:after {
    content: attr(title);
    position: absolute;
    left: 48px;
    background: #232d32;
    color: #e9edef;
    font-size: 0.92em;
    padding: 4px 11px;
    border-radius: 6px;
    white-space: nowrap;
    z-index: 50;
    top: 50%;
    transform: translateY(-50%);
    box-shadow: 0 2px 12px #1116;
    pointer-events: none;
    opacity: 1;
}
.wa-mini-divider {
    border: 0; height: 1.5px; background: #232d32; width: 64%; margin: 9px 0;
}

.wa-sidebar {
    width: 320px;
    background: #fff;
    border-right: 1px solid #ece5dd;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    z-index: 10;
}
.wa-sidebar-header { display: flex; align-items: center; justify-content: space-between;
    padding: 16px 16px 11px 16px; border-bottom: 1px solid #ece5dd; background: #f7f8fa;
}
.wa-profile-img {
    width: 39px; height: 39px; border-radius: 50%; object-fit: cover; background: #e1e6ea;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.05em; font-weight: 600; color: #7a869a;
}
.wa-profile-img.wa-initials {
    background: linear-gradient(135deg, #dbeafe 0%, #d1fae5 100%);
    color: #1e293b; font-size: 1.15em;
}
.wa-sidebar-header .wa-actions i { font-size: 1.06em; margin-left: 13px; color: #54656f; cursor: pointer; transition: color 0.15s; }
.wa-sidebar-header .wa-actions i:hover { color: #25d366; }
.wa-search-bar { padding: 7px 16px; background: #f6f6f6; border-bottom: 1px solid #ece5dd; position: relative; }
.wa-search-bar input {
    border-radius: 19px; border: none; background: #f0f2f5;
    padding: 8px 32px 8px 13px; font-size: 12px; width: 100%; outline: none;
    font-family: 'Gantari', sans-serif;
}
.wa-search-bar .bi-search { position: absolute; right: 22px; top: 15px; color: #bdbdbd; font-size: 1.08em; }
.wa-chats-list {
    flex: 1 1 auto;
    overflow-y: auto;
    background: #fff;
    /* Optional: nice scrolling */
    scrollbar-width: thin;
    scrollbar-color: #bdbdbd #f0f2f5;
}
.wa-chats-list::-webkit-scrollbar {
    width: 6px;
    background: #f0f2f5;
}
.wa-chats-list::-webkit-scrollbar-thumb {
    background: #bdbdbd;
    border-radius: 6px;
}

.wa-chat-list-item {
    display: flex; align-items: center; padding: 9px 15px; cursor: pointer;
    transition: background 0.18s; border-bottom: 1px solid #f5f5f5; text-decoration: none; font-size: 12px;
}
.wa-chat-list-item.active, .wa-chat-list-item:hover { background: #f0f2f5; }
.wa-chat-avatar {
    width: 35px; height: 35px; border-radius: 50%; object-fit: cover; background: #e1e6ea;
    margin-right: 10px; font-size: 1.05em; display: flex; align-items: center; justify-content: center;
    font-weight: 600; color: #7a869a;
}
.wa-chat-avatar.wa-initials {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%);
    color: #4b5563; font-size: 1em;
}
.wa-chat-list-details { flex: 1; min-width: 0; }
.wa-chat-list-title {
    font-weight: 600; font-size: 12px; color: #212529;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.wa-chat-list-lastmsg {
    font-size: 12px; color: #6a7076; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.wa-chat-list-time { font-size: 10.8px; color: #7c8b96; text-align: right; }
.wa-chat-list-unread {
    background: #25d366; color: #fff; font-size: 10px; border-radius: 12px; padding: 1px 7px; margin-left: 4px; min-width: 18px; text-align: center;
}
@media (max-width: 900px) {
    .wa-sidebar { width: 98vw; min-width: 0; max-width: 100vw; }
    .wa-mini-sidebar { width: 45px; }
    .wa-mini-sidebar-icon { width: 32px; height: 32px; font-size: 1em; }
    .wa-mini-sidebar-icon[title]:hover:after { left: 38px; }
}


.wa-chat-header { 
    display: flex; align-items: center; padding: 13px 24px; background: #075e54;
    color: #fff; min-height: 62px; border-bottom: 1px solid #056244;
    font-size: 13px;
}
.wa-chat-header .wa-chat-avatar {
    width: 35px; height: 35px; border-radius: 50%; background: #e1e6ea; margin-right: 12px;
    font-size: 1em; display: flex; align-items: center; justify-content: center;
    font-weight: 600; color: #7a869a;
}
.wa-chat-header .wa-chat-avatar.wa-initials {
    background: linear-gradient(135deg, #f0fdf4 0%, #e0e7ff 100%);
    color: #134a2c; font-size: 1.05em;
}
.wa-chat-header .wa-chat-title { font-weight: 600; font-size: 13px; }
.wa-chat-header .wa-chat-phone { font-size: 11.5px; opacity: 0.83; margin-left: 12px; }
.wa-chat-header .bi-search { margin-left: auto; cursor: pointer; font-size: 1.1em; opacity: 0.9; transition: color 0.14s; }
.wa-chat-header .bi-search:hover { color: #25d366; }

.wa-chat-main {
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
    min-width: 0;
    min-height: 0;
}

.wa-chat-messages {
    flex: 1 1 0;
    min-height: 0;
    overflow-y: auto !important;
    padding: 20px 18px 18px 18px;
 
    flex-direction: column;
    justify-content: flex-end;
    font-size: 13px;
    font-family: 'Gantari', sans-serif;
}




.wa-msg-row { display: flex; margin-bottom: 4px; }
.wa-msg-row.sent { justify-content: flex-end; }
.wa-msg-row.received { justify-content: flex-start; }
.wa-msg-bubble {
    max-width: 55vw;
    padding: 10px 46px 18px 14px;
    border-radius: 15px;
    font-size: 13px;
    word-break: break-word;
    position: relative;
    margin-bottom: 8px;
    background: #fff;
    color: #202c33;
    min-width: 38px;
    box-shadow: 0 1px 5px #1111;
    font-family: 'Gantari', sans-serif;
    display: inline-block;
    line-height: 1.5;
    vertical-align: bottom;
    border: 1px solid #e6e6e6;
}
.wa-msg-row.sent .wa-msg-bubble {
    background: #d1f8c6;
    color: #134a2c;
    align-self: flex-end;
    border: none;
}
.wa-msg-meta {
    position: absolute;
    right: 14px;
    bottom: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.wa-msg-time {
    font-size: 10px;
    color: #778f9b;
    font-family: 'Gantari', sans-serif;
    white-space: nowrap;
    letter-spacing: 0.01em;
    margin: 0;
    padding: 0;
}
.wa-msg-tick {
    font-size: 1.12em;
    color: #7bb9a8;
    opacity: 0.9;
    margin-left: 2px;
}
.wa-msg-tick.double { color: #21b88a; }

.wa-chat-input-bar {
    background: #f7f9fa;
    padding: 11px 18px;
    border-top: 1px solid #ece5dd;
    display: flex;
    align-items: center;
    min-height: 56px;
    box-shadow: 0 -2px 16px #bff8c122;
    z-index: 1;
    gap: 10px;
}
.wa-chat-input-bar .form-control {
    border-radius: 21px;
    background: #f3f8fa;
    border: 1.3px solid #e3ebe7;
    font-size: 13px;
    box-shadow: none;
    margin-right: 8px;
    font-family: 'Gantari', sans-serif;
    padding: 11px 16px;
    height: 40px;
    transition: border .14s;
}
.wa-chat-input-bar .form-control:focus {
    border: 1.6px solid #25d366;
    outline: none;
}
.wa-chat-input-bar i {
    color: #7c8b96;
    font-size: 1.08em;
    margin: 0 3px;
    cursor: pointer;
}
.wa-send-btn {
    border-radius: 50%;
    width: 38px;
    height: 38px;
    background: linear-gradient(120deg,#25d366 0,#4be5ab 100%);
    color: #fff;
    font-size: 1.18em;
    border: none;
    box-shadow: 0 2px 12px #19d17e33;
    transition: background 0.15s, box-shadow 0.18s;
    display: flex;
    align-items: center;
    justify-content: center;
    outline: none;
}
.wa-send-btn:hover, .wa-send-btn:focus {
    background: linear-gradient(120deg,#1ebea5 0,#0bc18b 100%);
    box-shadow: 0 2px 18px #25d36633;
}
.wa-actions .dropdown-item:hover {
    background: #f1f3f4;
}


</style>

<style>
 body.wa-dark .wa-chat-main {
    background: #181818 !important;
}
body.wa-dark .wa-chat-messages {
    background: #181818 !important;
    color: #fff !important;
}
body.wa-dark .wa-chat-header {
    background: #111 !important;
    color: #fff !important;
}
body.wa-dark .wa-msg-bubble {
    background: #232323 !important;
    color: #fff !important;
    border: 1px solid #222 !important;
}
body.wa-dark .wa-msg-row.sent .wa-msg-bubble {
    background: #204c32 !important;
    color: #d2ffd0 !important;
    border: none !important;
}
body.wa-dark .wa-chat-input-bar {
    background: #181818 !important;
    border-color: #222 !important;
}
body.wa-dark .wa-chat-input-bar .form-control {
    background: #232323 !important;
    color: #fff !important;
    border: 1.2px solid #444 !important;
}
body.wa-dark .wa-sidebar {
    background: #15191c !important;
    color: #fff !important;
    border-color: #111 !important;
}
body.wa-dark .wa-chats-list {
    background: #15191c !important;
}
body.wa-dark .wa-search-bar {
    background: #181b1e !important;
    border-color: #222 !important;
}
body.wa-dark .wa-search-bar input {
    background: #23272b !important;
    color: #fff !important;
    border: none !important;
}
body.wa-dark .wa-chat-list-item,
body.wa-dark .wa-chat-list-item.active,
body.wa-dark .wa-chat-list-item:hover {
    background: #181b1e !important;
    color: #fff !important;
}
body.wa-dark .wa-chat-list-title,
body.wa-dark .wa-chat-list-lastmsg,
body.wa-dark .wa-chat-list-time {
    color: #fff !important;
}
body.wa-dark .wa-chat-list-unread {
    background: #25d366 !important;
    color: #232323 !important;
}
body.wa-dark .wa-profile-img,
body.wa-dark .wa-profile-img.wa-initials {
    background: #20272c !important;
    color: #fff !important;
}
body.wa-dark .wa-chat-avatar,
body.wa-dark .wa-chat-avatar.wa-initials {
    background: #22282e !important;
    color: #fff !important;
}
body.wa-dark .wa-sidebar-header {
    background: #181b1e !important;
    border-bottom: 1px solid #232323 !important;
}
body.wa-dark #waHeaderMenuDropdown {
    background: #222 !important;
    color: #fff !important;
    box-shadow: 0 2px 16px #0009 !important;
}
body.wa-dark #waHeaderMenuDropdown .dropdown-item {
    color: #fff !important;
    background: transparent !important;
}
body.wa-dark #waHeaderMenuDropdown .dropdown-item:hover {
    background: #2a2a2a !important;
    color: #25d366 !important;
}
body.wa-dark #waHeaderMenuDropdown i {
    color: #bdbdbd !important;
}

</style>

<div class="wa-app-container">

    <!-- MINI SIDEBAR -->
    <div class="wa-mini-sidebar">
        <a href="/{{ $company }}/dashboard" class="wa-mini-sidebar-icon{{ request()->is("$company/dashboard") ? ' active' : '' }}" title="Dashboard">
            <i class="bi bi-bar-chart-line"></i>
        </a>
        <a href="/{{ $company }}/contacts" class="wa-mini-sidebar-icon{{ request()->is("$company/contacts") ? ' active' : '' }}" title="Contacts">
            <i class="bi bi-person-lines-fill"></i>
        </a>
        <a href="/{{ $company }}/lists" class="wa-mini-sidebar-icon{{ request()->is("$company/lists") ? ' active' : '' }}" title="Lists & Segments">
            <i class="bi bi-diagram-3"></i>
        </a>
        <a href="/{{ $company }}/send-message" class="wa-mini-sidebar-icon{{ request()->is("$company/send-message") ? ' active' : '' }}" title="Send Message">
            <i class="bi bi-send"></i>
        </a>
        <a href="/{{ $company }}/templates" class="wa-mini-sidebar-icon{{ request()->is("$company/templates") ? ' active' : '' }}" title="Templates">
            <i class="bi bi-collection"></i>
        </a>
        <a href="/{{ $company }}/inbox" class="wa-mini-sidebar-icon{{ request()->is("$company/inbox") ? ' active' : '' }}" title="Inbox">
            <i class="bi bi-chat-dots"></i>
        </a>
        <hr class="wa-mini-divider" />
        <a href="/{{ $company }}/usage" class="wa-mini-sidebar-icon{{ request()->is("$company/usage") ? ' active' : '' }}" title="Usage & Quota">
            <i class="bi bi-pie-chart"></i>
        </a>
        <a href="/{{ $company }}/audit-logs" class="wa-mini-sidebar-icon{{ request()->is("$company/audit-logs") ? ' active' : '' }}" title="Audit Logs">
            <i class="bi bi-list-check"></i>
        </a>
        <hr class="wa-mini-divider" />
        <a href="/{{ $company }}/settings" class="wa-mini-sidebar-icon{{ request()->is("$company/settings") ? ' active' : '' }}" title="Settings">
            <i class="bi bi-gear"></i>
        </a>
        <a href="/{{ $company }}/logout" class="wa-mini-sidebar-icon" title="Logout">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>

    <!-- SIDEBAR HEADER + CHAT LIST -->
    <div class="wa-sidebar">
        <div class="wa-sidebar-header wa-sidebar-brand">
            {{-- Profile or initials --}}
            @php
                $img = $user->avatar ?? null;
                $userInitials = isset($user->name) && $user->name ? strtoupper(collect(explode(' ', $user->name))->map(fn($w)=>$w[0])->implode('')) : 'U';
            @endphp
            @if($img)
                <img src="{{ $img }}" class="wa-profile-img" alt="Profile" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="wa-profile-img wa-initials" style="display:none;">{{ $userInitials }}</div>
            @else
                <div class="wa-profile-img wa-initials">{{ $userInitials }}</div>
            @endif
           <div class="wa-actions position-relative">
   
<a href="/{{ $company }}/send-message">
    <i class="bi bi-chat-dots"></i>
</a>
    
    <i class="bi bi-three-dots-vertical" id="waMenuToggle" style="cursor:pointer;"></i>
    <!-- Dropdown -->
    <div id="waHeaderMenuDropdown" style="display:none; position:absolute; right:0; top:40px; background:#fff; min-width:160px; box-shadow:0 2px 16px #0002; border-radius:10px; z-index:100; font-size:13px;">
        <div class="dropdown-item" id="toggleDarkMode" style="cursor:pointer; padding:11px 16px;">
            <i class="bi bi-moon me-2"></i>
            <span id="darkModeLabel">Dark Mode</span>
        </div>
        <div class="dropdown-item" style="cursor:pointer; padding:11px 16px;" onclick="location.href='/{{ $company }}/settings';">
            <i class="bi bi-gear me-2"></i> Settings
        </div>
        <div class="dropdown-item" style="cursor:pointer; padding:11px 16px;" onclick="location.href='/{{ $company }}/logout';">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </div>
    </div>
</div>

        </div>

        <div class="wa-search-bar" >
            <input type="text" placeholder="Search Chat Name" autocomplete="off" id="waSidebarSearch">
            <i class="bi bi-search"></i>
        </div>

        <div class="wa-chats-list" id="waChatsList">
            @forelse($contacts as $contact)
                @php
                    $lastMsg = $contact->messages->first();
                    $isActive = isset($selectedContact) && $selectedContact && $selectedContact->id == $contact->id;
                    $avatar = $contact->avatar ?? null;
                    $contactInitials = isset($contact->name) && $contact->name ? strtoupper(collect(explode(' ', $contact->name))->map(fn($w)=>$w[0])->implode('')) : 'U';
                @endphp
                <a href="{{ route('client.inbox.chat', ['company'=>$company, 'contact'=>$contact->id]) }}"
                   class="wa-chat-list-item{{ $isActive ? ' active' : '' }}">
                    @if($avatar)
                        <img src="{{ $avatar }}" class="wa-chat-avatar" alt="Avatar" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                        <div class="wa-chat-avatar wa-initials" style="display:none;">{{ $contactInitials }}</div>
                    @else
                        <div class="wa-chat-avatar wa-initials">{{ $contactInitials }}</div>
                    @endif
                    <div class="wa-chat-list-details">
                        <div class="wa-chat-list-title">{{ $contact->name ?: $contact->phone }}</div>
                        <div class="wa-chat-list-lastmsg">
                            {{ $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->message, 32) : '' }}
                        </div>
                    </div>
                    <div>
                        <div class="wa-chat-list-time">{{ $lastMsg ? $lastMsg->created_at->format('g:i a') : '' }}</div>
                        @if($lastMsg && $lastMsg->is_unread)
                            <div class="wa-chat-list-unread">{{ $lastMsg->unread_count ?? 1 }}</div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-4 text-muted text-center" style="font-size:12px;">No chats yet.</div>
            @endforelse
        </div>
    </div>

    <!-- CHAT VIEW -->
    <div class="wa-chat-main">
        @if(empty($selectedContact))
            <div class="h-100 d-flex flex-column justify-content-center align-items-center" style="min-height:65vh;">
                <i class="bi bi-whatsapp" style="font-size:54px;color:#25d366;"></i>
                <div class="fw-bold mt-3" style="color:#15a073; font-size:17px;">Select a chat to start messaging</div>
                <div class="text-muted mt-1" style="font-size:12px;">Your conversations appear here in real time.</div>
            </div>
        @else
            {{-- Chat Header --}}
            <div class="wa-chat-header">
                @php
                    $img = $selectedContact->avatar ?? null;
                    $contactInitials = isset($selectedContact->name) && $selectedContact->name ? strtoupper(collect(explode(' ', $selectedContact->name))->map(fn($w)=>$w[0])->implode('')) : 'U';
                @endphp
                @if($img)
                    <img src="{{ $img }}" class="wa-chat-avatar" alt="Avatar" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="wa-chat-avatar wa-initials" style="display:none;">{{ $contactInitials }}</div>
                @else
                    <div class="wa-chat-avatar wa-initials">{{ $contactInitials }}</div>
                @endif
                <div class="wa-chat-title">{{ $selectedContact->name ?: $selectedContact->phone }}</div>
                <div class="wa-chat-phone">{{ $selectedContact->phone }}</div>
              
            </div>

            {{-- Messages --}}
           <div class="wa-chat-messages" id="waMessages">
    @include('partials.chat-messages', ['messages' => $messages])
</div>


            {{-- Input Bar --}}
          <form id="waChatForm" class="wa-chat-input-bar" method="POST" action="{{ route('client.inbox.chat.send', ['company'=>$company, 'contact'=>$selectedContact->id]) }}">
                @csrf
              <span id="emojiBtn" style="position:relative;display:inline-block;">
    <i class="bi bi-emoji-smile"></i>
</span>
<span id="fileBtn" style="position:relative;display:inline-block;">
    <i class="bi bi-paperclip"></i>
    <input type="file" id="waFileInput" name="file" style="display:none;" />
</span>
<input type="text" name="message" class="form-control" required maxlength="2000" autocomplete="off" placeholder="Type a message..." id="waMessageInput">
 <button class="wa-send-btn" type="submit">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        @endif
    </div>
</div>
<!-- Emoji Button Picker (https://emoji-button.js.org/) -->
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/emoji-button.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
function scrollToBottom() {
    var box = document.getElementById('waMessages');
    if(box) box.scrollTop = box.scrollHeight;
}

$(document).ready(function() {
    // AJAX message send
        scrollToBottom(); 

    $('#waChatForm').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var messageInput = $form.find('input[name="message"]');
        var message = messageInput.val();
        var url = $form.attr('action');
        var token = $form.find('input[name="_token"]').val();

        if (!message.trim()) return;

        $form.find('button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                message: message
            },
            success: function(response) {
                // Just clear input and let polling reload messages
                messageInput.val('');
                scrollToBottom();
            },
            error: function(xhr) {
    alert('Error sending message!\n' + xhr.status + '\n' + xhr.responseText);
},

            complete: function() {
                $form.find('button[type="submit"]').prop('disabled', false);
            }
        });
    });

    // Live polling for new messages
    setInterval(fetchNewMessages, 4000);

    function fetchNewMessages() {
        var company = @json($company);
        var contactId = @json($selectedContact->id ?? null);
        if(!contactId) return;

        fetch(`/${company}/inbox/contact/${contactId}/messages`)
            .then(response => response.json())
            .then(data => {
                var msgBox = document.getElementById('waMessages');
                if(data.html) {
                    msgBox.innerHTML = data.html;
                    scrollToBottom();
                }
            });
    }
    
});
</script>

<script>
    $(document).ready(function(){
    // Dropdown toggle
    $('#waMenuToggle').on('click', function(e){
        e.stopPropagation();
        $('#waHeaderMenuDropdown').toggle();
    });

    // Hide dropdown on click outside
    $(document).on('click', function(){
        $('#waHeaderMenuDropdown').hide();
    });

    // Dark Mode toggle logic
    function setDarkMode(enabled) {
        if(enabled) {
            $('body').addClass('wa-dark');
            $('#darkModeLabel').text('Light Mode');
            $('#toggleDarkMode i').removeClass('bi-moon').addClass('bi-brightness-high');
            localStorage.setItem('wa-theme', 'dark');
        } else {
            $('body').removeClass('wa-dark');
            $('#darkModeLabel').text('Dark Mode');
            $('#toggleDarkMode i').removeClass('bi-brightness-high').addClass('bi-moon');
            localStorage.setItem('wa-theme', 'light');
        }
    }

    // On click dark mode toggle
    $('#toggleDarkMode').on('click', function(e){
        e.stopPropagation();
        const dark = !$('body').hasClass('wa-dark');
        setDarkMode(dark);
    });

    // Persist theme
    if(localStorage.getItem('wa-theme') === 'dark') setDarkMode(true);
    else setDarkMode(false);
});

</script>
@endsection
