<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======

# 🚀 API de Delivery - Laravel

API RESTful para sistema de delivery, desenvolvida com Laravel. Responsável por gerenciar autenticação, produtos, pedidos e regras de negócio da aplicação.

## 🧠 Sobre o projeto

Esta API foi construída para servir um frontend desacoplado (SPA), garantindo organização, escalabilidade e fácil integração com diferentes clientes (web, mobile, etc).

## 🚀 Tecnologias utilizadas

* PHP 8+
* Laravel
* MySQL / MariaDB
* Laravel Sanctum (ou JWT)
* Eloquent ORM

## 🔐 Autenticação

A API utiliza autenticação baseada em token:

* Laravel Sanctum (recomendado)
* ou JWT (alternativa)

## 📦 Funcionalidades

### 👤 Usuários

* Cadastro
* Login
* Logout
* Perfil autenticado

### 🍔 Produtos

* Listagem de produtos
* Detalhes do produto
* CRUD (admin)

### 📦 Pedidos

* Criar pedido
* Listar pedidos do usuário
* Atualizar status do pedido
* Visualizar detalhes

### 🛠️ Administração

* Gerenciamento de produtos
* Gerenciamento de pedidos
* Controle de status:

  * Pendente
  * Em preparo
  * Saiu para entrega
  * Entregue

## 🔗 Endpoints principais

```http
POST   /api/login
POST   /api/register
GET    /api/user

GET    /api/products
POST   /api/products
PUT    /api/products/{id}
DELETE /api/products/{id}

GET    /api/orders
POST   /api/orders
GET    /api/orders/{id}
PUT    /api/orders/{id}/status
```

## 📂 Estrutura do projeto

```bash id="laravelstruct"
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/

routes/
├── api.php

database/
├── migrations/
├── seeders/
```

## ⚙️ Instalação

```bash id="laravelinstall"
# Clonar o repositório
git clone https://github.com/seu-usuario/seu-repo.git

# Entrar na pasta
cd seu-repo

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Configurar banco de dados no .env

# Rodar migrations
php artisan migrate

# (Opcional) Popular banco
php artisan db:seed

# Iniciar servidor
php artisan serve
```

## ⚙️ Configuração

No arquivo `.env`, configure:

```env id="envdb"
DB_DATABASE=delivery
DB_USERNAME=root
DB_PASSWORD=
```

Se estiver usando Sanctum:

```bash id="sanctum"
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

## 🧪 Testes

```bash id="testlaravel"
php artisan test
```

## 🧩 Integração com Frontend

Essa API foi projetada para ser consumida por aplicações como:

* Vue.js
* React
* Mobile apps

Comunicação via JSON.

## 🧪 Melhorias futuras

* Pagamento online (Pix, cartão)
* WebSockets para atualização em tempo real
* Sistema de cupons
* Logs e auditoria
* Rate limiting avançado

## 📄 Licença

MIT

## 👩‍💻 Autora

Sabrina Oliveira
GitHub: [https://github.com/](https://github.com/)
LinkedIn: [https://linkedin.com/](https://linkedin.com/)
>>>>>>> 784de51552812cfb2a4fa968b3c5771f16f487a2
