<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio.index', $this->viewData());
    }

    public function show(string $slug): View
    {
        $data = $this->viewData();
        $project = collect($data['portfolio']['projects'])->firstWhere('slug', $slug);

        abort_if($project === null, 404);

        return view('portfolio.quest', [...$data, 'project' => $project]);
    }

    public function record(): Response
    {
        if (Storage::disk('public')->exists('muhammad-zidane-cv.pdf')) {
            return Storage::disk('public')->download('muhammad-zidane-cv.pdf', 'Muhammad-Zidane-CV.pdf');
        }

        $portfolio = config('portfolio');
        $lines = [
            'MUHAMMAD ZIDANE | CHARACTER RECORD',
            'Ringkasan profil, bukan CV lengkap.',
            '',
            'Mahasiswa Teknik Komputer',
            'Institut Teknologi Sepuluh Nopember (ITS)',
            '',
            'PROYEK',
        ];

        foreach ($portfolio['projects'] as $project) {
            $lines[] = $project['title'];
            $lines[] = 'Teknologi: '.implode(', ', $project['technologies']);
            $lines[] = '';
        }

        $lines[] = 'Kontak: '.($portfolio['email'] ?: 'Belum ditambahkan.');
        $lines[] = 'Riwayat kerja, tanggal, dan metrik hasil proyek belum diberikan.';

        return response(implode("\n", $lines)."\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Muhammad-Zidane-Character-Record.txt"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /** @return array{portfolio: array<string, mixed>, cvAvailable: bool} */
    private function viewData(): array
    {
        return [
            'portfolio' => config('portfolio'),
            'cvAvailable' => Storage::disk('public')->exists('muhammad-zidane-cv.pdf'),
        ];
    }
}
