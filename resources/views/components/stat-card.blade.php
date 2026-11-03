@props(['label', 'value', 'icon' => 'fa-chart-line', 'tone' => 'brand', 'hint' => null, 'href' => null])

<div class="stat-card stat-{{ $tone }}">
    <div class="stat-top">
        <span class="stat-label">{{ $label }}</span>
        <span class="stat-icon"><i class="fas {{ $icon }}"></i></span>
    </div>
    <div class="stat-value">{{ $value }}</div>
    @if ($hint || $href)
        <div class="stat-hint">
            @if ($href)
                <a href="{{ $href }}">{{ $hint ?? 'View details' }} <i class="fas fa-arrow-right"></i></a>
            @else
                {{ $hint }}
            @endif
        </div>
    @endif
</div>
