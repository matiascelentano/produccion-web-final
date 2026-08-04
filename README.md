# Arcade Shop

## Trabajo Final — Desarrollo de Aplicación Web con Laravel

Arcade Shop es una tienda online especializada en repuestos y periféricos arcade (joysticks, botones, fightpads, PCBs, adaptadores y accesorios), desarrollada utilizando Laravel bajo el patrón arquitectónico MVC.

La aplicación implementa un sistema completo de e-commerce con gestión de usuarios, catálogo de productos, carrito de compras, wishlist, pedidos, reseñas y un panel administrativo.

---

# Tabla de contenidos

* [Descripción del proyecto](#descripción-del-proyecto)
* [Alcance funcional](#alcance-funcional)
* [Tecnologías utilizadas](#tecnologías-utilizadas)
* [Instalación](#instalación)
* [Credenciales de prueba](#credenciales-de-prueba)
* [Modelo de datos](#modelo-de-datos)
* [Decisiones de diseño](#decisiones-de-diseño)
* [Rutas principales](#rutas-principales)
* [API REST](#api-rest)

---

# Descripción del proyecto

Arcade Shop permite administrar una tienda virtual dedicada a productos relacionados con sistemas arcade.

La aplicación cuenta con dos tipos principales de usuarios:

* Cliente / Visitante.
* Administrador.

El sistema fue desarrollado siguiendo la arquitectura MVC de Laravel, utilizando Eloquent ORM para la gestión de datos y Blade como motor de vistas.

---

# Alcance funcional

## Cliente / Visitante

Los usuarios pueden:

* Registrarse e iniciar sesión.
* Navegar el catálogo de productos.
* Buscar productos.
* Filtrar productos por categoría y marca.
* Ordenar productos por precio o antigüedad.
* Visualizar detalles de cada producto.
* Agregar productos a una wishlist.
* Administrar un carrito de compras persistente.
* Comprar productos individuales.
* Finalizar la compra completa del carrito.
* Consultar el historial de pedidos.
* Visualizar el detalle de cada pedido.
* Dejar reseñas únicamente sobre productos adquiridos.

---

## Administrador

El administrador cuenta con un panel privado que permite:

* Gestionar categorías mediante CRUD.
* Gestionar marcas mediante CRUD.
* Gestionar productos mediante CRUD.
* Cargar múltiples imágenes por producto.
* Consultar pedidos realizados por clientes.
* Actualizar el estado de los pedidos.

El acceso al panel administrativo está protegido mediante middleware de autorización por rol.

---

# API REST

Una parte del sistema está disponible mediante una API REST que devuelve respuestas en formato JSON.

La API incluye:

* Consulta del catálogo.
* Consulta del detalle de productos.
* Consulta de pedidos del usuario autenticado.
* Gestión de wishlist.

La autenticación utiliza la misma sesión del sitio web. No se implementan tokens ni Sanctum.

---

# Fuera de alcance

Para mantener el alcance del proyecto definido se establecieron los siguientes supuestos:

* No se implementa una pasarela de pago real.
* El proceso de compra simula el pago y genera el pedido directamente en estado pendiente.
* La autenticación funciona mediante sesiones de Laravel.
* No se utilizan tokens de autenticación.
* No se implementa verificación de correo electrónico.
* No se envían emails de confirmación o notificaciones.

---

# Tecnologías utilizadas

| Tecnología   | Uso                            |
| ------------ | ------------------------------ |
| Laravel      | Framework backend              |
| PHP 8.2      | Lenguaje principal             |
| MySQL        | Base de datos                  |
| Eloquent ORM | Manejo de modelos y relaciones |
| Blade        | Motor de plantillas            |
| Bootstrap    | Diseño de interfaz             |
| JavaScript   | Interactividad frontend        |
| Vite         | Compilación de assets          |

---

# Instalación

## Requisitos previos

Antes de instalar el proyecto es necesario contar con:

* PHP ^8.2
* Composer
* Node.js
* npm
* MySQL u otro motor compatible con Eloquent

---

## Instalación del proyecto

Clonar el repositorio:

```bash
git clone <url-del-repositorio>

cd arcade-shop
```

Instalar dependencias de PHP:

```bash
composer install
```

Crear archivo de configuración:

```bash
cp .env.example .env
```

Generar la clave de aplicación:

```bash
php artisan key:generate
```

Configurar la conexión a la base de datos en el archivo `.env`:

```env
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Ejecutar migraciones y seeders:

```bash
php artisan migrate --seed
```

Crear enlace simbólico para almacenamiento:

```bash
php artisan storage:link
```

Instalar dependencias frontend:

```bash
npm install
```

Compilar assets:

```bash
npm run dev
```

Iniciar servidor:

```bash
php artisan serve
```

La aplicación estará disponible en:

```
http://127.0.0.1:8000
```

> Importante: la variable `APP_URL` del archivo `.env` debe coincidir exactamente con la URL utilizada para acceder al sistema. De lo contrario, las imágenes almacenadas en `storage` pueden no visualizarse correctamente.

---

# Credenciales de prueba

El seeder principal (`DatabaseSeeder.php`) genera automáticamente usuarios para probar los diferentes roles.

| Rol           | Email                                             | Contraseña |
| ------------- | ------------------------------------------------- | ---------- |
| Administrador | [test@example.com](mailto:test@example.com)       | password   |
| Cliente       | [cliente@example.com](mailto:cliente@example.com) | password   |

---

# Modelo de datos

El diagrama Entidad-Relación se encuentra ubicado en:

```
docs/diagrama e-r.png
```

---

## Relaciones principales

### Usuarios

```
users (1) → (N) orders
users (1) → (N) addresses
users (1) → (N) reviews
```

Un usuario puede tener múltiples pedidos, direcciones y reseñas.

---

### Wishlist

```
users (N) ↔ (N) products
```

La relación se realiza mediante la tabla pivote:

```
wishlists
```

---

### Categorías

```
categories (N) ↔ (N) products
```

La relación utiliza:

```
category_product
```

Un producto puede pertenecer a múltiples categorías.

---

### Marcas

```
brands (1) → (N) products
```

Una marca puede tener múltiples productos.

---

### Imágenes

```
products (1) → (N) product_images
```

Cada producto puede contener múltiples imágenes.

---

### Pedidos

```
orders (1) → (N) order_items
```

Cada pedido contiene uno o varios productos.

Los elementos del pedido almacenan:

* Cantidad.
* Precio unitario al momento de compra.

Esto permite conservar el historial aunque el precio del producto cambie posteriormente.

---

### Carrito

```
carts (1) → (N) cart_items
```

El carrito es independiente de la wishlist y mantiene las cantidades seleccionadas para la compra.

---

# Estados de pedidos

Los estados se manejan mediante un Enum:

```
App\Enums\OrderStatus
```

Las transiciones válidas son:

```
Pendiente
    ↓
Pagado
    ↓
Enviado
    ↓
Entregado
```

También existe la posibilidad de cancelar un pedido antes de que sea enviado.

---

# Decisiones de diseño

## Wishlist y category_product

Ambas relaciones se implementan como tablas pivote simples mediante `belongsToMany()`.

No poseen modelos Eloquent propios debido a que no contienen atributos adicionales.

---

## Order Items

A diferencia de las tablas pivote simples, `order_items` posee información propia:

* quantity
* unit_price

Además, puede consultarse de forma independiente para generar reportes o estadísticas.

Por este motivo se implementó como un modelo Eloquent separado.

---

## Gestión de imágenes

Los productos pueden obtener imágenes desde dos ubicaciones:

Productos cargados mediante seeders:

```
public/images/
```

Productos cargados desde el panel administrativo:

```
storage/app/public/
```

El método `ProductImage::url()` determina automáticamente la ubicación correcta del archivo.

---

## Middleware de autorización

El panel administrativo utiliza:

```
EnsureUserIsAdmin
```

Este middleware verifica que el usuario autenticado tenga:

```
role = admin
```

Además, se mantiene la protección estándar mediante:

```
auth middleware
```

---

## Carrito y Wishlist

Ambas funcionalidades están separadas porque representan diferentes intenciones del usuario.

Carrito:

* Productos destinados a una compra.
* Maneja cantidades.
* Participa en el checkout.

Wishlist:

* Productos guardados para futuro interés.
* No posee cantidades.
* No participa en la compra.

---

## Checkout y transacciones

El proceso de compra utiliza:

```php
DB::transaction()
```

Esto garantiza que:

* La creación del pedido.
* La creación de sus productos.
* La actualización del stock.

Se realicen correctamente como una única operación.

---

# Rutas principales

## Sitio web

| Método          | Ruta                           | Descripción          |
| --------------- | ------------------------------ | -------------------- |
| GET             | `/`                            | Página principal     |
| GET             | `/productos`                   | Catálogo             |
| GET             | `/productos/{product}`         | Detalle del producto |
| GET/POST        | `/login`                       | Inicio de sesión     |
| GET/POST        | `/registro`                    | Registro             |
| POST            | `/logout`                      | Cierre de sesión     |
| GET/POST/DELETE | `/carrito`                     | Gestión del carrito  |
| GET/POST/DELETE | `/wishlist`                    | Gestión wishlist     |
| GET             | `/mis-pedidos`                 | Historial de pedidos |
| GET             | `/mis-pedidos/{order}`         | Detalle del pedido   |
| POST            | `/productos/{product}/comprar` | Compra individual    |
| POST            | `/checkout`                    | Compra del carrito   |

---

# Panel administrativo

Todas las rutas requieren autenticación y rol administrador.

| Método   | Ruta                | Descripción        |
| -------- | ------------------- | ------------------ |
| GET      | `/admin/dashboard`  | Dashboard          |
| Resource | `/admin/products`   | CRUD productos     |
| Resource | `/admin/categories` | CRUD categorías    |
| Resource | `/admin/brands`     | CRUD marcas        |
| GET/PUT  | `/admin/orders`     | Gestión de pedidos |

---

# API REST

Todas las respuestas utilizan formato JSON.

| Método | Endpoint             | Descripción                     |
| ------ | -------------------- | ------------------------------- |
| GET    | `/api/products`      | Lista paginada de productos     |
| GET    | `/api/products/{id}` | Detalle de producto             |
| GET    | `/api/orders`        | Pedidos del usuario autenticado |
| GET    | `/api/wishlist`      | Wishlist del usuario            |
| POST   | `/api/wishlist`      | Agregar producto                |
| DELETE | `/api/wishlist`      | Eliminar producto               |

---
