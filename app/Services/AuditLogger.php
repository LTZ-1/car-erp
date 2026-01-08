<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogger
{
    public static function log($action, $entity, $description = null)
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'entity_type' => get_class($entity),
            'entity_id' => $entity->id,
            'description' => $description,
        ]);
    }
}
