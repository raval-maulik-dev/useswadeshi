<?php

namespace App\Livewire\Pages;

use App\Models\Pledge;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Pledges extends Component
{
    use WithPagination;

    public $pledgeText = '';

    public $selectedProducts = [];

    public $isCreatingPledge = false;

    public $products = [];

    public function mount()
    {
        $this->products = Product::where('product_type', 'local')->get();
    }

    public function createPledge()
    {
        $this->validate([
            'pledgeText' => 'required|min:10|max:500',
            'selectedProducts' => 'required|array|min:1',
        ]);

        $pledge = Pledge::create([
            'user_id' => auth()->id(),
            'pledge_text' => $this->pledgeText,
            'products' => $this->selectedProducts,
            'status' => 'active',
        ]);

        $this->reset(['pledgeText', 'selectedProducts', 'isCreatingPledge']);

        session()->flash('message', 'Pledge created successfully! Thank you for supporting local products.');
    }

    public function toggleProduct($productId)
    {
        if (in_array($productId, $this->selectedProducts)) {
            $this->selectedProducts = array_diff($this->selectedProducts, [$productId]);
        } else {
            $this->selectedProducts[] = $productId;
        }
    }

    public function render()
    {
        $userPledges = Pledge::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $allPledges = Pledge::with('user')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.pages.pledges', [
            'userPledges' => $userPledges,
            'allPledges' => $allPledges,
        ])->layout('components.layouts.app');
    }
}
