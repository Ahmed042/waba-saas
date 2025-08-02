@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <div class="mb-4 d-flex align-items-center">
        <a href="/{{ $company }}/lists" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Back to Lists
        </a>
        <h3 class="fw-bold mb-0">{{ $list->name }} <span class="badge bg-info ms-2">{{ $contacts->count() }} contacts</span></h3>
    </div>
    @if($contacts->count() == 0)
        <div class="alert alert-info">This list has no contacts yet.</div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body px-0">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
