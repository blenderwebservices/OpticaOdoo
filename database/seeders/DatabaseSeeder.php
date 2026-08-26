<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Prescription;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users (Admin, Optometrist, Customers)
        $admin = User::create([
            'name' => 'Administrador Óptica',
            'email' => 'admin@opticaodoo.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '(555) 100-2000',
            'address' => 'Av. Principal #450, Centro Médico',
        ]);

        $optometrist = User::create([
            'name' => 'Dr. Carlos Mendoza (Optometrista)',
            'email' => 'dr.mendoza@opticaodoo.com',
            'password' => bcrypt('password'),
            'role' => 'optometrist',
            'phone' => '(555) 100-3000',
            'address' => 'Clínica Oftalmológica Nivel 2',
        ]);

        $customer1 = User::create([
            'name' => 'Ana Sofía Rodríguez',
            'email' => 'ana.sofia@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '(555) 987-6543',
            'address' => 'Calle Las Flores #12, Col. Primavera',
        ]);

        $customer2 = User::create([
            'name' => 'Fernando Gutiérrez',
            'email' => 'fernando.g@yahoo.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'phone' => '(555) 456-7890',
            'address' => 'Av. Reforma #88, Apt 4B',
        ]);

        // 2. Create Categories
        $catGraduadas = Category::create([
            'name' => 'Gafas Graduadas',
            'slug' => 'gafas-graduadas',
            'description' => 'Monturas oftálmicas graduadas de acetato, metal y titanio con filtro azul.',
        ]);

        $catSol = Category::create([
            'name' => 'Gafas de Sol',
            'slug' => 'gafas-de-sol',
            'description' => 'Protección UV400 y cristales polarizados con diseños elegantes.',
        ]);

        $catLentes = Category::create([
            'name' => 'Lentes de Contacto',
            'slug' => 'lentes-de-contacto',
            'description' => 'Lentes suaves diarios, mensuales y tóricos para astigmatismo.',
        ]);

        $catAccesorios = Category::create([
            'name' => 'Accesorios Ópticos',
            'slug' => 'accesorios',
            'description' => 'Kits de limpieza, estuches rígidos, cordones de seguridad y microfibras.',
        ]);

        // 3. Create Brands
        $brandRayban = Brand::create(['name' => 'Ray-Ban', 'slug' => 'ray-ban', 'description' => 'Icónica marca de gafas con estilo atemporal.']);
        $brandOakley = Brand::create(['name' => 'Oakley', 'slug' => 'oakley', 'description' => 'Líder en tecnología deportiva y lentes de alto rendimiento.']);
        $brandGucci = Brand::create(['name' => 'Gucci', 'slug' => 'gucci', 'description' => 'Elegancia italiana y acabados de lujo.']);
        $brandPrada = Brand::create(['name' => 'Prada Eyewear', 'slug' => 'prada', 'description' => 'Diseño vanguardista y sofisticación contemporánea.']);

        // 4. Create Products
        $p1 = Product::create([
            'name' => 'Ray-Ban Clubmaster Classic',
            'slug' => 'ray-ban-clubmaster-classic',
            'sku' => 'OPT-RB3016',
            'category_id' => $catGraduadas->id,
            'brand_id' => $brandRayban->id,
            'price' => 175.00,
            'sale_price' => 149.00,
            'stock' => 15,
            'frame_type' => 'Acetato',
            'frame_shape' => 'Wayfarer',
            'gender' => 'Unisex',
            'is_featured' => true,
            'is_active' => true,
            'description' => 'Armazón vintage atemporal con puente metálico y acetato pulido a mano. Incluye tratamiento filtro de luz azul.',
        ]);

        $p2 = Product::create([
            'name' => 'Oakley Holbrook Polarized UV400',
            'slug' => 'oakley-holbrook-polarized',
            'sku' => 'OPT-OK9102',
            'category_id' => $catSol->id,
            'brand_id' => $brandOakley->id,
            'price' => 190.00,
            'sale_price' => 165.00,
            'stock' => 8,
            'frame_type' => 'Inyectado',
            'frame_shape' => 'Rectangular',
            'gender' => 'Hombre',
            'is_featured' => true,
            'is_active' => true,
            'description' => 'Gafas de sol con tecnología Prizm que mejora el contraste de colores y elimina reflejos molestos.',
        ]);

        $p3 = Product::create([
            'name' => 'Gucci Cat-Eye Gold Rim',
            'slug' => 'gucci-cat-eye-gold',
            'sku' => 'OPT-GC0450',
            'category_id' => $catGraduadas->id,
            'brand_id' => $brandGucci->id,
            'price' => 310.00,
            'sale_price' => 280.00,
            'stock' => 4,
            'frame_type' => 'Titanio',
            'frame_shape' => 'Cat-Eye',
            'gender' => 'Mujer',
            'is_featured' => true,
            'is_active' => true,
            'description' => 'Armazón de titanio dorado ultra ligero con silueta Ojo de Gato, ideal para rostros ovalados y cuadrados.',
        ]);

        $p4 = Product::create([
            'name' => 'Prada Linea Rossa Sport',
            'slug' => 'prada-linea-rossa-sport',
            'sku' => 'OPT-PR08VS',
            'category_id' => $catSol->id,
            'brand_id' => $brandPrada->id,
            'price' => 240.00,
            'stock' => 12,
            'frame_type' => 'Inyectado',
            'frame_shape' => 'Aviador',
            'gender' => 'Unisex',
            'is_featured' => false,
            'is_active' => true,
            'description' => 'Gafas deportivas con protección envolvente, almohadillas antideslizantes y cristales espejo de alta nitidez.',
        ]);

        $p5 = Product::create([
            'name' => 'Lentes de Contacto Acuvue Oasys (Pack 6)',
            'slug' => 'acuvue-oasys-pack-6',
            'sku' => 'OPT-LC001',
            'category_id' => $catLentes->id,
            'brand_id' => $brandRayban->id,
            'price' => 55.00,
            'stock' => 30,
            'frame_type' => 'Sin Montura',
            'frame_shape' => 'Redonda',
            'gender' => 'Unisex',
            'is_featured' => false,
            'is_active' => true,
            'description' => 'Lentes de contacto de reemplazo quincenal con tecnología HydraClear Plus para máxima hidratación visual.',
        ]);

        // 5. Create Prescriptions
        $presc1 = Prescription::create([
            'user_id' => $customer1->id,
            'patient_name' => 'Ana Sofía Rodríguez',
            'sph_od' => '-2.25',
            'cyl_od' => '-0.75',
            'axis_od' => '180°',
            'add_od' => '+1.25',
            'sph_os' => '-2.00',
            'cyl_os' => '-0.50',
            'axis_os' => '175°',
            'add_os' => '+1.25',
            'pd' => '63 mm',
            'issue_date' => now()->subDays(10),
            'notes' => 'Paciente presenta astenopia por trabajo prolongado en pantalla. Se sugiere lente con filtro azul.',
        ]);

        $presc2 = Prescription::create([
            'user_id' => $customer2->id,
            'patient_name' => 'Fernando Gutiérrez',
            'sph_od' => '-1.50',
            'cyl_od' => '0.00',
            'axis_od' => '0°',
            'add_od' => '0.00',
            'sph_os' => '-1.75',
            'cyl_os' => '-0.25',
            'axis_os' => '90°',
            'add_os' => '0.00',
            'pd' => '65 mm',
            'issue_date' => now()->subDays(5),
            'notes' => 'Miopía leve. Lentes para conducir y actividades al aire libre.',
        ]);

        // 6. Create Appointments
        Appointment::create([
            'user_id' => $customer1->id,
            'optometrist_id' => $optometrist->id,
            'patient_name' => 'Ana Sofía Rodríguez',
            'email' => 'ana.sofia@gmail.com',
            'phone' => '(555) 987-6543',
            'appointment_date' => now()->addDays(1),
            'time_slot' => '10:00 AM',
            'status' => 'confirmed',
            'reason' => 'Revisión anual y graduación de armazón nuevo',
            'notes' => 'Cita confirmada por teléfono.',
        ]);

        Appointment::create([
            'user_id' => $customer2->id,
            'optometrist_id' => $optometrist->id,
            'patient_name' => 'Fernando Gutiérrez',
            'email' => 'fernando.g@yahoo.com',
            'phone' => '(555) 456-7890',
            'appointment_date' => now()->addDays(2),
            'time_slot' => '04:00 PM',
            'status' => 'pending',
            'reason' => 'Evaluación de fatiga visual',
            'notes' => 'Pendiente de reconfirmación.',
        ]);

        Appointment::create([
            'patient_name' => 'Mariana Morales',
            'email' => 'mariana.m@hotmail.com',
            'phone' => '(555) 333-2211',
            'appointment_date' => now()->addDays(3),
            'time_slot' => '11:30 AM',
            'status' => 'pending',
            'reason' => 'Examen visual completo sin costo',
        ]);

        // 7. Create Orders
        $order1 = Order::create([
            'order_number' => 'ORD-OPT8921',
            'user_id' => $customer1->id,
            'prescription_id' => $presc1->id,
            'customer_name' => 'Ana Sofía Rodríguez',
            'email' => 'ana.sofia@gmail.com',
            'phone' => '(555) 987-6543',
            'shipping_address' => 'Calle Las Flores #12, Col. Primavera',
            'total_amount' => 149.00,
            'status' => 'processing',
            'payment_status' => 'paid',
            'notes' => 'En montaje de micas antireflejantes en laboratorio.',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $p1->id,
            'quantity' => 1,
            'unit_price' => 149.00,
            'total_price' => 149.00,
        ]);

        $order2 = Order::create([
            'order_number' => 'ORD-OPT9450',
            'user_id' => $customer2->id,
            'prescription_id' => $presc2->id,
            'customer_name' => 'Fernando Gutiérrez',
            'email' => 'fernando.g@yahoo.com',
            'phone' => '(555) 456-7890',
            'shipping_address' => 'Av. Reforma #88, Apt 4B',
            'total_amount' => 165.00,
            'status' => 'delivered',
            'payment_status' => 'paid',
            'notes' => 'Entregado con estuche rígido y franela microfibra.',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $p2->id,
            'quantity' => 1,
            'unit_price' => 165.00,
            'total_price' => 165.00,
        ]);
    }
}
