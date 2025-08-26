<?php

namespace App\Livewire\Municipality;

use Flux\Flux;
use Livewire\Component;
use App\Models\Municipality;
use Masmerise\Toaster\Toaster;
use App\Helpers\Flash; // Assuming you have a Flash helper for session messages

use function Laravel\Prompts\alert;

class Municipalities extends Component
{
    public $municipalities;
    public $name, $municipality_id;
    public $isEdit = false;
    public $showModal = false;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {

        $this->municipalities = Municipality::all();
        return view('livewire.municipality.list-municipality');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->municipality_id = null;
        $this->isEdit = false;
        $this->confirmingDelete = false;
        $this->deleteId = null;
    }

    public function store()
    {
        $this->validate();
        Municipality::create(['name' => $this->name]);
        $this->resetInput();
        Flux::modal('municipality-modal')->close(); // Removed due to undefined class
        Toaster::success('Municipality created!');
    }

    public function edit($id)
    {
        $municipality = Municipality::findOrFail($id);
        $this->municipality_id = $municipality->id;
        $this->name = $municipality->name;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        Toaster::success('Municipality updated!');
        Municipality::find($this->municipality_id)->update(['name' => $this->name]);
        $this->resetInput();
        Flux::modal('municipality-modal')->close();
    }

    // Show confirmation modal before deleting
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
        Flux::modal('municipal-delete-modal')->show();
    }

    // Actually delete after confirmation
    public function deleteConfirmed()
    {
        // Check if the municipality has any schools
        $schools = \App\Models\School::where('municipality_id', $this->deleteId)->exists();
        if ($schools) {
            Toaster::error('Cannot delete municipality with associated schools!');
            $this->confirmingDelete = false;
            Flux::modal('municipal-delete-modal')->close();
            // return redirect()->to('/municipalities');
        } else {
            Municipality::destroy($this->deleteId);
            $this->resetInput();
            Flux::modal('municipal-delete-modal')->close();
            Toaster::success('Municipality deleted successfully!');
        }
    }
}
