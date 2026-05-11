<div>
    <div class="max-w-md mx-auto py-10">

        <h1 class="text-2xl font-bold mb-4">
            Verifique seu email
        </h1>

        <p class="text-gray-600 mb-6">
            Enviamos um link de confirmação para seu email.
        </p>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <button
            wire:click="resend"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Reenviar email
        </button>

    </div>
</div>
