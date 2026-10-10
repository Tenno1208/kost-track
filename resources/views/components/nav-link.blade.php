@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold bg-[#174D3A] text-white shadow-sm'
    : 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#777D75] hover:bg-[#F8F7F2] hover:text-[#242923] transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>