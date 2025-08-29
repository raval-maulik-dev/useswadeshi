<?php

namespace App\Livewire\Pages;

use App\Models\City;
use App\Models\State;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;

class Vendors extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCity = '';

    public $selectedState = '';

    public $cities = [];

    public $states = [];

    public function mount()
    {
        $this->states = State::with('cities')->get();
        $this->cities = City::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedState()
    {
        if ($this->selectedState) {
            $this->cities = City::where('state_id', $this->selectedState)->get();
        } else {
            $this->cities = City::all();
        }
        $this->selectedCity = '';
        $this->resetPage();
    }

    public function updatedSelectedCity()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Vendor::with(['city.state'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->orWhere('business_type', 'like', '%'.$this->search.'%');
            })
            ->when($this->selectedCity, function ($query) {
                $query->where('city_id', $this->selectedCity);
            })
            ->when($this->selectedState && ! $this->selectedCity, function ($query) {
                $query->whereHas('city', function ($q) {
                    $q->where('state_id', $this->selectedState);
                });
            })
            ->orderBy('name', 'asc');

        $vendors = $query->paginate(12);

        return view('livewire.pages.vendors', [
            'vendors' => $vendors,
        ]);
    }
}
