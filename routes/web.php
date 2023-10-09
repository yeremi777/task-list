<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
	return redirect()->route('tasks.index');
});

# Tasks
Route::group(['prefix' => 'tasks'], function () {
    Route::get('', function () {
        return view('index', [
            'tasks' => \App\Models\Task::latest()->paginate(10)
        ]);
    })->name('tasks.index');

    Route::view('/create', 'create')->name('tasks.create');
    Route::get('/{task}/edit', function (Task $task) {
        return view('edit', [
            'task' => $task
        ]);
    })->name('tasks.edit');

    Route::get('/{task}', function (Task $task) {
        return view('show', [
            'task' => $task
        ]);
    })->name('tasks.show');

    Route::post('', function (TaskRequest $request) {
        $task = Task::create($request->validated());

        return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task created successfully!');
    })->name('tasks.store');

    Route::put('/{task}', function (Task $task, TaskRequest $request) {
        $task->update($request->validated());

        return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task updated successfully!');
    })->name('tasks.update');

    Route::delete('/{task}', function (Task $task) {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    })->name('tasks.destroy');

    Route::put('/{task}/toggle-complete', function (Task $task) {
        $task->toggleComplete();

        return redirect()->back()->with('success', 'Task updated successfully!');
    })->name('tasks.toggle-complete');
});

Route::fallback(function () {
    return '404 NOT FOUND';
    // abort(Response::HTTP_NOT_FOUND);
});
