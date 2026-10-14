@php($isModern = $portfolio->template === 'modern')
@php($isCreative = $portfolio->template === 'creative')
<article class="portfolio-sheet layout-{{ $portfolio->template }}">
    @if ($isCreative)<div class="creative-top"><span>FOLIOFORM <strong>✳</strong></span><span>PORTFOLIO / {{ date('Y') }}</span></div><div class="creative-hero">@endif
    @if ($isModern)<div class="modern-banner">@endif
    <h1>{{ $portfolio->full_name }}<em>{{ $isCreative ? '!' : '.' }}</em></h1>
    @if ($portfolio->about)<p class="portfolio-lead">{{ $portfolio->about }}</p>@endif
    <div class="portfolio-contact"><a href="mailto:{{ $portfolio->email }}">{{ $portfolio->email }}</a>@if ($portfolio->contact_number)<span>{{ $portfolio->contact_number }}</span>@endif @if ($portfolio->address)<span>{{ $portfolio->address }}</span>@endif</div>
    @if ($isModern)</div>@endif
    @if ($isCreative)<span class="creative-orbit" aria-hidden="true">✳</span></div>@endif
    <div class="portfolio-content">
        <aside class="portfolio-side">@if ($portfolio->profile_picture)<img src="/storage/{{ $portfolio->profile_picture }}" alt="Portrait of {{ $portfolio->full_name }}">@else<div class="portfolio-avatar">{{ mb_substr($portfolio->full_name, 0, 1) }}</div>@endif</aside>
        <div class="portfolio-main">
            @if ($portfolio->projects)<section class="portfolio-section"><h2>SELECTED PROJECTS</h2><div class="portfolio-list">@foreach ($portfolio->projects as $project)@if (!empty($project['title']) || !empty($project['description']))<article class="portfolio-item"><h3>{{ $project['title'] ?? '' }} @if (!empty($project['url']))<a href="{{ $project['url'] }}" target="_blank" rel="noopener" aria-label="Open {{ $project['title'] ?? 'project' }}">↗</a>@endif</h3>@if (!empty($project['description']))<p>{{ $project['description'] }}</p>@endif</article>@endif @endforeach</div></section>@endif
            @if ($portfolio->experience)<section class="portfolio-section"><h2>EXPERIENCE</h2><div class="portfolio-list">@foreach ($portfolio->experience as $item)@if (!empty($item['role']) || !empty($item['company']))<article class="portfolio-item"><h3>{{ $item['role'] ?? '' }}@if (!empty($item['company'])) · {{ $item['company'] }}@endif</h3>@if (!empty($item['dates']))<span class="item-meta">{{ $item['dates'] }}</span>@endif @if (!empty($item['description']))<p>{{ $item['description'] }}</p>@endif</article>@endif @endforeach</div></section>@endif
            @if ($portfolio->education)<section class="portfolio-section"><h2>EDUCATION</h2><div class="portfolio-list">@foreach ($portfolio->education as $item)@if (!empty($item['degree']) || !empty($item['school']))<article class="portfolio-item"><h3>{{ $item['degree'] ?? '' }}@if (!empty($item['school'])) · {{ $item['school'] }}@endif</h3>@if (!empty($item['dates']))<span class="item-meta">{{ $item['dates'] }}</span>@endif</article>@endif @endforeach</div></section>@endif
            @if ($portfolio->skills)<section class="portfolio-section"><h2>SKILLS</h2><div class="skill-list">@foreach ($portfolio->skills as $skill)@if ($skill)<span>{{ $skill }}</span>@endif @endforeach</div></section>@endif
            @if ($portfolio->links)<section class="portfolio-section"><h2>ELSEWHERE</h2><div class="portfolio-link-list">@foreach ($portfolio->links as $link)@if (!empty($link['url']))<a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] ?: parse_url($link['url'], PHP_URL_HOST) }} ↗</a>@endif @endforeach</div></section>@endif
        </div>
    </div>
    <footer class="public-footer"><span>{{ $portfolio->full_name }} · {{ ucfirst($portfolio->template) }} portfolio</span><a href="{{ route('home') }}">Made with Folioform ↗</a></footer>
</article>