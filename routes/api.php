
<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/update/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/delete/{id}', [TaskController::class, 'destroy']);
Route::put('/tasks/{id}/toggle-status', [TaskController::class, 'toggleStatus']);