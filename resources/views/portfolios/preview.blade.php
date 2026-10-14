@extends('layouts.app')
@section('title', 'Preview · '.$portfolio->full_name)
@section('content')
<section class="preview-page"><div class="preview-toolbar"><a href="{{ route('portfolios.index') }}">← My portfolios</a><div class="toolbar-actions"><a class="button button-light" href="{{ route('portfolios.edit', $portfolio) }}">Edit details</a><a class="button button-light" href="{{ route('portfolios.templates', $portfolio) }}">Change design</a><button class="button button-dark" type="button" id="copy-link" data-url="{{ route('portfolios.public', $portfolio) }}">Copy share link <span aria-hidden="true">↗</span></button></div></div>@include('portfolios._portfolio')</section>
@endsection
@push('scripts')<script>document.querySelector('#copy-link').addEventListener('click', async (event) => { await navigator.clipboard.writeText(event.currentTarget.dataset.url); event.currentTarget.innerHTML = 'Link copied ✓'; });</script>@endpush