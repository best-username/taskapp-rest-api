<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\PhotoTrait;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PhotoTrait;

    protected $image;
    protected $size;
    protected $task_id;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image, $size, $id)
    {
        $this->image = $image;
        $this->size = $size;
        $this->task_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filename = $this->savePhoto($this->image, $this->size);
        $task = \App\Task::findOrFail($this->task_id);
        if($this->size == \App\Task::MOBILE_IMAGE_SIZE) {
            $task->image_mobile = $filename;
        }elseif($this->size == \App\Task::DESKTOP_IMAGE_SIZE) {
            $task->image_desktop = $filename;
        }
        $task->save();
//        dd($filename, $task);
        return $filename;
    }
}
