@include('errors.layout', [
    'code' => 401,
    'title' => 'Não autenticado',
    'message' => $exception->getMessage() ?: 'Você precisa estar logado para acessar este conteúdo.',
    'icon' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>',
])