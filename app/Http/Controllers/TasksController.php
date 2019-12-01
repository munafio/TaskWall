<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Add task to database and return it as a json response
     *
     * @param Request $request
     * @return JSON
     */
    public function add(Request $request){
        $id = (rand(9,999999999)+time()) * rand(0,999);
        Task::create([
            'id'      => $id,
            'user_id' => Auth::user()->id,
            'title'   => $request['title'],
            'body'    => $request['body'],
        ]);
        return response()->json(Task::find($id));
    }

    /**
     * Fetch tasks
     *
     * @return JSON
     */
    public function fetch(){
        $tasks = Task::where('user_id', Auth::user()->id)->orderBy('created_at');
        return response()->json(
            [
                'tasks' => $tasks->get(),
                'userTotalTasks' => $tasks->count()
            ]
        );
    }

    /**
     * Delete Task
     *
     * @param Request $request
     * @return JSON
     */
    public function delete(Request $request){
        return response()->json(Task::find($request['id'])->delete());
    }
}
