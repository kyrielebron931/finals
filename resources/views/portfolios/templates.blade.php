@extends('layouts.app')
@section('title', 'Choose a design')
@section('content')
<section class="template-page"><div class="page-heading"><div><p class="eyebrow">A GOOD FIT FOR YOUR WORK</p><h1>Choose your look<span class="title-period">.</span></h1><p class="page-lede">Your content stays the same. Pick the way you want it to feel.</p></div><a class="editor-back" href="{{ route('portfolios.edit', $portfolio) }}">← EDIT YOUR DETAILS</a></div>
    <div class="template-grid">
        @foreach (['simple' => ['Simple', 'Clean lines, generous breathing room and a focus on your story.'], 'modern' => ['Modern', 'A structured, card-based layout for work with lots of moving parts.'], 'creative' => ['Creative', 'Expressive type and an editorial feel for work that takes a point of view.']] as $key => [$name, $description])
            <article class="template-card {{ $portfolio->template === $key ? 'selected' : '' }}"><div class="template-swatch swatch-{{ $key }}"><div class="swatch-window"><div class="swatch-top"></div><div class="swatch-heading"></div><div class="swatch-sub"></div><div class="swatch-blocks"><i></i><i></i></div></div></div><div class="template-card-info"><div class="template-card-title"><h2>{{ $name }}</h2><span>0{{ $loop->iteration }}</span></div><p>{{ $description }}</p><form action="{{ route('portfolios.template', $portfolio) }}" method="post">@csrf @method('PUT')<input type="hidden" name="template" value="{{ $key }}"><button class="template-select" type="submit">{{ $portfolio->template === $key ? 'Selected · Preview' : 'Choose this design' }}</button></form></div></article>
        @endforeach
    </div>
</section>
@endsection