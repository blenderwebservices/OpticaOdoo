<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SalesChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Tendencia de Ventas (Últimos 7 Días)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(fn ($i) => Carbon::now()->subDays($i));

        $data = $days->map(function ($date) {
            return Order::whereDate('created_at', $date->toDateString())->sum('total_amount');
        });

        $labels = $days->map(fn ($date) => $date->format('d M'));

        return [
            'datasets' => [
                [
                    'label' => 'Ventas ($ USD)',
                    'data' => $data->toArray(),
                    'borderColor' => '#0d9488',
                    'backgroundColor' => 'rgba(13, 148, 136, 0.2)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
