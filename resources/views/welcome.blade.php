<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <title>{{ __('Electric Inspect - Professional Electrical Inspection Management') }}</title>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Navigation -->
    <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="flex aspect-square size-10 items-center justify-center rounded-md bg-blue-600 text-white">
                        <x-phosphor-lightning-fill width="24" height="24" />
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Revízie elektroinštalácií</span>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Sign in') }}
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="text-center">
                <div class="inline-flex items-center justify-center p-2 bg-blue-100 dark:bg-blue-900/20 rounded-full mb-6">
                    <x-phosphor-lightning-fill width="32" height="32" class="text-blue-600 dark:text-blue-400" />
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6">
                    {{ __('Professional Electrical') }}<br>
                    <span class="text-blue-600 dark:text-blue-400">{{ __('Inspection Management') }}</span>
                </h1>

                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                    {{ __('Streamline your electrical inspection workflow with our comprehensive management system. Track equipment, manage inspections, and generate professional reports with ease.') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Go to Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Sign In to Get Started') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white dark:bg-gray-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ __('Everything You Need') }}</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">{{ __('Powerful features to manage your electrical inspections efficiently') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-users width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Customer Management') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Organize and track all your customers with detailed information and contact history.') }}</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-wrench width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Equipment Tracking') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Monitor all electrical equipment with serial numbers, locations, and maintenance history.') }}</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-clipboard-text width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Inspection Records') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Create, manage, and track inspections with detailed results and file attachments.') }}</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-file-pdf width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('PDF Reports') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Generate professional inspection reports with your organization\'s logo and branding.') }}</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-user-list width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Team Management') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Assign inspections to technicians and track their work progress in real-time.') }}</p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-600 text-white mb-4">
                        <x-phosphor-building-office width="24" height="24" />
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Multi-Organization') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ __('Support for multiple organizations with complete data isolation and security.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-600 dark:bg-blue-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('Ready to get started?') }}</h2>
            <p class="text-xl text-blue-100 mb-8">{{ __('Sign in to streamline your electrical inspection workflow.') }}</p>
            @guest
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 bg-white border border-transparent rounded-md font-semibold text-sm text-blue-600 uppercase tracking-widest hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-600 transition ease-in-out duration-150">
                    {{ __('Sign In') }}
                </a>
            @endguest
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-blue-600 text-white">
                        <x-phosphor-lightning-fill width="20" height="20" />
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">Electric Inspect</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    © {{ date('Y') }} Electric Inspect. {{ __('All rights reserved.') }}
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
