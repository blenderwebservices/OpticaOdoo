@extends('layouts.app')

@section('title', $product->name . ' | Óptica Odoo Eyewear Studio')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex text-xs font-medium text-slate-500 mb-8 gap-2">
            <a href="{{ route('store.index') }}" class="hover:text-brand-600">Inicio</a>
            <span>/</span>
            <a href="{{ route('store.index', ['category' => $product->category?->slug]) }}" class="hover:text-brand-600">{{ $product->category?->name }}</a>
            <span>/</span>
            <span class="text-slate-900 font-semibold">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-white rounded-3xl p-8 border border-slate-200/80 shadow-sm">
            <!-- Product Preview Visual -->
            <div class="bg-slate-100 rounded-2xl p-12 flex items-center justify-center min-h-[350px] relative">
                <span class="text-9xl">
                    @if($product->category?->slug === 'gafas-de-sol') 🕶️ @elseif($product->category?->slug === 'lentes-de-contacto') 👁️ @else 👓 @endif
                </span>
                <div class="absolute top-4 left-4 bg-slate-900 text-white text-xs font-semibold px-3 py-1 rounded-full">
                    SKU: {{ $product->sku }}
                </div>
            </div>

            <!-- Product Info & Purchasing -->
            <div class="space-y-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="bg-teal-100 text-teal-800 text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $product->category?->name }}</span>
                        @if($product->brand)
                            <span class="text-xs font-bold text-slate-600">Marca: {{ $product->brand->name }}</span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold font-serif text-slate-900">{{ $product->name }}</h1>

                    <div class="mt-4 flex items-baseline gap-4">
                        @if($product->sale_price)
                            <span class="text-3xl font-extrabold text-slate-900 font-serif">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-lg text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-3xl font-extrabold text-slate-900 font-serif">${{ number_format($product->price, 2) }}</span>
                        @endif
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                            Stock disponible: {{ $product->stock }} unidades
                        </span>
                    </div>

                    <p class="text-slate-600 text-sm mt-4 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <!-- Technical Specs Grid -->
                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-100 text-xs">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            <span class="text-slate-500 block">Material Montura</span>
                            <span class="font-bold text-slate-900">{{ $product->frame_type ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            <span class="text-slate-500 block">Forma del Armazón</span>
                            <span class="font-bold text-slate-900">{{ $product->frame_shape ?? 'N/A' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            <span class="text-slate-500 block">Género Target</span>
                            <span class="font-bold text-slate-900">{{ $product->gender }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                            <span class="text-slate-500 block">Tratamiento Lente</span>
                            <span class="font-bold text-slate-900">Anti-Reflejante / UV400</span>
                        </div>
                    </div>
                </div>

                <!-- Purchase Form -->
                <form action="{{ route('store.checkout') }}" method="POST" class="space-y-4 pt-6 border-t border-slate-100">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="customer_name" required placeholder="Tu Nombre Completo" class="text-xs px-4 py-3 rounded-xl border border-slate-300">
                        <input type="email" name="email" required placeholder="Correo Electrónico" class="text-xs px-4 py-3 rounded-xl border border-slate-300">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="tel" name="phone" required placeholder="Teléfono" class="text-xs px-4 py-3 rounded-xl border border-slate-300">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required class="text-xs px-4 py-3 rounded-xl border border-slate-300">
                    </div>

                    <textarea name="shipping_address" required rows="2" placeholder="Dirección de envío completa..." class="w-full text-xs px-4 py-3 rounded-xl border border-slate-300"></textarea>

                    <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-teal-500 hover:from-brand-700 hover:to-teal-600 text-white font-extrabold text-sm py-4 rounded-2xl shadow-lg shadow-brand-600/25 transition-all">
                        Realizar Pedido Directo 🛒
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
