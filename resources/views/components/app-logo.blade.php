@props([
    'sidebar' => false,
])

<a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 group focus:outline-hidden']) }}>
    <div class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sky-50 dark:bg-zinc-800 border border-sky-200/80 dark:border-zinc-700 shadow-2xs group-hover:border-sky-400 transition-all">
        <img src="{{ asset('images/modex-icon.png') }}" alt="Modex Icon" class="size-6 object-contain" />
    </div>
    <div class="flex flex-col">
        <span class="font-['Caveat',cursive] text-2xl font-bold text-slate-900 dark:text-white leading-none tracking-wide group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors">Modex</span>
        <span class="text-[9px] text-slate-400 font-sans tracking-wider lowercase">the way you like</span>
    </div>
</a>
