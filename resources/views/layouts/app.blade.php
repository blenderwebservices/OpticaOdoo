<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Óptica Odoo | Armazones Premium, Gafas de Sol & Examen Visual')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,500..800;1,500..800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            dark: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 flex flex-col min-h-screen" x-data="{ appointmentModal: false, mobileMenu: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-brand-900 text-teal-100 text-xs py-2 px-4 text-center font-medium flex items-center justify-center gap-3 shadow-inner">
        <span>👓 <strong>Odoo Eyewear Studio:</strong> Envío Gratis en compras mayores a $75.00</span>
        <span class="hidden sm:inline">|</span>
        <span class="hidden sm:inline">🩺 Examen de la vista sin costo al comprar tu armazón</span>
        <a href="/admin" class="ml-4 underline hover:text-white font-bold bg-teal-800/60 px-2 py-0.5 rounded text-[11px]">Acceder a Panel Admin ➔</a>
    </div>

    <!-- Header Navigation -->
    <header class="bg-white/90 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('store.index') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-700 to-teal-500 flex items-center justify-center text-white shadow-md shadow-brand-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 block font-serif">Óptica Odoo</span>
                            <span class="text-[10px] tracking-widest text-brand-600 uppercase font-semibold block -mt-1">Eyewear Studio</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 font-medium text-slate-700 text-sm">
                    <a href="{{ route('store.index') }}" class="hover:text-brand-600 transition-colors">Inicio</a>
                    <a href="{{ route('store.index', ['category' => 'gafas-graduadas']) }}" class="hover:text-brand-600 transition-colors">Gafas Graduadas</a>
                    <a href="{{ route('store.index', ['category' => 'gafas-de-sol']) }}" class="hover:text-brand-600 transition-colors">Gafas de Sol</a>
                    <a href="{{ route('store.index', ['category' => 'lentes-de-contacto']) }}" class="hover:text-brand-600 transition-colors">Lentes de Contacto</a>
                    <a href="#about" class="hover:text-brand-600 transition-colors">Nosotros</a>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center gap-4">
                    <button @click="appointmentModal = true" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-teal-500 hover:from-brand-700 hover:to-teal-600 text-white font-semibold text-xs py-2.5 px-4 rounded-full shadow-lg shadow-brand-600/25 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 002-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Agendar Cita Visual</span>
                    </button>

                    <a href="/admin" class="p-2 text-slate-600 hover:text-brand-600 rounded-lg hover:bg-slate-100 transition-colors" title="Panel Administrativo (Filament)">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-600 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenu" class="md:hidden border-t border-slate-200 bg-white px-4 py-4 space-y-3">
            <a href="{{ route('store.index') }}" class="block text-slate-700 font-medium hover:text-brand-600">Inicio</a>
            <a href="{{ route('store.index', ['category' => 'gafas-graduadas']) }}" class="block text-slate-700 font-medium hover:text-brand-600">Gafas Graduadas</a>
            <a href="{{ route('store.index', ['category' => 'gafas-de-sol']) }}" class="block text-slate-700 font-medium hover:text-brand-600">Gafas de Sol</a>
            <a href="{{ route('store.index', ['category' => 'lentes-de-contacto']) }}" class="block text-slate-700 font-medium hover:text-brand-600">Lentes de Contacto</a>
            <button @click="appointmentModal = true; mobileMenu = false" class="w-full mt-2 bg-brand-600 text-white font-semibold text-xs py-2.5 px-4 rounded-xl shadow-md">
                Agendar Cita Visual
            </button>
        </div>
    </header>

    <!-- Success Flash Notification -->
    @if(session('success'))
        <div class="bg-emerald-600 text-white py-3 px-4 shadow-lg text-center font-semibold text-sm flex items-center justify-center gap-2 relative">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-teal-500 flex items-center justify-center text-white font-bold">Ó</div>
                        <span class="text-xl font-bold font-serif text-white">Óptica Odoo</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Expertos en salud visual y diseño de monturas oftálmicas de primera clase. Claridad, estilo y precisión en cada lente.
                    </p>
                    <div class="text-xs text-teal-400 font-medium">
                        📍 Av. Principal #450, Centro Médico de Salud Visual
                    </div>
                </div>

                <!-- Col 2: Colecciones -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider">Colecciones</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('store.index', ['category' => 'gafas-graduadas']) }}" class="hover:text-teal-400">Armazones oftálmicos</a></li>
                        <li><a href="{{ route('store.index', ['category' => 'gafas-de-sol']) }}" class="hover:text-teal-400">Gafas de Sol UV400</a></li>
                        <li><a href="{{ route('store.index', ['category' => 'lentes-de-contacto']) }}" class="hover:text-teal-400">Lentes de Contacto</a></li>
                        <li><a href="{{ route('store.index', ['category' => 'accesorios']) }}" class="hover:text-teal-400">Kits de limpieza & fundas</a></li>
                    </ul>
                </div>

                <!-- Col 3: Servicios Ópticos -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider">Servicios Clínicos</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><button @click="appointmentModal = true" class="hover:text-teal-400 text-left">Examen de la Vista Automatizado</button></li>
                        <li><span class="hover:text-teal-400 cursor-pointer">Adaptación de Lentes de Contacto</span></li>
                        <li><span class="hover:text-teal-400 cursor-pointer">Bifocales & Progresivos Digitales</span></li>
                        <li><span class="hover:text-teal-400 cursor-pointer">Filtro de Luz Azul (Anti-Blue Ray)</span></li>
                    </ul>
                </div>

                <!-- Col 4: Horarios & Contacto -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider">Atención al Cliente</h4>
                    <p class="text-sm text-slate-400 mb-2">Lun - Sáb: 9:00 AM - 7:00 PM</p>
                    <p class="text-sm text-slate-400 mb-4">Domingos: 10:00 AM - 3:00 PM</p>
                    <p class="text-sm text-teal-300 font-semibold">📞 (555) 019-2834</p>
                    <p class="text-sm text-teal-300 font-semibold">✉️ citas@opticaodoo.com</p>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} Óptica Odoo Eyewear Studio. Todos los derechos reservados.</p>
                <div class="flex items-center gap-6">
                    <a href="/admin" class="hover:text-teal-400 font-medium">Panel de Administración (FilamentPHP)</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal para Agendar Cita Examen de la Vista -->
    <div x-show="appointmentModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="appointmentModal = false"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-8 border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center">
                            🩺
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 font-serif">Agendar Examen de la Vista</h3>
                            <p class="text-xs text-slate-500">Evaluación completa por nuestros optometristas</p>
                        </div>
                    </div>
                    <button @click="appointmentModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('store.book_appointment') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nombre Completo del Paciente</label>
                        <input type="text" name="patient_name" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="Ej. Roberto Gómez">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                            <input type="email" name="email" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="correo@ejemplo.com">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Teléfono Móvil</label>
                            <input type="tel" name="phone" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="(555) 000-0000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Fecha Deseada</label>
                            <input type="date" name="appointment_date" min="{{ date('Y-m-d') }}" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Horario Preferido</label>
                            <select name="time_slot" required class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none bg-white">
                                <option value="09:00 AM">09:00 AM</option>
                                <option value="10:30 AM">10:30 AM</option>
                                <option value="12:00 PM">12:00 PM</option>
                                <option value="03:30 PM">03:30 PM</option>
                                <option value="05:00 PM">05:00 PM</option>
                                <option value="06:30 PM">06:30 PM</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Motivo de la Cita / Comentarios</label>
                        <textarea name="notes" rows="2" class="w-full text-sm px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-teal-500 focus:outline-none" placeholder="Indica si necesitas lentes progresivos, examen de rutina, molestias o molestia particular..."></textarea>
                    </div>

                    <button type="submit" class="w-full mt-2 bg-gradient-to-r from-brand-600 to-teal-500 hover:from-brand-700 hover:to-teal-600 text-white font-bold text-sm py-3 px-6 rounded-xl shadow-lg shadow-teal-500/25 transition-all">
                        Confirmar Cita Médica
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
