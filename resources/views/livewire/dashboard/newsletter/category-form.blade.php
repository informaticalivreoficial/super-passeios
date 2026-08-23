<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow-xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-6 border-b pb-3">
                {{ $this->modalTitle }}
            </h2>

            <div class="mb-5">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome da Categoria</label>
                <input
                    id="name"
                    type="text"
                    wire:model.defer="name"
                    placeholder="Ex: Empresas"
                    class="block w-full px-4 py-2 text-base text-gray-600 border border-gray-200 rounded-lg shadow-inner bg-gray-100"
                >
                @error('name') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="active" class="block text-sm font-semibold text-gray-700 mb-1">Ativa?</label>
                <select
                    id="active"
                    wire:model.defer="active"
                    class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                >
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
                @error('active') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out"
                >
                    <span wire:loading.remove>
                        <i class="fas fa-save mr-2"></i>
                        {{ $this->modalTitle }}
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i> Salvando...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
