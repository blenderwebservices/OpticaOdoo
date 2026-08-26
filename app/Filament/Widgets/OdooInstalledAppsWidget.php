<?php

namespace App\Filament\Widgets;

use App\Services\OdooService;
use Filament\Widgets\Widget;

class OdooInstalledAppsWidget extends Widget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.odoo-installed-apps-widget';

    protected function getViewData(): array
    {
        /** @var OdooService $odooService */
        $odooService = app(OdooService::class);
        $info = $odooService->getInstalledAppsInfo();

        return [
            'apps' => $info['apps'],
            'is_live' => $info['is_live'],
        ];
    }
}
