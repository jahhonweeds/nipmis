<?php

namespace App\Livewire\Vaccines;

use Flux\Flux;
use App\Models\Vaccine;
use Livewire\Component;
use App\Models\Municipality;
use Masmerise\Toaster\Toaster;
use App\Models\VaccineTransaction;

class VaccineTransactionsList extends Component
{
    public $vaccinestransactions;
    public $vaccines;
    public $municipalities;
    public $isEdit = false;
    public $showModal = false;
    public $confirmingDelete = false;
    public $deleteId = null;
    public $vaccine_id, $municipality_id, $date_expiry, $quantity, $batch_number;

    protected $rules = [
        'vaccine_id' => 'required|exists:vaccines,id',
        'municipality_id' => 'required|exists:municipalities,id',
        'date_expiry' => 'required|date',
        'quantity' => 'required|integer|min:1',
        'batch_number' => 'nullable|string|max:255',
    ];
    public function mount()
    {
        $this->vaccines = Vaccine::all();
        $this->municipalities = Municipality::all();
    }

    public function render()
    {
        $this->vaccinestransactions = VaccineTransaction::with('municipality')->get();
        return view('livewire.vaccines.vaccine-transactions-list');
    }

    public function resetInput()
    {
        $this->vaccine_id = null;
        $this->municipality_id = null;
        $this->date_expiry = null;
        $this->quantity = null;
        $this->batch_number = null;
        $this->isEdit = false;
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function store()
    {

        $this->validate();
        VaccineTransaction::create([
            'vaccine_id' => $this->vaccine_id,
            'municipality_id' => $this->municipality_id,
            'date_expiry' => $this->date_expiry,
            'quantity' => $this->quantity,
            'batch_number' => $this->batch_number
        ]);
        $this->resetInput();
        Flux::modal('vaccine-modal')->close(); // Removed due to undefined class
        Toaster::success('Vaccine created successfully!');
    }

    public function edit($id)
    {
        $vaccine = VaccineTransaction::findOrFail($id);
        $this->vaccine_id = $vaccine->id;
        $this->municipality_id = $vaccine->municipality_id;
        $this->date_expiry = $vaccine->date_expiry;
        $this->quantity = $vaccine->quantity;
        $this->batch_number = $vaccine->batch_number;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        Toaster::success('Vaccine updated successfully!');
        VaccineTransaction::find($this->vaccine_id)->update([
            'vaccine_id' => $this->vaccine_id,
            'municipality_id' => $this->municipality_id,
            'date_expiry' => $this->date_expiry,
            'quantity' => $this->quantity,
            'batch_number' => $this->batch_number
        ]);
        $this->resetInput();
        Flux::modal('vaccine-modal')->close();
    }

    // Show confirmation modal before deleting
    public function confirmDelete($id)
    {
        // $this->deleteId = $id;
        // $this->confirmingDelete = true;
        // Flux::modal('municipal-delete-modal')->show();
    }

    // Actually delete after confirmation
    public function deleteConfirmed()
    {
        // Check if the vaccine has any schools
        // $schools = \App\Models\School::where('vaccine_id', $this->deleteId)->exists();
        // if ($schools) {
        //     Toaster::error('Cannot delete vaccine with associated schools!');
        //     $this->confirmingDelete = false;
        //     Flux::modal('municipal-delete-modal')->close();
        //     // return redirect()->to('/municipalities');
        // } else {
        //     vaccine::destroy($this->deleteId);
        //     $this->resetInput();
        //     Flux::modal('municipal-delete-modal')->close();
        //     Toaster::success('vaccine deleted successfully!');
        // }
    }


    public function getNearExpiryVaccinesProperty()
    {
        return \App\Models\VaccineTransaction::with('vaccine')
            ->where('date_expiry', '>=', now())
            ->where('date_expiry', '<=', now()->addDays(30))
            ->orderBy('date_expiry')
            ->get();
    }
    public function getExpiredVaccinesProperty()
    {
        return \App\Models\VaccineTransaction::with('vaccine')
            ->where('date_expiry', '<=', now())
            ->orderBy('date_expiry')
            ->get();
    }
}
