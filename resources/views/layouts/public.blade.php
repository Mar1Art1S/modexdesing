@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ filled($title) ? $title . ' | Modex - Full-Stack 3D Engineering' : 'Modex - Full-Stack 3D Printing & Technical Engineering' }}</title>
        <meta name="description" content="{{ $description ?? 'From concept to physical reality: Full-stack mechanical engineering, parametric 3D CAD modeling, rapid additive manufacturing, and turnkey assembly.' }}">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Google Fonts: Unbounded (Headings), Inter (Body), Caveat (Logo script) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@300;400;500;600;700&family=Unbounded:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-blueprint-grid {
                background-color: #ffffff;
                background-image: 
                    radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.08) 0%, transparent 60%),
                    linear-gradient(to right, rgba(14, 165, 233, 0.05) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(14, 165, 233, 0.05) 1px, transparent 1px);
                background-size: 100% 100%, 36px 36px, 36px 36px;
            }

            .font-heading {
                font-family: 'Unbounded', system-ui, sans-serif;
            }

            .font-body {
                font-family: 'Inter', system-ui, sans-serif;
            }

            .btn-cyan-glow {
                background: linear-gradient(180deg, #10263c 0%, #0c1c2e 100%);
                border: 1px solid rgba(56, 189, 248, 0.85);
                box-shadow: 0 0 18px rgba(14, 165, 233, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.15);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .btn-cyan-glow:hover {
                border-color: #38bdf8;
                box-shadow: 0 0 28px rgba(14, 165, 233, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.25);
                transform: translateY(-1px);
            }
            .btn-cyan-glow:active {
                transform: translateY(1px);
            }

            .card-tech-glow {
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .card-tech-glow:hover {
                border-color: rgba(14, 165, 233, 0.6);
                box-shadow: 0 16px 36px -8px rgba(14, 165, 233, 0.2), 0 0 0 1px rgba(14, 165, 233, 0.25);
                transform: translateY(-3px);
            }

            .nav-active-glow {
                position: relative;
                color: #0284c7;
                font-weight: 600;
            }
            .nav-active-glow::after {
                content: '';
                position: absolute;
                bottom: -6px;
                left: 0;
                right: 0;
                height: 2.5px;
                background-color: #0ea5e9;
                border-radius: 9999px;
                box-shadow: 0 0 10px #0ea5e9, 0 0 16px rgba(14, 165, 233, 0.7);
            }
        </style>
    </head>
    <body class="bg-blueprint-grid text-slate-800 font-body min-h-screen flex flex-col antialiased selection:bg-sky-500 selection:text-white"
          x-data="{ 
              orderModalOpen: false, 
              selectedService: '3D Printing & Prototyping',
              mobileMenuOpen: false,
              submitted: false,
              previewHero: null,
              previewCard1: null,
              previewCard2: null,
              previewCard3: null,
              handleImageUpload(event, key) {
                  const file = event.target.files[0];
                  if (file) {
                      this[key] = URL.createObjectURL(file);
                  }
              }
          }">

        <!-- ============================================================ -->
        <!-- NAVIGATION HEADER                                            -->
        <!-- ============================================================ -->
        <header class="sticky top-0 z-40 bg-white/85 backdrop-blur-md border-b border-slate-200/80 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                
                <!-- BRAND LOGO -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-hidden">
                    <img src="{{ asset('images/logo-modex-accent.png') }}" 
                         alt="Modex - the way you like" 
                         class="h-10 sm:h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                         onerror="this.style.display='none'; document.getElementById('logo-fallback-nav').classList.remove('hidden');" />
                    
                    <div id="logo-fallback-nav" class="hidden flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full border border-sky-500/80 p-1 flex items-center justify-center shadow-[0_0_12px_rgba(14,165,233,0.3)]">
                            <div class="w-full h-full rounded-full border border-sky-400/40 flex items-center justify-center">
                                <svg class="w-6 h-6 text-sky-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 16c2-4 3-8 6-8s3 8 6 8 4-8 4-8" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-['Caveat',cursive] text-2xl font-bold text-slate-900 leading-none tracking-wide">Modex</span>
                            <span class="text-[11px] text-slate-500 tracking-wider lowercase font-sans">the way you like</span>
                        </div>
                    </div>
                </a>

                <!-- DESKTOP NAVIGATION LINKS -->
                <nav class="hidden md:flex items-center gap-8 text-[15px] tracking-normal">
                    <a href="{{ route('home') }}" 
                       class="{{ request()->routeIs('home') ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600 font-medium' }} py-1 transition-colors duration-200">
                        Home
                    </a>
                    <a href="{{ route('projects') }}" 
                       class="{{ request()->routeIs('projects') ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600 font-medium' }} py-1 transition-colors duration-200">
                        Projects
                    </a>
                    <a href="{{ route('printing') }}" 
                       class="{{ request()->routeIs('printing') ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600 font-medium' }} py-1 transition-colors duration-200">
                        3D Printing
                    </a>
                    <a href="{{ route('engineering') }}" 
                       class="{{ request()->routeIs('engineering') ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600 font-medium' }} py-1 transition-colors duration-200">
                        Technical Engineering
                    </a>
                    <a href="{{ route('contacts') }}" 
                       class="{{ request()->routeIs('contacts') ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600 font-medium' }} py-1 transition-colors duration-200">
                        Contacts
                    </a>
                </nav>

                <!-- HEADER ACTION BUTTON -->
                <div class="hidden sm:flex items-center gap-4">
                    <button type="button" 
                            @click="orderModalOpen = true; selectedService = 'General Project'" 
                            class="btn-cyan-glow text-white text-sm font-semibold px-5 py-2.5 rounded-xl cursor-pointer">
                        Order a Project
                    </button>
                </div>

                <!-- MOBILE HAMBURGER TOGGLE -->
                <button type="button" 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-lg text-slate-700 hover:text-sky-600 hover:bg-slate-100 transition-colors"
                        aria-label="Toggle navigation menu">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- MOBILE MENU DROPDOWN -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden bg-white/95 backdrop-blur-md border-b border-slate-200 px-6 py-4 space-y-3">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('home') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600 font-medium' }} py-1">Home</a>
                <a href="{{ route('projects') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('projects') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600 font-medium' }} py-1">Projects</a>
                <a href="{{ route('printing') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('printing') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600 font-medium' }} py-1">3D Printing</a>
                <a href="{{ route('engineering') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('engineering') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600 font-medium' }} py-1">Technical Engineering</a>
                <a href="{{ route('contacts') }}" @click="mobileMenuOpen = false" class="block {{ request()->routeIs('contacts') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600 font-medium' }} py-1">Contacts</a>
                <div class="pt-2">
                    <button type="button" 
                            @click="orderModalOpen = true; mobileMenuOpen = false; selectedService = 'General Project'" 
                            class="w-full btn-cyan-glow text-white text-sm font-semibold px-5 py-2.5 rounded-xl cursor-pointer">
                        Order a Project
                    </button>
                </div>
            </div>
        </header>

        <!-- MAIN PAGE CONTENT -->
        <main class="grow">
            {{ $slot }}
        </main>

        <!-- ============================================================ -->
        <!-- CONTACT & FOOTER SECTION                                     -->
        <!-- ============================================================ -->
        <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <!-- Brand -->
                    <div class="md:col-span-2">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full border border-sky-400 p-1 flex items-center justify-center">
                                <svg class="w-5 h-5 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 16c2-4 3-8 6-8s3 8 6 8 4-8 4-8" />
                                </svg>
                            </div>
                            <span class="font-['Caveat',cursive] text-2xl font-bold text-white leading-none">Modex</span>
                            <span class="text-xs text-slate-400 font-sans tracking-wide">the way you like</span>
                        </div>
                        <p class="text-sm text-slate-400 max-w-sm leading-relaxed">
                            Full-stack technical engineering, precision additive manufacturing, electronics integration, and turnkey physical product execution.
                        </p>
                    </div>

                    <!-- Services -->
                    <div>
                        <h4 class="font-heading text-xs font-bold text-white uppercase tracking-wider mb-4">Core Competencies</h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li><a href="{{ route('printing') }}" class="hover:text-sky-400 transition-colors">Industrial 3D Printing (FDM/SLA)</a></li>
                            <li><a href="{{ route('engineering') }}" class="hover:text-sky-400 transition-colors">Parametric CAD & Topology Optimization</a></li>
                            <li><a href="{{ route('engineering') }}" class="hover:text-sky-400 transition-colors">Electronics & PCB Packaging</a></li>
                            <li><a href="{{ route('projects') }}" class="hover:text-sky-400 transition-colors">Case Studies & Hardware Portfolio</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="font-heading text-xs font-bold text-white uppercase tracking-wider mb-4">Workshop & Direct Contact</h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li class="flex items-center gap-2">
                                <span class="text-sky-400">●</span>
                                <span>orders@modexdesign.com</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-sky-400">●</span>
                                <span>Kyiv / Global Express Shipping</span>
                            </li>
                            <li class="pt-2">
                                <button type="button" 
                                        @click="orderModalOpen = true"
                                        class="text-xs font-semibold text-sky-400 hover:text-sky-300 underline underline-offset-4 cursor-pointer">
                                    Book Technical Consultation →
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                    <p>&copy; {{ date('Y') }} Modex. Full-Stack 3D Engineering. All rights reserved.</p>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="hover:text-slate-400 transition-colors">Client Portal</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hover:text-slate-400 transition-colors">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </footer>

        <!-- ============================================================ -->
        <!-- UNIVERSAL "ORDER A PROJECT" MODAL DIALOG                     -->
        <!-- ============================================================ -->
        <div x-show="orderModalOpen" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            
            <div x-show="orderModalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
                 @click="orderModalOpen = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="orderModalOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 p-6 sm:p-8">
                    
                    <button type="button" 
                            @click="orderModalOpen = false; submitted = false"
                            class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <template x-if="!submitted">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                <span class="text-xs font-mono text-sky-700 font-semibold tracking-wider">FULL-STACK INTAKE</span>
                            </div>
                            <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">
                                Order a Technical Project
                            </h3>
                            <p class="text-sm text-slate-600 mt-1">
                                Submit CAD models, electrical requirements, or concept sketches for immediate DFM and cost estimation.
                            </p>

                            <form @submit.prevent="submitted = true" class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                        Primary Scope
                                    </label>
                                    <select x-model="selectedService" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50">
                                        <option value="3D Printing & Prototyping">3D Printing &amp; Prototyping (FDM / SLA / SLS)</option>
                                        <option value="Technical Engineering">Parametric 3D CAD &amp; Stress Analysis</option>
                                        <option value="Electronics & PCB Enclosure">Electronics Enclosure &amp; PCB Fit</option>
                                        <option value="Turnkey Hardware Product">Full-Stack Turnkey Hardware Product</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Name</label>
                                        <input type="text" required placeholder="Alex Miller" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email / Phone</label>
                                        <input type="text" required placeholder="alex@tech.com" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Technical Brief &amp; Tolerances</label>
                                    <textarea rows="3" placeholder="Target material (e.g. Carbon-Fiber Nylon, PEEK, Resin), operating environment, tolerances, or volume..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50"></textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Upload 3D CAD / PCB Files</label>
                                    <div class="rounded-xl border border-dashed border-slate-300 p-3 text-center bg-slate-50/60 hover:bg-sky-50/40 transition-colors">
                                        <input type="file" multiple class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-600 file:text-white hover:file:bg-sky-700 cursor-pointer" />
                                        <p class="text-[11px] text-slate-400 mt-1">Accepts STL, STEP, IGES, OBJ, DXF, Gerber, or PDF (up to 100MB)</p>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full btn-cyan-glow text-white font-semibold py-3 px-5 rounded-xl cursor-pointer text-sm">
                                        Submit Technical Request
                                    </button>
                                </div>
                            </form>
                        </div>
                    </template>

                    <template x-if="submitted">
                        <div class="text-center py-6">
                            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="font-heading text-xl font-bold text-slate-900">Engineering Brief Received</h3>
                            <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto">
                                Your specifications have been queued for DFM review. Our lead engineer will provide a feasibility report within 24 hours.
                            </p>
                            <button type="button" 
                                    @click="orderModalOpen = false; submitted = false"
                                    class="mt-6 px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors cursor-pointer">
                                Close
                            </button>
                        </div>
                    </template>

                </div>
            </div>
        </div>

    </body>
</html>

