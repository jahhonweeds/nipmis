<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Municipalities') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the list of municipalities') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Modal Trigger for Add -->
    <flux:modal.trigger name="municipality-modal">
        <div class="mb-2">
            <flux:button wire:click="resetInput">Add Municipality</flux:button>
        </div>
    </flux:modal.trigger>

    <!-- Modal for Create/Edit -->
    <flux:modal name="municipality-modal" class="md:w-96">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEdit ? 'Edit Municipality' : 'Add Municipality' }}</flux:heading>
                <flux:text class="mt-2">
                    {{ $isEdit ? 'Update the municipality name.' : 'Add a new municipality.' }}
                </flux:text>
            </div>
            <flux:input label="Name" placeholder="Municipality name" wire:model.defer="name" required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update' : 'Add' }}</flux:button>
            </div>
        </form>
    </flux:modal>
    <!-- Delete Confirmation Modal -->
    <flux:modal name="municipal-delete-modal" class="md:w-96">
        <div class="p-4">
            <flux:heading size="lg">Confirm Delete</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this Municipality? All School connected to this
                municipality will also be deleted</flux:text>
            <div class="flex justify-end gap-2 mt-4">
                <flux:button size="sm" variant="danger" wire:click="deleteConfirmed">Delete</flux:button>
                <flux:button size="sm" variant="primary" wire:click="resetInput">Cancel</flux:button>

            </div>
        </div>
    </flux:modal>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($municipalities as $municipality)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $municipality->name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                        <flux:modal.trigger name="municipality-modal">
                            <flux:button type="button" size="sm" wire:click="edit({{ $municipality->id }})"
                                class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="municipal-delete-modal">
                            <flux:button type="button" size="sm" wire:click="confirmDelete({{ $municipality->id }})"
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include("components.flash-message s")
</div>