@extends('layouts.app')
@php($editing = $portfolio->exists)
@section('title', $editing ? 'Edit portfolio' : 'Create portfolio')
@section('content')
<section class="editor-page">
    <div class="editor-heading"><div><a class="editor-back" href="{{ $editing ? route('portfolios.preview', $portfolio) : route('portfolios.index') }}">← BACK TO {{ $editing ? 'PREVIEW' : 'WORKSPACE' }}</a><h1>{{ $editing ? 'Your story, updated.' : 'Let’s tell your story.' }}</h1><p>Add the pieces you want people to remember. You can always come back and change them.</p></div><span class="section-number">{{ $editing ? 'EDIT PORTFOLIO' : 'NEW PORTFOLIO' }}</span></div>
    <form class="editor-form" action="{{ $editing ? route('portfolios.update', $portfolio) : route('portfolios.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($editing) @method('PUT') @endif
        <section class="form-section"><div class="section-heading"><div><h2>Personal details</h2><p>The essentials people need to reach you.</p></div><span class="section-number">01</span></div><div class="field-grid">
            <label class="field-label field-span">Profile picture <small>Square image works best · max 5 MB</small><div class="photo-field">@if ($portfolio->profile_picture)<img class="photo-preview" src="/storage/{{ $portfolio->profile_picture }}" alt="Current profile picture">@else<span class="photo-preview">{{ $editing ? mb_substr($portfolio->full_name, 0, 1) : '＋' }}</span>@endif<input class="field-input" name="profile_picture" type="file" accept="image/*"></div>@error('profile_picture')<small class="field-error">{{ $message }}</small>@enderror</label>
            <label class="field-label">Full name<input class="field-input" name="full_name" value="{{ old('full_name', $portfolio->full_name) }}" autocomplete="name" required>@error('full_name')<small class="field-error">{{ $message }}</small>@enderror</label>
            <label class="field-label">Email address<input class="field-input" name="email" type="email" value="{{ old('email', $portfolio->email) }}" autocomplete="email" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
            <label class="field-label">Contact number<input class="field-input" name="contact_number" type="tel" value="{{ old('contact_number', $portfolio->contact_number) }}" autocomplete="tel"></label>
            <label class="field-label">Address or location<input class="field-input" name="address" value="{{ old('address', $portfolio->address) }}" autocomplete="address-level2" placeholder="City, country"></label>
            <label class="field-label field-span">About me<textarea class="field-textarea" name="about" maxlength="5000" placeholder="A few sentences about what you do, what you care about, and where you’re headed.">{{ old('about', $portfolio->about) }}</textarea>@error('about')<small class="field-error">{{ $message }}</small>@enderror</label>
        </div></section>

        @php($educationRows = old('education', $portfolio->education ?: [['degree' => '', 'school' => '', 'dates' => '']]))
        <section class="form-section"><div class="section-heading"><div><h2>Education</h2><p>Include a school, qualification, course or anything relevant.</p></div><span class="section-number">02</span></div><div class="repeater" data-list="education">@foreach ($educationRows as $index => $item)<div class="repeat-item"><button class="remove-row" type="button" aria-label="Remove education entry">×</button><div class="field-grid"><label class="field-label">Degree or course<input class="field-input" name="education[{{ $index }}][degree]" value="{{ $item['degree'] ?? '' }}"></label><label class="field-label">School or institution<input class="field-input" name="education[{{ $index }}][school]" value="{{ $item['school'] ?? '' }}"></label><label class="field-label field-span">Years<input class="field-input" name="education[{{ $index }}][dates]" value="{{ $item['dates'] ?? '' }}" placeholder="2022 – 2025"></label></div></div>@endforeach</div><button class="add-row" type="button" data-add="education">＋ Add education</button></section>

        @php($skillRows = old('skills', $portfolio->skills ?: ['']))
        <section class="form-section"><div class="section-heading"><div><h2>Skills</h2><p>What do you do well? Keep it specific.</p></div><span class="section-number">03</span></div><div class="repeater" data-list="skills">@foreach ($skillRows as $skill)<div class="repeat-item"><button class="remove-row" type="button" aria-label="Remove skill">×</button><div class="field-grid"><label class="field-label field-span">Skill<input class="field-input" name="skills[]" value="{{ $skill }}" placeholder="e.g. Product design"></label></div></div>@endforeach</div><button class="add-row" type="button" data-add="skills">＋ Add skill</button></section>

        @php($projectRows = old('projects', $portfolio->projects ?: [['title' => '', 'url' => '', 'description' => '']]))
        <section class="form-section"><div class="section-heading"><div><h2>Projects</h2><p>Show the work you want people to see first.</p></div><span class="section-number">04</span></div><div class="repeater" data-list="projects">@foreach ($projectRows as $index => $item)<div class="repeat-item"><button class="remove-row" type="button" aria-label="Remove project">×</button><div class="field-grid"><label class="field-label">Project name<input class="field-input" name="projects[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}"></label><label class="field-label">Project link<input class="field-input" name="projects[{{ $index }}][url]" type="url" value="{{ $item['url'] ?? '' }}" placeholder="https://"></label><label class="field-label field-span">What did you make?<textarea class="field-textarea" name="projects[{{ $index }}][description]">{{ $item['description'] ?? '' }}</textarea></label></div></div>@endforeach</div><button class="add-row" type="button" data-add="projects">＋ Add project</button></section>

        @php($experienceRows = old('experience', $portfolio->experience ?: [['role' => '', 'company' => '', 'dates' => '', 'description' => '']]))
        <section class="form-section"><div class="section-heading"><div><h2>Experience</h2><p>Past roles, freelance work or meaningful collaborations.</p></div><span class="section-number">05</span></div><div class="repeater" data-list="experience">@foreach ($experienceRows as $index => $item)<div class="repeat-item"><button class="remove-row" type="button" aria-label="Remove experience">×</button><div class="field-grid"><label class="field-label">Role<input class="field-input" name="experience[{{ $index }}][role]" value="{{ $item['role'] ?? '' }}"></label><label class="field-label">Company<input class="field-input" name="experience[{{ $index }}][company]" value="{{ $item['company'] ?? '' }}"></label><label class="field-label field-span">Dates<input class="field-input" name="experience[{{ $index }}][dates]" value="{{ $item['dates'] ?? '' }}" placeholder="2023 – present"></label><label class="field-label field-span">A little about it<textarea class="field-textarea" name="experience[{{ $index }}][description]">{{ $item['description'] ?? '' }}</textarea></label></div></div>@endforeach</div><button class="add-row" type="button" data-add="experience">＋ Add experience</button></section>

        @php($linkRows = old('links', $portfolio->links ?: [['label' => '', 'url' => '']]))
        <section class="form-section"><div class="section-heading"><div><h2>Social & website links</h2><p>Point people to more of your work around the web.</p></div><span class="section-number">06</span></div><div class="repeater" data-list="links">@foreach ($linkRows as $index => $item)<div class="repeat-item"><button class="remove-row" type="button" aria-label="Remove link">×</button><div class="field-grid"><label class="field-label">Label<input class="field-input" name="links[{{ $index }}][label]" value="{{ $item['label'] ?? '' }}" placeholder="LinkedIn"></label><label class="field-label">URL<input class="field-input" name="links[{{ $index }}][url]" type="url" value="{{ $item['url'] ?? '' }}" placeholder="https://"></label></div></div>@endforeach</div><button class="add-row" type="button" data-add="links">＋ Add link</button></section>

        <div class="form-actions"><small>Your details are saved to your account. You can edit or delete them any time.</small><button class="button button-dark" type="submit">{{ $editing ? 'Save changes' : 'Save & choose a design' }} <span aria-hidden="true">↗</span></button></div>
    </form>
</section>
@endsection
@push('scripts')
<script>
const repeaterTemplates = new Map(
    Array.from(document.querySelectorAll('[data-list]'), (list) => [
        list.dataset.list,
        list.firstElementChild.cloneNode(true),
    ]),
);

document.querySelectorAll('[data-add]').forEach((button) => {
    button.addEventListener('click', () => {
        const list = document.querySelector(`[data-list="${button.dataset.add}"]`);
        const item = repeaterTemplates.get(button.dataset.add).cloneNode(true);
        const index = list.children.length;
        item.querySelectorAll('input, textarea').forEach((field) => {
            field.value = '';
            field.name = field.name.replace(/\[\d+\]/, `[${index}]`);
        });
        list.append(item);
    });
});
document.addEventListener('click', (event) => {
    const button = event.target.closest('.remove-row');
    if (button) button.closest('.repeat-item').remove();
});
document.querySelector('input[name="profile_picture"]')?.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (!file) return;
    const preview = document.querySelector('.photo-preview');
    if (preview.tagName === 'IMG') preview.src = URL.createObjectURL(file);
    else {
        const image = document.createElement('img');
        image.className = 'photo-preview';
        image.alt = 'Selected profile picture';
        image.src = URL.createObjectURL(file);
        preview.replaceWith(image);
    }
});
</script>
@endpush