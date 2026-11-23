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
