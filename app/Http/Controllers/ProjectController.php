<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Project;
use App\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        return response()->json($this->user->projects, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $project = new Project($request->all());
        $project->user_id = $this->user->id;
        $project->save();

        return response()->json($project, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param Project $project
     * @return JsonResponse
     */
    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        $project->update($request->input());
        return response()->json($project, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Project $project
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->tasks()->delete();

        return response()->json($project->delete());
    }
}
