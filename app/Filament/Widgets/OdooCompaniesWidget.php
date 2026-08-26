<?php

namespace App\Filament\Widgets;

use App\Services\OdooService;
use Filament\Widgets\Widget;

class OdooCompaniesWidget extends Widget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.odoo-companies-widget';

    protected function getViewData(): array
    {
        /** @var OdooService $odooService */
        $odooService = app(OdooService::class);
        $info = $odooService->getCompaniesInfo();

        return [
            'companies' => $info['companies'],
            'is_live' => $info['is_live'],
        ];
    }
}
