<x-mail::message>
# Reserva cancelada

Olá, {{ $booking->customer_name }}!

Sua reserva para **{{ $booking->tour?->title }}** foi cancelada.

@if($booking->tourDate)
**Data do passeio:** {{ $booking->tourDate->date->format('d/m/Y') }} às {{ substr($booking->tourDate->start_time, 0, 5) }}
@endif

@if($booking->payment_status?->value === 'REFUNDED')
O valor pago será estornado e deve aparecer na sua fatura/conta em alguns dias úteis, conforme o prazo do seu banco ou operadora do cartão.
@endif

@if($booking->cancellation_reason)
**Motivo:** {{ $booking->cancellation_reason }}
@endif

Se tiver qualquer dúvida, é só responder este e-mail.

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>