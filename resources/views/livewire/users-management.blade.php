<div class="p-4">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('User Accounts') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage the list of Users accounts') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Modal Trigger for Add -->
    <flux:modal.trigger name="User-modal">
        <div class="mb-2">
            <flux:button wire:click="resetInput">Add users account</flux:button>
        </div>
    </flux:modal.trigger>

    <!-- Modal for Create/Edit -->
    <flux:modal name="User-modal" class="md:w-250 ">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'register' }}" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $isEdit ? 'Edit User' : 'Add User' }}</flux:heading>
                <flux:text class="mt-2">
                    {{ $isEdit ? 'Update the User information.' : 'Add a new User.' }}
                </flux:text>
            </div>
            <!-- Name -->
            <div class="grid grid-col-4 gap-2">
                <div class="grid grid-cols-2 gap-2 col-span-4">
                    <flux:input wire:model="lastname" :label="__('Last Name')" type="text" required autofocus
                        autocomplete="lastname" :placeholder="__('Last Name')" />
                    <flux:input wire:model="firstname" :label="__('First Name')" type="text" required autofocus
                        autocomplete="firstname" :placeholder="__('First Name')" />
                </div>

                <div class="grid grid-cols-2 gap-2 col-span-4">
                    <flux:input wire:model="middlename" :label="__('Middle Name')" type="text" autofocus
                        autocomplete="middlename" :placeholder="__('Middle Name')" />
                    <flux:input wire:model="suffix" class="w-m-5" :label="__('Suffix')" type="text" autofocus
                        autocomplete="suffix" :placeholder="__('Suffix')" />
                </div>

            </div>
            <div class="grid grid-cols-4 gap-4"><!-- Name -->
                <div class="col-span-4"> <!-- Email Address -->
                    <flux:input wire:model="email" :label="__('Email address')" type="email" required
                        autocomplete="email" placeholder="email@example.com" />
                </div>
                <div class="col-span-2">
                    <!-- Password -->
                    <flux:input wire:model="password" :label="__('Password')" type="password"
                        autocomplete="new-password" :placeholder="__('Password')" viewable />
                </div>
                <div class="col-span-2">
                    <!-- Confirm Password -->
                    <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password"
                        autocomplete="new-password" :placeholder="__('Confirm password')" viewable />
                </div>
                <div class="col-span-2">
                    <flux:input wire:model="position" :label="__('Position')" type="text" autofocus
                        autocomplete="position" :placeholder="__('Position')" />
                </div>
                <div class="col-span-2">
                    @foreach ($municipalities as $municipality)
                        <flux:select wire:model="municipality_id" :label="__('Municipality')" required>
                            <flux:select.option>Choose Municipality...</flux:select.option>
                            <flux:select.option value="{{ $municipality->id }}">{{ $municipality->name }}
                            </flux:select.option>
                        </flux:select>
                    @endforeach

                </div>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update Account' : 'Add account' }}
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Delete Confirmation Modal -->
    <flux:modal name="municipal-delete-modal" class="md:w-96">
        <div class="p-4">
            <flux:heading size="lg">Confirm Delete</flux:heading>
            <flux:text class="mt-2">Are you sure you want to delete this User? All School connected to this
                User will also be deleted</flux:text>
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
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">email
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Municipality
                    </th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 dark:text-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->fullname }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $user->municipality->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                            <flux:modal.trigger name="User-modal">
                                <flux:button type="button" size="sm" wire:click="edit({{ $user->id }})"
                                    class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit
                                </flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="municipal-delete-modal">
                                <flux:button type="button" size="sm"
                                    wire:click="confirmDelete({{ $user->id }})"
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
