<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/quests/{slug}', [PortfolioController::class, 'show'])->name('quests.show');
Route::get('/character-record', [PortfolioController::class, 'record'])->name('record.download');
