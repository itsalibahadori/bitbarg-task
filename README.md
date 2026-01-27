
## Task Management

Technology used : Laravel 12 , Redis , Postgres 15 and Docker

### How to run app:
1. `docker compose up --build`
2. `docker compose exec app bash`
3. `composer i`
4. `.env.example` to `.env`
5. `run migrate:seed`   to create table and seed the role and permissions


the app is up on: 

[http://127.0.0.1:8000/](http://127.0.0.1:8000/)


# API Routes
- api/v1/auth/login
- api/v1/auth/register
- api/v1/tasks
- api/v1/tasks
- api/v1/tasks/{task}
- api/v1/tasks/{task}
- api/v1/tasks/{task}
- api/v1/users
- api/v1/users
- api/v1/users/{user}
- api/v1/users/{user}
- api/v1/users/{user}

<br/>
<br/>

# Project Structure

- Service Layer is used to implements user and task features. (thought process behind using service layer is to prevent fat controller and sprat business logic form controller)
- For role and permissions `spatie/laravel-permission` is used.
- For xss a middleware called `SanitizeInput` created and used globally for app
- Migration is used and seed for permissions
-