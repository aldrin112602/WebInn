<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

require_once __DIR__ . '/root/admin.php';
require_once __DIR__ . '/root/teacher.php';
require_once __DIR__ . '/root/student.php';
// require_once __DIR__ . '/root/guidance.php';
require_once __DIR__ . '/root/public.php';

Route::get('/clear-cache', function () {
    try {
        Artisan::call('config:cache');
        Artisan::call('cache:clear');
        return response()->json(['success' => true, 'message' => 'Cache cleared successfully!'], 200);
    } catch (Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to clear cache: ' . $e->getMessage()], 500);
    }
});
