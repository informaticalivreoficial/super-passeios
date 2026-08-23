<div>
    <form wire:submit.prevent="import" class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow-xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-2 border-b pb-3">
                Importar E-mails (CSV)
            </h2>
            <p class="text-sm text-gray-500 mb-5">
                O arquivo deve conter as colunas: <strong>e-mail</strong>, <strong>nome</strong> (opcional) e <strong>categoria</strong> (opcional). A primeira linha pode ser o cabeçalho.
            </p>

            <div class="mb-5">
                <label for="file" class="block text-sm font-semibold text-gray-700 mb-1">Arquivo CSV</label>
                <input
                    id="file"
                    type="file"
                    wire:model="file"
                    accept=".csv,.txt"
                    class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                >
                <div wire:loading wire:target="file" class="text-xs text-blue-600 mt-1">Enviando arquivo...</div>
                @error('file') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-5">
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Categoria padrão</label>
                <select
                    id="category_id"
                    wire:model.defer="category_id"
                    class="block w-full px-4 py-2 text-base text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                >
                    <option value="">Definir pela coluna do CSV (ou sem categoria)</option>
                    @foreach($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="mt-1 text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                    <input type="checkbox" wire:model.defer="updateExisting" class="rounded" style="accent-color: #16a3b7;">
                    Atualizar e-mails já existentes
                </label>
                <p class="text-xs text-gray-400 mt-1">Se desmarcado, e-mails duplicados serão ignorados.</p>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-200 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out"
                >
                    <span wire:loading.remove>
                        <i class="fas fa-file-import mr-2"></i>
                        Importar
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i> Importando...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
