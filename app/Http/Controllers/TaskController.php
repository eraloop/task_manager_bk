<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function index(Request $request)
    {
        $tasks = Task::paginate(5);
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,completed',
        ]);
    
        $task = Task::create($validated);
    
        return response()->json(new TaskResource($task), 201);
    }
    
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
    
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:pending,completed',
        ]);
    
        $task->update($validated);
    
        return response()->json(new TaskResource($task));
    }
    


    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->noContent(); 
    }

    public function toggleStatus($id)
    {
        $task = Task::findOrFail($id);
        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();

        return new TaskResource($task);
    }
}
