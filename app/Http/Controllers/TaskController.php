<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Catch_;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // $tasks = Task::where('user_id', Auth::id())->orderByDesc('id')->get();
            $tasks = Task::all();
            return $tasks;
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getChecklistWorks($request)
    {

        try {
            $tasks = Task::where('user_id', $request->user_id);
            Log::error($tasks);
            return $tasks;
        } catch (Exception $e) {
            Log::error($e);
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request, Task $task): JsonResponse
    {
        // 作成

        $request->merge([
            'user_id' => 1,
        ]);

        $task = Task::create($request->taskAttributes());
        return $task
            ? response()->json($task, 201)
            : response()->json([], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param [type] $id
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        Log::error($request->taskPatchAttribute());
        $task = Task::find($id);
        // $task->update($request->taskAttributes());

        // 更新
        return $task->update($request->taskPatchAttribute())
            ? response()->json($task, 200)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        // 論理削除
        $task = Task::findOrFail($id)->delete();

        return $task
            ? response()->json($task)
            : response()->json([], 500);
    }
}
