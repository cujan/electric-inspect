<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-700 dark:from-blue-700 dark:to-indigo-800 p-12 flex-col justify-between relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>

                <!-- Logo and Text -->
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="flex aspect-square size-12 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm text-white shadow-xl">
                            <x-phosphor-lightning-fill width="28" height="28" />
                        </div>
                        <span class="text-2xl font-bold text-white">Electric Inspect</span>
                    </div>

                    <h1 class="text-4xl font-bold text-white mb-4">
                        Professional Electrical<br>Inspection Management
                    </h1>
                    <p class="text-blue-100 text-lg">
                        Streamline your workflow and manage inspections with ease.
                    </p>
                </div>

                <!-- Features List -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center space-x-3 text-white">
                        <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-phosphor-check width="20" height="20" />
                        </div>
                        <span class="text-blue-50">Track equipment and inspections</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-phosphor-check width="20" height="20" />
                        </div>
                        <span class="text-blue-50">Generate professional PDF reports</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="flex-shrink-0 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-phosphor-check width="20" height="20" />
                        </div>
                        <span class="text-blue-50">Manage your team efficiently</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="relative z-10 text-blue-100 text-sm">
                    © {{ date('Y') }} Electric Inspect. All rights reserved.
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex flex-col items-center mb-8">
                        <div class="flex aspect-square size-16 items-center justify-center rounded-lg bg-blue-600 text-white mb-4 shadow-lg">
                            <x-phosphor-lightning-fill width="32" height="32" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Electric Inspect</h1>
                    </div>

                    <!-- Form Content -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                        {{ $slot }}
                    </div>

                    <!-- Mobile Footer -->
                    <div class="lg:hidden mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                        © {{ date('Y') }} Electric Inspect. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
