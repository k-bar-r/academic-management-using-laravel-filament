<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
    </x-filament-panels::form>

    @if(count($this->students) > 0)
    <div class="mt-4 p-4 bg-white rounded shadow">
        <h2 class="text-xl mb-4">Student Attendance</h2>
        <table class="w-full">
            <thead>
                <tr class="border-b-2">
                    <th class="text-left p-2">Name</th>
                    <th class="text-left p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->students as $student)
                <tr class="border-b">
                    <td class="p-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td class="p-2">
                        <select wire:model="statuses.{{ $student->id }}" class="w-full p-2 border rounded">
                            <option value="hadir">Hadir</option>
                            <option value="alpha">Alpha</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            

                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-filament-panels::page>