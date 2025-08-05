@extends('client.app')

@section('content')
<div class="container py-4 px-3">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-4 shadow-sm" style="background:linear-gradient(90deg,#f7fafc 60%,#e8f1fa 100%); border-left: 6px solid #2573e6;">
                <h2 class="mb-2 fw-bold" style="color:#22223b;">Welcome, {{ strtoupper($company) }} Team!</h2>
                <div class="fs-5 text-muted">
                    Your secure WhatsApp automation hub.<br>
                    <span class="badge bg-gradient-primary text-white" style="background:linear-gradient(90deg,#4f8cfb,#38b6ff);">Enterprise SaaS</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-people-fill fs-2 text-primary"></i></div>
                    <div class="fs-3 fw-bold">{{ $activeContacts }}</div>
                    <div class="text-muted">Active Contacts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-chat-dots-fill fs-2 text-success"></i></div>
                    <div class="fs-3 fw-bold">{{ $messagesSent }}</div>
                    <div class="text-muted">Messages Sent</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-pie-chart-fill fs-2 text-info"></i></div>
                    <div class="fs-3 fw-bold">{{ $remainingMessages }}</div>
                    <div class="text-muted">Remaining Messages</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-activity fs-2 text-primary"></i></div>
                    <div class="fs-3 fw-bold">{{ $quota }}%</div>
                    <div class="text-muted">Quota Remaining</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Actions & Chart -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-header bg-transparent pb-0 border-0">
                    <div class="fw-bold fs-5">Messaging Activity (This Month)</div>
                </div>
                <div class="card-body">
                    <canvas id="messagesChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-header bg-transparent pb-0 border-0">
                    <div class="fw-bold fs-5">Quick Actions</div>
                </div>
                <div class="card-body pt-3">
                    <div class="d-grid gap-3">
                        <a href="/{{ $company }}/contacts" class="btn btn-outline-primary btn-lg rounded-pill fw-semibold">
                            <i class="bi bi-person-lines-fill me-2"></i>Add Contacts
                        </a>
                        <a href="/{{ $company }}/send-message" class="btn btn-outline-success btn-lg rounded-pill fw-semibold">
                            <i class="bi bi-send me-2"></i>Send New Message
                        </a>
                        <a href="/{{ $company }}/usage" class="btn btn-outline-info btn-lg rounded-pill fw-semibold">
                            <i class="bi bi-bar-chart me-2"></i>View Usage & Quota
                        </a>
                        <a href="/{{ $company }}/inbox" class="btn btn-outline-dark btn-lg rounded-pill fw-semibold">
                            <i class="bi bi-chat-dots me-2"></i>Open Inbox
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Activity Log Preview (Dynamic) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="fw-bold fs-5">Recent Activity</div>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        @foreach($recentActivity as $item)
                            <li class="list-group-item px-0">{!! $item !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('messagesChart').getContext('2d');
    var messagesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Messages Sent',
                data: @json($data),
                backgroundColor: 'rgba(56, 182, 255, 0.6)',
                borderColor: 'rgba(56, 182, 255, 1)',
                borderWidth: 2,
                borderRadius: 6,
                maxBarThickness: 16
            }]
        },
        options: {
            scales: {
                x: {
                    ticks: { font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
