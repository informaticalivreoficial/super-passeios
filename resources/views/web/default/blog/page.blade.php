@extends("web.$config->template.master.master")

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 mb-3">
            {{ $page->title }}
        </h1>

        @if($page->publish_at)
            <p class="text-sm text-slate-400">
                Atualizado em {{ $page->publish_at }}
            </p>
        @endif
    </div>

    @if($page->hasCover())
        <div class="rounded-3xl overflow-hidden mb-10 aspect-[16/7]">
            <img
                src="{{ $page->cover() }}"
                alt="{{ $page->thumb_caption ?? $page->title }}"
                class="h-full w-full object-cover"
            >
        </div>
    @endif

    <div class="prose prose-slate max-w-none prose-headings:font-bold prose-a:text-cyan-600">
        {!! $page->content !!}
    </div>

</div>
@endsection