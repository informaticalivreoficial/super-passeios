Contato via site

Nome: {{ $nome }}
E-mail: {{ $email }}
@if (!empty($whatsapp))
WhatsApp: {{ $whatsapp }}
@endif
Recebido em: {{ now()->format('d/m/Y H:i') }}

Mensagem:
{{ $mensagem }}

Responder: {{ $email }}

--
{{ config('mail.from.name') }}
