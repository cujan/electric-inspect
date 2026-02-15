<x-layouts.app :title="__('Edit Technician')">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <x-heading>{{ __('Edit Technician') }}</x-heading>
            <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Update technician information') }}
            </x-text>
        </div>

        <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
            <div class="px-4 py-5 sm:p-6">
                <x-form method="put" action="{{ route('users.update', $user) }}" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <x-input
                            type="text"
                            :label="__('Full Name')"
                            name="name"
                            :value="old('name', $user->name)"
                            required
                            autofocus
                        />

                        <x-input
                            type="email"
                            :label="__('Email Address')"
                            name="email"
                            :value="old('email', $user->email)"
                            required
                        />

                        <x-input
                            type="text"
                            :label="__('Číslo osvedčenia')"
                            name="certificate_number"
                            :value="old('certificate_number', $user->certificate_number)"
                        />

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Change Password') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">{{ __('Leave blank to keep the current password') }}</p>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <x-input
                                    type="password"
                                    :label="__('New Password')"
                                    name="password"
                                    autocomplete="new-password"
                                />

                                <x-input
                                    type="password"
                                    :label="__('Confirm Password')"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>

                        <x-button>
                            {{ __('Update Technician') }}
                        </x-button>
                    </div>
                </x-form>
            </div>
        </div>
    </x-container>
</x-layouts.app>
