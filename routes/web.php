<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/dashboard/sync-gmb', [\App\Http\Controllers\Dashboard\DashboardController::class, 'syncGmb'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.sync-gmb');

Route::middleware(['auth', 'role:business_owner'])->group(function () {
    Route::get('/onboarding', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'index'])->name('onboarding');
    Route::post('/onboarding/step1', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'step1'])->name('onboarding.step1');
    Route::post('/onboarding/step2', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'step2'])->name('onboarding.step2');
    Route::post('/onboarding/step3', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'step3'])->name('onboarding.step3');
    Route::post('/onboarding/step4', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'step4'])->name('onboarding.step4');
    Route::post('/onboarding/step5', [\App\Http\Controllers\Dashboard\OnboardingController::class, 'step5'])->name('onboarding.step5');

    // Dashboard Sub-modules
    Route::get('/business', [\App\Http\Controllers\Dashboard\BusinessController::class, 'index'])->name('dashboard.business');
    Route::get('/qr', [\App\Http\Controllers\Dashboard\QrController::class, 'index'])->name('dashboard.qr');
    Route::get('/reviews', [\App\Http\Controllers\Dashboard\ReviewController::class, 'index'])->name('dashboard.reviews');
    Route::get('/feedback', [\App\Http\Controllers\Dashboard\FeedbackController::class, 'index'])->name('dashboard.feedback');
    Route::get('/analytics', [\App\Http\Controllers\Dashboard\AnalyticsController::class, 'index'])->name('dashboard.analytics');
    Route::get('/widgets', [\App\Http\Controllers\Dashboard\WidgetController::class, 'index'])->name('dashboard.widgets');

    // Google Reviews Management
    Route::get('/reviews/manage', [\App\Http\Controllers\Dashboard\ReviewsController::class, 'index'])->name('dashboard.reviews.manage');
    Route::get('/reviews/{review}/suggest', [\App\Http\Controllers\Dashboard\ReviewsController::class, 'generateSuggestion'])->name('dashboard.reviews.suggest');

    // Competitor Analysis
    Route::get('/competitors', [\App\Http\Controllers\Dashboard\CompetitorController::class, 'index'])->name('dashboard.competitors');

    // GMB Audit
    Route::get('/audit', [\App\Http\Controllers\Dashboard\AuditController::class, 'index'])->name('dashboard.audit');

    // Marketing & Ads
    Route::get('/marketing', [\App\Http\Controllers\Dashboard\MarketingController::class, 'index'])->name('dashboard.marketing');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // GMB Manager
    Route::middleware('role:gmb_manager')->prefix('manager')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Manager\ManagerController::class, 'index'])->name('manager.dashboard');
    });

    // Agency
    Route::middleware('role:marketer')->prefix('agency')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Agency\AgencyController::class, 'index'])->name('agency.dashboard');
    });

    // Reseller
    Route::middleware('role:reseller')->prefix('reseller')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Reseller\ResellerController::class, 'index'])->name('reseller.dashboard');
    });

    // Admin
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/ai-settings', [\App\Http\Controllers\Admin\AiSettingsController::class, 'index'])->name('admin.ai-settings');
        Route::post('/ai-settings', [\App\Http\Controllers\Admin\AiSettingsController::class, 'update'])->name('admin.ai-settings.update');
    });
});

// Customer Review Flow
Route::prefix('r')->group(function () {
    Route::get('/{slug}', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'start'])->name('review.start');
    Route::post('/{slug}/rate', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'submitRating'])->name('review.rate');
    Route::get('/{slug}/questions', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'showMCQ'])->name('review.questions');
    Route::post('/{slug}/questions', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'submitMCQ'])->name('review.submit_mcq');
    Route::get('/{slug}/reviews', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'showDrafts'])->name('review.drafts');
    Route::get('/{slug}/redirect', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'googleRedirect'])->name('review.redirect');
    Route::get('/{slug}/feedback', [\App\Http\Controllers\ReviewFlow\ReviewFlowController::class, 'showPrivateFeedback'])->name('review.feedback');
});

require __DIR__.'/auth.php';
