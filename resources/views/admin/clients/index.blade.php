<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Clients</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Gantari:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Gantari', sans-serif;
    }
    .sidebar {
      width: 260px;
      height: 100vh;
      background-color: #f8f9fa;
      padding: 20px;
      border-right: 1px solid #dee2e6;
    }
    .sidebar .logo {
      font-size: 1.8rem;
      font-weight: 600;
      margin-bottom: 30px;
    }
    .sidebar .nav-link {
      color: #333;
      font-weight: 500;
      padding: 10px 15px;
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }
    .sidebar .nav-link:hover {
      background-color: #e9ecef;
      color: #0d6efd;
    }
    .sidebar .nav-group {
      margin-bottom: 20px;
    }
    .sidebar .nav-group-title {
      font-size: 0.9rem;
      font-weight: 600;
      color: #6c757d;
      text-transform: uppercase;
      margin-bottom: 5px;
    }
    .table-actions i {
      cursor: pointer;
      margin-right: 10px;
      color: #6c757d;
    }
    .table-actions i:hover {
      color: #0d6efd;
    }
    .toggle-section {
      display: none;
    }
  </style>
</head>
<body>

<div class="d-flex">
  <div class="sidebar">
    <div class="logo">
      <i class="bi bi-robot"></i> Rubatt Bot
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Main</div>
      <a href="#" class="nav-link"><i class="bi bi-house"></i> Dashboard</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Client Management</div>
      <a href="/admin/clients" class="nav-link"><i class="bi bi-people"></i> Clients</a>
      <a href="#" class="nav-link"><i class="bi bi-person-lines-fill"></i> Assign Subscriptions</a>
      <a href="#" class="nav-link"><i class="bi bi-key"></i> API Credentials</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Bot Configuration</div>
      <a href="#" class="nav-link"><i class="bi bi-sliders2"></i> Behavior Settings</a>
      <a href="#" class="nav-link"><i class="bi bi-translate"></i> Voice & Language</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Usage Analytics</div>
      <a href="#" class="nav-link"><i class="bi bi-bar-chart"></i> Message Stats</a>
      <a href="#" class="nav-link"><i class="bi bi-clock-history"></i> API Usage Logs</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">System Monitoring</div>
      <a href="#" class="nav-link"><i class="bi bi-exclamation-triangle"></i> Error Logs</a>
      <a href="#" class="nav-link"><i class="bi bi-cpu"></i> Server Health</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Billing & Subscriptions</div>
      <a href="#" class="nav-link"><i class="bi bi-cash"></i> Invoices</a>
      <a href="#" class="nav-link"><i class="bi bi-credit-card"></i> Payments</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Notifications</div>
      <a href="#" class="nav-link"><i class="bi bi-bell"></i> Alerts</a>
      <a href="#" class="nav-link"><i class="bi bi-envelope"></i> Email Triggers</a>
    </div>
    <div class="nav-group">
      <div class="nav-group-title">Settings</div>
      <a href="#" class="nav-link"><i class="bi bi-gear"></i> System Settings</a>
      <a href="#" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>

  <div class="flex-grow-1 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-bold">Clients</h2>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
        <i class="bi bi-plus-circle me-1"></i> Add New Client
      </button>
    </div>

    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($clients as $index => $client)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ ucfirst($client->role) }}</td>
            <td class="table-actions">
              <i class="bi bi-pencil-square" data-bs-toggle="tooltip" title="Edit"></i>
              <i class="bi bi-trash" data-bs-toggle="tooltip" title="Delete"></i>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Modal for Add New Client -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addClientModalLabel">Add New Client</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('admin.clients.store') }}">
            @csrf
            @if ($errors->any())
  <script>
    console.error("Form validation failed:", @json($errors->all()));
  </script>
@endif

@if(session('error'))
  <script>
    console.error("Server error:", "{{ session('error') }}");
  </script>
@endif

            <div class="modal-body">
              <div class="btn-group mb-3" role="group">
                <button type="button" class="btn btn-outline-primary active" id="officialBtn">Official</button>
                <button type="button" class="btn btn-outline-secondary" id="nonOfficialBtn">Non-Official</button>
              </div>

              <div id="officialFields">
                <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Company</label>
                  <input type="text" class="form-control" name="company">
                </div>
                <div class="mb-3">
                  <label class="form-label">Phone</label>
                  <input type="text" class="form-control" name="phone">
                </div>
                <div class="mb-3">
                  <label class="form-label">Call Back URL</label>
                  <input type="text" class="form-control" name="callback_url">
                </div>
                <div class="mb-3">
                  <label class="form-label">Phone ID</label>
                  <input type="text" class="form-control" name="phone_id">
                </div>
                <div class="mb-3">
                  <label class="form-label">Access Token</label>
                  <input type="text" class="form-control" name="access_token">
                </div>
              </div>

              <div id="nonOfficialFields" class="toggle-section">
                <div class="mb-3">
                  <label class="form-label">Whatsapp Number</label>
                  <input type="text" class="form-control" name="number_wa">
                </div>
                <div class="mb-3">
                  <label class="form-label">API</label>
                  <input type="text" class="form-control" name="api">
                </div>
                <input type="hidden" name="type" id="clientType" value="official">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Client</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const officialBtn = document.getElementById('officialBtn');
  const nonOfficialBtn = document.getElementById('nonOfficialBtn');
  const officialFields = document.getElementById('officialFields');
  const nonOfficialFields = document.getElementById('nonOfficialFields');

  officialBtn.addEventListener('click', () => {
  officialFields.style.display = 'block';
  nonOfficialFields.style.display = 'none';
  officialBtn.classList.add('active');
  nonOfficialBtn.classList.remove('active');
  document.getElementById('clientType').value = 'official';
});

nonOfficialBtn.addEventListener('click', () => {
  officialFields.style.display = 'none';
  nonOfficialFields.style.display = 'block';
  nonOfficialBtn.classList.add('active');
  officialBtn.classList.remove('active');
  document.getElementById('clientType').value = 'non_official';
});

</script>
</body>
</html>
