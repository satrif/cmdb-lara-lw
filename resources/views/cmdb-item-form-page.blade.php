@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <a href="{{ route('cmdb-items.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Back to list</a>
    </div>

    <h2 class="text-2xl font-semibold mb-6">
        {{ $itemId ? 'Edit CMDB Item' : 'Create New CMDB Item' }}
    </h2>

    <livewire:cmdb-item-form :itemId="$itemId ?? null" />
@endsection
