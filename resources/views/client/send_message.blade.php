@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <h3 class="fw-bold mb-4">Send Message</h3>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            {!! implode('<br>', $errors->all()) !!}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body">
            <form method="POST" action="{{ route('client.send_message.send', ['company'=>$company]) }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Select List (send to all in this list):</label>
                        <select class="form-select" name="list_id">
                            <option value="">-- No list selected --</option>
                            @foreach($lists as $list)
                                <option value="{{ $list->id }}">{{ $list->name }} ({{ $list->contacts()->count() }} contacts)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Or select individual contacts:</label>
                        <select class="form-select" name="contact_ids[]" multiple size="5">
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->phone }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" rows="4" class="form-control" required maxlength="2000" placeholder="Type your message here"></textarea>
                </div>

                <div>
                    <button class="btn btn-primary px-5 py-2 rounded-pill fw-semibold" type="submit">
                        <i class="bi bi-send"></i> Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
