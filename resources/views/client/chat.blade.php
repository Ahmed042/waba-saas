@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <a href="/{{ $company }}/inbox" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back to Inbox
    </a>
    <div class="card border-0 shadow-sm rounded-4" style="max-width:540px;margin:auto;">
        <div class="card-header bg-light d-flex align-items-center">
            <div class="fw-bold fs-5">{{ $contact->name ?: '(No Name)' }}</div>
            <div class="text-muted ms-3">{{ $contact->phone }}</div>
        </div>
        <div class="card-body p-3" style="background:#f7f9fa;min-height:370px;max-height:400px;overflow-y:auto;">
            @foreach($messages as $msg)
                @if($msg->direction === 'sent')
                    <div class="d-flex justify-content-end mb-2">
                        <div class="bg-primary text-white rounded-4 px-3 py-2" style="max-width:70%;">
                            <div class="small">{{ $msg->message }}</div>
                            <div class="text-end text-white-50 small" style="font-size:11px;">
                                {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-start mb-2">
                        <div class="bg-white border rounded-4 px-3 py-2" style="max-width:70%;">
                            <div class="small">{{ $msg->message }}</div>
                            <div class="text-end text-secondary small" style="font-size:11px;">
                                {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="card-footer bg-white">
            @if(session('success'))
                <div class="alert alert-success mb-2 py-1 px-2">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('client.inbox.chat.send', ['company'=>$company, 'contact'=>$contact->id]) }}">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control rounded-pill" required maxlength="2000" placeholder="Type a message...">
                    <button class="btn btn-primary rounded-pill ms-2 px-4" type="submit">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
