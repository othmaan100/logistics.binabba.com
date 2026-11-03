@php
    $panelName = 'Secretary';
    $homeUrl = url('Staff_dashboard');
    $activityUrl = null;

    $menu = [
        ['label' => 'Dashboard', 'icon' => 'fa-th-large', 'url' => url('Staff_dashboard'), 'match' => ['Staff_dashboard', 'staff_dashboard']],

        ['heading' => 'Operations'],
        ['label' => 'Clients', 'icon' => 'fa-address-book', 'match' => ['Clients*', 'clients*'], 'items' => [
            ['Add Client', url('clients/create')],
            ['All Clients', url('Clients')],
        ]],
        ['label' => 'Goods', 'icon' => 'fa-boxes', 'match' => ['goods*'], 'items' => [
            ['Add Goods', url('goods/create')],
            ['All Goods', url('goods')],
        ]],
        ['label' => 'Trucks', 'icon' => 'fa-truck', 'match' => ['trucks*'], 'items' => [
            ['Add Truck', url('trucks/create')],
            ['All Trucks', url('trucks')],
        ]],
        ['label' => 'Drivers', 'icon' => 'fa-id-card', 'match' => ['drivers*'], 'items' => [
            ['Add Driver', url('drivers/create')],
            ['All Drivers', url('drivers')],
        ]],
        ['label' => 'Stocks', 'icon' => 'fa-warehouse', 'match' => ['stock*'], 'items' => [
            ['Add Stock Type', url('stocks/stocktypecreate')],
            ['Add Stock', url('stock/create')],
            ['All Stocks', url('stock')],
        ]],

        ['heading' => 'Finance'],
        ['label' => 'Payments', 'icon' => 'fa-money-bill-wave', 'match' => ['payments*'], 'items' => [
            ['All Payments', url('payments')],
        ]],
        ['label' => 'Expenses', 'icon' => 'fa-receipt', 'match' => ['expenses*'], 'items' => [
            ['Add Expense', url('expenses/create')],
            ['All Expenses', url('expenses')],
        ]],
        ['label' => 'Fuel Debt', 'icon' => 'fa-gas-pump', 'match' => ['fuelDebt*'], 'items' => [
            ['Add Fuel Debt', url('fuelDebts/create')],
            ['All Fuel Debts', url('fuelDebts')],
        ]],
    ];
@endphp
@extends('layouts.panel')
