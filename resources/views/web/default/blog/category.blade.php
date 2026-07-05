@extends("web.$config->template.master.master")

@section('content')
<div class="voyage-article">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">

        {{-- Cabeçalho da categoria --}}
        <div class="mb-12 sm:mb-14 fade-up">
            <a href="{{ route('web.blog.index') }}" class="voyage-back mb-6">
                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 4l-6 6 6 6"/>
                </svg>
                VOLTAR PARA O BLOG
            </a>

            <h1 class="display text-4xl sm:text-5xl font-medium leading-[1.1] mt-3 mb-3" style="color: var(--ink);">
                {{ $category->title }}
            </h1>

            <p class="voyage-meta-item text-sm">
                {{ $articles->total() }} {{ $articles->total() == 1 ? 'ARTIGO ENCONTRADO' : 'ARTIGOS ENCONTRADOS' }}
            </p>
        </div>

        {{-- Grid de artigos --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($articles as $article)
                
                <a    href="{{ route('web.blog.show', $article->slug) }}"
                    class="voyage-card group flex flex-col fade-up"
                >
                    <div class="relative aspect-[16/10] overflow-hidden shrink-0">
                        <img
                            src="{{ $article->cover() ?? asset('images/placeholder-blog.jpg') }}"
                            alt="{{ $article->title }}"
                            class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110"
                        >

                        @if($article->category)
                            <div class="absolute bottom-4 left-4">
                                <span class="voyage-tag">
                                    {{ $article->categoryObject->title }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="voyage-card-divider"></div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="display text-xl font-medium mb-3 line-clamp-2" style="color: var(--ink);">
                            {{ $article->title }}
                        </h3>

                        @if($article->excerpt)
                            <p class="mb-5 text-[15px] leading-7 line-clamp-3" style="color: var(--ink-soft);">
                                {{ $article->excerpt }}
                            </p>
                        @endif

                        <div class="mt-auto flex items-center justify-between pt-4" style="border-top: 1px dashed var(--line);">
                            <div class="flex items-center gap-3 voyage-meta-item">
                                <span>{{ $article->publish_at ?? $article->created_at->format('d/m/Y') }}</span>
                                @if($article->readingTime)
                                    <span>&middot;</span>
                                    <span>{{ $article->readingTime }} MIN</span>
                                @endif
                            </div>

                            <span class="voyage-cta">
                                LER
                                <svg width="14" height="14" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-20 text-center rounded-2xl" style="border: 2px dashed var(--line);">
                    <p style="color: var(--ink-soft);">Nenhum artigo nessa categoria ainda.</p>
                </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        @if($articles->hasPages())
            <div class="mt-14 voyage-pagination">
                {{ $articles->links('vendor.pagination.voyage') }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,500&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

<style>
    .voyage-article {
        --ink: #16302f;
        --ink-soft: #4a5f5d;
        --paper: #efe7d6;
        --card: #fffdf8;
        --teal: #0e7c86;
        --teal-deep: #0a5a62;
        --coral: #c1602f;
        --line: #d8cdb2;
        --font-display: 'Fraunces', serif;
        --font-body: 'Inter', sans-serif;
        --font-mono: 'IBM Plex Mono', monospace;

        background: var(--paper);
        color: var(--ink);
        font-family: var(--font-body);
    }

    .voyage-article .eyebrow-tag {
        font-family: var(--font-mono);
        letter-spacing: 0.08em;
    }

    .voyage-article .display {
        font-family: var(--font-display);
        letter-spacing: -0.01em;
    }

    .voyage-meta-item {
        font-family: var(--font-mono);
        font-size: .75rem;
        color: var(--ink-soft);
    }

    .voyage-back {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-family: var(--font-mono);
        font-size: .75rem;
        letter-spacing: .04em;
        color: var(--ink-soft);
        text-decoration: none;
        transition: color .2s ease, gap .2s ease;
    }
    .voyage-back:hover { color: var(--teal-deep); gap: .6rem; }
    .voyage-back svg { transition: transform .2s ease; }
    .voyage-back:hover svg { transform: translateX(-2px); }

    .voyage-tag {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .35rem 1rem .35rem 1.5rem;
        background: var(--coral);
        color: #fff9f2;
        font-family: var(--font-mono);
        font-size: .68rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        border-radius: 3px 10px 10px 3px;
    }
    .voyage-tag::before {
        content: '';
        position: absolute;
        left: 8px; top: 50%;
        width: 6px; height: 6px;
        background: var(--paper);
        border-radius: 50%;
        transform: translateY(-50%);
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.15);
    }

    .voyage-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 20px;
        overflow: hidden;
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .voyage-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(22,48,47,0.12);
        border-color: var(--teal);
    }

    .voyage-card-divider { border-top: 2px dashed var(--line); }

    .voyage-cta {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        color: var(--teal-deep);
        font-family: var(--font-mono);
        font-size: .72rem;
        letter-spacing: .05em;
        text-transform: uppercase;
    }
    .voyage-card:hover .voyage-cta { color: var(--coral); }
    .voyage-cta svg { transition: transform .3s ease; }
    .voyage-card:hover .voyage-cta svg { transform: translateX(3px); }

    /* Paginação */
    .voyage-pagination { font-family: var(--font-mono); }
    .voyage-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 .6rem;
        border-radius: 50%;
        border: 1px solid var(--line);
        background: var(--card);
        color: var(--ink-soft);
        font-size: .8rem;
        text-decoration: none;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
    }
    .voyage-page-btn:hover { border-color: var(--teal); color: var(--teal-deep); }
    .voyage-page-btn.is-current {
        background: var(--teal);
        border-color: var(--teal);
        color: #fffdf8;
        font-weight: 600;
    }
    .voyage-page-btn.is-dots { border: none; background: transparent; color: var(--ink-soft); }
    .voyage-page-btn.is-disabled { opacity: .35; cursor: not-allowed; }

    @media (prefers-reduced-motion: no-preference) {
        .fade-up { animation: voyageFadeUp .6s ease both; }
        @keyframes voyageFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    }
</style>
@endpush