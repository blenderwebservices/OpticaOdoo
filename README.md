# Óptica Odoo | Eyewear Studio & ERP Integration System

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

---

## 🎯 Objetivo de la Aplicación

**Óptica Odoo** es una solución web integral construida en **Laravel 13** y **Filament PHP v3** diseñada para la gestión clínica, comercial y operativa de ópticas, centros de optometría y laboratorios oftálmicos.

El objetivo principal de la aplicación es centralizar la operación diaria de la óptica (atención a pacientes, agendamiento de exámenes de la vista, catálogo de armazones/micas y ventas en mostrador) y **sincronizar de forma automatizada e unilateral** todos los eventos comerciales hacia una instancia de **Odoo ERP** (Community / Enterprise / SaaS).

---

## 🔄 Arquitectura de Sincronización Unilateral (Laravel ➔ Odoo ERP)

La aplicación opera bajo un modelo de **Sincronización Unilateral de Salida (Push Integration)**. Cada registro o transacción creado en Óptica Odoo se procesa localmente y se replica inmediatamente hacia el ERP Odoo a través de los servicios centralizados en [`app/Services/OdooService.php`](file:///Users/franc/Herd/OpticaOdoo/app/Services/OdooService.php).

```
┌────────────────────────────────┐                 ┌───────────────────────────────┐
│     Óptica Odoo (Laravel)      │                 │           Odoo ERP            │
│  (Gestión Clínica y Ventas)    │                 │    (Servidor en la Nube)    │
├────────────────────────────────┤                 ├───────────────────────────────┤
│ • Registro de Pacientes/User   │ ──(res.partner)─► │ • Directores de Contacto      │
│ • Órdenes de Venta (Order)     │ ──(sale.order)──► │ • Cotizaciones y Pedidos      │
│ • Facturación y Cobranza       │ ──(account.move)► │ • Facturas (out_invoice)      │
│ • Reabastecimiento Stock Bajo  │ ─(purchase.order)►│ • Órdenes de Compra a Proveed.│
└────────────────────────────────┘                 └───────────────────────────────┘
```

### Flujos de Sincronización Unilateral:

1. **Pacientes y Clientes (`User` ➔ `res.partner`)**:
   - Al registrar o actualizar un paciente o cliente en la app, se invoca `createCustomer()`.
   - Se crea o actualiza la ficha del contacto en Odoo marcándolo como cliente (`customer_rank = 1`).

2. **Ventas y Cotizaciones (`Order` ➔ `sale.order` & `sale.order.line`)**:
   - Al crearse una orden de compra de armazones o graduación de micas, se ejecuta `createSaleOrder()`.
   - Se genera una Orden de Venta (`sale.order`) en Odoo vinculada al cliente (`partner_id`) con el desglose de productos, cantidades y precios.

3. **Facturación de Clientes (`Order` ➔ `account.move` - `out_invoice`)**:
   - Al marcar un pedido como pagado o generar comprobante fiscal, se invoca `createCustomerInvoice()`.
   - Se crea un asiento contable de tipo Factura de Cliente (`out_invoice`) en el módulo de Facturación/Contabilidad de Odoo.

4. **Órdenes de Compra por Stock Bajo (`Product` ➔ `purchase.order`)**:
   - Al detectar productos con inventario igual o inferior al mínimo configurado (`stock <= 3`), se ejecuta `createPurchaseOrder()`.
   - Se genera una Orden de Compra automatizada dirigida a proveedores registrados en Odoo (`supplier_rank = 1`).

---

## 🔌 APIs y Protocolos Utilizados

### 1. **Odoo External JSON-RPC 2.0 API**
- **Protocolo**: HTTP POST con payload JSON-RPC 2.0 (`/jsonrpc`).
- **Autenticación**:
  - Firma remota mediante `API Key` (Personal Access Token) y el `UID` (User ID) del usuario en Odoo.
  - Resolución dinámica del `UID` asociado a la API Key.
- **Servicios JSON-RPC de Odoo**:
  - **`common` / `version`**: Validación del estado de conexión y versión de la instancia Odoo (ej. `Odoo saas~19.4+e`).
  - **`object` / `execute_kw`**: Ejecución de métodos remotos (`search_read`, `create`, `write`) sobre los modelos del ERP:
    - **`res.partner`**: Clientes, pacientes y proveedores de monturas.
    - **`sale.order` & `sale.order.line`**: Registro de ventas.
    - **`account.move`**: Facturas de clientes (`out_invoice`).
    - **`purchase.order`**: Compras de reabastecimiento.
    - **`ir.module.module`**: Lectura de aplicaciones y módulos instalados.
    - **`res.company`**: Lectura de empresas y sucursales accesibles vía API.
    - **`res.users`**: Lectura de datos del usuario autenticado vía API Key.

### 2. **Filament PHP Admin Panel & Livewire Widgets**
- **Panel de Control**: Implementado con **Filament v3**.
- **Widgets de Integración**:
  - [`OdooStatusWidget`](file:///Users/franc/Herd/OpticaOdoo/app/Filament/Widgets/OdooStatusWidget.php): Muestra URL, Base de Datos, estado de conexión (En Línea / Fallback), usuario autenticado via API y versión del servidor Odoo.
  - [`OdooCompaniesWidget`](file:///Users/franc/Herd/OpticaOdoo/app/Filament/Widgets/OdooCompaniesWidget.php): Muestra la lista de empresas y sucursales accesibles (`res.company`).
  - [`OdooInstalledAppsWidget`](file:///Users/franc/Herd/OpticaOdoo/app/Filament/Widgets/OdooInstalledAppsWidget.php): Muestra el listado de aplicaciones y módulos activos en Odoo.
  - [`OdooSyncStatsWidget`](file:///Users/franc/Herd/OpticaOdoo/app/Filament/Widgets/OdooSyncStatsWidget.php): Métricas de objetos sincronizados entre la app y Odoo.

---

### 3. **Aislamiento y Ligue de Empresa Única (`ODOO_COMPANY_NAME` / `ODOO_COMPANY_ID`)**
- Esta aplicación está **estrictamente ligada a una única empresa** dentro del ERP Odoo, definida fácilmente por su nombre mediante `ODOO_COMPANY_NAME="ES VISION"` o por su ID numérico `ODOO_COMPANY_ID=2`.
- El servicio resuelve dinámicamente el `company_id` en Odoo por nombre o ID.
- Todas las operaciones de creación (clientes, órdenes de venta, facturas y órdenes de compra) adjuntan automáticamente la clave `'company_id' => $companyId`.
- Las demás empresas registradas en la instancia de Odoo ERP permanecen completamente invisibles para esta aplicación.

---

## ⚙️ Configuración del Entorno (`.env`)

Para establecer la conexión con la instancia de Odoo ERP y ligar la aplicación a la empresa deseada (ejemplo: **ES VISION**), configure las siguientes variables en su archivo `.env`:

```ini
# Odoo API Credentials
ODOO_URL=https://es-labs.odoo.com
ODOO_DB=es-labs
ODOO_API_KEY=tu_api_key_de_odoo
ODOO_UID=5
ODOO_COMPANY_NAME="ES VISION"
ODOO_COMPANY_ID=2
```

---

## 🚀 Requisitos e Instalación

### Requisitos:
- **PHP**: ^8.3
- **Composer**: v2.x
- **Node.js & npm**

### Pasos de Instalación:
```bash
# 1. Clonar el repositorio e instalar dependencias
composer install
npm install

# 2. Configurar el archivo de entorno
cp .env.example .env
php artisan key:generate

# 3. Ejecutar migraciones y seeders
php artisan migrate --seed

# 4. Iniciar el servidor local y compilar assets
npm run build
php artisan serve
```

Acceda al panel de administración en: `http://localhost:8000/admin`
