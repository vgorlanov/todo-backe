<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskRequest;
use App\Task;
use App\User;


class TaskController extends Controller
{
    /**
     * @var User
     */
    private User $user;

    public function __construct()
    {
        $this->user = User::find(1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        $task = Task::find(1);

        $task->setOrder('project', 4);
        $result = $task->getOrder('project');





        return $this->user->tasks()->where('done', '=', Task::ACTIVE)->orWhere(static function ($query) {
            $query->where('done', '=', Task::DONE)->where('date', '>=', now()->format('Y-m-d'));
        })->orderBy('done', 'asc')->orderByRaw("cast(orders->'$.project' as unsigned) asc")->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $task = new Task($request->all());
        $task->user_id = $this->user->id;
        $task->save();

        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->input());
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Task $task): JsonResponse
    {
        return response()->json($task->delete());
    }
}
