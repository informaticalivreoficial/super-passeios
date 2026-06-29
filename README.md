🌊 Super Passeios Náutica SaaS

<p align="center">
  Plataforma SaaS para gestão e comercialização de passeios náuticos, permitindo que empresas criem suas embarcações, publiquem passeios e gerenciem reservas em um painel moderno e intuitivo.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0-brightgreen" alt="Versão">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-3.x-FB70A9?logo=livewire&logoColor=white" alt="Livewire">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38BDF8?logo=tailwindcss&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Licença MIT">
</p>

---

## 📋 Sobre o Projeto

O sistema funciona como um marketplace de experiências náuticas, onde:

Empresas criam suas contas e perfis
Cadastram embarcações
Publicam passeios (tours)
Gerenciam reservas e disponibilidade
Recebem pagamentos via integração com gateways (ex: Mercado Pago)

---

## 🛠️ Tecnologias

| Tecnologia | Versão |
|---|---|
| PHP | 8.3 |
| Laravel | 10.x |
| Livewire | 3.x |
| TailwindCSS | 3.x |
| Alpine.js | 3.x |
| MySQL | 8.x |

---

# ✨ Funcionalidades

## 🏢 Gestão de Empresas
Cadastro de empresas (onboarding SaaS)
Validação de e-mail
Perfil da empresa com informações completas

## 🚤 Embarcações
Cadastro de barcos
Capacidade, descrição e imagens
Associação com passeios

## 🏝️ Passeios (Tours)
Criação de experiências náuticas
Controle de datas e disponibilidade
Status ativo/inativo
Visualizações e destaque

## 📅 Reservas
Sistema de booking
Controle de vagas
Status de pagamento
Histórico de reservas

## 💳 Pagamentos
Integração com Mercado Pago
Checkout seguro
Webhooks para confirmação
Suporte a cartão, PIX e carteira

## 🔐 Permissões
Roles e permissions com Spatie
Painel administrativo controlado por acesso

## 🧠 Arquitetura
O projeto segue uma arquitetura modular baseada em:

Services (regras de negócio)
Livewire Components (UI reativa)
Models com relações bem definidas
Events/Webhooks para pagamentos
Camada de onboarding para empresas

## 🖥️ Requisitos
PHP 8.3+
Composer
Node.js 18+
MySQL 8+
Extensões PHP padrão do Laravel

## ⚙️ Instalação

```bash
git clone https://github.com/informaticalivreoficial/super-passeios.git
cd super-passeios

composer install
npm install
npm run build
```

Configuração do ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Migrações e seed

```bash
php artisan migrate --seed
```

Rodar o projeto

```bash
php artisan serve
npm run dev
```

## 💳 Configuração Mercado Pago

MERCADOPAGO_ACCESS_TOKEN=your_token
MERCADOPAGO_PUBLIC_KEY=your_key

## 📦 Estrutura SaaS

Fluxo principal:

Usuário cria conta
Confirma e-mail
Cria empresa (onboarding)
Acessa painel SaaS
Cria embarcações e passeios
Recebe reservas e pagamentos

## 🔐 Controle de Acesso
Admin global
Dono da empresa
Funcionários (futuro suporte multi-role)

## 📊 Roadmap
 Multi-tenant completo
 App mobile (API)
 Chat entre cliente e empresa
 Sistema de avaliações
 Cupons de desconto
 Geolocalização de passeios
 Dashboard analítico avançado

## 📸 Preview



---

## 🤝 Contribuição

Pull requests são bem-vindos. Para mudanças maiores, abra uma issue primeiro para discussão.

## 👤 Colaboradores

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/informaticalivreoficial">
        <img src="https://avatars.githubusercontent.com/u/28687748?v=4" width="100px" style="border-radius: 50%" alt="Renato Montanari"/>
        <br />
        <sub><b>Renato Montanari</b></sub>
      </a>
    </td>
  </tr>
</table>

---

## 📄 Licença

Este projeto está sob a licença [MIT](https://opensource.org/licenses/MIT).

---