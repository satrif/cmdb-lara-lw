<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CmdbItem;

class CmdbItemList extends Component
{
    public $search = '';
    public $typeFilter = '';

    public function goSearch() {
        $this->render();
    }

    public function render()
    {
        $items = CmdbItem::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', 'ilike', $this->typeFilter);
            })
            ->with(['attributes', 'children', 'parents'])
            ->orderBy('name')
            ->get();

        return view('livewire.cmdb-item-list', [
            'items' => $items,
            'types' => ['server', 'computer', 'software', 'license', 'network_device', 'other']//make a fillable list
        ]);
    }

    public function deleteItem($id)
    {
        CmdbItem::find($id)->delete();
        session()->flash('message', 'Item deleted successfully.');
    }

    public function goToCreateItem()
    {
        return redirect()->route('cmdb-items.create');
    }
}
