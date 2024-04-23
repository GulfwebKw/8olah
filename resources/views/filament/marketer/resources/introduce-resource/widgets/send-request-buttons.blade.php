<x-filament-widgets::widget>
    <x-filament::section>
        <a href="{{ \App\Filament\Marketer\Pages\SendRequest::getUrl() }}">
            <div class="flex items-center gap-x-3">
                <div class="flex-1 h-11">
                    <x-heroicon-s-chat-bubble-left class="h-11"/>
                </div>
                <div class="flex-1">
                    {{ __('Send Request') }}
                </div>
            </div>
        </a>
    </x-filament::section>
</x-filament-widgets::widget>
