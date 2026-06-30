<div class="max-w-7xl mx-auto space-y-8">

    {{-- CARDS DE SALDO --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Disponível --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Disponível</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(35,197,94,0.1);">
                    <svg class="w-5 h-5" style="color: #23c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 22C6.48 22 2 17.52 2 12S6.48 2 12 2s10 4.48 10 10-4.48 10-10 10zm-1-7l-3-3 1.41-1.41L11 12.17l5.59-5.58L18 8l-7 7z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #23c55e;">
                R$ {{ number_format($data['available_balance'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">Pronto para saque</p>
        </div>

        {{-- Pendente --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Pendente</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(245,158,11,0.1);">
                    <svg class="w-5 h-5" style="color: #d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #d97706;">
                R$ {{ number_format($data['pending_balance'], 2, ',', '.') }}
            </p>
            @if($data['next_release'])
                <p class="text-xs mt-1" style="color: #c5bfb2;">
                    Próximo em {{ $data['next_release']->available_at->diffForHumans() }}
                </p>
            @else
                <p class="text-xs mt-1" style="color: #c5bfb2;">Aguardando liberação</p>
            @endif
        </div>

        {{-- Total vendas --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Total vendas</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(22,163,183,0.1);">
                    <svg class="w-5 h-5" style="color: #16a3b7;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 17l4-8 4 4 4-6 4 10"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #051e34;">
                R$ {{ number_format($data['total_sales'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">
                Taxa: R$ {{ number_format($data['total_commission'], 2, ',', '.') }}
            </p>
        </div>

        {{-- Total sacado --}}
        <div class="bg-white rounded-3xl p-6" style="border: 1px solid #e8e4d8;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold" style="color: #87c2c0;">Total sacado</span>
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center"
                     style="background: rgba(99,102,241,0.1);">
                    <svg class="w-5 h-5" style="color: #6366f1;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12l7 7 7-7"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold" style="color: #051e34;">
                R$ {{ number_format($data['total_withdrawn'], 2, ',', '.') }}
            </p>
            <p class="text-xs mt-1" style="color: #c5bfb2;">Valores transferidos</p>
        </div>

    </div>

</div>

</div>

@push('scripts')  
    @if(session()->has('toastr'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                toastr["{{ session('toastr.type') }}"](
                    "{{ session('toastr.message') }}",
                    "{{ session('toastr.title') }}"
                );
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                };
            });
        </script>
    @endif
@endpush
