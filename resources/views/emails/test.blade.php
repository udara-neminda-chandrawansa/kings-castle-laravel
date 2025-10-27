@extends('emails.layout')

@section('title', 'Test Email')

@section('header')
<div class="header">
    <h1>Kings Castle Hotel</h1>
    <p>Email System Test</p>
</div>
@endsection

@section('content')
    <h2>Email System Test</h2>
    <p>This is a test email to verify that the email system is working correctly.</p>
    
    <div class="alert alert-success">
        <strong>Success!</strong> If you're reading this, the email system is configured properly.
    </div>
    
    <p><strong>Test Data:</strong></p>
    <ul>
        <li>Sent at: {{ now()->format('Y-m-d H:i:s') }}</li>
        <li>Server Time: {{ date('Y-m-d H:i:s') }}</li>
        <li>App Name: {{ config('app.name') }}</li>
    </ul>
    
    <p>You can now proceed with sending booking confirmations, payment notifications, and status updates to your customers.</p>
@endsection
