<?php

namespace App\Livewire\Dashboard\Newsletter;

use App\Models\Newsletter;
use App\Models\NewsletterCategory;
use Illuminate\Validation\Rule;
use Livewire\Component;

class NewsletterForm extends Component
{
    public ?Newsletter $newsletter = null;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $city = null;

    public ?string $instagram = null;

    public ?string $whatsapp = null;

    public ?string $site = null;

    public ?int $category_id = null;

    public int $active = 1;

    public function mount(?Newsletter $newsletter = null): void
    {
        if ($newsletter?->exists) {
            $this->newsletter = $newsletter;
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

    public function getCategoriesProperty()
    {
        return NewsletterCategory::where('active', true)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('newsletters', 'email')->ignore($this->newsletter?->id),
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

        if (!$this->newsletter?->exists) {
            $data['confirmed_at'] = now();
            $data['unsubscribe_token'] = \Illuminate\Support\Str::random(64);
        }

        $newsletter = Newsletter::updateOrCreate(
            ['id' => $this->newsletter?->id],
            $data
        );

        $this->dispatch('swal:success', [
            'title' => 'Sucesso!',
            'text'  => $this->newsletter?->exists && !$newsletter->wasRecentlyCreated
                ? 'E-mail atualizado com sucesso!'
                : 'E-mail cadastrado com sucesso!',
            'timer' => 2000,
            'showConfirmButton' => false,
        ]);

        if ($newsletter->wasRecentlyCreated) {
            $this->redirect(route('admin.newsletter.edit', $newsletter));
            return;
        }

        $this->newsletter = $newsletter;
    }

    public function getTitleProperty(): string
    {
        return $this->newsletter?->exists ? 'Editar E-mail' : 'Cadastrar E-mail';
    }

    public function render()
    {
        return view('livewire.dashboard.newsletter.newsletter-form')->with([
            'title' => $this->title,
        ]);
    }
}
