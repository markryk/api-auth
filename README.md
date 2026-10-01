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

### Configurando o modelo User

### Controller de autenticação

### Rotas da API
Arquivo: *routes/api.php*

Em *bootstrap/app.php*, dentro de withRouting(), acrescente:
```
web: __DIR__.'/../routes/web.php',
api: __DIR__.'/../routes/api.php', (acrescentar essa linha)
```

### Criando Requests

### Scramble (Swagger/OpenAPI)

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