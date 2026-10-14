@extends('layouts.app')
@section('title', 'My portfolios')
@section('content')
<section class="dashboard-page">
    <div class="page-heading"><div><p class="eyebrow">YOUR WORKSPACE</p><h1>My portfolios<span class="title-period">.</span></h1><p class="page-lede">Keep your work current. The next opportunity can come from anywhere.</p></div><a class="button button-dark" href="{{ route('portfolios.create') }}"><span aria-hidden="true">＋</span> New portfolio</a></div>
    @if ($portfolios->isEmpty())
        <div class="empty-state"><div class="empty-mark">f.</div><h2>Your first portfolio starts here.</h2><p>Add your story, choose a design and give your work a place to live.</p><a class="button button-dark" href="{{ route('portfolios.create') }}">Start your portfolio <span aria-hidden="true">↗</span></a></div>
    @else
        <div class="portfolio-table-wrap"><div class="portfolio-table-head"><span>PORTFOLIO</span><span>DESIGN</span><span>LAST UPDATED</span><span>LINK</span><span></span></div>
            @foreach ($portfolios as $portfolio)
                <article class="portfolio-row"><div class="portfolio-identity">@if ($portfolio->profile_picture)<img src="/storage/{{ $portfolio->profile_picture }}" alt="">@else<span class="initial-avatar">{{ mb_substr($portfolio->full_name, 0, 1) }}</span>@endif<div><strong>{{ $portfolio->full_name }}</strong><small>{{ $portfolio->email }}</small></div></div><span class="template-label"><i class="template-dot dot-{{ $portfolio->template }}"></i>{{ ucfirst($portfolio->template) }}</span><span class="row-date">{{ $portfolio->updated_at->format('M j, Y') }}</span><a class="text-link" href="{{ route('portfolios.public', $portfolio) }}" target="_blank" rel="noopener">Open portfolio <span aria-hidden="true">↗</span></a><div class="row-actions"><a class="icon-link" href="{{ route('portfolios.preview', $portfolio) }}" aria-label="Preview {{ $portfolio->full_name }}">↗</a><a class="icon-link" href="{{ route('portfolios.edit', $portfolio) }}" aria-label="Edit {{ $portfolio->full_name }}">✎</a><form action="{{ route('portfolios.destroy', $portfolio) }}" method="post" onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">@csrf @method('DELETE')<button class="icon-link" aria-label="Delete {{ $portfolio->full_name }}">×</button></form></div></article>
            @endforeach
        </div>
    @endif
</section>
@endsection