<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $lowStockProducts = Product::where('stock', '<=', 3)->count();
        $totalCustomers = User::where('role', 'customer')->count();

        return [
            Stat::make('Ventas Totales', '$' . number_format($totalSales, 2))
                ->description('Ingresos acumulados por ventas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Citas Visuales Pendientes', $pendingAppointments)
                ->description('Exámenes de vista agendados')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),

            Stat::make('Inventario Bajo', $lowStockProducts)
                ->description('Armazones con 3 o menos unidades')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'danger' : 'success'),

            Stat::make('Clientes Registrados', $totalCustomers)
                ->description('Pacientes y compradores')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
