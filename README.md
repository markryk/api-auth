# API REST (Registro e Login usando Laravel, Sanctum e Swagger Scramble)

Tópicos desenvolvidos

- Cadastro de usuários
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
Copia arquivo .env.example e renomeia para .env

Preenche info do seu banco de dados (nesse caso, MySQL)
```
php artisan key:generate
php artisan serve
```

## Passos para a criação do projeto

- Configurando o modelo User
- Controller de autenticação
- Rotas da API
- Criando Requests
- Scramble (Swagger/OpenAPI)

### Scramble (Swagger)
Acessar no navegador
```
http://127.0.0.1:8000/docs/api
```


## Testando a API (endpoints)
(Particularmente estou usando Insomnia)

Inicie o servidor:
```
php artisan serve
```

URL:
```
http://127.0.0.1:8000
```

Endpoints:
- POST /api/register
- POST /api/login 
- GET /api/me
- POST /api/logout


### Endpoint: POST /api/register


Body JSON (Usuário exemplo)
```
{
  "name": "João",
  "email": "joao@email.com",
  "password": "123456"
}
```

Se informações estiverem OK (200 OK), a resposta será:
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

### Endpoint: POST /api/login

Body JSON
```
{
  "email": "joao@email.com",
  "password": "123456"
}
```

  
Se informações estiverem OK (200 OK), a resposta será:
```
{
	"message": "Login realizado com sucesso",
	"token": "...",
	"user": {
		"id": ...,
		"name": "Joao",
		"email": "joao@email.com",
		"email_verified_at": null,
		"created_at": "...",
		"updated_at": "..."
	}
}
```

Se email ou senha estiver incorretas ou se e mail não existir, a resposta será:
```
{
	"message": "Credenciais inválidas.",
	"errors": {
		"email": [
			"Credenciais inválidas."
		]
	}
}
```

### Endpoint: GET /api/me

Verifica informações do usuário logado

Após o login, enviar token:
```
Authorization (ou Auth) >> Bearer Token >> Token: SEU_TOKEN
```

Se informações estiverem OK (200 OK), a resposta será:
```
{
	"id": ...,
	"name": "Joao",
	"email": "joao@email.com",
	"email_verified_at": null,
	"created_at": "...",
	"updated_at": "..."
}
```

### Endpoint: POST /api/logout

Se informações estiverem OK (200 OK), a resposta será:
```
{
	"message": "Logout realizado com sucesso"
}
```