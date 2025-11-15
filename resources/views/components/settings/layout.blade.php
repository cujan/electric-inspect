<div class="flex items-start max-md:flex-col w-full">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <x-navlist variant="secondary">
            <x-navlist.item :href="route('settings.profile.edit')" :current="request()->routeIs('settings.profile.edit')">{{ __('Profile') }}</x-navlist.item>
            <x-navlist.item :href="route('settings.password.edit')" :current="request()->routeIs('settings.password.edit')">{{ __('Password') }}</x-navlist.item>
            <x-navlist.item :href="route('settings.appearance.edit')" :current="request()->routeIs('settings.appearance.edit')">{{ __('Appearance') }}</x-navlist.item>
            @if(!auth()->user()->isTechnician())
                <x-navlist.item :href="route('settings.organization.edit')" :current="request()->routeIs('settings.organization.edit')">{{ __('Organization') }}</x-navlist.item>
            @endif
        </x-navlist>
    </div>

    <x-separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <x-heading>{{ $heading ?? '' }}</x-heading>
        <x-subheading>{{ $subheading ?? '' }}</x-subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
