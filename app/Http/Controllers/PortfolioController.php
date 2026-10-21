<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    private const TEMPLATES = ['simple', 'modern', 'creative'];

    public function home(): View
    {
        return view('home');
    }

    public function index(): View
    {
        return view('portfolios.index', ['portfolios' => auth()->user()->portfolios()->latest()->get()]);
    }

    public function create(): View
    {
        return view('portfolios.form', ['portfolio' => new Portfolio]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedPortfolio($request);
        $data['slug'] = Str::slug($data['full_name']).'-'.Str::lower(Str::random(6));
        $data['user_id'] = $request->user()->id;
        $data['template'] = 'simple';
        $this->storeProfilePicture($request, $data);

        $portfolio = Portfolio::create($data);

        return redirect()->route('portfolios.templates', $portfolio)->with('status', 'Portfolio saved. Choose a design to continue.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $this->ensureOwner($portfolio);

        return view('portfolios.form', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureOwner($portfolio);
        $data = $this->validatedPortfolio($request);
        $this->storeProfilePicture($request, $data, $portfolio);
        $portfolio->update($data);

        return redirect()->route('portfolios.preview', $portfolio)->with('status', 'Your changes are saved.');
    }

    public function templates(Portfolio $portfolio): View
    {
        $this->ensureOwner($portfolio);

        return view('portfolios.templates', compact('portfolio'));
    }

    public function setTemplate(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $this->ensureOwner($portfolio);
        $data = $request->validate(['template' => ['required', 'in:'.implode(',', self::TEMPLATES)]]);
        $portfolio->update($data);

        return redirect()->route('portfolios.preview', $portfolio)->with('status', 'Portfolio design updated.');
    }

    public function preview(Portfolio $portfolio): View
    {
        $this->ensureOwner($portfolio);

        return view('portfolios.preview', compact('portfolio'));
    }

    public function publicShow(Portfolio $portfolio): View
    {
        return view('portfolios.show', compact('portfolio'));
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->ensureOwner($portfolio);
        if ($portfolio->profile_picture) {
            Storage::disk('public')->delete($portfolio->profile_picture);
        }
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('status', 'Portfolio deleted.');
    }

    private function validatedPortfolio(Request $request): array
    {
        return $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'max:5000'],
            'profile_picture' => ['nullable', 'image', 'max:5120'],
            'education' => ['nullable', 'array'],
            'education.*.degree' => ['nullable', 'string', 'max:160'],
            'education.*.school' => ['nullable', 'string', 'max:160'],
            'education.*.dates' => ['nullable', 'string', 'max:100'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['nullable', 'string', 'max:80'],
            'projects' => ['nullable', 'array'],
            'projects.*.title' => ['nullable', 'string', 'max:160'],
            'projects.*.url' => ['nullable', 'url', 'max:500'],
            'projects.*.description' => ['nullable', 'string', 'max:2000'],
            'experience' => ['nullable', 'array'],
            'experience.*.role' => ['nullable', 'string', 'max:160'],
            'experience.*.company' => ['nullable', 'string', 'max:160'],
            'experience.*.dates' => ['nullable', 'string', 'max:100'],
            'experience.*.description' => ['nullable', 'string', 'max:2000'],
            'links' => ['nullable', 'array'],
            'links.*.label' => ['nullable', 'string', 'max:80'],
            'links.*.url' => ['nullable', 'url', 'max:500'],
        ]);
    }

    private function storeProfilePicture(Request $request, array &$data, ?Portfolio $portfolio = null): void
    {
        if (! $request->hasFile('profile_picture')) {
            unset($data['profile_picture']);

            return;
        }

        if ($portfolio?->profile_picture) {
            Storage::disk('public')->delete($portfolio->profile_picture);
        }

        $data['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
    }

    private function ensureOwner(Portfolio $portfolio): void
    {
        abort_unless($portfolio->user_id === auth()->id(), 404);
    }
}
