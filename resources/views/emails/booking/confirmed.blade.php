<x-mail::message>
# {{ $isPaid ? '✅ Reserva confirmada!' : '⏳ Reserva recebida!' }}

Olá, **{{ $customer->name }}**!

@if($isPaid)
Seu pagamento foi aprovado e sua reserva está confirmada. Te esperamos no passeio!
@else
Recebemos sua reserva. Assim que o pagamento for confirmado, você receberá outro e-mail.
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
| Forma de pagamento | {{ strtoupper($booking->payment_method) }} |
| Nº da reserva | `{{ $booking->uuid }}` |

---

## Acesse sua conta

Criamos uma conta para você acompanhar suas reservas. Clique abaixo para definir sua senha e acessar:

<x-mail::button :url="$loginUrl">
Acessar minha conta
</x-mail::button>

Qualquer dúvida, entre em contato com a operadora do passeio diretamente pelo WhatsApp.

Até breve!<br>
{{ config('app.name') }}
</x-mail::message>