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

Criação do projeto
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