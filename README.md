<div align="center">

# 🚀 Laravel 12 REST API con Sanctum

### API REST completa con autenticación, CRUD de Mascotas y Posts

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Sanctum](https://img.shields.io/badge/Sanctum-4.0-38BDF8?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/sanctum)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

[Características](#-características) • 
[Instalación](#-instalación) • 
[Documentación](#-documentación-de-la-api) • 
[Arquitectura](#-arquitectura-del-proyecto)

</div>

---

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Stack Tecnológico](#-stack-tecnológico)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#️-configuración)
- [Autenticación](#-autenticación-con-sanctum)
- [Documentación de la API](#-documentación-de-la-api)
  - [Endpoints de Autenticación](#endpoints-de-autenticación)
  - [CRUD de Mascotas](#crud-de-mascotas)
  - [CRUD de Posts](#crud-de-posts)
- [Arquitectura del Proyecto](#-arquitectura-del-proyecto)
- [Validaciones](#-validaciones)
- [Pruebas](#-pruebas-con-postman)
- [Estructura de Base de Datos](#-estructura-de-base-de-datos)
- [Licencia](#-licencia)

---

## ✨ Características

- ✅ **Autenticación JWT** con Laravel Sanctum
- ✅ **CRUD Completo** para Mascotas y Posts
- ✅ **Validaciones robustas** en todos los endpoints
- ✅ **Arquitectura RESTful** estándar
- ✅ **Protección de rutas** con middleware
- ✅ **Relaciones Eloquent** entre modelos
- ✅ **Respuestas JSON** estructuradas
- ✅ **Documentación completa** con ejemplos

---

## 🛠️ Stack Tecnológico

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **Laravel** | 12.0 | Framework PHP |
| **PHP** | 8.2+ | Lenguaje de programación |
| **MySQL** | 8.0+ | Base de datos |
| **Sanctum** | 4.0 | Autenticación API |
| **Composer** | 2.0+ | Gestor de dependencias |
| **Postman** | - | Pruebas de API |

---

## 📋 Requisitos

Antes de comenzar, asegúrate de tener instalado:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0
- **Laravel** 12
- **Postman** (para pruebas)
- **Git**

---

## 📦 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/fgonmar445/Proyecto_API
cd proyecto_api
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos

Edita el archivo `.env` con tus credenciales de MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Instalar y configurar Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Iniciar servidor de desarrollo

```bash
php artisan serve
```

La API estará disponible en: `http://127.0.0.1:8000`

---

## ⚙️ Configuración

### Importar base de datos (opcional)

Si prefieres importar la base de datos directamente:

```bash
mysql -u root -p laravel_api < laravel_api.sql
```

### Configurar CORS (si es necesario)

Edita `config/cors.php` para permitir peticiones desde tu frontend.

---

## 🔐 Autenticación con Sanctum

### Flujo de autenticación

1. **Registro/Login** → El usuario se registra o inicia sesión
2. **Generación de Token** → El servidor genera un token personal
3. **Almacenamiento** → El cliente guarda el token
4. **Peticiones protegidas** → Se envía el token en cada petición:
   ```
   Authorization: Bearer {TOKEN_AQUI}
   ```
5. **Validación** → Sanctum valida el token
6. **Acceso concedido** → Si es válido, permite acceso a recursos

### Añadir token en Postman

Una vez registrado o logueado, copia el token recibido:

![Token en Postman](./images/token.png)

Agrégalo en la pestaña **Headers**:
- **Key**: `Authorization`
- **Value**: `Bearer {tu_token}`

---

## 📚 Documentación de la API

### Base URL

```
http://127.0.0.1:8000/api
```

---

### Endpoints de Autenticación

#### 📍 Registro de Usuario

**POST** `/api/register`

Crea un nuevo usuario y devuelve un token de acceso.

**Body (JSON):**

```json
{
  "name": "Ana García",
  "email": "ana@example.com",
  "password": "987654321!",
  "password_confirmation": "987654321!"
}
```

**Respuesta exitosa (201):**

```json
{
  "user": {
    "id": 1,
    "name": "Ana García",
    "email": "ana@example.com",
    "created_at": "2024-01-15T10:30:00.000000Z"
  },
  "token": "1|aBcDeFgHiJkLmNoPqRsTuVwXyZ..."
}
```

![Registro de Usuario](./images/register_user.png)

---

#### 📍 Inicio de Sesión

**POST** `/api/login`

Autentica un usuario existente.

**Body (JSON):**

```json
{
  "email": "ana@example.com",
  "password": "987654321!"
}
```

**Respuesta exitosa (200):**

```json
{
  "user": {
    "id": 1,
    "name": "Ana García",
    "email": "ana@example.com"
  },
  "token": "2|XyZwVuTsRqPoNmLkJiHgFeDcBa..."
}
```

---

#### 📍 Obtener Usuario Autenticado

**GET** `/api/user` 🔒

Devuelve la información del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta exitosa (200):**

```json
{
  "id": 1,
  "name": "Ana García",
  "email": "ana@example.com",
  "email_verified_at": null,
  "created_at": "2024-01-15T10:30:00.000000Z",
  "updated_at": "2024-01-15T10:30:00.000000Z"
}
```

---

#### 📍 Cerrar Sesión

**POST** `/api/logout` 🔒

Revoca el token actual del usuario.

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta exitosa (200):**

```json
{
  "message": "Logout exitoso"
}
```

---

### CRUD de Mascotas

> 🔒 **Nota:** Todas las rutas requieren autenticación (token).

#### 📍 Crear Mascota

**POST** `/api/mascotas`

**Headers:**
```
Authorization: Bearer {token}
```

**Body (JSON):**

```json
{
  "nombre": "Toby",
  "edad": 3,
  "especie": "Perro",
  "peso": 10.2,
  "vacunado": true
}
```

**Respuesta exitosa (201):**

```json
{
  "id": 1,
  "nombre": "Toby",
  "edad": 3,
  "especie": "Perro",
  "peso": 10.2,
  "vacunado": true,
  "user_id": 1,
  "created_at": "2024-01-15T11:00:00.000000Z",
  "updated_at": "2024-01-15T11:00:00.000000Z"
}
```

**Ejemplos:**

![Crear Mascota - Toby](./images/toby.png)

![Crear Mascota - Kira](./images/kira.png)

---

#### 📍 Listar Mascotas

**GET** `/api/mascotas`

Devuelve todas las mascotas del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta exitosa (200):**

```json
[
  {
    "id": 1,
    "nombre": "Toby",
    "edad": 3,
    "especie": "Perro",
    "peso": 10.2,
    "vacunado": true,
    "user_id": 1,
    "created_at": "2024-01-15T11:00:00.000000Z",
    "updated_at": "2024-01-15T11:00:00.000000Z"
  },
  {
    "id": 2,
    "nombre": "Kira",
    "edad": 2,
    "especie": "Gato",
    "peso": 4.5,
    "vacunado": true,
    "user_id": 1,
    "created_at": "2024-01-15T11:05:00.000000Z",
    "updated_at": "2024-01-15T11:05:00.000000Z"
  }
]
```

![Listar Mascotas](./images/get_mascotas.png)

---

#### 📍 Obtener una Mascota

**GET** `/api/mascotas/{id}`

Devuelve una mascota específica del usuario.

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta exitosa (200):**

```json
{
  "id": 1,
  "nombre": "Toby",
  "edad": 3,
  "especie": "Perro",
  "peso": 10.2,
  "vacunado": true,
  "user_id": 1,
  "created_at": "2024-01-15T11:00:00.000000Z",
  "updated_at": "2024-01-15T11:00:00.000000Z"
}
```

---

#### 📍 Actualizar Mascota

**PUT** `/api/mascotas/{id}`

Actualiza los datos de una mascota existente.

**Headers:**
```
Authorization: Bearer {token}
```

**Body (JSON):**

```json
{
  "nombre": "Toby Actualizado",
  "edad": 4,
  "especie": "Perro",
  "peso": 11.0,
  "vacunado": true
}
```

**Respuesta exitosa (200):**

```json
{
  "id": 1,
  "nombre": "Toby Actualizado",
  "edad": 4,
  "especie": "Perro",
  "peso": 11.0,
  "vacunado": true,
  "user_id": 1,
  "created_at": "2024-01-15T11:00:00.000000Z",
  "updated_at": "2024-01-15T12:00:00.000000Z"
}
```

![Actualizar Mascota](./images/mascotas_put.png)

---

#### 📍 Eliminar Mascota

**DELETE** `/api/mascotas/{id}`

Elimina una mascota del usuario autenticado.

**Headers:**
```
Authorization: Bearer {token}
```

**Respuesta exitosa (200):**

```json
{
  "message": "Mascota eliminada correctamente"
}
```

![Eliminar Mascota](./images/delete_mascotas.png)

---

### CRUD de Posts

> 🔒 **Nota:** Todas las rutas requieren autenticación (token).

#### 📍 Crear Post

**POST** `/api/posts`

**Headers:**
```
Authorization: Bearer {token}
```

**Body (JSON):**

```json
{
  "title": "Mi primer post",
  "content": "Contenido del post aquí..."
}
```

---

#### 📍 Listar Posts

**GET** `/api/posts`

Devuelve todos los posts del usuario autenticado.

---

#### 📍 Obtener un Post

**GET** `/api/posts/{id}`

Devuelve un post específico.

---

#### 📍 Actualizar Post

**PUT** `/api/posts/{id}`

Actualiza un post existente.

---

#### 📍 Eliminar Post

**DELETE** `/api/posts/{id}`

Elimina un post.

---

## 🏗️ Arquitectura del Proyecto

Este proyecto sigue la **arquitectura MVC estándar de Laravel**, organizada en capas que separan responsabilidades:

### 📂 Estructura de Carpetas

```
proyecto_api/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Lógica de peticiones HTTP
│   │   │   ├── AuthController.php
│   │   │   ├── MascotaController.php
│   │   │   └── PostController.php
│   │   └── Middleware/        # Filtros de peticiones
│   └── Models/                # Modelos Eloquent (ORM)
│       ├── User.php
│       ├── Mascota.php
│       └── Post.php
├── database/
│   ├── migrations/            # Esquema de base de datos
│   └── seeders/               # Datos de prueba
├── routes/
│   └── api.php                # Definición de rutas API
├── config/
│   ├── sanctum.php            # Configuración de Sanctum
│   └── cors.php               # Configuración CORS
└── .env                       # Variables de entorno
```

---

### 🎮 Controladores

Los controladores procesan las peticiones HTTP y devuelven respuestas JSON.

| Controlador | Responsabilidad |
|-------------|-----------------|
| `AuthController` | Registro, login, logout y gestión de tokens |
| `MascotaController` | CRUD completo de mascotas |
| `PostController` | CRUD completo de posts |

**Métodos RESTful utilizados:**

- `index()` → Listar recursos
- `store()` → Crear recurso
- `show($id)` → Mostrar un recurso
- `update($id)` → Actualizar recurso
- `destroy($id)` → Eliminar recurso

---

### 🧬 Modelos y Relaciones

Los modelos representan las tablas de la base de datos usando **Eloquent ORM**.

**Modelos principales:**

- **User**: Usuarios autenticados
- **Mascota**: Mascotas asociadas a usuarios
- **Post**: Publicaciones de usuarios

**Relaciones:**

```php
// User.php
public function mascotas()
{
    return $this->hasMany(Mascota::class);
}

public function posts()
{
    return $this->hasMany(Post::class);
}
```

```php
// Mascota.php
public function user()
{
    return $this->belongsTo(User::class);
}
```

```php
// Post.php
public function user()
{
    return $this->belongsTo(User::class);
}
```

---

### 🧵 Middleware

El middleware filtra peticiones antes de llegar a los controladores.

**Middleware utilizado:**

- `auth:sanctum` → Protege rutas que requieren autenticación
- `EnsureFrontendRequestsAreStateful` → Maneja sesiones con Sanctum

**Aplicación:**

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('mascotas', MascotaController::class);
    Route::apiResource('posts', PostController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
```

---

### 🔐 Laravel Sanctum

**Sanctum** genera tokens personales para autenticar peticiones API.

**Generación de token:**

```php
$token = $user->createToken('auth_token')->plainTextToken;
```

**Uso en peticiones:**

```
Authorization: Bearer {token}
```

Sanctum valida el token y asocia la petición al usuario correspondiente.

---

## ⭐ Validaciones

Todas las peticiones que crean o actualizan recursos implementan **validaciones robustas**.

### Reglas de validación comunes:

| Regla | Descripción |
|-------|-------------|
| `required` | Campo obligatorio |
| `string` | Debe ser texto |
| `integer` | Debe ser número entero |
| `numeric` | Debe ser numérico |
| `boolean` | Debe ser verdadero/falso |
| `email` | Formato de email válido |
| `min:X` | Valor mínimo |
| `max:X` | Longitud máxima |
| `confirmed` | Campo de confirmación |
| `unique:tabla,columna` | Valor único en BD |

### Ejemplo de validación (Mascotas):

```php
$request->validate([
    'nombre' => 'required|string|max:255',
    'edad' => 'required|integer|min:0',
    'especie' => 'required|string',
    'peso' => 'required|numeric|min:0',
    'vacunado' => 'required|boolean'
]);
```

### Respuesta de error de validación (422):

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "nombre": [
      "El campo nombre es obligatorio."
    ],
    "edad": [
      "El campo edad debe ser un número entero.",
      "El campo edad debe ser al menos 0."
    ]
  }
}
```

---

## 🧪 Pruebas con Postman

### Configurar entorno en Postman

1. Crear nueva colección: `Laravel API`
2. Añadir variable de entorno:
   - **Variable**: `base_url`
   - **Valor**: `http://127.0.0.1:8000/api`
3. Configurar Authorization:
   - **Type**: Bearer Token
   - **Token**: `{{token}}`

### Flujo de pruebas recomendado:

1. ✅ **POST** `/register` → Guardar token
2. ✅ **POST** `/login` → Verificar autenticación
3. ✅ **GET** `/user` → Obtener usuario autenticado
4. ✅ **POST** `/mascotas` → Crear varias mascotas
5. ✅ **GET** `/mascotas` → Listar todas
6. ✅ **PUT** `/mascotas/1` → Actualizar una
7. ✅ **DELETE** `/mascotas/1` → Eliminar una
8. ✅ **POST** `/posts` → Crear posts
9. ✅ **POST** `/logout` → Cerrar sesión

---

## 💾 Estructura de Base de Datos

### Tabla: `users`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT | ID único |
| `name` | VARCHAR(255) | Nombre del usuario |
| `email` | VARCHAR(255) | Email único |
| `password` | VARCHAR(255) | Contraseña hasheada |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de actualización |

### Tabla: `mascotas`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT | ID único |
| `user_id` | BIGINT | FK a users |
| `nombre` | VARCHAR(255) | Nombre de la mascota |
| `edad` | INT | Edad en años |
| `especie` | VARCHAR(255) | Especie (Perro, Gato...) |
| `peso` | DECIMAL | Peso en kg |
| `vacunado` | BOOLEAN | Estado de vacunación |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de actualización |

### Tabla: `posts`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id` | BIGINT | ID único |
| `user_id` | BIGINT | FK a users |
| `title` | VARCHAR(255) | Título del post |
| `content` | TEXT | Contenido |
| `created_at` | TIMESTAMP | Fecha de creación |
| `updated_at` | TIMESTAMP | Fecha de actualización |

### Diagrama de relaciones:

```
users (1) ──< (N) mascotas
users (1) ──< (N) posts
```

---

## 📝 Licencia

Este proyecto está bajo la licencia **MIT**.

---

## 🏁 Conclusión

Este proyecto es una **API REST completa y profesional** construida con Laravel 12 y Sanctum, que demuestra:

✅ Autenticación segura con tokens  
✅ CRUD completo de recursos  
✅ Validaciones robustas  
✅ Arquitectura limpia y escalable  
✅ Buenas prácticas de desarrollo  

**Ideal para:**
- Aprendizaje de Laravel y APIs REST
- Base para proyectos más complejos
- Portafolio de desarrollo backend
- Integración con frontends (React, Vue, Angular)

---

<div align="center">

**Desarrollado con ❤️ usando Laravel 12**

[⬆ Volver arriba](#-laravel-12-rest-api-con-sanctum)

</div>