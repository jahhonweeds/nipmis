<?php

namespace App\Livewire;

use Flux\Flux;
use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UsersManagement extends Component
{
    public $users;
    public $isEdit = false;
    public $user_id;
    public $lastname, $firstname, $middlename, $suffix, $position, $email, $password, $password_confirmation, $municipality_id;
    public $municipalities = [];
    public function mount()
    {
        $this->users = \App\Models\User::all();
        $this->municipalities = \App\Models\Municipality::all();
    }
    public function render()
    {
        return view('livewire.users-management');
    }

    public function register()
    {
        $validated = $this->validate();

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        $this->resetInput();
        Flux::modal('User-modal')->close();
        Toaster::success('user created successfully!');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->lastname = $user->lastname;
        $this->firstname = $user->firstname;
        $this->middlename = $user->middlename;
        $this->suffix = $user->suffix;
        $this->position = $user->position;
        $this->password = '';
        $this->password_confirmation = '';
        $this->email = $user->email;
        $this->municipality_id = $user->municipality_id;
        $this->isEdit = true;
        Flux::modal('User-modal')->show();
    }
    public function rules()
    {
        return [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'municipality_id' => ['required', 'exists:municipalities,id'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $this->user_id],
            'password' => [$this->isEdit ? 'nullable' : 'required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }
    public function update()
    {

        $validated = $this->validate();
        // Hash the password if it's not empty, otherwise remove it from the validated data
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user = User::findOrFail($this->user_id);
        $user->update($validated);

        $this->resetInput();
        Flux::modal('User-modal')->close();
        Toaster::success('User updated successfully!');
    }

    public function resetInput()
    {
        $this->lastname = '';
        $this->firstname = '';
        $this->middlename = '';
        $this->suffix = '';
        $this->position = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->isEdit = false;
        $this->user_id = null;
    }
}
