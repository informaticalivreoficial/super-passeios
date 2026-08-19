@include('errors.layout', [
    'code' => 419,
    'title' => 'Sessão expirada',
    'message' => $exception->getMessage() ?: 'Sua sessão expirou. Volte e tente novamente.',
    'icon' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
])