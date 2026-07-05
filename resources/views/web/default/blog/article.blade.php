@extends("web.$config->template.master.master")

@section('content')
<div class="voyage-article">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">

        {{-- Breadcrumb --}}
        <nav class="mb-6 sm:mb-8 flex items-center gap-2 eyebrow-tag text-xs" style="color: var(--ink-soft);">
            <a href="{{ route('web.blog.index') }}" class="hover:text-[var(--teal-deep)] transition-colors">BLOG</a>
            @if($article->category)
                <span>/</span>
                <a href="{{ route('web.blog.category', $article->categoryObject->slug) }}" class="hover:text-[var(--teal-deep)] transition-colors">
                    {{ Str::upper($article->categoryObject->title) }}
                </a>
            @endif
        </nav>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 xl:gap-12">

            {{-- Conteúdo principal --}}
            <article class="xl:col-span-2 fade-up">

                {{-- === Bilhete / Ticket === --}}
                <div class="ticket-card overflow-hidden">

                    {{-- Stub superior: categoria + título --}}
                    <div class="p-6 sm:p-10 pb-8">
                        @if($article->category)
                            <span class="voyage-tag mb-5">
                                {{ $article->categoryObject->title }}
                            </span>
                        @endif

                        <h1 class="display text-3xl sm:text-4xl lg:text-[2.75rem] font-medium leading-[1.15] mb-6" style="color: var(--ink);">
                            {{ $article->title }}
                        </h1>

                        {{-- Meta como dados do bilhete --}}
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 sm:gap-x-0">
                            
                            <span class="voyage-meta-item">By {{ Str::upper($article->userObject->name) }}</span>
                            <span class="voyage-meta-sep hidden sm:block sm:mx-4"></span>                           

                            <span class="voyage-meta-item">{{ $article->publish_at ?? $article->created_at->format('d/m/Y') }}</span>

                            @if($article->readingTime)
                                <span class="voyage-meta-sep hidden sm:block sm:mx-4"></span>
                                <span class="voyage-meta-item">{{ $article->readingTime }} min. de leitura</span>
                            @endif

                            <span class="voyage-meta-sep hidden sm:block sm:mx-4"></span>
                            <span class="voyage-meta-item">{{ number_format($article->views,0,',','.') }} Visualizações</span>
                        </div>
                    </div>

                    {{-- Linha de picote --}}
                    <div class="perforation"></div>

                    {{-- Imagem de capa --}}
                    @if($article->cover())
                        <div class="p-6 sm:p-10 pt-8">
                            <div class="rounded-2xl overflow-hidden aspect-[16/9]">
                                <img
                                    src="{{ $article->cover() }}"
                                    alt="{{ $article->thumb_caption ?? $article->title }}"
                                    class="h-full w-full object-cover"
                                >
                            </div>
                            @if($article->thumb_caption)
                                <p class="mt-3 text-xs italic" style="color: var(--ink-soft); font-family: var(--font-display);">
                                    {{ $article->thumb_caption }}
                                </p>
                            @endif
                        </div>
                    @else
                        <div class="h-6"></div>
                    @endif
                </div>

                {{-- Corpo do artigo --}}
                <div class="voyage-prose mt-10 px-1 sm:px-2">
                    {!! $article->content !!}
                </div>

                {{-- Tags --}}
                @if($article->tags)
                    <div class="flex flex-wrap gap-3 mt-12 pt-8" style="border-top: 1px dashed var(--line);">
                        @foreach(explode(',', $article->tags) as $tag)
                            <span class="luggage-tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                @endif

                @if($article->gallery()->isNotEmpty())
                    <div class="mt-12 pt-8" style="border-top: 1px dashed var(--line);">
                        <h3 class="eyebrow-tag text-xs mb-6" style="color: var(--ink-soft);">
                            REGISTROS DA VIAGEM
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-5" id="voyage-gallery">
                            @foreach($article->gallery() as $i => $photo)
                                <button
                                    type="button"
                                    data-index="{{ $i }}"
                                    class="postcard voyage-thumb block w-full rounded-lg overflow-hidden aspect-[4/3] group text-left"
                                    style="--tilt: {{ $i % 2 === 0 ? '-1.5deg' : '1.5deg' }};"
                                >
                                    <img
                                        src="{{ $photo }}"
                                        alt="{{ $article->title }} - foto {{ $i + 1 }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </button>
                            @endforeach
                        </div>
                    </div>                    
                @endif
            </article>
            
            <aside class="xl:col-span-1">
                <div class="xl:sticky xl:top-8">
                    <h3 class="eyebrow-tag text-xs mb-5" style="color: var(--ink-soft);">
                        PRÓXIMOS DESTINOS DE LEITURA
                    </h3>

                    <div class="flex flex-col gap-4">
                        @forelse($related as $item)
                            
                            <a    href="{{ route('web.blog.show', $item->slug) }}"
                                class="related-card group flex gap-4 overflow-hidden p-3 transition-colors duration-200"
                            >
                                <div class="relative w-20 h-20 sm:w-24 sm:h-24 shrink-0 rounded-xl overflow-hidden">
                                    <img
                                        src="{{ $item->cover() ?? asset('images/placeholder-blog.jpg') }}"
                                        alt="{{ $item->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-110"
                                    >
                                </div>
                                <div class="flex flex-col justify-center min-w-0">
                                    <h4 class="display text-sm font-medium leading-snug line-clamp-2" style="color: var(--ink);">
                                        {{ $item->title }}
                                    </h4>
                                    <span class="voyage-meta-item mt-2">
                                        {{ $item->publish_at ?? $item->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm" style="color: var(--ink-soft);">Nenhum artigo relacionado por aqui ainda.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>

    {{-- Lightbox --}}
                    <div id="voyage-lightbox" class="voyage-lightbox" role="dialog" aria-modal="true" aria-hidden="true">
                        <button type="button" class="voyage-lightbox-close" data-action="close" aria-label="Fechar">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M4 4l12 12M16 4L4 16"/>
                            </svg>
                        </button>

                        <button type="button" class="voyage-lightbox-nav voyage-lightbox-prev" data-action="prev" aria-label="Foto anterior">
                            <svg width="22" height="22" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 4l-6 6 6 6"/>
                            </svg>
                        </button>

                        <figure class="voyage-lightbox-frame">
                            <img id="voyage-lightbox-img" src="" alt="">
                            <figcaption id="voyage-lightbox-counter" class="voyage-meta-item"></figcaption>
                        </figure>

                        <button type="button" class="voyage-lightbox-nav voyage-lightbox-next" data-action="next" aria-label="Próxima foto">
                            <svg width="22" height="22" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M8 4l6 6-6 6"/>
                            </svg>
                        </button>
                    </div>
            {{-- Sidebar --}}
</div>
@endsection

@push('styles')
{{-- Fontes: idealmente mover para o <head> do master layout --}}
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

    /* Etiqueta de categoria estilo "tag de bagagem" */
    .voyage-tag {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .35rem 1rem .35rem 1.5rem;
        background: var(--coral);
        color: #fff9f2;
        font-family: var(--font-mono);
        font-size: .7rem;
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

    .voyage-thumb {
        cursor: zoom-in;
        border: none;
        padding: 6px; /* mantém o padding do .postcard */
    }

    .voyage-lightbox {
        position: fixed;
        inset: 0;
        z-index: 60;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(22, 48, 47, 0.92);
        padding: 1.5rem;
    }
    .voyage-lightbox.is-open { display: flex; }

    .voyage-lightbox-frame {
        max-width: min(90vw, 900px);
        max-height: 85vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .75rem;
    }
    .voyage-lightbox-frame img {
        max-width: 100%;
        max-height: 78vh;
        border-radius: 8px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        background: #fff;
        padding: 6px;
    }
    .voyage-lightbox-frame figcaption {
        color: #efe7d6;
        opacity: .75;
    }

    .voyage-lightbox-close,
    .voyage-lightbox-nav {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255,253,248,0.1);
        color: #fffdf8;
        border: 1px solid rgba(255,253,248,0.25);
        transition: background .2s ease;
    }
    .voyage-lightbox-close:hover,
    .voyage-lightbox-nav:hover { background: rgba(255,253,248,0.2); }

    .voyage-lightbox-close { top: 1.25rem; right: 1.25rem; }
    .voyage-lightbox-prev { left: 1.25rem; top: 50%; transform: translateY(-50%); }
    .voyage-lightbox-next { right: 1.25rem; top: 50%; transform: translateY(-50%); }

    @media (max-width: 640px) {
        .voyage-lightbox-prev { left: .5rem; }
        .voyage-lightbox-next { right: .5rem; }
        .voyage-lightbox-close { top: .75rem; right: .75rem; }
    }

    .postcard {
        background: #fff;
        padding: 6px;
        border: 1px solid var(--line);
        box-shadow: 0 3px 8px rgba(22,48,47,0.08);
        transform: rotate(var(--tilt, 0deg));
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .postcard:hover {
        transform: rotate(0deg) translateY(-3px);
        box-shadow: 0 8px 16px rgba(22,48,47,0.12);
    }
    .postcard img { border-radius: 4px; }

    /* Ticket / bilhete do cabeçalho */
    .ticket-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 22px;
        box-shadow: 0 1px 2px rgba(22,48,47,0.04);
    }

    /* Linha de picote (perfuração) */
    .perforation {
        position: relative;
        height: 0;
        border-top: 2px dashed var(--line);
        margin: 0 -1px;
    }
    .perforation::before,
    .perforation::after {
        content: '';
        position: absolute;
        top: -12px;
        width: 24px;
        height: 24px;
        background: var(--paper);
        border-radius: 50%;
    }
    .perforation::before { left: -13px; }
    .perforation::after { right: -13px; }

    .voyage-meta-item {
        font-family: var(--font-mono);
        font-size: .75rem;
        color: var(--ink-soft);
    }

    .voyage-meta-sep {
        width: 1px;
        align-self: stretch;
        background: var(--line);
    }

    /* Corpo do artigo */
    .voyage-prose {
        font-family: var(--font-body);
        font-size: 1.0625rem;
        color: #253c3a;
    }
    .voyage-prose h2 {
        font-family: var(--font-display);
        font-size: 1.65rem;
        font-weight: 600;
        color: var(--ink);
        margin: 2.2em 0 .7em;
    }
    .voyage-prose h3 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        font-weight: 600;
        margin: 1.8em 0 .6em;
    }
    .voyage-prose a { color: var(--teal-deep); text-decoration: underline; text-underline-offset: 3px; }
    .voyage-prose img { border-radius: 16px; margin: 1.8em 0; }
    .voyage-prose blockquote {
        font-family: var(--font-display);
        font-style: italic;
        font-size: 1.25rem;
        color: var(--teal-deep);
        border-left: 3px solid var(--teal);
        padding-left: 1.25rem;
        margin: 1.8em 0;
    }
    .voyage-prose ul, .voyage-prose ol { margin: 0 0 1.5em 1.3em; }
    .voyage-prose li { margin-bottom: .4em; }

    /* Etiquetas de bagagem (tags do artigo) */
    .luggage-tag {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .9rem .4rem 1.6rem;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 4px 12px 12px 4px;
        font-family: var(--font-mono);
        font-size: .72rem;
        color: var(--ink-soft);
        transform: rotate(-1deg);
    }
    .luggage-tag:nth-child(even) { transform: rotate(1deg); }
    .luggage-tag::before {
        content: '';
        position: absolute;
        left: 9px; top: 50%;
        width: 5px; height: 5px;
        border-radius: 50%;
        background: var(--paper);
        box-shadow: inset 0 0 0 1px var(--line);
        transform: translateY(-50%);
    }

    .related-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
    }
    .related-card:hover { border-color: var(--teal); }

    @media (prefers-reduced-motion: no-preference) {
        .fade-up { animation: voyageFadeUp .6s ease both; }
        @keyframes voyageFadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    }
</style>    
@endpush

@push('scripts')
<script>
    (function () {
        const gallery = document.getElementById('voyage-gallery');
        const lightbox = document.getElementById('voyage-lightbox');
        if (!gallery || !lightbox) return;

        document.body.appendChild(lightbox);

        const photos = Array.from(gallery.querySelectorAll('.voyage-thumb img')).map(img => ({
            src: img.getAttribute('src'),
            alt: img.getAttribute('alt'),
        }));

        const lightboxImg = document.getElementById('voyage-lightbox-img');
        const counter = document.getElementById('voyage-lightbox-counter');
        let currentIndex = 0;
        let lastFocused = null;

        function render() {
            const photo = photos[currentIndex];
            lightboxImg.src = photo.src;
            lightboxImg.alt = photo.alt;
            counter.textContent = (currentIndex + 1) + ' / ' + photos.length;
        }

        function open(index) {
            currentIndex = index;
            lastFocused = document.activeElement;
            render();
            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            lightbox.querySelector('[data-action="close"]').focus();
        }

        function close() {
            lightbox.classList.remove('is-open');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            if (lastFocused) lastFocused.focus();
        }

        function prev() {
            currentIndex = (currentIndex - 1 + photos.length) % photos.length;
            render();
        }

        function next() {
            currentIndex = (currentIndex + 1) % photos.length;
            render();
        }

        gallery.querySelectorAll('.voyage-thumb').forEach(btn => {
            btn.addEventListener('click', () => open(Number(btn.dataset.index)));
        });

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) close();
            const action = e.target.closest('[data-action]')?.dataset.action;
            if (action === 'close') close();
            if (action === 'prev') prev();
            if (action === 'next') next();
        });

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') prev();
            if (e.key === 'ArrowRight') next();
        });
    })();
</script>
@endpush