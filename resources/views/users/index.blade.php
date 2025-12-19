<x-layouts.app :title="__('Team Members')">
    <x-container class="py-6 lg:py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <x-heading>{{ __('Team Members') }}</x-heading>
                <x-text class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Manage your organization technicians') }}
                </x-text>
            </div>
            <div>
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <x-phosphor-plus width="16" height="16" class="mr-1" />
                    {{ __('Add Technician') }}
                </a>
            </div>
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

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                <div class="flex">
                    <x-phosphor-x-circle width="20" height="20" class="text-red-400" />
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-white/10 sm:rounded-xl">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Email
                                </th>
                                @if(auth()->user()->isSuperAdmin())
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Organization
                                </th>
                                @endif
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Inspections
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Joined
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($technicians as $technician)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <span class="h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 font-semibold">
                                                    {{ $technician->initials() }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $technician->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $technician->email }}
                                    </td>
                                    @if(auth()->user()->isSuperAdmin())
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $technician->organization->name ?? 'N/A' }}
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $technician->inspections()->count() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $technician->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('users.show', $technician) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">{{ __('View') }}</a>
                                        <a href="{{ route('users.edit', $technician) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">{{ __('Edit') }}</a>
                                        <form action="{{ route('users.destroy', $technician) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this technician? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isSuperAdmin() ? '6' : '5' }}" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        <x-phosphor-users width="48" height="48" class="mx-auto mb-3 text-gray-300 dark:text-gray-600" />
                                        <p>{{ __('No technicians found.') }}</p>
                                        <a href="{{ route('users.create') }}" class="mt-2 inline-flex items-center text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                            <x-phosphor-plus width="16" height="16" class="mr-1" />
                                            Add your first technician
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($technicians->hasPages())
                    <div class="mt-6">
                        {{ $technicians->links() }}
                    </div>
                @endif
            </div>
        </div>
    </x-container>
</x-layouts.app>
