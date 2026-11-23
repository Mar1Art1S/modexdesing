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
        <x-sections.architectural-showcase />

    </div>
</section>
