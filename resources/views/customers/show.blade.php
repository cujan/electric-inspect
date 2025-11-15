<x-layouts.app :title="$customer->company_name">
    <x-container class="py-6 lg:py-8">
        <div class="mb-6">
            <a href="{{ route('customers.index') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                <x-phosphor-arrow-left width="16" height="16" class="mr-1" />
                {{ __('Back to Customers') }}
            </a>
        </div>

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

        <div class="flex justify-between items-start mb-6">
            <div>
                <x-heading>{{ $customer->company_name }}</x-heading>
                <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Customer ID:') }} {{ $customer->customer_id }}
                </x-text>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <x-phosphor-pencil width="16" height="16" class="mr-1" />
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this customer? This will also delete all associated equipment and inspections.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        <x-phosphor-trash width="16" height="16" class="mr-1" />
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Customer Information') }}
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Company Name') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->company_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                                <dd class="mt-1">
                                    @if ($customer->is_active)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            Inactive
                                        </span>
                                    @endif
                                </dd>
                            </div>
                            @if ($customer->address)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->address }}</dd>
                                </div>
                            @endif
                            @if ($customer->city || $customer->state || $customer->postal_code)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('City, State ZIP') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ implode(', ', array_filter([$customer->city, $customer->state, $customer->postal_code])) }}
                                    </dd>
                                </div>
                            @endif
                            @if ($customer->country)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Country') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->country }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Contact Information') }}
                        </h3>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Contact Person') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->contact_person ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    @if ($customer->contact_email)
                                        <a href="mailto:{{ $customer->contact_email }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                            {{ $customer->contact_email }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->contact_phone ?? '-' }}</dd>
                            </div>
                        </dl>
                        @if ($customer->notes)
                            <div class="mt-4">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Notes') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->notes }}</dd>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">
                                {{ __('Equipment') }}
                            </h3>
                            <a href="{{ route('equipment.create', ['customer_id' => $customer->id]) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                <x-phosphor-plus width="16" height="16" class="mr-1" />
                                {{ __('Add Equipment') }}
                            </a>
                        </div>
                        @if ($customer->equipment->count() > 0)
                            <div class="space-y-3">
                                @foreach ($customer->equipment as $equipment)
                                    <div class="flex justify-between items-start p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <div>
                                            <a href="{{ route('equipment.show', $equipment) }}" class="font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $equipment->equipment_type }}
                                            </a>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $equipment->location }}</p>
                                            @if ($equipment->serial_number)
                                                <p class="text-xs text-gray-500 dark:text-gray-400">SN: {{ $equipment->serial_number }}</p>
                                            @endif
                                        </div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($equipment->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                            @elseif($equipment->status === 'maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                            @endif">
                                            {{ ucfirst($equipment->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No equipment registered yet.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Statistics') }}
                        </h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Equipment') }}</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $customer->equipment->count() }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Inspections') }}</dt>
                                <dd class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $customer->inspections->count() }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Recent Inspections') }}
                        </h3>
                        @if ($customer->inspections->count() > 0)
                            <div class="space-y-3">
                                @foreach ($customer->inspections->take(5) as $inspection)
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <a href="{{ route('inspections.show', $inspection) }}" class="text-sm font-medium text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $inspection->inspection_type }}
                                            </a>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $inspection->inspection_date->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($inspection->result === 'pass') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                            @elseif($inspection->result === 'fail') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400
                                            @elseif($inspection->result === 'conditional') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400
                                            @endif">
                                            {{ ucfirst($inspection->result) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No inspections yet.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-layouts.app>
