@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold mb-0">Contacts</h3>
        <div>
            <!-- Button trigger modals -->
            <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addContactModal">
                <i class="bi bi-person-plus"></i> Add Contact
            </button>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload"></i> Import CSV
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

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
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phone }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No contacts yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('client.contacts.store', ['company'=>$company]) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add Contact</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" maxlength="255">
            </div>
            <div class="mb-3">
              <label class="form-label">Phone <span class="text-danger">*</span></label>
              <input type="text" name="phone" class="form-control" required maxlength="20">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('client.contacts.import', ['company'=>$company]) }}" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Import Contacts (CSV)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">CSV File <span class="text-danger">*</span></label>
              <input type="file" name="csv_file" class="form-control" required accept=".csv">
              <small class="text-muted">Format: Name,Phone (first row is header)</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Import</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
