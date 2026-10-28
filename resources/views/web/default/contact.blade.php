@extends("web.$config->template.master.master")

@section('content')

    @php
        $whatsapp = preg_replace('/\D/', '', (string) $config->whatsapp);
        $telefone = $config->phone ?: $config->cell_phone;
        $telefoneDigitos = preg_replace('/\D/', '', (string) $telefone);
        $mostrarTelefone = $telefone && $telefoneDigitos !== $whatsapp;
    @endphp

    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, #1e40af 0%, #2563eb 40%, #3b82f6 100%); padding: 64px 0 88px;">

        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-16 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-8 right-10 w-96 h-96 bg-blue-200 rounded-full blur-3xl"></div>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 80px;">
                <path d="M0,40 C320,80 640,0 960,40 C1280,80 1440,20 1440,20 L1440,80 L0,80 Z" fill="#EEF4FB"/>
            </svg>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <nav class="flex items-center justify-center gap-2 text-xs mb-6" style="color: rgba(255,255,255,0.6);">
                <a href="{{ route('web.home') }}" class="hover:text-white transition">Início</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                <span style="color: rgba(255,255,255,0.9);">Atendimento</span>
            </nav>

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur border border-white/30 text-white text-sm font-semibold mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                Atendimento
            </div>

            <h1 class="text-3xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight">
                Como podemos <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-yellow-200">ajudar?</span>
            </h1>

            <p class="text-base lg:text-lg text-blue-100 max-w-2xl mx-auto">
                Tire dúvidas, envie sugestões ou fale sobre parcerias. Nossa equipe responde o mais rápido possível.
            </p>
        </div>
    </section>

    {{-- CONTEÚDO --}}
    <section class="py-12 lg:py-16" style="background: linear-gradient(180deg, #EEF4FB 0%, #F8FAFC 100%);">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid lg:grid-cols-5 gap-6 lg:gap-8">

                {{-- Canais de atendimento --}}
                <aside class="lg:col-span-2">
                    <div class="rounded-3xl p-7 sm:p-8 text-white relative overflow-hidden lg:sticky lg:top-20"
                         style="background: linear-gradient(160deg, #0f172a 0%, #12304f 100%);">

                        <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full opacity-20 blur-2xl" style="background: #3b82f6;"></div>

                        <div class="relative">
                            <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: #93c5fd;">
                                Canais de atendimento
                            </p>
                            <h2 class="text-2xl font-extrabold mb-2">Fale direto com agente</h2>
                            <p class="text-sm mb-7" style="color: #b8d4e8;">
                                Prefere conversar por outro canal? Estamos por aqui.
                            </p>
                        </div>

                        <div class="relative space-y-3">

                            @if ($whatsapp)
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener"
                                   class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:translate-x-1"
                                   style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                                    <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.25); color: #93c5fd;">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wider" style="color: #93c5fd;">WhatsApp</span>
                                        <span class="block text-sm font-bold">{{ $config->whatsapp }}</span>
                                    </span>
                                </a>
                            @endif

                            @if ($config->email)
                                <a href="mailto:{{ $config->email }}"
                                   class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:translate-x-1"
                                   style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                                    <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.25); color: #93c5fd;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold uppercase tracking-wider" style="color: #93c5fd;">E-mail</span>
                                        <span class="block text-sm font-bold break-words">{{ $config->email }}</span>
                                    </span>
                                </a>
                            @endif

                            @if ($mostrarTelefone)
                                <a href="tel:{{ $telefoneDigitos }}"
                                   class="flex items-center gap-4 p-4 rounded-2xl transition-all hover:translate-x-1"
                                   style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
                                    <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.25); color: #93c5fd;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wider" style="color: #93c5fd;">Telefone</span>
                                        <span class="block text-sm font-bold">{{ $telefone }}</span>
                                    </span>
                                </a>
                            @endif

                        </div>

                        <div class="relative pt-7">
                            <div class="pt-5 space-y-2 text-xs" style="border-top: 1px solid rgba(255,255,255,0.1); color: #9fb8cd;">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    Segunda a sexta, 9h às 18h
                                </p>
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
                                    Resposta em até 1 dia útil
                                </p>
                            </div>

                            @if ($whatsapp)
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener"
                                   class="mt-5 w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold transition-all hover:scale-[1.02]"
                                   style="background: #2563eb; color: #fff;">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    Conversar no WhatsApp
                                </a>
                            @endif
                        </div>

                    </div>
                </aside>

                {{-- Formulário --}}
                <div class="lg:col-span-3">
                    <div class="h-full bg-white rounded-3xl p-6 sm:p-8 lg:p-10 shadow-sm" style="border: 1px solid #e2e8f0;">
                        <div class="flex items-start gap-4 mb-7">
                            <span class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.1); color: #2563eb;">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div>
                                <h2 class="text-xl font-extrabold text-gray-800">Envie sua mensagem</h2>
                                <p class="text-sm text-gray-500 mt-1">Preencha os campos abaixo e retornaremos pelo e-mail informado.</p>
                            </div>
                        </div>

                        <livewire:web.contact-form />
                    </div>
                </div>

            </div>

            {{-- Garantias --}}
            <div class="grid sm:grid-cols-3 gap-4 mt-8">
                @foreach ([
                    ['M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'Resposta rápida', 'Retornamos em até 1 dia útil.'],
                    ['M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'Atendimento humano', 'Sem robôs: quem responde é a nossa equipe.'],
                    ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z M9 12l2 2 4-4', 'Dados protegidos', 'Suas informações não são compartilhadas.'],
                ] as [$icone, $titulo, $texto])
                    <div class="flex items-start gap-3 p-5 bg-white rounded-2xl" style="border: 1px solid #e2e8f0;">
                        <span class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(37,99,235,0.08); color: #2563eb;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $icone }}"/></svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $titulo }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $texto }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
