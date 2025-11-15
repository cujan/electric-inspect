<x-layouts.app :title="__('Organization | Settings')">
<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Organization')" :subheading="__('Update your organization information and logo')">
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                <div class="flex">
                    <x-phosphor-check-circle width="20" height="20" class="text-green-400" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <x-form method="put" action="{{ route('settings.organization.update') }}" enctype="multipart/form-data" class="my-6 w-full space-y-6">
            <x-input type="text" :label="__('Organization Name')" :value="$organization->name" name="name" required autofocus />

            <div>
                <x-label for="address" value="{{ __('Address') }}" />
                <x-textarea id="address" class="mt-1 block w-full" name="address" rows="3">{{ old('address', $organization->address) }}</x-textarea>
                <x-error for='address' />
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-input type="text" :label="__('Phone')" :value="$organization->phone" name="phone" />
                <x-input type="email" :label="__('Email')" :value="$organization->email" name="email" />
            </div>

            <div>
                <x-label for="logo" value="{{ __('Organization Logo') }}" />

                @if($organization->logo)
                    <div class="mt-2 mb-4">
                        <div class="flex items-start space-x-4">
                            <img src="{{ Storage::url($organization->logo) }}" alt="{{ $organization->name }}" class="h-24 w-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current logo</p>
                                <form action="{{ route('settings.organization.logo.delete') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this logo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <x-phosphor-trash width="14" height="14" class="mr-1" />
                                        {{ __('Remove Logo') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <input id="logo" type="file" name="logo" accept="image/jpeg,image/png,image/jpg" class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG (Max 2MB). This logo will appear on PDF inspection reports.</p>
                <x-error for='logo' />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <x-button class="w-full">{{ __('Save Changes') }}</x-button>
                </div>

                <x-action-message class="me-3" on="organization-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </x-form>

        <section class="mt-10 space-y-6">
            <div class="relative mb-5">
                <x-heading>{{ __('Organization Information') }}</x-heading>
                <x-subheading>{{ __('Additional details about your organization') }}</x-subheading>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl p-6">
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Organization ID') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $organization->id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Slug') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $organization->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $organization->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                                {{ $organization->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $organization->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </section>
    </x-settings.layout>
</section>
</x-layouts.app>
