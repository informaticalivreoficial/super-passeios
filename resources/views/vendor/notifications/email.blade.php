<x-mail::message>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# Oops!
@else
# Olá!
@endif
@endif

{{-- Intro --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Button --}}
@isset($actionText)

@php
$color = match ($level) {
    'success', 'error' => $level,
    default => 'primary',
};
@endphp

<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>

@endisset

{{-- Outro --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Manual URL --}}
@isset($actionText)
<br>
<p style="font-size:12px; color:#87c2c0; line-height:1.6; margin:0 0 6px;">
    Caso o botão não funcione, copie e cole o link abaixo no seu navegador:
</p>
<p style="font-size:11px; word-break:break-all; margin:0;">
    <a href="{{ $actionUrl }}" style="color:#16a3b7; text-decoration:none;">
        {{ $displayableActionUrl }}
    </a>
</p>
@endisset

{{-- Salutation --}}
<br>

@if (! empty($salutation))
{{ $salutation }}
@else
Atenciosamente,
<strong>{{ config('app.name') }}</strong>
@endif

</x-mail::message>