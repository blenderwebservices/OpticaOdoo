<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-squares-2x2 class="w-6 h-6 text-teal-600 dark:text-teal-400" />
                    <span class="text-base font-semibold text-gray-900 dark:text-white">
                        Aplicaciones y Módulos Instalados en Odoo Server
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
                        {{ count($apps ?? []) }} Módulos Activos
                    </span>
                </div>
            </div>
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800/50 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th scope="col" class="px-4 py-3">Aplicación / Módulo</th>
                        <th scope="col" class="px-4 py-3">Nombre Técnico</th>
                        <th scope="col" class="px-4 py-3">Descripción</th>
                        <th scope="col" class="px-4 py-3">Versión</th>
                        <th scope="col" class="px-4 py-3 text-right">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($apps ?? [] as $app)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-teal-100/60 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300">
                                        @switch($app['technical_name'])
                                            @case('sale')
                                                <x-heroicon-o-shopping-cart class="w-5 h-5" />
                                                @break
                                            @case('account')
                                                <x-heroicon-o-document-text class="w-5 h-5" />
                                                @break
                                            @case('purchase')
                                                <x-heroicon-o-truck class="w-5 h-5" />
                                                @break
                                            @case('stock')
                                                <x-heroicon-o-cube class="w-5 h-5" />
                                                @break
                                            @case('contacts')
                                                <x-heroicon-o-user-group class="w-5 h-5" />
                                                @break
                                            @case('point_of_sale')
                                                <x-heroicon-o-calculator class="w-5 h-5" />
                                                @break
                                            @default
                                                <x-heroicon-o-eye class="w-5 h-5" />
                                        @endswitch
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $app['name'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $app['author'] ?? 'Odoo S.A.' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-400">
                                <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                    {{ $app['technical_name'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-600 dark:text-gray-300 max-w-md">
                                {{ $app['summary'] }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                    {{ $app['version'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Instalado
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
