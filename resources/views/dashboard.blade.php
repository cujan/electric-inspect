<x-layouts.app :title="__('Dashboard')">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <x-heading>{{ __('Dashboard') }}</x-heading>
            <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Welcome back, ') }} {{ auth()->user()->name }}
            </x-text>
        </div>

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 dark:bg-blue-900/20 rounded-full">
                        <x-phosphor-users width="24" height="24" />
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('Total Customers') }}
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $stats['customers'] }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('customers.index') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 inline-flex items-center">
                    {{ __('View all') }}
                    <x-phosphor-arrow-right width="14" height="14" class="ml-1" />
                </a>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 dark:bg-green-900/20 rounded-full">
                        <x-phosphor-wrench width="24" height="24" />
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('Total Equipment') }}
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $stats['equipment'] }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('equipment.index') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 inline-flex items-center">
                    {{ __('View all') }}
                    <x-phosphor-arrow-right width="14" height="14" class="ml-1" />
                </a>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 mr-4 text-purple-500 bg-purple-100 dark:bg-purple-900/20 rounded-full">
                        <x-phosphor-clipboard-text width="24" height="24" />
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('Total Inspections') }}
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $stats['inspections'] }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('inspections.index') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 inline-flex items-center">
                    {{ __('View all') }}
                    <x-phosphor-arrow-right width="14" height="14" class="ml-1" />
                </a>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl p-6">
                <div class="flex items-center">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 dark:bg-orange-900/20 rounded-full">
                        <x-phosphor-calendar width="24" height="24" />
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            {{ __('Upcoming Inspections') }}
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                            {{ $stats['upcoming'] }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('inspections.index', ['status' => 'scheduled']) }}" class="mt-4 text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 inline-flex items-center">
                    {{ __('View scheduled') }}
                    <x-phosphor-arrow-right width="14" height="14" class="ml-1" />
                </a>
            </div>
        </div>

        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Quick Actions') }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="{{ route('customers.create') }}" class="flex items-center justify-center px-4 py-3 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                            <x-phosphor-plus width="18" height="18" class="mr-2 text-blue-600 dark:text-blue-400" />
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ __('New Customer') }}</span>
                        </a>
                        <a href="{{ route('equipment.create') }}" class="flex items-center justify-center px-4 py-3 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition">
                            <x-phosphor-plus width="18" height="18" class="mr-2 text-green-600 dark:text-green-400" />
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ __('New Equipment') }}</span>
                        </a>
                        <a href="{{ route('inspections.create') }}" class="flex items-center justify-center px-4 py-3 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition">
                            <x-phosphor-plus width="18" height="18" class="mr-2 text-purple-600 dark:text-purple-400" />
                            <span class="text-sm font-medium text-purple-600 dark:text-purple-400">{{ __('New Inspection') }}</span>
                        </a>
                        <a href="{{ route('inspections.index') }}" class="flex items-center justify-center px-4 py-3 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            <x-phosphor-list width="18" height="18" class="mr-2 text-gray-600 dark:text-gray-400" />
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('View All') }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('System Information') }}
                    </h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">{{ __('Organization') }}</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                @if (auth()->user()->isSuperAdmin())
                                    {{ __('Super Admin') }}
                                @else
                                    {{ auth()->user()->organization->name }}
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">{{ __('Role') }}</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-400">{{ __('User') }}</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->email }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </x-container>
</x-layouts.app>
