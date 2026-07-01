@extends("web.$config->template.master.master")

@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, #0a3358 100%); min-height: 220px;">

        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 80% 50%, var(--teal) 0%, transparent 50%);"></div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden" style="line-height: 0;">
            <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display: block; width: 100%; height: 60px;">
                <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#fafaf8"/>
            </svg>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">
            <nav class="flex items-center gap-2 text-xs mb-6" style="color: rgba(255,255,255,0.5);">
                <a href="{{ route('web.home') }}" class="hover:text-white transition">Início</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
                <span style="color: rgba(255,255,255,0.8);">Preferências de Cookies</span>
            </nav>
            <h1 class="text-3xl font-800 text-white" style="font-family: 'Syne', sans-serif;">
                Preferências de Cookies
            </h1>
            <p class="text-sm mt-2" style="color: rgba(255,255,255,0.6);">
                Atualizado em {{ now()->format('d/m/Y') }}
            </p>
        </div>

    </section>

    {{-- CONTEÚDO --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="bg-white rounded-3xl p-8 lg:p-12" style="border: 1px solid #e8e4d8;">
            <div class="prose prose-slate max-w-none"
                 style="color: #444; line-height: 1.8; font-size: 0.95rem;">
                {!! $config->cookies_preference !!}
            </div>
        </div>

        {{-- Voltar --}}
        <div class="mt-8 text-center">
            <a href="{{ route('web.home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold transition"
               style="background: white; color: var(--navy); border: 1.5px solid #e8e4d8;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar ao início
            </a>
        </div>

    </div>

@endsection

@push('styles')
<style>
    .prose h2 { font-size: 1.25rem; font-weight: 700; margin: 1.5rem 0 0.75rem; color: #051e34; }
    .prose h3 { font-size: 1.1rem; font-weight: 600; margin: 1.25rem 0 0.5rem; color: #051e34; }
    .prose ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .prose li { margin-bottom: 0.35rem; }
    .prose a  { color: var(--primary); text-decoration: underline; }
</style>
@endpush