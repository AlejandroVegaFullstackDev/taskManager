TaskManager – API & Plataforma de Gestión de Tareas

Proyecto personal pensado para mostrar buenas prácticas en desarrollo Full‑Stack con Laravel + PostgreSQL + Docker.

✨ Características principales

API RESTful con operaciones CRUD para tareas.

Autenticación JWT (Laravel Sanctum) con expiración configurable.

Arquitectura hexagonal: controladores → servicios → repositorios → modelos.

Docker‑first: entorno replicable en cualquier máquina.

CI/CD listo para GitHub Actions (tests + Lint + Build).

Cobertura de tests: unitarios y de integración (PHPUnit).

🚀 Demo local en 5 pasos

# 1. Clona el repo
$ git clone https://github.com/tu‑usuario/taskmanager.git && cd taskmanager

# 2. Copia variables de entorno
$ cp .env.example .env    # ajusta valores si lo deseas

# 3. Levanta servicios
$ docker compose up -d --build

# 4. Instala dependencias & ejecuta migraciones
$ docker compose exec app composer install
$ docker compose exec app php artisan migrate --seed

# 5. Visita la app (frontend opcional)
http://localhost:3000   # si usas el front React opcional

Credenciales iniciales (Seeds)email: admin@example.compassword: passwordPuedes cambiarlas en database/seeders/UserSeeder.php antes de levantar el stack.

🗄️ Stack Tecnológico

Capa

Tecnología

Versión

Backend

PHP / Laravel

8.3 / 10.x

Base de datos

PostgreSQL

15

Autenticación

JWT (Sanctum)

—

Contenedores

Docker & Compose

26+

CI/CD

GitHub Actions

—

Testing

PHPUnit + Pest

—

📂 Estructura de carpetas (backend)

app/
 ├─ Http/Controllers       // Entradas HTTP
 ├─ Domain/Models          // Entidades de dominio (Eloquent)
 ├─ Domain/Repositories    // Interfaces
 ├─ Infrastructure/Repos   // Implementaciones Eloquent
 └─ Services               // Casos de uso

🔐 Autenticación

Login – POST /api/login

{ "email": "admin@example.com", "password": "password" }

Respuesta → access_token, token_type, expires_in.

Incluye la cabecera:

Authorization: Bearer <token>

📑 Endpoints de Tareas

Método

Endpoint

Descripción

GET

/api/tasks

Listar tareas

POST

/api/tasks

Crear tarea

GET

/api/tasks/{id}

Obtener tarea

PUT

/api/tasks/{id}

Actualizar tarea

DELETE

/api/tasks/{id}

Eliminar tarea

Consulta docs/openapi.yaml para una especificación completa (OpenAPI 3.1).

🧪 Pruebas

# Ejecutar todas las pruebas
$ docker compose exec app php artisan test

# Cobertura (HTML)
$ docker compose exec app phpdbg -qrr vendor/bin/phpunit --coverage-html storage/coverage

☁️ Despliegue en producción

Se puede desplegar en cualquier PaaS que soporte Docker (AWS ECS/Fargate, Railway, Fly.io, etc.).
Ejemplo de workflow GitHub Actions a Railway incluido en .github/workflows/deploy.yml.

📄 Licencia

Publicado bajo la licencia MIT. Siéntete libre de usarlo como base para tus propios proyectos.

🤝 Créditos y contexto

Este repositorio nació como una prueba técnica; posteriormente fue refactorizado y ampliado para servir como ejemplo público de buenas prácticas. Todo el código mostrado aquí es 100 % original y no contiene información ni activos privados de terceros.

