@extends('layouts.app_admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
    
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    {{-- NEWS STATISTIC CARD --}}
    @include('layouts.partials_admin.stats-card')

    {{-- NEWS STATISTIC CHART --}}
    @include('layouts.partials_admin.line-chart')

    {{-- NEWS REPORT TABLE --}}
    @include('layouts.partials_admin.report-table')
@endsection

{{-- STYLE NEWS CARD --}}
@stack('style')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard/news-card.css') }}">