<?php

namespace App\Livewire\Company;

use Livewire\Component;

class NotificationBell extends Component
{
    public $open = false;

    protected $listeners = ['notification-received' => '$refresh'];

    public function toggle()
    {
        $this->open = !$this->open;
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
    
    public function render()
    {
        $notifications = auth('customer')->user()
            ->notifications()
            ->latest()
            ->take(8)
            ->get();

        $unreadCount = auth('customer')->user()->unreadNotifications()->count();

        return view('livewire.company.notification-bell', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
