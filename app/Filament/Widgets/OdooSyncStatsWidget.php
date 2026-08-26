<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OdooSyncStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $customersCount = User::where('role', 'customer')->count();
        $saleOrdersCount = Order::count();
        $invoicesCount = Order::where('payment_status', 'paid')->count();
        $invoicedAmount = Order::where('payment_status', 'paid')->sum('total_amount');
        $purchaseAlerts = Product::where('stock', '<=', 3)->count();

        return [
            Stat::make('Clientes en Odoo (res.partner)', $customersCount)
                ->description('Contactos y pacientes en base de datos')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Ventas Sincronizadas (sale.order)', $saleOrdersCount)
                ->description('Órdenes procesadas en Odoo')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Facturación en Odoo (account.move)', '$' . number_format($invoicedAmount, 2))
                ->description("{$invoicesCount} Facturas out_invoice emitidas")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Órdenes de Compra (purchase.order)', $purchaseAlerts . ' Solicitudes')
                ->description('Reabastecimiento de stock bajo')
                ->descriptionIcon('heroicon-m-truck')
                ->color($purchaseAlerts > 0 ? 'warning' : 'gray'),
        ];
    }
}
