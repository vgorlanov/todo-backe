<?php

namespace App\Http\Controllers;

use App\Library\Order\Order;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    protected Order $order;

    /**
     * @var User
     */
    private User $user;

    public function __construct(Order $order)
    {
        $this->user = User::find(1);
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        $task = Task::find(5);

        // todo если нет проекта или даты или входящих


        $this->order->setModel($task)->setProject(4, 1);

        echo true;die;



//        return $this->user->tasks()->where('done', '=', Task::ACTIVE)->orWhere(static function ($query) {
//            $query->where('done', '=', Task::DONE)->where('date', '>=', now()->format('Y-m-d'));
//        })->orderBy('done', 'asc')->orderByRaw("cast(orders->'$.project' as unsigned) asc")->get();
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

    /**
     * @param Request $request
     * @param Task $task
     * @return JsonResponse
     */
    public function move(Request $request, Task $task, int $to): JsonResponse
    {

        switch ($to) {
            case 'project':
                $this->order->setModel($task)->setProject($request->get('position'), $request->get('project'));
                break;
            case 'active':
                $this->order->setModel($task)->setActive($request->get('position'), $request->get('date'));
                break;
            case 'new':
                $this->order->setModel($task)->setNew($request->get('position'));
                break;
        }

        return response()->json($task, 200);
    }
}
