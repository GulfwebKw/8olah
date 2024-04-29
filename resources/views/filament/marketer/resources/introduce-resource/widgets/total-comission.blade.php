<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1 h-11">
                <x-heroicon-o-currency-dollar class="h-11"/>
            </div>
            <div class="flex-1">
                @php
                    if (!function_exists('float_format')) {
                        function float_format(float $num, ?string $decimal_separator = '.', ?string $thousands_separator = ','): string
                        {
                            $floorNum = floor($num);
                            $digits = $num - $floorNum > 0 ? floatval( '0.'.\Illuminate\Support\Str::replaceFirst($floorNum.'.' , '' , $num) ) : 0;
                            return number_format($floorNum , 0 , $decimal_separator ,$thousands_separator) . ( $digits > 0  ? $decimal_separator. \Illuminate\Support\Str::replaceFirst('0.' , '' , $digits) : '') ;
                        }
                    }
                @endphp
                {{ __('Dashboard_Balance' , ['price' => float_format(\App\Models\Introduce::query()
                                    ->where('is_earned' , false)
                                    ->where('user_id' , auth()->id())->sum('number_works_approved') * auth()->user()->commission_per_work )]) }}
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
