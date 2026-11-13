@extends('layouts.admin')

@section('title', 'Organization')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:.5rem">
        <span>Organization details</span>
        @if ($org->setup_completed_at)
            <small class="text-muted font-weight-normal">Set up {{ $org->setup_completed_at->format('d M Y') }} · last changed {{ $org->updated_at->diffForHumans() }}</small>
        @endif
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">Please check the highlighted fields.</div>
        @endif

        <form method="POST" action="{{ route('organization.update') }}" enctype="multipart/form-data" class="org-form" novalidate>
            @csrf
            @method('PUT')
            @include('setup._form')
            <div class="setup-actions">
                <span class="text-muted small">Changes apply straight away to the sidebar, sign-in page and all documents.</span>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>

@if ($org->exists)
    <div class="card mt-4">
        <div class="card-header">Document header preview</div>
        <div class="card-body">
            <p class="text-muted small">This is how the top of invoices, reports and PDFs will look.</p>
            <div class="org-letterhead-preview">
                <x-org-letterhead />
            </div>
        </div>
    </div>
@endif
@endsection
