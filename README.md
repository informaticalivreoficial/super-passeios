🌊 Super Passeios Náutica SaaS

Plataforma SaaS para gestão e comercialização de passeios náuticos, permitindo que empresas criem suas embarcações, publiquem passeios e gerenciem reservas em um painel moderno e intuitivo.

Construído com Laravel 10, Livewire 3, Alpine.js e Tailwind CSS.

🚀 Visão Geral

O sistema funciona como um marketplace de experiências náuticas, onde:

Empresas criam suas contas e perfis
Cadastram embarcações
Publicam passeios (tours)
Gerenciam reservas e disponibilidade
Recebem pagamentos via integração com gateways (ex: Mercado Pago)

🧱 Stack Tecnológica
⚙️ Laravel 10
⚡ Livewire 3
🌿 Alpine.js
🎨 Tailwind CSS
🗄️ MySQL / MariaDB
💳 Integração com Mercado Pago
🔐 Spatie Laravel Permission
📦 Vite

✨ Funcionalidades
🏢 Gestão de Empresas
Cadastro de empresas (onboarding SaaS)
Validação de e-mail
Perfil da empresa com informações completas

🚤 Embarcações
Cadastro de barcos
Capacidade, descrição e imagens
Associação com passeios

🏝️ Passeios (Tours)
Criação de experiências náuticas
Controle de datas e disponibilidade
Status ativo/inativo
Visualizações e destaque

📅 Reservas
Sistema de booking
Controle de vagas
Status de pagamento
Histórico de reservas

💳 Pagamentos
Integração com Mercado Pago
Checkout seguro
Webhooks para confirmação
Suporte a cartão, PIX e carteira

🔐 Permissões
Roles e permissions com Spatie
Painel administrativo controlado por acesso

🧠 Arquitetura
O projeto segue uma arquitetura modular baseada em:

Services (regras de negócio)
Livewire Components (UI reativa)
Models com relações bem definidas
Events/Webhooks para pagamentos
Camada de onboarding para empresas

🖥️ Requisitos
PHP 8.3+
Composer
Node.js 18+
MySQL 8+
Extensões PHP padrão do Laravel

⚙️ Instalação
git clone https://github.com/seu-repo/nautical-saas.git
cd nautical-saas

composer install
npm install
npm run build

Configuração do ambiente
cp .env.example .env
php artisan key:generate

Migrações e seed
php artisan migrate --seed

Rodar o projeto
php artisan serve
npm run dev

💳 Configuração Mercado Pago
MERCADOPAGO_ACCESS_TOKEN=your_token
MERCADOPAGO_PUBLIC_KEY=your_key

📦 Estrutura SaaS

Fluxo principal:

Usuário cria conta
Confirma e-mail
Cria empresa (onboarding)
Acessa painel SaaS
Cria embarcações e passeios
Recebe reservas e pagamentos
🔐 Controle de Acesso
Admin global
Dono da empresa
Funcionários (futuro suporte multi-role)
📊 Roadmap
 Multi-tenant completo
 App mobile (API)
 Chat entre cliente e empresa
 Sistema de avaliações
 Cupons de desconto
 Geolocalização de passeios
 Dashboard analítico avançado
📸 Preview

(adicione aqui screenshots do painel, onboarding e página de tours)

🤝 Contribuição

Pull requests são bem-vindos. Para mudanças maiores, abra uma issue primeiro para discussão.

📄 Licença

Este projeto é de uso privado/comercial. Todos os direitos reservados.

⚓ Sobre o projeto

Este SaaS foi construído com foco em escalabilidade, experiência do usuário e automação de reservas para o mercado de turismo náutico.