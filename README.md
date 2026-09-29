# Biblioteca API

API REST feita em Laravel para o trabalho de Desenvolvimento Web III (IF Sudeste MG - Campus Muriaé).

A API gerencia **livros**, **autores**, **categorias** e **usuários**, com autenticação via **Laravel Sanctum**.

## Tecnologias

- PHP 8.3+
- Laravel 13
- MySQL (ou MariaDB/PostgreSQL)
- Laravel Sanctum (autenticação por token)

## Arquitetura

O projeto segue uma arquitetura em camadas:

```
Request -> FormRequest (validação) -> Controller -> Service (regras de negócio)
        -> Repository (acesso a dados) -> Model -> Resource (formato do JSON)
```

- `app/Http/Controllers` - recebem a requisição e devolvem a resposta
- `app/Http/Requests` - validação dos dados de entrada
- `app/Http/Resources` - formatação das respostas em JSON
- `app/Services` - regras de negócio (ex: não excluir autor que possui livros)
- `app/Repositories` - acesso ao banco, com interfaces em `Contracts/`
- `app/Policies` - regras de permissão (usuário só altera a própria conta)

## Como rodar

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Crie o banco `biblioteca_api` no MySQL e ajuste usuário/senha no `.env`. Depois:

```bash
php artisan migrate --seed
php artisan serve
```

A API fica disponível em `http://localhost:8000/api`.

O seeder cria alguns dados de exemplo e um usuário de teste:

- **email:** test@example.com
- **senha:** password

## Autenticação

As rotas de consulta (`GET`) são públicas. As rotas de cadastro, alteração e exclusão precisam de token.

1. Faça login em `POST /api/login` (ou cadastre-se em `POST /api/register`)
2. Copie o `token` da resposta
3. Envie nas próximas requisições o header `Authorization: Bearer {token}`

Envie também `Accept: application/json` em todas as requisições.

## Endpoints

### Autenticação

| Método | Rota | Descrição | Auth |
|---|---|---|---|
| POST | `/api/register` | Cadastra um usuário e retorna o token | Não |
| POST | `/api/login` | Faz login e retorna o token | Não |
| POST | `/api/logout` | Revoga o token atual | Sim |
| GET | `/api/user` | Dados do usuário logado | Sim |

### Autores

| Método | Rota | Descrição | Auth |
|---|---|---|---|
| GET | `/api/autores` | Lista os autores | Não |
| GET | `/api/autores/{id}` | Retorna um autor com seus livros | Não |
| POST | `/api/autores` | Cadastra um autor | Sim |
| PUT | `/api/autores/{id}` | Atualiza um autor | Sim |
| DELETE | `/api/autores/{id}` | Remove um autor | Sim |

### Categorias

| Método | Rota | Descrição | Auth |
|---|---|---|---|
| GET | `/api/categorias` | Lista as categorias | Não |
| GET | `/api/categorias/{id}` | Retorna uma categoria com seus livros | Não |
| POST | `/api/categorias` | Cadastra uma categoria | Sim |
| PUT | `/api/categorias/{id}` | Atualiza uma categoria | Sim |
| DELETE | `/api/categorias/{id}` | Remove uma categoria | Sim |

### Livros

| Método | Rota | Descrição | Auth |
|---|---|---|---|
| GET | `/api/livros` | Lista os livros com autor e categoria | Não |
| GET | `/api/livros/{id}` | Retorna um livro com autor e categoria | Não |
| POST | `/api/livros` | Cadastra um livro | Sim |
| PUT | `/api/livros/{id}` | Atualiza um livro | Sim |
| DELETE | `/api/livros/{id}` | Remove um livro | Sim |

### Usuários

| Método | Rota | Descrição | Auth |
|---|---|---|---|
| GET | `/api/users` | Lista os usuários | Sim |
| GET | `/api/users/{id}` | Retorna um usuário | Sim |
| PUT | `/api/users/{id}` | Atualiza a própria conta | Sim |
| DELETE | `/api/users/{id}` | Exclui a própria conta | Sim |

## Exemplos de corpo das requisições

**Autor**

```json
{
    "nome": "Machado de Assis",
    "nacionalidade": "Brasileira",
    "nascimento": "1839-06-21",
    "biografia": "Escritor brasileiro."
}
```

**Categoria**

```json
{
    "nome": "Romance",
    "descricao": "Obras de ficção em prosa"
}
```

**Livro**

```json
{
    "titulo": "Dom Casmurro",
    "isbn": "9788535910681",
    "ano_publicacao": 1899,
    "descricao": "A história de Bentinho e Capitu.",
    "paginas": 256,
    "autor_id": 1,
    "categoria_id": 1
}
```

## Códigos de resposta

| Código | Quando acontece |
|---|---|
| 200 | Sucesso |
| 201 | Registro criado |
| 401 | Não autenticado (sem token ou token inválido) |
| 403 | Sem permissão (ex: alterar a conta de outro usuário) |
| 404 | Registro não encontrado |
| 409 | Não é possível excluir (autor ou categoria com livros vinculados) |
| 422 | Erro de validação |

## Postman

A collection com todas as rotas está em `docs/biblioteca-api.postman_collection.json`. Basta importar no Postman. O login salva o token automaticamente na variável `token`.

## Testes

Os testes usam SQLite em memória, então não precisam do MySQL:

```bash
php artisan test
```
