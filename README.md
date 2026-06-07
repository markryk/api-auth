# API REST com Registro e Login usando Laravel, Sanctum e Swagger Scramble

Tópicos desenvolvidos

- Cadastro de usuários (Register)
- Login autenticado
- Logout
- Proteção de rotas com token
- Documentação automática da API com Scramble (Swagger/OpenAPI)
- Autenticação via Laravel Sanctum

Tecnologias utilizadas

- PHP
- Laravel
- Laravel Sanctum
- Dedoc Scramble (Swagger/OpenAPI)
- MySQL

## Rodar projeto

```
git clone https://github.com/markryk/api-auth.git
cd api-auth
composer install
```
- copia arquivo .env.example e renomeia para .env
- preenche info do seu banco de dados
```
php artisan key:generate
php artisan serve
```

## Criação do projeto

```
composer create-project laravel/laravel api-auth
```
```
cd api-auth
```

Arquivo .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_auth
DB_USERNAME=root
DB_PASSWORD=
```

Criar banco
```
CREATE DATABASE api_auth;
```

Instalação do Sanctum
```
composer require laravel/sanctum
```

Publicação dos arquivos:
```
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

Execução das migrations
```
php artisan migrate
```

### Configurando o modelo User

No arquivo **app/Models/User.php**, adicionar o trait *HasApiTokens*

### Controller de autenticação

```
php artisan make:controller Api/AuthController
```

Arquivo será criado em *app/Http/Controllers/Api/AuthController.php*

Implementar métodos register(), login(), me() (usuário autenticado) e logout()

### Rotas da API
Arquivo: *routes/api.php*

Em *bootstrap/app.php*, dentro de withRouting(), acrescente:
```
web: __DIR__.'/../routes/web.php',
api: __DIR__.'/../routes/api.php', (acrescentar essa linha)
```

## Testando a API
Particularmente estou usando Insomnia

Inicie o servidor:
```
php artisan serve
```

URL:
```
http://127.0.0.1:8000
```

Endpoint: POST /api/register

Body JSON
```
{
  "name": "João",
  "email": "joao@email.com",
  "password": "123456"
}
```

Resposta
```
{
  "message": "Usuário criado com sucesso",
  "token": "1|tokenAqui",
  "user": {
    "id": 1,
    "name": "João",
    "email": "joao@email.com"
  }
}
```

#### Testando o login

Endpoint: POST /api/login

Body JSON
```
{
  "email": "joao@email.com",
  "password": "123456"
}
```

#### Utilizando token no header

Após o login, enviar token no header:
```
Authorization (ou Auth): Bearer SEU_TOKEN
```

Endpoint: GET /api/me