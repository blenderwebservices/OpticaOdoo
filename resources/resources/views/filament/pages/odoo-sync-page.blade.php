<x-filament-panels::page>
    <div class="space-y-6">

        <!-- Header Connection Status Card -->
        <div class="p-6 bg-slate-900 text-white rounded-2xl shadow-lg border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center text-2xl font-bold">
                    ⚙️
                </div>
                <div>
                    <h2 class="text-xl font-bold font-serif">Conexión con Odoo API</h2>
                    <p class="text-xs text-slate-400">Instancia: <code class="text-teal-300 bg-slate-800 px-2 py-0.5 rounded">{{ env('ODOO_URL', 'https://es-labs.odoo.com') }}</code></p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($connectionStatus['success'] ?? false)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Conectado a Odoo API
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        Sincronización Lista (API Key detectada)
                    </span>
                @endif

                <x-filament::button wire:click="testConnection" color="gray" size="sm">
                    Reverificar Conexión
                </x-filament::button>
            </div>
        </div>

        <!-- Action Grid for Odoo Processes -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Card 1: Clientes (res.partner) -->
            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                        👥
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Clientes (res.partner)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Envía los pacientes y compradores registrados en la óptica hacia el catálogo de contactos de Odoo.
                    </p>
                </div>

                <x-filament::button wire:click="syncCustomers" color="info" class="w-full">
                    Sincronizar Clientes ➔
                </x-filament::button>
            </div>

            <!-- Card 2: Órdenes de Venta (sale.order) -->
            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                        🛒
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Órdenes de Venta (SO)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Crea órdenes de venta en Odoo (`sale.order`) con armazones, micas y detalles de cada pedido.
                    </p>
                </div>

                <x-filament::button wire:click="syncSaleOrders" color="success" class="w-full">
                    Sincronizar Pedidos ➔
                </x-filament::button>
            </div>

            <!-- Card 3: Órdenes de Compra (purchase.order) -->
            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                        📦
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Órdenes de Compra (PO)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Genera un pedido de compra automático a proveedores en Odoo para productos con bajo stock.
                    </p>
                </div>

                <x-filament::button wire:click="triggerPurchaseOrder" color="warning" class="w-full">
                    Generar Orden de Compra ➔
                </x-filament::button>
            </div>

            <!-- Card 4: Facturación (account.move) -->
            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                        🧾
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Facturación de Clientes</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Crea comprobantes fiscales y facturas de venta (`out_invoice`) asociadas al cliente en Odoo.
                    </p>
                </div>

                <x-filament::button wire:click="generateCustomerInvoice" color="primary" class="w-full">
                    Emitir Factura Odoo ➔
                </x-filament::button>
            </div>

        </div>

        <!-- Table of Recent Invoices in Odoo -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-4 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-lg font-serif">Facturas Recientes en Odoo (`account.move`)</h3>
                <x-filament::button wire:click="fetchInvoices" color="gray" size="xs">
                    Actualizar Lista
                </x-filament::button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase">
                        <tr>
                            <th class="py-3 px-4">ID Odoo</th>
                            <th class="py-3 px-4">Folio Factura</th>
                            <th class="py-3 px-4">Cliente</th>
                            <th class="py-3 px-4">Monto Total</th>
                            <th class="py-3 px-4">Estatus</th>
                            <th class="py-3 px-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($recentInvoices as $inv)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-4 font-mono font-bold text-teal-600">#{{ $inv['id'] }}</td>
                                <td class="py-3 px-4 font-semibold text-slate-900">{{ $inv['name'] ?? 'INV/2026/00' . $inv['id'] }}</td>
                                <td class="py-3 px-4 text-slate-700">
                                    {{ is_array($inv['partner_id'] ?? null) ? $inv['partner_id'][1] : ($inv['partner_id'] ?? 'Cliente') }}
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900">${{ number_format($inv['amount_total'] ?? 0, 2) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-emerald-100 text-emerald-800">
                                        {{ $inv['state'] ?? 'Publicada' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-slate-500">{{ $inv['invoice_date'] ?? date('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-slate-400">No hay facturas registradas. Usa los botones de arriba para emitir una.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
