@extends('client.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">My WhatsApp Templates</h2>
    <a href="{{ route('client.templates.create', ['company' => $company]) }}" class="btn btn-primary mb-3">
        + Create New Template
    </a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @php
        $hasMetaTemplates = !empty($templates) && count($templates);
        $hasPending = !empty($pendingTemplates) && count($pendingTemplates);
    @endphp

    @if($hasMetaTemplates || $hasPending)
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Language</th>
                <th>Status</th>
                <th>Category</th>
                <th>Meta Template ID</th>
                <th>Body</th>
            </tr>
        </thead>
        <tbody>
        {{-- 1. Locally created templates still pending admin review (not yet on Meta) --}}
        @foreach($pendingTemplates as $tpl)
            <tr>
                <td>{{ $tpl->name }}</td>
                <td>{{ $tpl->language }}</td>
                <td>
                    <span class="badge bg-secondary">In Review </span>
                </td>
                <td>—</td>
                <td>—</td>
                <td>{{ $tpl->body }}</td>
            </tr>
        @endforeach

        {{-- 2. All templates from Meta (approved/rejected/pending) --}}
        @foreach($templates as $tpl)
            <tr>
                <td>{{ $tpl['name'] }}</td>
                <td>{{ $tpl['language'] }}</td>
                <td>
                    @if(strtolower($tpl['status']) == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @elseif(strtolower($tpl['status']) == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @elseif(strtolower($tpl['status']) == 'pending')
                        <span class="badge bg-warning text-dark">Pending (Meta)</span>
                    @else
                        <span class="badge bg-light text-dark">{{ ucfirst($tpl['status']) }}</span>
                    @endif
                </td>
                <td>{{ $tpl['category'] ?? '-' }}</td>
                <td>{{ $tpl['id'] ?? '-' }}</td>
                <td>
                    @foreach($tpl['components'] as $component)
                        @if($component['type'] == 'BODY')
                            {{ $component['text'] }}
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <div class="alert alert-info">No templates yet.</div>
    @endif
</div>
@endsection
