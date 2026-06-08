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

- No arquivo **app/Models/User.php**, adicionar o trait *HasApiTokens*
- Preencher *Fillable*

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

### Criando Requests

```
php artisan make:request RegisterRequest
```
Em *app/Http/Requests/RegisterRequest.php*:
- método *authorize()*, retornar **true**
- Preencher método *rules()* (Scramble lê esse método e gera o schema do body automaticamente)

Em *Api/AuthController.php*:
```
public function register(RegisterRequest $request) {
  $validated = $request->validated();
  ...
}
```

Repetir o passo anterior para criar o LoginRequest

### Scramble (Swagger/OpenAPI)
Instalação
```
composer require dedoc/scramble
```

Publicar a configuração
```
php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider"
```

#### Configurando Sanctum para Scramble

Ir em *app/Providers/AppServiceProvider.php*, método *boot()*:
```
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

...
Scramble::configure()->withDocumentTransformers(function (OpenApi $openApi) {
  $openApi->secure(
    SecurityScheme::http('bearer')
  );
});
```

Testando
```
http://127.0.0.1:8000/docs/api
```

## Testando a API
(Particularmente estou usando Insomnia)

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