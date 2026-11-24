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
                    
                    From Client Reference Photo &rarr; To Ready 3D Prototype
                </h2>
                <p class="text-base sm:text-lg text-slate-600 mt-3 leading-relaxed">
                    
                    Send us a photo, broken sample, or sketch. We engineer the exact 3D CAD model and manufacture precision scale mockups, brackets, or working components.
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
                                
                                CASE 01 // 04
                            </span>
                            <span class="px-2.5 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200">
                                
                                PLA (Scale Model)
                            </span>
                        </div>

                        <div class="h-16 lg:h-20 flex items-center">
                            <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                
                                Portal Structures &amp; Busbars
                            </h3>
                        </div>

                        <div class="h-20 sm:h-22 flex items-center">
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                
                                Client provided hangar photos of portal steel structures. We engineered the precise 3D CAD model and printed a scaled prototype for investor presentation and spatial fit inspection.
                            </p>
                        </div>

                        <!-- Deliverable Chips -->
                        <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Input: Hangar photo
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Output: 3D scale model
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                
                                ✓ Scale 100% fit
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100 mt-auto">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Portal Structures Prototyping'" 
                                class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                            
                            Order Similar Prototype &rarr;
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
                                
                                CASE 02 // 04
                            </span>
                            <span class="px-2.5 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200">
                                
                                PETG (Heavy-Duty Hinges)
                            </span>
                        </div>

                        <div class="h-16 lg:h-20 flex items-center">
                            <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                
                                Disconnect Switch &amp; Latch
                            </h3>
                        </div>

                        <div class="h-20 sm:h-22 flex items-center">
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                
                                From reference photos of the copper knife and lock mechanism, we engineered articulated joint kinematics and printed a functional PETG test unit to verify mechanical latching.
                            </p>
                        </div>

                        <!-- Deliverable Chips -->
                        <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Input: Mechanism photo
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Output: Functional unit
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                
                                ✓ Kinematic precision
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100 mt-auto">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Disconnect Mechanism Prototyping'" 
                                class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                            
                            Order Similar Prototype &rarr;
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
                                
                                CASE 03 // 04
                            </span>
                            <span class="px-2.5 py-0.5 rounded bg-sky-50 text-sky-700 border border-sky-200">
                                
                                PLA (Modular Model)
                            </span>
                        </div>

                        <div class="h-16 lg:h-20 flex items-center">
                            <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                
                                Modular Substation Assembly
                            </h3>
                        </div>

                        <div class="h-20 sm:h-22 flex items-center">
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                
                                From transport photos of a full-scale modular unit, we designed and 3D printed a modular display model for international exhibitions and customer tender bids.
                            </p>
                        </div>

                        <!-- Deliverable Chips -->
                        <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Input: Module photo
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Output: Modular scale model
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                
                                ✓ Exhibition ready
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100 mt-auto">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Modular Substation Prototyping'" 
                                class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                            
                            Order Similar Prototype &rarr;
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
                                
                                CASE 04 // 04
                            </span>
                            <span class="px-2.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                
                                PETG (Durable Adapter)
                            </span>
                        </div>

                        <div class="h-16 lg:h-20 flex items-center">
                            <h3 class="font-heading text-2xl sm:text-3xl lg:text-[28px] font-black text-slate-900 tracking-tight leading-tight line-clamp-2">
                                
                                Insulator Columns &amp; Brackets
                            </h3>
                        </div>

                        <div class="h-20 sm:h-22 flex items-center">
                            <p class="text-sm sm:text-base text-slate-600 leading-relaxed font-sans line-clamp-3">
                                
                                From client photos of high-voltage insulator stacks, we modeled custom transitional brackets and 3D printed PETG prototypes to test-fit dimensions before mass production.
                            </p>
                        </div>

                        <!-- Deliverable Chips -->
                        <div class="mt-4 flex flex-wrap gap-2 text-xs font-mono font-bold">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Input: Insulators photo
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800">
                                
                                ✓ Output: Custom adapter
                            </span>
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200">
                                
                                ✓ Load resistance
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100 mt-auto">
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Insulator Mounting Prototyping'" 
                                class="w-full btn-cyan-glow text-white font-bold py-3 px-5 rounded-xl cursor-pointer text-sm sm:text-base flex items-center justify-center gap-2 shadow-md">
                            
                            Order Similar Prototype &rarr;
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
