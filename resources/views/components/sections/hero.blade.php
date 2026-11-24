<!-- ============================================================ -->
<!-- SECTION 1: FULL-SCREEN HERO WITH ZAS.PNG & CAD DRAWING FRAME -->
<!-- ============================================================ -->
<section id="hero" class="relative min-h-[650px] lg:min-h-[calc(100vh-5.5rem)] py-10 sm:py-14 lg:py-16 flex flex-col justify-center overflow-hidden bg-[#e5e9ee]">
    
    <!-- FULL-BLEED HERO BACKGROUND: ZAS.PNG SPREAD ACROSS ENTIRE SCREEN -->
    <div class="absolute inset-0 w-full h-full pointer-events-none select-none z-0 overflow-hidden">
        <!-- Full-screen original cover image (zas.png with jpg fallback) -->
        <img src="{{ asset('images/zas.png') }}" 
             onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = '{{ asset('images/zas.jpg') }}'; }"
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
                
                FROM CONCEPT TO REALITY:<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 via-sky-800 to-sky-600">3D PRINTING &amp; TECHNICAL<br>
                    ENGINEERING
                </span>
            </h1>

            <!-- SUBTITLE (LARGER & MORE SPACIOUS) -->
            <p class="mt-6 text-base sm:text-lg lg:text-xl text-slate-700 max-w-2xl font-normal leading-relaxed" data-aos="fade-up" data-aos-duration="700" data-aos-delay="200">
                
                High-precision 3D modeling, rapid prototyping, and turnkey manufacturing of complex hardware engineering projects.
            </p>

            <!-- ACTION BUTTONS (LARGER, IMPACTFUL BUTTONS) -->
            <div class="mt-8 flex flex-wrap items-center gap-4" data-aos="fade-up" data-aos-duration="700" data-aos-delay="300">
                <button type="button" 
                        @click="orderModalOpen = true; selectedService = '3D Printing & Prototyping'"
                        class="btn-cyan-glow text-white text-base sm:text-lg font-bold px-8 sm:px-10 py-4 rounded-xl cursor-pointer w-full sm:w-auto text-center">
                    
                    Start a Project
                </button>
                
                <a href="#projects" 
                   class="inline-flex items-center justify-center px-8 sm:px-9 py-4 rounded-xl text-base sm:text-lg font-bold text-slate-900 bg-white hover:bg-slate-50 border-2 border-slate-900 shadow-sm hover:border-sky-500 hover:text-sky-600 hover:shadow-[0_0_20px_rgba(14,165,233,0.25)] transition-all duration-300 w-full sm:w-auto">
                    
                    View Projects &darr;
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
                        
                        PRECISION ACCURACY
                    </div>
                </div>
                <div>
                    <div class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-baseline gap-1">
                        <span>24</span>
                        <span class="text-sky-500 font-bold text-base sm:text-lg lg:text-xl">hrs</span>
                    </div>
                    <div class="text-[11px] sm:text-xs font-mono font-bold tracking-wider text-slate-600 uppercase mt-1.5">
                        
                        RAPID TURNAROUND
                    </div>
                </div>
                <div>
                    <div class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight flex items-baseline gap-1">
                        <span>100%</span>
                        <span class="text-sky-500 font-bold text-base sm:text-lg lg:text-xl">CAD</span>
                    </div>
                    <div class="text-[11px] sm:text-xs font-mono font-bold tracking-wider text-slate-600 uppercase mt-1.5">
                        
                        PARAMETRIC DESIGN
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
