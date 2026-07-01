@extends("web.$config->template.master.master")

@section('content')
<div class="max-w-lg mx-auto text-center py-24 px-4">
    <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-6"
         style="background: rgba(239,68,68,0.1);">
        <svg class="w-8 h-8" style="color: #dc2626;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold mb-3" style="color: var(--navy);">Inscrição cancelada</h1>
    <p class="text-sm mb-6" style="color: #87c2c0;">
        Você foi removido da nossa lista de e-mails. Sentiremos sua falta!
    </p>
    <a href="{{ route('web.home') }}" class="btn-primary text-sm">
        Voltar ao início
    </a>
</div>
@endsection