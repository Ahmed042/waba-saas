@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}</h1>
    <p>Bot Type: <strong>{{ $user->bot_type ?? 'N/A' }}</strong></p>
    <p>Subscription Status: <strong>{{ ucfirst($user->subscription_status) }}</strong></p>
    <p>Messages Used: <strong>{{ $user->messages_used ?? 0 }} / {{ $user->message_quota ?? 'Unlimited' }}</strong></p>
</div>
@endsection
