<x-layouts.public title="Modex | Full-Stack 3D Printing & Technical Hardware Engineering" description="Single-page technical engineering platform: Parametric CAD, high-voltage substations, precision 3D printing in PLA & PETG, FEA simulation, and turnkey electromechanical assembly.">
    
    <!-- ============================================================ -->
    <!-- SECTION 1: FULL-SCREEN HERO WITH ZAS.JPG & CAD DRAWING FRAME -->
    <!-- ============================================================ -->
    <section id="hero" class="relative min-h-[650px] lg:min-h-[calc(100vh-5.5rem)] py-10 sm:py-14 lg:py-16 flex flex-col justify-center overflow-hidden bg-[#e5e9ee]">
        
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

        <!-- UPPER HERO: HEADLINE, SUBTITLE, BUTTONS, SPECS (BIG TEXT & BIG BLOCKS) -->
        <div class="relative z-10 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 grow flex items-center">
            <div class="max-w-3xl lg:max-w-2xl xl:max-w-3xl">

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
                            class="btn-cyan-glow text-white text-base sm:text-lg font-bold px-8 sm:px-10 py-4 rounded-xl cursor-pointer w-full sm:w-auto text-center">
                        <span x-show="lang === 'ua'">Почати Проект</span>
                        <span x-show="lang === 'en'">Start a Project</span>
                    </button>
                    
                    <a href="#projects" 
                       class="inline-flex items-center justify-center px-8 sm:px-9 py-4 rounded-xl text-base sm:text-lg font-bold text-slate-900 bg-white hover:bg-slate-50 border-2 border-slate-900 shadow-sm hover:border-sky-500 hover:text-sky-600 hover:shadow-[0_0_20px_rgba(14,165,233,0.25)] transition-all duration-300 w-full sm:w-auto">
                        <span x-show="lang === 'ua'">Переглянути Проекти &darr;</span>
                        <span x-show="lang === 'en'">View Projects &darr;</span>
                    </a>
                </div>

                <!-- TECHNICAL HIGHLIGHT SPECS (OPTION 2: ±0.05 mm | 24 hrs | 100% CAD) -->
                <div class="mt-10 sm:mt-12 pt-6 sm:pt-8 border-t-2 border-slate-300/80 grid grid-cols-3 gap-4 sm:gap-8 max-w-xl font-mono" data-aos="fade-up" data-aos-duration="700" data-aos-delay="400">
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-baseline gap-1">
                            <span>&plusmn;0.05</span>
                            <span class="text-sky-500 font-bold text-base sm:text-lg lg:text-xl">mm</span>
                        </div>
                        <div class="text-[11px] sm:text-xs font-mono font-bold tracking-wider text-slate-600 uppercase mt-1.5">
                            <span x-show="lang === 'ua'">ТОЧНІСТЬ ДРУКУ</span>
                            <span x-show="lang === 'en'">PRECISION ACCURACY</span>
                        </div>
                    </div>
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-baseline gap-1">
                            <span>24</span>
                            <span class="text-sky-500 font-bold text-base sm:text-lg lg:text-xl">hrs</span>
                        </div>
                        <div class="text-[11px] sm:text-xs font-mono font-bold tracking-wider text-slate-600 uppercase mt-1.5">
                            <span x-show="lang === 'ua'">ШВИДКИЙ ДРУК</span>
                            <span x-show="lang === 'en'">RAPID TURNAROUND</span>
                        </div>
                    </div>
                    <div>
                        <div class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-baseline gap-1">
                            <span>100%</span>
                            <span class="text-sky-500 font-bold text-base sm:text-lg lg:text-xl">CAD</span>
                        </div>
                        <div class="text-[11px] sm:text-xs font-mono font-bold tracking-wider text-slate-600 uppercase mt-1.5">
                            <span x-show="lang === 'ua'">ПАРАМЕТРИЧНИЙ ДИЗАЙН</span>
                            <span x-show="lang === 'en'">PARAMETRIC DESIGN</span>
                        </div>
                    </div>
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
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12" data-aos="fade-up" data-aos-duration="600">
                <div>
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
                        <span x-show="lang === 'ua'">ВСІ ПРОЕКТИ</span>
                        <span x-show="lang === 'en'">ALL PROJECTS</span>
                    </button>
                    <button type="button" 
                            @click="currentFilter = 'architecture'" 
                            :class="currentFilter === 'architecture' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                            class="px-4 py-2.5 rounded-xl border border-slate-400 transition-all cursor-pointer">
                        <span x-show="lang === 'ua'">АРХІТЕКТУРА</span>
                        <span x-show="lang === 'en'">ARCHITECTURE</span>
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
                        <span x-show="lang === 'ua'">МЕХАТРОНІКА</span>
                        <span x-show="lang === 'en'">MECHATRONICS</span>
                    </button>
                </div>
            </div>

            <!-- PROJECTS GRID: BIGGER CARDS WITH LARGE VIEWPORTS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- PROJECT 1: 10kV Substation Insulator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'industrial'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
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
                    </div>

                    <div class="p-5 sm:p-6 bg-slate-50">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Модульна Підстанція 10кВ' : '10kV Substation Insulator Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold font-mono transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- PROJECT 2: Autonomous Tracked Rover with Robotic Manipulator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'robotics'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
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
                    </div>

                    <div class="p-5 sm:p-6 bg-slate-50">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Гусенична Робоплатформа з Маніпулятором' : 'Tracked Rover with Manipulator Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold font-mono transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- PROJECT 3: Full-Cycle Biomimetic Walking Robot (Draft to Assembly) -->
                <div x-show="currentFilter === 'all' || currentFilter === 'mechatronics' || currentFilter === 'iot'"
                     class="card-tech-glow cad-corner-cross rounded-2xl bg-white border-2 border-slate-900 overflow-hidden flex flex-col justify-between group shadow-lg">
                    <div class="p-6 sm:p-7 border-b border-slate-200">
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
                    </div>

                    <div class="p-5 sm:p-6 bg-slate-50">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Проект: Крокуючий Робот Повного Циклу' : 'Full-Cycle Walking Robot Project')"
                                class="w-full py-3 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 hover:text-white text-slate-900 text-sm font-bold font-mono transition-all cursor-pointer shadow-xs">
                            <span x-show="lang === 'ua'">Замовити CAD Специфікацію &rarr;</span>
                            <span x-show="lang === 'en'">Request CAD Specification &rarr;</span>
                        </button>
                    </div>
                </div>

            </div>

            <!-- SPECIAL SHOWCASE: CORPORATE & CLIENT GIFTS // 3D SCALE MODELS -->
            <div x-show="currentFilter === 'all' || currentFilter === 'architecture'"
                 x-data="{ 
                     activeImg: '{{ asset('images/house/008.jpg') }}',
                     activeIdx: 0,
                     lightboxOpen: false,
                     giftTab: 'who',
                     gallery: [
                         '{{ asset('images/house/008.jpg') }}',
                         '{{ asset('images/house/001.jpg') }}',
                         '{{ asset('images/house/003.jpg') }}',
                         '{{ asset('images/house/007.jpg') }}',
                         '{{ asset('images/house/002.png') }}',
                         '{{ asset('images/house/006.png') }}'
                     ],
                     nextImg() {
                         this.activeIdx = (this.activeIdx + 1) % this.gallery.length;
                         this.activeImg = this.gallery[this.activeIdx];
                     },
                     prevImg() {
                         this.activeIdx = (this.activeIdx - 1 + this.gallery.length) % this.gallery.length;
                         this.activeImg = this.gallery[this.activeIdx];
                     }
                 }"
                 class="mt-12 bg-white rounded-2xl border-2 border-slate-900 shadow-xl overflow-hidden cad-corner-cross" 
                 data-aos="fade-up" data-aos-duration="700">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
                    
                    <!-- Left (7 cols): Interactive Expanded Architectural Gallery with Hero View & Thumbnails -->
                    <div class="lg:col-span-7 bg-slate-950 p-4 sm:p-6 lg:p-7 flex flex-col border-b lg:border-b-0 lg:border-r border-slate-900">
                        <!-- Main Hero Photo Container with Full Bleed Square Coverage -->
                        <div class="relative w-full flex-1 min-h-[380px] sm:min-h-[460px] lg:min-h-[500px] rounded-xl overflow-hidden bg-slate-900 border border-slate-800 flex items-center justify-center group cursor-pointer"
                             @click="lightboxOpen = true">
                            
                            <!-- Sharp high-detail foreground image covering entire square plane (object-cover) -->
                            <img :src="activeImg" 
                                 alt="Corporate & Client Gifts by Modex" 
                                 class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105" />
                            
                            <!-- Prev / Next arrows directly on the photo for effortless browsing -->
                            <button type="button" 
                                    @click.stop="prevImg()" 
                                    aria-label="Previous image"
                                    class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-900/80 hover:bg-sky-500 text-white flex items-center justify-center transition-all duration-200 backdrop-blur-sm border border-slate-700/80 shadow-lg opacity-80 sm:opacity-0 group-hover:opacity-100 hover:scale-105 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button type="button" 
                                    @click.stop="nextImg()" 
                                    aria-label="Next image"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-slate-900/80 hover:bg-sky-500 text-white flex items-center justify-center transition-all duration-200 backdrop-blur-sm border border-slate-700/80 shadow-lg opacity-80 sm:opacity-0 group-hover:opacity-100 hover:scale-105 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- Top Counter Pill -->
                            <div class="absolute top-3 left-3 z-20 bg-slate-900/85 backdrop-blur-md px-3 py-1 rounded-lg border border-slate-700/80 text-white font-mono text-xs flex items-center gap-1.5 shadow-md">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span class="font-bold" x-text="activeIdx + 1"></span>
                                <span class="text-slate-400">/</span>
                                <span class="text-slate-400" x-text="gallery.length"></span>
                            </div>

                            <!-- Top Enlarge Pill -->
                            <div class="absolute top-3 right-3 z-20 bg-slate-900/85 hover:bg-sky-500 backdrop-blur-md px-3 py-1.5 rounded-lg border border-slate-700/80 text-white font-mono text-xs flex items-center gap-1.5 transition-colors shadow-md opacity-90 sm:opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                </svg>
                                <span class="hidden sm:inline" x-show="lang === 'ua'">На весь екран</span>
                                <span class="hidden sm:inline" x-show="lang === 'en'">Fullscreen</span>
                            </div>
                        </div>

                        <!-- Thumbnails Row (larger, comfortable, responsive) -->
                        <div class="grid grid-cols-6 gap-2 sm:gap-2.5 mt-4 shrink-0">
                            <template x-for="(imgSrc, idx) in gallery" :key="idx">
                                <button type="button" 
                                        @click="activeImg = imgSrc; activeIdx = idx"
                                        :class="activeIdx === idx ? 'border-sky-400 ring-2 ring-sky-400/80 scale-102 opacity-100 shadow-md shadow-sky-500/30' : 'border-slate-800 opacity-60 hover:opacity-100'"
                                        class="h-16 sm:h-20 rounded-xl overflow-hidden border-2 bg-slate-900 transition-all cursor-pointer relative group">
                                    <img :src="imgSrc" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Right (5 cols): Description, Interactive Tabs & Call to Action -->
                    <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between bg-white font-sans">
                        <div>
                            <h3 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                                <span x-show="lang === 'ua'">Корпоративні та Клієнтські Подарунки</span>
                                <span x-show="lang === 'en'">Corporate &amp; Client Gifts</span>
                            </h3>

                            <p class="text-sm font-semibold text-sky-700 mt-2 leading-snug">
                                <span x-show="lang === 'ua'">Мініатюра будинку, офісу чи будівлі, яку ваш клієнт ніколи не забуде.</span>
                                <span x-show="lang === 'en'">A miniature of the home, office or building your client will never forget.</span>
                            </p>

                            <p class="text-xs sm:text-[13px] text-slate-600 mt-2.5 leading-relaxed">
                                <span x-show="lang === 'ua'">
                                    Закриття угоди, вручення ключів чи святкування важливої дати? Індивідуальний масштабний макет перетворює реальну нерухомість на особистий пам'ятний подарунок, який роками залишається на столі чи полиці.
                                </span>
                                <span x-show="lang === 'en'">
                                    Closing a deal, handing over keys or celebrating a milestone? A custom scale model turns a real property into a personal keepsake that stays on a desk or shelf for years.
                                </span>
                            </p>

                            <!-- Interactive 3-Tab Switcher -->
                            <div class="mt-5 grid grid-cols-3 gap-1 p-1 bg-slate-100 rounded-xl font-mono text-xs">
                                <button type="button" 
                                        @click="giftTab = 'who'"
                                        :class="giftTab === 'who' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                                        class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                                    <span x-show="lang === 'ua'">Для кого</span>
                                    <span x-show="lang === 'en'">Who it's for</span>
                                </button>
                                <button type="button" 
                                        @click="giftTab = 'what'"
                                        :class="giftTab === 'what' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                                        class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                                    <span x-show="lang === 'ua'">Що входить</span>
                                    <span x-show="lang === 'en'">What you get</span>
                                </button>
                                <button type="button" 
                                        @click="giftTab = 'how'"
                                        :class="giftTab === 'how' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                                        class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                                    <span x-show="lang === 'ua'">Як замовити</span>
                                    <span x-show="lang === 'en'">How it works</span>
                                </button>
                            </div>

                            <!-- Tab 1: Who it's for -->
                            <div x-show="giftTab === 'who'" class="mt-4 space-y-2.5 font-sans text-xs sm:text-[13px] text-slate-700">
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-sky-100 text-sky-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏠</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Рієлтори та агентства:</span>
                                            <span x-show="lang === 'en'">Real estate agents and agencies:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Подаруйте покупцям мініатюру їхнього нового будинку під час закриття угоди.</span>
                                            <span x-show="lang === 'en'">Give buyers a miniature of their new home at closing.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏗️</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Девелопери та будівельники:</span>
                                            <span x-show="lang === 'en'">Developers and builders:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Макет готового будинку або апартаментів як подарунок при врученні ключів.</span>
                                            <span x-show="lang === 'en'">A model of the finished house or apartment as a handover gift.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-amber-100 text-amber-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏛️</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Банки, страхові та юрфірми:</span>
                                            <span x-show="lang === 'en'">Banks, insurers and law firms:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Незабутній знак вдячності для ключових та VIP-клієнтів.</span>
                                            <span x-show="lang === 'en'">A memorable thank-you for key clients.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-indigo-100 text-indigo-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏢</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Компанії:</span>
                                            <span x-show="lang === 'en'">Companies:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Копія штаб-квартири, філії чи флагманської будівлі для партнерів, команди та ювілеїв.</span>
                                            <span x-show="lang === 'en'">A replica of your headquarters, branch or flagship building for partners, employees and anniversaries.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2: What you get -->
                            <div x-show="giftTab === 'what'" class="mt-4 space-y-2.5 font-sans text-xs sm:text-[13px] text-slate-700" style="display: none;">
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Детальна мініатюра:</span>
                                            <span x-show="lang === 'en'">Detailed miniature:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Створена з високою точністю за фотографіями, кресленнями або реальною адресою.</span>
                                            <span x-show="lang === 'en'">A detailed miniature built from photos, drawings or an address.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Індивідуальні опції:</span>
                                            <span x-show="lang === 'en'">Custom options:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Вибір кольорів, фактури, деталей даху, фасадів та ландшафтного оточення.</span>
                                            <span x-show="lang === 'en'">Options for color, roof and façade details, and surroundings.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Пам'ятна підставка з табличкою:</span>
                                            <span x-show="lang === 'en'">Base with custom plate:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Дерев'яна чи акрилова підставка з табличкою: ім'я, пам'ятна дата або логотип компанії.</span>
                                            <span x-show="lang === 'en'">A wooden or acrylic base with a custom plate: name, date or your logo.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Подарункове пакування:</span>
                                            <span x-show="lang === 'en'">Gift-ready packaging:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Готова презентабельна коробка, захищена доставка безпосередньо вам або клієнту.</span>
                                            <span x-show="lang === 'en'">Gift-ready packaging, shipped directly to you or your client.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3: How it works -->
                            <div x-show="giftTab === 'how'" class="mt-4 space-y-2.5 font-sans text-xs sm:text-[13px] text-slate-700" style="display: none;">
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">01</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Надішліть об'єкт:</span>
                                            <span x-show="lang === 'en'">Send us the property:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Фотографії, планування поверхів, адреса чи онлайн-посилання.</span>
                                            <span x-show="lang === 'en'">Photos, floor plans, an address or a link.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">02</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Погодьте дизайн:</span>
                                            <span x-show="lang === 'en'">Confirm the design:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Ми надсилаємо цифрове 3D-прев'ю та фіксовану вартість.</span>
                                            <span x-show="lang === 'en'">We send a 3D preview and a fixed price.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">03</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Виготовлення:</span>
                                            <span x-show="lang === 'en'">We build it:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">Друк на власних 3D-принтерах та ручна фінішна доводка майстром.</span>
                                            <span x-show="lang === 'en'">Printed in-house and finished by hand.</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                                    <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">04</div>
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            <span x-show="lang === 'ua'">Доставка у подарунковій коробці:</span>
                                            <span x-show="lang === 'en'">Delivered in gift packaging:</span>
                                        </p>
                                        <p class="text-slate-600 text-xs">
                                            <span x-show="lang === 'ua'">З детальним фотозвітом готового макета перед відправкою.</span>
                                            <span x-show="lang === 'en'">With a photo of the finished model before it ships.</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button & Trust Notice -->
                        <div class="mt-6 pt-5 border-t border-slate-100">
                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Подарунковий макет: Корпоративні та клієнтські подарунки' : 'Scale Model: Corporate & Client Gifts')"
                                    class="w-full btn-cyan-glow text-white font-bold py-3.5 px-6 rounded-xl cursor-pointer text-sm font-mono transition-all flex items-center justify-center gap-2">
                                <span x-show="lang === 'ua'">Замовити Подарунковий Макет &rarr;</span>
                                <span x-show="lang === 'en'">Order a Gift Model &rarr;</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- FULLSCREEN LIGHTBOX MODAL FOR ARCHITECTURAL IMAGES -->
                <div x-show="lightboxOpen" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="lightboxOpen = false"
                     @keydown.arrow-right.window="nextImg()"
                     @keydown.arrow-left.window="prevImg()"
                     class="fixed inset-0 z-[10000] bg-black/95 backdrop-blur-md flex flex-col items-center justify-between p-4 sm:p-6"
                     style="display: none;">
                    
                    <!-- Top Bar -->
                    <div class="w-full max-w-7xl flex items-center justify-between text-white font-mono text-sm py-2">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="font-bold">
                                <span x-show="lang === 'ua'">Архітектурний огляд високої роздільності</span>
                                <span x-show="lang === 'en'">High-Resolution Architectural View</span>
                            </span>
                            <span class="text-slate-400">
                                (<span x-text="activeIdx + 1"></span> / <span x-text="gallery.length"></span>)
                            </span>
                        </div>
                        <button type="button" 
                                @click="lightboxOpen = false" 
                                class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white transition-colors cursor-pointer"
                                aria-label="Close fullscreen view">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Main Image Area with Prev/Next -->
                    <div class="relative w-full max-w-6xl flex-1 flex items-center justify-center my-2 overflow-hidden">
                        <img :src="activeImg" 
                             alt="Full size architectural view" 
                             class="max-h-[80vh] max-w-full object-contain rounded-xl shadow-2xl" />
                        
                        <!-- Nav buttons in lightbox -->
                        <button type="button" 
                                @click="prevImg()" 
                                aria-label="Previous image"
                                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-900/80 hover:bg-sky-500 text-white flex items-center justify-center border border-slate-700 transition-all cursor-pointer">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button type="button" 
                                @click="nextImg()" 
                                aria-label="Next image"
                                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-slate-900/80 hover:bg-sky-500 text-white flex items-center justify-center border border-slate-700 transition-all cursor-pointer">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Bottom Thumbnails in lightbox -->
                    <div class="w-full max-w-3xl flex items-center justify-center gap-2 sm:gap-3 py-2 overflow-x-auto">
                        <template x-for="(imgSrc, idx) in gallery" :key="idx">
                            <button type="button" 
                                    @click="activeImg = imgSrc; activeIdx = idx" 
                                    :class="activeIdx === idx ? 'border-sky-400 ring-2 ring-sky-400 scale-105' : 'border-slate-800 opacity-60 hover:opacity-100'"
                                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg overflow-hidden border-2 bg-slate-900 transition-all cursor-pointer shrink-0">
                                <img :src="imgSrc" class="w-full h-full object-cover" />
                            </button>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION 4: CLIENT PHOTOS → 3D PRINTED PROTOTYPE SHOWCASE     -->
    <!-- INTERACTIVE SPOTLIGHT SLIDER WITH LARGE IMAGES & MINIMAL TEXT-->
    <!-- ============================================================ -->
    <section id="printing" class="py-20 lg:py-28 cad-blueprint-substrate relative" 
             x-data="{
                 activeSlide: 0,
                 totalSlides: 4,
                 next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides; },
                 prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides; },
                 goTo(idx) { this.activeSlide = idx; }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- SECTION HEADER: CLEAN & SPACIOUS -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10 sm:mb-14" data-aos="fade-up" data-aos-duration="600">
                <div class="max-w-3xl">
                    <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        <span x-show="lang === 'ua'">Від Фотографії Замовника &rarr; До Готового 3D-Прототипу</span>
                        <span x-show="lang === 'en'">From Client Reference Photo &rarr; To Ready 3D Prototype</span>
                    </h2>
                    <p class="text-base sm:text-lg text-slate-600 mt-3 leading-relaxed">
                        <span x-show="lang === 'ua'">Надсилайте звичайне фото, зламаний зразок чи креслення. Ми проектуємо точну 3D-модель та друкуємо масштабний макет, кронштейни або функціональну деталь.</span>
                        <span x-show="lang === 'en'">Send us a photo, broken sample, or sketch. We engineer the exact 3D CAD model and manufacture precision scale mockups, brackets, or working components.</span>
                    </p>
                </div>

                <!-- SLIDER CONTROLS: DOTS PAGINATION & ARROWS -->
                <div class="flex items-center justify-between sm:justify-end gap-3 sm:gap-4 shrink-0">
                    <!-- Dots Pagination -->
                    <div class="flex items-center gap-2.5 bg-white px-4 py-2.5 rounded-full border-2 border-slate-900 shadow-xs">
                        <button type="button" 
                                @click="goTo(0)" 
                                aria-label="Go to case 1"
                                :class="activeSlide === 0 ? 'w-7 bg-slate-900' : 'w-2.5 bg-slate-400 hover:bg-slate-600'"
                                class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        <button type="button" 
                                @click="goTo(1)" 
                                aria-label="Go to case 2"
                                :class="activeSlide === 1 ? 'w-7 bg-slate-900' : 'w-2.5 bg-slate-400 hover:bg-slate-600'"
                                class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        <button type="button" 
                                @click="goTo(2)" 
                                aria-label="Go to case 3"
                                :class="activeSlide === 2 ? 'w-7 bg-slate-900' : 'w-2.5 bg-slate-400 hover:bg-slate-600'"
                                class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        <button type="button" 
                                @click="goTo(3)" 
                                aria-label="Go to case 4"
                                :class="activeSlide === 3 ? 'w-7 bg-slate-900' : 'w-2.5 bg-slate-400 hover:bg-slate-600'"
                                class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                    </div>

                    <!-- Arrow Navigation Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="prev()" 
                                aria-label="Previous Slide"
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 text-slate-900 hover:text-white flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button" 
                                @click="next()" 
                                aria-label="Next Slide"
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl border-2 border-slate-900 bg-white hover:bg-slate-900 text-slate-900 hover:text-white flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- INTERACTIVE SLIDER CONTAINER (EQUAL FIXED HEIGHT ACROSS ALL SLIDES) -->
            <div class="relative mb-10 min-h-[620px] sm:min-h-[660px] lg:min-h-[540px]" data-aos="fade-up" data-aos-delay="100">
                
                <!-- SLIDE 1: PORTAL STRUCTURES (g1.jpg) -->
                <div x-show="activeSlide === 0" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-[0.99]"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border-2 border-slate-900 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 h-[620px] sm:h-[660px] lg:h-[540px] w-full">
                    
                    <!-- LARGE PHOTO CONTAINER (IDENTICAL RATIO) -->
                    <div class="lg:col-span-7 relative h-64 sm:h-80 lg:h-full bg-slate-950 overflow-hidden group">
                        <img src="{{ asset('images/g1.jpg') }}" 
                             alt="Client reference photo: substation bay structure" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" />
                    </div>

                    <!-- EQUALIZED CONTENT CONTAINER -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 h-full flex flex-col justify-between overflow-hidden">
                        <div>
                            <div class="flex items-center justify-between font-mono text-xs text-sky-700 font-bold mb-2">
                                <span>
                                    <span x-show="lang === 'ua'">КЕЙС 01 // 04</span>
                                    <span x-show="lang === 'en'">CASE 01 // 04</span>
                                </span>
                                <span class="px-2.5 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200">
                                    <span x-show="lang === 'ua'">PLA (Точний макет)</span>
                                    <span x-show="lang === 'en'">PLA (Scale Model)</span>
                                </span>
                            </div>

                            <div class="h-16 lg:h-20 flex items-center">
                                <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                    <span x-show="lang === 'ua'">Портальні Ферми та Шинопровід</span>
                                    <span x-show="lang === 'en'">Portal Structures &amp; Busbars</span>
                                </h3>
                            </div>

                            <div class="h-20 sm:h-22 flex items-center">
                                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                    <span x-show="lang === 'ua'">Замовник надав фотографії ангару зі сталевими конструкціями. Ми розробили точну 3D CAD модель і виготовили масштабний макет для презентації інвесторам та перевірки просторових вузлів.</span>
                                    <span x-show="lang === 'en'">Client provided hangar photos of portal steel structures. We engineered the precise 3D CAD model and printed a scaled prototype for investor presentation and spatial fit inspection.</span>
                                </p>
                            </div>

                            <!-- Deliverable Chips -->
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Вхід: Фото ангару</span>
                                    <span x-show="lang === 'en'">✓ Input: Hangar photo</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Результат: 3D-макет</span>
                                    <span x-show="lang === 'en'">✓ Output: 3D scale model</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span x-show="lang === 'ua'">✓ Масштаб 100%</span>
                                    <span x-show="lang === 'en'">✓ Scale 100% fit</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100 mt-auto">
                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D-Макет: Портальні Ферми' : 'Portal Structures Prototyping')" 
                                    class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                                <span x-show="lang === 'ua'">Замовити Схожий Прототип &rarr;</span>
                                <span x-show="lang === 'en'">Order Similar Prototype &rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 2: DISCONNECT SWITCH (g2.jpg) -->
                <div x-show="activeSlide === 1" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-[0.99]"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border-2 border-slate-900 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 h-[620px] sm:h-[660px] lg:h-[540px] w-full">
                    
                    <!-- LARGE PHOTO CONTAINER (IDENTICAL RATIO) -->
                    <div class="lg:col-span-7 relative h-64 sm:h-80 lg:h-full bg-slate-950 overflow-hidden group">
                        <img src="{{ asset('images/g2.jpg') }}" 
                             alt="Client reference photo: disconnect switch" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" />
                    </div>

                    <!-- EQUALIZED CONTENT CONTAINER -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 h-full flex flex-col justify-between overflow-hidden">
                        <div>
                            <div class="flex items-center justify-between font-mono text-xs text-amber-700 font-bold mb-2">
                                <span>
                                    <span x-show="lang === 'ua'">КЕЙС 02 // 04</span>
                                    <span x-show="lang === 'en'">CASE 02 // 04</span>
                                </span>
                                <span class="px-2.5 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                    <span x-show="lang === 'ua'">PETG (Міцні шарніри)</span>
                                    <span x-show="lang === 'en'">PETG (Heavy-Duty Hinges)</span>
                                </span>
                            </div>

                            <div class="h-16 lg:h-20 flex items-center">
                                <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                    <span x-show="lang === 'ua'">Силовий Роз'єднувач та Замок</span>
                                    <span x-show="lang === 'en'">Disconnect Switch &amp; Latch</span>
                                </h3>
                            </div>

                            <div class="h-20 sm:h-22 flex items-center">
                                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                    <span x-show="lang === 'ua'">За фотографією мідного ножа та замка ми розробили геометрію рухомих шарнірів і надрукували функціональний прототип із міцного PETG для випробування механіки замикання.</span>
                                    <span x-show="lang === 'en'">From reference photos of the copper knife and lock mechanism, we engineered articulated joint kinematics and printed a functional PETG test unit to verify mechanical latching.</span>
                                </p>
                            </div>

                            <!-- Deliverable Chips -->
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Вхід: Фото вузла</span>
                                    <span x-show="lang === 'en'">✓ Input: Mechanism photo</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Результат: Робочий вузол</span>
                                    <span x-show="lang === 'en'">✓ Output: Functional unit</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span x-show="lang === 'ua'">✓ Точна кінематика</span>
                                    <span x-show="lang === 'en'">✓ Kinematic precision</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100 mt-auto">
                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D-Прототип: Механізм Роз\'єднувача' : 'Disconnect Mechanism Prototyping')" 
                                    class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                                <span x-show="lang === 'ua'">Замовити Схожий Прототип &rarr;</span>
                                <span x-show="lang === 'en'">Order Similar Prototype &rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 3: MODULAR SUBSTATION (g3.jpg) -->
                <div x-show="activeSlide === 2" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-[0.99]"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border-2 border-slate-900 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 h-[620px] sm:h-[660px] lg:h-[540px] w-full">
                    
                    <!-- LARGE PHOTO CONTAINER (IDENTICAL RATIO) -->
                    <div class="lg:col-span-7 relative h-64 sm:h-80 lg:h-full bg-slate-950 overflow-hidden group">
                        <img src="{{ asset('images/g3.jpg') }}" 
                             alt="Client reference photo: heavy modular transport" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" />
                    </div>

                    <!-- EQUALIZED CONTENT CONTAINER -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 h-full flex flex-col justify-between overflow-hidden">
                        <div>
                            <div class="flex items-center justify-between font-mono text-xs text-sky-700 font-bold mb-2">
                                <span>
                                    <span x-show="lang === 'ua'">КЕЙС 03 // 04</span>
                                    <span x-show="lang === 'en'">CASE 03 // 04</span>
                                </span>
                                <span class="px-2.5 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200">
                                    <span x-show="lang === 'ua'">PLA (Збірний макет)</span>
                                    <span x-show="lang === 'en'">PLA (Modular Model)</span>
                                </span>
                            </div>

                            <div class="h-16 lg:h-20 flex items-center">
                                <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                    <span x-show="lang === 'ua'">Модульна Підстанція у Зборі</span>
                                    <span x-show="lang === 'en'">Modular Substation Assembly</span>
                                </h3>
                            </div>

                            <div class="h-20 sm:h-22 flex items-center">
                                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                    <span x-show="lang === 'ua'">За фотографією великогабаритного модуля на автотралі ми створили деталізований розбірний 3D-макет із порталами для демонстрації на промислових виставках та тендерах.</span>
                                    <span x-show="lang === 'en'">From transport photos of a full-scale modular unit, we designed and 3D printed a modular display model for international exhibitions and customer tender bids.</span>
                                </p>
                            </div>

                            <!-- Deliverable Chips -->
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Вхід: Фото модуля</span>
                                    <span x-show="lang === 'en'">✓ Input: Module photo</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Результат: Розбірний макет</span>
                                    <span x-show="lang === 'en'">✓ Output: Modular scale model</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span x-show="lang === 'ua'">✓ Готовий до виставок</span>
                                    <span x-show="lang === 'en'">✓ Exhibition ready</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100 mt-auto">
                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D-Макет: Модульна Підстанція' : 'Modular Substation Prototyping')" 
                                    class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                                <span x-show="lang === 'ua'">Замовити Схожий Прототип &rarr;</span>
                                <span x-show="lang === 'en'">Order Similar Prototype &rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SLIDE 4: INSULATOR STACKS (g4.jpg) -->
                <div x-show="activeSlide === 3" 
                     x-transition:enter="transition ease-out duration-250"
                     x-transition:enter-start="opacity-0 scale-[0.99]"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border-2 border-slate-900 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 h-[620px] sm:h-[660px] lg:h-[540px] w-full">
                    
                    <!-- LARGE PHOTO CONTAINER (IDENTICAL RATIO) -->
                    <div class="lg:col-span-7 relative h-64 sm:h-80 lg:h-full bg-slate-950 overflow-hidden group">
                        <img src="{{ asset('images/g4.jpg') }}" 
                             alt="Client reference photo: insulator stack" 
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-700" />
                    </div>

                    <!-- EQUALIZED CONTENT CONTAINER -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 h-full flex flex-col justify-between overflow-hidden">
                        <div>
                            <div class="flex items-center justify-between font-mono text-xs text-emerald-700 font-bold mb-2">
                                <span>
                                    <span x-show="lang === 'ua'">КЕЙС 04 // 04</span>
                                    <span x-show="lang === 'en'">CASE 04 // 04</span>
                                </span>
                                <span class="px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span x-show="lang === 'ua'">PETG (Міцний адаптер)</span>
                                    <span x-show="lang === 'en'">PETG (Durable Adapter)</span>
                                </span>
                            </div>

                            <div class="h-16 lg:h-20 flex items-center">
                                <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                    <span x-show="lang === 'ua'">Ізоляційні Колони та Кронштейни</span>
                                    <span x-show="lang === 'en'">Insulator Columns &amp; Brackets</span>
                                </h3>
                            </div>

                            <div class="h-20 sm:h-22 flex items-center">
                                <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                    <span x-show="lang === 'ua'">За фотографією високовольтних ребристих ізоляторів ми спроектували перехідні кронштейни й надрукували примірочні прототипи з PETG для перевірки посадки перед серією.</span>
                                    <span x-show="lang === 'en'">From client photos of high-voltage insulator stacks, we modeled custom transitional brackets and 3D printed PETG prototypes to test-fit dimensions before mass production.</span>
                                </p>
                            </div>

                            <!-- Deliverable Chips -->
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Вхід: Фото ізоляторів</span>
                                    <span x-show="lang === 'en'">✓ Input: Insulators photo</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                    <span x-show="lang === 'ua'">✓ Результат: Точний адаптер</span>
                                    <span x-show="lang === 'en'">✓ Output: Custom adapter</span>
                                </span>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    <span x-show="lang === 'ua'">✓ Міцність до навантажень</span>
                                    <span x-show="lang === 'en'">✓ Load resistance</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-4 border-t border-slate-100 mt-auto">
                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? '3D-Прототип: Кронштейни Ізоляторів' : 'Insulator Mounting Prototyping')" 
                                    class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                                <span x-show="lang === 'ua'">Замовити Схожий Прототип &rarr;</span>
                                <span x-show="lang === 'en'">Order Similar Prototype &rarr;</span>
                            </button>
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
            
            <!-- SECTION HEADER -->
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16" data-aos="fade-up" data-aos-duration="600">
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                    <span x-show="lang === 'ua'">Як Ми Працюємо: Від Вашої Задачі До Готової Деталі</span>
                    <span x-show="lang === 'en'">How We Work: From Your Request to 3D Printed Parts</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-600 mt-3 leading-relaxed">
                    <span x-show="lang === 'ua'">Більшість наших замовлень — це якісний 3D-друк деталей. Ми ведемо прямий діалог на кожному кроці: допомагаємо з кресленнями, якщо немає моделі, підбираємо надійний пластик (PLA або PETG) та показуємо 3D-вигляд ще до друку.</span>
                    <span x-show="lang === 'en'">Most of our work is dedicated to precision 3D printing of parts. We stay in direct touch at every step: we help create drawings if you don't have a file, pick the right plastic (PLA or PETG), and confirm the 3D model with you before printing.</span>
                </p>
            </div>

            <!-- THE 4 GRAND COLLABORATION CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- CARD 01: ЗАДАЧА ТА ОБГОВОРЕННЯ -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 01</span>
                                <span x-show="lang === 'en'">STEP // 01</span>
                            </span>
                            <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 leading-snug mb-4">
                            <span x-show="lang === 'ua'">Запит та Обговорення</span>
                            <span x-show="lang === 'en'">Request &amp; Consultation</span>
                        </h3>

                        <!-- 2-3 Sentences (Optimized for Larger Font) -->
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'ua'">
                            Надішліть фото деталі, ескіз або зламаний зразок. Ми швидко уточнимо умови роботи, навантаження та розрахуємо точну вартість друку протягом 15 хвилин.
                        </p>
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'en'">
                            Send a photo of the part, a sketch, or a broken sample. We quickly clarify operating conditions and loads, and calculate the exact printing price within 15 minutes.
                        </p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs sm:text-sm font-mono font-bold text-sky-700">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span x-show="lang === 'ua'">Розрахунок за 15 хвилин</span>
                        <span x-show="lang === 'en'">Calculation in 15 minutes</span>
                    </div>
                </div>

                <!-- CARD 02: КРЕСЛЕННЯ ТА 3D-РОЗРОБКА -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="200">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 02</span>
                                <span x-show="lang === 'en'">STEP // 02</span>
                            </span>
                            <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 leading-snug mb-4">
                            <span x-show="lang === 'ua'">Креслення &amp; 3D-Модель</span>
                            <span x-show="lang === 'en'">Drawings &amp; 3D Model</span>
                        </h3>

                        <!-- 2-3 Sentences (Optimized for Larger Font) -->
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'ua'">
                            Знімаємо точні розміри штангенциркулем та будуємо правильну 3D-модель з посиленням навантажених місць. Показуємо візуалізацію на екрані для вашого погодження до запуску друку.
                        </p>
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'en'">
                            We take precise caliper measurements and build clean 3D CAD geometry with reinforced stress points. We show you the 3D model for your approval before printing starts.
                        </p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs sm:text-sm font-mono font-bold text-sky-700">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span x-show="lang === 'ua'">Погодження 3D перед друком</span>
                        <span x-show="lang === 'en'">3D visual approval first</span>
                    </div>
                </div>

                <!-- CARD 03: МАСШТАБ ТА ПЛАСТИК PLA / PETG -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-xl hover:border-sky-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="300">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-sky-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 03</span>
                                <span x-show="lang === 'en'">STEP // 03</span>
                            </span>
                            <div class="w-11 h-11 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 leading-snug mb-4">
                            <span x-show="lang === 'ua'">Масштаб та Пластик</span>
                            <span x-show="lang === 'en'">Scale &amp; PLA / PETG</span>
                        </h3>

                        <!-- 2-3 Sentences (Optimized for Larger Font) -->
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'ua'">
                            Підбираємо оптимальний матеріал: гладкий PLA для корпусів і макетів або міцний PETG для кронштейнів, шестерень та тепла. Визначаємо потрібну кількість від 1 штуки до партії без переплат.
                        </p>
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'en'">
                            We select the optimal material: smooth PLA for enclosures and prototypes, or tough PETG for brackets, gears, and heat resistance. We produce any volume from 1 piece to a batch without extra costs.
                        </p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs sm:text-sm font-mono font-bold text-sky-700">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span x-show="lang === 'ua'">PLA або PETG від 1 шт</span>
                        <span x-show="lang === 'en'">PLA or PETG from 1 piece</span>
                    </div>
                </div>

                <!-- CARD 04: 3D-ДРУК ТА ГОТОВА ДЕТАЛЬ -->
                <div class="cad-corner-cross bg-white border-2 border-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm hover:shadow-xl hover:border-emerald-600 transition-all duration-300 flex flex-col justify-between group" data-aos="fade-up" data-aos-delay="400">
                    <div>
                        <!-- Header Row -->
                        <div class="flex items-center justify-between mb-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-emerald-600 text-white font-mono text-xs font-black tracking-wider uppercase">
                                <span x-show="lang === 'ua'">КРОК // 04</span>
                                <span x-show="lang === 'en'">STEP // 04</span>
                            </span>
                            <div class="w-11 h-11 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 leading-snug mb-4">
                            <span x-show="lang === 'ua'">3D-Друк &amp; Готова Деталь</span>
                            <span x-show="lang === 'en'">3D Printing &amp; Ready Part</span>
                        </h3>

                        <!-- 2-3 Sentences (Optimized for Larger Font) -->
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'ua'">
                            Виготовляємо деталь на каліброваному 3D-принтері та надсилаємо фотозвіт. Контролюємо точність розмірів штангенциркулем, проводимо фінішну обробку та швидко відправляємо кур'єром або поштою.
                        </p>
                        <p class="text-base sm:text-[17px] text-slate-700 leading-relaxed font-sans" x-show="lang === 'en'">
                            We manufacture the part on calibrated 3D printers and provide photo updates. We verify dimensions with digital calipers, perform post-processing, and promptly dispatch via courier.
                        </p>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs sm:text-sm font-mono font-bold text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span x-show="lang === 'ua'">Готова деталь з перевіркою</span>
                        <span x-show="lang === 'en'">Ready part with quality check</span>
                    </div>
                </div>

            </div>

            <!-- COLLABORATION CTA BANNER (HIGH-TECH CAD CALLOUT) -->
            <div class="mt-14 relative rounded-3xl p-8 sm:p-10 lg:p-12 overflow-hidden bg-gradient-to-br from-[#0c1926] via-[#0f243a] to-[#0a1522] border-2 border-sky-500/40 shadow-2xl shadow-sky-950/20 text-white flex flex-col lg:flex-row items-center justify-between gap-8" data-aos="fade-up" data-aos-duration="700">
                
                <!-- Ambient Glow Lights -->
                <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-sky-500/20 blur-[80px] pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-blue-600/15 blur-[80px] pointer-events-none"></div>
                <div class="absolute inset-0 bg-blueprint-grid opacity-20 pointer-events-none"></div>

                <!-- CAD Blueprint Corner Markers -->
                <span class="absolute top-3 left-4 text-sky-400 font-mono text-sm font-bold pointer-events-none select-none opacity-60">+</span>
                <span class="absolute top-3 right-4 text-sky-400 font-mono text-sm font-bold pointer-events-none select-none opacity-60">+</span>
                <span class="absolute bottom-3 left-4 text-sky-400 font-mono text-sm font-bold pointer-events-none select-none opacity-60">+</span>
                <span class="absolute bottom-3 right-4 text-sky-400 font-mono text-sm font-bold pointer-events-none select-none opacity-60">+</span>

                <!-- Left Column: Headline, Specs & Guarantees -->
                <div class="relative z-10 max-w-2xl text-center lg:text-left">
                    <h3 class="font-heading text-2xl sm:text-3xl lg:text-[2.1rem] font-black text-white tracking-tight leading-tight">
                        <span x-show="lang === 'ua'">Потрібно надрукувати деталь або відновити зламану?</span>
                        <span x-show="lang === 'en'">Need to 3D print a part or replace a broken one?</span>
                    </h3>

                    <p class="text-slate-300 text-sm sm:text-base lg:text-[17px] mt-3 leading-relaxed font-sans">
                        <span x-show="lang === 'ua'">Надішліть нам фото або креслення. Швидко розрахуємо вартість друку, підкажемо, який пластик обрати (PLA для макетів чи PETG для навантажень) та одразу запустимо у виробництво.</span>
                        <span x-show="lang === 'en'">Send us a photo or sketch. We will quickly calculate the print cost, advise whether PLA or PETG fits best, and start printing right away.</span>
                    </p>

                    <!-- Fast Benefits Row -->
                    <div class="mt-5 flex flex-wrap items-center justify-center lg:justify-start gap-y-2 gap-x-5 text-xs sm:text-sm font-mono text-slate-300">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-show="lang === 'ua'">Швидка відповідь за 15 хв</span>
                            <span x-show="lang === 'en'">Fast 15-min response</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-show="lang === 'ua'">Від 1 шт до серії</span>
                            <span x-show="lang === 'en'">From 1 piece to batch</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-show="lang === 'ua'">Контроль штангенциркулем</span>
                            <span x-show="lang === 'en'">Digital caliper check</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Direct Contact Cards -->
                <div class="relative z-10 w-full sm:w-auto flex flex-col sm:flex-row lg:flex-col gap-3.5 shrink-0">
                    
                    <!-- 1. WHATSAPP DIRECT CARD -->
                    <a href="https://wa.me/" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group p-4 sm:p-5 rounded-2xl bg-slate-900/90 border-2 border-slate-700/80 hover:border-emerald-500/80 hover:bg-slate-800/90 transition-all duration-300 shadow-lg hover:shadow-emerald-500/20 flex items-center gap-4 hover:-translate-y-0.5">
                        <div class="w-12 h-12 rounded-xl bg-[#25D366] text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.35 0-2.69-.33-3.88-.97l-.28-.15-3.12.82.83-3.04-.18-.29a8.18 8.18 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.51c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.17-.48-.29z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] font-mono font-bold tracking-wider uppercase text-emerald-400">
                                WhatsApp
                            </div>
                            <div class="font-heading font-black text-white text-base group-hover:text-emerald-300 transition-colors">
                                Modex
                            </div>
                            <div class="text-xs text-slate-400 font-sans mt-0.5">
                                <span x-show="lang === 'ua'">Швидкий розрахунок у WhatsApp →</span>
                                <span x-show="lang === 'en'">Fast quote in WhatsApp →</span>
                            </div>
                        </div>
                    </a>

                    <!-- 2. INSTAGRAM DIRECT CARD -->
                    <a href="https://instagram.com/modexdesign" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group p-4 sm:p-5 rounded-2xl bg-slate-900/90 border-2 border-slate-700/80 hover:border-pink-500/80 hover:bg-slate-800/90 transition-all duration-300 shadow-lg hover:shadow-pink-500/20 flex items-center gap-4 hover:-translate-y-0.5">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center shrink-0 shadow-md shadow-pink-600/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] font-mono font-bold tracking-wider uppercase text-pink-400">
                                <span x-show="lang === 'ua'">Instagram Direct</span>
                                <span x-show="lang === 'en'">Instagram Direct</span>
                            </div>
                            <div class="font-heading font-black text-white text-base group-hover:text-pink-300 transition-colors">
                                @modexdesign
                            </div>
                            <div class="text-xs text-slate-400 font-sans mt-0.5">
                                <span x-show="lang === 'ua'">Надіслати фото або креслення →</span>
                                <span x-show="lang === 'en'">Send photo or drawing →</span>
                            </div>
                        </div>
                    </a>

                    <!-- 2. FACEBOOK MESSENGER CARD -->
                    <a href="https://facebook.com/modexdesign" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="group p-4 sm:p-5 rounded-2xl bg-slate-900/90 border-2 border-slate-700/80 hover:border-blue-500/80 hover:bg-slate-800/90 transition-all duration-300 shadow-lg hover:shadow-blue-500/20 flex items-center gap-4 hover:-translate-y-0.5">
                        <div class="w-12 h-12 rounded-xl bg-[#1877F2] text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/30 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] font-mono font-bold tracking-wider uppercase text-blue-400">
                                <span x-show="lang === 'ua'">Facebook Messenger</span>
                                <span x-show="lang === 'en'">Facebook Messenger</span>
                            </div>
                            <div class="font-heading font-black text-white text-base group-hover:text-blue-300 transition-colors">
                                modexdesign
                            </div>
                            <div class="text-xs text-slate-400 font-sans mt-0.5">
                                <span x-show="lang === 'ua'">Написати нам у чат →</span>
                                <span x-show="lang === 'en'">Message us in chat →</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECTION: ABOUT US // BRATISLAVA 3D SCALE MODEL STUDIO       -->
    <!-- ============================================================ -->
    <section id="about" class="py-20 lg:py-28 bg-white relative border-t-2 border-slate-900 overflow-hidden" data-aos="fade-up" data-aos-duration="700">
        
        <!-- Ambient blueprint background elements -->
        <div class="absolute inset-0 bg-blueprint-grid opacity-25 pointer-events-none"></div>
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-sky-400/10 blur-[100px] pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-emerald-400/10 blur-[100px] pointer-events-none"></div>

        <!-- Corner CAD markers -->
        <span class="absolute top-4 left-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
        <span class="absolute top-4 right-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
        <span class="absolute bottom-4 left-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
        <span class="absolute bottom-4 right-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- SECTION HEADER -->
            <div class="max-w-3xl">
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    <span x-show="lang === 'ua'">Про Нашу Студію</span>
                    <span x-show="lang === 'en'">About Us</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-slate-600 mt-4 leading-relaxed font-sans">
                    <span x-show="lang === 'ua'">
                        Ми — невелика студія в Братиславі (Словаччина), яка проектує та друкує на 3D-принтерах масштабні макети на замовлення для архітекторів, девелоперів, інженерних компаній та учасників міжнародних виставок.
                    </span>
                    <span x-show="lang === 'en'">
                        We are a small studio in Bratislava, Slovakia, that designs and 3D prints custom scale models for architects, developers, engineering firms and exhibitors.
                    </span>
                </p>
            </div>

            <!-- MAIN GRID: PHILOSOPHY CARD + WHAT WE MAKE -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch mt-12">
                
                <!-- Left (5 cols): How We Work & Direct Contact -->
                <div class="lg:col-span-5 rounded-3xl p-8 sm:p-10 bg-gradient-to-br from-[#0c1926] via-[#0f243a] to-[#0a1522] border-2 border-slate-900 text-white flex flex-col justify-between shadow-2xl relative overflow-hidden cad-corner-cross" data-aos="fade-right" data-aos-delay="100">
                    
                    <!-- Ambient Glow -->
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-sky-500/20 rounded-full blur-3xl pointer-events-none"></div>

                    <div>
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-white tracking-tight leading-snug">
                            <span x-show="lang === 'ua'">Від першого ескізу до готового макета — в одних руках</span>
                            <span x-show="lang === 'en'">From the first drawing to final delivery — in one pair of hands</span>
                        </h3>

                        <p class="text-slate-300 text-sm sm:text-base mt-4 leading-relaxed font-sans">
                            <span x-show="lang === 'ua'">
                                Кожен макет починається з ваших креслень, CAD-файлів або навіть простого ескізу. Ми самі будуємо 3D-модель, друкуємо її на власних принтерах і доводимо вручну — тож ви працюєте з однією людиною від першого запитання до фінальної доставки. Без посередників і без мінімального замовлення.
                            </span>
                            <span x-show="lang === 'en'">
                                Every model starts with your drawings, CAD files or even a sketch. We build the 3D model ourselves, print it on our in-house printers and finish it by hand, so you work with one person from the first question to the final delivery. No middlemen, no minimum order.
                            </span>
                        </p>

                        <!-- Key Principles Checklist -->
                        <div class="mt-6 space-y-2.5 font-mono text-xs sm:text-sm text-slate-200">
                            <div class="flex items-center gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span x-show="lang === 'ua'">Будь-який формат: креслення, CAD або ескіз</span>
                                <span x-show="lang === 'en'">Any input: drawings, CAD files, or sketches</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span x-show="lang === 'ua'">Власні принтери та ручна фінішна обробка</span>
                                <span x-show="lang === 'en'">In-house 3D printers &amp; precision hand finish</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span x-show="lang === 'ua'">Без посередників і без мінімального замовлення</span>
                                <span x-show="lang === 'en'">No middlemen, no minimum order quantity</span>
                            </div>
                        </div>

                        <!-- Dedication callout -->
                        <div class="mt-6 p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xs">
                            <p class="text-xs sm:text-sm font-mono text-emerald-300 font-bold flex items-start gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0 mt-1"></span>
                                <span>
                                    <span x-show="lang === 'ua'">Ми — молода студія, і кожен проєкт отримує нашу повну увагу.</span>
                                    <span x-show="lang === 'en'">We’re a young studio, and each project gets our full attention.</span>
                                </span>
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Right (7 cols): What We Make (3 Categories) -->
                <div class="lg:col-span-7 flex flex-col justify-between gap-5" data-aos="fade-left" data-aos-delay="200">
                    
                    <div class="pb-3 border-b-2 border-slate-900">
                        <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 uppercase tracking-tight">
                            <span x-show="lang === 'ua'">Що ми виготовляємо</span>
                            <span x-show="lang === 'en'">What we make</span>
                        </h3>
                    </div>

                    <div class="space-y-4">
                        
                        <!-- 1. Architectural models -->
                        <div class="p-6 sm:p-7 rounded-2xl border-2 border-slate-900 bg-white hover:border-sky-500 transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 group">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-sky-50 border border-sky-200 text-sky-700 flex items-center justify-center font-bold text-2xl shrink-0 group-hover:scale-110 group-hover:bg-sky-600 group-hover:text-white transition-all duration-300 shadow-xs">
                                    🏛️
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-heading text-lg sm:text-xl font-black text-slate-900 group-hover:text-sky-600 transition-colors">
                                        <span x-show="lang === 'ua'">Архітектурні макети</span>
                                        <span x-show="lang === 'en'">Architectural models</span>
                                    </h4>
                                    <p class="text-sm sm:text-base text-slate-600 mt-2 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">
                                            Будівлі, житлові комплекси, генеральні плани ділянок та індивідуальні простори для девелоперів і архітектурних бюро.
                                        </span>
                                        <span x-show="lang === 'en'">
                                            Buildings, residential complexes, site plans, and spaces for architects, developers, and presentation boards.
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Industrial and infrastructure models -->
                        <div class="p-6 sm:p-7 rounded-2xl border-2 border-slate-900 bg-white hover:border-blue-600 transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 group">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center font-bold text-2xl shrink-0 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-xs">
                                    ⚙️
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-heading text-lg sm:text-xl font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                                        <span x-show="lang === 'ua'">Промислові та інфраструктурні макети</span>
                                        <span x-show="lang === 'en'">Industrial and infrastructure models</span>
                                    </h4>
                                    <p class="text-sm sm:text-base text-slate-600 mt-2 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">
                                            Підстанції, заводи, технологічні лінії та обладнання для міжнародних виставок і презентацій інвесторам.
                                        </span>
                                        <span x-show="lang === 'en'">
                                            Substations, plants, and equipment for engineering expos, trade fairs, and investor presentations.
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Corporate gifts -->
                        <div class="p-6 sm:p-7 rounded-2xl border-2 border-slate-900 bg-white hover:border-emerald-600 transition-all duration-300 shadow-md hover:shadow-xl hover:-translate-y-0.5 group">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center font-bold text-2xl shrink-0 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-xs">
                                    🎁
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-heading text-lg sm:text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">
                                        <span x-show="lang === 'ua'">Корпоративні подарунки</span>
                                        <span x-show="lang === 'en'">Corporate gifts</span>
                                    </h4>
                                    <p class="text-sm sm:text-base text-slate-600 mt-2 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">
                                            Мініатюрні точні копії вашого офісу, знакового об'єкта чи флагманського продукту бренду.
                                        </span>
                                        <span x-show="lang === 'en'">
                                            Miniature replicas of your office, headquarters building, or flagship industrial product.
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Bottom Quick Action CTA Bar -->
                    <div class="mt-2 p-5 sm:p-6 rounded-2xl bg-slate-900 border-2 border-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                            <div class="text-xs sm:text-sm font-mono">
                                <span class="font-bold text-white block" x-show="lang === 'ua'">Прямий зв'язок з майстром у Братиславі</span>
                                <span class="font-bold text-white block" x-show="lang === 'en'">Direct contact with our Bratislava studio</span>
                                <span class="text-slate-400 text-[11px]" x-show="lang === 'ua'">Швидкий розрахунок за 15 хвилин &bull; Без посередників</span>
                                <span class="text-slate-400 text-[11px]" x-show="lang === 'en'">15-minute quote response &bull; No middlemen</span>
                            </div>
                        </div>

                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Індивідуальний макет (Студія Братислава)' : 'Custom Scale Model (Bratislava Studio)')" 
                                class="w-full sm:w-auto btn-cyan-glow text-white font-mono font-bold py-3 px-6 rounded-xl cursor-pointer text-xs sm:text-sm transition-all whitespace-nowrap shadow-md">
                            <span x-show="lang === 'ua'">Замовити Макет &rarr;</span>
                            <span x-show="lang === 'en'">Order a Model &rarr;</span>
                        </button>
                    </div>

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
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch">
                
                <!-- Left: Interactive Order Intake Form -->
                <div class="lg:col-span-7 bg-white rounded-2xl border-2 border-slate-900 p-8 sm:p-10 shadow-xl cad-corner-cross flex flex-col justify-between" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <h2 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 mb-6">
                            <span x-show="lang === 'ua'">Оформити Замовлення на Деталь</span>
                            <span x-show="lang === 'en'">Place Your 3D Print Order</span>
                        </h2>

                        <template x-if="!sent">
                            <form @submit.prevent="sent = true" class="space-y-5">
                                
                                <!-- КОНТАКТНІ ДАНІ: ІМ'Я ТА EMAIL -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                            <span x-show="lang === 'ua'">Ваше Ім'я:</span>
                                            <span x-show="lang === 'en'">Your Name:</span>
                                        </label>
                                        <input type="text" required x-model="name" :placeholder="lang === 'ua' ? 'Олександр' : 'Alexander'" class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 text-base text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans transition-colors" />
                                    </div>
                                    <div>
                                        <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                            <span x-show="lang === 'ua'">Email (для розрахунку або файлів):</span>
                                            <span x-show="lang === 'en'">Email Address (for quote or files):</span>
                                        </label>
                                        <input type="email" required x-model="email" :placeholder="lang === 'ua' ? 'alex@example.com' : 'alex@example.com'" class="w-full rounded-xl border-2 border-slate-300 px-4 py-3 text-base text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans transition-colors" />
                                    </div>
                                </div>

                                <!-- ЗАВАНТАЖЕННЯ ФАЙЛІВ (СМУЖКА З ВИПАДАЮЧИМ СПИСКОМ) -->
                                <div x-data="{ openUpload: false, selectedFiles: [] }">
                                    <label class="block text-xs sm:text-sm font-mono font-bold text-slate-900 uppercase mb-2">
                                        <span x-show="lang === 'ua'">Завантажити файли, креслення або фото:</span>
                                        <span x-show="lang === 'en'">Upload CAD Files, Drawings or Photos:</span>
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
                                            <span class="text-xs font-mono font-semibold text-slate-500 hidden sm:inline" x-show="selectedFiles.length === 0">
                                                <span x-show="lang === 'ua'">до 100 МБ</span>
                                                <span x-show="lang === 'en'">up to 100MB</span>
                                            </span>
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
                                    <textarea rows="4" x-model="details" :placeholder="lang === 'ua' ? 'Опишіть призначення деталі, орієнтовні розміри або вставте посилання на фото чи 3D-файл (Google Drive, Instagram, Facebook, хмара)...' : 'Describe the part purpose, rough dimensions, or paste a link to photos/CAD files (Google Drive, Instagram, Facebook, cloud storage)...'" class="w-full rounded-xl border-2 border-slate-300 p-4 text-base text-slate-900 bg-slate-50/70 focus:outline-hidden focus:border-sky-500 font-sans transition-colors"></textarea>
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="w-full btn-cyan-glow text-white font-bold py-4 rounded-xl cursor-pointer text-base sm:text-lg shadow-lg hover:shadow-cyan-500/30 transition-all">
                                        <span x-show="lang === 'ua'">Надіслати Замовлення на Розрахунок &rarr;</span>
                                        <span x-show="lang === 'en'">Submit Order for Estimation &rarr;</span>
                                    </button>
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
                            <span x-show="lang === 'ua'">ПРЯМИЙ ЗВ'ЯЗОК</span>
                            <span x-show="lang === 'en'">DIRECT CONTACT</span>
                        </h3>
                        <div class="grid grid-cols-4 gap-2 sm:gap-3.5">
                            <!-- 1. WHATSAPP -->
                            <a href="https://wa.me/" target="_blank" rel="noopener noreferrer" 
                               title="WhatsApp: Modex" aria-label="WhatsApp"
                               class="group aspect-square rounded-xl border-2 border-slate-200 hover:border-emerald-500 bg-slate-50 hover:bg-emerald-50/50 p-2 sm:p-2.5 flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md">
                                <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md shadow-emerald-500/20 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.35 0-2.69-.33-3.88-.97l-.28-.15-3.12.82.83-3.04-.18-.29a8.18 8.18 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.51c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.17-.48-.29z"/>
                                    </svg>
                                </div>
                            </a>
                            <!-- 2. INSTAGRAM -->
                            <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" 
                               title="Instagram: @modexdesign" aria-label="Instagram"
                               class="group aspect-square rounded-xl border-2 border-slate-200 hover:border-pink-500 bg-slate-50 hover:bg-pink-50/50 p-2 sm:p-2.5 flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md">
                                <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center shadow-md shadow-pink-500/20 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                            </a>
                            <!-- 3. FACEBOOK -->
                            <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" 
                               title="Facebook: modexdesign" aria-label="Facebook"
                               class="group aspect-square rounded-xl border-2 border-slate-200 hover:border-blue-600 bg-slate-50 hover:bg-blue-50/50 p-2 sm:p-2.5 flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md">
                                <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-[#1877F2] text-white flex items-center justify-center shadow-md shadow-blue-500/20 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                            </a>
                            <!-- 4. EMAIL -->
                            <a href="mailto:orders@modexdesign.com" 
                               title="Email: orders@modexdesign.com" aria-label="Email"
                               class="group aspect-square rounded-xl border-2 border-slate-200 hover:border-sky-500 bg-slate-50 hover:bg-sky-50/50 p-2 sm:p-2.5 flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md">
                                <div class="w-11 h-11 sm:w-13 sm:h-13 rounded-full bg-sky-500 text-white flex items-center justify-center shadow-md shadow-sky-500/20 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Practical FAQ Card -->
                    <div class="bg-white rounded-2xl border-2 border-slate-900 p-6 sm:p-7 shadow-xl font-mono text-sm sm:text-base cad-corner-cross flex-1 flex flex-col justify-between" data-aos="fade-up" data-aos-delay="300">
                        <div>
                            <h3 class="font-heading text-lg font-black text-slate-900 mb-5 pb-3 border-b-2 border-slate-900 uppercase">
                                <span x-show="lang === 'ua'">ЧАСТІ ЗАПИТАННЯ ПО ЗАМОВЛЕННЮ</span>
                                <span x-show="lang === 'en'">ORDERING FAQ</span>
                            </h3>
                            <div class="space-y-3.5">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                                        <span x-show="lang === 'ua'">Як передати креслення чи фото деталі?</span>
                                        <span x-show="lang === 'en'">How to send photos or drawings?</span>
                                    </h4>
                                    <p class="text-slate-600 text-sm sm:text-base mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">Надішліть посилання у формі, напишіть у WhatsApp, Instagram @modexdesign, Facebook або на пошту.</span>
                                        <span x-show="lang === 'en'">Paste a link in the form, message us on WhatsApp, Instagram @modexdesign, Facebook, or email us.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                                        <span x-show="lang === 'ua'">Якщо немає 3D-моделі, тільки зламана деталь?</span>
                                        <span x-show="lang === 'en'">What if there is no 3D file, only a broken sample?</span>
                                    </h4>
                                    <p class="text-slate-600 text-sm sm:text-base mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'">Достатньо сфотографувати деталь поруч із лінійкою. Ми знімемо всі розміри та створимо точну 3D-модель.</span>
                                        <span x-show="lang === 'en'">Take a photo of the part with a ruler next to it. We will engineer the 3D model accurately.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                                        <span x-show="lang === 'ua'">Який пластик обрати: PLA чи PETG?</span>
                                        <span x-show="lang === 'en'">Which plastic to choose: PLA or PETG?</span>
                                    </h4>
                                    <p class="text-slate-600 text-sm sm:text-base mt-1 font-sans leading-relaxed">
                                        <span x-show="lang === 'ua'"><strong>PLA</strong> підходить для макетів та естетики. <strong>PETG</strong> — для міцних шестерень, кронштейнів та деталей авто.</span>
                                        <span x-show="lang === 'en'"><strong>PLA</strong> for visual mockups. <strong>PETG</strong> for high-strength brackets, gears, and outdoor parts.</span>
                                    </p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm sm:text-base">
                                        <span x-show="lang === 'ua'">Скільки часу займає виготовлення?</span>
                                        <span x-show="lang === 'en'">How long does printing take?</span>
                                    </h4>
                                    <p class="text-slate-600 text-sm sm:text-base mt-1 font-sans leading-relaxed">
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