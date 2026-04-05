<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function createTask(TaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'priority' => $request->priority,
        ]);

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task has been Added!'
        ], 201);
    }

    public function getTasks(Request $request)
    {
        $query = Task::query();
        //filter by status
        if ($request->has('status')) $query->where('status', $request->status);
        //filter by priority
        if ($request->has('priority')) $query->where('priority', $request->priority);
        //search by title
        if ($request->has('search')) $query->where('title', 'like', "%{$request->search}%");
        // Sorting 
        //if the request has sort parameter sort by that parameter otherwise sort by priority and due date
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'due_date') {
                $query->orderBy('due_date', 'ASC');
            } elseif ($sort === 'priority') {
                $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC");
            }
        } else {
            $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') ASC")
                ->orderBy('due_date', 'ASC');
        }

        return response()->json([
            'success' => true,
            'data' => $query->get(),
            'message' => 'Tasks retrieved successfully'
        ]);
    }

    public function GetSingleTask($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['success' => false, 'data' => null, 'message' => 'Task not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $task, 'message' => 'Task retrieved successfully'], 200);
    }

    public function updateTask(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $newStatus = $request->input('status');
        //if the new status is different from the current status
        if ($newStatus && $newStatus !== $task->status) {
            //if the task is already done, we cannot update it
            if ($task->status === 'done') {
                return response()->json(['success' => false, 'data' => null, 'message' => 'Cannot update a completed task'], 422);
            }
            //if the task is pending and the new status is done, we cannot update it until it goes through in_progress
            if ($task->status === 'pending' && $newStatus === 'done') {
                return response()->json(['success' => false, 'data' => null, 'message' => 'Pending tasks must go through in_progress first'], 422);
            }
        }

        $task->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $task,
            'message' => 'Task has been Updated!'
        ], 200);
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['success' => true, 'data' => null, 'message' => 'Task has been Deleted!'], 200);
    }
}
