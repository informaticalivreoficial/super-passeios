<?php

namespace App\Livewire\Company\Notifications;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class NotificationIndex extends Component
{
    use WithPagination;

    public $filter = 'all'; // all | unread

    public function setFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function markAsRead($notificationId)
    {
        auth('customer')->user()
            ->notifications()
            ->where('id', $notificationId)
            ->first()
            ?->markAsRead();
    }

    public function markAllAsRead()
    {
        auth('customer')->user()->unreadNotifications->markAsRead();
    }

    public function colorClasses($color)
    {
        return match ($color) {
            'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
            'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600'],
            'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600'],
            'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
            default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500'],
        };
    }

    #[Layout('components.layouts.company', ['title' => 'Notificações', 'bracrhumb' => 'Gerencie suas notificações.'])]
    public function render()
    {
        $query = auth('customer')->user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        }

        return view('livewire.company.notifications.notification-index', [
            'notifications' => $query->latest()->paginate(15),
            'unreadCount' => auth('customer')->user()->unreadNotifications()->count(),
        ]);
    }
}
