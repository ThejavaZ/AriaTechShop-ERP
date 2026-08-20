<?php

namespace App\Livewire\Repairs;

use App\Models\Repair;
use App\Models\RepairStatusHistory;
use App\Services\EmailApiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Reparaciones')]
#[Layout('layouts.app')]
class RepairsList extends Component
{
    use WithPagination;

    // Filtros y búsqueda
    public $search = '';
    

    public $statusFilter = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    // Modal crear
    public $showCreateModal = false;

    public $customer_name = '';

    public $customer_email = '';

    public $customer_phone = '';

    public $device_type = '';

    public $brand = '';

    public $model = '';

    public $serial_number = '';

    public $issue_description = '';

    public $estimated_cost = '';

    public $estimated_delivery = '';

    // Modal detalles
    public $showDetailModal = false;

    public $selectedRepair = null;

    public $newTechnicianId = null;
    

    public $technicians = [];

    // Cambio de estado
    public $newStatus = '';

    public $statusChangeNotes = '';

    public $showStatusChangeSuccess = false;

    // Modal eliminar
    public $showDeleteModal = false;

    public $repairToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    protected $rules = [
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
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    // ========== MODAL CREAR ==========

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->resetForm();
    }

    public function updateTechnician()
    {
        $this->selectedRepair->update([
            'assigned_to' => $this->newTechnicianId ?: null,
        ]);

        $this->selectedRepair->refresh()->load('technician');

        session()->flash('success', 'Técnico actualizado correctamente.');
    }

    public function createRepair()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $repair = Repair::create([
                'repair_number' => Repair::generateRepairNumber(),

                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'device_type' => $this->device_type,
                'brand' => $this->brand,
                'model' => $this->model,
                'serial_number' => $this->serial_number,
                'issue_description' => $this->issue_description,
                'estimated_cost' => $this->estimated_cost,
                'estimated_delivery' => $this->estimated_delivery,
                'received_at' => now(),
                'status' => 'pending',
            ]);

            // Registrar en historial
            RepairStatusHistory::create([
                'repair_id' => $repair->id,
                'status_to' => 'pending',
                'notes' => 'Reparación registrada',
                'changed_by' => auth()->id(),
            ]);

            // Enviar correo de registro al cliente
            try {
                $emailService = new EmailApiService;
                $emailService->sendRegistrationEmail($repair);
            } catch (\Exception $e) {
                Log::warning('No se pudo enviar correo de registro: '.$e->getMessage());
            }

            DB::commit();

            $this->closeCreateModal();
            session()->flash('success', 'Reparación creada exitosamente. Se envió un correo al cliente.');
            $this->resetPage();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear reparación: '.$e->getMessage());
            session()->flash('error', 'Error al crear la reparación.');
        }
    }

    // ========== MODAL DETALLES ==========

    public function openDetailModal($repairId)
    {
        $this->selectedRepair = Repair::with(['technician', 'statusHistory.user'])
            ->findOrFail($repairId);
        $this->newStatus = $this->selectedRepair->status;
        $this->newTechnicianId = $this->selectedRepair->assigned_to;
        $this->technicians = \App\Models\User::role('tecnico')->get();
        $this->statusChangeNotes = '';
        $this->showStatusChangeSuccess = false;
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedRepair = null;
        $this->newStatus = '';
        $this->statusChangeNotes = '';
        $this->showStatusChangeSuccess = false;
    }

    // ========== CAMBIO DE ESTADO ==========

    public function updateStatus()
    {
        if (! $this->selectedRepair) {
            return;
        }

        $this->validate([
            'newStatus' => 'required|in:pending,diagnosed,approved,in_progress,completed,delivered,cancelled',
            'statusChangeNotes' => 'nullable|string|max:500',
        ]);

        // Evitar guardar si el estado es el mismo
        if ($this->newStatus === $this->selectedRepair->status) {
            $this->addError('newStatus', 'El estado seleccionado es igual al actual.');

            return;
        }

        try {
            DB::beginTransaction();

            $previousStatus = $this->selectedRepair->status;

            // Actualizar el estado de la reparación
            $this->selectedRepair->update([
                'status' => $this->newStatus,
            ]);

            // Registrar en historial
            RepairStatusHistory::create([
                'repair_id' => $this->selectedRepair->id,
                'status_from' => $previousStatus,
                'status_to' => $this->newStatus,
                'notes' => $this->statusChangeNotes ?: 'Cambio de estado manual',
                'changed_by' => auth()->id(),
            ]);

            // Enviar correo de notificación al cliente
            try {
                $emailService = new EmailApiService;
                $emailService->sendStatusChangeEmail($this->selectedRepair, $previousStatus, $this->newStatus);
            } catch (\Exception $e) {
                Log::warning('No se pudo enviar correo de cambio de estado: '.$e->getMessage());
            }

            DB::commit();

            // Recargar la reparación con relaciones actualizadas
            $this->selectedRepair = Repair::with(['technician', 'statusHistory.user'])
                ->findOrFail($this->selectedRepair->id);

            $this->statusChangeNotes = '';
            $this->showStatusChangeSuccess = true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar estado: '.$e->getMessage());
            $this->addError('newStatus', 'Error al actualizar el estado. Intenta de nuevo.');
        }
    }

    // ========== MODAL ELIMINAR ==========

    public function confirmDelete($repairId)
    {
        $this->repairToDelete = Repair::findOrFail($repairId);
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->repairToDelete = null;
    }

    public function deleteRepair()
    {
        try {
            $this->repairToDelete->delete();

            $this->closeDeleteModal();
            $this->closeDetailModal();

            session()->flash('success', 'Reparación eliminada exitosamente.');
            $this->resetPage();

        } catch (\Exception $e) {
            Log::error('Error al eliminar reparación: '.$e->getMessage());
            session()->flash('error', 'Error al eliminar la reparación.');
        }
    }

    // ========== HELPERS ==========

    private function resetForm()
    {
        $this->customer_name = '';
        $this->customer_email = '';
        $this->customer_phone = '';
        $this->device_type = '';
        $this->brand = '';
        $this->model = '';
        $this->serial_number = '';
        $this->issue_description = '';
        $this->estimated_cost = '';
        $this->estimated_delivery = '';
        $this->resetValidation();
    }

    public function render()
    {
        $repairs = Repair::query()
            ->with(['technician'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('repair_number', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_name', 'like', '%'.$this->search.'%')
                        ->orWhere('customer_email', 'like', '%'.$this->search.'%')
                        ->orWhere('device_type', 'like', '%'.$this->search.'%')
                        ->orWhere('brand', 'like', '%'.$this->search.'%')
                        ->orWhere('model', 'like', '%'.$this->search.'%')
                        ->orWhereHas('technician', function ($tq) {
                            $tq->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(15);

        $statusCounts = [
            'all' => Repair::count(),
            'pending' => Repair::where('status', 'pending')->count(),
            'diagnosed' => Repair::where('status', 'diagnosed')->count(),
            'in_progress' => Repair::where('status', 'in_progress')->count(),
            'completed' => Repair::where('status', 'completed')->count(),
            'delivered' => Repair::where('status', 'delivered')->count(),
            'cancelled' => Repair::where('status', 'cancelled')->count(),
        ];

        return view('livewire.repairs.repairs-list', [
            'repairs' => $repairs,
            'statusCounts' => $statusCounts,
        ]);
    }
}
