@extends("layouts.staff")

@section("content")

<div class="welcome-banner">
    <div>
        <h2>Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ \Illuminate\Support\Str::title(strtolower(strtok(\Auth::user()->fullName, ' '))) }}</h2>
        <p>Here is today's snapshot of operations.</p>
    </div>
    <div class="welcome-actions">
        <a href="{{ url('goods/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New goods</a>
        <a href="{{ url('clients/create') }}" class="btn btn-secondary"><i class="fas fa-user-plus"></i> New client</a>
    </div>
</div>

<div class="section-title">Cash inflow</div>
<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <x-stat-card label="This month" :value="'₦' . number_format($totalFunds_this_month)" icon="fa-calendar-alt" tone="brand"
            hint="All payments" :href="url('payments')" />
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
        <x-stat-card label="Today" :value="'₦' . number_format($totalfundsToday)" icon="fa-coins" tone="brand" />
    </div>
</div>

<div class="section-title">Expenses</div>
<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <x-stat-card label="This month" :value="'₦' . number_format($totalExpenses_this_month)" icon="fa-calendar-alt" tone="rose"
            hint="All expenses" :href="url('expenses')" />
    </div>
    <div class="col-xl-6 col-md-6 mb-4">
        <x-stat-card label="Today" :value="'₦' . number_format($totalExpensesToday)" icon="fa-money-bill-wave" tone="rose" />
    </div>
</div>

<div class="section-title">Operations</div>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Delivered goods" :value="number_format($deliveredGoods)" icon="fa-check-circle" tone="sky"
            hint="View goods" :href="url('goods')" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Undelivered goods" :value="number_format($undeliveredGoods)" icon="fa-shipping-fast" tone="amber"
            hint="View goods" :href="url('goods')" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Stock items" :value="$stock" icon="fa-warehouse" tone="slate"
            hint="View stocks" :href="url('stock')" />
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <x-stat-card label="Stock given this month" :value="$goodassignment_this_month ?: 0" icon="fa-dolly" tone="slate" />
    </div>
</div>

<x-truck-performance :trucks="$truckPerformance" operations-route="trucks.operations" />

@endsection
