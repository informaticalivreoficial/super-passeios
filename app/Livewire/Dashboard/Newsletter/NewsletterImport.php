<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\Newsletter;
use App\Models\NewsletterCategory;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class NewsletterImport extends Component
{
    public ?TemporaryUploadedFile $file = null;

    public ?int $category_id = null;

    public bool $updateExisting = false;

    public ?array $result = null;

    public function getCategoriesProperty()
    {
        return NewsletterCategory::where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function import(): void
    {
        $this->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
            'category_id' => ['nullable', 'exists:newsletter_categories,id'],
        ], [
            'file.required' => 'Selecione um arquivo CSV.',
            'file.mimes' => 'O arquivo deve ser do tipo CSV.',
            'file.max' => 'O arquivo não pode exceder 10MB.',
        ]);

        $path = $this->file->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon' => 'error',
                'text' => 'Não foi possível ler o arquivo.',
            ]);
            return;
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $row = 0;
        $hasHeader = false;

        while (($line = fgetcsv($handle, 0, ',', '"')) !== false) {
            $row++;

            if (count($line) === 0 || (count($line) === 1 && trim($line[0]) === '')) {
                continue;
            }

            if ($row === 1) {
                $first = strtolower(trim($line[0] ?? ''));
                if (str_contains($first, 'email') || str_contains($first, 'e-mail') || !filter_var($first, FILTER_VALIDATE_EMAIL)) {
                    $hasHeader = true;
                    continue;
                }
            }

            $email = trim($line[0] ?? '');
            $name = trim($line[1] ?? '');
            $categoryFromCsv = trim($line[2] ?? '');

            $email = ltrim($email, "\xEF\xBB\xBF");

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $skipped++;
                continue;
            }

            $categoryId = $this->category_id;

            if ($categoryId === null && $categoryFromCsv !== '') {
                $category = NewsletterCategory::where('name', $categoryFromCsv)->first();
                $categoryId = $category?->id;
            }

            $existing = Newsletter::where('email', $email)->first();

            if ($existing && !$this->updateExisting) {
                $skipped++;
                continue;
            }

            $data = [
                'name' => $name ?: null,
                'category_id' => $categoryId,
                'active' => true,
            ];

            if (!$existing) {
                $data['confirmed_at'] = now();
                $data['unsubscribe_token'] = \Illuminate\Support\Str::random(64);
                Newsletter::create(array_merge(['email' => $email], $data));
                $created++;
            } else {
                $existing->update($data);
                $updated++;
            }
        }

        fclose($handle);

        $this->dispatch('swal:success', [
            'title' => 'Importação concluída!',
            'text' => "{$created} adicionado(s), {$updated} atualizado(s) e {$skipped} ignorado(s).",
            'timer' => 4000,
            'showConfirmButton' => false,
        ]);

        $this->dispatch('newsletter-imported');

        $this->resetForm();
    }

    #[On('resetNewsletterImport')]
    public function resetForm(): void
    {
        $this->reset(['file', 'category_id', 'updateExisting']);
    }

    public function render()
    {
        return view('livewire.dashboard.newsletter.newsletter-import');
    }
}
