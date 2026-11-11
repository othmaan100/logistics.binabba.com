@props(['trucks', 'operationsRoute'])

@php
    $money = function ($n) {
        $abs = abs($n);
        $sign = $n < 0 ? '−' : '';
        if ($abs >= 1e9) return $sign . '₦' . number_format($abs / 1e9, 2) . 'B';
        if ($abs >= 1e6) return $sign . '₦' . number_format($abs / 1e6, 1) . 'M';
        if ($abs >= 1e3) return $sign . '₦' . number_format($abs / 1e3, 0) . 'k';
        return $sign . '₦' . number_format($abs);
    };
    $full = fn ($n) => '₦' . number_format($n, 2);

    $byStatus = $trucks->countBy('status');
    $recovering = $trucks->where('status', \App\Services\TruckPerformance::RECOVERING);

    $statusInfo = [
        'profitable' => ['Profitable', 'success', 'Has earned back its value and is now in profit'],
        'recovering' => ['Recovering', 'warning', 'Earning, but has not yet earned back its purchase value'],
        'loss'       => ['Loss-making', 'danger', 'Its trips cost more than they bring in'],
        'idle'       => ['No trips', 'secondary', 'No goods recorded for this truck yet'],
    ];
@endphp

<div class="section-title">Truck performance</div>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Fleet operating income" :value="$money($trucks->sum('income'))" icon="fa-chart-line" tone="brand"
            :hint="number_format($trucks->sum('trips')) . ' trips by ' . $trucks->count() . ' trucks'" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Profitable trucks" :value="($byStatus['profitable'] ?? 0) . ' of ' . $trucks->count()" icon="fa-trophy" tone="brand"
            hint="Earned back their value" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Still recovering value" :value="$byStatus['recovering'] ?? 0" icon="fa-hourglass-half" tone="amber"
            :hint="$recovering->isNotEmpty() ? $money($recovering->sum('balance')) . ' left to earn back' : 'None outstanding'" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Loss-making trucks" :value="$byStatus['loss'] ?? 0" icon="fa-exclamation-triangle" tone="rose"
            :hint="($byStatus['loss'] ?? 0) ? 'Needs attention' : 'None — every truck earns more than it costs'" />
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:.5rem">
        <span>Profitability by truck</span>
        <small class="text-muted font-weight-normal">Trucks needing attention are listed first</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table perf-table">
                <thead>
                    <tr>
                        <th>Truck</th>
                        <th class="text-right">Trips</th>
                        <th class="text-right">Goods cost</th>
                        <th class="text-right">Expenses</th>
                        <th class="text-right">Operating income</th>
                        <th class="text-right">Truck value</th>
                        <th style="min-width:7rem">Value recovered</th>
                        <th class="text-right">Net profit / to recover</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trucks as $t)
                        @php([$label, $tone, $why] = $statusInfo[$t->status])
                        <tr>
                            <td>
                                <a class="perf-truck" href="{{ route($operationsRoute, $t->id) }}" title="Open this truck's Operations page">
                                    {{ $t->plate_number }} <i class="fas fa-arrow-right"></i>
                                </a>
                                <div class="small text-muted">{{ $t->truck_model }}</div>
                            </td>
                            <td class="text-right">{{ number_format($t->trips) }}</td>
                            <td class="text-right" title="{{ $full($t->goods_cost) }}">{{ $money($t->goods_cost) }}</td>
                            <td class="text-right" title="{{ $full($t->total_expenses) }}">{{ $money($t->total_expenses) }}</td>
                            <td class="text-right font-weight-bold text-dark" title="{{ $full($t->income) }}">{{ $money($t->income) }}</td>
                            <td class="text-right" title="{{ $full($t->value) }}">{{ $money($t->value) }}</td>
                            <td>
                                @if ($t->recovered === null)
                                    <span class="text-muted small">No value set</span>
                                @else
                                    <div class="perf-bar perf-{{ $tone }}" title="{{ number_format($t->recovered, 1) }}% of the truck's value earned back">
                                        <span style="width: {{ min(100, $t->recovered) }}%"></span>
                                    </div>
                                    <div class="small text-muted mt-1">{{ number_format($t->recovered) }}%</div>
                                @endif
                            </td>
                            <td class="text-right" title="{{ $t->profit >= 0 ? 'Net profit ' . $full($t->profit) : 'Balance to recover ' . $full($t->balance) }}">
                                @if ($t->profit >= 0)
                                    <span class="perf-amount perf-success">+{{ $money($t->profit) }}</span>
                                @else
                                    <span class="perf-amount perf-{{ $tone }}">{{ $money($t->balance) }}</span>
                                    <div class="small text-muted">to recover</div>
                                @endif
                            </td>
                            <td><span class="badge badge-{{ $tone }}" title="{{ $why }}">{{ $label }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="small text-muted mb-0 mt-3">
            Same figures as each truck's Operations page. <strong>Operating income</strong> is goods cost minus diesel, road expenses,
            commission, recorded expenses and the driver's 10% share. A truck is <strong>profitable</strong> once its operating income
            exceeds its purchase value. Hover over an amount to see the exact figure; click a plate number for the truck's full breakdown.
        </p>
    </div>
</div>
