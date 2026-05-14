<?php

namespace App\Traits;

trait WithToastr
{
    protected function toast(string $type, string $message): void
    {
        $this->dispatch('toast', type: $type, message: $message);
    }

    public function toastSuccess(string $message): void
    {
        $this->toast('success', $message);
    }

    public function toastError(string $message): void
    {
        $this->toast('error', $message);
    }

    public function toastWarning(string $message): void
    {
        $this->toast('warning', $message);
    }

    public function toastInfo(string $message): void
    {
        $this->toast('info', $message);
    }
}