<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\OdooService;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class OdooSyncPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationLabel = 'Integración Odoo API';

    protected static ?string $title = 'Centro de Control & Sincronización Odoo';

    protected static ?string $navigationGroup = 'Administración';

    protected static string $view = 'filament.pages.odoo-sync-page';

    public array $connectionStatus = [];
    public array $companyInfo = [];
    public array $recentInvoices = [];

    public function mount(OdooService $odooService)
    {
        $this->testConnection($odooService);
        $this->fetchInvoices($odooService);
    }

    public function testConnection(OdooService $odooService)
    {
        $this->connectionStatus = $odooService->getConnectionDetails();
        $comp = $odooService->getCompaniesInfo();
        $this->companyInfo = $comp['companies'][0] ?? [];
    }

    public function syncCustomers(OdooService $odooService)
    {
        $customers = User::where('role', 'customer')->get();
        $count = 0;

        foreach ($customers as $customer) {
            $odooService->createCustomer($customer);
            $count++;
        }

        Notification::make()
            ->title("Sincronización Exitosa")
            ->body("Se enviaron {$count} clientes a Odoo (modelo res.partner).")
            ->success()
            ->send();
    }

    public function syncSaleOrders(OdooService $odooService)
    {
        $orders = Order::with(['items.product'])->latest()->take(5)->get();
        $count = 0;

        foreach ($orders as $order) {
            $odooService->createSaleOrder($order);
            $count++;
        }

        Notification::make()
            ->title("Órdenes de Venta Sincronizadas")
            ->body("Se enviaron {$count} pedidos a Odoo como Sales Orders (sale.order).")
            ->success()
            ->send();
    }

    public function triggerPurchaseOrder(OdooService $odooService)
    {
        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        $items = [];
        foreach ($lowStockProducts as $prod) {
            $items[] = [
                'name' => $prod->name . ' (' . $prod->sku . ')',
                'quantity' => 15,
                'price' => $prod->price * 0.5,
            ];
        }

        if (empty($items)) {
            $items[] = [
                'name' => 'Armazón Ray-Ban Clubmaster (Stock Preventivo)',
                'quantity' => 10,
                'price' => 75.00,
            ];
        }

        $res = $odooService->createPurchaseOrder('Luxottica Eyewear Supplier', $items);

        Notification::make()
            ->title("Orden de Compra Generada")
            ->body($res['message'] ?? 'Orden de compra enviada a Odoo (purchase.order).')
            ->info()
            ->send();
    }

    public function generateCustomerInvoice(OdooService $odooService)
    {
        $latestOrder = Order::latest()->first();

        if ($latestOrder) {
            $res = $odooService->createCustomerInvoice($latestOrder);
            Notification::make()
                ->title("Factura Creada")
                ->body($res['message'] ?? 'Factura de cliente creada en Odoo (out_invoice).')
                ->success()
                ->send();
            
            $this->fetchInvoices($odooService);
        } else {
            Notification::make()->title("No hay pedidos")->warning()->send();
        }
    }

    public function fetchInvoices(OdooService $odooService)
    {
        $res = $odooService->getInvoices('out_invoice');
        $this->recentInvoices = $res['invoices'] ?? [];
    }
}
