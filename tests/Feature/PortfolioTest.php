<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    public function test_home_shows_the_four_projects_and_honest_contact_availability(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSeeText('Muhammad')
            ->assertSeeText('QRIS Cross-Border Analysis')
            ->assertSeeText('Smart Buoy Rip Current Early Warning System')
            ->assertSeeText('Indoor Air Quality Monitoring')
            ->assertSeeText('Unity AI Body Tracking')
            ->assertSeeText('Belum ditambahkan');
    }

    public function test_quest_is_accessible_without_javascript_and_discloses_unknown_results(): void
    {
        $response = $this->get('/quests/qris-cross-border');

        $response->assertOk()
            ->assertSeeText('QRIS Cross-Border Analysis')
            ->assertSeeText('Known results')
            ->assertSeeText('Temuan analisis, ukuran dataset, performa, dan bukti implementasi belum diberikan.')
            ->assertSeeText('Repository dan live demo belum ditambahkan.');
    }

    public function test_unknown_quest_returns_not_found(): void
    {
        $this->get('/quests/unknown-project')
            ->assertNotFound()
            ->assertSeeText('This quest is uncharted.');
    }

    public function test_character_record_download_is_identified_as_a_summary(): void
    {
        Storage::fake('public');

        $response = $this->get('/character-record');

        $response->assertOk()
            ->assertDownload('Muhammad-Zidane-Character-Record.txt')
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSeeText('Ringkasan profil, bukan CV lengkap.')
            ->assertSeeText('PostgreSQL, n8n, Docker, Metabase');
    }

    public function test_real_cv_is_downloaded_when_the_owner_has_added_it(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('muhammad-zidane-cv.pdf', 'CV download fixture');

        $response = $this->get('/character-record');

        $response->assertOk()->assertDownload('Muhammad-Zidane-CV.pdf');
        Storage::disk('public')->assertExists('muhammad-zidane-cv.pdf');
    }

    public function test_configured_project_titles_are_escaped_in_html(): void
    {
        config(['portfolio.projects.0.title' => '<script>alert("test")</script>']);

        $response = $this->get('/quests/qris-cross-border');

        $response->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert("test")</script>', false);
    }
}
