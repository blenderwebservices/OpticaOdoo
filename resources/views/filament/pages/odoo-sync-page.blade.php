<x-filament-panels::page>
    <div class="space-y-6">

        <!-- Header Connection Status Card -->
        <div class="p-6 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 space-y-4">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-500/10 dark:bg-teal-500/20 text-teal-600 dark:text-teal-300 flex items-center justify-center text-2xl font-bold border border-teal-500/20">
                        ⚙️
                    </div>
                    <div>
                        <h2 class="text-xl font-bold font-serif text-slate-900 dark:text-white">Centro de Control & Sincronización Odoo</h2>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                            Instancia: <code class="text-teal-700 bg-teal-50 dark:text-teal-300 dark:bg-slate-800 border border-teal-200/60 dark:border-slate-700/60 px-2 py-0.5 rounded font-mono">{{ $connectionStatus['url'] ?? env('ODOO_URL', 'https://es-labs.odoo.com') }}</code> 
                            • Base de Datos: <code class="text-teal-700 bg-teal-50 dark:text-teal-300 dark:bg-slate-800 border border-teal-200/60 dark:border-slate-700/60 px-2 py-0.5 rounded font-mono">{{ $connectionStatus['db'] ?? env('ODOO_DB', 'es-labs') }}</code>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @if($connectionStatus['is_live'] ?? true)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                            Conectado (En Línea)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 border border-amber-300 dark:border-amber-500/30">
                            Modo Demostración API
                        </span>
                    @endif

                    <x-filament::button wire:click="testConnection" color="gray" size="sm">
                        Reverificar Conexión
                    </x-filament::button>
                </div>
            </div>

            <!-- Empresa Ligada & Usuario API Details Banner -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-slate-200 dark:border-slate-800 text-xs">
                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                    <span class="text-lg">🏢</span>
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-teal-700 dark:text-teal-400">Empresa Odoo Asignada</div>
                        <div class="font-semibold text-slate-900 dark:text-slate-100 text-sm">
                            {{ $companyInfo['name'] ?? 'ES VISION' }}
                            <span class="text-xs font-normal text-slate-500 dark:text-slate-400 font-mono">(ID #{{ $companyInfo['id'] ?? 2 }})</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/80 dark:border-slate-700/60">
                    <span class="text-lg">👤</span>
                    <div>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-teal-700 dark:text-teal-400">Usuario API Autenticado</div>
                        <div class="font-semibold text-slate-900 dark:text-slate-100 text-sm">
                            {{ $connectionStatus['user_name'] ?? 'Francisco Gomez' }}
                            <span class="text-xs font-normal text-slate-500 dark:text-slate-400 font-mono">({{ $connectionStatus['user_email'] ?? 'francisco@enjoysafety.com.mx' }} • UID #{{ $connectionStatus['uid'] ?? 5 }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Grid for Odoo Processes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1: Clientes (res.partner) -->
            <div class="p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4 flex flex-col justify-between hover:border-blue-300 dark:hover:border-blue-700 transition-colors">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center text-xl font-bold">
                        👥
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">Clientes (res.partner)</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Envía los pacientes y compradores registrados en la óptica hacia el catálogo de contactos de Odoo.
                    </p>
                </div>

                <x-filament::button wire:click="syncCustomers" color="info" class="w-full">
                    Sincronizar Clientes ➔
                </x-filament::button>
            </div>

            <!-- Card 2: Órdenes de Venta (sale.order) -->
            <div class="p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4 flex flex-col justify-between hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60 flex items-center justify-center text-xl font-bold">
                        🛒
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">Órdenes de Venta (SO)</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Crea órdenes de venta en Odoo (`sale.order`) con armazones, micas y detalles de cada pedido.
                    </p>
                </div>

                <x-filament::button wire:click="syncSaleOrders" color="success" class="w-full">
                    Sincronizar Pedidos ➔
                </x-filament::button>
            </div>

            <!-- Card 3: Órdenes de Compra (purchase.order) -->
            <div class="p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4 flex flex-col justify-between hover:border-amber-300 dark:hover:border-amber-700 transition-colors">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/60 flex items-center justify-center text-xl font-bold">
                        📦
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">Órdenes de Compra (PO)</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Genera un pedido de compra automático a proveedores en Odoo para productos con bajo stock.
                    </p>
                </div>

                <x-filament::button wire:click="triggerPurchaseOrder" color="warning" class="w-full">
                    Generar Orden de Compra ➔
                </x-filament::button>
            </div>

            <!-- Card 4: Facturación (account.move) -->
            <div class="p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4 flex flex-col justify-between hover:border-purple-300 dark:hover:border-purple-700 transition-colors">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 border border-purple-200/60 dark:border-purple-800/60 flex items-center justify-center text-xl font-bold">
                        🧾
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base">Facturación de Clientes</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Crea comprobantes fiscales y facturas de venta (`out_invoice`) asociadas al cliente en Odoo.
                    </p>
                </div>

                <x-filament::button wire:click="generateCustomerInvoice" color="primary" class="w-full">
                    Emitir Factura Odoo ➔
                </x-filament::button>
            </div>

        </div>

        <!-- Table of Recent Invoices in Odoo -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 dark:text-white text-lg font-serif">Facturas Recientes en Odoo (`account.move`)</h3>
                <x-filament::button wire:click="fetchInvoices" color="gray" size="xs">
                    Actualizar Lista
                </x-filament::button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-700 dark:text-slate-300 font-semibold border-b border-slate-200 dark:border-slate-700 uppercase">
                        <tr>
                            <th class="py-3 px-4">ID Odoo</th>
                            <th class="py-3 px-4">Folio Factura</th>
                            <th class="py-3 px-4">Cliente</th>
                            <th class="py-3 px-4">Monto Total</th>
                            <th class="py-3 px-4">Estatus</th>
                            <th class="py-3 px-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                        @forelse($recentInvoices as $inv)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-teal-600 dark:text-teal-400">#{{ $inv['id'] }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">{{ $inv['name'] ?? 'INV/2026/00' . $inv['id'] }}</td>
                                <td class="py-3 px-4 text-slate-700 dark:text-slate-300">
                                    {{ is_array($inv['partner_id'] ?? null) ? $inv['partner_id'][1] : ($inv['partner_id'] ?? 'Cliente') }}
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900 dark:text-white">${{ number_format($inv['amount_total'] ?? 0, 2) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                        {{ $inv['state'] ?? 'Publicada' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500 dark:text-slate-400">{{ $inv['invoice_date'] ?? date('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-500 dark:text-slate-400">No hay facturas registradas. Usa los botones de arriba para emitir una.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
