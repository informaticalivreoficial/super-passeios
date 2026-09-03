<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\Newsletter;
use App\Models\NewsletterCategory;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class NewsletterForm extends Component
{
    public ?int $id = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $city = null;

    public ?string $instagram = null;

    public ?string $whatsapp = null;

    public ?string $site = null;

    public ?int $category_id = null;

    public int $active = 1;

    public function getCategoriesProperty()
    {
        return NewsletterCategory::where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    #[On('loadNewsletter')]
    public function load($payload = []): void
    {
        $data = $payload['payload'] ?? $payload;

        if (!empty($data['editId'])) {
            $newsletter = Newsletter::find($data['editId']);
            if ($newsletter) {
                $this->id = $newsletter->id;
                $this->name = $newsletter->name;
                $this->email = $newsletter->email;
                $this->city = $newsletter->city;
                $this->instagram = $newsletter->instagram;
                $this->whatsapp = $newsletter->whatsapp;
                $this->site = $newsletter->site;
                $this->category_id = $newsletter->category_id;
                $this->active = $newsletter->active ? 1 : 0;
            }
        }
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('newsletters', 'email')->ignore($this->id),
            ],
            'city' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:newsletter_categories,id',
            'active' => 'required|boolean',
        ], [
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'city' => $this->city,
            'instagram' => $this->instagram,
            'whatsapp' => $this->whatsapp,
            'site' => $this->site,
            'category_id' => $this->category_id,
            'active' => $this->active,
        ];

        if (!$this->id) {
            $data['confirmed_at'] = now();
            $data['unsubscribe_token'] = \Illuminate\Support\Str::random(64);
        }

        Newsletter::updateOrCreate(
            ['id' => $this->id],
            $data
        );

        $this->dispatch('newsletter-saved');
        $this->resetForm();
    }

    #[On('resetNewsletterForm')]
    public function resetForm(): void
    {
        $this->reset(['id', 'name', 'email', 'city', 'instagram', 'whatsapp', 'site', 'category_id', 'active']);
        $this->active = 1;
    }

    public function getModalTitleProperty(): string
    {
        return $this->id ? 'Editar E-mail' : 'Cadastrar E-mail';
    }

    public function render()
    {
        return view('livewire.dashboard.newsletter.newsletter-form');
    }
}
