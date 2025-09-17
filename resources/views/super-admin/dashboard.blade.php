@extends('layouts.super_admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

    {{-- NEWS STATISTIC CARD --}}
    @include('layouts.partials_super_admin.stats-card')

    {{-- NEWS STATISTIC CHART --}}
    @isset($newsPerMonth)

        {{-- LINE CHART & NEWS UPDATES --}}
        @include('layouts.partials_super_admin.line-chart')
        
    @endisset
    {{-- MANAGEMENT ADMIN ACCOUNT --}}
    @include('layouts.partials_super_admin.management-account')

    {{-- TABLE NEWS REPORT --}}
    @include('layouts.partials_super_admin.report-table')
@endsection

{{-- STYLE NEWS CARD --}}
@stack('style')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard/news-card.css') }}">