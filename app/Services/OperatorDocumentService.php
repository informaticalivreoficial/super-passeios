<?php

namespace App\Services;

use App\Enums\DocumentTypeEnum;
use App\Models\Customer;
use App\Models\OperatorDocument;
use App\Models\OperatorDocumentAcceptance;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OperatorDocumentService
{
    public function hasPendingRequiredDocuments(Customer $customer): bool
    {
        return $this->getPendingRequiredDocuments($customer)->isNotEmpty();
    }

    public function getPendingRequiredDocuments(Customer $customer)
    {
        $latestVersions = $this->getLatestPublishedVersions();
        $acceptedTypeVersions = $this->getAcceptedTypeVersions($customer);

        return $latestVersions->filter(function ($doc) use ($acceptedTypeVersions) {
            if (!$doc->is_required) {
                return false;
            }

            $acceptedVersion = $acceptedTypeVersions->get($doc->type);

            if (!$acceptedVersion) {
                return true;
            }

            return version_compare($doc->version, $acceptedVersion, '>');
        });
    }

    public function getPendingRequiredCount(Customer $customer): int
    {
        return $this->getPendingRequiredDocuments($customer)->count();
    }

    public function hasAcceptedDocument(Customer $customer, OperatorDocument $document): bool
    {
        return OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->where('document_id', $document->id)
            ->where('version', $document->version)
            ->exists();
    }

    public function hasAcceptedType(Customer $customer, string $type): bool
    {
        $latest = OperatorDocument::where('type', $type)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->orderByDesc('version')
            ->first();

        if (!$latest) {
            return true;
        }

        return $this->hasAcceptedDocument($customer, $latest);
    }

    public function requiresAcceptance(Customer $customer, OperatorDocument $document): bool
    {
        if (!$document->isPublished() || !$document->is_required) {
            return false;
        }

        return !$this->hasAcceptedDocument($customer, $document);
    }

    public function acceptDocument(Customer $customer, OperatorDocument $document, ?string $ip = null, ?string $agent = null): OperatorDocumentAcceptance
    {
        if (!$document->isPublished()) {
            abort(400, 'Não é possível aceitar um documento que não foi publicado.');
        }

        $existing = OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->where('document_id', $document->id)
            ->where('version', $document->version)
            ->first();

        if ($existing && $existing->accepted_at) {
            return $existing;
        }

        if ($existing) {
            $existing->update([
                'accepted_at'  => now(),
                'ip_address'   => $ip,
                'user_agent'   => $agent,
            ]);

            return $existing->fresh();
        }

        return OperatorDocumentAcceptance::create([
            'customer_id'  => $customer->id,
            'document_id'  => $document->id,
            'version'      => $document->version,
            'content_hash' => $document->contentHash(),
            'accepted_at'  => now(),
            'ip_address'   => $ip,
            'user_agent'   => $agent,
            'viewed_at'    => now(),
        ]);
    }

    public function markViewed(Customer $customer, OperatorDocument $document): void
    {
        OperatorDocumentAcceptance::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'document_id' => $document->id,
                'version'     => $document->version,
            ],
            [
                'viewed_at'    => now(),
                'content_hash' => $document->contentHash(),
            ]
        );
    }

    public function getCurrentDocumentVersion(string $type): ?OperatorDocument
    {
        return OperatorDocument::where('type', $type)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->orderByDesc('version')
            ->first();
    }

    public function getLatestPublishedVersions()
    {
        $types = array_column(DocumentTypeEnum::cases(), 'value');
        $latestPerType = collect();

        foreach ($types as $type) {
            $doc = OperatorDocument::where('type', $type)
                ->where('is_active', true)
                ->whereNotNull('published_at')
                ->orderByDesc('version')
                ->first();

            if ($doc) {
                $latestPerType->push($doc);
            }
        }

        return $latestPerType;
    }

    public function getAcceptedTypeVersions(Customer $customer): \Illuminate\Support\Collection
    {
        $acceptances = OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->join('operator_documents', 'operator_documents.id', '=', 'operator_document_acceptances.document_id')
            ->select(
                'operator_documents.type',
                'operator_document_acceptances.version'
            )
            ->get();

        return $acceptances->mapWithKeys(function ($acc) {
            return [$acc->type => $acc->version];
        });
    }

    public function getDocumentStatusForCustomer(Customer $customer, OperatorDocument $document): string
    {
        if (!$document->isPublished()) {
            return 'draft';
        }

        $accepted = OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->where('document_id', $document->id)
            ->where('version', $document->version)
            ->whereNotNull('accepted_at')
            ->exists();

        if ($accepted) {
            return 'accepted';
        }

        $hasOlderAcceptance = OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->where('document_id', $document->id)
            ->whereNotNull('accepted_at')
            ->exists();

        if ($hasOlderAcceptance && $document->is_required) {
            return 'update_available';
        }

        if ($document->is_required) {
            return 'pending';
        }

        return 'optional';
    }

    public function createDocument(array $data): OperatorDocument
    {
        $data['slug'] = Str::slug($data['type'] . '-' . $data['version']);

        return OperatorDocument::create($data);
    }

    public function publishDocument(OperatorDocument $document, User $user): OperatorDocument
    {
        $document->update([
            'is_active'   => true,
            'published_at' => now(),
            'effective_at' => $document->effective_at ?? now(),
            'updated_by'  => $user->id,
        ]);

        return $document->fresh();
    }

    public function getOperatorAcceptanceHistory(Customer $customer)
    {
        return OperatorDocumentAcceptance::where('customer_id', $customer->id)
            ->with('document')
            ->orderByDesc('accepted_at')
            ->get();
    }

    public function getAllOperatorsWithStatus(OperatorDocument $document): array
    {
        $allOperators = Customer::whereHas('roles', fn($q) => $q->where('name', 'proprietary'))->get();

        $accepted = OperatorDocumentAcceptance::where('document_id', $document->id)
            ->where('version', $document->version)
            ->whereNotNull('accepted_at')
            ->pluck('customer_id');

        return [
            'accepted'   => $allOperators->whereIn('id', $accepted),
            'pending'    => $allOperators->whereNotIn('id', $accepted),
            'total'      => $allOperators->count(),
            'accepted_count' => $accepted->count(),
            'pending_count'  => $allOperators->count() - $accepted->count(),
        ];
    }
}
