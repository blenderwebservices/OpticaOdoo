@extends('layouts.app')

@section('title', 'Óptica Odoo | Colección de Armazones & Gafas de Sol Premium')

@section('content')
<!-- Hero Banner Section (Odoo Eyewear Style) -->
<section class="relative bg-slate-900 text-white overflow-hidden py-20 lg:py-28">
    <div class="absolute inset-0 z-0 opacity-40 bg-[radial-gradient(#14b8a6_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <!-- Decorative Glowing Spheres -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Hero Content -->
            <div class="space-y-8 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-teal-500/10 border border-teal-500/30 text-teal-300 text-xs font-semibold px-4 py-1.5 rounded-full backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    <span>Colección Primavera / Verano {{ date('Y') }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif leading-tight tracking-tight">
                    Estilo, Confort & <span class="bg-gradient-to-r from-teal-300 via-emerald-400 to-teal-200 bg-clip-text text-transparent">Claridad Absoluta</span>
                </h1>

                <p class="text-slate-300 text-base sm:text-lg max-w-xl font-light leading-relaxed">
                    Descubre armazones graduados ultraligeros de titanio y acetato italiano, diseñados para resaltar tu personalidad con la más alta tecnología oftálmica.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="#catalog" class="w-full sm:w-auto bg-gradient-to-r from-brand-500 to-teal-400 hover:from-brand-600 hover:to-teal-500 text-slate-950 font-extrabold text-sm py-4 px-8 rounded-full shadow-xl shadow-teal-500/20 transition-all transform hover:-translate-y-0.5 text-center">
                        Explorar Colección 🕶️
                    </a>
                    <button @click="appointmentModal = true" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-sm py-4 px-8 rounded-full backdrop-blur-md transition-all text-center">
                        Examen Visual Gratis 🩺
                    </button>
                </div>

                <!-- Trust Badges -->
                <div class="pt-8 border-t border-slate-800/80 grid grid-cols-3 gap-4 text-center lg:text-left text-xs text-slate-400">
                    <div>
                        <p class="text-white font-bold text-base font-serif">100% UV400</p>
                        <p>Protección Solar Total</p>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base font-serif">2 Años</p>
                        <p>Garantía de Armazón</p>
                    </div>
                    <div>
                        <p class="text-white font-bold text-base font-serif">24 Horas</p>
                        <p>Bifocales & Progresivos</p>
                    </div>
                </div>
            </div>

            <!-- Right Hero Card Display -->
            <div class="relative flex justify-center">
                <div class="relative w-full max-w-md bg-gradient-to-b from-slate-800/80 to-slate-900/90 border border-slate-700/60 rounded-3xl p-6 shadow-2xl backdrop-blur-xl">
                    <div class="absolute -top-3 -right-3 bg-amber-400 text-slate-950 text-[10px] font-black uppercase px-3 py-1 rounded-full shadow-md tracking-wider">
                        Más Vendido
                    </div>
                    <!-- Frame Illustration Image Mockup -->
                    <div class="bg-gradient-to-tr from-slate-700 to-slate-800 rounded-2xl p-8 mb-6 flex items-center justify-center min-h-[220px] shadow-inner relative overflow-hidden group">
                        <div class="absolute inset-0 bg-teal-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="text-center">
                            <span class="text-7xl block mb-2 transform group-hover:scale-110 transition-transform">👓</span>
                            <span class="text-xs text-teal-300 font-semibold tracking-widest uppercase">Acetato Titanio Premium</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-white font-serif">Armazón Ray-Ban Clubmaster</h3>
                            <span class="text-teal-400 font-extrabold text-lg">$149.00</span>
                        </div>
                        <p class="text-xs text-slate-400">Montura oftálmica ligera con filtro azul de pantalla y soporte ergonómico.</p>
                    </div>
                    <div class="mt-6 flex items-center gap-3">
                        <a href="#catalog" class="w-full bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs py-3 rounded-xl text-center transition-colors">
                            Ver Detalles de Modelo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Showcase Section -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-bold font-serif text-slate-900 tracking-tight">Categorías Destacadas</h2>
            <p class="text-slate-600 text-sm mt-2">Encuentra el par de lentes perfecto ajustado a tus necesidades diarias</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $cat)
                <a href="{{ route('store.index', ['category' => $cat->slug]) }}" class="group relative bg-slate-50 border border-slate-200/80 rounded-2xl p-6 hover:shadow-xl hover:border-brand-500 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-3xl mb-4 group-hover:scale-110 transition-transform">
                        @if($cat->slug === 'gafas-graduadas') 👓
                        @elseif($cat->slug === 'gafas-de-sol') 🕶️
                        @elseif($cat->slug === 'lentes-de-contacto') 👁️
                        @else 🧼
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif group-hover:text-brand-600 transition-colors">{{ $cat->name }}</h3>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $cat->description }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs font-semibold text-brand-600">
                        <span>{{ $cat->products_count }} Modelos</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Main Products Catalog Section -->
<section id="catalog" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Filters Bar -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 pb-6 border-b border-slate-200">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-brand-600 block mb-1">Catálogo Exclusivo</span>
                <h2 class="text-3xl font-bold font-serif text-slate-900">Encuentra tus Gafas Ideales</h2>
            </div>

            <!-- Filter Controls -->
            <form method="GET" action="{{ route('store.index') }}" class="flex flex-wrap items-center gap-3">
                <!-- Search Input -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por marca o modelo..." class="text-xs px-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 w-48">

                <!-- Gender Select -->
                <select name="gender" onchange="this.form.submit()" class="text-xs px-3 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Género: Todos</option>
                    <option value="Hombre" {{ request('gender') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="Mujer" {{ request('gender') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="Unisex" {{ request('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                    <option value="Niños" {{ request('gender') == 'Niños' ? 'selected' : '' }}>Niños</option>
                </select>

                <!-- Frame Shape Select -->
                <select name="shape" onchange="this.form.submit()" class="text-xs px-3 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">Forma: Todas</option>
                    <option value="Aviador" {{ request('shape') == 'Aviador' ? 'selected' : '' }}>Aviador</option>
                    <option value="Redonda" {{ request('shape') == 'Redonda' ? 'selected' : '' }}>Redonda</option>
                    <option value="Cuadrada" {{ request('shape') == 'Cuadrada' ? 'selected' : '' }}>Cuadrada</option>
                    <option value="Cat-Eye" {{ request('shape') == 'Cat-Eye' ? 'selected' : '' }}>Cat-Eye</option>
                    <option value="Rectangular" {{ request('shape') == 'Rectangular' ? 'selected' : '' }}>Rectangular</option>
                </select>

                @if(request()->hasAny(['search', 'gender', 'shape', 'category']))
                    <a href="{{ route('store.index') }}" class="text-xs text-rose-600 underline font-semibold px-2 py-1">Limpiar filtros</a>
                @endif
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                <div x-data="{ buyModal: false }" class="bg-white rounded-2xl border border-slate-200/90 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                    <!-- Image Box -->
                    <div class="relative bg-slate-100 p-6 flex items-center justify-center h-56 overflow-hidden">
                        <div class="text-6xl transform group-hover:scale-110 transition-transform duration-300">
                            @if($product->category?->slug === 'gafas-de-sol') 🕶️ @elseif($product->category?->slug === 'lentes-de-contacto') 👁️ @else 👓 @endif
                        </div>

                        <!-- Badge Overlay -->
                        <div class="absolute top-3 left-3 flex flex-col gap-1">
                            @if($product->sale_price)
                                <span class="bg-rose-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">Oferta</span>
                            @endif
                            <span class="bg-slate-900/80 text-white backdrop-blur-md text-[10px] font-medium px-2.5 py-0.5 rounded-full">
                                {{ $product->gender }}
                            </span>
                        </div>

                        @if($product->brand)
                            <div class="absolute top-3 right-3 text-[10px] font-bold text-slate-500 bg-white/90 px-2 py-0.5 rounded border border-slate-200">
                                {{ $product->brand->name }}
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="text-[11px] font-semibold text-brand-600 uppercase tracking-wider mb-1">
                                {{ $product->category?->name }} • {{ $product->frame_shape ?? 'Elegante' }}
                            </div>
                            <h3 class="text-base font-bold text-slate-900 font-serif line-clamp-1 group-hover:text-brand-600 transition-colors">
                                <a href="{{ route('store.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                @if($product->sale_price)
                                    <span class="text-xs text-slate-400 line-through mr-1">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-lg font-extrabold text-slate-900 font-serif">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-lg font-extrabold text-slate-900 font-serif">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <button @click="buyModal = true" class="bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-2 px-3.5 rounded-xl shadow-md shadow-brand-600/20 transition-all">
                                Comprar 🛒
                            </button>
                        </div>
                    </div>

                    <!-- Quick Buy Modal for Product -->
                    <div x-show="buyModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="buyModal = false"></div>
                        <div class="flex min-h-full items-center justify-center p-4">
                            <div class="relative bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100 text-left">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="font-serif font-bold text-lg text-slate-900">Comprar {{ $product->name }}</h4>
                                    <button @click="buyModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
                                </div>

                                <form action="{{ route('store.checkout') }}" method="POST" class="space-y-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="p-3 bg-slate-50 rounded-xl flex items-center justify-between text-xs font-semibold text-slate-700 mb-3">
                                        <span>Precio Unitario:</span>
                                        <span class="text-brand-600 text-sm font-bold">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo</label>
                                        <input type="text" name="customer_name" required class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300">
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Correo</label>
                                            <input type="email" name="email" required class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Teléfono</label>
                                            <input type="tel" name="phone" required class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">Dirección de Entrega</label>
                                        <textarea name="shipping_address" required rows="2" class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300" placeholder="Calle, número, colonia, código postal..."></textarea>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Cantidad</label>
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Graduación / Notas</label>
                                            <input type="text" name="notes" placeholder="Ej. Esfera -1.50" class="w-full text-xs px-3 py-2 rounded-lg border border-slate-300">
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full mt-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-3 rounded-xl shadow-md">
                                        Confirmar Pedido & Enviar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-slate-200">
                    <p class="text-slate-500 font-medium">No se encontraron armazones o gafas con los filtros seleccionados.</p>
                    <a href="{{ route('store.index') }}" class="inline-block mt-3 text-xs font-bold text-brand-600 underline">Ver todos los productos</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Eye Exam Callout Banner (Odoo Industry Feature) -->
<section class="py-16 bg-gradient-to-r from-brand-900 via-slate-900 to-teal-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="space-y-3 text-center md:text-left">
            <span class="bg-teal-500/20 text-teal-300 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Servicio Oftálmico Especializado</span>
            <h2 class="text-3xl font-bold font-serif">¿No conoces tu graduación exacta?</h2>
            <p class="text-slate-300 text-sm max-w-xl">
                Agenda un examen de la vista computarizado en nuestro gabinete óptico. Nuestros optometristas evaluarán tu salud ocular sin costo en la compra de tu montura.
            </p>
        </div>
        <button @click="appointmentModal = true" class="bg-teal-400 hover:bg-teal-300 text-slate-950 font-extrabold text-sm py-4 px-8 rounded-full shadow-lg shadow-teal-400/20 transition-transform transform hover:scale-105 whitespace-nowrap">
            Reservar Cita Médica 📅
        </button>
    </div>
</section>
@endsection
