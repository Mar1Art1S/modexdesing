<!-- ============================================================ -->
<!-- CONTACT & FOOTER SECTION                                     -->
<!-- ============================================================ -->
<footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
            <!-- Brand -->
            <div class="md:col-span-2" data-aos="fade-up" data-aos-delay="100">
                <a href="{{ route('home') }}" class="inline-block group">
                    <img src="{{ asset('images/modex-header-logo-white.png') }}" 
                         alt="Modex - the way you like" 
                         class="h-20 sm:h-24 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                         onerror="this.src='{{ asset('images/modex4.png') }}';" />
                </a>
            </div>

            <!-- Services -->
            <div data-aos="fade-up" data-aos-delay="200">
                <h4 class="font-heading text-sm sm:text-base font-bold text-white uppercase tracking-wider mb-4">
                    <span x-show="lang === 'ua'">Напрямки Діяльності</span>
                    <span x-show="lang === 'en'">Core Competencies</span>
                </h4>
                <ul class="space-y-3 text-sm sm:text-base text-slate-300">
                    <li>
                        <a href="#engineering" class="hover:text-sky-400 transition-colors">
                            <span x-show="lang === 'ua'">3D-Моделювання</span>
                            <span x-show="lang === 'en'">3D Modeling</span>
                        </a>
                    </li>
                    <li>
                        <a href="#printing" class="hover:text-sky-400 transition-colors">
                            <span x-show="lang === 'ua'">3D Друк та Прототипування</span>
                            <span x-show="lang === 'en'">3D Printing &amp; Prototyping</span>
                        </a>
                    </li>
                    <li>
                        <a href="#engineering" class="hover:text-sky-400 transition-colors">
                            <span x-show="lang === 'ua'">Процес 3D-друку деталей</span>
                            <span x-show="lang === 'en'">Parts 3D Printing Workflow</span>
                        </a>
                    </li>
                    <li>
                        <a href="#about" class="hover:text-sky-400 transition-colors">
                            <span x-show="lang === 'ua'">Про Студію (Братислава)</span>
                            <span x-show="lang === 'en'">About Us (Bratislava Studio)</span>
                        </a>
                    </li>
                    <li>
                        <a href="#projects" class="hover:text-sky-400 transition-colors">
                            <span x-show="lang === 'ua'">Портфоліо та Реалізовані Проекти</span>
                            <span x-show="lang === 'en'">Case Studies &amp; Hardware Portfolio</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div data-aos="fade-up" data-aos-delay="300">
                <h4 class="font-heading text-sm sm:text-base font-bold text-white uppercase tracking-wider mb-4">
                    <span x-show="lang === 'ua'">Майстерня та Зв'язок</span>
                    <span x-show="lang === 'en'">Workshop &amp; Direct Contact</span>
                </h4>
                <ul class="space-y-3 text-sm sm:text-base text-slate-300">
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 012.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.35 0-2.69-.33-3.88-.97l-.28-.15-3.12.82.83-3.04-.18-.29a8.18 8.18 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24m4.52 11.51c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.1-.23-.17-.48-.29z"/>
                        </svg>
                        <a href="https://wa.me/" target="_blank" rel="noopener noreferrer" class="hover:text-emerald-400 transition-colors">WhatsApp: Modex</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:orders@modexdesign.com" class="hover:text-sky-400 transition-colors">orders@modexdesign.com</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-pink-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" class="hover:text-pink-400 transition-colors">Instagram: @modexdesign</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-blue-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" class="hover:text-blue-400 transition-colors">Facebook: modexdesign</a>
                    </li>
                    <li class="pt-2">
                        <button type="button" 
                                @click="orderModalOpen = true" 
                                class="text-sm font-semibold text-sky-400 hover:text-sky-300 underline underline-offset-4 cursor-pointer">
                            <span x-show="lang === 'ua'">Замовити Консультацію Інженера &rarr;</span>
                            <span x-show="lang === 'en'">Book Technical Consultation &rarr;</span>
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
