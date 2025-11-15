<x-layouts.app :title="__('Create Inspection')">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <a href="{{ route('inspections.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                <x-phosphor-arrow-left width="16" height="16" class="mr-1" />
                {{ __('Back to Inspections') }}
            </a>
        </div>

        <div class="max-w-3xl">
            <x-heading>{{ __('Create Inspection') }}</x-heading>
            <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Record a new inspection') }}
            </x-text>

            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                <form method="POST" action="{{ route('inspections.store') }}" enctype="multipart/form-data" class="px-4 py-5 sm:p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @if($technicians)
                        <div>
                            <x-label for="inspector_id" value="{{ __('Assign to Technician') }}" />
                            <x-select id="inspector_id" name="inspector_id" class="mt-1 block w-full">
                                <option value="">Select a technician (optional)</option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}" {{ old('inspector_id') == $technician->id ? 'selected' : '' }}>
                                        {{ $technician->name }}
                                    </option>
                                @endforeach
                            </x-select>
                            <x-error for='inspector_id' />
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">If not selected, it will be assigned to you</p>
                        </div>
                        @endif

                        <div>
                            <x-label for="customer_id" value="{{ __('Customer') }}" />
                            <x-select id="customer_id" name="customer_id" class="mt-1 block w-full" required>
                                <option value="">Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->company_name }}
                                    </option>
                                @endforeach
                            </x-select>
                            <x-error for='customer_id' />
                        </div>

                        <div>
                            <x-label for="equipment_id" value="{{ __('Equipment') }}" />
                            <x-select id="equipment_id" name="equipment_id" class="mt-1 block w-full" required>
                                <option value="">Select equipment</option>
                                @foreach ($equipment as $item)
                                    <option value="{{ $item->id }}" data-customer="{{ $item->customer_id }}" {{ old('equipment_id', request('equipment_id')) == $item->id ? 'selected' : '' }}>
                                        {{ $item->equipment_type }} - {{ $item->customer->company_name }}
                                    </option>
                                @endforeach
                            </x-select>
                            <x-error for='equipment_id' />
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="inspection_type" value="{{ __('Inspection Type') }}" />
                            <x-input id="inspection_type" class="mt-1 block w-full" type="text" name="inspection_type" :value="old('inspection_type')" required placeholder="e.g., Annual Safety Inspection" />
                            <x-error for='inspection_type' />
                        </div>

                        <div>
                            <x-label for="inspection_date" value="{{ __('Inspection Date') }}" />
                            <x-input id="inspection_date" class="mt-1 block w-full" type="date" name="inspection_date" :value="old('inspection_date', date('Y-m-d'))" required />
                            <x-error for='inspection_date' />
                        </div>

                        <div>
                            <x-label for="inspection_time" value="{{ __('Inspection Time') }}" />
                            <x-input id="inspection_time" class="mt-1 block w-full" type="time" name="inspection_time" :value="old('inspection_time')" />
                            <x-error for='inspection_time' />
                        </div>

                        <div>
                            <x-label for="status" value="{{ __('Status') }}" />
                            <x-select id="status" name="status" class="mt-1 block w-full" required>
                                <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </x-select>
                            <x-error for='status' />
                        </div>

                        <div>
                            <x-label for="result" value="{{ __('Result') }}" />
                            <x-input id="result" class="mt-1 block w-full" type="text" name="result" :value="old('result')" required placeholder="e.g., Pass, Fail, Conditional" />
                            <x-error for='result' />
                        </div>
                    </div>

                    <x-separator />

                    <div>
                        <x-label for="notes" value="{{ __('Notes') }}" />
                        <x-textarea id="notes" class="mt-1 block w-full" name="notes" rows="3">{{ old('notes') }}</x-textarea>
                        <x-error for='notes' />
                    </div>

                    <x-separator />

                    <div>
                        <x-label for="files" value="{{ __('Attach Files (PDF, Images)') }}" />
                        <input id="files" type="file" name="files[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PDF, JPG, PNG (Max 10MB per file)</p>
                        <x-error for='files' />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('inspections.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Create Inspection') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-container>
</x-layouts.app>
