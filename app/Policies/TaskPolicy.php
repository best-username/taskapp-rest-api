<?php

namespace App\Policies;

use App\Task;
use App\User;
use App\Board;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->creator_id;
    }
    
    /**
     * Determine whether the user can attach task to the board.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @param  \App\Board  $board
     * @return mixed
     */
    public function attachToBoard(User $user, Task $task, Board $board)
    {
        return $user->id === $task->creator_id && $user->id === $board->creator_id; 
    }

}
