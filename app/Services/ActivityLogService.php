<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    public static function log(
        string $action,
        string $modelType,
        int $modelId,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
        ]);
    }

    public static function logLeadCreated(int $leadId, array $data): ActivityLog
    {
        return self::log(
            'created',
            'Lead',
            $leadId,
            null,
            $data,
            'Lead created'
        );
    }

    public static function logLeadUpdated(int $leadId, array $oldData, array $newData): ActivityLog
    {
        return self::log(
            'updated',
            'Lead',
            $leadId,
            $oldData,
            $newData,
            'Lead updated'
        );
    }

    public static function logLeadDeleted(int $leadId): ActivityLog
    {
        return self::log(
            'deleted',
            'Lead',
            $leadId,
            null,
            null,
            'Lead deleted'
        );
    }

    public static function logLeadStatusChanged(int $leadId, string $oldStatus, string $newStatus): ActivityLog
    {
        return self::log(
            'status_changed',
            'Lead',
            $leadId,
            ['status' => $oldStatus],
            ['status' => $newStatus],
            "Lead status changed from {$oldStatus} to {$newStatus}"
        );
    }

    public static function logLeadAssigned(int $leadId, ?int $oldUserId, ?int $newUserId): ActivityLog
    {
        return self::log(
            'assigned',
            'Lead',
            $leadId,
            ['assigned_to' => $oldUserId],
            ['assigned_to' => $newUserId],
            'Lead assignment changed'
        );
    }
}
