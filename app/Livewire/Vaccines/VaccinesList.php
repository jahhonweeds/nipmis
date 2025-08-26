<?php

namespace App\Livewire\Vaccines;

use App\Models\Vaccine;
use Flux\Flux;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class VaccinesList extends Component
{

    public $vaccines;
    public $isEdit = false;
    public $showModal = false;
    public $confirmingDelete = false;
    public $deleteId = null;
    public $name, $vaccine_id, $description, $doses, $manufacturer;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'doses' => 'integer|min:1',
        'manufacturer' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $this->vaccines = Vaccine::all();
        return view('livewire.vaccines.vaccines-list');
    }


    public function resetInput()
    {
        $this->name = '';
        $this->vaccine_id = null;
        $this->isEdit = false;
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function store()
    {
        $this->validate();
        Vaccine::create([
            'name' => $this->name,
            'description' => $this->description,
            'doses' => $this->doses,
            'manufacturer' => $this->manufacturer,
        ]);
        $this->resetInput();
        Flux::modal('vaccine-modal')->close(); // Removed due to undefined class
        Toaster::success('Vaccine created successfully!');
    }

    public function edit($id)
    {
        $vaccine = Vaccine::findOrFail($id);
        $this->vaccine_id = $vaccine->id;
        $this->name = $vaccine->name;
        $this->description = $vaccine->description;
        $this->doses = $vaccine->doses;
        $this->manufacturer = $vaccine->manufacturer;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        Toaster::success('Vaccine updated successfully!');
        vaccine::find($this->vaccine_id)->update([
            'name' => $this->name,
            'description' => $this->description,
            'doses' => $this->doses,
            'manufacturer' => $this->manufacturer
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
}
