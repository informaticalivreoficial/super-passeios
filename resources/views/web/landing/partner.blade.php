@extends('components.layouts.landing')

@section('title', $title)

@section('content')
    @include('web.landing.partials.navbar')
    @include('web.landing.partials.hero')
    @include('web.landing.partials.benefits')
    @include('web.landing.partials.how-it-works') 
    @include('web.landing.partials.dashboard')
    @include('web.landing.partials.features')
    {{--  
    @include('web.landing.partials.testimonials')
    --}}
    @include('web.landing.partials.faq')
    @include('web.landing.partials.footer')
@endsection

@push('scripts')
    <script>        
        function shareWhatsApp(event) {
            event.preventDefault();

            const message = "Atendimento {{ $config->app_name }}";

            const phone = "{{ $config->whatsapp }}";

            const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);

            const whatsappUrl = isMobile
                ? `https://api.whatsapp.com/send?phone=${phone}&text=${message}`
                : `https://web.whatsapp.com/send?phone=${phone}&text=${message}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
@endpush