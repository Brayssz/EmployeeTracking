<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TravelUser;
use App\Models\Travel;
use App\Models\User;
use App\Models\Department;

class TravelUsersManagement extends Component
{
    public $travel_id;
    public $user_id;

    public $travels;
    public $users;

    public $travelUser_id;

    protected function rules()
    {
        return [
            'travel_id' => 'required|exists:travels,travel_id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->travelUser_id) {
            $travelUser = TravelUser::findOrFail($this->travelUser_id);
            $travelUser->update([
                'travel_id' => $this->travel_id,
                'user_id' => $this->user_id,
            ]);

            session()->flash('message', 'Travel User updated successfully.');
        } else {
            TravelUser::create([
                'travel_id' => $this->travel_id,
                'user_id' => $this->user_id,
            ]);

            session()->flash('message', 'Travel User saved successfully.');
        }

        $this->resetForm();
        return redirect()->route('travel-users');
    }

    public function edit($id)
    {
        $travelUser = TravelUser::findOrFail($id);
        $this->travelUser_id = $travelUser->id;
        $this->travel_id = $travelUser->travel_id;
        $this->user_id = $travelUser->user_id;
    }

    public function getFields()
    {
        $this->travels = Travel::all();
        $this->users = User::where('status', 'active')->get();
    }

    public function mount()
    {
        $this->getFields();
    }

    public function resetForm()
    {
        $this->travel_id = null;
        $this->user_id = null;
    }

    public function render()
    {
        return view('livewire.travel-users-management');
    }
}
