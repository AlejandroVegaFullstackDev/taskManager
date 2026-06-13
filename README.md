# ✅ TaskManager — API de Gestión de Tareas

API REST en **Laravel 12** para gestionar tareas con **autenticación JWT**.
Diseñada en capas (**controllers → services → repositories → models**) para
mantener el dominio desacoplado de la infraestructura. Lista para Docker y con
suite de tests en GitHub Actions.

![CI](https://github.com/AlejandroVegaFullstackDev/taskManager/actions/workflows/ci.yml/badge.svg)
![PHP](https://img.shields.io/badge/php-8.2-777BB4)
![Laravel](https://img.shields.io/badge/laravel-12-FF2D20)
![PostgreSQL](https://img.shields.io/badge/postgres-15-336791)
![Tests](https://img.shields.io/badge/tests-PHPUnit-3776AB)

---

## ✨ Características

- **CRUD** de tareas vía API REST.
- **Autenticación JWT** con `tymon/jwt-auth` (register, login, refresh, logout).
- **Arquitectura en capas**: el controlador delega en un **servicio**, que usa un
  **repositorio** (interfaz) — inversión de dependencias vía contenedor de Laravel.
- **Validación** con Form Requests.
- **Tests** de feature (API + auth) y unitarios (servicio) con PHPUnit.

> El portafolio mencionaba "Sanctum": la autenticación real usa
> **`tymon/jwt-auth`** (tokens JWT con TTL configurable).

---

## 🧱 Arquitectura

```
app/
├── Http/
│   ├── Controllers/      TaskController, AuthController  (capa de entrada, delgada)
│   └── Requests/         StoreTaskRequest, UpdateTaskRequest  (validación)
├── Services/             TaskService  (lógica de aplicación)
├── Repositories/         TaskRepositoryInterface + TaskRepository  (persistencia)
├── Exceptions/           TaskNotFoundException  (render 404 JSON)
└── Models/               Task, User
```

El binding `TaskRepositoryInterface → TaskRepository` se registra en
`AppServiceProvider`, así el servicio depende de la **interfaz**, no de Eloquent.

---

## 🔗 Endpoints

| Método | Ruta | Auth | Descripción |
|--------|------|------|-------------|
| `POST` | `/api/register` | público | Crea usuario y devuelve token |
| `POST` | `/api/login` | público | Devuelve token JWT |
| `POST` | `/api/refresh` | JWT | Renueva el token |
| `POST` | `/api/logout` | JWT | Invalida el token |
| `GET`  | `/api/tasks` | JWT | Lista tareas |
| `POST` | `/api/tasks` | JWT | Crea tarea |
| `GET`  | `/api/tasks/{id}` | JWT | Detalle de tarea |
| `PUT`  | `/api/tasks/{id}` | JWT | Actualiza tarea |
| `DELETE` | `/api/tasks/{id}` | JWT | Elimina tarea |

Las rutas protegidas requieren `Authorization: Bearer <token>`. El campo
`status` de una tarea acepta `pendiente` o `completada`.

```jsonc
// POST /api/tasks
{ "title": "Comprar pan", "description": "En la tienda", "status": "pendiente" }
```

---

## 🚀 Cómo correrlo

### Local (SQLite, rápido)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret          # genera JWT_SECRET
touch database/database.sqlite  # .env trae DB_CONNECTION=sqlite
php artisan migrate
php artisan serve               # http://localhost:8000
```

### Docker (PostgreSQL)

```bash
cp .env.example .env            # ajusta DB_* y pon DB_CONNECTION=pgsql
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

El seeder crea un usuario de prueba `test@example.com` / `password`.

---

## 🧪 Tests

```bash
php artisan test          # corre la suite (SQLite en memoria, vía phpunit.xml)
```

Cubren registro/login/refresh, protección por JWT y el CRUD completo de tareas,
además de tests unitarios del `TaskService` con repositorio simulado (Mockery).
La suite corre en **GitHub Actions** (`.github/workflows/ci.yml`).

---

## 🛠️ Stack

`PHP 8.2` · `Laravel 12` · `tymon/jwt-auth` · `PostgreSQL 15` / `SQLite` ·
`PHPUnit 11` · `Docker`

---

## 📄 Licencia

MIT
