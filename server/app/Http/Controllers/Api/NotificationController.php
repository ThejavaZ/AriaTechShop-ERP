<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EmailApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $emailService;

    public function __construct(EmailApiService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Enviar correo genérico
     */
    public function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'html' => 'required|string',
            'text' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->emailService->sendEmail(
            $request->to,
            $request->subject,
            $request->html,
            $request->text
        );

        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Enviar correo de bienvenida
     */
    public function sendWelcome(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $result = $this->emailService->sendWelcomeEmail($request->email, $request->name);
        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Enviar confirmación de orden
     */
    public function sendOrderConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'order_number' => 'required|string',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $result = $this->emailService->sendOrderConfirmation($request->email, $request->all());
        return response()->json($result, $result['success'] ? 200 : 500);
    }

    /**
     * Enviar factura
     */
    public function sendInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'invoice_number' => 'required|string',
            'date' => 'required|string',
            'total' => 'required|numeric',
            'pdf_path' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $result = $this->emailService->sendInvoiceEmail(
            $request->email,
            $request->only(['invoice_number', 'date', 'total']),
            $request->pdf_path
        );

        return response()->json($result, $result['success'] ? 200 : 500);
    }
}