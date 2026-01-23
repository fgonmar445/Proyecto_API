# API REST con Laravel 12 + Sanctum  
Proyecto completo con autenticación, CRUD de Mascotas y Posts.



## 🚀 Requisitos
- PHP 8.2+
- Composer
- MySQL
- Laravel 12
- Postman


## 📦 Instalación

```
git clone https://github.com/fgonmar445/Proyecto_API
cd proyecto_api
composer install
cp .env.example .env
php artisan key:generate
```


## ⚙️ Configura tu base de datos en .env
```
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=
```


## 🔐 Instalación de Laravel Sanctum
```
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

---

# 🔐 1. Rutas de Autenticación (register, login, user)

Estas rutas permiten registrar usuarios, iniciar sesión y obtener el usuario autenticado usando Laravel Sanctum.

```php
// routes/api.php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
```
## Ejemplo JSON para registro - POST register
```
{
  "name": "Ana",
  "email": "ana@example.com",
  "password": "987654321!",
  "password_confirmation": "987654321!"
}
```

<img src="./images/register_user.png">

## 🪙 Añadir Token en Postman

Al crear un usuario mediante la ruta http://127.0.0.1:8000/api/register nos devuelve un token, devemos de añadirlo en la seccion Header.

<img src="./images/token.png">

Lo necesitamos para interactuar como usuario autenticado en Postman y poder recrear las distintas acciones.

---

# CRUD de Mascotas documentado (con capturas)
La API incluye un CRUD completo para la gestión de Mascotas. Todas las rutas están protegidas mediante Laravel Sanctum, por lo que es necesario enviar un token válido en cada petición.


## 📌 POST /api/mascotas — Crear una mascota
Permite registrar una nueva mascota asociada al usuario autenticado.

Ejemplo JSON:

```
json
{
  "nombre": "Toby",
  "edad": 3,
  "especie": "Perro",
  "peso": 10.2,
  "vacunado": true
}
```
<img src="./images/toby.png">
<img src="./images/kira.png">


## 📌 GET /api/mascotas — Listar mascotas
Devuelve todas las mascotas registradas por el usuario autenticado
<img src="./images/get_mascotas.png">


## 📌 PUT /api/mascotas/{id} — Actualizar una mascota

Permite modificar los datos de una mascota existente.

Ejemplo JSON:
```
json
{
  "nombre": "Toby Actualizado",
  "edad": 4,
  "especie": "Perro",
  "peso": 11.0,
  "vacunado": true
}
```
<img src="./images/mascotas_put.png">


## 📌 DELETE /api/mascotas/{id} — Eliminar una mascota
Elimina una mascota del usuario autenticado.<br>
<img src="./images/delete_mascotas.png">

---

# 🧱 2. Descripción de la Arquitectura del Proyecto
Este proyecto sigue la arquitectura estándar de Laravel, organizada en capas que separan la lógica de negocio, el acceso a datos y la gestión de rutas. A continuación se detalla cada parte clave:

## 📂 Estructura de carpetas
Laravel organiza el proyecto en módulos bien definidos:

- app/ → Contiene la lógica principal del backend.

- Models/ → Modelos Eloquent que representan tablas de la base de datos.

- Http/Controllers/ → Controladores que gestionan las peticiones.

- Http/Middleware/ → Filtros que se ejecutan antes o después de cada petición.

- routes/api.php → Archivo donde se definen las rutas de la API.

- database/migrations/ → Migraciones que crean y modifican tablas.

- config/ → Archivos de configuración del framework y paquetes (incluido Sanctum).

Esta estructura permite mantener el código limpio, escalable y fácil de mantener.



## 🎮 Uso de Controladores
Los controladores se encargan de procesar las peticiones HTTP y devolver respuestas JSON.

En este proyecto se utilizan:

- AuthController → Registro, login y gestión del token.

- MascotaController → CRUD completo de Mascotas.

- PostController → CRUD completo de Posts.

- UserController → Listado y filtrado de usuarios.

Cada controlador sigue el patrón RESTful, utilizando métodos como:

- index() → listar

- store() → crear

- show() → mostrar

- update() → actualizar

- destroy() → eliminar

Esto garantiza una API ordenada y fácil de consumir.



## 🧬 Modelos
Los modelos representan las tablas de la base de datos y permiten interactuar con ellas mediante Eloquent ORM.

Modelos utilizados:

- User → Usuarios autenticados.

- Mascota → Mascotas asociadas a un usuario.

- Post → Publicaciones creadas por un usuario.

Cada modelo define:

- Sus atributos

- Sus relaciones (por ejemplo, User tiene muchas Mascotas y muchos Posts)

- Sus reglas de asignación masiva ($fillable)

Ejemplo de relación:
```
php
public function mascotas()
{
    return $this->hasMany(Mascota::class);
}
```


## 🧵 Middleware
El middleware actúa como un filtro entre la petición y la respuesta.

En este proyecto se usa principalmente:

- auth:sanctum → Protege rutas que requieren autenticación.

- EnsureFrontendRequestsAreStateful → Maneja sesiones seguras cuando se usa Sanctum.

Gracias a esto, solo los usuarios autenticados pueden acceder a:

- Mascotas

- Posts

- Datos del usuario

## 🔐 Sanctum
Laravel Sanctum se utiliza para:

- Generar tokens personales

- Proteger rutas de la API

- Asociar recursos al usuario autenticado

Cuando un usuario se registra o inicia sesión, se genera un token:
```
php
$token = $user->createToken('auth_token')->plainTextToken;
```

Este token se envía en Postman mediante:

Código
Authorization: Bearer TOKEN_AQUI
Sanctum permite una autenticación ligera, segura y perfecta para APIs REST.

---
# ⭐ 3. Validaciones usadas en los controladores
La API implementa un sistema de validación sólido en cada uno de los controladores para garantizar que los datos enviados por el cliente sean correctos antes de procesarlos. Esto evita errores, asegura la integridad de la información y protege la base de datos frente a entradas no deseadas o mal formadas.

Laravel proporciona el método validate() que permite definir reglas específicas para cada campo. Estas validaciones se ejecutan automáticamente antes de crear o actualizar un recurso, y en caso de fallo devuelven una respuesta JSON con código 422 Unprocessable Entity, indicando qué campos no cumplen los requisitos.

Las validaciones aplicadas incluyen:

- Tipos de datos (string, integer, numeric, boolean)

- Campos obligatorios mediante required

- Longitudes máximas con max:255

- Valores mínimos como min:0

- Formato correcto de email

- Confirmación de contraseñas

- Validación de relaciones (IDs existentes)

Ejemplo real de validación en el controlador de Mascotas:

```
php
$request->validate([
    'nombre' => 'required|string|max:255',
    'edad' => 'required|integer|min:0',
    'especie' => 'required|string',
    'peso' => 'required|numeric|min:0',
    'vacunado' => 'required|boolean'
]);
```
Este enfoque garantiza que solo se procesen datos válidos y consistentes, reforzando la seguridad y fiabilidad de la API.

---

# 🔐 4. Flujo de Autenticación con Sanctum

1. El usuario se registra o inicia sesión.
2. El servidor genera un token personal con Sanctum.
3. El cliente guarda el token.
4. En cada petición protegida, el cliente envía:
   Authorization: Bearer TOKEN
5. Sanctum valida el token.
6. Si es válido, permite el acceso a Mascotas, Posts y /user.

---

# 🏁 Conclusión

Este proyecto demuestra el uso de Laravel 12 con Sanctum para construir una API REST segura, modular y escalable.  
Incluye autenticación por token, CRUD completos, validaciones robustas y una arquitectura clara basada en controladores, modelos y middleware.  
Ideal para prácticas de backend y consumo desde Postman.
