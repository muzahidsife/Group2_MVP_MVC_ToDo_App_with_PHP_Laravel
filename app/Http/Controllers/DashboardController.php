<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $stats = [
            'total'     => $user->tasks()->count(),
            'pending'   => $user->tasks()->pending()->count(),
            'completed' => $user->tasks()->completed()->count(),
            'overdue'   => $user->tasks()->overdue()->count(),
        ];

        $recentTasks = $user->tasks()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        $recentActivity = $user->activityLogs()
            ->with('task')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'recentTasks', 'recentActivity'));
    }
}
