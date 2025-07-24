<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TimeTrackingController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChartController;

Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('home.index');
});

Route::get('/dashboard', function () {
    $today = \Carbon\Carbon::now()->settings(['locale' => app()->getLocale()]);
    $dateMessage = $today->format('l, j.F.Y');

    // Create charts using the controller
    $chartController = app(ChartController::class);
    $charts = $chartController->getDashboardCharts();
    $projectStatusChart = $charts['projectStatusChart'];
    $issueStatusBarChart = $charts['issueStatusBarChart'];

    // Get dynamic issue counts
    $totalIssues = \App\Models\Issue::count();
    $openIssues = \App\Models\Issue::where('status_id', '!=', 6)->count();

    // Get dynamic project counts
    $totalProjects = \App\Models\Project::count();
    $activeProjects = \App\Models\Project::active()->count();
    $completedProjectsInMonth = \App\Models\Project::where('status', 'completed')->where('created_at', '>=', now()->startOfMonth())->count();
    
    // Get total logged time for current user across all projects
    $totalLoggedTime = \Illuminate\Support\Facades\Auth::user()->getFormattedTotalLoggedTime();
    
    return view('admin.index', compact('dateMessage', 'totalIssues', 'openIssues', 'totalLoggedTime', 'activeProjects', 'totalProjects', 'projectStatusChart', 'issueStatusBarChart', 'completedProjectsInMonth'));
})->middleware(['auth', 'verified'])->name('dashboard');

/* Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::post('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login'); // Two-factor authentication
Route::get('/verify', [AdminController::class, 'ShowVerification'])->name('custom.verification.form');
Route::post('/verify', [AdminController::class, 'VerificationVerify'])->name('custom.verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/profile/store', [AdminController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/profile/password/update', [AdminController::class, 'PasswordUpdate'])->name('admin.password.update');

    Route::get('/dashboard/issues', [IssueController::class, 'ShowIssues'])->name('admin.issues');
    Route::get('/dashboard/issues/{id}', [IssueController::class, 'ShowSingleIssue'])->name('admin.issues.show');
    Route::get('/dashboard/issues/{id}/edit', [IssueController::class, 'ShowSingleIssueEdit'])->name('admin.issues.edit');
    Route::put('/dashboard/issues/{id}', [IssueController::class, 'UpdateIssue'])->name('admin.issues.update');
    Route::patch('/dashboard/issues/{id}/status', [IssueController::class, 'UpdateStatus'])->name('admin.issues.update-status');

    // Projects routes
    Route::get('/dashboard/projects', [ProjectsController::class, 'ShowProjects'])->name('admin.projects');
    Route::get('/dashboard/projects/{id}', [ProjectsController::class, 'ShowSingleProject'])->name('admin.projects.show');
    
    // Offers routes
    Route::resource('/dashboard/offers', OfferController::class, [
        'names' => [
            'index' => 'admin.offers.index',
            'create' => 'admin.offer.admin_offers_create',
            'store' => 'admin.offers.store',
            'show' => 'admin.offer.admin_offers_show',
            'edit' => 'admin.offers.edit',
            'update' => 'admin.offers.update',
            'destroy' => 'admin.offers.destroy',
        ]
    ]);
    
    // Offer status routes
    Route::post('/dashboard/offers/{offer}/send', [OfferController::class, 'markAsSent'])->name('admin.offers.send');
    Route::post('/dashboard/offers/{offer}/accept', [OfferController::class, 'markAsAccepted'])->name('admin.offers.accept');
    Route::post('/dashboard/offers/{offer}/reject', [OfferController::class, 'markAsRejected'])->name('admin.offers.reject');
    
    // User assignment routes
    Route::patch('/dashboard/issues/{id}/assignment', [IssueController::class, 'UpdateAssignment'])->name('admin.issues.update-assignment');
    
    // Time tracking routes
    Route::post('/dashboard/issues/{id}/time', [TimeTrackingController::class, 'logTime'])->name('admin.issues.log-time');
    Route::patch('/dashboard/issues/{id}/estimate', [TimeTrackingController::class, 'setEstimate'])->name('admin.issues.set-estimate');
    Route::get('/dashboard/issues/{id}/time-entries', [TimeTrackingController::class, 'getTimeEntries'])->name('admin.issues.time-entries');
    Route::delete('/dashboard/time-entries/{id}', [TimeTrackingController::class, 'deleteTimeEntry'])->name('admin.time-entries.delete');
    Route::get('/dashboard/time/summary', [TimeTrackingController::class, 'getUserTimeSummary'])->name('admin.time.summary');
    
    // Chart API routes (simplified for the 4 required charts only)
    Route::get('/api/charts/data', [ChartController::class, 'getChartData'])->name('api.charts.data');
    Route::get('/api/charts/colors', [ChartController::class, 'getChartColors'])->name('api.charts.colors');
});
