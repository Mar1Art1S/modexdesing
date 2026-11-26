@php
    $members = [
        [
            'name' => 'Dmytro Matiikiv',
            'role' => 'FOUNDER',
            'image' => 'images/photo1/photo2.jpg',
            'alt_image' => 'images/photo1/photo2.png',
        ],
        [
            'name' => 'Oleg Livinsky',
            'role' => 'CAD / FDM EXPERT',
            'image' => 'images/photo1/photo1.jpg',
            'alt_image' => 'images/photo1/photo1.png',
        ],
    ];

    if (file_exists(public_path('images/photo1/photo3.png')) || file_exists(public_path('images/photo1/photo3.jpg')) || file_exists(base_path('images/photo1/photo3.jpg'))) {
        $members[] = [
            'name' => 'Michal Gabanyi',
            'role' => 'SLA EXPERT',
            'image' => 'images/photo1/photo3.jpg',
            'alt_image' => 'images/photo1/photo3.png',
        ];
    }

    $colCount = count($members);
@endphp

<!-- ============================================================ -->
<!-- SECTION: OUR TEAM (PHOTO1 SHOWCASE)                          -->
<!-- ============================================================ -->
<section id="team" class="py-20 lg:py-28 bg-white relative border-t-2 border-slate-900 overflow-hidden" data-aos="fade-up" data-aos-duration="600">
    
    <!-- Ambient Blueprint Grid Overlay -->
    <div class="absolute inset-0 bg-blueprint-grid opacity-20 pointer-events-none"></div>

    <!-- Technical Corner Markers -->
    <span class="absolute top-4 left-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
    <span class="absolute top-4 right-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
    <span class="absolute bottom-4 left-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>
    <span class="absolute bottom-4 right-6 text-slate-400 font-mono text-sm font-bold select-none opacity-40">+</span>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header with Circle Icon -->
        <div class="text-center max-w-2xl mx-auto mb-14 sm:mb-16">
            <!-- Icon Badge (Round user icon) -->
            <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto rounded-full bg-slate-100 border-2 border-slate-900 flex items-center justify-center text-slate-900 mb-6 shadow-sm">
                <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>

            <!-- Title -->
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight uppercase">
                OUR TEAM
            </h2>

            <!-- Subtitle -->
            <p class="text-base sm:text-lg text-slate-600 mt-4 leading-relaxed font-sans">
                We are a group of experienced professionals ready to help your ideas grow.
            </p>
        </div>

        <!-- Team Members Grid -->
        <div class="mx-auto {{ $colCount === 2 ? 'max-w-3xl grid grid-cols-1 sm:grid-cols-2 gap-10 sm:gap-14' : 'max-w-5xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 sm:gap-12' }} justify-center items-center">
            @foreach ($members as $member)
                <div class="flex flex-col items-center text-center group" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    
                    <!-- Circular Portrait Image Container -->
                    <div class="w-48 h-48 sm:w-56 sm:h-56 lg:w-60 lg:h-60 rounded-full overflow-hidden border-4 border-slate-900 bg-slate-100 shadow-xl group-hover:scale-105 group-hover:border-sky-600 group-hover:shadow-2xl transition-all duration-300 relative">
                        <img src="{{ asset($member['image']) }}?v=2" 
                             onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src = '{{ asset($member['alt_image']) }}?v=2'; } else if (this.dataset.tried === '1') { this.dataset.tried = '2'; this.src = '/{{ $member['image'] }}?v=2'; }"
                             alt="{{ $member['name'] }} - {{ $member['role'] }}" 
                             class="w-full h-full object-cover object-center grayscale hover:grayscale-0 transition-all duration-500" />
                    </div>

                    <!-- Member Name -->
                    <h3 class="font-heading text-xl sm:text-2xl font-black text-slate-900 mt-6 tracking-tight">
                        {{ $member['name'] }}
                    </h3>

                    <!-- Member Role / Title -->
                    <p class="text-xs sm:text-sm font-mono font-bold uppercase tracking-widest text-amber-600 mt-2">
                        {{ $member['role'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>
