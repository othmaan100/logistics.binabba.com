@php
    $panelName = 'Administrator';
    $homeUrl = url('dashboard');
    $activityUrl = url('activity-logs');

    $menu = [
        ['label' => 'Dashboard', 'icon' => 'fa-th-large', 'url' => url('dashboard'), 'match' => ['dashboard']],

        ['heading' => 'Operations'],
        ['label' => 'Clients', 'icon' => 'fa-address-book', 'match' => ['admin-clients*', 'clients*'], 'items' => [
            ['Add Client', url('admin-clients/create')],
            ['All Clients', url('admin-clients')],
        ]],
        ['label' => 'Goods', 'icon' => 'fa-boxes', 'match' => ['admin-goods*', 'goods*'], 'items' => [
            ['Add Goods', url('admin-goods/create')],
            ['All Goods', url('admin-goods')],
        ]],
        ['label' => 'Trucks', 'icon' => 'fa-truck', 'match' => ['admin-trucks*', 'trucks*'], 'items' => [
            ['Add Truck', url('admin-trucks/create')],
            ['All Trucks', url('admin-trucks')],
        ]],
        ['label' => 'Drivers', 'icon' => 'fa-id-card', 'match' => ['admin-drivers*', 'drivers*'], 'items' => [
            ['Add Driver', url('admin-drivers/create')],
            ['All Drivers', url('admin-drivers')],
        ]],
        ['label' => 'Stocks', 'icon' => 'fa-warehouse', 'match' => ['admin-stock*', 'stock*'], 'items' => [
            ['Add Stock Type', url('admin-stocks/stocktypecreate')],
            ['Add Stock', url('admin-stocks/create')],
            ['All Stocks', url('admin-stocks')],
        ]],

        ['heading' => 'Finance'],
        ['label' => 'Payments', 'icon' => 'fa-money-bill-wave', 'match' => ['admin-payments*', 'payments*'], 'items' => [
            ['All Payments', url('admin-payments')],
        ]],
        ['label' => 'Expenses', 'icon' => 'fa-receipt', 'match' => ['admin-expenses*', 'expenses*'], 'items' => [
            ['Add Expense', url('admin-expenses/create')],
            ['All Expenses', url('admin-expenses')],
        ]],
        ['label' => 'Fuel Debt', 'icon' => 'fa-gas-pump', 'match' => ['admin-fuelDebt*', 'fuelDebt*'], 'items' => [
            ['Add Fuel Debt', url('admin-fuelDebt/create')],
            ['All Fuel Debts', url('admin-fuelDebt')],
        ]],

        ['heading' => 'System'],
        ['label' => 'Users', 'icon' => 'fa-user-shield', 'match' => ['users*'], 'items' => [
            ['Add User', url('users/create')],
            ['All Users', url('users')],
        ]],
        ['label' => 'Activity Log', 'icon' => 'fa-history', 'url' => url('activity-logs'), 'match' => ['activity-logs*']],
    ];
@endphp
@extends('layouts.panel')
