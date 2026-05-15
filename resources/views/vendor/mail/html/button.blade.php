@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

@php
$styles = match($color) {
    'success' => 'background-color:#23c55e; color:#051e34; border-bottom:3px solid #15803d;',
    'gold'    => 'background-color:#fadd37; color:#051e34; border-bottom:3px solid #c4a800;',
    default   => 'background-color:#16a3b7; color:#ffffff; border-bottom:3px solid #0e7a8a;',
};
@endphp

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:24px 0;">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
    <a  {{-- ✅ estava faltando --}}
        href="{{ $url }}"
        target="_blank"
        rel="noopener"
        style="display:inline-block; padding:14px 32px; font-family:Arial,sans-serif; font-size:15px; font-weight:700; text-decoration:none; border-radius:12px; letter-spacing:-0.2px; {{ $styles }}"
    >
        {{ $slot }}
    </a>
</td>
</tr>
</table>
</td>
</tr>
</table>