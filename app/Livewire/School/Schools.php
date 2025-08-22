<?php

namespace App\Livewire\School;

use Flux\Flux;
use Livewire\Component;
use App\Models\School;
use App\Models\Municipality;

class Schools extends Component
{
    public $schools, $name, $school_id, $municipality_id, $municipalities;
    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'municipality_id' => 'required|exists:municipalities,id',
    ];

    public function render()
    {
        $this->schools = School::with('municipality')->get();
        $this->municipalities = Municipality::all();
        return view('livewire.school.list-school');
    }

    public function resetInput()
    {
        $this->name = '';
        $this->school_id = null;
        $this->municipality_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();
        School::create([
            'name' => $this->name,
            'municipality_id' => $this->municipality_id,
        ]);
        $this->resetInput();
        Flux::modal('school-modal')->close();
    }

    public function edit($id)
    {
        $school = School::findOrFail($id);
        $this->school_id = $school->id;
        $this->name = $school->name;
        $this->municipality_id = $school->municipality_id;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        School::find($this->school_id)->update([
            'name' => $this->name,
            'municipality_id' => $this->municipality_id,
        ]);
        $this->resetInput();
        Flux::modal('school-modal')->close();
    }

    public function delete($id)
    {
        // School::destroy($id);
        // $this->resetInput();
    }
}