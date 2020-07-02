<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskAttachToBoardRequest;

class TaskController extends Controller
{
    /** @api {get} {{host}}/api/tasks
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        return response()->json(['success' => true, 'data' => $task->all()->load('boards')]);
    }

    /** @api {post} {{host}}/api/task
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request)
    {
        $task = new Task($request->all());
        return response()->json(['success' => $task->save(), 'data' => $task]);
    }

    /** @api {get} {{host}}/api/task/1
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(['success' => true, 'data' => $task]);
    }

    /** @api {put} {{host}}/api/task/58
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        return response()->json(['success' => $task->update($request->all()), 'data' => $task]);
    }

    /** @api {destroy} {{host}}/api/task/58
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        return response()->json(['success' => $task->delete()]);
    }
    
    /** @api {task/attach} {{host}}/api/task/attach
     * Attach the specified resource to the Board object.
     */
    public function attachToBoard(TaskAttachToBoardRequest $request)
    {
        $task = Task::find($request->task_id);
        $task->boards()->attach($request->board_id);

        return response()->json(['success' => true, 'data' => $task]);
    }
}
