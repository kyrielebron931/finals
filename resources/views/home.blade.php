@extends('layouts.app')

@section('title', 'A portfolio that feels like you')

@section('content')
<section class="hero-band">
    <div class="hero-copy">
        <p class="eyebrow"><span class="eyebrow-dot"></span> YOUR WORK, WELL PRESENTED</p>
        <h1>Make room<br>for your <em>best work.</em></h1>
        <p class="hero-description">A thoughtful portfolio, without the blank-page panic. Tell your story, choose a look, and put it out into the world.</p>
        <div class="hero-actions">
            <a class="button button-dark" href="{{ auth()->check() ? route('portfolios.create') : route('register') }}">Create your portfolio <span aria-hidden="true">↗</span></a>
            <span class="hero-note">Free to build · Yours to share</span>
        </div>
        <div class="hero-index"><span>01</span> A good first impression starts here</div>
    </div>
    <div class="hero-art" aria-label="A preview of a portfolio layout">
        <div class="art-note">SELECTED WORK<br><span>2024 — 2026</span></div>
        <div class="art-sheet">
            <div class="art-topline"><span>PORTFOLIO / 01</span><span>INDEPENDENT CREATIVE</span></div>
            <div class="art-intro"><span class="art-avatar">F</span><div><span class="art-name">Feljohn<br>Anog<span class="art-period">.</span></span><span class="art-role">Designer & image maker</span></div></div>
            <div class="art-rule"></div>
            <div class="art-work-label">RECENT PROJECTS <span>↘</span></div>
            <div class="art-projects"><div class="art-project art-project-one"><span>01 / BRAND IDENTITY</span><b>Good<br>Form</b></div><div class="art-project art-project-two"><span>02 / DIGITAL</span><b>Field<br>Notes</b></div></div>
            <div class="art-bottom"><span>AVAILABLE FOR SELECT PROJECTS</span><span>NYC · WORLDWIDE</span></div>
        </div>
        <div class="art-stamp">MAKE IT<br>YOUR OWN <span>✳</span></div>
        <div class="art-caption">YOUR NEXT CHAPTER, IN VIEW</div>
    </div>
</section>
<section class="home-process" aria-label="How it works">
    <div class="process-heading"><span class="eyebrow">THREE STEPS, THEN YOU’RE LIVE</span><span class="process-side-note">A little less setup. A lot more you.</span></div>
    <div class="process-steps"><article><span class="step-number">01</span><h2>Put your story together</h2><p>Add the details, projects and links people need to know you.</p></article><article><span class="step-number">02</span><h2>Find your format</h2><p>Choose between three considered designs, made to do your work justice.</p></article><article><span class="step-number">03</span><h2>Share what you make</h2><p>Preview your portfolio, fine-tune it, then share your own link.</p></article></div>
</section>
@endsection