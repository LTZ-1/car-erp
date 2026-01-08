<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    public function store(Request $request, \App\Models\SalesOrder $order)
    {
        // Authorization: only admin or owner
        $this->authorize('update', $order);

        $request->validate([
            'type' => 'required|string',
            'document' => 'required|file|max:5120', // 5MB
        ]);

        $path = $request->file('document')->store('documents/' . $order->id, 'public');

        $doc = Document::create([
            'sales_order_id' => $order->id,
            'type' => $request->type,
            'file_path' => $path,
        ]);

        // audit
        if (class_exists(\App\Services\AuditLogger::class)) {
            \App\Services\AuditLogger::log(
                'UPLOAD_DOCUMENT',
                $order,
                'Uploaded ' . $request->type . ' as ' . $path
            );
        }

        return back()->with('success', 'Document uploaded');
    }
}
