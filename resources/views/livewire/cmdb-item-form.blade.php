<div>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="name" id="name" class="p-2.5 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select wire:model="type" id="type" class="p-1.5 mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Select Type</option>
                    <option value="server">Server</option>
                    <option value="computer">Computer</option>
                    <option value="software">Software</option>
                    <option value="license">License</option>
                    <option value="network_device">Network Device</option>
                    <option value="other">Other</option>
                </select>
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" rows="3" class="p-2.5 mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>

            <!-- Attributes Section -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium">Attributes</h3>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($itemAttributes as $index => $attribute)
                        <div class="flex items-center border rounded p-2">
                            <div class="flex-1">
                                <span class="font-medium">{{ $attribute['key'] }}:</span> {{ $attribute['value'] }}
                            </div>
                            <button type="button" wire:click="removeAttribute({{ $index }})" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" wire:model="newAttributeKey" placeholder="Attribute key" class="p-2.5 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <input type="text" wire:model="newAttributeValue" placeholder="Attribute value" class="p-2.5 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <button type="button" wire:click="addAttribute" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Add Attribute
                        </button>
                    </div>
                </div>
            </div>

            <!-- Relationships Section -->
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium">Relationships</h3>

                <div class="mt-4 space-y-2">
                    @foreach($relationships as $index => $relationship)
                        <div class="flex items-center justify-between border rounded p-2">
                            <div>
                                <span class="font-medium">{{ $relationship['name'] }}</span> ({{ $relationship['type'] }})
                                <span class="text-sm text-gray-500 ml-2">{{ $relationship['relationship_type'] }}</span>
                            </div>
                            <button type="button" wire:click="removeRelationship({{ $index }})" class="text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <select wire:model="selectedChildId" class="p-1.5 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Item</option>
                            @foreach($availableItems as $availableItem)
                                <option value="{{ $availableItem->id }}">{{ $availableItem->name }} ({{ $availableItem->type }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select wire:model="selectedRelationshipType" class="p-1.5 w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Select Relationship</option>
                            @foreach($relationshipTypes as $type)
                                <option value="{{ $type }}">{{ str_replace('_', ' ', $type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="button" wire:click="addRelationship" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Add Relationship
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a wire:click="goToList" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700">
                    Go Back
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    Save Item
                </button>
            </div>
        </div>
    </form>
</div>
