<x-layouts.public title="Industrial 3D Printing & Materials Matrix" description="Precision 3D printing in PLA and durable PETG. Slicing tolerances, volume pricing, and material specifications.">
    
    <!-- PAGE HERO -->
    <section class="pt-12 pb-10 border-b border-slate-200/80 bg-gradient-to-b from-sky-50/40 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-mono font-medium mb-4">
                    <span>CAPABILITIES // ADDITIVE MANUFACTURING</span>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Precision 3D Printing.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-900 via-sky-700 to-sky-500">Functional PLA &amp; PETG.</span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    We specialize in functional, dimensionally stable prototypes and production parts printed with high-grade PLA and impact-resistant PETG. Calibrated layer adhesion, tight tolerances to ±0.05 mm, and clean surface finishes.
                </p>
            </div>
        </div>
    </section>

    <!-- INTERACTIVE 3D PRINT ESTIMATOR & MATERIAL CALCULATOR -->
    <section class="py-12 border-b border-slate-200 bg-white" 
             x-data="{
                 volume: 85,
                 infill: 40,
                 qty: 1,
                 materialRate: 0.08,
                 materialName: 'PETG Technical',
                 materialTemp: '75°C',
                 setMaterial(name, rate, temp) {
                     this.materialName = name;
                     this.materialRate = rate;
                     this.materialTemp = temp;
                 },
                 get estimatedCost() {
                     const effectiveVol = this.volume * (0.2 + (this.infill / 100) * 0.8);
                     const basePrice = Math.max(15, effectiveVol * this.materialRate);
                     return Math.round(basePrice * this.qty * (this.qty > 5 ? 0.85 : 1));
                 },
                 get turnaroundDays() {
                     if (this.qty > 20) return '3-5 business days';
                     if (this.qty > 5) return '2-3 business days';
                     return '24-48 hours';
                 }
             }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-slate-50 to-sky-50/30 p-6 sm:p-10 shadow-sm">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-200">
                    <div>
                        <div class="text-xs font-mono text-sky-700 font-bold uppercase tracking-wider mb-1">Interactive Tool</div>
                        <h2 class="font-heading text-2xl font-bold text-slate-900">Instant Estimate Calculator</h2>
                        <p class="text-xs text-slate-500 mt-1">Configure part volume and technical polymer to see ballpark pricing and delivery times.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-xs font-mono text-slate-600 font-semibold">PRINTER FLEET: ACTIVE &amp; DISPATCH READY</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Controls Column -->
                    <div class="lg:col-span-7 space-y-6">
                        
                        <!-- Material Selector Pills -->
                        <div>
                            <label class="block text-xs font-mono font-bold text-slate-700 uppercase mb-3">1. Select Polymer Grade (PLA / PETG)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" 
                                        @click="setMaterial('PLA Standard', 0.06, '55°C')"
                                        :class="materialRate === 0.06 ? 'border-sky-500 bg-white shadow-xs ring-2 ring-sky-500/20' : 'border-slate-200 bg-white/70 hover:bg-white'"
                                        class="p-3.5 rounded-xl border text-left cursor-pointer transition-all">
                                    <div class="font-semibold text-xs text-slate-900">PLA Standard</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">High accuracy &amp; clean finish</div>
                                    <div class="text-[11px] text-sky-700 font-mono mt-1 font-bold">$0.06 / cm³</div>
                                </button>
                                
                                <button type="button" 
                                        @click="setMaterial('PLA+ Tough Impact', 0.08, '60°C')"
                                        :class="materialRate === 0.08 && materialName === 'PLA+ Tough Impact' ? 'border-sky-500 bg-white shadow-xs ring-2 ring-sky-500/20' : 'border-slate-200 bg-white/70 hover:bg-white'"
                                        class="p-3.5 rounded-xl border text-left cursor-pointer transition-all">
                                    <div class="font-semibold text-xs text-slate-900">PLA+ Tough</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">Impact-resistant mechanical parts</div>
                                    <div class="text-[11px] text-sky-700 font-mono mt-1 font-bold">$0.08 / cm³</div>
                                </button>
                                
                                <button type="button" 
                                        @click="setMaterial('PETG Technical', 0.08, '75°C')"
                                        :class="materialRate === 0.08 && materialName === 'PETG Technical' ? 'border-sky-500 bg-white shadow-xs ring-2 ring-sky-500/20' : 'border-slate-200 bg-white/70 hover:bg-white'"
                                        class="p-3.5 rounded-xl border text-left cursor-pointer transition-all">
                                    <div class="font-semibold text-xs text-slate-900">PETG Technical</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">Moisture-proof &amp; tough enclosures</div>
                                    <div class="text-[11px] text-sky-700 font-mono mt-1 font-bold">$0.08 / cm³</div>
                                </button>

                                <button type="button" 
                                        @click="setMaterial('PETG Heavy-Duty', 0.10, '80°C')"
                                        :class="materialRate === 0.10 ? 'border-sky-500 bg-white shadow-xs ring-2 ring-sky-500/20' : 'border-slate-200 bg-white/70 hover:bg-white'"
                                        class="p-3.5 rounded-xl border text-left cursor-pointer transition-all">
                                    <div class="font-semibold text-xs text-slate-900">PETG Heavy-Duty</div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">UV &amp; chemical resistance</div>
                                    <div class="text-[11px] text-sky-700 font-mono mt-1 font-bold">$0.10 / cm³</div>
                                </button>
                            </div>
                        </div>

                        <!-- Volume Slider -->
                        <div>
                            <div class="flex justify-between text-xs font-mono mb-1.5">
                                <span class="font-bold text-slate-700 uppercase">2. Estimated Part Volume</span>
                                <span class="text-sky-700 font-bold" x-text="volume + ' cm³ (~' + Math.round(volume * 1.25) + ' grams)'"></span>
                            </div>
                            <input type="range" min="10" max="600" step="5" x-model.number="volume" class="w-full accent-sky-600 cursor-pointer" />
                            <div class="flex justify-between text-[10px] text-slate-400 font-mono mt-1">
                                <span>10 cm³ (Small Bracket)</span>
                                <span>250 cm³ (Sensor Housing)</span>
                                <span>600 cm³ (Full Enclosure)</span>
                            </div>
                        </div>

                        <!-- Infill & Qty -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="flex justify-between text-xs font-mono mb-1.5">
                                    <span class="font-bold text-slate-700 uppercase">3. Infill Density</span>
                                    <span class="text-sky-700 font-bold" x-text="infill + '%'"></span>
                                </div>
                                <input type="range" min="15" max="100" step="5" x-model.number="infill" class="w-full accent-sky-600 cursor-pointer" />
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-mono mb-1.5">
                                    <span class="font-bold text-slate-700 uppercase">4. Quantity</span>
                                    <span class="text-sky-700 font-bold" x-text="qty + ' pcs'"></span>
                                </div>
                                <input type="number" min="1" max="100" x-model.number="qty" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs text-slate-800 bg-white" />
                            </div>
                        </div>

                    </div>

                    <!-- Output Card Column -->
                    <div class="lg:col-span-5">
                        <div class="rounded-2xl bg-white border border-slate-200/90 shadow-md p-6 sm:p-7">
                            <div class="text-[11px] font-mono text-slate-400 uppercase tracking-wider mb-1">CALCULATED ESTIMATE</div>
                            <div class="flex items-baseline gap-2">
                                <span class="font-heading text-4xl font-extrabold text-slate-900" x-text="'$' + estimatedCost"></span>
                                <span class="text-xs text-slate-500 font-mono">USD</span>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-600 font-mono">
                                <div class="flex justify-between">
                                    <span>Selected Material:</span>
                                    <strong class="text-slate-900" x-text="materialName"></strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Heat Deflection:</span>
                                    <strong class="text-sky-600" x-text="materialTemp"></strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Turnaround Time:</span>
                                    <strong class="text-emerald-600" x-text="turnaroundDays"></strong>
                                </div>
                                <div class="flex justify-between">
                                    <span>Dimensional Tolerance:</span>
                                    <strong class="text-slate-900">±0.05 mm (ISO 2768)</strong>
                                </div>
                            </div>

                            <button type="button" 
                                    @click="orderModalOpen = true; selectedService = 'Estimated: ' + materialName + ' (' + volume + 'cm³)'"
                                    class="w-full mt-6 btn-cyan-glow text-white font-semibold py-3 rounded-xl cursor-pointer text-xs uppercase tracking-wider">
                                Order This Specification
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-2.5">
                                Exact pricing finalized upon CAD mesh slice inspection.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- TECHNICAL MATERIALS COMPARISON MATRIX -->
    <section class="py-14 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900">
                    Engineering Material Specifications
                </h2>
                <p class="text-sm text-slate-600 mt-2">
                    Every filament and resin in our workshop is dried in active desiccant chambers and tested on calibrated tensile specimens.
                </p>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-xs">
                <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                    <thead class="bg-slate-100/80 text-slate-900 font-heading text-[11px] uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Polymer Grade</th>
                            <th class="py-3.5 px-4">Tensile Strength</th>
                            <th class="py-3.5 px-4">Heat Deflection (HDT)</th>
                            <th class="py-3.5 px-4">Chemical Resistance</th>
                            <th class="py-3.5 px-4">Key Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-sans">
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">PLA Standard (Bio-Polymer)</td>
                            <td class="py-3.5 px-4 font-mono text-sky-700 font-bold">55 MPa</td>
                            <td class="py-3.5 px-4 font-mono">55°C</td>
                            <td class="py-3.5 px-4">Standard indoor environment, alcohols</td>
                            <td class="py-3.5 px-4 text-slate-600">Visual prototypes, dimensional check jigs, architectural scale models</td>
                        </tr>
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">PLA+ (Tough Enhanced)</td>
                            <td class="py-3.5 px-4 font-mono text-sky-700 font-bold">65 MPa</td>
                            <td class="py-3.5 px-4 font-mono">60°C</td>
                            <td class="py-3.5 px-4">Oils, mild detergents</td>
                            <td class="py-3.5 px-4 text-slate-600">Rigid enclosures, snap-fit assemblies, mechanical brackets</td>
                        </tr>
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">PETG Technical (Functional)</td>
                            <td class="py-3.5 px-4 font-mono text-sky-700 font-bold">52 MPa</td>
                            <td class="py-3.5 px-4 font-mono">75°C</td>
                            <td class="py-3.5 px-4">Water, acids, outdoor exposure</td>
                            <td class="py-3.5 px-4 text-slate-600">Weatherproof electronics enclosures, fluid reservoirs, clips</td>
                        </tr>
                        <tr class="hover:bg-sky-50/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">PETG Heavy-Duty (Structural)</td>
                            <td class="py-3.5 px-4 font-mono text-sky-700 font-bold">58 MPa</td>
                            <td class="py-3.5 px-4 font-mono">80°C</td>
                            <td class="py-3.5 px-4">UV radiation, solvents, mechanical impact</td>
                            <td class="py-3.5 px-4 text-slate-600">Robotic chassis parts, motor mounts, structural hardware</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</x-layouts.public>

