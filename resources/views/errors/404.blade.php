@include('errors.layout', [
    'code' => 404,
    'title' => 'Página não encontrada',
    'message' => $exception->getMessage() ?: 'O conteúdo que você procura não existe ou foi movido.',
    'icon' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>',
])