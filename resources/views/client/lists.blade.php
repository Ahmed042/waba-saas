@extends('client.app')

@section('content')
<div class="container py-4 px-2">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="fw-bold mb-0">Contact Lists</h3>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addListModal">
            <i class="bi bi-plus"></i> Create List
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($lists as $list)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="fw-bold fs-5 mb-2">{{ $list->name }}</div>
                        <div class="mb-3 text-muted">{{ $list->contacts()->count() }} contacts</div>
                        <a href="{{ route('client.lists.contacts', ['company'=>$company, 'list'=>$list->id]) }}" class="btn btn-outline-info btn-sm me-2">
                            View Contacts
                        </a>
                        <!-- Assign contacts modal trigger -->
                        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#assignContactsModal{{ $list->id }}">
                            Assign Contacts
                        </button>
                    </div>
                </div>
            </div>
            <!-- Assign Contacts Modal -->
            <div class="modal fade" id="assignContactsModal{{ $list->id }}" tabindex="-1">
              <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('client.lists.add_contacts', ['company'=>$company, 'list'=>$list->id]) }}">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title">Assign Contacts to {{ $list->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Contacts</label>
                        <select name="contact_ids[]" class="form-select" multiple size="6" required>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->phone }})</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple</small>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Assign</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
        @empty
            <div class="col-12 text-muted text-center">
                No lists created yet.
            </div>
        @endforelse
    </div>

    <!-- Add List Modal -->
    <div class="modal fade" id="addListModal" tabindex="-1">
      <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('client.lists.store', ['company'=>$company]) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Create New List</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">List Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" maxlength="255" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection
