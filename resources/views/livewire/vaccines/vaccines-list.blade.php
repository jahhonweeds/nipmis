<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Vaccines') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the list of Vaccines') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Modal Trigger for Add -->
    <flux:modal.trigger name="vaccine-modal">
        <div class="mb-2">
            <flux:button wire:click="resetInput">Add vaccine</flux:button>
        </div>
    </flux:modal.trigger>

    <!-- Modal for Create/Edit -->
    <flux:modal name="vaccine-modal" class="md:w-200">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEdit ? 'Edit Vaccine' : 'Add Vaccine' }}</flux:heading>
                <flux:text class="mt-2">
                    {{ $isEdit ? 'Update the Vaccine name.' : 'Add a new Vaccine.' }}
                </flux:text>
            </div>
            <flux:input label="Name" placeholder="Vaccine name" wire:model.defer="name" required />
            <flux:input label="Description" placeholder="Description" wire:model.defer="description" />
            <flux:input label="Doses" type="number" placeholder="Doses" wire:model.defer="doses" required />
            <flux:input label="Manufacturer" placeholder="Manufacturer" wire:model.defer="manufacturer" required />
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
            <flux:text class="mt-2">Are you sure you want to delete this vaccine? All School connected to this
                vaccine will also be deleted</flux:text>
            <div class="flex justify-end gap-2 mt-4">
                <flux:button size="sm" variant="danger" wire:click="deleteConfirmed">Delete</flux:button>
                <flux:button size="sm" variant="primary" wire:click="resetInput">Cancel</flux:button>
            </div>
        </div>

    </flux:modal>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-white">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doses
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Manufacturer
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 dark:text-white divide-y divide-gray-200">
                @foreach ($vaccines as $vaccine)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->doses }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->manufacturer }}</td>
                        <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                            <flux:modal.trigger name="vaccine-modal">
                                <flux:button type="button" size="sm" wire:click="edit({{ $vaccine->id }})"
                                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="municipal-delete-modal">
                                <flux:button type="button" size="sm"
                                    wire:click="confirmDelete({{ $vaccine->id }})"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 disabled">Delete
                                </flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <x-toaster-hub /> --}}
</div>
