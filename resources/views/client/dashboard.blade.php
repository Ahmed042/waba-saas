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
                    <div class="fs-3 fw-bold">1,280</div>
                    <div class="text-muted">Active Contacts</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-chat-dots-fill fs-2 text-success"></i></div>
                    <div class="fs-3 fw-bold">6,500</div>
                    <div class="text-muted">Messages Sent</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-diagram-3 fs-2 text-warning"></i></div>
                    <div class="fs-3 fw-bold">8</div>
                    <div class="text-muted">Contact Lists</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <div class="mb-2"><i class="bi bi-pie-chart-fill fs-2 text-info"></i></div>
                    <div class="fs-3 fw-bold">92%</div>
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
                    <!-- Dummy Chart -->
                    <div class="d-flex align-items-center justify-content-center" style="height:200px;">
                        <span class="text-muted">[Chart Placeholder - Will show daily messages sent]</span>
                    </div>
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
    <!-- Activity Log Preview (Optional) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <div class="fw-bold fs-5">Recent Activity</div>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">You sent <b>Broadcast Message</b> to <b>Sales Team</b> (300 contacts)</li>
                        <li class="list-group-item px-0">Imported 500 new contacts from <b>marketing.csv</b></li>
                        <li class="list-group-item px-0">Added <b>Support Team</b> to Contact Lists</li>
                        <li class="list-group-item px-0">Message template <b>New Offer</b> submitted for approval</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
