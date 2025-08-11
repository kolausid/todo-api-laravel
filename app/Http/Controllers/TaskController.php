<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // GET /api/tasks
    public function index()
    {
        // Возвращаем все задачи. Для больших проектов нужно сделать пагинацию.
        $tasks = Task::all();

        // Возвращаем JSON-ответ
        return response()->json([
            'data' => $tasks,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // POST /api/tasks
    public function store(Request $request)
    {
        // Валидация входных данных
            $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            // статус - обычная строка, но мы ограничим допустимые значения через in
            'status'      => 'nullable|in:pending,in_progress,done']);

        // Создаём задачу
        $task = Task::create($validated);

        return response()->json([
            'message' => 'Task created',
            'data' => $task,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // GET /api/tasks/{id}
    public function show($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $task,
        ], Response::HTTP_OK);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // PUT /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,done',
        ]);

        // Обновляем поля
        $task->update($validated);

        return response()->json([
            'message' => 'Task updated',
            'data' => $task,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], Response::HTTP_NOT_FOUND);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted',
        ], Response::HTTP_NO_CONTENT);
    }
}
