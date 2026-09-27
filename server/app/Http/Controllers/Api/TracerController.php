<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class TracerController extends Controller
{
    public function index(Request $request)
    {
        $traceId = $request->query('trace_id');

        $logs = [];

        if ($traceId) {
            $logs = $this->filterLogsByTraceId($traceId);
        } else {
            $logs = $this->getRecentLogs(50);
        }

        return response()->json([
            'trace_id' => $traceId,
            'logs' => $logs,
        ]);
    }

    protected function filterLogsByTraceId(string $traceId): array
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return [];
        }

        $lines = File::get($logFile);
        $logLines = explode("\n", $lines);
        $filtered = [];

        foreach ($logLines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            try {
                $entry = json_decode($line, true);

                if ($entry && isset($entry['trace_id']) && $entry['trace_id'] === $traceId) {
                    $filtered[] = $entry;
                }
            } catch (\Exception $e) {
                // Skip non-JSON lines
            }
        }

        return array_slice($filtered, 0, 100);
    }

    protected function getRecentLogs(int $count = 50): array
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return [];
        }

        $lines = File::get($logFile);
        $logLines = explode("\n", $lines);
        $recent = [];

        for ($i = max(0, count($logLines) - $count); $i < count($logLines); $i++) {
            $line = trim($logLines[$i]);
            if (empty($line)) {
                continue;
            }

            try {
                $entry = json_decode($line, true);
                if ($entry) {
                    $recent[] = $entry;
                }
            } catch (\Exception $e) {
                // Skip non-JSON lines, keep raw for LineFormatter output
                $recent[] = ['raw' => $line];
            }
        }

        return $recent;
    }
}