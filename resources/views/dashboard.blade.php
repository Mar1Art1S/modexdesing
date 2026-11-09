<x-layouts::app :title="__('Client Engineering Portal')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        
        <!-- DASHBOARD HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-mono text-sky-700 dark:text-sky-400 font-semibold tracking-wider">LIVE TELEMETRY</span>
                </div>
                <h1 class="font-heading text-2xl font-bold text-zinc-900 dark:text-white">Hardware Projects Dashboard</h1>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Track production status, print telemetry, tolerance reports, and CAD revisions.</p>
            </div>
            <div>
                <a href="{{ route('home') }}" class="btn-cyan-glow text-white text-xs font-semibold px-4 py-2.5 rounded-xl cursor-pointer inline-flex items-center gap-2">
                    <span>+ New Engineering Request</span>
                </a>
            </div>
        </div>

        <!-- STATS KPI METRICS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                <div class="text-[11px] font-mono text-zinc-400 uppercase tracking-wider mb-1">ACTIVE BUILDS</div>
                <div class="font-heading text-2xl font-bold text-zinc-900 dark:text-white">2 <span class="text-xs font-normal text-sky-600">Jobs</span></div>
                <div class="text-[11px] text-emerald-600 mt-1 flex items-center gap-1 font-mono">
                    <span>● 1 on print bed</span>
                    <span class="text-zinc-400">•</span>
                    <span>1 in CAD review</span>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                <div class="text-[11px] font-mono text-zinc-400 uppercase tracking-wider mb-1">PARTS DELIVERED</div>
                <div class="font-heading text-2xl font-bold text-zinc-900 dark:text-white">64 <span class="text-xs font-normal text-zinc-500">units</span></div>
                <div class="text-[11px] text-zinc-500 mt-1 font-mono">100% Quality Passed</div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                <div class="text-[11px] font-mono text-zinc-400 uppercase tracking-wider mb-1">AVERAGE TOLERANCE</div>
                <div class="font-heading text-2xl font-bold text-sky-600 dark:text-sky-400">±0.038 <span class="text-xs font-normal text-zinc-500">mm</span></div>
                <div class="text-[11px] text-zinc-500 mt-1 font-mono">ISO 2768-m Calibrated</div>
            </div>

            <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-2xs">
                <div class="text-[11px] font-mono text-zinc-400 uppercase tracking-wider mb-1">PRIMARY MATERIAL</div>
                <div class="font-heading text-base font-bold text-zinc-900 dark:text-white truncate">PA12-CF Carbon</div>
                <div class="text-[11px] text-zinc-500 mt-1 font-mono">165°C Heat Deflection</div>
            </div>

        </div>

        <!-- ACTIVE BUILD IN PRODUCTION CARD -->
        <div class="rounded-2xl border border-sky-500/40 bg-gradient-to-br from-white via-sky-50/20 to-white dark:from-zinc-900 dark:via-sky-950/20 dark:to-zinc-900 p-6 sm:p-7 shadow-xs">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 pb-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/10 border border-sky-500/30 flex items-center justify-center text-sky-600 dark:text-sky-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs font-mono text-sky-600 dark:text-sky-400 font-bold">JOB #MOD-2026-08 // IN PRODUCTION</div>
                        <h2 class="font-heading text-lg font-bold text-zinc-900 dark:text-white">10kV Substation Busbar Support Housing</h2>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 text-xs font-mono font-semibold">
                        PRINTING: 72%
                    </span>
                    <span class="text-xs text-zinc-500 font-mono">ETA: 4h 15m</span>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="space-y-2 mb-6">
                <div class="flex justify-between text-xs font-mono text-zinc-500">
                    <span>Layer 1,842 of 2,560</span>
                    <span class="text-sky-600 font-semibold">72% Completed</span>
                </div>
                <div class="w-full h-2.5 rounded-full bg-zinc-100 dark:bg-zinc-800 overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-sky-600 to-sky-400 rounded-full shadow-[0_0_12px_#38bdf8]" style="width: 72%"></div>
                </div>
            </div>

            <!-- Telemetry Badges -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-mono text-zinc-600 dark:text-zinc-400">
                <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-400">MACHINE</div>
                    <div class="font-bold text-zinc-900 dark:text-white mt-0.5">CoreXY Ind-01</div>
                </div>
                <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-400">NOZZLE / BED</div>
                    <div class="font-bold text-zinc-900 dark:text-white mt-0.5">310°C / 110°C</div>
                </div>
                <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-400">LAYER HEIGHT</div>
                    <div class="font-bold text-zinc-900 dark:text-white mt-0.5">0.12 mm</div>
                </div>
                <div class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-200/80 dark:border-zinc-700">
                    <div class="text-[10px] text-zinc-400">INSERTS</div>
                    <div class="font-bold text-zinc-900 dark:text-white mt-0.5">M4 Brass (x8)</div>
                </div>
            </div>
        </div>

        <!-- RECENT PRODUCTION LOGS & REVISIONS TABLE -->
        <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-2xs">
            <h3 class="font-heading text-base font-bold text-zinc-900 dark:text-white mb-4">Production Queue &amp; Order History</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-zinc-700 dark:text-zinc-300">
                    <thead class="text-[11px] font-mono text-zinc-400 uppercase tracking-wider border-b border-zinc-100 dark:border-zinc-800">
                        <tr>
                            <th class="py-3 px-3">Order ID</th>
                            <th class="py-3 px-3">Component Name</th>
                            <th class="py-3 px-3">Material</th>
                            <th class="py-3 px-3">Quantity</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800 font-sans">
                        <tr>
                            <td class="py-3.5 px-3 font-mono text-sky-600">#MOD-2026-08</td>
                            <td class="py-3.5 px-3 font-semibold text-zinc-900 dark:text-white">10kV Busbar Modular Insulator</td>
                            <td class="py-3.5 px-3 font-mono">PETG</td>
                            <td class="py-3.5 px-3">4 pcs</td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded bg-sky-100 text-sky-800 dark:bg-sky-950 dark:text-sky-300 font-mono text-[10px] font-semibold">
                                    In Production
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono">
                                <a href="#" class="text-sky-600 hover:underline">Telemetry →</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3.5 px-3 font-mono text-zinc-500">#MOD-2026-07</td>
                            <td class="py-3.5 px-3 font-semibold text-zinc-900 dark:text-white">Tracked Rover Arm Bracket</td>
                            <td class="py-3.5 px-3 font-mono">PLA+</td>
                            <td class="py-3.5 px-3">12 pcs</td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-mono text-[10px] font-semibold">
                                    Delivered
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono">
                                <a href="#" class="text-sky-600 hover:underline">Inspection PDF</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3.5 px-3 font-mono text-zinc-500">#MOD-2026-06</td>
                            <td class="py-3.5 px-3 font-semibold text-zinc-900 dark:text-white">Walking Robot Leg Joint Set</td>
                            <td class="py-3.5 px-3 font-mono">PETG + PLA</td>
                            <td class="py-3.5 px-3">2 sets</td>
                            <td class="py-3.5 px-3">
                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 font-mono text-[10px] font-semibold">
                                    Delivered
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-right font-mono">
                                <a href="#" class="text-sky-600 hover:underline">Re-order</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts::app>
