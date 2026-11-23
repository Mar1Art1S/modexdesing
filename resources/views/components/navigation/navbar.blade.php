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
        <nav class="hidden md:flex items-center gap-6 lg:gap-7 text-[15px] lg:text-[16px] tracking-normal font-semibold">
            <a href="#hero" 
               :class="activeSection === 'hero' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
               class="py-1 transition-colors duration-200">
                <span x-show="lang === 'en'">Home</span>
                <span x-show="lang === 'ua'">Головна</span>
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
            <a href="#about" 
               :class="activeSection === 'about' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
               class="py-1 transition-colors duration-200">
                <span x-show="lang === 'en'">About Us</span>
                <span x-show="lang === 'ua'">Про нас</span>
            </a>
            <a href="#contacts" 
               :class="activeSection === 'contacts' ? 'nav-active-glow' : 'text-slate-600 hover:text-sky-600'" 
               class="py-1 transition-colors duration-200">
                <span x-show="lang === 'en'">Contacts</span>
                <span x-show="lang === 'ua'">Контакти</span>
            </a>
        </nav>

        <!-- HEADER ACTION BUTTONS & LANGUAGE SWITCHER -->
        <div class="hidden sm:flex items-center gap-4">
            <!-- LANGUAGE TOGGLE -->
            <div class="flex items-center p-0.5 rounded-lg bg-slate-100 border border-slate-300 text-xs font-bold">
                <button type="button" 
                        @click="setLang('en')"
                        :class="lang === 'en' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-md transition-all cursor-pointer">
                    EN
                </button>
                <button type="button" 
                        @click="setLang('ua')"
                        :class="lang === 'ua' ? 'bg-white text-sky-600 shadow-xs' : 'text-slate-500 hover:text-slate-800'"
                        class="px-3 py-1.5 rounded-md transition-all cursor-pointer">
                    UA
                </button>
            </div>

            <!-- ORDER PROJECT CTA -->
            <button type="button" 
                    @click="orderModalOpen = true; selectedService = (lang === 'ua' ? 'Загальний Проект' : 'General Project')" 
                    class="btn-cyan-glow text-white text-sm sm:text-base font-bold px-5 sm:px-6 py-2.5 rounded-xl cursor-pointer">
                <span x-show="lang === 'en'">Order a Project</span>
                <span x-show="lang === 'ua'">Замовити Проект</span>
            </button>
        </div>

        <!-- MOBILE HAMBURGER TOGGLE -->
        <button type="button" 
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden w-11 h-11 flex items-center justify-center rounded-xl text-slate-800 hover:text-sky-600 bg-slate-100 hover:bg-slate-200 transition-colors cursor-pointer"
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
         class="md:hidden bg-white/98 backdrop-blur-md border-b-2 border-slate-300 px-5 py-5 space-y-2 shadow-xl">
        <div class="flex items-center justify-between pb-3 mb-2 border-b border-slate-200">
            <span class="text-xs font-mono font-bold text-slate-500 uppercase tracking-wider">МОВА // LANGUAGE:</span>
            <div class="flex items-center p-1 rounded-xl bg-slate-100 border border-slate-300 text-xs font-bold">
                <button type="button" @click="setLang('en')" :class="lang === 'en' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-600'" class="px-3 py-1.5 rounded-lg cursor-pointer">EN</button>
                <button type="button" @click="setLang('ua')" :class="lang === 'ua' ? 'bg-white text-sky-600 shadow-sm' : 'text-slate-600'" class="px-3 py-1.5 rounded-lg cursor-pointer">UA</button>
            </div>
        </div>
        <a href="#hero" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">Home</span><span x-show="lang === 'ua'">Головна</span>
        </a>
        <a href="#projects" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">Projects</span><span x-show="lang === 'ua'">Проекти</span>
        </a>
        <a href="#printing" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">3D Printing</span><span x-show="lang === 'ua'">3D Друк</span>
        </a>
        <a href="#engineering" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">How it Works</span><span x-show="lang === 'ua'">Як ми працюємо</span>
        </a>
        <a href="#about" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">About Us</span><span x-show="lang === 'ua'">Про нас</span>
        </a>
        <a href="#contacts" @click="mobileMenuOpen = false" class="block text-slate-800 hover:text-sky-600 active:bg-sky-50 font-bold text-lg py-2.5 px-3 rounded-xl transition-colors">
            <span x-show="lang === 'en'">Contacts</span><span x-show="lang === 'ua'">Контакти</span>
        </a>
        <div class="pt-3">
            <button type="button" 
                    @click="orderModalOpen = true; mobileMenuOpen = false; selectedService = (lang === 'ua' ? 'Загальний Проект' : 'General Project')" 
                    class="w-full btn-cyan-glow text-white text-base font-bold py-3.5 px-6 rounded-xl cursor-pointer shadow-md">
                <span x-show="lang === 'en'">Order a Project</span>
                <span x-show="lang === 'ua'">Замовити Проект</span>
            </button>
        </div>
    </div>
</header>
