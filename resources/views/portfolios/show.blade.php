@extends('layouts.app')
@section('title', $portfolio->full_name.' · Portfolio')
@section('body-class', 'public-portfolio-page')
@section('content')
<section class="public-page">@include('portfolios._portfolio')</section>
@endsection