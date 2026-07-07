<x-mail::message>
# {{ $isPaid ? '✅ Reserva confirmada!' : '⏳ Reserva recebida!' }}

Olá, **{{ $customer->name }}**!

@if($isPaid)
Seu pagamento foi aprovado e sua reserva está confirmada. Te esperamos no passeio! O voucher está anexado a este e-mail em PDF — apresente no embarque.
@else
Recebemos sua reserva. Assim que o pagamento for confirmado, você receberá outro e-mail com o voucher em anexo.
@endif

---

## Detalhes do passeio

**{{ $tour->title }}**

📅 {{ $date->date->translatedFormat('d \d\e F \d\e Y') }}
🕐 {{ $date->start_time }}{{ $date->end_time ? ' — ' . $date->end_time : '' }}
📍 {{ $tour->boarding_place ?? '' }}

---

## Resumo da reserva

| | |
|---|---|
| Adultos | {{ $booking->adults }} |
@if($booking->children > 0)
| Crianças (meia) | {{ $booking->children }} |
@endif
| Total pago | **R$ {{ number_format($booking->total, 2, ',', '.') }}** |
| Forma de pagamento | {{ match($booking->payment_method) {
    'pix'  => 'PIX',
    'card' => 'Cartão de crédito',
    default => ucfirst($booking->payment_method),
} }} |
| Nº da reserva | `{{ strtoupper(substr($booking->uuid, 0, 8)) }}` |

---

## Acompanhe sua reserva

Clique abaixo para ver os detalhes e status da sua reserva a qualquer momento, sem precisar de senha:

<x-mail::button :url="$magicLink">
Acompanhar minha reserva
</x-mail::button>

Qualquer dúvida, entre em contato com a operadora do passeio diretamente pelo WhatsApp.

Até breve!<br>
{{ config('app.name') }}
</x-mail::message>