<div>
    <div class="m-1 p-1 mb-4">
        <input type="text" wire:model="search" wire:keydown.enter="goSearch" placeholder="Search items..." class="form-input">
        <select wire:model="typeFilter" wire:click="goSearch" class="form-select ml-2">
            <option value="">All Types</option>
            @foreach($types as $type)
                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
            @endforeach
        </select>
        <button wire:click="goToCreateItem" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($items as $item)
            <div class="border rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-bold">{{ $item->name }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $item->type }}</span>
                </div>
                <p class="text-gray-600 mt-2">{{ $item->description }}</p>

                @if($item->attributes->count())
                    <div class="mt-3">
                        <h4 class="font-semibold text-sm">Attributes:</h4>
                        <ul class="text-sm">
                            @foreach($item->attributes as $attr)
                                <li><span class="font-medium">{{ $attr->key }}:</span> {{ $attr->value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-4 flex justify-between">
                    <a href="{{ route('cmdb-items.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                    <button wire:click="deleteItem({{ $item->id }})" class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
