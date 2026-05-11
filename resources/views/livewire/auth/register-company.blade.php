<div>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="w-full max-w-md bg-white rounded-2xl shadow p-8">

            <h1 class="text-2xl font-bold mb-6">
                Cadastro Empresa
            </h1>

            <form wire:submit="save" class="space-y-4">

                <div>
                    <label class="block mb-1">
                        Nome
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                    @error('name')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                    @error('email')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">
                        Telefone
                    </label>

                    <input
                        type="text"
                        wire:model="cell_phone"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                    @error('cell_phone')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">
                        Senha
                    </label>

                    <input
                        type="password"
                        wire:model="password"
                        class="w-full border rounded-lg px-4 py-2"
                    >

                    @error('password')
                        <span class="text-red-500 text-sm">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">
                        Confirmar Senha
                    </label>

                    <input
                        type="password"
                        wire:model="password_confirmation"
                        class="w-full border rounded-lg px-4 py-2"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-black text-white py-3 rounded-xl"
                >
                    Criar Conta
                </button>

            </form>

        </div>

    </div>
</div>
