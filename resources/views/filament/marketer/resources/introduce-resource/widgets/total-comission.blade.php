<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1 h-11">
                <x-heroicon-o-currency-dollar class="h-11"/>
            </div>
            <div class="flex-1">
                {{ __('Dashboard_Balance' , ['price' => number_format(\App\Models\Introduce::query()
                                    ->where('is_earned' , false)
                                    ->where('user_id' , auth()->id())->sum('number_works_approved') * auth()->user()->commission_per_work )]) }}
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
