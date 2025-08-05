@extends('layouts.auth') {{-- or your default layout --}}

@section('content')
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow p-4" style="min-width:340px;max-width:90vw;">
        <h4 class="mb-3 text-center">Which company are you from?</h4>
        <form method="POST" action="{{ route('choose.company.post') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="company" class="form-control" placeholder="Enter company name or code..." autofocus required>
                {{-- Optionally: add a datalist/autocomplete of known company slugs --}}
            </div>
            <button type="submit" class="btn btn-primary w-100">Continue</button>
        </form>
    </div>
</div>
@endsection
