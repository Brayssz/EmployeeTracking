<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Department;

class DepartmentManagement extends Component
{
    public $department_id;
    public $name;
    public $status;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->department_id) {
            $department = Department::find($this->department_id);
            $department->update([
                'name' => $this->name,
                'status' => $this->status,
            ]);
        } else {
            Department::create([
                'name' => $this->name,
                'status' => $this->status,
            ]);
        }

        session()->flash('message', 'Department saved successfully.');
        $this->resetForm();

        return redirect()->route('departments');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $this->department_id = $department->department_id;
        $this->name = $department->name;
        $this->status = $department->status;
    }

    public function resetForm()
    {
        $this->department_id = null;
        $this->name = '';
        $this->status = '';
    }

    public function render()
    {
        return view('livewire.department-management');
    }
}
