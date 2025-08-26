<div class="p-4">

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Vaccines Inventory') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the list of stocks vaccines to inventory') }}
        </flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Near Expiry Vaccines Dashboard Card --}}

    <div class="mb-6">
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-lg mb-1">Near Expiry Vaccines (Next 30 Days)</div>
                        @if ($this->nearExpiryVaccines->count())
                            <ul class="list-disc pl-5">
                                @foreach ($this->nearExpiryVaccines as $item)
                                    <li>
                                        <span class="font-semibold">{{ $item->vaccine->name }}</span>
                                        (Batch: {{ $item->batch_number }})
                                        -
                                        <span
                                            class="text-red-600">{{ \Carbon\Carbon::parse($item->date_expiry)->format('M d, Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-600">No vaccines expiring soon.</span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $this->nearExpiryVaccines->count() }}
                    </div>
                </div>
            </div>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-lg mb-1">Expired Vaccines</div>
                        @if ($this->expiredVaccines->count())
                            <ul class="list-disc pl-5">
                                @foreach ($this->expiredVaccines as $item)
                                    <li>
                                        <span class="font-semibold">{{ $item->vaccine->name }}</span>
                                        (Batch: {{ $item->batch_number }})
                                        -
                                        <span
                                            class="text-red-600">{{ \Carbon\Carbon::parse($item->date_expiry)->format('M d, Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-600">No expired vaccines.</span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold text-yellow-600">
                        {{ $this->expiredVaccines->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Trigger for Add -->
    <flux:modal.trigger name="vaccine-modal">
        <div class="mb-2">
            <flux:button wire:click="resetInput">Add Stocks</flux:button>
        </div>
    </flux:modal.trigger>

    <!-- Modal for Create/Edit -->
    <flux:modal name="vaccine-modal" class="md:w-200">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEdit ? 'Edit Vaccine Stocks' : 'Add Stocks Vaccine' }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ $isEdit ? 'Update the Vaccine Stocks.' : 'Add a new Vaccine Stocks.' }}
                </flux:text>
            </div>
            <flux:select label="Vaccine Type" wire:model="vaccine_id">
                <flux:select.option>Choose Vaccine...</flux:select.option>
                @foreach ($vaccines as $vaccine)
                    <flux:select.option value="{{ $vaccine->id }}">{{ $vaccine->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select label="Municipality" wire:model="municipality_id">
                <flux:select.option>Choose Municipality...</flux:select.option>
                @foreach ($municipalities as $municipality)
                    <flux:select.option value="{{ $municipality->id }}">{{ $municipality->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input label="Quantity" placeholder="Quantity" wire:model.defer="quantity" required />
            <flux:input label="batch_number" placeholder="batch_number" wire:model.defer="batch_number" required />
            <flux:input label="Date Expiry" type="date" placeholder="Date Expiry" wire:model.defer="date_expiry"
                required />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update' : 'Add' }}</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="vaccinetransaction-delete-modal" class="md:w-96">
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
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine
                        Type
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch
                        Number
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry
                        Date
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quatity
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 dark:text-white divide-y divide-gray-200">
                @foreach ($vaccinestransactions as $vaccine)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->vaccine->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->batch_number }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->date_expiry }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vaccine->quantity }}</td>
                        <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                            <flux:modal.trigger name="vaccine-modal">
                                <flux:button type="button" size="sm" wire:click="edit({{ $vaccine->id }})"
                                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="vaccinetransaction-delete-modal">
                                <flux:button type="button" size="sm" disabled
                                    wire:click="confirmDelete({{ $vaccine->id }})"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 ">Delete
                                </flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
