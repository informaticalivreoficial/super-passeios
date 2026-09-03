<div>
    @section('title', $title)
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-envelope-open-text mr-2"></i> {{ $newsletter?->exists ? 'Editar E-mail' : 'Cadastrar E-mail' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Painel de Controle</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">{{ $newsletter?->exists ? 'Editar' : 'Cadastrar' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="bg-white">
            <div class="card-body text-muted">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Nome:</b></label>
                            <input
                                type="text"
                                wire:model.defer="name"
                                placeholder="Nome (opcional)"
                                class="form-control"
                            >
                            @error('name') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>E-mail: *</b></label>
                            <input
                                type="email"
                                wire:model.defer="email"
                                placeholder="contato@exemplo.com"
                                class="form-control"
                            >
                            @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Cidade:</b></label>
                            <input
                                type="text"
                                wire:model.defer="city"
                                placeholder="Cidade (opcional)"
                                class="form-control"
                            >
                            @error('city') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Instagram:</b></label>
                            <input
                                type="text"
                                wire:model.defer="instagram"
                                placeholder="@usuario"
                                class="form-control"
                            >
                            @error('instagram') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>WhatsApp:</b></label>
                            <input
                                type="text"
                                x-mask="(99) 99999-9999"
                                wire:model.defer="whatsapp"
                                placeholder="(00) 00000-0000"
                                class="form-control"
                            >
                            @error('whatsapp') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Site:</b></label>
                            <input
                                type="text"
                                wire:model.defer="site"
                                placeholder="https://exemplo.com"
                                class="form-control"
                            >
                            @error('site') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Categoria:</b></label>
                            <select
                                wire:model.defer="category_id"
                                class="form-control"
                            >
                                <option value="">Sem categoria</option>
                                @foreach($this->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label class="labelforms"><b>Ativo:</b></label>
                            <div class="mt-1">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        wire:model="active"
                                        class="w-5 h-5 rounded border-gray-300 text-green-500 focus:ring-green-500"
                                    >
                                    <span class="text-sm font-medium text-gray-700">Ativo</span>
                                </label>
                            </div>
                            @error('active') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="{{ route('admin.newsletter.index') }}" class="btn btn-default">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </a>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="btn btn-success float-right"
                        >
                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-save mr-1"></i> {{ $newsletter?->exists ? 'Atualizar' : 'Salvar' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Salvando...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
