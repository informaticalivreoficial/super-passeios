@props(['url'])
<tr>
    <td align="center" style="background: linear-gradient(135deg, #051e34 0%, #0a3358 60%, #0e4a7a 100%); padding: 0;">

        <div style="padding: 28px 40px; text-align: center;">
            <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
                @if (trim($slot) === 'Laravel')
                    <img src="https://laravel.com/img/notification-logo.png" alt="Laravel" style="height: 40px; width: auto; border: 0;">
                @elseif (config('app.logomarca'))
                    <img src="{{ config('app.logomarca') }}" alt="{{ config('app.name') }}" style="height: 40px; width: auto; border: 0;">
                @else
                    <span style="font-size: 22px; font-weight: 800; color: #ffffff; font-family: Arial, sans-serif; letter-spacing: -0.5px;">
                        {{ $slot }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Faixa decorativa --}}
        <div style="height: 4px; background: linear-gradient(90deg, #16a3b7 0%, #fadd37 50%, #16a3b7 100%);"></div>

    </td>
</tr>