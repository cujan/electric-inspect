<x-layouts.app :title="__('Edit Equipment')">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                <x-phosphor-arrow-left width="16" height="16" class="mr-1" />
                {{ __('Back to Equipment') }}
            </a>
        </div>

        <div class="max-w-3xl">
            <x-heading>{{ __('Edit Equipment') }}</x-heading>
            <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update equipment information') }}
            </x-text>

            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                <form method="POST" action="{{ route('equipment.update', $equipment) }}" class="px-4 py-5 sm:p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="customer_id" value="{{ __('Customer') }}" />
                        <x-select id="customer_id" name="customer_id" class="mt-1 block w-full" required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $equipment->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->company_name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-error for='customer_id' />
                    </div>

                    <x-separator />

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-label for="equipment_type" value="{{ __('Equipment Type') }}" />
                            <x-input id="equipment_type" class="mt-1 block w-full" type="text" name="equipment_type" :value="old('equipment_type', $equipment->equipment_type)" required />
                            <x-error for='equipment_type' />
                        </div>

                        <div>
                            <x-label for="manufacturer" value="{{ __('Manufacturer') }}" />
                            <x-input id="manufacturer" class="mt-1 block w-full" type="text" name="manufacturer" :value="old('manufacturer', $equipment->manufacturer)" />
                            <x-error for='manufacturer' />
                        </div>

                        <div>
                            <x-label for="model" value="{{ __('Model') }}" />
                            <x-input id="model" class="mt-1 block w-full" type="text" name="model" :value="old('model', $equipment->model)" />
                            <x-error for='model' />
                        </div>

                        <div>
                            <x-label for="serial_number" value="{{ __('Serial Number') }}" />
                            <x-input id="serial_number" class="mt-1 block w-full" type="text" name="serial_number" :value="old('serial_number', $equipment->serial_number)" />
                            <x-error for='serial_number' />
                        </div>

                        <div>
                            <x-label for="location" value="{{ __('Location') }}" />
                            <x-input id="location" class="mt-1 block w-full" type="text" name="location" :value="old('location', $equipment->location)" required />
                            <x-error for='location' />
                        </div>

                        <div>
                            <x-label for="installation_date" value="{{ __('Installation Date') }}" />
                            <x-input id="installation_date" class="mt-1 block w-full" type="date" name="installation_date" :value="old('installation_date', $equipment->installation_date?->format('Y-m-d'))" />
                            <x-error for='installation_date' />
                        </div>

                        <div>
                            <x-label for="status" value="{{ __('Status') }}" />
                            <x-select id="status" name="status" class="mt-1 block w-full" required>
                                <option value="active" {{ old('status', $equipment->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $equipment->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="retired" {{ old('status', $equipment->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                            </x-select>
                            <x-error for='status' />
                        </div>
                    </div>

                    <div>
                        <x-label for="description" value="{{ __('Description') }}" />
                        <x-textarea id="description" class="mt-1 block w-full" name="description" rows="2">{{ old('description', $equipment->description) }}</x-textarea>
                        <x-error for='description' />
                    </div>

                    <div>
                        <x-label for="notes" value="{{ __('Notes') }}" />
                        <x-textarea id="notes" class="mt-1 block w-full" name="notes" rows="3">{{ old('notes', $equipment->notes) }}</x-textarea>
                        <x-error for='notes' />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('equipment.show', $equipment) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Update Equipment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-container>
</x-layouts.app>
