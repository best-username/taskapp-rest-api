<?php

namespace App\Services;

use Auth;
use App\Task;
use App\Jobs\ProcessImage;
use App\Events\TaskUpdated;
use App\Http\Traits\PhotoTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\TaskCreateRequest;
use Illuminate\Support\Facades\Log;

class TaskService {
    
    use PhotoTrait;

    public function storeTask(TaskCreateRequest $request) {
        
        DB::beginTransaction();

        try {
            $task = new Task($request->validated());
            $image = $this->savePhoto($request->image);
            $task->creator()->associate(Auth::user()->id);
            $task->save();
            $task->boards()->attach($request->board_id);
            $imageFile = base64_encode(File::get($image));
            ProcessImage::dispatch($imageFile, Task::DESKTOP_IMAGE_SIZE, $task->id);
            ProcessImage::dispatch($imageFile, Task::MOBILE_IMAGE_SIZE, $task->id);
            TaskUpdated::dispatch($task, 'create');
        } catch (\Exception $e) {
//            Log::error($e->getMessage());
            DB::rollBack();
            throw $e;
        }
        
        DB::commit();
        return $task;
        
    }
    
}
