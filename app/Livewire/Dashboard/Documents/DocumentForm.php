<?php

namespace App\Livewire\Dashboard\Documents;

use App\Enums\DocumentTypeEnum;
use App\Models\OperatorDocument;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class DocumentForm extends Component
{
    public ?OperatorDocument $document = null;

    public string $type = '';
    public string $title = '';
    public string $version = '1.0';
    public string $description = '';
    public string $content = '';
    public bool $is_required = false;
    public bool $is_active = false;
    public ?string $effective_at = null;
    public ?string $expires_at = null;
    public int $sort_order = 0;

    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'type'          => 'required|string|in:' . implode(',', array_column(DocumentTypeEnum::cases(), 'value')),
            'title'         => 'required|string|min:3|max:255',
            'version'       => 'required|string|max:20',
            'description'   => 'nullable|string|max:500',
            'content'       => 'required|string',
            'is_required'   => 'boolean',
            'is_active'     => 'boolean',
            'effective_at'  => 'nullable|date_format:d/m/Y',
            'expires_at'    => 'nullable|date_format:d/m/Y|after_or_equal:effective_at',
            'sort_order'    => 'integer|min:0',
        ];
    }

    protected $messages = [
        'type.required'    => 'Selecione o tipo do documento',
        'type.in'          => 'Tipo de documento inválido',
        'title.required'   => 'O título é obrigatório',
        'title.min'        => 'O título deve ter no mínimo 3 caracteres',
        'version.required' => 'A versão é obrigatória',
        'content.required' => 'O conteúdo é obrigatório',
        'expires_at.after_or_equal' => 'A data de encerramento deve ser igual ou posterior à data de vigência',
    ];

    public function mount(OperatorDocument|int|null $document = null): void
    {
        $this->authorize('viewAny', OperatorDocument::class);

        if ($document) {
            $this->document = $document instanceof OperatorDocument
                ? $document
                : OperatorDocument::findOrFail($document);
            $this->authorize('view', $this->document);

            $this->isEditing = true;
            $this->type = $this->document->type;
            $this->title = $this->document->title;
            $this->version = $this->document->version;
            $this->description = $this->document->description ?? '';
            $this->content = $this->document->content;
            $this->is_required = $this->document->is_required;
            $this->is_active = $this->document->is_active;
            $this->effective_at = $this->document->effective_at?->format('d/m/Y');
            $this->expires_at = $this->document->expires_at?->format('d/m/Y');
            $this->sort_order = $this->document->sort_order;
        }
    }

    public function save(): void
    {
        $this->authorize('viewAny', OperatorDocument::class);

        $validated = $this->validate();

        if ($validated['effective_at']) {
            $validated['effective_at'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['effective_at']);
        }
        if ($validated['expires_at']) {
            $validated['expires_at'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['expires_at']);
        }

        $validated['slug'] = Str::slug($validated['type'] . '-' . $validated['version']);

        if ($this->isEditing) {
            $this->authorize('update', $this->document);

            $validated['updated_by'] = auth()->id();
            $this->document->update($validated);

            $message = 'Documento atualizado com sucesso.';
        } else {
            $existingTypeVersion = OperatorDocument::where('type', $validated['type'])
                ->where('version', $validated['version'])
                ->exists();

            if ($existingTypeVersion) {
                $this->dispatch('swal:error', [
                    'title' => 'Versão duplicada',
                    'text'  => 'Já existe uma versão deste tipo e número.',
                ]);
                return;
            }

            $validated['created_by'] = auth()->id();
            $validated['updated_by'] = auth()->id();
            $this->document = OperatorDocument::create($validated);
            $this->isEditing = true;

            $message = 'Documento criado com sucesso.';
        }

        $this->dispatch('swal:success', [
            'title'             => 'Salvo!',
            'text'              => $message,
            'timer'             => 3000,
            'showConfirmButton' => false,
        ]);
    }

    public function publish(): void
    {
        $this->authorize('publish', $this->document);

        if ($this->document->isPublished()) {
            return;
        }

        $this->document->update([
            'is_active'    => true,
            'published_at' => now(),
            'effective_at' => $this->document->effective_at ?? now(),
            'updated_by'   => auth()->id(),
        ]);

        $this->document->refresh();

        $operators = \App\Models\Customer::whereHas('roles', fn($q) => $q->where('name', 'proprietary'))->get();
        foreach ($operators as $operator) {
            $operator->notify(new \App\Notifications\NewDocumentVersionPublished($this->document));
        }

        $this->dispatch('swal:success', [
            'title'             => 'Publicado!',
            'text'              => 'O documento foi publicado e notificações enviadas.',
            'timer'             => 3000,
            'showConfirmButton' => false,
        ]);
    }

    public function createNewVersion(): void
    {
        $this->authorize('create', OperatorDocument::class);

        $latestVersion = OperatorDocument::where('type', $this->document->type)
            ->orderByDesc('version')
            ->first();

        $parts = explode('.', $latestVersion->version ?? '1.0');
        $minor = (int) ($parts[1] ?? 0) + 1;
        $newVersion = $parts[0] . '.' . $minor;

        $newDocument = OperatorDocument::create([
            'type'          => $this->document->type,
            'title'         => $this->document->title,
            'slug'          => Str::slug($this->document->type . '-' . $newVersion),
            'description'   => $this->document->description,
            'content'       => $this->document->content,
            'version'       => $newVersion,
            'is_required'   => $this->document->is_required,
            'is_active'     => false,
            'sort_order'    => $this->document->sort_order,
            'created_by'    => auth()->id(),
            'updated_by'    => auth()->id(),
        ]);

        $this->redirectRoute('admin.documents.edit', $newDocument->id);
    }

    public function getRenderedContentProperty(): string
    {
        if (empty($this->content)) {
            return '<p class="text-slate-400 italic">Nenhum conteúdo para visualizar.</p>';
        }

        $environment = \League\CommonMark\Environment\Environment::createCommonMarkEnvironment();
        $converter = new \League\CommonMark\MarkdownConverter($environment);

        return $converter->convert($this->content)->getContent();
    }

    public function render()
    {
        return view('livewire.dashboard.documents.document-form', [
            'types' => DocumentTypeEnum::cases(),
        ])->layout('components.layouts.app', [
            'title' => $this->isEditing ? 'Editar Documento' : 'Novo Documento',
        ]);
    }
}
