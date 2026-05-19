<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Live PMO Dashboard Route Matrix
Route::get('/pmo-dashboard', function () {
    // 1. Fetch entries that are waiting to be processed or mapped by PMO
    $pendingLogs = DB::table('dpr_logs')
        ->where('status', 'pending_mapping')
        ->orderBy('created_at', 'desc')
        ->get();

    // 2. Fetch master cost codes for the dropdown manual assignment panel
    $costCodes = DB::table('cost_codes')->get();

    // 3. Count macro statistics dynamically
    $totalActiveSites = DB::table('projects')->count();
    $submissionsToday = DB::table('dpr_logs')->whereDate('created_at', today())->count();
    $pendingMappingCount = DB::table('dpr_logs')->where('status', 'pending_mapping')->count();

    return view('pmo-dashboard', compact('pendingLogs', 'costCodes', 'totalActiveSites', 'submissionsToday', 'pendingMappingCount'));
});

// Action Route: Process and verify the submitted records
Route::post('/verify-dpr/{id}', function (\Illuminate\Http\Request $request, $id) {
    DB::table('dpr_logs')->where('id', $id)->update([
        'cost_code_mapped' => $request->input('cost_code'),
        'status' => 'verified',
        'updated_at' => now()
    ]);

    return back()->with('verified_success', 'Site entry successfully verified and mapped to project accounts!');
})->name('dpr.verify');
// Live CEO Command Center Route Matrix
Route::get('/ceo-dashboard', function () {
    // 1. Pull only entries that have been checked and verified by the PMO
    $verifiedLogs = DB::table('dpr_logs')
        ->where('status', 'verified')
        ->orderBy('updated_at', 'desc')
        ->get();

    // 2. Compute live aggregate analytics across operations
    $totalManpowerDeployed = DB::table('dpr_logs')->where('status', 'verified')->sum('labor_count');
    $totalVerifiedTasks = DB::table('dpr_logs')->where('status', 'verified')->count();
    
    // 3. Count how many critical material challans have hit the systems
    $materialChallansCount = DB::table('dpr_logs')
        ->where('status', 'verified')
        ->whereNotNull('challan_no')
        ->count();

    return view('ceo-dashboard', compact('verifiedLogs', 'totalManpowerDeployed', 'totalVerifiedTasks', 'materialChallansCount'));
});
use App\Http\Controllers\DprController;
use Illuminate\Support\Facades\DB;

// Site Engineer Form Route
Route::get('/engineer-form', function () {
    $projects = DB::table('projects')->get();
    return view('engineer-form', compact('projects'));
});

// Form Submission Action Route
Route::post('/submit-dpr', [DprController::class, 'store'])->name('dpr.store');

require __DIR__.'/auth.php';
