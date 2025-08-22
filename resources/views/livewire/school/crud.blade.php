<div>
    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
        <input type="text" wire:model="name" placeholder="School Name">
        <select wire:model="municipality_id">
            <option value="">Select Municipality</option>
            @foreach($municipalities as $municipality)
                <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
            @endforeach
        </select>
        <button type="submit">{{ $isEdit ? 'Update' : 'Add' }}</button>
        @if($isEdit)
            <button type="button" wire:click="resetInput">Cancel</button>
        @endif
    </form>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Municipality</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>{{ $school->municipality->name ?? '' }}</td>
                    <td>
                        <button wire:click="edit({{ $school->id }})">Edit</button>
                        <button wire:click="delete({{ $school->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
