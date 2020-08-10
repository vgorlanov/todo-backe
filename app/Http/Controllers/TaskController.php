<?php

namespace App\Http\Controllers;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->user->tasks()->with('project')->get();

        return response()->json($result, 200);
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
        return response()->json($task->update($request->input()), 200);
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
