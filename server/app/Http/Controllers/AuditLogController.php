<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['subject', 'causer'])->latest();

        // Filtro por evento
        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        // Filtro por usuario (causer)
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        // Filtro por tipo de modelo
        if ($request->filled('subject_type')) {
            $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
        }

        // Filtro por rango de fechas
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $activities = $query->paginate(20)->withQueryString();

        // Listas para los <select> de filtros
        $events = Activity::distinct()->pluck('event')->filter()->values();
        $subjectTypes = Activity::distinct()->pluck('subject_type')->filter()->values();

        return view('audit.index', compact('activities', 'events', 'subjectTypes'));
    }
}
