{{-- The organization's logo, or a truck icon before one has been uploaded --}}
@if ($organization?->logo_path)
    <img src="{{ $organization->logoUrl() }}" alt="{{ $organization->short_name }}" {{ $attributes }}>
@else
    <span {{ $attributes->merge(['class' => 'org-logo-fallback']) }}><i class="fas fa-truck"></i></span>
@endif
