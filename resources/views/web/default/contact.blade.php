@extends("web.$config->template.master.master")

@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%); min-height: 220px;">

        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, var(--primary) 0%, transparent 50%);"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16">
            <nav class="flex items-center gap-2 text-xs mb-6" style="color: rgba(255,255,255,0.5);">
                <a href="{{ route('web.home') }}" class="hover:text-white transition">Início</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                <span style="color: rgba(255,255,255,0.8);">Atendimento</span>
            </nav>
            <h1 class="text-3xl lg:text-4xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                Fale com a gente
            </h1>
            <p class="text-sm lg:text-base mt-3 max-w-2xl" style="color: rgba(255,255,255,0.65);">
                Tire dúvidas, envie sugestões ou fale sobre parcerias. Nossa equipe responde o mais rápido possível.
            </p>
        </div>

    </section>

    {{-- CONTEÚDO --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Canais de atendimento --}}
            <aside class="space-y-4">

                @if ($config->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $config->whatsapp) }}"
                       target="_blank" rel="noopener"
                       class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all"
                       style="border: 1px solid #e8e4d8;">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.1); color: var(--primary);">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">WhatsApp</p>
                            <p class="text-sm font-bold text-gray-800">{{ $config->whatsapp }}</p>
                            <p class="text-xs text-gray-400 mt-1">Atendimento rápido</p>
                        </div>
                    </a>
                @endif

                @if ($config->email)
                    <a href="mailto:{{ $config->email }}"
                       class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all"
                       style="border: 1px solid #e8e4d8;">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.1); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">E-mail</p>
                            <p class="text-sm font-bold text-gray-800 break-all">{{ $config->email }}</p>
                            <p class="text-xs text-gray-400 mt-1">Resposta em até 1 dia útil</p>
                        </div>
                    </a>
                @endif

                @if ($config->phone || $config->cell_phone)
                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $config->phone ?: $config->cell_phone) }}"
                       class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all"
                       style="border: 1px solid #e8e4d8;">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.1); color: var(--primary);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Telefone</p>
                            <p class="text-sm font-bold text-gray-800">{{ $config->phone ?: $config->cell_phone }}</p>
                            <p class="text-xs text-gray-400 mt-1">Segunda a sexta, 9h às 18h</p>
                        </div>
                    </a>
                @endif

            </aside>

            {{-- Formulário --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 lg:p-10" style="border: 1px solid #e8e4d8;">
                <h2 class="text-xl font-extrabold text-gray-800 mb-1">Envie sua mensagem</h2>
                <p class="text-sm text-gray-500 mb-6">Preencha o formulário e retornaremos o contato.</p>

                <livewire:web.contact-form />
            </div>

        </div>

    </div>
@endsection
