<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TimeTrackingController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChartController;

use App\Models\Status;
use App\Models\Project;
use App\Models\ProjectStatus;
use Carbon\Carbon;


Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('home.index');
});

Route::get('/dashboard', function () {
    $today = Carbon::now()->settings(['locale' => app()->getLocale()]);
    $dateMessage = $today->format('l, j.F.Y');
    $user = Auth::user();
    $projectStatus = ProjectStatus::all();
    $status = Status::all();
    $projects = Project::all();

    // Create charts
    $chartController = app(ChartController::class);
    $charts = $chartController->getDashboardCharts();
    $projectStatusChart = $charts['projectStatusChart'];
    $issueStatusBarChart = $charts['issueStatusBarChart'];

    // Get user issues
    $userIssues = $user->getAssignedIssuesSorted(5);

    // Get recently updated active projects
    $userProjects = $user->getRecentlyUpdatedActiveProjects(5);

    // Get dynamic issue counts
    $totalIssues = $user->assignedIssues()->count() + $user->createdIssues()->count();
    
    // Get open issues
    $closedStatusId = $status->where('name', 'closed')->value('id');
    $openIssues = $user->assignedIssues()->where('status_id', '!=', $closedStatusId)->count() + $user->createdIssues()->where('status_id', '!=', $closedStatusId)->count();

    // Get dynamic project counts
    $totalProjects = $user->projects()->count();
    $activeProjects = $user->projects()->active()->count();
    
    // Get completed projects
    $completedStatusId = $projectStatus->where('name', 'completed')->value('id');
    $completedProjectsInMonth = $projects->where('status_id', $completedStatusId)
        ->where('created_at', '>=', now()->startOfMonth())
        ->count();
    
    // Get total logged time for current user across all projects
    $totalLoggedTime = $user->getFormattedTotalLoggedTime();

    // Get recent activities for the user
    $recentActivities = $user->getRecentActivities(8);
    
    return view('admin.index', compact('dateMessage', 'totalIssues', 'openIssues', 'totalLoggedTime', 'activeProjects', 'totalProjects', 'projectStatusChart', 'issueStatusBarChart', 'completedProjectsInMonth', 'userIssues', 'userProjects', 'recentActivities'));
})->middleware(['auth', 'verified'])->name('dashboard');

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

    // Issues routes
    Route::get('/dashboard/issues', [IssueController::class, 'ShowIssues'])->name('admin.issues');
    Route::get('/dashboard/issues/create', [IssueController::class, 'ShowCreateIssue'])->name('admin.issues.create');
    Route::post('/dashboard/issues/create', [IssueController::class, 'CreateIssue'])->name('admin.issues.create-issue');
    Route::get('/dashboard/issues/{id}', [IssueController::class, 'ShowSingleIssue'])->name('admin.issues.show');
    Route::get('/dashboard/issues/{id}/edit', [IssueController::class, 'ShowSingleIssueEdit'])->name('admin.issues.edit');
    Route::put('/dashboard/issues/{id}', [IssueController::class, 'UpdateIssue'])->name('admin.issues.update');
    Route::delete('/dashboard/issues/{id}', [IssueController::class, 'DeleteIssue'])->name('admin.issues.destroy');
    Route::put('/dashboard/issues/{id}/close', [IssueController::class, 'CloseIssue'])->name('admin.issues.close');

    // Projects routes
    Route::get('/dashboard/projects', [ProjectsController::class, 'ShowProjects'])->name('admin.projects');
    Route::get('/dashboard/projects/create', [ProjectsController::class, 'ShowCreateProject'])->name('admin.projects.create');
    Route::post('/dashboard/projects/create', [ProjectsController::class, 'CreateProject'])->name('admin.projects.create-project');
    Route::get('/dashboard/projects/{id}', [ProjectsController::class, 'ShowSingleProject'])->name('admin.projects.show');
    Route::get('/dashboard/projects/{id}/edit', [ProjectsController::class, 'ShowSingleProjectEdit'])->name('admin.projects.edit');
    Route::put('/dashboard/projects/{id}', [ProjectsController::class, 'UpdateProject'])->name('admin.projects.update');
    Route::delete('/dashboard/projects/{id}', [ProjectsController::class, 'DeleteProject'])->name('admin.projects.destroy'); // Done
    Route::post('/dashboard/projects/{id}/complete', [ProjectsController::class, 'CompleteProject'])->name('admin.projects.complete');
    Route::post('/dashboard/projects/{id}/hold', [ProjectsController::class, 'HoldProject'])->name('admin.projects.hold');
    
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
        
    // Time tracking routes
    Route::post('/dashboard/issues/{id}/time', [TimeTrackingController::class, 'logTime'])->name('admin.issues.log-time');
    Route::patch('/dashboard/issues/{id}/estimate', [TimeTrackingController::class, 'setEstimate'])->name('admin.issues.set-estimate');
    Route::get('/dashboard/issues/{id}/time-entries', [TimeTrackingController::class, 'getTimeEntries'])->name('admin.issues.time-entries');
    Route::delete('/dashboard/time-entries/{id}', [TimeTrackingController::class, 'deleteTimeEntry'])->name('admin.time-entries.delete');
    Route::get('/dashboard/time/summary', [TimeTrackingController::class, 'getUserTimeSummary'])->name('admin.time.summary');
    
    // Chart API routes
    Route::get('/api/charts/data', [ChartController::class, 'getChartData'])->name('api.charts.data');
    Route::get('/api/charts/colors', [ChartController::class, 'getChartColors'])->name('api.charts.colors');
});
