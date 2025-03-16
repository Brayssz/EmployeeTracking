<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $position;
    public $department_id;
    public $password;
    public $password_confirmation;
    public $status;
    public $departments;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'position' => 'required|string',
            'department_id' => 'required|exists:departments,department_id',
        ];

        if (!$this->user_id) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function mount()
    {
        $this->departments = Department::all();
    }
        
    public function save()
    {
        
        $this->validate();
        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'position' => $this->position,
                'department_id' => $this->department_id,
                'status' => $this->status,
            ]);

            if ($this->password) {
                $user->update([
                    'password' => Hash::make($this->password),
                ]);
            }
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'position' => $this->position,
                'department_id' => $this->department_id,
                'password' => Hash::make($this->password),
            ]);
        }

        session()->flash('message', 'User saved successfully.');
        $this->resetForm();

        return redirect()->route('users');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->position = $user->position;
        $this->department_id = $user->department_id;
        $this->status = $user->status;
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->position = '';
        $this->department_id = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->status = '';
    }

    public function render()
    {
        return view('livewire.user-management');
    }
}
