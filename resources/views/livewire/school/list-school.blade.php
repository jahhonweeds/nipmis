<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Schools') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the list of schools') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Modal Trigger for Add -->
    <flux:modal.trigger name="school-modal">
        <div class="mb-2">
            <flux:button wire:click="resetInput">Add School</flux:button>
        </div>
    </flux:modal.trigger>

    <!-- Modal for Create/Edit -->
    <flux:modal name="school-modal" class="md:w-96">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEdit ? 'Edit School' : 'Add School' }}</flux:heading>
                <flux:text class="mt-2">
                    {{ $isEdit ? 'Update the school details.' : 'Add a new school.' }}
                </flux:text>
            </div>
            <flux:input label="Name" placeholder="School name" wire:model.defer="name" required />
            <flux:select label="Municipality" wire:model.defer="municipality_id" required>
                <option value="">Select Municipality</option>
                @foreach($municipalities as $municipality)
                <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                @endforeach
            </flux:select>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update' : 'Add' }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Municipality</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($schools as $school)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $school->name }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $school->municipality->name ?? '' }}</td>
                    <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                        <flux:modal.trigger name="school-modal">
                            <flux:button size="sm" type="button" wire:click="edit({{ $school->id }})"
                                class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit
                            </flux:button>
                        </flux:modal.trigger>
                        <flux:button size="sm" wire:click="delete({{ $school->id }})"
                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</flux:button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>