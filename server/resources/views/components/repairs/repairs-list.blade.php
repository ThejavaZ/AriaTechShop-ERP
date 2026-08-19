new class extends Component
{
    // ... tus propiedades y métodos existentes ...

    public $newTechnicianId = null;

    // Si no tienes este método aún, agrégalo dentro de openDetailModal()
    // justo después de cargar $selectedRepair:
    public function openDetailModal($id)
    {
        $this->selectedRepair = Repair::with('statusHistory.user', 'technician')->findOrFail($id);
        $this->newTechnicianId = $this->selectedRepair->assigned_to;
        $this->showDetailModal = true;
    }

    public function updateTechnician()
    {
        $this->selectedRepair->update([
            'assigned_to' => $this->newTechnicianId ?: null,
        ]);

        $this->selectedRepair->refresh()->load('technician');

        session()->flash('success', 'Técnico actualizado correctamente.');
    }

    // Computed property para obtener técnicos disponibles (Livewire recalcula al renderizar)
    public function with(): array
    {
        return [
            'repairs' => $this->repairs, // lo que ya tengas
            'technicians' => \App\Models\User::role('tecnico')->get(),
        ];
    }
};