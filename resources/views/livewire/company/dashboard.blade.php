<div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Saldo Disponível</p>
        <h2 class="text-3xl font-bold mt-2">
            R$ {{ number_format($wallet['available_balance'], 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Saldo Pendente</p>
        <h2 class="text-3xl font-bold mt-2">
            R$ {{ number_format($wallet['pending_balance'], 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Total Vendido</p>
        <h2 class="text-3xl font-bold mt-2">
            R$ {{ number_format($wallet['total_sales'], 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Comissão</p>
        <h2 class="text-3xl font-bold mt-2">
            R$ {{ number_format($wallet['total_commission'], 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Total Sacado</p>
        <h2 class="text-3xl font-bold mt-2">
            R$ {{ number_format($wallet['total_withdrawn'], 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <p class="text-sm text-gray-500">Próxima Liberação</p>

        @if($wallet['next_release'])
            <h2 class="text-2xl font-bold mt-2">
                {{ $wallet['next_release']->available_at->format('d/m/Y') }}
            </h2>

            <p class="text-lg mt-2">
                R$ {{ number_format($wallet['next_release']->net_amount, 2, ',', '.') }}
            </p>
        @else
            <p class="text-gray-400 mt-2">
                Nenhuma liberação pendente
            </p>
        @endif
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
