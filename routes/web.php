<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Installation Wizard
Route::prefix('install')->group(function () {
    Route::get('/', [\App\Http\Controllers\InstallController::class, 'index'])->name('install.index');
    Route::post('/database', [\App\Http\Controllers\InstallController::class, 'setupDatabase'])->name('install.database');
    Route::post('/database/test', [\App\Http\Controllers\InstallController::class, 'testConnection'])->name('install.database.test');
    Route::post('/app', [\App\Http\Controllers\InstallController::class, 'setupApp'])->name('install.app');
    Route::post('/finalize', [\App\Http\Controllers\InstallController::class, 'finalize'])->name('install.finalize');
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
    Route::post('/business/manual-sync', [\App\Http\Controllers\Dashboard\BusinessController::class, 'manualSync'])->name('dashboard.business.manual-sync');
    Route::post('/business/branches', [\App\Http\Controllers\Dashboard\BusinessController::class, 'storeBranch'])->name('dashboard.business.branches.store');
    Route::put('/business/branches/{branch}', [\App\Http\Controllers\Dashboard\BusinessController::class, 'updateBranch'])->name('dashboard.business.branches.update');
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
    Route::get('/marketing', [\App\Http\Controllers\Dashboard\MarketingHubController::class, 'index'])->name('dashboard.marketing');
    Route::post('/marketing/ads', [\App\Http\Controllers\Dashboard\MarketingHubController::class, 'launchAds'])->name('dashboard.marketing.ads');

    // Creative Hub (Auto-Poster)
    Route::get('/creative-hub', [\App\Http\Controllers\Dashboard\CreativeHubController::class, 'index'])->name('dashboard.creative');
    Route::post('/creative-hub/generate/{festival}', [\App\Http\Controllers\Dashboard\CreativeHubController::class, 'generate'])->name('dashboard.creative.generate');

    // Social Scheduler
    Route::get('/scheduler', [\App\Http\Controllers\Dashboard\SocialSchedulerController::class, 'index'])->name('dashboard.scheduler');
    Route::post('/scheduler/post/{poster}', [\App\Http\Controllers\Dashboard\SocialSchedulerController::class, 'postNow'])->name('dashboard.scheduler.post');
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

        // AI Settings
        Route::get('/ai-settings', [\App\Http\Controllers\Admin\AiSettingsController::class, 'index'])->name('admin.ai-settings');
        Route::post('/ai-settings', [\App\Http\Controllers\Admin\AiSettingsController::class, 'update'])->name('admin.ai-settings.update');
        Route::post('/ai-settings/test', [\App\Http\Controllers\Admin\AiSettingsController::class, 'testConnection'])->name('admin.ai-settings.test');

        // Business Management
        Route::get('/businesses', [\App\Http\Controllers\Admin\BusinessManagementController::class, 'index'])->name('admin.businesses.index');
        Route::get('/businesses/{business}', [\App\Http\Controllers\Admin\BusinessManagementController::class, 'show'])->name('admin.businesses.show');
        Route::patch('/businesses/{business}/status', [\App\Http\Controllers\Admin\BusinessManagementController::class, 'updateStatus'])->name('admin.businesses.status');
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

// GMB OAuth Routes
Route::middleware('auth')->group(function () {
    Route::get('/auth/google/redirect', [\App\Http\Controllers\Auth\GmbAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GmbAuthController::class, 'handleCallback'])->name('auth.google.callback');
});

require __DIR__.'/auth.php';
