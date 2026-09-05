<?php

namespace App\Livewire\Company\Documents;

use App\Models\Customer;
use App\Models\OperatorDocument;
use App\Services\OperatorDocumentService;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DocumentIndex extends Component
{
    public function mount(): void
    {
        $this->authorize('viewAny', OperatorDocument::class);
    }

    #[Layout('components.layouts.company', ['title' => 'Contratos e Documentos', 'bracrhumb' => 'Contratos e Documentos'])]
    public function render(OperatorDocumentService $service)
    {
        $customer = auth('customer')->user();
        $latestVersions = $service->getLatestPublishedVersions();
        $acceptedVersions = $service->getAcceptedTypeVersions($customer);

        $documentsWithStatus = $latestVersions->map(function ($doc) use ($customer, $service) {
            return [
                'document'       => $doc,
                'status'         => $service->getDocumentStatusForCustomer($customer, $doc),
                'is_accepted'    => $service->hasAcceptedDocument($customer, $doc),
                'requires_acceptance' => $service->requiresAcceptance($customer, $doc),
            ];
        });

        $pendingCount = $service->getPendingRequiredCount($customer);
        $hasPendingRequired = $service->hasPendingRequiredDocuments($customer);

        return view('livewire.company.documents.document-index', [
            'documentsWithStatus'  => $documentsWithStatus,
            'pendingCount'         => $pendingCount,
            'hasPendingRequired'   => $hasPendingRequired,
        ]);
    }
}
