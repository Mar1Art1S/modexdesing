<x-layouts.public title="Contact & Technical Consultation" description="Book a direct engineering consultation, submit CAD models under NDA, or visit our 3D hardware prototyping workshop.">
    
    <!-- PAGE HERO -->
    <section class="pt-12 pb-10 border-b border-slate-200/80 bg-gradient-to-b from-sky-50/40 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-mono font-medium mb-4">
                    <span>COMMUNICATION // DIRECT WORKSHOP INTAKE</span>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Let's Build Your Hardware.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-900 via-sky-700 to-sky-500">Engineering Consultation.</span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    Discuss your project with our lead engineer. We offer mutual NDA signing, full DFM review, and rapid-response technical feasibility feedback.
                </p>
            </div>
        </div>
    </section>

    <!-- CONTACT FORM & WORKSHOP INFO -->
    <section class="py-14 bg-white" x-data="{ sent: false, ndaRequired: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <!-- Left: Form -->
                <div class="lg:col-span-7">
                    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                            <span class="text-xs font-mono text-sky-700 font-bold uppercase tracking-wider">PROJECT INTAKE FORM</span>
                        </div>
                        <h2 class="font-heading text-2xl font-bold text-slate-900">Send Technical Inquiry</h2>
                        <p class="text-xs text-slate-500 mt-1 mb-6">All communications are treated with strict engineering confidentiality.</p>

                        <template x-if="!sent">
                            <form @submit.prevent="sent = true" class="space-y-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Your Name</label>
                                        <input type="text" required placeholder="Alexander Vance" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Company / Organization</label>
                                        <input type="text" placeholder="Robotics Lab / Individual" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Email Address</label>
                                        <input type="email" required placeholder="alex@tech.com" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Phone / Telegram Handle</label>
                                        <input type="text" placeholder="+380... or @telegram" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Project Category</label>
                                    <select class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50">
                                        <option>3D Printing &amp; Prototyping (PLA, PETG)</option>
                                        <option>Parametric 3D CAD Modeling &amp; Engineering Drawings</option>
                                        <option>Electronics Enclosure &amp; PCB Hardware Fit</option>
                                        <option>Full Turnkey Electromechanical Prototype</option>
                                        <option>Batch Production &amp; Finished Assembly</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Technical Requirements &amp; Quantities</label>
                                    <textarea rows="4" placeholder="Detail your mechanical requirements, operating temperature, required tolerances, chemical exposure, or deadline..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50"></textarea>
                                </div>

                                <!-- NDA Checkbox -->
                                <div class="flex items-start gap-2 pt-1">
                                    <input type="checkbox" id="nda-checkbox" x-model="ndaRequired" class="mt-0.5 rounded border-slate-300 text-sky-600 focus:ring-sky-500" />
                                    <label for="nda-checkbox" class="text-xs text-slate-600 cursor-pointer">
                                        <strong>Mutual NDA Required:</strong> Please send a signed Non-Disclosure Agreement before I upload proprietary 3D CAD models.
                                    </label>
                                </div>

                                <div class="pt-3">
                                    <button type="submit" class="w-full btn-cyan-glow text-white font-semibold py-3.5 rounded-xl cursor-pointer text-sm">
                                        Send Technical Brief
                                    </button>
                                </div>
                            </form>
                        </template>

                        <template x-if="sent">
                            <div class="text-center py-10">
                                <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="font-heading text-xl font-bold text-slate-900">Inquiry Successfully Queued</h3>
                                <p class="text-sm text-slate-600 mt-2 max-w-md mx-auto">
                                    Thank you. Our engineering team has received your message. You will receive an initial technical feasibility response within 24 hours.
                                </p>
                                <button type="button" @click="sent = false" class="mt-6 text-xs text-sky-600 font-semibold hover:underline">
                                    Send another inquiry
                                </button>
                            </div>
                        </template>

                    </div>
                </div>

                <!-- Right: Workshop Details & FAQ -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <!-- Direct Contact Card -->
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">
                        <h3 class="font-heading text-base font-bold text-slate-900 mb-4">Direct Channels</h3>
                        <div class="space-y-4 text-xs font-mono text-slate-700">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">@</div>
                                <div>
                                    <div class="font-bold text-slate-900">EMAIL</div>
                                    <a href="mailto:orders@modexdesign.com" class="text-sky-600 hover:underline">orders@modexdesign.com</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-pink-100 text-pink-700 font-bold flex items-center justify-center shrink-0">IG</div>
                                <div>
                                    <div class="font-bold text-slate-900">INSTAGRAM</div>
                                    <a href="https://instagram.com/modexdesign" target="_blank" rel="noopener noreferrer" class="text-pink-600 hover:underline">@modexdesign</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">FB</div>
                                <div>
                                    <div class="font-bold text-slate-900">FACEBOOK</div>
                                    <a href="https://facebook.com/modexdesign" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">facebook.com/modexdesign</a>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">LOC</div>
                                <div>
                                    <div class="font-bold text-slate-900">WORKSHOP FACILITY</div>
                                    <span class="text-slate-600">Kyiv Engineering Hub, Ukraine<br>Worldwide Express Courier Delivery</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Accordion -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-2xs">
                        <h3 class="font-heading text-base font-bold text-slate-900 mb-4">Engineering FAQ</h3>
                        
                        <div class="space-y-4 text-xs">
                            <div>
                                <h4 class="font-semibold text-slate-900">What file formats are preferred?</h4>
                                <p class="text-slate-500 mt-1 leading-relaxed">
                                    Native STEP (.step / .stp) is optimal for high-precision parametric geometry. We also accept IGES, STL, OBJ, DXF, KiCAD PCB, and SolidWorks files.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-100">
                                <h4 class="font-semibold text-slate-900">Can you design custom electronics inside the 3D enclosure?</h4>
                                <p class="text-slate-500 mt-1 leading-relaxed">
                                    Yes! As full-stack hardware engineers, we design both custom PCBs in KiCAD and the 3D printed mechanical enclosures around them, ensuring zero clearance clashes.
                                </p>
                            </div>
                            <div class="pt-3 border-t border-slate-100">
                                <h4 class="font-semibold text-slate-900">What tolerances can you hold on printed parts?</h4>
                                <p class="text-slate-500 mt-1 leading-relaxed">
                                    On our industrial calibrated printers, linear tolerances of ±0.05 mm are standard. Critical hole bores can be reamed or fitted with brass threaded inserts for ±0.02 mm precision.
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

</x-layouts.public>

