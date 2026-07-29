
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