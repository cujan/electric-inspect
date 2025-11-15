<x-layouts.app :title="__('Edit Customer')">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <a href="{{ route('customers.show', $customer) }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                <x-phosphor-arrow-left width="16" height="16" class="mr-1" />
                {{ __('Back to Customer') }}
            </a>
        </div>

        <div class="max-w-3xl">
            <x-heading>{{ __('Edit Customer') }}</x-heading>
            <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update customer information') }}
            </x-text>

            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                <form method="POST" action="{{ route('customers.update', $customer) }}" class="px-4 py-5 sm:p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-label for="company_name" value="{{ __('Company Name') }}" />
                            <x-input id="company_name" class="mt-1 block w-full" type="text" name="company_name" :value="old('company_name', $customer->company_name)" required autofocus />
                            <x-error for='company_name' />
                        </div>

                        <div class="sm:col-span-2">
                            <x-label for="address" value="{{ __('Address') }}" />
                            <x-textarea id="address" class="mt-1 block w-full" name="address" rows="2">{{ old('address', $customer->address) }}</x-textarea>
                            <x-error for='address' />
                        </div>

                        <div>
                            <x-label for="city" value="{{ __('City') }}" />
                            <x-input id="city" class="mt-1 block w-full" type="text" name="city" :value="old('city', $customer->city)" />
                            <x-error for='city' />
                        </div>

                        <div>
                            <x-label for="state" value="{{ __('State') }}" />
                            <x-input id="state" class="mt-1 block w-full" type="text" name="state" :value="old('state', $customer->state)" />
                            <x-error for='state' />
                        </div>

                        <div>
                            <x-label for="postal_code" value="{{ __('Postal Code') }}" />
                            <x-input id="postal_code" class="mt-1 block w-full" type="text" name="postal_code" :value="old('postal_code', $customer->postal_code)" />
                            <x-error for='postal_code' />
                        </div>

                        <div>
                            <x-label for="country" value="{{ __('Country') }}" />
                            <x-input id="country" class="mt-1 block w-full" type="text" name="country" :value="old('country', $customer->country)" />
                            <x-error for='country' />
                        </div>
                    </div>

                    <x-separator />

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <x-label for="contact_person" value="{{ __('Contact Person') }}" />
                            <x-input id="contact_person" class="mt-1 block w-full" type="text" name="contact_person" :value="old('contact_person', $customer->contact_person)" />
                            <x-error for='contact_person' />
                        </div>

                        <div>
                            <x-label for="contact_email" value="{{ __('Contact Email') }}" />
                            <x-input id="contact_email" class="mt-1 block w-full" type="email" name="contact_email" :value="old('contact_email', $customer->contact_email)" />
                            <x-error for='contact_email' />
                        </div>

                        <div>
                            <x-label for="contact_phone" value="{{ __('Contact Phone') }}" />
                            <x-input id="contact_phone" class="mt-1 block w-full" type="text" name="contact_phone" :value="old('contact_phone', $customer->contact_phone)" />
                            <x-error for='contact_phone' />
                        </div>
                    </div>

                    <x-separator />

                    <div>
                        <x-label for="notes" value="{{ __('Notes') }}" />
                        <x-textarea id="notes" class="mt-1 block w-full" name="notes" rows="3">{{ old('notes', $customer->notes) }}</x-textarea>
                        <x-error for='notes' />
                    </div>

                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $customer->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:ring-offset-gray-900">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            {{ __('Active Customer') }}
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('customers.show', $customer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Update Customer') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-container>
</x-layouts.app>
