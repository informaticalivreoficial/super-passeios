@include('errors.layout', [
    'code' => 403,
    'title' => 'Acesso negado',
    'message' => $exception->getMessage() ?: 'Você não tem permissão para acessar este conteúdo.',
    'icon' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M4.9 4.9l14.2 14.2"/></svg>',
])