<x-layouts.public title="Engineering Projects & Hardware Portfolio" description="Case studies of custom technical engineering, 3D printing, robotics, and full-stack physical hardware products.">
    
    <!-- PAGE HERO -->
    <section class="pt-12 pb-10 border-b border-slate-200/80 bg-gradient-to-b from-sky-50/40 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-200 text-sky-700 text-xs font-mono font-medium mb-4">
                    <span>CASE STUDIES // FULL-STACK HARDWARE</span>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Engineered from Scratch.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-900 via-sky-700 to-sky-500">Built to Perform.</span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    A curated portfolio of high-load mechanical parts, electrical isolation modules, robotic assemblies, and sealed sensor enclosures developed from concept sketches to functional deployment.
                </p>
            </div>
        </div>
    </section>

    <!-- PROJECTS GALLERY WITH FILTERING -->
    <section class="py-12 lg:py-16" x-data="{ currentFilter: 'all' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2 mb-10 pb-4 border-b border-slate-200">
                <button type="button" 
                        @click="currentFilter = 'all'" 
                        :class="currentFilter === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all cursor-pointer">
                    All Projects (6)
                </button>
                <button type="button" 
                        @click="currentFilter = 'industrial'" 
                        :class="currentFilter === 'industrial' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all cursor-pointer">
                    Industrial &amp; Energy
                </button>
                <button type="button" 
                        @click="currentFilter = 'robotics'" 
                        :class="currentFilter === 'robotics' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all cursor-pointer">
                    Robotics &amp; Mechanics
                </button>
                <button type="button" 
                        @click="currentFilter = 'mechatronics'" 
                        :class="currentFilter === 'mechatronics' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all cursor-pointer">
                    Mechatronics &amp; R&amp;D
                </button>
                <button type="button" 
                        @click="currentFilter = 'tooling'" 
                        :class="currentFilter === 'tooling' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all cursor-pointer">
                    Manufacturing Jigs
                </button>
            </div>

            <!-- PROJECTS GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- PROJECT 1: 10kV Busbar Substation Modular Isolator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'industrial'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 01</span>
                            <span class="text-sky-600 font-semibold uppercase">ENERGY</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            10kV Busbar Modular Insulator
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Flame-retardant high-voltage busbar support brackets engineered with internal dielectric ribs to eliminate electrical arcing under high load.
                        </p>
                    </div>

                    <!-- Image Slot: Displays user's zas.jpg cover -->
                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/zas.jpg') }}" 
                             alt="10kV Busbar Modular Insulator" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>MATERIAL:</strong> PETG Technical</div>
                            <div><strong>TOLERANCE:</strong> ±0.04 mm</div>
                            <div><strong>TEMP PEAK:</strong> 85°C</div>
                            <div><strong>PROCESS:</strong> Precision FDM</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = '10kV Busbar Insulator Build'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

                <!-- PROJECT 2: Autonomous Tracked Rover with Robotic Manipulator -->
                <div x-show="currentFilter === 'all' || currentFilter === 'robotics'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 02</span>
                            <span class="text-sky-600 font-semibold uppercase">ROBOTICS &amp; CAD</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            Autonomous Tracked Rover with Manipulator
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            End-to-end design from engineering sketch to functioning prototype: reinforced tracked chassis, 6-axis 3D-printed manipulator arm, and sensor payload.
                        </p>
                    </div>

                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/zas2.jpg') }}" 
                             alt="Autonomous Tracked Rover with Robotic Manipulator" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>MATERIAL:</strong> PETG + PLA</div>
                            <div><strong>CHASSIS:</strong> All-Terrain Tracks</div>
                            <div><strong>ARM:</strong> 6-DOF Servo Joint</div>
                            <div><strong>TOLERANCE:</strong> ±0.04 mm</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Tracked Rover with Manipulator Project'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

                <!-- PROJECT 3: Full-Cycle Walking Robot (Draft to Assembly) -->
                <div x-show="currentFilter === 'all' || currentFilter === 'mechatronics' || currentFilter === 'iot'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 03</span>
                            <span class="text-sky-600 font-semibold uppercase">MECHATRONICS &amp; R&amp;D</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            Full-Cycle Walking Robot (Draft to Assembly)
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Modex 4-stage turnkey development: engineering math and hand drafting, parametric 3D CAD simulation, FDM 3D printing of joints, and electromechanical assembly.
                        </p>
                    </div>

                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('images/zas3.jpg') }}" 
                             alt="Full-Cycle Walking Robot Development: Drafting, CAD, 3D Printing, Assembly" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>MATERIAL:</strong> Tough PETG + PLA</div>
                            <div><strong>KINEMATICS:</strong> 12-DOF Gait</div>
                            <div><strong>SENSORS:</strong> Sonar + MCU</div>
                            <div><strong>TOLERANCE:</strong> ±0.05 mm</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Full-Cycle Walking Robot Project'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

                <!-- PROJECT 4: Custom CNC Vacuum Fixture Plate -->
                <div x-show="currentFilter === 'all' || currentFilter === 'tooling'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 04</span>
                            <span class="text-sky-600 font-semibold uppercase">TOOLING &amp; JIGS</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            CNC Internal Vacuum Chuck
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            3D printed conformal vacuum routing plate designed to secure delicate carbon-fiber sheet stock during multi-axis CNC surface milling.
                        </p>
                    </div>

                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <div class="w-full h-full p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 to-sky-50/50">
                            <svg class="w-20 h-20 text-sky-600" viewBox="0 0 100 80" fill="none" stroke="currentColor">
                                <rect x="15" y="25" width="70" height="35" rx="3" stroke="#475569" stroke-width="2" fill="#e2e8f0" />
                                <line x1="25" y1="35" x2="75" y2="35" stroke="#0ea5e9" stroke-width="1.5" stroke-dasharray="3 3" />
                                <line x1="25" y1="45" x2="75" y2="45" stroke="#0ea5e9" stroke-width="1.5" stroke-dasharray="3 3" />
                                <circle cx="30" cy="40" r="3" fill="#0284c7" />
                                <circle cx="50" cy="40" r="3" fill="#0284c7" />
                                <circle cx="70" cy="40" r="3" fill="#0284c7" />
                            </svg>
                            <span class="text-[11px] font-mono text-slate-500 mt-1">Conformal Internal Air Channels</span>
                        </div>
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>MATERIAL:</strong> Solid PETG (100% Infill)</div>
                            <div><strong>VACUUM:</strong> -0.85 bar sealed</div>
                            <div><strong>FLATNESS:</strong> 0.05 mm fly-cut</div>
                            <div><strong>CYCLE:</strong> 250+ Machining Hours</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'CNC Tooling Jig'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

                <!-- PROJECT 5: Drone Gimbal Quick-Release Mount -->
                <div x-show="currentFilter === 'all' || currentFilter === 'robotics'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 05</span>
                            <span class="text-sky-600 font-semibold uppercase">AEROSPACE</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            Anti-Vibration Gimbal Latch
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Snap-locking modular camera bracket combining carbon fiber composite rigidity with cast urethane damping balls to filter motor harmonics.
                        </p>
                    </div>

                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <div class="w-full h-full p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 to-sky-50/50">
                            <svg class="w-20 h-20 text-sky-600" viewBox="0 0 100 80" fill="none" stroke="currentColor">
                                <circle cx="50" cy="40" r="28" stroke="#334155" stroke-width="2" fill="#f1f5f9" />
                                <circle cx="35" cy="30" r="4" fill="#0ea5e9" />
                                <circle cx="65" cy="30" r="4" fill="#0ea5e9" />
                                <circle cx="50" cy="55" r="4" fill="#0ea5e9" />
                                <rect x="42" y="32" width="16" height="16" rx="2" stroke="#0f172a" stroke-width="2" />
                            </svg>
                            <span class="text-[11px] font-mono text-slate-500 mt-1">Harmonic Damping Matrix</span>
                        </div>
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>WEIGHT:</strong> 42 grams total</div>
                            <div><strong>DAMPING:</strong> 22 Hz Resonant Cutoff</div>
                            <div><strong>MATERIAL:</strong> PA6-CF + Silicone 40A</div>
                            <div><strong>LOCK:</strong> Push-to-Eject</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Drone Gimbal Mount'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

                <!-- PROJECT 6: High-Temp Lab Centrifuge Rotor Adapter -->
                <div x-show="currentFilter === 'all' || currentFilter === 'industrial'"
                     class="card-tech-glow rounded-2xl bg-white border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group">
                    <div class="p-6">
                        <div class="flex items-center justify-between text-xs font-mono text-slate-400 mb-2">
                            <span>PRJ // 06</span>
                            <span class="text-sky-600 font-semibold uppercase">BIOMEDICAL</span>
                        </div>
                        <h3 class="font-heading text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors">
                            Chemical Centrifuge Adapter
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Autoclavable test tube inserts printed in medical-grade PEEK polymer capable of withstanding 12,000 RPM centrifugal g-force and 134°C sterilization cycles.
                        </p>
                    </div>

                    <div class="mx-6 relative h-48 rounded-xl bg-slate-50 border border-slate-200 overflow-hidden flex items-center justify-center">
                        <div class="w-full h-full p-4 flex flex-col items-center justify-center bg-gradient-to-br from-slate-50 to-sky-50/50">
                            <svg class="w-20 h-20 text-sky-600" viewBox="0 0 100 80" fill="none" stroke="currentColor">
                                <ellipse cx="50" cy="40" rx="36" ry="24" stroke="#475569" stroke-width="2" fill="#e2e8f0" />
                                <ellipse cx="32" cy="38" rx="8" ry="12" stroke="#0ea5e9" stroke-width="2" fill="#ffffff" />
                                <ellipse cx="68" cy="38" rx="8" ry="12" stroke="#0ea5e9" stroke-width="2" fill="#ffffff" />
                                <ellipse cx="50" cy="42" rx="7" ry="10" stroke="#0284c7" stroke-width="2" fill="#ffffff" />
                            </svg>
                            <span class="text-[11px] font-mono text-slate-500 mt-1">PEEK Autoclave 134°C</span>
                        </div>
                    </div>

                    <div class="p-6 pt-4 border-t border-slate-100 mt-4 bg-slate-50/50">
                        <div class="grid grid-cols-2 gap-2 text-[11px] font-mono text-slate-600 mb-4">
                            <div><strong>MATERIAL:</strong> Pure PEEK Polymer</div>
                            <div><strong>G-FORCE:</strong> 15,000 × g rated</div>
                            <div><strong>STERILIZATION:</strong> Steam Autoclave</div>
                            <div><strong>BIO:</strong> ISO 10993 Cytotoxicity</div>
                        </div>
                        <button type="button" 
                                @click="orderModalOpen = true; selectedService = 'Laboratory PEEK Adapter'"
                                class="w-full py-2.5 rounded-xl border border-sky-500/80 bg-white hover:bg-sky-50 text-sky-700 text-xs font-semibold shadow-2xs transition-all cursor-pointer">
                            Request Technical Specs →
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </section>

</x-layouts.public>

