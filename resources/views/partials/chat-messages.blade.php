@php use Illuminate\Support\Str; @endphp

@foreach($messages as $msg)
    <div class="wa-msg-row {{ $msg->direction == 'sent' ? 'sent' : 'received' }}">
        <div class="wa-msg-bubble">

            {{-- Render audio if present in the audio column --}}
            @if($msg->audio)
                <div class="audio-player-wrapper" style="display: flex; align-items: center; gap: 10px; margin-top: 7px;">
                {{-- Debug: Show audio path --}}
<p style="font-size:12px;color:#999;">
    Audio Source: 
    {{ Str::startsWith($msg->audio, ['http://', 'https://']) ? $msg->audio : asset('storage/'.$msg->audio) }}
</p>
  
                <audio controls style="width: 180px; border-radius: 9px; box-shadow: 0 2px 10px #ececec;" 
                        class="wa-audio" onloadedmetadata="displayDuration(this)">
                        <source src="{{ Str::startsWith($msg->audio, ['http://', 'https://']) ? $msg->audio : asset('storage/'.$msg->audio) }}">
                        Your browser does not support the audio element.
                    </audio>
                    <span class="audio-duration" style="font-size: 0.92em; color: #888;"></span>
                </div>
            @elseif($msg->message)
                {{-- Text Message --}}
                <span>{{ $msg->message }}</span>
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
@endforeach

{{-- ===== Script for displaying audio duration ===== --}}
<script>
    function displayDuration(audioElem) {
        // Find the next sibling with class 'audio-duration'
        const durationElem = audioElem.closest('.audio-player-wrapper').querySelector('.audio-duration');
        if (audioElem.duration && durationElem) {
            let min = Math.floor(audioElem.duration / 60);
            let sec = Math.floor(audioElem.duration % 60);
            durationElem.textContent = min + ':' + sec.toString().padStart(2, '0');
        }
    }
</script>

{{-- ===== Optional: Extra minimal styling for a more beautiful player ===== --}}
<style>
audio::-webkit-media-controls-panel {
    background-color: #faf8f6;
    border-radius: 10px;
}
audio {
    border-radius: 9px;
    box-shadow: 0 2px 10px #ececec;
}
</style>
