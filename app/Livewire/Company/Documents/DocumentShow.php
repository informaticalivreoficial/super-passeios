<?php

namespace App\Livewire\Company\Documents;

use App\Models\Customer;
use App\Models\OperatorDocument;
use App\Services\OperatorDocumentService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DocumentShow extends Component
{
    public OperatorDocument $document;
    public bool $hasViewed = false;
    public bool $agreeTerms = false;
    public string $status = '';

    public function mount(OperatorDocument|int|null $document = null): void
    {
        $this->document = $document instanceof OperatorDocument
            ? $document
            : OperatorDocument::findOrFail($document);
        $this->authorize('view', $this->document);

        if (!$this->document->isPublished()) {
            abort(403, 'Este documento não está disponível.');
        }

        $customer = auth('customer')->user();
        $service = app(OperatorDocumentService::class);

        $this->status = $service->getDocumentStatusForCustomer($customer, $this->document);

        $acceptance = $this->document->acceptances()
            ->where('customer_id', $customer->id)
            ->where('version', $this->document->version)
            ->first();

        $this->hasViewed = $acceptance && $acceptance->viewed_at !== null;
    }

    public function markAsViewed(): void
    {
        $customer = auth('customer')->user();
        $service = app(OperatorDocumentService::class);
        $service->markViewed($customer, $this->document);

        $this->hasViewed = true;

        $this->dispatch('document-viewed');
    }

    public function accept(): void
    {
        if (!$this->agreeTerms) {
            $this->dispatch('swal:warning', [
                'title' => 'Atenção',
                'text'  => 'Você precisa marcar que leu e concorda com o documento.',
            ]);
            return;
        }

        $customer = auth('customer')->user();

        if (!$this->hasViewed) {
            $this->dispatch('swal:warning', [
                'title' => 'Atenção',
                'text'  => 'Você precisa visualizar o conteúdo completo antes de aceitar.',
            ]);
            return;
        }

        $service = app(OperatorDocumentService::class);
        $service->acceptDocument(
            $customer,
            $this->document,
            request()->ip(),
            request()->userAgent()
        );

        $this->status = 'accepted';

        $this->dispatch('swal:success', [
            'title'             => 'Aceito!',
            'text'              => 'Documento aceito com sucesso.',
            'timer'             => 3000,
            'showConfirmButton' => false,
        ]);

        $this->redirectRoute('company.documents.index');
    }

    #[Layout('components.layouts.company', ['title' => 'Documento', 'bracrhumb' => 'Contratos e Documentos'])]
    public function render()
    {
        return view('livewire.company.documents.document-show', [
            'renderedContent' => $this->renderMarkdown(),
        ]);
    }

    private function renderMarkdown(): string
    {
        $environment = \League\CommonMark\Environment\Environment::createCommonMarkEnvironment();
        $converter = new \League\CommonMark\MarkdownConverter($environment);

        return $converter->convert($this->document->content)->getContent();
    }
}
