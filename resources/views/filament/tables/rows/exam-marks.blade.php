<div class="fi-modal-content space-y-6 dark bg-gray-900 p-6 rounded-xl">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold tracking-tight fi-modal-heading text-white">
            {{ $record->examType->exam_type_name }} {{ $record->subject->name }}
            <span class="text-gray-400">{{ $record->exam_name }}</span>
        </h2>
    </div>

    <form method="POST" action="{{ route('exam-marks.update', ['exam' => $record->id]) }}">
        @csrf
        @method('POST')

        <div class="border border-gray-700 rounded-xl overflow-hidden">
            <table class="w-full fi-ta-table text-white">
                <thead>
                    <tr class="bg-gray-800 border-b border-gray-700">
                        <th class="text-left py-3 px-4 font-medium text-sm text-gray-200">Student</th>
                        <th class="text-left py-3 px-4 font-medium text-sm text-gray-200">Mark</th>
                        <th class="text-right py-3 px-4 font-medium text-sm text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody x-data="{ editing: {} }" class="divide-y divide-gray-700">
                    @foreach ($record->marks as $mark)
                    <tr class="hover:bg-gray-800/50">
                        <td class="py-3 px-4 text-sm text-gray-300">
                            {{ $mark->student->first_name }} {{ $mark->student->last_name }}
                        </td>

                        <td class="py-3 px-4">
                            <template x-if="editing[{{ $mark->id }}]">
                                <input
                                    type="number"
                                    name="marks[{{ $mark->id }}]"
                                    value="{{ $mark->mark }}"
                                    min="0"
                                    max="100"
                                    step="0.1"
                                    class="fi-input block w-24 rounded-md border-gray-600 bg-transparent text-white placeholder-gray-400 shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 text-sm">
                            </template>

                            <template x-if="!editing[{{ $mark->id }}]">
                                <span class="text-sm text-gray-300">{{ $mark->mark }}</span> -->
                            </template>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button
                                type="button"
                                x-on:click="editing[{{ $mark->id }}] = !editing[{{ $mark->id }}]"
                                class="fi-icon-btn fi-icon-btn-size-sm text-primary-400 hover:bg-primary-500/20 focus:bg-primary-500/20 p-1.5 rounded-md inline-flex items-center justify-center">
                                <template x-if="!editing[{{ $mark->id }}]">
                                    <svg class="fi-icon-btn-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                    </svg>
                                </template>
                                <template x-if="editing[{{ $mark->id }}]">
                                    <svg class="fi-icon-btn-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </template>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="submit" class="fi-btn fi-btn-size-md inline-flex items-center justify-center py-2 px-4 font-medium rounded-lg bg-primary-600 hover:bg-primary-500 focus:bg-primary-500 text-white shadow focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                <span class="fi-btn-label">Save changes</span>
            </button>
        </div>
    </form>
</div>