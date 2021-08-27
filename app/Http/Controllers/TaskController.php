<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\UpdateTask;
use App\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getTasks(Request $request)
    {
        $tasks = Task::query()->with(['user','status','history']);

        if ($request->has('filters')) {
            foreach($request->input('filters') as $filter){
                $tasks->where($filter['column'], $filter['value']);
            }
        }

        if ($request->has('sort')) {
            $sorting = $request->input('sort');

            if (!empty($sorting['column']) && !empty($sorting['order'])) {
                $order = 'asc';

                if ($sorting['order'] == 'descending') {
                    $order = 'desc';
                }

                $tasks->orderBy($sorting['column'], $order);
            }
        }

        $tasks->where('active', true);

        return response()->json([
            'tasks' => $tasks->paginate($request->input('count', 10))
        ]);
    }

    public function getTasksByUserId(Request $request, $user_id)
    {
        $tasks = Task::query()->with(['user','status','history']);

        if ($request->has('filters')) {
            foreach($request->input('filters') as $filter){
                $tasks->where($filter['column'], $filter['value']);
            }
        }

        if ($request->has('sort')) {
            $sorting = $request->input('sort');

            if (!empty($sorting['column']) && !empty($sorting['order'])) {
                $order = 'asc';

                if ($sorting['order'] == 'descending') {
                    $order = 'desc';
                }

                $tasks->orderBy($sorting['column'], $order);
            }
        }

        $tasks->where('user_id', $user_id);
        $tasks->where('active', true);

        return response()->json([
            'tasks' => $tasks->paginate($request->input('count', 10))
        ]);
    }

    public function createTask(CreateTask $request)
    {
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $user = Auth::user();

        $action = 'Пользователь '. $user->name . ' создал задание "'. $task->name .'"';

        TaskHistory::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'action' => $action
        ]);

        return response()->json([
            'message' => 'success',
            'task' => $task
        ]);
    }

    public function updateTask(UpdateTask $request, $id)
    {
        $task = Task::find($id);

        if(empty($task)){
            abort(404);
        }

        $user = Auth::user();
        if(!empty($request->all())){
            foreach($request->all() as $key => $value){
                if($task->$key !== $value){
                    switch ($key) {
                        case 'name':
                            $action = 'Пользователь '. $user->name . ' изменил название задания "'. $task->name .'" на "'. $value .'"';
                            break;
                        case 'description':
                            $action = 'Пользователь '. $user->name . ' изменил описание в задании "'. $task->name .'" на "'. $value .'"';
                            break;
                        case 'deadline_date':
                            $action = 'Пользователь '. $user->name . ' изменил дату выполнения в задании "'. $task->name .'" на "'. $value .'"';
                            break;
                        case 'user_id':
                            $action = 'Пользователь '. $user->name . ' изменил привязаного пользователя в задании "'. $task->name .'" на "'. $value .'"';
                            break;
                        case 'status_id':
                            $action = 'Пользователь '. $user->name . ' изменил статус в задании "'. $task->name .'" на "'. $value .'"';
                            break;
                    }
                    TaskHistory::create([
                        'user_id' => $user->id,
                        'task_id' => $task->id,
                        'action' => $action
                    ]);
                }
            }
        }

        $task->update($request->all());

        return response()->json([
            'message' => 'success',
            'task' => $task
        ]);
    }

    public function deleteTask($id)
    {
        $task = Task::find($id);

        if(empty($task)){
            abort(404);
        }

        $task->update(['active' => false]);

        return response()->json([
            'message' => 'success'
        ]);
    }

}
