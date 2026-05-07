<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->keyword ?? '');
        $logName = trim($request->log_name ?? '');
        $causerId = $request->causer_id;

        $logs = Activity::with(['causer', 'subject'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('description', 'like', "%{$keyword}%")
                      ->orWhere('subject_type', 'like', "%{$keyword}%")
                      ->orWhere('event', 'like', "%{$keyword}%");
                });
            })
            ->when($logName, function ($query) use ($logName) {
                $query->where('log_name', $logName);
            })
            ->when($causerId, function ($query) use ($causerId) {
                $query->where('causer_id', $causerId);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $logNames = Activity::query()
            ->select('log_name')
            ->whereNotNull('log_name')
            ->distinct()
            ->orderBy('log_name')
            ->pluck('log_name');

        return view('admin.activity-log.index', compact('logs', 'logNames'));
    }
}