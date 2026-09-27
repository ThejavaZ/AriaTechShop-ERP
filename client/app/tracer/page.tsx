import { useState, useEffect } from 'react';

export default function TracerViewer() {
  const [traceId, setTraceId] = useState<string>('');
  const [logs, setLogs] = useState<any[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const fetchLogs = async (id?: string) => {
    setLoading(true);
    setError(null);
    try {
      const url = id
        ? `/api/tracer?trace_id=${id}`
        : '/api/tracer';
      const res = await fetch(url, {
        credentials: 'include',
      });
      if (!res.ok) {
        throw new Error('Failed to fetch logs');
      }
      const data = await res.json();
      setLogs(data.logs || []);
      setTraceId(data.trace_id || '');
    } catch (e: any) {
      setError(e.message);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchLogs();
  }, []);

  return (
    <div className="p-6">
      <h1 className="text-2xl font-bold mb-6">Visor de Trazabilidad</h1>

      <div className="card mb-6">
        <div className="card-header">
          <span>Trace-ID actual: </span>
          <span className="font-mono text-sm ml-2"
            >{traceId || '(ningún Trace-ID)'}</span
          >
        </div>
        <div className="card-body p-4">
          <input
            type="text"
            value traceId
            onChange={(e) => setTraceId(e.target.value)}
            placeholder="Ingrese Trace-ID para filtrar"
            className="w-full p-2 border rounded mb-3"
          />
          <button
            onClick={() => fetchLogs(traceId)}
            className="btn btn-primary"
            disabled={loading}
          >
            {loading ? 'Cargando...' : 'Filtrar'}
          </button>
        </div>
      </div>

      {error && (
        <div className="alert alert-error mb-6">
          <p>{error}</p>
        </div>
      )}

      {loading && !traceId && (
        <p className="text-muted">Cargando logs recientes...</p>
      )}

      <div className="overflow-x-auto">
        <table className="min-w-full">
          <thead>
            <tr>
              <th className="p-3 border border-gray-200">Nivel</th>
              <th className="p-3 border border-gray-200">Trace-ID</th>
              <th className="p-3 border border-gray-200">Endpoint</th>
              <th className="p-3 border border-gray-200">Timestamp</th>
              <th className="p-3 border border-gray-200">Mensaje</th>
            </tr>
          </thead>
          <tbody>
            {logs.map((log, index) => (
              <tr key={index} className="hover:bg-gray-50">
                <td className="p-3 text-sm">{log.level || 'N/A'}</td>
                <td className="p-3 font-mono text-xs">
                  {log.trace_id || 'N/A'}
                </td>
                <td className="p-3 text-sm">{log.endpoint || 'N/A'}</td>
                <td className="p-3 text-xs">
                  {log.timestamp || 'N/A'}
                </td>
                <td className="p-3 text-sm truncate">
                  {log.message || log.raw || 'N/A'}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}