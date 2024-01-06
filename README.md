# Challenge by Coodesh - Gerenciador de Despesas

Desenvolvimento de uma tela de gestão de despesas (CRUD), com login via autenticação de usuários e restrições de acesso.

### Tecnologias Utilizadas
  - Laravel X10
  - VueJs 3
  - Flatpickr
  - MySQL

----

# Instruções

## Instalando as dependências

**Backend**

Via terminal acesse a pasta `backend` e rodar os seguintes comandos
```sh
composer install
```

**Frontend**

Em outro terminal, acesse a pasta `frontend` e execute os seguintes comandos:

```sh
npm install
```

```sh
npm run dev
```

## Configurações do banco de dados
> _(Testado com MySQL e SQLite mas provavelmente não terá problemas para usar PostgreSQL também)_

1. Copie o conteúdo do arquivo `.env.example` para `.env`
2. Edite o arquivo `.env` adicionando as configurações do banco. Atenção para as variáveis abaixo:
```sh
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
3. Para criar as tabelas, execute as migrations execute o comando:
```sh
php artisan migrate
```
4. Para popular a base com dados fakes, execute o comando:
```sh
php artisan db:seed
```
5. Para executar o servidor interno do Laravel/PHP execute:

```sh
php artisan serve
```
