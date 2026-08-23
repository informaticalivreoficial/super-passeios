<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\NewsletterCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class NewsletterCategoryForm extends Component
{
    public ?int $id = null;

    public ?string $name = null;

    public int $active = 1;

    #[On('loadNewsletterCategory')]
    public function load($payload = []): void
    {
        $data = $payload['payload'] ?? $payload;

        if (!empty($data['editId'])) {
            $category = NewsletterCategory::find($data['editId']);
            if ($category) {
                $this->id = $category->id;
                $this->name = $category->name;
                $this->active = $category->active ? 1 : 0;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'active' => 'required|boolean',
        ], [
            'name.required' => 'Informe o nome da categoria.',
        ]);

        NewsletterCategory::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'active' => $this->active,
            ]
        );

        $this->dispatch('newsletter-category-saved');
        $this->resetForm();
    }

    #[On('resetNewsletterCategoryForm')]
    public function resetForm(): void
    {
        $this->reset(['id', 'name', 'active']);
        $this->active = 1;
    }

    public function getModalTitleProperty(): string
    {
        return $this->id ? 'Editar Categoria' : 'Cadastrar Categoria';
    }

    public function render()
    {
        return view('livewire.dashboard.newsletter.category-form');
    }
}
