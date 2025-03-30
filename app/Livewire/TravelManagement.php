<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Travel;

class TravelManagement extends Component
{
    public $travel_id;
    public $purpose;
    public $description;
    public $start_date;
    public $end_date;

    protected function rules()
    {
        return [
            'purpose' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->travel_id) {
            $travel = Travel::find($this->travel_id);
            $travel->update([
                'purpose' => $this->purpose,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        } else {
            Travel::create([
                'purpose' => $this->purpose,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
        }

        session()->flash('message', 'Travel saved successfully.');
        $this->resetForm();

        return redirect()->route('travels');
    }

    public function edit($id)
    {
        $travel = Travel::findOrFail($id);
        $this->travel_id = $travel->travel_id;
        $this->purpose = $travel->purpose;
        $this->description = $travel->description;
        $this->start_date = $travel->start_date;
        $this->end_date = $travel->end_date;
    }

    public function resetForm()
    {
        $this->travel_id = null;
        $this->purpose = '';
        $this->description = '';
        $this->start_date = '';
        $this->end_date = '';
    }

    public function render()
    {
        return view('livewire.travel-management');
    }
}
