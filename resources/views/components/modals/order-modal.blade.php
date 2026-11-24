<!-- ============================================================ -->
<!-- UNIVERSAL "ORDER A PROJECT" MODAL DIALOG                     -->
<!-- ============================================================ -->
<div x-show="orderModalOpen" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    
    <div x-show="orderModalOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
         @click="orderModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="orderModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 p-6 sm:p-8">
            
            <button type="button" 
                    @click="orderModalOpen = false; submitted = false"
                    class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <template x-if="!submitted">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        
                        <span class="text-xs font-mono text-sky-700 font-semibold tracking-wider">FULL-STACK INTAKE</span>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900" id="modal-title">
                        
                        Order a Technical Project
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        
                        Submit CAD models, electrical requirements, or concept sketches for immediate DFM and cost estimation.
                    </p>

                    <form @submit.prevent="submitted = true" class="mt-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                
                                Primary Scope
                            </label>
                            <select x-model="selectedService" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50">
                                
                                <optgroup label="Select Order Stage">
                                        <option value="Order (Drawing / Photo of part)">1. Order (Drawing / Photo of part)</option>
                                        <option value="3D CAD Modeling from scratch">2. 3D CAD Modeling from scratch</option>
                                        <option value="3D Print Job (Ready STL/STEP file)">3. 3D Print Job (Ready STL/STEP file)</option>
                                        <option value="Ready Model / Batch Production">4. Ready Model / Batch Production</option>
                                    </optgroup>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                    
                                    Name
                                </label>
                                <input type="text" required :placeholder="'Alex Miller'" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                    
                                    Email / Phone
                                </label>
                                <input type="text" required :placeholder="'alex@tech.com'" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                
                                Technical Brief &amp; Tolerances
                            </label>
                            <textarea rows="3" :placeholder="'Target material (PLA, PETG), color, infill, operating environment, or batch volume...'" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm text-slate-800 focus:outline-hidden focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 bg-slate-50/50"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                                
                                Upload 3D CAD / PCB Files
                            </label>
                            <div class="rounded-xl border border-dashed border-slate-300 p-3 text-center bg-slate-50/60 hover:bg-sky-50/40 transition-colors">
                                <input type="file" multiple class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-sky-600 file:text-white hover:file:bg-sky-700 cursor-pointer" />
                                
                                <p class="text-[11px] text-slate-400 mt-1">Accepts STL, STEP, IGES, OBJ, DXF, Gerber, or PDF (up to 100MB)</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full btn-cyan-glow text-white font-semibold py-3 px-5 rounded-xl cursor-pointer text-sm">
                                
                                Submit Technical Request
                            </button>
                        </div>
                    </form>
                </div>
            </template>

            <template x-if="submitted">
                <div class="text-center py-6">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-slate-900">
                        
                        Engineering Brief Received
                    </h3>
                    <p class="text-sm text-slate-600 mt-2 max-w-sm mx-auto">
                        
                        Your specifications have been queued for DFM review. Our lead engineer will provide a feasibility report within 24 hours.
                    </p>
                    <button type="button" 
                            @click="orderModalOpen = false; submitted = false"
                            class="mt-6 px-6 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition-colors cursor-pointer">
                        
                        Close
                    </button>
                </div>
            </template>

        </div>
    </div>
</div>
