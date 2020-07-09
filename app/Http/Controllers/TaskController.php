<?php

namespace App\Http\Controllers;

use Auth;
use App\Task;
use App\Label;
use App\Board;
use Illuminate\Http\Request;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\TaskAttachToBoardRequest;
use App\Events\TaskUpdated;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /** @api {get} {{host}}/api/tasks
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['success' => true, 'data' => TaskResource::collection(Task::with(['boards', 'labels'])->get())]);
    }

    /** @api {post} {{host}}/api/task
     * Store a newly created resource in storage.
     */
    public function store(TaskCreateRequest $request)
    {
        $task = (new TaskService())->storeTask($request);
        return response()->json(['success' => true, 'data' => new TaskResource($task)]);
    }

    /** @api {get} {{host}}/api/task/1
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json(['success' => true, 'data' => new TaskResource($task)]);
    }

    /** @api {put} {{host}}/api/task/58
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        TaskUpdated::dispatch($task, 'update');
        return response()->json(['success' => $task->update($request->validated()), 'data' => new TaskResource($task)]);
    }

    /** @api {destroy} {{host}}/api/task/58
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        TaskUpdated::dispatch($task, 'delete');
        return response()->json(['success' => $task->delete()]);
    }
    
    /** @api {task/attach} {{host}}/api/task/attach
     * Attach the specified resource to the Board object.
     */
    public function attachToBoard(TaskAttachToBoardRequest $request)
    {
        $task = Task::findOrFail($request->task_id);
        $board = Board::findOrFail($request->board_id);
        $this->authorize('attachToBoard', [$task, $board]);
        $task->boards()->attach($board);

        return response()->json(['success' => true, 'data' => $task->load('boards')]);
    }
    
    /** @api {tasks/label/{label}} {{host}}/api/tasks/label/{$label_id}
     * Attach the specified resource to the Board object.
     */
    public function getByLabel(Label $label)
    {
        return response()->json(['success' => true, 'data' => $label->tasks]);
    }
    
    /** @api {tasks/label/{label}} {{host}}/api/tasks/status/{status}
     * Attach the specified resource to the Board object.
     */
    public function getByStatus($status)
    {
        $tasks = Task::where('status', $status)->get();
        return response()->json(['success' => true, 'data' => TaskResource::collection($tasks)]);
    }
}
