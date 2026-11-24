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
             '{{ asset('images/house/002.jpg') }}',
             '{{ asset('images/house/006.jpg') }}'
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
                     onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = this.src.includes('.jpg') ? this.src.replace('.jpg', '.png') : this.src.replace('.png', '.jpg'); }"
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
                    
                    <span class="hidden sm:inline">Fullscreen</span>
                </div>
            </div>

            <!-- Thumbnails Row (larger, comfortable, responsive) -->
            <div class="grid grid-cols-6 gap-2 sm:gap-2.5 mt-4 shrink-0">
                <template x-for="(imgSrc, idx) in gallery" :key="idx">
                    <button type="button" 
                            @click="activeImg = imgSrc; activeIdx = idx" 
                            :class="activeIdx === idx ? 'border-sky-400 ring-2 ring-sky-400/80 scale-102 opacity-100 shadow-md shadow-sky-500/30' : 'border-slate-800 opacity-60 hover:opacity-100'"
                            class="h-16 sm:h-20 rounded-xl overflow-hidden border-2 bg-slate-900 transition-all cursor-pointer relative group">
                        <img :src="imgSrc" onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = this.src.includes('.jpg') ? this.src.replace('.jpg', '.png') : this.src.replace('.png', '.jpg'); }" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    </button>
                </template>
            </div>
        </div>

        <!-- Right (5 cols): Description, Interactive Tabs & Call to Action -->
        <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between bg-white font-sans">
            <div>
                <h3 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-snug">
                    
                    Corporate &amp; Client Gifts
                </h3>

                <p class="text-sm font-semibold text-sky-700 mt-2 leading-snug">
                    
                    A miniature of the home, office or building your client will never forget.
                </p>

                <p class="text-xs sm:text-[13px] text-slate-600 mt-2.5 leading-relaxed">
                    
                    Closing a deal, handing over keys or celebrating a milestone? A custom scale model turns a real property into a personal keepsake that stays on a desk or shelf for years.
                </p>

                <!-- Interactive 3-Tab Switcher -->
                <div class="mt-5 grid grid-cols-3 gap-1 p-1 bg-slate-100 rounded-xl font-mono text-xs">
                    <button type="button" 
                            @click="giftTab = 'who'"
                            :class="giftTab === 'who' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                            class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                        
                        Who it's for
                    </button>
                    <button type="button" 
                            @click="giftTab = 'what'"
                            :class="giftTab === 'what' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                            class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                        
                        What you get
                    </button>
                    <button type="button" 
                            @click="giftTab = 'how'"
                            :class="giftTab === 'how' ? 'bg-white text-slate-900 font-bold shadow-xs border border-slate-300' : 'text-slate-600 hover:text-slate-900 border border-transparent'"
                            class="py-2 px-1 text-center rounded-lg transition-all cursor-pointer">
                        
                        How it works
                    </button>
                </div>

                <!-- Tab 1: Who it's for -->
                <div x-show="giftTab === 'who'" class="mt-4 space-y-2.5 font-sans text-xs sm:text-[13px] text-slate-700">
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-sky-100 text-sky-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏠</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Real estate agents and agencies:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                Give buyers a miniature of their new home at closing.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏗️</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Developers and builders:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                A model of the finished house or apartment as a handover gift.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-amber-100 text-amber-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏛️</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Banks, insurers and law firms:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                A memorable thank-you for key clients.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-indigo-100 text-indigo-800 flex items-center justify-center text-xs shrink-0 mt-0.5 font-bold">🏢</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Companies:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                A replica of your headquarters, branch or flagship building for partners, employees and anniversaries.
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
                                
                                Detailed miniature:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                A detailed miniature built from photos, drawings or an address.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Custom options:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                Options for color, roof and façade details, and surroundings.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Base with custom plate:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                A wooden or acrylic base with a custom plate: name, date or your logo.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] shrink-0 mt-0.5 font-bold">✓</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Gift-ready packaging:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                Gift-ready packaging, shipped directly to you or your client.
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
                                
                                Send us the property:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                Photos, floor plans, an address or a link.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">02</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Confirm the design:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                We send a 3D preview and a fixed price.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">03</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                We build it:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                Printed in-house and finished by hand.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5 p-2 rounded-lg hover:bg-slate-50 transition-colors">
                        <div class="w-5 h-5 rounded-md bg-slate-900 text-white flex items-center justify-center text-[11px] font-mono shrink-0 mt-0.5 font-bold">04</div>
                        <div>
                            <p class="font-bold text-slate-900">
                                
                                Delivered in gift packaging:
                            </p>
                            <p class="text-slate-600 text-xs">
                                
                                With a photo of the finished model before it ships.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Button & Trust Notice -->
            <div class="mt-6 pt-5 border-t border-slate-100">
                <button type="button" 
                        @click="orderModalOpen = true; selectedService = 'Scale Model: Corporate & Client Gifts'"
                        class="w-full btn-cyan-glow text-white font-bold py-3.5 px-6 rounded-xl cursor-pointer text-sm font-mono transition-all flex items-center justify-center gap-2">
                    
                    Order a Gift Model &rarr;
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
                    
                    High-Resolution Architectural View
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
                 onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = this.src.includes('.jpg') ? this.src.replace('.jpg', '.png') : this.src.replace('.png', '.jpg'); }"
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
                    <img :src="imgSrc" onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = this.src.includes('.jpg') ? this.src.replace('.jpg', '.png') : this.src.replace('.png', '.jpg'); }" class="w-full h-full object-cover" />
                </button>
            </template>
        </div>
    </div>
</div>
