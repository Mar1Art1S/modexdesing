<x-layouts.public title="Modex | Full-Stack 3D Printing & Technical Hardware Engineering" description="Single-page technical engineering platform: Parametric CAD, high-voltage substations, precision 3D printing in PLA & PETG, FEA simulation, and turnkey electromechanical assembly.">
    
    <!-- ============================================================ -->
    <!-- SECTION 1: FULL-SCREEN HERO WITH ZAS.JPG & CAD DRAWING FRAME -->
    <!-- ============================================================ -->
    <section id="hero" class="relative min-h-[700px] lg:h-[calc(100vh-5.5rem)] lg:max-h-[900px] flex flex-col justify-between overflow-hidden bg-[#e5e9ee]">
        
        <!-- TECHNICAL DRAFTING BORDER: ZONE MARKERS (A-D, 1-8) -->
        <div class="hidden xl:flex absolute top-3 left-8 right-8 justify-between text-[11px] font-mono text-slate-500 font-bold select-none z-20 pointer-events-none">
            <span>[ZONE: 01]</span><span>[ZONE: 02]</span><span>[ZONE: 03]</span><span>[ZONE: 04]</span><span>[ZONE: 05]</span><span>[ZONE: 06]</span><span>[ZONE: 07]</span><span>[ZONE: 08]</span>
        </div>
        <div class="hidden xl:flex flex-col absolute top-20 bottom-20 left-3 justify-between text-[11px] font-mono text-slate-500 font-bold select-none z-20 pointer-events-none">
            <span>[A]</span><span>[B]</span><span>[C]</span><span>[D]</span>
        </div>

        <!-- FULL-BLEED HERO BACKGROUND: ZAS.JPG SPREAD ACROSS ENTIRE SCREEN -->
        <div class="absolute inset-0 w-full h-full pointer-events-none select-none z-0 overflow-hidden">
            <!-- Full-screen original cover image (zas.jpg) -->
            <img src="{{ asset('images/zas.jpg') }}" 
                 alt="Modex Substation Engineering Cover" 
                 class="w-full h-full object-cover object-right lg:object-[82%_center]" />

            <!-- Technical Blueprint Grid Overlay -->
            <div class="absolute inset-0 bg-blueprint-grid opacity-25 mix-blend-multiply pointer-events-none"></div>

            <!-- Left soft gradient wash for crystal-clear text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#e5e9ee] via-[#e5e9ee]/90 sm:via-[#e5e9ee]/80 to-transparent w-full lg:w-[56%] pointer-events-none"></div>

            <!-- Top subtle fade for header blend -->
            <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-[#e5e9ee]/80 to-transparent pointer-events-none"></div>

            <!-- Bottom soft fade for cards grounding -->
            <div class="absolute bottom-0 left-0 right-0 h-44 bg-gradient-to-t from-[#e5e9ee] via-[#e5e9ee]/75 to-transparent pointer-events-none"></div>
        </div>

        <!-- FLOATING CAD HUD BADGES (OVER TECHNICAL SUBSTATION COVER) -->
        <div class="hidden lg:flex items-center gap-3 absolute top-6 right-8 xl:right-16 z-20 pointer-events-auto select-none">
            <div class="px-3.5 py-1.5 rounded-md bg-white/90 backdrop-blur-md border border-slate-300 shadow-sm text-xs font-mono text-slate-700 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span x-show="lang === 'ua'">3D ДРУК ДЕТАЛЕЙ // МАЙСТЕРНЯ ПРОТОТИПІВ</span>
                <span x-show="lang === 'en'">3D PRINTING WORKSHOP // PROTOTYPING</span>
            </div>
            <div class="px-3 py-1.5 rounded-md bg-white/90 backdrop-blur-md border border-slate-300 shadow-sm text-xs font-mono text-slate-700">
                <span x-show="lang === 'ua'">МАСШТАБ: 1:1 (ТОЧНИЙ РОЗМІР)</span>
                <span x-show="lang === 'en'">SCALE: 1:1 (EXACT FIT)</span>
            </div>
            <div class="px-3 py-1.5 rounded-md bg-white/90 backdrop-blur-md border border-slate-300 shadow-sm text-xs font-mono text-slate-700">
                <span class="text-sky-600 font-bold">&plusmn;0.05 mm</span>
            </div>
        </div>

        <!-- UPPER HERO: HEADLINE, SUBTITLE, BUTTONS, SPECS (BIG TEXT & BIG BLOCKS) -->
        <div class="relative z-10 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-8 sm:pt-12 lg:pt-16 pb-8 grow flex items-center">
            <div class="max-w-3xl lg:max-w-2xl xl:max-w-3xl">
                
                <!-- TECHNICAL BADGE (LARGER & BOLDER) -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/95 backdrop-blur-md border-2 border-sky-400 text-sky-900 text-xs sm:text-sm font-mono font-bold mb-6 shadow-sm" data-aos="fade-down" data-aos-duration="600">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500 animate-pulse"></span>
                    <span x-show="lang === 'ua'">ІНДУСТРІАЛЬНИЙ 3D ДРУК ТА ФУЛСТЕК ІНЖЕНЕРІЯ</span>
                    <span x-show="lang === 'en'">INDUSTRIAL 3D PROTOTYPING &amp; FULL-STACK HARDWARE</span>
                </div>

                <!-- MAIN TITLE (BIGGER DISPLAY TYPOGRAPHY) -->
                <h1 class="font-heading text-3xl sm:text-5xl lg:text-[3.35rem] xl:text-[3.75rem] font-black tracking-tight text-slate-900 leading-[1.08]" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                    <span x-show="lang === 'ua'">
                        ВІД ЗАДУМУ ДО РЕАЛЬНОСТІ:<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-sky-800 to-sky-600">3D ДРУК ТА ТЕХНІЧНЕ</span><br>
                        ПРОЕКТУВАННЯ
                    </span>
                    <span x-show="lang === 'en'">
                        FROM CONCEPT TO REALITY:<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-sky-800 to-sky-600">3D PRINTING &amp; TECHNICAL</span><br>
                        ENGINEERING
                    </span>
                </h1>

                <!-- SUBTITLE (LARGER & MORE SPACIOUS) -->
                <p class="mt-6 text-base sm:text-lg lg:text-xl text-slate-700 max-w-2xl font-normal leading-relaxed" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                    <span x-show="lang === 'ua'">Високоточне моделювання, прототипування та виготовлення складних технічних проектів з повним циклом інженерного контролю.</span>
                    <span x-show="lang === 'en'">High-precision 3D modeling, rapid prototyping, and turnkey manufacturing of complex hardware engineering projects.</span>
                </p>

                <!-- ACTION BUTTONS (LARGER, IMPACTFUL BUTTONS) -->
                <div class="mt-8 flex flex-wrap items-center gap-4" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
                    <button type="button" 
                            @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D Друк та Прототипування' : '3D Printing & Prototyping')"
                            class="btn-cyan-glow text-white text-base sm:text-lg font-bold px-8 sm:px-10 py-4 rounded-xl cursor-pointer">
                        <span x-show="lang === 'ua'">Почати Проект</span>
                        <span x-show="lang === 'en'">Start a Project</span>
                    </button>
                    
                    <a href="#services" 
                       class="inline-flex items-center justify-center px-8 sm:px-9 py-4 rounded-xl text-base sm:text-lg font-bold text-slate-900 bg-white hover:bg-slate-50 border-2 border-slate-900 shadow-sm hover:border-sky-500 hover:text-sky-600 hover:shadow-[0_0_20px_rgba(14,165,233,0.25)] transition-all duration-300">
                        <span x-show="lang === 'ua'">Наші Напрямки &darr;</span>
                        <span x-show="lang === 'en'">Our Capabilities &darr;</span>
                    </a>
                </div>

                <!-- TECHNICAL HIGHLIGHT SPECS (LARGER BOLD NUMBERS) -->
                <div class="mt-10 pt-6 border-t-2 border-slate-300/80 grid grid-cols-3 gap-6 max-w-xl font-mono" data-aos="fade-up" data-aos-duration="700" data-aos-delay="400">
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">±0.05 <span class="text-sky-600 text-sm font-normal">mm</span></div>
                        <div class="text-xs text-slate-600 uppercase tracking-wider mt-1 font-bold" x-text="lang === 'ua' ? 'Точність друку' : 'Precision Accuracy'"></div>
                    </div>
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">24 <span class="text-sky-600 text-sm font-normal">hrs</span></div>
                        <div class="text-xs text-slate-600 uppercase tracking-wider mt-1 font-bold" x-text="lang === 'ua' ? 'Швидкість партії' : 'Rapid Turnaround'"></div>
                    </div>
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl font-black text-slate-900">100% <span class="text-sky-600 text-sm font-normal">CAD</span></div>
                        <div class="text-xs text-slate-600 uppercase tracking-wider mt-1 font-bold" x-text="lang === 'ua' ? 'Параметричне CAD' : 'Parametric Design'"></div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!-- ============================================================ -->
    <!-- SECTION 2: CORE ENGINEERING CAPABILITIES SHOWCASE MATRIX      -->
    <!-- RECREATED TO MATCH TECHNICAL SPECIFICATION MATRIX BLUEPRINT   -->
    <!-- ============================================================ -->
    <section id="services" class="py-20 lg:py-28 cad-blueprint-substrate relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- TECHNICAL DIMENSION SEPARATOR (CAD LEADER ARROWS) -->
            <div class="flex items-center justify-between text-[11px] sm:text-xs font-mono text-slate-500 font-semibold mb-12 select-none">
                <div class="flex items-center flex-1">
                    <span class="text-slate-400 font-mono font-bold select-none">|&larr;</span>
                    <span class="flex-1 border-t border-slate-300 ml-2 mr-3"></span>
                </div>
                <span class="tracking-widest uppercase text-slate-500 text-center font-bold px-1 whitespace-nowrap">
                    CORE ENGINEERING CAPABILITIES // SPECIFICATION MATRIX [REF: MODEX-P01]
                </span>
                <div class="flex items-center flex-1">
                    <span class="flex-1 border-t border-slate-300 ml-3 mr-2"></span>
                    <span class="text-slate-400 font-mono font-bold select-none">&rarr;|</span>
                </div>
            </div>

            <!-- TWO-COLUMN ENGINEERING MATRIX LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-stretch">
                
                <!-- LEFT COLUMN: TITLE, INTRO & DRAFTING SHEET STAMP -->
                <div class="lg:col-span-5 flex flex-col justify-between" data-aos="fade-right" data-aos-duration="700">
                    <div>
                        <!-- Section Badge -->
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-sky-50 border border-sky-300 text-sky-800 text-xs font-mono font-bold uppercase tracking-wider mb-4">
                            <span x-show="lang === 'ua'">// МОЖЛИВОСТІ // 3D-ДРУК ТА МОДЕЛЮВАННЯ</span>
                            <span x-show="lang === 'en'">// CAPABILITIES // 3D PRINTING &amp; CAD</span>
                        </div>

                        <!-- Section Main Heading -->
                        <h2 class="font-heading text-3xl sm:text-4xl lg:text-[44px] font-black text-slate-900 tracking-tight leading-[1.15]">
                            <span x-show="lang === 'ua'">Повний Цикл Виготовлення<br class="hidden sm:inline"> Деталей.</span>
                            <span x-show="lang === 'en'">Complete Parts Prototyping<br class="hidden sm:inline"> &amp; 3D Printing.</span>
                        </h2>

                        <!-- Intro Paragraph -->
                        <p class="text-base sm:text-lg text-slate-600 mt-4 leading-relaxed font-normal">
                            <span x-show="lang === 'ua'">Від першої ідеї, фотографії зразка чи простого ескізу на папері — до точної 3D-моделі, підбору надійного пластику (PLA або PETG) та чистого друку готової деталі.</span>
                            <span x-show="lang === 'en'">From an initial idea, reference photo, or paper sketch — to a precise 3D model, proper plastic selection (PLA or PETG), and clean manufacturing of the finished part.</span>
                        </p>
                    </div>

                    <!-- MODEX WORKSHOP DRAFTING SHEET TITLE BLOCK -->
                    <div class="mt-8 lg:mt-12 border-2 border-slate-900 bg-white shadow-xs font-mono text-xs overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                        <!-- Dark Top Title Bar -->
                        <div class="bg-slate-900 text-white px-3.5 py-2 flex items-center justify-between font-bold text-[11px] sm:text-xs tracking-wider">
                            <span>MODEX WORKSHOP DRAFTING SHEET</span>
                            <span class="text-sky-400">DWG: MDX-2026-FDM</span>
                        </div>

                        <!-- Row 1: Developer & Project Code (2 columns) -->
                        <div class="grid grid-cols-2 divide-x divide-slate-900 border-b border-slate-900">
                            <div class="p-2.5 sm:p-3">
                                <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">
                                    <span x-show="lang === 'ua'">МАЙСТЕРНЯ / ВИРОБНИЦТВО:</span>
                                    <span x-show="lang === 'en'">WORKSHOP / PRODUCER:</span>
                                </div>
                                <div class="text-[11px] sm:text-xs font-bold text-slate-900 mt-0.5">MODEX 3D WORKSHOP</div>
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">
                                    <span x-show="lang === 'ua'">НАПРЯМОК РОБІТ:</span>
                                    <span x-show="lang === 'en'">PROJECT SCOPE:</span>
                                </div>
                                <div class="text-[11px] sm:text-xs font-bold text-slate-900 mt-0.5">CUSTOM 3D PRINTING</div>
                            </div>
                        </div>

                        <!-- Row 2: Scale, Tolerance, Material (3 columns) -->
                        <div class="grid grid-cols-3 divide-x divide-slate-900 border-b border-slate-900">
                            <div class="p-2.5 sm:p-3">
                                <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">
                                    <span x-show="lang === 'ua'">МАСШТАБ:</span>
                                    <span x-show="lang === 'en'">SCALE:</span>
                                </div>
                                <div class="text-[11px] sm:text-xs font-bold text-slate-900 mt-0.5">1:1 (EXACT FIT)</div>
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">
                                    <span x-show="lang === 'ua'">ТОЧНІСТЬ:</span>
                                    <span x-show="lang === 'en'">TOLERANCE:</span>
                                </div>
                                <div class="text-[11px] sm:text-xs font-bold text-sky-600 mt-0.5">&plusmn;0.05 mm</div>
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <div class="text-[9px] uppercase tracking-wider text-slate-500 font-semibold">
                                    <span x-show="lang === 'ua'">ПЛАСТИК:</span>
                                    <span x-show="lang === 'en'">MATERIAL:</span>
                                </div>
                                <div class="text-[11px] sm:text-xs font-bold text-slate-900 mt-0.5">PLA / PETG</div>
                            </div>
                        </div>

                        <!-- Row 3: Status & Sheet Number (with dividing vertical line) -->
                        <div class="grid grid-cols-12 divide-x divide-slate-900">
                            <div class="col-span-8 p-2.5 sm:p-3 text-[10px] sm:text-[11px] font-bold text-emerald-700 tracking-wider">
                                <span x-show="lang === 'ua'">СТАТУС: ГОТОВО ДО ДРУКУ</span>
                                <span x-show="lang === 'en'">STATUS: VERIFIED FOR PRODUCTION</span>
                            </div>
                            <div class="col-span-4 p-2.5 sm:p-3 text-right text-[10px] sm:text-[11px] font-bold text-slate-600 tracking-wider">
                                SHEET 1 OF 1
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: 3 STACKED ENGINEERING PILLAR CARDS -->
                <div class="lg:col-span-7 flex flex-col gap-4 sm:gap-5 justify-between">
                    
                    <!-- PILLAR 01: ADDITIVE 3D PRINTING -->
                    <a href="#printing" class="block group relative bg-white rounded-2xl border border-slate-300/80 shadow-xs pt-4 pb-4.5 px-5 sm:px-6 hover:border-sky-400 hover:shadow-md transition-all duration-200" data-aos="fade-left" data-aos-delay="100">
                        <!-- Corner Crosses -->
                        <span class="absolute top-2 left-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>
                        <span class="absolute bottom-2 right-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>

                        <!-- Header Row -->
                        <div class="flex items-center justify-between font-mono text-xs mb-1.5 pl-2">
                            <span class="text-sky-700 font-bold tracking-wider">PILLAR 01 // 3D PRINTING</span>
                            <span class="text-slate-500 font-normal">PRECISION: &plusmn;0.05mm</span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-heading font-black text-slate-900 text-lg sm:text-xl lg:text-[22px] leading-snug group-hover:text-sky-600 transition-colors">
                            <span x-show="lang === 'ua'">3D Друк та Прототипування: PLA та PETG</span>
                            <span x-show="lang === 'en'">3D Printing &amp; Prototyping: PLA &amp; PETG</span>
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-xs sm:text-sm mt-2 leading-relaxed font-normal">
                            <span x-show="lang === 'ua'">Високоточний 3D-друк деталей, функціональних корпусів та механічних вузлів матеріалами PLA та міцним PETG. Точне калібрування принтерів, стабільна геометрія та чисті поверхні.</span>
                            <span x-show="lang === 'en'">High-precision 3D printing of functional parts, enclosures, and mechanical components using PLA and sturdy PETG. Accurate printer calibration and clean surface finish.</span>
                        </p>

                        <!-- Dotted Divider -->
                        <div class="border-t border-dotted border-slate-200 my-3.5"></div>

                        <!-- Bottom Pills Row -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">MAX BUILD: 420x380x500 mm</span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">ШАР: 0.08 - 0.32 mm</span>
                                <span x-show="lang === 'en'">LAYER: 0.08 - 0.32 mm</span>
                            </span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">МАТЕРІАЛИ: PLA / PETG</span>
                                <span x-show="lang === 'en'">MATERIALS: PLA / PETG</span>
                            </span>
                        </div>
                    </a>

                    <!-- PILLAR 02: 3D CAD MODELING FROM SCRATCH -->
                    <a href="#engineering" class="block group relative bg-white rounded-2xl border border-slate-300/80 shadow-xs pt-4 pb-4.5 px-5 sm:px-6 hover:border-sky-400 hover:shadow-md transition-all duration-200" data-aos="fade-left" data-aos-delay="200">
                        <!-- Corner Crosses -->
                        <span class="absolute top-2 left-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>
                        <span class="absolute bottom-2 right-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>

                        <!-- Header Row -->
                        <div class="flex items-center justify-between font-mono text-xs mb-1.5 pl-2">
                            <span class="text-sky-700 font-bold tracking-wider">PILLAR 02 // 3D CAD MODELING</span>
                            <span class="text-slate-500 font-normal">
                                <span x-show="lang === 'ua'">ВІД ІДЕЇ ТА ЗРАЗКА</span>
                                <span x-show="lang === 'en'">FROM IDEA &amp; SAMPLE</span>
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-heading font-black text-slate-900 text-lg sm:text-xl lg:text-[22px] leading-snug group-hover:text-sky-600 transition-colors">
                            <span x-show="lang === 'ua'">3D-Моделювання Деталей та Розрахунок Міцності</span>
                            <span x-show="lang === 'en'">3D CAD Modeling &amp; Strength Optimization</span>
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-xs sm:text-sm mt-2 leading-relaxed font-normal">
                            <span x-show="lang === 'ua'">Побудова точних 3D-моделей за вашим зразком, фотографією чи зламаною деталлю. Оптимізація форми під робочі навантаження, посилення вразливих місць ребрами жорсткості та підготовка до запуску на принтері.</span>
                            <span x-show="lang === 'en'">Accurate 3D modeling from your physical sample, photo, or broken part. Geometry optimization under mechanical loads, structural rib reinforcement, and complete print-ready file preparation.</span>
                        </p>

                        <!-- Dotted Divider -->
                        <div class="border-t border-dotted border-slate-200 my-3.5"></div>

                        <!-- Bottom Pills Row -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">ТОЧНІ РОЗМІРИ</span>
                                <span x-show="lang === 'en'">ACCURATE DIMENSIONS</span>
                            </span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">ПОСИЛЕННЯ РЕБРАМИ ЖОРСТКОСТІ</span>
                                <span x-show="lang === 'en'">STRUCTURAL REINFORCEMENT</span>
                            </span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">ПІДГОТОВКА ДО ДРУКУ</span>
                                <span x-show="lang === 'en'">PRINT OPTIMIZATION</span>
                            </span>
                        </div>
                    </a>

                    <!-- PILLAR 03: ENCLOSURES & ASSEMBLY -->
                    <a href="#projects" class="block group relative bg-white rounded-2xl border border-slate-300/80 shadow-xs pt-4 pb-4.5 px-5 sm:px-6 hover:border-sky-400 hover:shadow-md transition-all duration-200" data-aos="fade-left" data-aos-delay="300">
                        <!-- Corner Crosses -->
                        <span class="absolute top-2 left-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>
                        <span class="absolute bottom-2 right-2.5 text-sky-600 font-mono text-xs font-bold leading-none select-none pointer-events-none">+</span>

                        <!-- Header Row -->
                        <div class="flex items-center justify-between font-mono text-xs mb-1.5 pl-2">
                            <span class="text-sky-700 font-bold tracking-wider">PILLAR 03 // ENCLOSURES &amp; ASSEMBLY</span>
                            <span class="text-slate-500 font-normal">
                                <span x-show="lang === 'ua'">СКЛАДАННЯ «ПІД КЛЮЧ»</span>
                                <span x-show="lang === 'en'">TURNKEY ASSEMBLY</span>
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-heading font-black text-slate-900 text-lg sm:text-xl lg:text-[22px] leading-snug group-hover:text-sky-600 transition-colors">
                            <span x-show="lang === 'ua'">Корпуси, Різьбові З'єднання та Складання Вузлів</span>
                            <span x-show="lang === 'en'">Enclosures, Threaded Inserts &amp; Assembly</span>
                        </h3>

                        <!-- Description -->
                        <p class="text-slate-600 text-xs sm:text-sm mt-2 leading-relaxed font-normal">
                            <span x-show="lang === 'ua'">Проектування та друк корпусів під розміри ваших плат чи електроніки, надійна термопосадка латунних різьбових втулок M2–M8 для багаторазового закручування, захист від пилу й вологи та фінальне складання готового вузла.</span>
                            <span x-show="lang === 'en'">Precision enclosure 3D printing designed around your boards and electronic components, durable heat-set brass threaded inserts (M2–M8) for repeated bolting, dust/moisture protection, and complete assembly.</span>
                        </p>

                        <!-- Dotted Divider -->
                        <div class="border-t border-dotted border-slate-200 my-3.5"></div>

                        <!-- Bottom Pills Row -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">РІЗЬБОВІ ВТУЛКИ M2-M8</span>
                                <span x-show="lang === 'en'">BRASS INSERTS M2-M8</span>
                            </span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">ПІДГОНКА ПІД ЕЛЕКТРОНІКУ</span>
                                <span x-show="lang === 'en'">PCB &amp; ELECTRONICS FIT</span>
                            </span>
                            <span class="px-2.5 py-1 rounded bg-slate-100/80 border border-slate-200/80 text-slate-700 font-mono text-[10px] sm:text-[11px] font-semibold tracking-wide">
                                <span x-show="lang === 'ua'">СКЛАДАННЯ ГОТОВОГО ВИРОБУ</span>
                                <span x-show="lang === 'en'">FINISHED ASSEMBLY</span>
                            </span>
                        </div>
                    </a>

                </div>

            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 3: HARDWARE PROJECTS & CASE STUDIES PORTFOLIO        -->
    <!-- BIGGER PROJECT SHOWCASE BLOCKS WITH BLUEPRINT SCHEMATICS    -->
    <!-- ============================================================ -->
    <section id="projects" class="py-20 lg:py-28 bg-white" x-data="{ currentFilter: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- TECHNICAL DIMENSION SEPARATOR -->
            <div class="cad-dimension-line mb-10 text-xs font-mono font-bold">
                <span x-show="lang === 'ua'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ПЕРЕВІРЕНІ ІНЖЕНЕРНІ КЕЙСИ ТА РОЗРОБКИ // ПЕРЕРІЗ C-C &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
                <span x-show="lang === 'en'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; VERIFIED HARDWARE CASE STUDIES // SECTION C-C &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12" data-aos="fade-up" data-aos-duration="600">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-sky-100 border border-sky-400 text-sky-900 text-xs sm:text-sm font-mono font-bold uppercase tracking-wider mb-3">
                        <span x-show="lang === 'ua'">ПОРТФОЛІО // РЕАЛЬНА ІНЖЕНЕРІЯ</span>
                        <span x-show="lang === 'en'">PORTFOLIO // REAL ENGINEERING</span>
                    </div>
                    <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                        <span x-show="lang === 'ua'">Реалізовані Інженерні Кейси</span>
                        <span x-show="lang === 'en'">Engineered Hardware Case Studies</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-2">
                        <span x-show="lang === 'ua'">Проекти, розраховані під екстремальні струми, механічні навантаження та агресивне середовище.</span>
                        <span x-show="lang === 'en'">Hardware designed for extreme voltages, structural loads, and outdoor environments.</span>
                    </p>
                </div>

                <!-- Category Filter Tabs (Larger buttons) -->
                <div class="flex flex-wrap items-center gap-2.5 font-mono text-xs sm:text-sm">
                    <button type="button" 
                            @click="currentFilter = 'all'" 
                            :class="currentFilter === 'all' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2.5 rounded-xl border border-slate-400 transition-all cursor-pointer">
                        <span x-show="lang === 'ua'">ВСІ [3]</span>
                        <span x-show="lang === 'en'">ALL [3]</span>
                    </button>
                    <button type="button" 
                            @click="currentFilter = 'industrial'" 
                            :class="currentFilter === 'industrial' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2.5 rounded-xl border border-slate-400 transition-all cursor-pointer">
                        <span x-show="lang === 'ua'">ПІДСТАНЦІЇ 10кВ</span>
                        <span x-show="lang === 'en'">10kV SUBSTATION</span>
                    </button>
                    <button type="button" 
                            @click="currentFilter = 'robotics'" 
                            :class="currentFilter === 'robotics' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2.5 rounded-xl border border-slate-400 transition-all cursor-pointer">
                        <span x-show="lang === 'ua'">РОБОТОТЕХНІКА</span>
                        <span x-show="lang === 'en'">ROBOTICS</span>
                    </button>
                    <button type="button" 
                            @click="currentFilter = 'mechatronics'" 
                            :class="currentFilter === 'mechatronics' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2.5 rounded-xl border border-slate-400 transition-all cursor-pointer">
                        <span x-show="lang === 'ua'">МЕХАТРОНІКА ТА R&amp;D</span>
                        <span x-show="lang === 'en'">MECHATRONICS &amp; R&amp;D</span>
                    </button>
                </div>
            </div>

            <!-- PROJECTS GRID: BIGGER CARDS WITH LARGE VIEWPORTS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- PROJECT 1: 10kV Substation Insulator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'industrial'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-500 mb-2">
                            <span class="font-bold">PRJ // 01</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'ua'">ЕНЕРГЕТИКА 10 000В</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'en'">10,000V ENERGY</span>
                        </div>
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                            <span x-show="lang === 'ua'">Модульна Підстанція 10кВ та Шинопровід</span>
                            <span x-show="lang === 'en'">10kV Substation Busbar &amp; Modular Insulator</span>
                        </h3>
                        <p class="text-sm text-slate-600 mt-2.5 leading-relaxed">
                            <span x-show="lang === 'ua'">Вогнестійкі діелектричні опори шинопровід з внутрішнім аеродинамічним ребруванням для запобігання дуговому розряду під робочою напругою 10 000 В.</span>
                            <span x-show="lang === 'en'">Flame-retardant high-voltage dielectric busbar supports with internal aerodynamic ribbing to eliminate arc discharge under 10,000V live load.</span>
                        </p>
                    </div>

                    <!-- Project Image Visual (User's Zas.jpg Substation Model) - Large h-60 Viewport -->
                    <div class="relative h-60 bg-slate-100 overflow-hidden border-b border-slate-200">
                        <img src="{{ asset('images/zas.jpg') }}" 
                             alt="10kV Modular Substation Insulator" 
                             class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105" />
                        <div class="absolute bottom-3 left-3 px-3 py-1 rounded bg-slate-900/90 backdrop-blur-xs text-xs font-mono text-white font-bold">
                            <span x-show="lang === 'ua'">МОДЕЛЬ: DIE TRAN 10кВ</span>
                            <span x-show="lang === 'en'">MODEL: DIE TRAN 10kV</span>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 font-mono text-xs text-slate-800">
                        <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b border-slate-300">
                            <div><strong x-show="lang === 'ua'">МАТЕРІАЛ:</strong><strong x-show="lang === 'en'">MATERIAL:</strong> PETG Engineering</div>
                            <div><strong x-show="lang === 'ua'">ТОЧНІСТЬ:</strong><strong x-show="lang === 'en'">TOLERANCE:</strong> &plusmn;0.04 mm</div>
                            <div><strong x-show="lang === 'ua'">ТЕМП. ПІК:</strong><strong x-show="lang === 'en'">TEMP PEAK:</strong> 85&deg;C</div>
                            <div><strong x-show="lang === 'ua'">ДІЕЛЕКТРИК:</strong><strong x-show="lang === 'en'">DIELECTRIC:</strong> 22 kV/mm</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Модульна Підстанція 10кВ' : '10kV Substation Insulator Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- PROJECT 2: Autonomous Tracked Rover with Robotic Manipulator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'robotics'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-500 mb-2">
                            <span class="font-bold">PRJ // 02</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'ua'">РОБОТОТЕХНІКА &amp; CAD</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'en'">ROBOTICS &amp; CAD</span>
                        </div>
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                            <span x-show="lang === 'ua'">Гусенична Робоплатформа з Маніпулятором</span>
                            <span x-show="lang === 'en'">Autonomous Tracked Rover with Robotic Manipulator</span>
                        </h3>
                        <p class="text-sm text-slate-600 mt-2.5 leading-relaxed">
                            <span x-show="lang === 'ua'">Проектування від технічного ескізу до робочого зразка: міцне гусеничне шасі, 6-осьова 3D-друкована рука з сервоприводами, ергономічний захват та інтегрований блок датчиків.</span>
                            <span x-show="lang === 'en'">End-to-end design from engineering sketch to functioning prototype: reinforced tracked chassis, 6-axis 3D-printed manipulator arm, custom gripper, and sensor payload.</span>
                        </p>
                    </div>

                    <!-- Project Image Visual (User's Zas2.jpg Robot Model) - Large h-60 Viewport -->
                    <div class="relative h-60 bg-slate-100 overflow-hidden border-b border-slate-200">
                        <img src="{{ asset('images/zas2.jpg') }}" 
                             alt="Autonomous Tracked Rover with Robotic Manipulator" 
                             class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105" />
                        <div class="absolute bottom-3 left-3 px-3 py-1 rounded bg-slate-900/90 backdrop-blur-xs text-xs font-mono text-white font-bold">
                            <span x-show="lang === 'ua'">МОДЕЛЬ: TRACK-ROVER M-01</span>
                            <span x-show="lang === 'en'">MODEL: TRACK-ROVER M-01</span>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 font-mono text-xs text-slate-800">
                        <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b border-slate-300">
                            <div><strong x-show="lang === 'ua'">МАТЕРІАЛ:</strong><strong x-show="lang === 'en'">MATERIAL:</strong> PETG + PLA</div>
                            <div><strong x-show="lang === 'ua'">ШАСІ:</strong><strong x-show="lang === 'en'">CHASSIS:</strong> All-Terrain Tracks</div>
                            <div><strong x-show="lang === 'ua'">МАНІПУЛЯТОР:</strong><strong x-show="lang === 'en'">MANIPULATOR:</strong> 6-DOF Servo</div>
                            <div><strong x-show="lang === 'ua'">ТОЧНІСТЬ:</strong><strong x-show="lang === 'en'">TOLERANCE:</strong> &plusmn;0.04 mm</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Гусенична Робоплатформа з Маніпулятором' : 'Tracked Rover with Manipulator Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- PROJECT 3: Full-Cycle Biomimetic Walking Robot (Draft to Assembly) -->
                <div x-show="currentFilter === 'all' || currentFilter === 'mechatronics' || currentFilter === 'iot'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-500 mb-2">
                            <span class="font-bold">PRJ // 03</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'ua'">МЕХАТРОНІКА &amp; R&amp;D</span>
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-900 font-bold" x-show="lang === 'en'">MECHATRONICS &amp; R&amp;D</span>
                        </div>
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 group-hover:text-sky-600 transition-colors leading-snug">
                            <span x-show="lang === 'ua'">Крокуючий Робот: Повний Цикл від Ескізу до Складання</span>
                            <span x-show="lang === 'en'">Full-Cycle Walking Robot (Draft to Assembly)</span>
                        </h3>
                        <p class="text-sm text-slate-600 mt-2.5 leading-relaxed">
                            <span x-show="lang === 'ua'">4 етапи розробки Modex: інженерний розрахунок і ручний ескіз, параметричне 3D CAD-моделювання, FDM-друк рухомих шарнірів та фінальне складання з електронікою.</span>
                            <span x-show="lang === 'en'">Modex 4-stage turnkey development: engineering math and hand drafting, parametric 3D CAD simulation, FDM 3D printing of joints, and electromechanical assembly.</span>
                        </p>
                    </div>

                    <!-- Project Image Visual (User's Zas3.jpg Assembly Lifecycle) - Large h-60 Viewport -->
                    <div class="relative h-60 bg-slate-100 overflow-hidden border-b border-slate-200">
                        <img src="{{ asset('images/zas3.jpg') }}" 
                             alt="Full-Cycle Walking Robot Development: Drafting, CAD, 3D Printing, Assembly" 
                             class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105" />
                        <div class="absolute bottom-3 left-3 px-3 py-1 rounded bg-slate-900/90 backdrop-blur-xs text-xs font-mono text-white font-bold">
                            <span x-show="lang === 'ua'">ЦИКЛ: ЕСКІЗ &rarr; CAD &rarr; ДРУК &rarr; СКЛАДАННЯ</span>
                            <span x-show="lang === 'en'">CYCLE: DRAFT &rarr; CAD &rarr; PRINT &rarr; ASSEMBLY</span>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 font-mono text-xs text-slate-800">
                        <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b border-slate-300">
                            <div><strong x-show="lang === 'ua'">МАТЕРІАЛ:</strong><strong x-show="lang === 'en'">MATERIAL:</strong> Tough PETG + PLA</div>
                            <div><strong x-show="lang === 'ua'">КІНЕМАТИКА:</strong><strong x-show="lang === 'en'">KINEMATICS:</strong> 12-DOF Gait</div>
                            <div><strong x-show="lang === 'ua'">СЕНСОРИ:</strong><strong x-show="lang === 'en'">SENSORS:</strong> Sonar + MCU</div>
                            <div><strong x-show="lang === 'ua'">ТОЧНІСТЬ:</strong><strong x-show="lang === 'en'">TOLERANCE:</strong> &plusmn;0.05 mm</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Крокуючий Робот Повного Циклу' : 'Full-Cycle Walking Robot Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 4: CLIENT PHOTOS → 3D PRINTED PROTOTYPE SHOWCASE     -->
    <!-- WORK PERFORMED: 3D PRINTING PROTOTYPES BASED ON CLIENT PHOTOS -->
    <!-- ============================================================ -->
    <section id="printing" class="py-20 lg:py-28 cad-blueprint-substrate">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- TECHNICAL DIMENSION SEPARATOR -->
            <div class="cad-dimension-line mb-10 text-xs font-mono font-bold">
                <span x-show="lang === 'ua'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ПРИКЛАД РОБОТИ // ФОТО ВІД ЗАМОВНИКА &rarr; РОЗРОБКА 3D-ПРОТОТИПУ &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
                <span x-show="lang === 'en'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; CLIENT CASE WORKFLOW // REFERENCE PHOTO &rarr; 3D PRINTED PROTOTYPE &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
            </div>

            <!-- SECTION HEADER -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16" data-aos="fade-up" data-aos-duration="600">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-sky-100 border border-sky-400 text-sky-900 text-xs sm:text-sm font-mono font-bold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-sky-600 animate-pulse"></span>
                    <span x-show="lang === 'ua'">ВХІДНЕ ЗАВДАННЯ // РОБОТА ПО 3D-ПРОТОТИПУ ЗА ФОТО</span>
                    <span x-show="lang === 'en'">CLIENT INPUT // 3D PROTOTYPE PRINTED FROM PHOTOS</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                    <span x-show="lang === 'ua'">Приклади Завдань: Фото від Замовника &rarr; Наш 3D-Прототип</span>
                    <span x-show="lang === 'en'">From Client Reference Photos to 3D Printed Prototype</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-600 mt-3 leading-relaxed">
                    <span x-show="lang === 'ua'">Ми не виробляємо повнорозмірні промислові споруди — це реальні фотографії, які замовник надсилає нам як вхідне завдання. Наша робота полягає у виготовленні 3D-прототипу на принтері: розробка точної 3D-моделі, друк масштабного макета, кронштейнів або функціональних деталей (PLA / PETG). Ціни обговорюються індивідуально.</span>
                    <span x-show="lang === 'en'">We do not manufacture full-scale industrial complexes — these are reference photos provided by our clients as project briefs. Our job is 3D printing the prototype: accurate 3D CAD modeling, scale prototyping, brackets, and functional test parts (in PLA or PETG). Pricing is determined individually.</span>
                </p>
            </div>

            <!-- 4-PHOTO GRID SHOWCASE (g1, g2, g3, g4) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <!-- CARD 1: g1.jpg (PORTAL BAY HANGAR) -->
                <div class="cad-corner-cross bg-white rounded-2xl border-2 border-slate-900 overflow-hidden shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <!-- Image Container with HUD -->
                        <div class="relative h-60 sm:h-64 overflow-hidden bg-slate-900 border-b-2 border-slate-900">
                            <img src="{{ asset('images/g1.jpg') }}" 
                                 alt="Client reference photo: substation bay structure" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" />
                            
                            <!-- Blueprint HUD Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute top-3 left-3 px-2 py-1 rounded bg-slate-900/90 border border-sky-400 text-sky-400 font-mono text-[10px] font-bold">
                                📸 <span x-show="lang === 'ua'">ФОТО ВІД ЗАМОВНИКА</span><span x-show="lang === 'en'">CLIENT PHOTO</span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-white font-mono text-[11px] font-bold truncate">
                                [ВХІДНИЙ ОБ'ЄКТ // ПОРТАЛИ 10кВ]
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 sm:p-6">
                            <h3 class="font-heading text-lg font-black text-slate-900 leading-snug">
                                <span x-show="lang === 'ua'">Портальні Ферми та Шинопровід</span>
                                <span x-show="lang === 'en'">Portal Structures &amp; Busbars</span>
                            </h3>

                            <!-- What Client Provided -->
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    <span x-show="lang === 'ua'">Що надав замовник:</span>
                                    <span x-show="lang === 'en'">What client provided:</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'ua'">Фото цеху та портальних сталевих ферм для оцінки габаритів та прив'язки вузлів.</p>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'en'">Hangar photos showing portal steel frames and spatial layout to assess scale.</p>
                            </div>

                            <!-- What We Did on 3D Printer -->
                            <div class="mt-2.5 p-3 rounded-xl bg-sky-50 border border-sky-200 text-xs text-sky-950">
                                <div class="font-bold text-sky-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                    <span x-show="lang === 'ua'">Робота на 3D-принтері:</span>
                                    <span x-show="lang === 'en'">Our 3D print work:</span>
                                </div>
                                <p class="text-sky-800 text-[11px] leading-relaxed" x-show="lang === 'ua'">3D-моделювання та друк точного масштабного макета для просторової перевірки та презентації.</p>
                                <p class="text-sky-800 text-[11px] leading-relaxed" x-show="lang === 'en'">3D CAD modeling and precision scaled 3D print for spatial fit check and presentation.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Material Badge -->
                    <div class="p-5 sm:p-6 pt-0 border-t border-slate-100 mt-2">
                        <div class="flex items-center justify-between text-[11px] font-mono text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                            <span class="font-bold text-slate-900" x-show="lang === 'ua'">Матеріал друку:</span>
                            <span class="font-bold text-slate-900" x-show="lang === 'en'">3D Material:</span>
                            <span class="text-sky-700 font-bold">PLA (Точний макет)</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: g2.jpg (DISCONNECT BLADES / SWITCH) -->
                <div class="cad-corner-cross bg-white rounded-2xl border-2 border-slate-900 overflow-hidden shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Image Container with HUD -->
                        <div class="relative h-60 sm:h-64 overflow-hidden bg-slate-900 border-b-2 border-slate-900">
                            <img src="{{ asset('images/g2.jpg') }}" 
                                 alt="Client reference photo: disconnect switch" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" />
                            
                            <!-- Blueprint HUD Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute top-3 left-3 px-2 py-1 rounded bg-slate-900/90 border border-amber-400 text-amber-400 font-mono text-[10px] font-bold">
                                📸 <span x-show="lang === 'ua'">ФОТО ВІД ЗАМОВНИКА</span><span x-show="lang === 'en'">CLIENT PHOTO</span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-white font-mono text-[11px] font-bold truncate">
                                [ВХІДНИЙ ОБ'ЄКТ // РОЗ'ЄДНУВАЧ]
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 sm:p-6">
                            <h3 class="font-heading text-lg font-black text-slate-900 leading-snug">
                                <span x-show="lang === 'ua'">Силовий Роз'єднувач та Замок</span>
                                <span x-show="lang === 'en'">Disconnect Switch &amp; Latch</span>
                            </h3>

                            <!-- What Client Provided -->
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    <span x-show="lang === 'ua'">Що надав замовник:</span>
                                    <span x-show="lang === 'en'">What client provided:</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'ua'">Фото вузла розмикача з мідними ножами та замком для перевірки механіки ходу.</p>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'en'">Photo of the knife disconnect blade and lock mechanism to verify articulation.</p>
                            </div>

                            <!-- What We Did on 3D Printer -->
                            <div class="mt-2.5 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-950">
                                <div class="font-bold text-amber-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span>
                                    <span x-show="lang === 'ua'">Робота на 3D-принтері:</span>
                                    <span x-show="lang === 'en'">Our 3D print work:</span>
                                </div>
                                <p class="text-amber-800 text-[11px] leading-relaxed" x-show="lang === 'ua'">Розробка геометрії шарнірів та 3D-друк рухомого тестового прототипу механізму замикання.</p>
                                <p class="text-amber-800 text-[11px] leading-relaxed" x-show="lang === 'en'">Joint geometry design and 3D printing an articulated functional prototype of the mechanism.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Material Badge -->
                    <div class="p-5 sm:p-6 pt-0 border-t border-slate-100 mt-2">
                        <div class="flex items-center justify-between text-[11px] font-mono text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                            <span class="font-bold text-slate-900" x-show="lang === 'ua'">Матеріал друку:</span>
                            <span class="font-bold text-slate-900" x-show="lang === 'en'">3D Material:</span>
                            <span class="text-amber-700 font-bold">PETG (Міцні шарніри)</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: g3.jpg (OVERSIZE MODULE TRANSPORT) -->
                <div class="cad-corner-cross bg-white rounded-2xl border-2 border-slate-900 overflow-hidden shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Image Container with HUD -->
                        <div class="relative h-60 sm:h-64 overflow-hidden bg-slate-900 border-b-2 border-slate-900">
                            <img src="{{ asset('images/g3.jpg') }}" 
                                 alt="Client reference photo: heavy modular transport" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" />
                            
                            <!-- Blueprint HUD Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute top-3 left-3 px-2 py-1 rounded bg-slate-900/90 border border-sky-400 text-sky-400 font-mono text-[10px] font-bold">
                                📸 <span x-show="lang === 'ua'">ФОТО ВІД ЗАМОВНИКА</span><span x-show="lang === 'en'">CLIENT PHOTO</span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-white font-mono text-[11px] font-bold truncate">
                                [ВХІДНИЙ ОБ'ЄКТ // ПІДСТАНЦІЯ]
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 sm:p-6">
                            <h3 class="font-heading text-lg font-black text-slate-900 leading-snug">
                                <span x-show="lang === 'ua'">Модульна Підстанція у Зборі</span>
                                <span x-show="lang === 'en'">Modular Substation Assembly</span>
                            </h3>

                            <!-- What Client Provided -->
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    <span x-show="lang === 'ua'">Що надав замовник:</span>
                                    <span x-show="lang === 'en'">What client provided:</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'ua'">Фото готового великогабаритного модуля на тралі для виготовлення точної мініатюрної копії.</p>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'en'">Photo of the full-scale assembled module on transport for scale model fabrication.</p>
                            </div>

                            <!-- What We Did on 3D Printer -->
                            <div class="mt-2.5 p-3 rounded-xl bg-sky-50 border border-sky-200 text-xs text-sky-950">
                                <div class="font-bold text-sky-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                    <span x-show="lang === 'ua'">Робота на 3D-принтері:</span>
                                    <span x-show="lang === 'en'">Our 3D print work:</span>
                                </div>
                                <p class="text-sky-800 text-[11px] leading-relaxed" x-show="lang === 'ua'">3D-друк збірного макета модуля в масштабі з окремими порталами для виставок та тендерів.</p>
                                <p class="text-sky-800 text-[11px] leading-relaxed" x-show="lang === 'en'">Multi-part scaled 3D print of the modular substation for exhibitions and project approvals.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Material Badge -->
                    <div class="p-5 sm:p-6 pt-0 border-t border-slate-100 mt-2">
                        <div class="flex items-center justify-between text-[11px] font-mono text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                            <span class="font-bold text-slate-900" x-show="lang === 'ua'">Матеріал друку:</span>
                            <span class="font-bold text-slate-900" x-show="lang === 'en'">3D Material:</span>
                            <span class="text-sky-700 font-bold">PLA (Збірний макет)</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: g4.jpg (INSULATOR COLUMNS & CONDUCTORS) -->
                <div class="cad-corner-cross bg-white rounded-2xl border-2 border-slate-900 overflow-hidden shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Image Container with HUD -->
                        <div class="relative h-60 sm:h-64 overflow-hidden bg-slate-900 border-b-2 border-slate-900">
                            <img src="{{ asset('images/g4.jpg') }}" 
                                 alt="Client reference photo: insulator stack" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500" />
                            
                            <!-- Blueprint HUD Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute top-3 left-3 px-2 py-1 rounded bg-slate-900/90 border border-emerald-400 text-emerald-400 font-mono text-[10px] font-bold">
                                📸 <span x-show="lang === 'ua'">ФОТО ВІД ЗАМОВНИКА</span><span x-show="lang === 'en'">CLIENT PHOTO</span>
                            </div>
                            <div class="absolute bottom-3 left-3 right-3 text-white font-mono text-[11px] font-bold truncate">
                                [ВХІДНИЙ ОБ'ЄКТ // ІЗОЛЯТОРИ]
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 sm:p-6">
                            <h3 class="font-heading text-lg font-black text-slate-900 leading-snug">
                                <span x-show="lang === 'ua'">Ізоляційні Колони та Струмовводи</span>
                                <span x-show="lang === 'en'">Insulator Columns &amp; Leads</span>
                            </h3>

                            <!-- What Client Provided -->
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700">
                                <div class="font-bold text-slate-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    <span x-show="lang === 'ua'">Що надав замовник:</span>
                                    <span x-show="lang === 'en'">What client provided:</span>
                                </div>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'ua'">Фото ребристих ізоляторів та кріплень кабелів із серійними мітками для розробки нових адаптерів.</p>
                                <p class="text-slate-600 text-[11px] leading-relaxed" x-show="lang === 'en'">Photo of insulator stacks and cable clamp brackets to design custom mounting adapters.</p>
                            </div>

                            <!-- What We Did on 3D Printer -->
                            <div class="mt-2.5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-950">
                                <div class="font-bold text-emerald-900 flex items-center gap-1.5 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    <span x-show="lang === 'ua'">Робота на 3D-принтері:</span>
                                    <span x-show="lang === 'en'">Our 3D print work:</span>
                                </div>
                                <p class="text-emerald-800 text-[11px] leading-relaxed" x-show="lang === 'ua'">Проектування перехідних кронштейнів та 3D-друк примірочних прототипів перед запуском у виробництво.</p>
                                <p class="text-emerald-800 text-[11px] leading-relaxed" x-show="lang === 'en'">CAD engineering of mounting brackets and 3D printing fitment prototypes prior to production.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Material Badge -->
                    <div class="p-5 sm:p-6 pt-0 border-t border-slate-100 mt-2">
                        <div class="flex items-center justify-between text-[11px] font-mono text-slate-700 bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                            <span class="font-bold text-slate-900" x-show="lang === 'ua'">Матеріал друку:</span>
                            <span class="font-bold text-slate-900" x-show="lang === 'en'">3D Material:</span>
                            <span class="text-emerald-700 font-bold">PETG (Міцний адаптер)</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- INDIVIDUAL PRICING & CUSTOM EVALUATION BANNER -->
            <div class="bg-white rounded-2xl border-2 border-slate-900 p-8 sm:p-10 shadow-xl cad-corner-cross">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-sky-100 text-sky-900 font-mono text-xs font-bold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                        <span x-show="lang === 'ua'">ІНДИВІДУАЛЬНИЙ РОЗРАХУНОК // ВАРТІСТЬ ЗАЛЕЖИТЬ ВІД ЗАВДАННЯ</span>
                        <span x-show="lang === 'en'">CUSTOM PRICING // QUOTED PER PROJECT SPECIFICATION</span>
                    </div>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        <span x-show="lang === 'ua'">Ціни на 3D-Друк Прототипів Обговорюються Індивідуально</span>
                        <span x-show="lang === 'en'">3D Prototype Pricing is Quoted Individually</span>
                    </h3>
                    <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed font-sans max-w-4xl">
                        <span x-show="lang === 'ua'">Ми виконуємо друк прототипів та деталей на 3D-принтері під індивідуальні вимоги замовника. Автоматичні калькулятори не здатні врахувати реальні технічні параметри (чи потрібне моделювання по фото, який масштаб і яка потрібна міцність). Тому ми прораховуємо фіксовану ціну індивідуально за 4 параметрами:</span>
                        <span x-show="lang === 'en'">We manufacture custom 3D printed prototypes and functional components based on each client's specific requirements. Generic automated calculators cannot evaluate CAD modeling needs, infill load resistance, or part scale. We calculate a transparent, fixed price based on 4 parameters:</span>
                    </p>

                    <!-- 4 Pricing Factors Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 mt-6 font-mono text-xs">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="text-sky-600">01.</span>
                                <span x-show="lang === 'ua'">Вхідні дані (Фото чи 3D-файл):</span>
                                <span x-show="lang === 'en'">Input Data (Photo vs 3D CAD):</span>
                            </div>
                            <div class="text-slate-600 mt-1 font-sans text-xs">
                                <span x-show="lang === 'ua'">Друк з вашого готового файлу або створення 3D-моделі по фото/зразку.</span>
                                <span x-show="lang === 'en'">Direct print from your STL/STEP or 3D modeling from your reference photo.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="text-sky-600">02.</span>
                                <span x-show="lang === 'ua'">Матеріал (PLA або PETG):</span>
                                <span x-show="lang === 'en'">Plastic Type (PLA or PETG):</span>
                            </div>
                            <div class="text-slate-600 mt-1 font-sans text-xs">
                                <span x-show="lang === 'ua'">PLA для високої деталізації макета чи PETG для міцності та навантажень.</span>
                                <span x-show="lang === 'en'">Smooth aesthetic PLA for models or tough PETG for mechanical parts.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="text-sky-600">03.</span>
                                <span x-show="lang === 'ua'">Масштаб та щільність:</span>
                                <span x-show="lang === 'en'">Scale &amp; Infill Density:</span>
                            </div>
                            <div class="text-slate-600 mt-1 font-sans text-xs">
                                <span x-show="lang === 'ua'">Зменшений демонстраційний макет чи функціональний зразок 1:1.</span>
                                <span x-show="lang === 'en'">Scaled display prototype or full 1:1 mechanical test component.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                            <div class="font-bold text-slate-900 flex items-center gap-2">
                                <span class="text-sky-600">04.</span>
                                <span x-show="lang === 'ua'">Тираж деталей:</span>
                                <span x-show="lang === 'en'">Batch Quantity:</span>
                            </div>
                            <div class="text-slate-600 mt-1 font-sans text-xs">
                                <span x-show="lang === 'ua'">Одиничний тестовий прототип для примірки або серія зі знижкою.</span>
                                <span x-show="lang === 'en'">Single test prototype for fitment or volume production batch.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 5: 3D PRINTING & COLLABORATION WORKFLOW (4 STEPS)    -->
    <!-- DIRECT COMMUNICATION WITH CLIENT // PARTS 3D PRINTING FOCUS  -->
    <!-- ============================================================ -->
    <section id="engineering" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- TECHNICAL DIMENSION SEPARATOR -->
            <div class="cad-dimension-line mb-10 text-xs font-mono font-bold">
                <span x-show="lang === 'ua'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ПРОЦЕС ЗАМОВЛЕННЯ // 3D-ДРУК ДЕТАЛЕЙ ТА СПІВПРАЦЯ &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
                <span x-show="lang === 'en'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ORDER WORKFLOW // 3D PRINTING &amp; CLIENT COLLABORATION &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
            </div>

            <!-- SECTION HEADER -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16" data-aos="fade-up" data-aos-duration="600">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-md bg-sky-100 border border-sky-400 text-sky-900 text-xs sm:text-sm font-mono font-bold uppercase tracking-wider mb-4">
                    <span class="w-2 h-2 rounded-full bg-sky-600 animate-pulse"></span>
                    <span x-show="lang === 'ua'">3D-ДРУК ДЕТАЛЕЙ // 4 ПРОСТИХ КРОКИ</span>
                    <span x-show="lang === 'en'">PARTS 3D PRINTING // 4 SIMPLE STEPS</span>
                </div>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                    <span x-show="lang === 'ua'">Як Ми Працюємо: Від Вашої Задачі До Готової Деталі</span>
                    <span x-show="lang === 'en'">How We Work: From Your Request to 3D Printed Parts</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-600 mt-3 leading-relaxed">
                    <span x-show="lang === 'ua'">Більшість наших замовлень — це якісний 3D-друк деталей. Ми ведемо прямий діалог на кожному кроці: допомагаємо з кресленнями, якщо немає моделі, підбираємо надійний пластик (PLA або PETG) та показуємо 3D-вигляд ще до друку.</span>
                    <span x-show="lang === 'en'">Most of our work is dedicated to precision 3D printing of parts. We stay in direct touch at every step: we help create drawings if you don't have a file, pick the right plastic (PLA or PETG), and confirm the 3D model with you before printing.</span>
                </p>
            </div>

            <!-- 4-STEP CONNECTED PIPELINE RIBBON (DESKTOP PROGRESSION) -->
            <div class="hidden lg:grid grid-cols-4 gap-4 mb-8 text-xs font-mono font-bold" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 shadow-sm">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white flex items-center justify-center font-black text-xs shrink-0">01</span>
                    <div class="truncate">
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'ua'">Задача &amp; Діалог</div>
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'en'">Request &amp; Dialogue</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'ua'">Фото або ескіз деталі</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'en'">Photo or part sketch</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 shadow-sm">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white flex items-center justify-center font-black text-xs shrink-0">02</span>
                    <div class="truncate">
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'ua'">Креслення &amp; 3D-Модель</div>
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'en'">Drawings &amp; 3D Model</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'ua'">Показ перед друком</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'en'">3D preview approval</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-800 shadow-sm">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white flex items-center justify-center font-black text-xs shrink-0">03</span>
                    <div class="truncate">
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'ua'">Пластик PLA / PETG</div>
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'en'">PLA / PETG Plastic</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'ua'">Масштаб, міцність, ціна</div>
                        <div class="text-[11px] text-slate-500 font-normal truncate" x-show="lang === 'en'">Scale, infill &amp; budget</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3.5 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-950 shadow-sm">
                    <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-black text-xs shrink-0">04</span>
                    <div class="truncate">
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'ua'">3D-Друк &amp; Готова Деталь</div>
                        <div class="uppercase tracking-wider font-bold truncate" x-show="lang === 'en'">Printing &amp; Ready Part</div>
                        <div class="text-[11px] text-emerald-700 font-normal truncate" x-show="lang === 'ua'">Від 1 шт до серії</div>
                        <div class="text-[11px] text-emerald-700 font-normal truncate" x-show="lang === 'en'">From 1 pc to batch</div>
                    </div>
                </div>
            </div>

            <!-- THE 4 GRAND COLLABORATION CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- CARD 01: ЗАДАЧА ТА ОБГОВОРЕННЯ -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 01</span>
                                <span x-show="lang === 'en'">STEP // 01</span>
                            </span>
                            <!-- Icon: Friendly Dialogue / Chat -->
                            <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl font-black text-slate-900 leading-snug">
                            <span x-show="lang === 'ua'">Запит та Обговорення</span>
                            <span x-show="lang === 'en'">Request &amp; Consultation</span>
                        </h3>
                        <p class="text-xs font-mono text-slate-500 mt-1">
                            <span x-show="lang === 'ua'">Початок з будь-яких матеріалів</span>
                            <span x-show="lang === 'en'">Start with a photo, sketch or file</span>
                        </p>

                        <!-- Communication Box -->
                        <div class="my-4 p-3.5 rounded-xl bg-sky-50/80 border border-sky-200 text-xs text-slate-700 leading-relaxed">
                            <div class="font-bold text-sky-900 mb-1 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                <span x-show="lang === 'ua'">Як ми спілкуємося:</span>
                                <span x-show="lang === 'en'">How we communicate:</span>
                            </div>
                            <p x-show="lang === 'ua'">Ви надсилаєте фото деталі, ескіз на папері або зразок зламаної частини. Ми швидко відповідаємо, ставимо прості уточнюючі запитання та з'ясовуємо, як деталь буде працювати.</p>
                            <p x-show="lang === 'en'">You share a photo, broken sample, sketch, or 3D file. We answer quickly, ask clear questions, and clarify where and how the part will operate.</p>
                        </div>

                        <!-- Action Points -->
                        <div class="space-y-2 text-xs text-slate-600 font-sans">
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">01.</span>
                                <span x-show="lang === 'ua'">Прийом замовлення з фото поруч із лінійкою або зразком.</span>
                                <span x-show="lang === 'en'">Accepting requests from photos with ruler or sample part.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">02.</span>
                                <span x-show="lang === 'ua'">Оцінка умов роботи (тертя, навантаження, температура).</span>
                                <span x-show="lang === 'en'">Evaluating working conditions (friction, loads, outdoors).</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">03.</span>
                                <span x-show="lang === 'ua'">Швидкий попередній прорахунок вартості друку.</span>
                                <span x-show="lang === 'en'">Quick initial price estimation for 3D printing.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deliverable / Result Badge -->
                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'ua'">Результат для вас:</div>
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'en'">Stage Deliverable:</div>
                        <div class="font-bold text-slate-900 text-xs mt-0.5 flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">&check;</span>
                            <span x-show="lang === 'ua'">Чітка вартість та строки виконання</span>
                            <span x-show="lang === 'en'">Transparent price &amp; verified timeline</span>
                        </div>
                        <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] font-bold">
                            <span x-show="lang === 'ua'">💬 Оцінка за 15 хвилин</span>
                            <span x-show="lang === 'en'">💬 Fast response within 15 min</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 02: КРЕСЛЕННЯ ТА 3D-РОЗРОБКА -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 02</span>
                                <span x-show="lang === 'en'">STEP // 02</span>
                            </span>
                            <!-- Icon: 3D Drafting Wireframe -->
                            <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl font-black text-slate-900 leading-snug">
                            <span x-show="lang === 'ua'">Креслення &amp; 3D-Модель</span>
                            <span x-show="lang === 'en'">Drawings &amp; 3D Model</span>
                        </h3>
                        <p class="text-xs font-mono text-slate-500 mt-1">
                            <span x-show="lang === 'ua'">Підготовка деталі до друку</span>
                            <span x-show="lang === 'en'">Preparing part geometry for print</span>
                        </p>

                        <!-- Communication Box -->
                        <div class="my-4 p-3.5 rounded-xl bg-sky-50/80 border border-sky-200 text-xs text-slate-700 leading-relaxed">
                            <div class="font-bold text-sky-900 mb-1 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                <span x-show="lang === 'ua'">Як ми спілкуємося:</span>
                                <span x-show="lang === 'en'">How we communicate:</span>
                            </div>
                            <p x-show="lang === 'ua'">Показуємо вам 3D-модель деталі на екрані перед друком. Ви наочно бачите форму з усіх боків, оцінюєте вигляд і вносите будь-які корективи до запуску принтера.</p>
                            <p x-show="lang === 'en'">We show you the 3D model on screen prior to printing. You inspect the shape from all angles and approve or adjust dimensions before printing starts.</p>
                        </div>

                        <!-- Action Points -->
                        <div class="space-y-2 text-xs text-slate-600 font-sans">
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">01.</span>
                                <span x-show="lang === 'ua'">Зняття точних розмірів штангенциркулем зі зразка.</span>
                                <span x-show="lang === 'en'">Precise caliper measurements taken directly from sample.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">02.</span>
                                <span x-show="lang === 'ua'">Побудова точної 3D-моделі деталі або оптимізація вашого файлу.</span>
                                <span x-show="lang === 'en'">Creating clean 3D CAD geometry or optimizing your file.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-sky-600 font-bold font-mono">03.</span>
                                <span x-show="lang === 'ua'">Посилення вразливих місць та ребер жорсткості.</span>
                                <span x-show="lang === 'en'">Reinforcing stress points, bosses, and strengthening ribs.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deliverable / Result Badge -->
                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'ua'">Результат для вас:</div>
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'en'">Stage Deliverable:</div>
                        <div class="font-bold text-slate-900 text-xs mt-0.5 flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">&check;</span>
                            <span x-show="lang === 'ua'">Погоджена вами 3D-модель для друку</span>
                            <span x-show="lang === 'en'">Approved 3D model ready for printing</span>
                        </div>
                        <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] font-bold">
                            <span x-show="lang === 'ua'">📐 Показ 3D перед друком</span>
                            <span x-show="lang === 'en'">📐 Visual 3D approval</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 03: МАСШТАБ ТА ПЛАСТИК PLA / PETG -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 03</span>
                                <span x-show="lang === 'en'">STEP // 03</span>
                            </span>
                            <!-- Icon: Spool / Filament -->
                            <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl font-black text-slate-900 leading-snug">
                            <span x-show="lang === 'ua'">Масштаб та Пластик</span>
                            <span x-show="lang === 'en'">Scale &amp; PLA / PETG</span>
                        </h3>
                        <p class="text-xs font-mono text-slate-500 mt-1">
                            <span x-show="lang === 'ua'">Підбір матеріалу під умови деталі</span>
                            <span x-show="lang === 'en'">Right plastic for operating conditions</span>
                        </p>

                        <!-- Communication Box -->
                        <div class="my-4 p-3.5 rounded-xl bg-sky-50/80 border border-sky-200 text-xs text-slate-700 leading-relaxed">
                            <div class="font-bold text-sky-900 mb-1 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                <span x-show="lang === 'ua'">Як ми спілкуємося:</span>
                                <span x-show="lang === 'en'">How we communicate:</span>
                            </div>
                            <p x-show="lang === 'ua'">Разом визначаємо потрібну кількість деталей (від 1 шт до партії). Ми чесно радимо правильний пластик, щоб деталь витримувала потрібні навантаження і ви не переплачували.</p>
                            <p x-show="lang === 'en'">We define quantity together (1 piece to a batch). We recommend the right plastic so your part reliably holds the loads without unnecessary expenses.</p>
                        </div>

                        <!-- Action Points (PLA vs PETG Focus) -->
                        <div class="space-y-2 text-xs text-slate-600 font-sans">
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                                <span class="font-bold text-slate-900 font-mono text-[13px]">PLA</span> — 
                                <span x-show="lang === 'ua'">ідеальний для корпусів, декоративних виробів, макетів, коробок та примірки. Ідеальна гладкість та точність.</span>
                                <span x-show="lang === 'en'">great for enclosures, mockups, visual models, and fit prototypes. Smooth finish and sharp detail.</span>
                            </div>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200">
                                <span class="font-bold text-slate-900 font-mono text-[13px]">PETG</span> — 
                                <span x-show="lang === 'ua'">міцний пластик для силових деталей, кронштейнів, шестерень, деталей авто та вулиці. Стійкий до ударів і тепла.</span>
                                <span x-show="lang === 'en'">high-strength plastic for functional parts, brackets, gears, and outdoor use. Impact and heat resistant.</span>
                            </div>
                            <div class="flex items-start gap-2 pt-0.5">
                                <span class="text-sky-600 font-bold font-mono">03.</span>
                                <span x-show="lang === 'ua'">Підбір щільності заповнення для міцності та економії.</span>
                                <span x-show="lang === 'en'">Tuning infill density for strength and cost efficiency.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deliverable / Result Badge -->
                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'ua'">Результат для вас:</div>
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'en'">Stage Deliverable:</div>
                        <div class="font-bold text-slate-900 text-xs mt-0.5 flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">&check;</span>
                            <span x-show="lang === 'ua'">Правильний пластик і фіксований бюджет</span>
                            <span x-show="lang === 'en'">Right plastic &amp; fixed transparent price</span>
                        </div>
                        <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 font-mono text-[11px] font-bold">
                            <span x-show="lang === 'ua'">🧵 PLA або PETG під задачу</span>
                            <span x-show="lang === 'en'">🧵 PLA or PETG for your task</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 04: 3D-ДРУК ТА ГОТОВА ДЕТАЛЬ -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:border-emerald-600 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-emerald-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 04</span>
                                <span x-show="lang === 'en'">STEP // 04</span>
                            </span>
                            <!-- Icon: 3D Print Nozzle / Checkmark -->
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl font-black text-slate-900 leading-snug">
                            <span x-show="lang === 'ua'">3D-Друк &amp; Готова Деталь</span>
                            <span x-show="lang === 'en'">3D Printing &amp; Ready Part</span>
                        </h3>
                        <p class="text-xs font-mono text-slate-500 mt-1">
                            <span x-show="lang === 'ua'">Точний друк, очищення та доставка</span>
                            <span x-show="lang === 'en'">Precision print, cleanup &amp; delivery</span>
                        </p>

                        <!-- Communication Box -->
                        <div class="my-4 p-3.5 rounded-xl bg-emerald-50/80 border border-emerald-200 text-xs text-slate-700 leading-relaxed">
                            <div class="font-bold text-emerald-950 mb-1 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                <span x-show="lang === 'ua'">Як ми спілкуємося:</span>
                                <span x-show="lang === 'en'">How we communicate:</span>
                            </div>
                            <p x-show="lang === 'ua'">Надсилаємо фото або відео процесу друку деталі. Після завершення проводимо перевірку розмірів, повідомляємо про готовність та передаємо або відправляємо поштою.</p>
                            <p x-show="lang === 'en'">We send photo/video updates during printing. Once finished, we verify dimensions with calipers, notify you, and hand over or dispatch via courier.</p>
                        </div>

                        <!-- Action Points -->
                        <div class="space-y-2 text-xs text-slate-600 font-sans">
                            <div class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold font-mono">01.</span>
                                <span x-show="lang === 'ua'">Високоточний 3D-друк на каліброваних принтерах.</span>
                                <span x-show="lang === 'en'">High-precision 3D printing on calibrated equipment.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold font-mono">02.</span>
                                <span x-show="lang === 'ua'">Контроль відповідності розмірів штангенциркулем.</span>
                                <span x-show="lang === 'en'">Dimensional verification using digital calipers.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold font-mono">03.</span>
                                <span x-show="lang === 'ua'">Фінішне очищення та швидкий повторний друк за потреби.</span>
                                <span x-show="lang === 'en'">Clean post-processing and instant re-printing if needed.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deliverable / Result Badge -->
                    <div class="mt-6 pt-4 border-t border-slate-200">
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'ua'">Результат для вас:</div>
                        <div class="text-[11px] font-mono text-slate-500 uppercase font-bold" x-show="lang === 'en'">Stage Deliverable:</div>
                        <div class="font-bold text-slate-900 text-xs mt-0.5 flex items-center gap-1.5">
                            <span class="text-emerald-600 font-bold">&check;</span>
                            <span x-show="lang === 'ua'">Готова якісна деталь у ваших руках</span>
                            <span x-show="lang === 'en'">Finished functional part in your hands</span>
                        </div>
                        <div class="mt-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 font-mono text-[11px] font-bold">
                            <span x-show="lang === 'ua'">📦 Від 1 шт до серії</span>
                            <span x-show="lang === 'en'">📦 From 1 piece to a batch</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- COLLABORATION CTA BANNER -->
            <div class="mt-12 bg-slate-900 rounded-2xl p-6 sm:p-8 lg:p-10 border-2 border-slate-800 shadow-xl text-white flex flex-col lg:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-blueprint-grid opacity-15 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-2xl text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-sky-500/20 border border-sky-400/40 text-sky-300 font-mono text-xs font-bold uppercase tracking-wider mb-3">
                        <span class="w-2 h-2 rounded-full bg-sky-400 animate-pulse"></span>
                        <span x-show="lang === 'ua'">ПРЯМИЙ ЗВ'ЯЗОК // ОЦІНКА ДРУКУ ЗА 15 ХВИЛИН</span>
                        <span x-show="lang === 'en'">DIRECT CONTACT // 15-MIN QUOTE</span>
                    </div>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-white tracking-tight">
                        <span x-show="lang === 'ua'">Потрібно надрукувати деталь або відновити зламану?</span>
                        <span x-show="lang === 'en'">Need to 3D print a part or replace a broken one?</span>
                    </h3>
                    <p class="text-slate-300 text-sm sm:text-base mt-2 leading-relaxed font-sans">
                        <span x-show="lang === 'ua'">Надішліть нам фото або креслення. Ми швидко оцінимо вартість друку, підкажемо, який пластик обрати (PLA для макетів чи PETG для міцності) та одразу візьмемо в роботу.</span>
                        <span x-show="lang === 'en'">Send us a photo or sketch. We will quickly calculate the print cost, advise whether PLA or PETG fits best, and start printing right away.</span>
                    </p>
                </div>

                <div class="relative z-10 flex flex-wrap items-center justify-center gap-4 shrink-0">
                    <button type="button" 
                            @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D-друк деталей: Від фото/ескізу до готового зразка' : '3D Printing of Parts: From Photo to Ready Sample')" 
                            class="btn-cyan-glow text-white font-mono text-xs sm:text-sm font-bold px-6 py-3.5 rounded-xl cursor-pointer shadow-lg hover:shadow-cyan-500/30 transition-all">
                        <span x-show="lang === 'ua'">Замовити 3D-Друк Деталей &rarr;</span>
                        <span x-show="lang === 'en'">Order 3D Printing of Parts &rarr;</span>
                    </button>
                    <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" 
                       class="px-5 py-3.5 rounded-xl border border-slate-700 bg-slate-800/80 hover:bg-slate-700 text-white font-mono text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-pink-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <span>Instagram</span>
                    </a>
                    <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" 
                       class="px-5 py-3.5 rounded-xl border border-slate-700 bg-slate-800/80 hover:bg-slate-700 text-white font-mono text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 6: INTAKE ORDER FORM (WORKFLOW STAGES)               -->
    <!-- (КРЕСЛЕННЯ) — МОДЕЛЮВАННЯ — ПРОЦЕС ДРУКУ — ГОТОВА МОДЕЛЬ     -->
    <!-- ============================================================ -->
    <section id="contacts" class="py-20 lg:py-28 cad-blueprint-substrate" 
             x-data="{ 
                 sent: false, 
                 orderType: 'drawing', 
                 material: 'petg', 
                 quantity: '1',
                 customQty: '',
                 name: '',
                 contact: '',
                 email: '',
                 details: ''
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- TECHNICAL DIMENSION SEPARATOR -->
            <div class="cad-dimension-line mb-10 text-xs font-mono font-bold">
                <span x-show="lang === 'ua'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ОФОРМЛЕННЯ ЗАМОВЛЕННЯ // ВІД КРЕСЛЕННЯ ДО ГОТОВОЇ МОДЕЛІ &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
                <span x-show="lang === 'en'">&vert;&larr;&mdash;&mdash;&mdash;&mdash;&mdash; ORDER SPECIFICATION // FROM DRAWING TO FINISHED PART &mdash;&mdash;&mdash;&mdash;&mdash;&rarr;&vert;</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
                
                <!-- Left: Interactive Order Intake Form -->
                <div class="lg:col-span-7 bg-white rounded-2xl border-2 border-slate-900 p-8 sm:p-10 shadow-xl cad-corner-cross flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                            <span class="text-xs sm:text-sm font-mono text-sky-800 font-bold uppercase tracking-wider" x-show="lang === 'ua'">ФОРМА ЗАМОВЛЕННЯ 3D-ДРУКУ ТА МОДЕЛЮВАННЯ</span>
                            <span class="text-xs sm:text-sm font-mono text-sky-800 font-bold uppercase tracking-wider" x-show="lang === 'en'">3D PRINTING &amp; CAD ORDER INTAKE</span>
                        </div>
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900">
                            <span x-show="lang === 'ua'">Оформити Замовлення на Деталь</span>
                            <span x-show="lang === 'en'">Place Your 3D Print Order</span>
                        </h2>
                        <p class="text-sm text-slate-600 mt-2 mb-6 font-sans" x-show="lang === 'ua'">
                            Залиште деталі вашого замовлення. Ми зв'яжемося протягом 15–30 хвилин з точним розрахунком вартості.
                        </p>
                        <p class="text-sm text-slate-600 mt-2 mb-6 font-sans" x-show="lang === 'en'">
                            Leave the details of your order. We will contact you within 15–30 minutes with an exact price estimate.
                        </p>

                        <template x-if="!sent">
                            <form @submit.prevent="sent = true" class="space-y-5">
                                
                                <!-- 1. ТИП ЗАМОВЛЕННЯ -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                        <span x-show="lang === 'ua'">Тип Замовлення:</span>
                                        <span x-show="lang === 'en'">Order Type:</span>
                                    </label>
                                    
                                    <div class="font-mono text-xs">
                                        <div class="p-3.5 rounded-xl border-2 border-sky-600 bg-sky-50/80 text-sky-950 font-bold shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                            <div class="flex items-center gap-2.5">
                                                <span class="text-base">📐</span>
                                                <span class="font-bold text-sm">
                                                    <span x-show="lang === 'ua'">Замовлення</span>
                                                    <span x-show="lang === 'en'">Order</span>
                                                </span>
                                            </div>
                                            <div class="text-xs font-sans font-normal text-slate-600">
                                                <span x-show="lang === 'ua'">Маю ескіз, фото або зразок деталі</span>
                                                <span x-show="lang === 'en'">Have a sketch, photo, or sample</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- КОНТАКТНІ ДАНІ: ІМ'Я ТА EMAIL -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                            <span x-show="lang === 'ua'">Ваше Ім'я:</span>
                                            <span x-show="lang === 'en'">Your Name:</span>
                                        </label>
                                        <input type="text" required x-model="name" :placeholder="lang === 'ua' ? 'Олександр' : 'Alexander'" class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 text-sm text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans" />
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                            <span x-show="lang === 'ua'">Email (для розрахунку або файлів):</span>
                                            <span x-show="lang === 'en'">Email Address (for quote or files):</span>
                                        </label>
                                        <input type="email" required x-model="email" :placeholder="lang === 'ua' ? 'alex@example.com' : 'alex@example.com'" class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 text-sm text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans" />
                                    </div>
                                </div>

                                <!-- ЗАВАНТАЖЕННЯ ФАЙЛІВ (СМУЖКА З ВИПАДАЮЧИМ СПИСКОМ) -->
                                <div x-data="{ openUpload: false, selectedFiles: [] }">
                                    <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                        <span x-show="lang === 'ua'">Завантажити файли або креслення:</span>
                                        <span x-show="lang === 'en'">Upload CAD Files or Drawings:</span>
                                    </label>

                                    <!-- Смужка у вигляді випадаючого списку -->
                                    <div @click="openUpload = !openUpload" 
                                         class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 bg-slate-50/70 hover:bg-slate-100/90 text-sm cursor-pointer transition-all flex items-center justify-between select-none">
                                        <div class="flex items-center gap-2.5 text-slate-700 truncate">
                                            <span class="text-base text-sky-600">📎</span>
                                            <template x-if="selectedFiles.length === 0">
                                                <span class="text-slate-500 font-sans text-xs sm:text-sm">
                                                    <span x-show="lang === 'ua'">Прикріпити файли (STL, STEP, PDF, фото або креслення)</span>
                                                    <span x-show="lang === 'en'">Attach files (STL, STEP, PDF, photos or drawings)</span>
                                                </span>
                                            </template>
                                            <template x-if="selectedFiles.length > 0">
                                                <span class="font-bold text-sky-900 font-sans text-xs sm:text-sm">
                                                    <span x-show="lang === 'ua'">Обрано файлів: <span x-text="selectedFiles.length"></span></span>
                                                    <span x-show="lang === 'en'">Files attached: <span x-text="selectedFiles.length"></span></span>
                                                </span>
                                            </template>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-mono font-semibold text-slate-500 hidden sm:inline" x-show="selectedFiles.length === 0">до 100 МБ</span>
                                            <svg class="w-4 h-4 text-slate-600 transition-transform duration-200" :class="openUpload ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Випадаючий блок завантаження -->
                                    <div x-show="openUpload" class="mt-2.5" style="display: none;">
                                        <div class="rounded-xl border-2 border-dashed border-sky-400 bg-sky-50/50 p-4 text-center hover:bg-sky-50/80 transition-colors">
                                            <input type="file" multiple 
                                                   @change="selectedFiles = Array.from($event.target.files)"
                                                   id="file-upload-input"
                                                   class="hidden" />
                                            <label for="file-upload-input" class="cursor-pointer block">
                                                <div class="text-sky-700 font-bold text-xs sm:text-sm font-sans flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                    </svg>
                                                    <span x-show="lang === 'ua'">Натисніть для вибору файлів або перетягніть сюди</span>
                                                    <span x-show="lang === 'en'">Click to select files or drag and drop here</span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 mt-1 font-sans">
                                                    <span x-show="lang === 'ua'">Формати: STL, STEP, STP, IGES, OBJ, DXF, DWG, PDF, JPG, PNG (до 100 МБ)</span>
                                                    <span x-show="lang === 'en'">Formats: STL, STEP, STP, IGES, OBJ, DXF, DWG, PDF, JPG, PNG (up to 100MB)</span>
                                                </p>
                                            </label>

                                            <!-- Список обраних файлів -->
                                            <template x-if="selectedFiles.length > 0">
                                                <div class="mt-3 pt-3 border-t border-sky-200/80 text-left space-y-1.5 max-h-36 overflow-y-auto">
                                                    <template x-for="(file, index) in selectedFiles" :key="index">
                                                        <div class="flex items-center justify-between text-xs bg-white/80 px-2.5 py-1.5 rounded-lg border border-sky-200 text-slate-800 font-mono">
                                                            <span class="truncate flex-1 pr-2" x-text="file.name"></span>
                                                            <span class="text-[10px] text-slate-500 shrink-0" x-text="(file.size / 1024 / 1024).toFixed(2) + ' MB'"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- ОПИС ТА ПОСИЛАННЯ НА ФАЙЛИ / ФОТО -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                        <span x-show="lang === 'ua'">Опис Завдання або Посилання на Фото / Креслення:</span>
                                        <span x-show="lang === 'en'">Project Details &amp; Links to Photos / CAD Files:</span>
                                    </label>
                                    <textarea rows="4" x-model="details" :placeholder="lang === 'ua' ? 'Опишіть призначення деталі, орієнтовні розміри або вставте посилання на фото чи 3D-файл (Google Drive, Instagram, Facebook, хмара)...' : 'Describe the part purpose, rough dimensions, or paste a link to photos/CAD files (Google Drive, Instagram, Facebook, cloud storage)...'" class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 text-sm text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans"></textarea>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full btn-cyan-glow text-white font-bold py-4 rounded-xl cursor-pointer text-base sm:text-lg shadow-lg hover:shadow-cyan-500/30 transition-all">
                                        <span x-show="lang === 'ua'">Надіслати Замовлення на Розрахунок &rarr;</span>
                                        <span x-show="lang === 'en'">Submit Order for Estimation &rarr;</span>
                                    </button>
                                    <div class="text-center text-slate-500 text-xs font-mono mt-2.5">
                                        <span x-show="lang === 'ua'">⚡ Відповідаємо протягом 15–30 хвилин. Конфіденційність гарантовано.</span>
                                        <span x-show="lang === 'en'">⚡ We reply within 15–30 minutes. Complete confidentiality guaranteed.</span>
                                    </div>
                                </div>
                            </form>
                        </template>

                        <template x-if="sent">
                            <div class="text-center py-12 font-mono">
                                <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h3 class="font-heading text-xl font-bold text-slate-900">
                                    <span x-show="lang === 'ua'">ЗАМОВЛЕННЯ УСПІШНО ПРИЙНЯТО В РОБОТУ</span>
                                    <span x-show="lang === 'en'">ORDER RECEIVED SUCCESSFULLY</span>
                                </h3>
                                <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto font-sans">
                                    <span x-show="lang === 'ua'">Майстер зв'яжеться з вами найближчим часом (протягом 15–30 хвилин) для погодження вартості, матеріалу та термінів друку.</span>
                                    <span x-show="lang === 'en'">Our engineer will contact you shortly (within 15–30 minutes) to confirm the price, material, and printing schedule.</span>
                                </p>
                                <button type="button" @click="sent = false" class="mt-6 text-sm text-sky-700 font-bold hover:underline">
                                    <span x-show="lang === 'ua'">Надіслати ще одну деталь</span>
                                    <span x-show="lang === 'en'">Send another part</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right: Workshop Direct Channels & Practical FAQ -->
                <div class="lg:col-span-5 flex flex-col justify-between gap-6">
                    
                    <!-- Direct Channels Card -->
                    <div class="bg-white rounded-2xl border-2 border-slate-900 p-6 sm:p-7 shadow-xl font-mono text-xs sm:text-sm cad-corner-cross" data-aos="fade-up" data-aos-delay="200">
                        <h3 class="font-heading text-base font-black text-slate-900 mb-5 pb-3 border-b-2 border-slate-900 uppercase">
                            <span x-show="lang === 'ua'">ПРЯМИЙ ЗВ'ЯЗОК З МАЙСТРОМ</span>
                            <span x-show="lang === 'en'">DIRECT CONTACT WITH ENGINEER</span>
                        </h3>
                        <div class="space-y-4 text-slate-800">
                            <!-- 1. INSTAGRAM -->
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-pink-100 text-pink-700 font-black flex items-center justify-center shrink-0 text-sm">IG</div>
                                <div>
                                    <div class="font-bold text-slate-500 text-[11px] uppercase">
                                        <span x-show="lang === 'ua'">INSTAGRAM (ФОТО ДЕТАЛЕЙ ТА DIRECT)</span>
                                        <span x-show="lang === 'en'">INSTAGRAM (PHOTOS &amp; DIRECT)</span>
                                    </div>
                                    <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" class="text-pink-600 font-bold hover:underline text-sm">@modexdesign</a>
                                </div>
                            </div>
                            <!-- 2. FACEBOOK -->
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-700 font-black flex items-center justify-center shrink-0 text-sm">FB</div>
                                <div>
                                    <div class="font-bold text-slate-500 text-[11px] uppercase">
                                        <span x-show="lang === 'ua'">FACEBOOK (ПОВІДОМЛЕННЯ ТА КОНСУЛЬТАЦІЯ)</span>
                                        <span x-show="lang === 'en'">FACEBOOK (MESSAGES &amp; CHAT)</span>
                                    </div>
                                    <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" class="text-blue-600 font-bold hover:underline text-sm">facebook.com/modexdesign</a>
                                </div>
                            </div>
                            <!-- 3. EMAIL / ПОШТА -->
                            <div class="flex items-start gap-3.5">
                                <div class="w-9 h-9 rounded-lg bg-sky-100 text-sky-900 font-black flex items-center justify-center shrink-0 text-sm">@</div>
                                <div>
                                    <div class="font-bold text-slate-500 text-[11px] uppercase">
                                        <span x-show="lang === 'ua'">ПОШТА ДЛЯ КРЕСЛЕНЬ ТА МОДЕЛЕЙ</span>
                                        <span x-show="lang === 'en'">EMAIL FOR DRAWINGS &amp; CAD</span>
                                    </div>
                                    <a href="mailto:orders@modexdesign.com" class="text-sky-700 font-bold hover:underline text-sm">orders@modexdesign.com</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Practical FAQ Card -->
                    <div class="bg-white rounded-2xl border-2 border-slate-900 p-6 sm:p-7 shadow-xl font-mono text-xs sm:text-sm cad-corner-cross flex-1 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                        <div>
                            <h3 class="font-heading text-base font-black text-slate-900 mb-4 pb-3 border-b-2 border-slate-900 uppercase">
                                <span x-show="lang === 'ua'">ЧАСТІ ЗАПИТАННЯ ПО ЗАМОВЛЕННЮ</span>
                                <span x-show="lang === 'en'">ORDERING FAQ</span>
                            </h3>
                            <div class="space-y-3.5">
                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        <span x-show="lang === 'ua'">Як передати креслення чи фото деталі?</span>
                                        <span x-show="lang === 'en'">How to send photos or drawings?</span>
                                    </h4>
                                    <p class="text-slate-600 text-xs mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">Надішліть посилання у формі, напишіть в Instagram @modexdesign, Facebook або на пошту.</span>
                                        <span x-show="lang === 'en'">Paste a link in the form, message us on Instagram @modexdesign, Facebook, or email us.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        <span x-show="lang === 'ua'">Якщо немає 3D-моделі, тільки зламана деталь?</span>
                                        <span x-show="lang === 'en'">What if there is no 3D file, only a broken sample?</span>
                                    </h4>
                                    <p class="text-slate-600 text-xs mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">Достатньо сфотографувати деталь поруч із лінійкою. Ми знімемо всі розміри та створимо точну 3D-модель.</span>
                                        <span x-show="lang === 'en'">Take a photo of the part with a ruler next to it. We will engineer the 3D model accurately.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        <span x-show="lang === 'ua'">Який пластик обрати: PLA чи PETG?</span>
                                        <span x-show="lang === 'en'">Which plastic to choose: PLA or PETG?</span>
                                    </h4>
                                    <p class="text-slate-600 text-xs mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'"><strong>PLA</strong> підходить для макетів та естетики. <strong>PETG</strong> — для міцних шестерень, кронштейнів та деталей авто.</span>
                                        <span x-show="lang === 'en'"><strong>PLA</strong> for visual mockups. <strong>PETG</strong> for high-strength brackets, gears, and outdoor parts.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        <span x-show="lang === 'ua'">Скільки часу займає виготовлення?</span>
                                        <span x-show="lang === 'en'">How long does printing take?</span>
                                    </h4>
                                    <p class="text-slate-600 text-xs mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">Зазвичай тестовий прототип друкується протягом 24–48 годин. Можливий терміновий друк день-у-день.</span>
                                        <span x-show="lang === 'en'">Typically 24–48 hours for prototype parts. Express same-day service is available on request.</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


</x-layouts.public>