<flux:dropdown position="bottom" align="start">
    <flux:button icon="bars-2" variant="subtle" inset="right" />

    <flux:menu>
        <flux:menu.radio.group>
            <flux:menu.item :href="route('profile.edit')" wire:navigate>
                {{ __('Settings') }}
            </flux:menu.item>
            <flux:menu.separator />
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>
