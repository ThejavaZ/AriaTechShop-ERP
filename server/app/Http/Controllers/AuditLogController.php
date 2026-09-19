<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with(['user', 'product'])
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->action, fn($q) => $q->where('action', $request->action))
            ->orderBy('created_at', $request->order ?? 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('inventory.audit-log', compact('logs'));
    }
}
