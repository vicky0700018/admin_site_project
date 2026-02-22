<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardAnalyticsService
{
    public static function getAdminDashboardData()
    {
        return [
            'total_leads' => Lead::count(),
            'total_subadmins' => User::where('role', 'subadmin')->count(),
            'leads_this_month' => Lead::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
            'leads_this_week' => Lead::whereBetween('created_at', [
                now()->subDays(7)->startOfDay(),
                now()->endOfDay()
            ])->count(),
            'completed_leads' => Lead::where('status', 'completed')->count(),
            'leads_by_status' => Lead::selectRaw('status, count(*) as count')
                                    ->groupBy('status')
                                    ->pluck('count', 'status')
                                    ->toArray(),
            'recent_leads' => Lead::with('assignedTo')
                                 ->latest()
                                 ->limit(10)
                                 ->get(),
            'recent_activity' => \App\Models\ActivityLog::with('user')
                                                        ->latest()
                                                        ->limit(10)
                                                        ->get(),
        ];
    }

    public static function getSubadminDashboardData($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        return [
            'total_leads' => Lead::count(),
            'assigned_leads' => Lead::where('assigned_to', $userId)->count(),
            'completed_leads' => Lead::where('status', 'completed')
                                    ->where('assigned_to', $userId)
                                    ->count(),
            'in_progress_leads' => Lead::where('status', 'in_progress')
                                      ->where('assigned_to', $userId)
                                      ->count(),
            'leads_by_status' => Lead::where('assigned_to', $userId)
                                    ->selectRaw('status, count(*) as count')
                                    ->groupBy('status')
                                    ->pluck('count', 'status')
                                    ->toArray(),
            'recent_leads' => Lead::where('assigned_to', $userId)
                                 ->latest()
                                 ->limit(10)
                                 ->get(),
        ];
    }
}
