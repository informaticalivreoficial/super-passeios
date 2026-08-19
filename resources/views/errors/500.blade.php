@include('errors.layout', [
    'code' => 500,
    'title' => 'Erro interno',
    'message' => $exception->getMessage() ?: 'Algo deu errado no servidor. Tente novamente em instantes.',
    'icon' => '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>',
])