<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-building-office-2 class="w-6 h-6 text-teal-600 dark:text-teal-400" />
                    <span class="text-base font-semibold text-gray-900 dark:text-white">
                        Empresa Odoo Ligada a la App (res.company)
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    @if($is_live ?? false)
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            🟢 En Vivo (Odoo Server)
                        </span>
                    @else
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800" title="Demostración API activa (credenciales demo en .env)">
                            🟡 Modo Demostración API
                        </span>
                    @endif
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-teal-50 text-teal-700 dark:bg-teal-900/30 dark:text-teal-300 border border-teal-200 dark:border-teal-800">
                        Empresa Asignada (ID #{{ app(App\Services\OdooService::class)->getCompanyId() }})
                    </span>
                </div>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($companies ?? [] as $company)
                <div class="p-4 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/50 shadow-sm hover:shadow-md transition-all">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="p-2 rounded-lg bg-teal-50 dark:bg-teal-950/40 text-teal-600 dark:text-teal-400 border border-teal-200/50 dark:border-teal-800/50">
                                <x-heroicon-o-building-office class="w-5 h-5" />
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-gray-900 dark:text-white leading-tight">
                                    {{ $company['name'] }}
                                </h4>
                                <span class="text-xs font-mono text-gray-500 dark:text-gray-400">
                                    res.company ID #{{ $company['id'] }}
                                </span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            Acceso API
                        </span>
                    </div>

                    <div class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300 border-t border-gray-100 dark:border-gray-800 pt-2.5 mt-2">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="w-4 h-4 text-gray-500 dark:text-gray-400 flex-shrink-0" />
                            <span class="truncate">{{ $company['street'] }}, {{ $company['city'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-envelope class="w-4 h-4 text-gray-500 dark:text-gray-400 flex-shrink-0" />
                            <span class="truncate">{{ $company['email'] }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-phone class="w-4 h-4 text-gray-500 dark:text-gray-400 flex-shrink-0" />
                            <span>{{ $company['phone'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 pt-1">
                            <x-heroicon-o-currency-dollar class="w-4 h-4 text-teal-600 dark:text-teal-400 flex-shrink-0" />
                            <span class="font-semibold text-gray-800 dark:text-gray-200">Moneda: {{ $company['currency'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
