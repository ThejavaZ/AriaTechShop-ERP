<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use App\Services\EmailApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class RepairController extends Controller
{
    protected $emailService;

    public function __construct(EmailApiService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Listar reparaciones
     */
    public function index(Request $request)
    {
        $query = Repair::with(['customer', 'technician']);

        // Filtros
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('repair_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('device_type', 'like', "%{$search}%");
            });
        }

        $repairs = $query->latest()->paginate(15);

        return response()->json($repairs);
    }

    /**
     * Crear reparación
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'device_type' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|string|max:100',
            'issue_description' => 'required|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'estimated_delivery' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $repair = Repair::create([
                'repair_number' => Repair::generateRepairNumber(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'device_type' => $request->device_type,
                'brand' => $request->brand,
                'model' => $request->model,
                'serial_number' => $request->serial_number,
                'issue_description' => $request->issue_description,
                'estimated_cost' => $request->estimated_cost,
                'estimated_delivery' => $request->estimated_delivery,
                'received_at' => now(),
                'assigned_to' => $request->assigned_to,
                'status' => 'pending',
            ]);

            // Registrar en historial
 RepairStatusHistory::create([
    'repair_id' => $repair->id,
    'status_to' => 'pending',
    'notes' => 'Reparación registrada',
    'changed_by' => \Illuminate\Support\Facades\Auth::id(),
]);
            // Enviar correo de registro
            $this->sendRegistrationEmail($repair);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reparación registrada exitosamente',
                'data' => $repair->load(['customer', 'technician'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear reparación: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reparación'
            ], 500);
        }
    }

    /**
     * Ver detalle de reparación
     */
    public function show($id)
    {
        $repair = Repair::with(['customer', 'technician', 'statusHistory.user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $repair
        ]);
    }

    /**
     * Actualizar reparación
     */
    public function update(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email',
            'customer_phone' => 'sometimes|string|max:20',
            'technician_notes' => 'nullable|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'estimated_delivery' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $repair->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Reparación actualizada exitosamente',
            'data' => $repair->load(['customer', 'technician'])
        ]);
    }

    /**
     * Cambiar estado de reparación
     */
    public function changeStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diagnosed,approved,in_progress,completed,delivered,cancelled',
            'notes' => 'nullable|string',
            'final_cost' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $repair = Repair::findOrFail($id);
            $oldStatus = $repair->status;
            $newStatus = $request->status;

            // Actualizar estado
            $repair->status = $newStatus;
            
            if ($request->has('final_cost')) {
                $repair->final_cost = $request->final_cost;
            }

            if ($newStatus === 'delivered') {
                $repair->delivered_at = now();
            }

            $repair->save();

            // Registrar en historial
  $history = RepairStatusHistory::create([
    'repair_id' => $repair->id,
    'status_from' => $oldStatus,
    'status_to' => $newStatus,
    'notes' => $request->notes,
    'changed_by' => \Illuminate\Support\Facades\Auth::id(),
]);

            // Enviar correo de cambio de estado
            $emailResult = $this->sendStatusChangeEmail($repair, $oldStatus, $newStatus, $request->notes);
            
            if ($emailResult['success']) {
                $history->email_sent = true;
                $history->save();
                
                $repair->customer_notified = true;
                $repair->last_notification_at = now();
                $repair->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'email_sent' => $emailResult['success'],
                'data' => $repair->load(['customer', 'technician', 'statusHistory'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar estado: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado'
            ], 500);
        }
    }

    /**
     * Eliminar reparación
     */
    public function destroy($id)
    {
        $repair = Repair::findOrFail($id);
        $repair->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reparación eliminada exitosamente'
        ]);
    }

    /**
     * Enviar encuesta de satisfacción
     */
    public function sendSurvey($id)
    {
        $repair = Repair::findOrFail($id);

        if ($repair->status !== 'delivered') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se puede enviar encuesta a reparaciones entregadas'
            ], 400);
        }

        $result = $this->sendSurveyEmail($repair);

        return response()->json($result);
    }

    // ========== MÉTODOS PRIVADOS PARA ENVÍO DE CORREOS ==========

    private function sendRegistrationEmail(Repair $repair)
    {
        $subject = "Reparación Registrada - {$repair->repair_number}";
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #4F46E5; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { padding: 30px; background: #f9fafb; }
                .info-box { background: white; padding: 20px; border: 1px solid #ddd; margin: 20px 0; border-radius: 5px; }
                .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .status-badge { display: inline-block; padding: 5px 15px; background: #FCD34D; color: #92400E; border-radius: 20px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🔧 Reparación Registrada</h1>
                    <p style='margin: 0; font-size: 18px;'>{$repair->repair_number}</p>
                </div>
                <div class='content'>
                    <h2>Hola {$repair->customer_name},</h2>
                    <p>Tu equipo ha sido recibido y registrado en nuestro sistema.</p>
                    
                    <div class='info-box'>
                        <h3>Información del Equipo</h3>
                        <div class='info-row'>
                            <strong>Tipo:</strong>
                            <span>{$repair->device_type}</span>
                        </div>
                        <div class='info-row'>
                            <strong>Marca/Modelo:</strong>
                            <span>{$repair->brand} {$repair->model}</span>
                        </div>
                        <div class='info-row'>
                            <strong>Problema:</strong>
                            <span>{$repair->issue_description}</span>
                        </div>
                        <div class='info-row'>
                            <strong>Fecha de recepción:</strong>
                            <span>{$repair->received_at->format('d/m/Y')}</span>
                        </div>
                        <div class='info-row'>
                            <strong>Estado:</strong>
                            <span class='status-badge'>Pendiente</span>
                        </div>
                    </div>
                    
                    <p>Te mantendremos informado sobre el progreso de tu reparación.</p>
                    <p><strong>Número de seguimiento:</strong> {$repair->repair_number}</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2026 AriaTech Shop - Servicio Técnico</p>
                </div>
            </div>
        </body>
        </html>";

        return $this->emailService->sendEmail(
            $repair->customer_email,
            $subject,
            $html
        );
    }

    private function sendStatusChangeEmail(Repair $repair, $oldStatus, $newStatus, $notes = null)
    {
        $statusMessages = [
            'diagnosed' => [
                'title' => '🔍 Diagnóstico Completado',
                'message' => 'Hemos completado el diagnóstico de tu equipo.',
                'color' => '#3B82F6'
            ],
            'approved' => [
                'title' => '✅ Reparación Aprobada',
                'message' => 'Tu reparación ha sido aprobada y procederemos con el trabajo.',
                'color' => '#8B5CF6'
            ],
            'in_progress' => [
                'title' => '🔧 En Reparación',
                'message' => 'Estamos trabajando en la reparación de tu equipo.',
                'color' => '#F59E0B'
            ],
            'completed' => [
                'title' => '✓ Reparación Completada',
                'message' => 'Tu equipo está listo para ser recogido.',
                'color' => '#10B981'
            ],
            'delivered' => [
                'title' => '📦 Entregado',
                'message' => 'Tu equipo ha sido entregado exitosamente.',
                'color' => '#6B7280'
            ],
            'cancelled' => [
                'title' => '❌ Reparación Cancelada',
                'message' => 'La reparación ha sido cancelada.',
                'color' => '#EF4444'
            ],
        ];

        $statusInfo = $statusMessages[$newStatus] ?? [
            'title' => 'Actualización de Estado',
            'message' => 'El estado de tu reparación ha cambiado.',
            'color' => '#6B7280'
        ];

        $subject = "{$statusInfo['title']} - {$repair->repair_number}";
        
        $notesHtml = $notes ? "
            <div style='background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 15px; margin: 20px 0;'>
                <strong>Notas del técnico:</strong><br>
                {$notes}
            </div>
        " : '';

        $costHtml = '';
        if ($newStatus === 'diagnosed' && $repair->estimated_cost) {
            $costHtml = "
                <div style='background: #DBEAFE; border-left: 4px solid #3B82F6; padding: 15px; margin: 20px 0;'>
                    <strong>Costo estimado:</strong> \${$repair->estimated_cost}
                </div>
            ";
        }

        if ($newStatus === 'completed' && $repair->final_cost) {
            $costHtml = "
                <div style='background: #D1FAE5; border-left: 4px solid #10B981; padding: 15px; margin: 20px 0;'>
                    <strong>Costo final:</strong> \${$repair->final_cost}
                </div>
            ";
        }

        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: {$statusInfo['color']}; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { padding: 30px; background: #f9fafb; }
                .info-box { background: white; padding: 20px; border: 1px solid #ddd; margin: 20px 0; border-radius: 5px; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>{$statusInfo['title']}</h1>
                    <p style='margin: 0;'>{$repair->repair_number}</p>
                </div>
                <div class='content'>
                    <h2>Hola {$repair->customer_name},</h2>
                    <p>{$statusInfo['message']}</p>
                    
                    {$notesHtml}
                    {$costHtml}
                    
                    <div class='info-box'>
                        <p><strong>Equipo:</strong> {$repair->device_type} {$repair->brand} {$repair->model}</p>
                        <p><strong>Estado actual:</strong> {$repair->status_label}</p>
                        <p><strong>Número de seguimiento:</strong> {$repair->repair_number}</p>
                    </div>
                    
                    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2026 AriaTech Shop - Servicio Técnico</p>
                    <p>Email: soporte@ariatech.com | Teléfono: (123) 456-7890</p>
                </div>
            </div>
        </body>
        </html>";

        return $this->emailService->sendEmail(
            $repair->customer_email,
            $subject,
            $html
        );
    }

    private function sendSurveyEmail(Repair $repair)
    {
        $surveyUrl = config('app.url') . "/survey/" . encrypt($repair->id);
        
        $subject = "¿Cómo fue tu experiencia? - {$repair->repair_number}";
        
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #8B5CF6; color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { padding: 30px; background: #f9fafb; }
                .button { display: inline-block; padding: 15px 30px; background: #8B5CF6; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; font-weight: bold; }
                .stars { font-size: 30px; text-align: center; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>⭐ Tu opinión es importante</h1>
                </div>
                <div class='content'>
                    <h2>Hola {$repair->customer_name},</h2>
                    <p>Esperamos que tu experiencia con nosotros haya sido satisfactoria.</p>
                    <p>Nos gustaría conocer tu opinión sobre el servicio de reparación de tu <strong>{$repair->device_type}</strong>.</p>
                    
                    <div class='stars'>⭐⭐⭐⭐⭐</div>
                    
                    <div style='text-align: center;'>
                        <a href='{$surveyUrl}' class='button'>Responder Encuesta</a>
                    </div>
                    
                    <p style='text-align: center; margin-top: 30px;'>
                        <small>La encuesta solo te tomará 2 minutos</small>
                    </p>
                    
                    <p>¡Gracias por confiar en nosotros!</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2026 AriaTech Shop</p>
                </div>
            </div>
        </body>
        </html>";

        return $this->emailService->sendEmail(
            $repair->customer_email,
            $subject,
            $html
        );
    }
}