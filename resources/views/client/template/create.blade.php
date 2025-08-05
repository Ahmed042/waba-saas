@extends('client.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Create WhatsApp Template</h2>
    <form method="POST" action="{{ route('client.templates.store', ['company' => $company]) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Template Name</label>
            <input type="text" class="form-control" name="name" required placeholder="e.g. welcome_offer">
        </div>
        <div class="mb-3">
            <label class="form-label">Language</label>
           <select class="form-select" name="language" required>
    <option value="en_US">English (US)</option>
    <option value="en_GB">English (UK)</option>
    <option value="ur">Urdu</option>
</select>

        </div>
        <div class="mb-3">
            <label class="form-label">Body Text</label>
            <textarea class="form-control" name="body" rows="4" required placeholder="Your message body here, use {{1}} for variables"></textarea>
        </div>

        <button class="btn btn-success">Submit for Approval</button>
    </form>
</div>
@endsection
