@props(['active', 'label'])

@php
$classes = ($active ?? false)
? 'bg-slate-800/80 text-emerald-400 border-r-2 border-emerald-500 font-semibold'
: 'text-slate-400 hover:bg-slate-800/40 hover:text-slate-200 border-r-2 border-transparent';
@endphp

<a {{ $attributes->merge(['class' => 'flex items-center px-6 py-3 transition-all duration-300 group ' . $classes]) }} wire:navigate>
    <div class="shrink-0 flex items-center justify-center transition-colors duration-300 group-hover:text-emerald-400">
        {{ $icon }}
    </div>
    <span x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-x-2"
        class="ms-4 text-sm tracking-wide whitespace-nowrap">
        {{ $label }}
    </span>
</a>