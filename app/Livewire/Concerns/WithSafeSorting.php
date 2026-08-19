<?php

namespace App\Livewire\Concerns;

trait WithSafeSorting
{
    public function sortBy(string $field): void
    {
        if (!in_array($field, $this->sortableFields(), true)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    protected function safeSortField(): string
    {
        return in_array($this->sortField, $this->sortableFields(), true)
            ? $this->sortField
            : $this->defaultSortField();
    }

    protected function safeSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }

    abstract protected function sortableFields(): array;

    abstract protected function defaultSortField(): string;
}