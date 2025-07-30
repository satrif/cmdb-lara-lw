<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\CmdbItem;
use App\Models\CmdbAttribute;

class CmdbItemForm extends Component
{
    public $item;
    public $itemId;
    public $name;
    public $type;
    public $description;

    public $itemAttributes = [];
    public $newAttributeKey = '';
    public $newAttributeValue = '';

    public $relationships = [];
    public $availableItems = [];
    public $selectedChildId = '';
    public $selectedRelationshipType = '';

    protected $rules = [
        'name' => 'required|min:3',
        'type' => 'required',
    ];

    public function mount($itemId = null)
    {
        if ($itemId) {//get item, rels and attr data
            $this->item = CmdbItem::with(['attributes', 'children'])->findOrFail($itemId);
            $this->itemId = $itemId;
            $this->name = $this->item->name;
            $this->type = $this->item->type;
            $this->description = $this->item->description;

            $this->itemAttributes = $this->item->attributes->toArray();
            $this->relationships = $this->item->children->map(function ($child) {
                return [
                    'id' => $child->id,
                    'name' => $child->name,
                    'type' => $child->type,
                    'relationship_type' => $child->pivot->relationship_type
                ];
            })->toArray();
        }

        $this->availableItems = CmdbItem::where('id', '!=', $this->itemId)->get();
    }

    public function addAttribute()
    {
        $this->validate([
            'newAttributeKey' => 'required',
            'newAttributeValue' => 'required',
        ]);

        $this->itemAttributes[] = [
            'key' => $this->newAttributeKey,
            'value' => $this->newAttributeValue,
        ];

        $this->newAttributeKey = '';
        $this->newAttributeValue = '';
    }

    public function removeAttribute($index)
    {
        unset($this->itemAttributes[$index]);
        $this->itemAttributes = array_values($this->itemAttributes);
    }

    public function addRelationship()
    {
        $this->validate([
            'selectedChildId' => 'required|exists:cmdb_items,id',
            'selectedRelationshipType' => 'required',
        ]);

        $child = CmdbItem::find($this->selectedChildId);

        $this->relationships[] = [
            'id' => $child->id,
            'name' => $child->name,
            'type' => $child->type,
            'relationship_type' => $this->selectedRelationshipType,
        ];
        //
        $this->selectedChildId = '';
        $this->selectedRelationshipType = '';
    }

    public function removeRelationship($index)
    {
        unset($this->relationships[$index]);
        $this->relationships = array_values($this->relationships);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
        ];
        //if ID isset update, else create
        if ($this->itemId) {
            $item = CmdbItem::find($this->itemId);
            $item->update($data);
        } else {
            $item = CmdbItem::create($data);
            $this->itemId = $item->id;
        }

        // attributes - delete then populate
        $item->attributes()->delete();
        foreach ($this->itemAttributes as $attr) {
            $item->attributes()->create([
                'key' => $attr['key'],
                'value' => $attr['value'],
            ]);
        }

        // relationships
        $syncData = [];
        foreach ($this->relationships as $rel) {
            $syncData[$rel['id']] = ['relationship_type' => $rel['relationship_type']];
        }
        $item->children()->sync($syncData);

        session()->flash('message', 'Item saved successfully.');
        return redirect()->route('cmdb-items.index');
    }

    public function render()
    {
        return view('livewire.cmdb-item-form', [
            'relationshipTypes' => ['contains', 'depends_on', 'licensed_to', 'installed_on', 'connected_to']//make a fillable list
        ]);
    }

    public function goToList()
    {
        return redirect()->route('cmdb-items.index');
    }
}
