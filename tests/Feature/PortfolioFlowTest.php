<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_and_create_a_portfolio(): void
    {
        $this->post('/register', [
            'name' => 'Morgan Lee',
            'email' => 'morgan@example.com',
            'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
        ])->assertRedirect('/dashboard')->assertSessionHasNoErrors();

        $this->assertAuthenticated();
        $this->post('/portfolios', $this->portfolioDetails())
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $portfolio = Portfolio::firstOrFail();
        $this->assertSame('Morgan Lee', $portfolio->full_name);
        $this->assertSame(['Product design', 'Research'], $portfolio->skills);
        $this->assertDatabaseHas('portfolios', ['user_id' => auth()->id(), 'email' => 'morgan@example.com']);
    }

    public function test_a_user_can_choose_preview_update_and_delete_a_portfolio(): void
    {
        $user = User::factory()->create();
        $portfolio = $user->portfolios()->create($this->portfolioDetails() + [
            'slug' => 'morgan-portfolio',
            'template' => 'simple',
        ]);

        $this->actingAs($user)
            ->put(route('portfolios.template', $portfolio), ['template' => 'creative'])
            ->assertRedirect(route('portfolios.preview', $portfolio));

        $this->get(route('portfolios.preview', $portfolio))->assertOk()->assertSee('Creative portfolio');
        $this->get(route('portfolios.public', $portfolio))->assertOk()->assertSee('Morgan Lee')->assertSee('Selected project');

        $this->put(route('portfolios.update', $portfolio), $this->portfolioDetails(['full_name' => 'Morgan Lee Jr.']))
            ->assertRedirect(route('portfolios.preview', $portfolio));
        $this->assertDatabaseHas('portfolios', ['id' => $portfolio->id, 'full_name' => 'Morgan Lee Jr.']);

        $this->delete(route('portfolios.destroy', $portfolio))->assertRedirect(route('portfolios.index'));
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    public function test_portfolios_are_not_manageable_by_another_user(): void
    {
        $owner = User::factory()->create();
        $portfolio = $owner->portfolios()->create($this->portfolioDetails() + ['slug' => 'private-portfolio']);

        $this->actingAs(User::factory()->create())
            ->get(route('portfolios.edit', $portfolio))
            ->assertNotFound();
    }

    public function test_forwarded_https_host_is_used_for_navigation_and_registration_redirects(): void
    {
        $headers = [
            'Host' => 'localhost:8000',
            'X-Forwarded-Host' => 'preview.example.test',
            'X-Forwarded-Proto' => 'https',
        ];

        $this->withHeaders($headers)
            ->get('/login')
            ->assertOk()
            ->assertSee('href="https://preview.example.test/register"', false);

        $this->withHeaders($headers)->post('/register', [
            'name' => 'Taylor Test',
            'email' => 'taylor@example.com',
            'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
        ])->assertRedirect('https://preview.example.test/dashboard');
    }

    private function portfolioDetails(array $overrides = []): array
    {
        return array_replace([
            'full_name' => 'Morgan Lee',
            'email' => 'morgan@example.com',
            'about' => 'A product designer with a curious streak.',
            'education' => [['degree' => 'BDes', 'school' => 'North College', 'dates' => '2020–2024']],
            'skills' => ['Product design', 'Research'],
            'projects' => [['title' => 'Selected project', 'url' => 'https://example.com', 'description' => 'A thoughtful project.']],
            'experience' => [['role' => 'Designer', 'company' => 'Fieldwork', 'dates' => '2024–now', 'description' => 'Built useful things.']],
            'links' => [['label' => 'Website', 'url' => 'https://example.com']],
        ], $overrides);
    }
}
