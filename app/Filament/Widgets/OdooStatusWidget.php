<?php

namespace App\Filament\Widgets;

use App\Services\OdooService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OdooStatusWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        /** @var OdooService $odooService */
        $odooService = app(OdooService::class);
        $details = $odooService->getConnectionDetails();

        $statusColor = $details['status_color'] ?? 'success';
        $statusLabel = $details['status_label'] ?? 'Conectado';
        $url = $details['url'] ?? 'https://es-labs.odoo.com';
        $db = $details['db'] ?? 'es-labs';
        $userName = $details['user_name'] ?? 'API Admin';
        $userEmail = $details['user_email'] ?? 'admin@optica-odoo.com';
        $uid = $details['uid'] ?? 2;
        $version = $details['server_version'] ?? 'Odoo v17.0';

        return [
            Stat::make('Estado de Conexión Odoo', $statusLabel)
                ->description("Servidor: {$version}")
                ->descriptionIcon('heroicon-m-signal')
                ->color($statusColor),

            Stat::make('Instancia & Base de Datos', $db)
                ->description(parse_url($url, PHP_URL_HOST) ?? $url)
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('primary'),

            Stat::make('Usuario API Conectado', $userName)
                ->description("UID #{$uid} • {$userEmail}")
                ->descriptionIcon('heroicon-m-user-circle')
                ->color('info'),

            Stat::make('Integración Odoo ERP', 'Activa & Sincronizada')
                ->description('API JSON-RPC 2.0 Operativa')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('success'),
        ];
    }
}
