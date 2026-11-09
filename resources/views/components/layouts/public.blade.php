@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ filled($title) ? $title . ' | Modex - Фулстек 3D Друк та Інженерія' : 'Modex - Фулстек 3D Друк та Технічне Проектування' }}</title>
        <meta name="description" content="{{ $description ?? 'Від задуму до фізичної реальності: Фулстек інженерне проектування, параметричне 3D CAD моделювання, індустріальне адитивне виробництво та складання «під ключ».' }}">

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Google Fonts: Unbounded (Headings), Inter (Body), Caveat (Logo script) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@300;400;500;600;700&family=Unbounded:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Three.js Native ES Module Import Map for 3D Background Reel -->
        <script type="importmap">
        {
            "imports": {
                "three": "/vendor/three/build/three.module.min.js",
                "three/addons/": "/vendor/three/addons/"
            }
        }
        </script>
        <link rel="modulepreload" href="/vendor/three/build/three.module.min.js">

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

            /* 3D Morphing Background Reel in Hero */
            #hero-morph-stage {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                background: transparent !important;
                --canvas-filter: invert(1) hue-rotate(180deg) saturate(0.9);
                --canvas-blend: multiply;
                --canvas-opacity: 0.95;
            }
            #hero-morph-stage canvas {
                opacity: 0;
                filter: invert(1) hue-rotate(180deg) saturate(0.9) !important;
                mix-blend-mode: multiply !important;
                transition: opacity 1.8s cubic-bezier(0.16, 1, 0.3, 1);
                display: block;
                width: 100%;
                height: 100%;
            }
            #hero-morph-stage.is-live canvas {
                opacity: 0.95 !important;
            }

            /* 4-Step Engineering Pipeline Tab & Stage Styling */
            .pipeline-tab-btn.active {
                background: #0284c7;
                color: #ffffff !important;
                box-shadow: 0 0 10px rgba(14, 165, 233, 0.4);
            }
            .pipeline-tab-btn.active span {
                color: #ffffff !important;
            }
            #hero-pipeline-stage canvas {
                display: block;
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body class="bg-blueprint-grid text-slate-800 font-body min-h-screen flex flex-col antialiased selection:bg-sky-500 selection:text-white"
          x-data="{ 
              lang: localStorage.getItem('modex_lang') || 'ua',
              setLang(l) {
                  this.lang = l;
                  localStorage.setItem('modex_lang', l);
              },
              activeSection: 'hero',
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
              },
              init() {
                  const sections = ['hero', 'services', 'projects', 'printing', 'engineering', 'contacts'];
                  const onScroll = () => {
                      const scrollPos = window.scrollY + 140;
                      for (const id of sections) {
                          const el = document.getElementById(id);
                          if (el) {
                              const top = el.offsetTop;
                              const height = el.offsetHeight;
                              if (scrollPos >= top && scrollPos < top + height) {
                                  this.activeSection = id;
                              }
                          }
                      }
                  };
                  window.addEventListener('scroll', onScroll, { passive: true });
                  onScroll();
              }
          }">

        <!-- ============================================================ -->
        <!-- TECHNICAL DRAFTING TOP RULER (CAD COORDINATE HEADER)         -->
        <!-- ============================================================ -->
        <div class="hidden lg:flex items-center justify-between px-6 py-1 bg-slate-900 text-slate-400 font-mono text-[10px] border-b border-slate-800 select-none z-50">
            <div class="flex items-center gap-4">
                <span class="text-sky-400 font-bold" x-show="lang === 'ua'">MODEX // ІНЖЕНЕРНЕ БЮРО ТА ЛАБОРАТОРІЯ</span>
                <span class="text-sky-400 font-bold" x-show="lang === 'en'">MODEX // DRAFTING LAB</span>
                <span x-show="lang === 'ua'">ЗОНА: [A-1 &rarr; D-8]</span>
                <span x-show="lang === 'en'">ZONE: [A-1 &rarr; D-8]</span>
                <span class="text-slate-500">|</span>
                <span x-show="lang === 'ua'">ДОПУСК: &plusmn;0.05 мм</span>
                <span x-show="lang === 'en'">TOLERANCE: &plusmn;0.05 mm</span>
                <span x-show="lang === 'ua'">ТОЧНІСТЬ: КАЛІБРОВАНИЙ ДРУК</span>
                <span x-show="lang === 'en'">PRECISION: CALIBRATED PRINT</span>
            </div>
            <div class="flex items-center gap-6">
                <span x-show="lang === 'ua'">КООРД: <span class="text-sky-400 font-semibold" x-text="'[' + activeSection.toUpperCase() + ' // АКТИВНА ЗОНА]'"></span></span>
                <span x-show="lang === 'en'">COORD: <span class="text-sky-400 font-semibold" x-text="'[' + activeSection.toUpperCase() + ' // VIEWPORT]'"></span></span>
                <span class="text-slate-500">|</span>
                <span x-show="lang === 'ua'">КРЕСЛЕННЯ: MDX-2026-FDM</span>
                <span x-show="lang === 'en'">DWG NO: MDX-2026-FDM</span>
                <span class="px-1.5 py-0.2 rounded bg-sky-950 text-sky-300 border border-sky-800" x-show="lang === 'ua'">МАСШТАБ: 1:1</span>
                <span class="px-1.5 py-0.2 rounded bg-sky-950 text-sky-300 border border-sky-800" x-show="lang === 'en'">SCALE: 1:1</span>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- NAVIGATION HEADER (ONE-PAGE SMOOTH SCROLL)                   -->
        <!-- ============================================================ -->
        <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-300 shadow-xs transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                
                <!-- BRAND LOGO WITH CAD TAG -->
                <a href="#hero" class="flex items-center gap-3 group focus:outline-hidden">
                    <img src="{{ asset('images/modex-header-logo-accent.png') }}" 
                         alt="Modex - the way you like" 
                         class="h-10 sm:h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                         onerror="this.src='{{ asset('images/modex4.png') }}';" />
                </a>

                <!-- DESKTOP ONE-PAGE ANCHOR NAVIGATION LINKS -->
                <nav class="hidden md:flex items-center gap-6 text-[14px] lg:text-[15px] tracking-normal font-medium">
                    <a href="#hero" 
                       :class="activeSection === 'hero' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">Home</span>
                        <span x-show="lang === 'ua'">Головна</span>
                    </a>
                    <a href="#services" 
                       :class="activeSection === 'services' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">Capabilities</span>
                        <span x-show="lang === 'ua'">Напрямки</span>
                    </a>
                    <a href="#projects" 
                       :class="activeSection === 'projects' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">Projects</span>
                        <span x-show="lang === 'ua'">Проекти</span>
                    </a>
                    <a href="#printing" 
                       :class="activeSection === 'printing' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">3D Printing</span>
                        <span x-show="lang === 'ua'">3D Друк</span>
                    </a>
                    <a href="#engineering" 
                       :class="activeSection === 'engineering' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">How it Works</span>
                        <span x-show="lang === 'ua'">Як ми працюємо</span>
                    </a>
                    <a href="#contacts" 
                       :class="activeSection === 'contacts' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
                       class="py-1 transition-colors duration-200">
                        <span x-show="lang === 'en'">Contacts</span>
                        <span x-show="lang === 'ua'">Контакти</span>
                    </a>
                </nav>

                <!-- HEADER ACTION BUTTONS & LANGUAGE SWITCHER -->
                <div class="hidden sm:flex items-center gap-3.5">
                    <!-- LANGUAGE TOGGLE -->
                    <div class="flex items-center p-0.5 rounded-lg bg-slate-100 border border-slate-300 text-xs font-semibold">
                        <button type="button" 
                                @click="setLang('en')"
                                :class="lang === 'en' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                                class="px-2.5 py-1 rounded-md transition-all cursor-pointer">
                            EN
                        </button>
                        <button type="button" 
                                @click="setLang('ua')"
                                :class="lang === 'ua' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                                class="px-2.5 py-1 rounded-md transition-all cursor-pointer">
                            UA
                        </button>
                    </div>

                    <!-- ORDER PROJECT CTA (EXACT GLOW FROM MOCKUP) -->
                    <button type="button" 
                            @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Загальний Проект' : 'General Project')" 
                            class="btn-cyan-glow text-white text-xs sm:text-sm font-semibold px-4.5 py-2.5 rounded-xl cursor-pointer">
                        <span x-show="lang === 'en'">Order a Project</span>
                        <span x-show="lang === 'ua'">Замовити Проект</span>
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
                 class="md:hidden bg-white/98 backdrop-blur-md border-b border-slate-300 px-6 py-4 space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <span class="text-xs text-slate-500 font-mono">LANGUAGE:</span>
                    <div class="flex items-center p-0.5 rounded-lg bg-slate-100 border border-slate-300 text-xs font-semibold">
                        <button type="button" @click="setLang('en')" :class="lang === 'en' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500'" class="px-2.5 py-1 rounded-md">EN</button>
                        <button type="button" @click="setLang('ua')" :class="lang === 'ua' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500'" class="px-2.5 py-1 rounded-md">UA</button>
                    </div>
                </div>
                <a href="#hero" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">Home</span><span x-show="lang === 'ua'">Головна</span>
                </a>
                <a href="#services" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">Capabilities</span><span x-show="lang === 'ua'">Напрямки</span>
                </a>
                <a href="#projects" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">Projects</span><span x-show="lang === 'ua'">Проекти</span>
                </a>
                <a href="#printing" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">3D Printing</span><span x-show="lang === 'ua'">3D Друк</span>
                </a>
                <a href="#engineering" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">How it Works</span><span x-show="lang === 'ua'">Як ми працюємо</span>
                </a>
                <a href="#contacts" @click="mobileMenuOpen = false" class="block text-slate-700 hover:text-sky-600 font-medium py-1">
                    <span x-show="lang === 'en'">Contacts</span><span x-show="lang === 'ua'">Контакти</span>
                </a>
                <a href="{{ route('test-animation') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 font-medium py-0.5 font-mono text-xs">
                    <span>🌀 Xplore AI Демо &rarr;</span>
                </a>
                <div class="pt-2">
                    <button type="button" 
                            @click="orderModalOpen = true; mobileMenuOpen = false; selectedService = (lang === 'ua' ? 'Загальний Проект' : 'General Project')" 
                            class="w-full btn-cyan-glow text-white text-sm font-semibold px-5 py-2.5 rounded-xl cursor-pointer">
                        <span x-show="lang === 'en'">Order a Project</span>
                        <span x-show="lang === 'ua'">Замовити Проект</span>
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
                    <div class="md:col-span-2" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('home') }}" class="inline-block mb-4 group">
                            <img src="{{ asset('images/modex-header-logo-white.png') }}" 
                                 alt="Modex - the way you like" 
                                 class="h-10 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                                 onerror="this.src='{{ asset('images/modex4.png') }}';" />
                        </a>
                        <p class="text-sm text-slate-400 max-w-sm leading-relaxed" x-show="lang === 'ua'">
                            Повний цикл інженерного проектування, високоточне адитивне виробництво, інтеграція електроніки та складання готових виробів «під ключ».
                        </p>
                        <p class="text-sm text-slate-400 max-w-sm leading-relaxed" x-show="lang === 'en'">
                            Full-stack technical engineering, precision additive manufacturing, electronics integration, and turnkey physical product execution.
                        </p>
                    </div>

                    <!-- Services -->
                    <div data-aos="fade-up" data-aos-delay="200">
                        <h4 class="font-heading text-xs font-bold text-white uppercase tracking-wider mb-4">
                            <span x-show="lang === 'ua'">Напрямки Діяльності</span>
                            <span x-show="lang === 'en'">Core Competencies</span>
                        </h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li>
                                <a href="#printing" class="hover:text-sky-400 transition-colors">
                                    <span x-show="lang === 'ua'">3D Друк та Прототипування (PLA / PETG)</span>
                                    <span x-show="lang === 'en'">3D Printing &amp; Prototyping (PLA / PETG)</span>
                                </a>
                            </li>
                            <li>
                                <a href="#engineering" class="hover:text-sky-400 transition-colors">
                                    <span x-show="lang === 'ua'">Процес 3D-друку деталей</span>
                                    <span x-show="lang === 'en'">Parts 3D Printing Workflow</span>
                                </a>
                            </li>
                            <li>
                                <a href="#services" class="hover:text-sky-400 transition-colors">
                                    <span x-show="lang === 'ua'">Корпуси для РЕА та Інтеграція Плат</span>
                                    <span x-show="lang === 'en'">Electronics & PCB Packaging</span>
                                </a>
                            </li>
                            <li>
                                <a href="#projects" class="hover:text-sky-400 transition-colors">
                                    <span x-show="lang === 'ua'">Портфоліо та Реалізовані Проекти</span>
                                    <span x-show="lang === 'en'">Case Studies & Hardware Portfolio</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('test-animation') }}" class="text-slate-400 hover:text-slate-300 transition-colors inline-flex items-center gap-1.5 font-mono text-xs">
                                    <span x-show="lang === 'ua'">Тестова копія Xplore AI &rarr;</span>
                                    <span x-show="lang === 'en'">Test Copy Xplore AI &rarr;</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h4 class="font-heading text-xs font-bold text-white uppercase tracking-wider mb-4">
                            <span x-show="lang === 'ua'">Майстерня та Зв'язок</span>
                            <span x-show="lang === 'en'">Workshop & Direct Contact</span>
                        </h4>
                        <ul class="space-y-2 text-sm text-slate-400">
                            <li class="flex items-center gap-2">
                                <span class="text-sky-400">●</span>
                                <a href="mailto:orders@modexdesign.com" class="hover:text-sky-400 transition-colors">orders@modexdesign.com</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-pink-400">●</span>
                                <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" class="hover:text-pink-400 transition-colors">Instagram: @modexdesign</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-blue-400">●</span>
                                <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" class="hover:text-blue-400 transition-colors">Facebook: modexdesign</a>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-slate-400">●</span>
                                <span x-show="lang === 'ua'">Київ / Відправка Новою Поштою щодня</span>
                                <span x-show="lang === 'en'">Kyiv / Daily Courier Dispatch</span>
                            </li>
                            <li class="pt-2">
                                <button type="button" 
                                        @click="orderModalOpen = true"
                                        class="text-xs font-semibold text-sky-400 hover:text-sky-300 underline underline-offset-4 cursor-pointer">
                                    <span x-show="lang === 'ua'">Замовити Консультацію Інженера →</span>
                                    <span x-show="lang === 'en'">Book Technical Consultation →</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                    <p x-show="lang === 'ua'">&copy; {{ date('Y') }} Modex. Фулстек 3D Інженерія. Всі права захищено.</p>
                    <p x-show="lang === 'en'">&copy; {{ date('Y') }} Modex. Full-Stack 3D Engineering. All rights reserved.</p>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="hover:text-slate-400 transition-colors">
                            <span x-show="lang === 'ua'">Портал Клієнта</span>
                            <span x-show="lang === 'en'">Client Portal</span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hover:text-slate-400 transition-colors">
                                <span x-show="lang === 'ua'">Реєстрація</span>
                                <span x-show="lang === 'en'">Register</span>
                            </a>
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
                                <span class="text-xs font-mono text-sky-700 font-semibold tracking-wider" x-show="lang === 'ua'">ТЕХНІЧНЕ ЗАМОВЛЕННЯ</span>
                                <span class="text-xs font-mono text-sky-700 font-semibold tracking-wider" x-show="lang === 'en'">FULL-STACK INTAKE</span>
                            </div>
                            <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">
                                <span x-show="lang === 'ua'">Замовити Технічний Проект</span>
                                <span x-show="lang === 'en'">Order a Technical Project</span>
                            </h3>
                            <p class="text-sm text-slate-600 mt-1">
                                <span x-show="lang === 'ua'">Надішліть CAD-моделі, вимоги до електроніки або ескізи для швидкого DFM-аналізу та розрахунку вартості.</span>
                                <span x-show="lang === 'en'">Submit CAD models, electrical requirements, or concept sketches for immediate DFM and cost estimation.</span>
                            </p>

                            <form @submit.prevent="submitted = true" class="mt-6 space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                        <span x-show="lang === 'ua'">Основний Напрям</span>
                                        <span x-show="lang === 'en'">Primary Scope</span>
                                    </label>
                                    <select x-model="selectedService" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50">
                                        <template x-if="lang === 'ua'">
                                            <optgroup label="Оберіть тип замовлення">
                                                <option value="Замовлення (Креслення / Фото деталі)">1. Замовлення (Креслення / Фото деталі)</option>
                                                <option value="3D-Моделювання деталі з нуля">2. 3D-Моделювання деталі з нуля</option>
                                                <option value="Процес 3D-друку (готовий файл STL/STEP)">3. Процес 3D-друку (готовий файл STL/STEP)</option>
                                                <option value="Готова модель / Серійний тираж">4. Готова модель / Серійний тираж деталей</option>
                                            </optgroup>
                                        </template>
                                        <template x-if="lang === 'en'">
                                            <optgroup label="Select Order Stage">
                                                <option value="Order (Drawing / Photo of part)">1. Order (Drawing / Photo of part)</option>
                                                <option value="3D CAD Modeling from scratch">2. 3D CAD Modeling from scratch</option>
                                                <option value="3D Print Job (Ready STL/STEP file)">3. 3D Print Job (Ready STL/STEP file)</option>
                                                <option value="Ready Model / Batch Production">4. Ready Model / Batch Production</option>
                                            </optgroup>
                                        </template>
                                    </select>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                            <span x-show="lang === 'ua'">Ваше Ім'я</span>
                                            <span x-show="lang === 'en'">Name</span>
                                        </label>
                                        <input type="text" required :placeholder="lang === 'ua' ? 'Олександр Коваленко' : 'Alex Miller'" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                            <span x-show="lang === 'ua'">Email / Телефон</span>
                                            <span x-show="lang === 'en'">Email / Phone</span>
                                        </label>
                                        <input type="text" required :placeholder="lang === 'ua' ? 'alex@engineering.ua' : 'alex@tech.com'" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                        <span x-show="lang === 'ua'">Технічне Завдання, Матеріал та Допуски</span>
                                        <span x-show="lang === 'en'">Technical Brief &amp; Tolerances</span>
                                    </label>
                                    <textarea rows="3" :placeholder="lang === 'ua' ? 'Цільовий матеріал (PLA, PETG), колір, заповнення, умови експлуатації або обсяг партії...' : 'Target material (PLA, PETG), color, infill, operating environment, or batch volume...'" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50"></textarea>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                        <span x-show="lang === 'ua'">Завантажити файли 3D CAD / Gerber</span>
                                        <span x-show="lang === 'en'">Upload 3D CAD / PCB Files</span>
                                    </label>
                                    <div class="rounded-xl border border-dashed border-slate-300 p-3 text-center bg-slate-50/60 hover:bg-sky-50/40 transition-colors">
                                        <input type="file" multiple class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-600 file:text-white hover:file:bg-sky-700 cursor-pointer" />
                                        <p class="text-[11px] text-slate-400 mt-1" x-show="lang === 'ua'">Підтримуються формати STL, STEP, IGES, OBJ, DXF, Gerber або PDF (до 100 МБ)</p>
                                        <p class="text-[11px] text-slate-400 mt-1" x-show="lang === 'en'">Accepts STL, STEP, IGES, OBJ, DXF, Gerber, or PDF (up to 100MB)</p>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full btn-cyan-glow text-white font-semibold py-3 px-5 rounded-xl cursor-pointer text-sm">
                                        <span x-show="lang === 'ua'">Надіслати Технічний Запит</span>
                                        <span x-show="lang === 'en'">Submit Technical Request</span>
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
                            <h3 class="font-heading text-xl font-bold text-slate-900">
                                <span x-show="lang === 'ua'">Технічне Завдання Отримано</span>
                                <span x-show="lang === 'en'">Engineering Brief Received</span>
                            </h3>
                            <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto">
                                <span x-show="lang === 'ua'">Ваші специфікації передано інженеру на DFM-аналіз. Ми надішлемо звіт про можливість виготовлення протягом 24 годин.</span>
                                <span x-show="lang === 'en'">Your specifications have been queued for DFM review. Our lead engineer will provide a feasibility report within 24 hours.</span>
                            </p>
                            <button type="button" 
                                    @click="orderModalOpen = false; submitted = false"
                                    class="mt-6 px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors cursor-pointer">
                                <span x-show="lang === 'ua'">Закрити</span>
                                <span x-show="lang === 'en'">Close</span>
                            </button>
                        </div>
                    </template>

                </div>
            </div>
        </div>

    </body>
</html>
