<div class="wa-msg-row {{ $msg->direction == 'sent' ? 'sent' : 'received' }}">
    <div class="wa-msg-bubble">
        @if($msg->message)
            <span>{{ $msg->message }}</span>
        @endif

      @if($msg->audio)
    <div style="margin-top: 7px;">
        <audio controls style="width: 180px;">
            <source src="
                @if(Str::startsWith($msg->audio, ['http://', 'https://']))
                    {{ $msg->audio }}
                @elseif(strlen($msg->audio) > 40)
                    {{ route('client.audio.fetch', [$company, $msg->audio]) }}
                @else
                    {{ asset('storage/'.$msg->audio) }}
                @endif
            ">
            Your browser does not support the audio element.
        </audio>
    </div>
@endif


        <span class="wa-msg-meta">
            <span class="wa-msg-time">{{ $msg->created_at->format('g:i a') }}</span>
            @if($msg->direction == 'sent')
                @if($msg->status == 'sent')
                    <span class="wa-msg-tick"><i class="bi bi-check-lg"></i></span>
                @elseif($msg->status == 'delivered' || $msg->status == 'read')
                    <span class="wa-msg-tick double"><i class="bi bi-check2-all"></i></span>
                @endif
            @endif
        </span>
    </div>
</div>
