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
