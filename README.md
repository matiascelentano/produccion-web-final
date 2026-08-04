Arcade Shop — Sistema de E-commerce

Trabajo Final — Desarrollo de Aplicación Web con Laravel.

1. Descripción del proyecto y alcance funcional

Arcade Shop es una tienda en línea especializada en repuestos y periféricos arcade (joysticks, botones, fightpads, PCBs/adaptadores y accesorios), desarrollada con Laravel siguiendo el patrón MVC.

La aplicación cubre dos roles principales:

Cliente / Visitante: puede registrarse, iniciar sesión, navegar el catálogo filtrando por categoría y marca, ordenar por precio/antigüedad, agregar productos a una wishlist, gestionar un carrito de compras, comprar un producto individual o finalizar la compra de todo el carrito, ver el historial de sus pedidos, y dejar reseñas de productos que haya comprado.
Administrador: gestiona el CRUD completo de categorías, marcas y productos (incluyendo carga de múltiples imágenes por producto), y visualiza/actualiza el estado de los pedidos realizados por los clientes.

Un subconjunto de esta funcionalidad (catálogo, detalle de producto, pedidos del usuario autenticado y wishlist) además se expone como una API REST que devuelve JSON, como ejercicio introductorio sobre el tema (ver sección 6).

Fuera de alcance / supuestos
No se implementa una pasarela de pago real: el flujo de "compra" simula el proceso pidiendo datos de contacto y dirección de envío, y genera el pedido directamente en estado pendiente.
La autenticación es 100% de sesión (el middleware auth nativo de Laravel); la API reutiliza esa misma sesión y no implementa tokens ni Sanctum.
El envío de emails (verificación, notificaciones de pedido) no está implementado; el registro de usuarios no requiere verificación de correo para operar.

2. Instrucciones de instalación
Requisitos previos
PHP ^8.2
Composer
Node.js y npm
MySQL (u otro motor compatible con Eloquent)

Pasos

# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd arcade-shop

# 2. Instalar dependencias de PHP
composer install

# 3. Copiar el archivo de entorno y generar la clave de la aplicación
cp .env.example .env
php artisan key:generate

# 4. Configurar la base de datos en el archivo .env
#    DB_DATABASE, DB_USERNAME y DB_PASSWORD según tu entorno local

# 5. Correr migraciones y seeders
php artisan migrate --seed

# 6. Crear el symlink de storage (necesario para ver las imágenes de productos)
php artisan storage:link

# 7. Instalar dependencias de Node y compilar los assets
npm install
npm run dev

# 8. Levantar el servidor de desarrollo (en otra terminal)
php artisan serve

Con esto, la aplicación queda disponible en http://127.0.0.1:8000 (o el puerto que indique php artisan serve).

Importante: la variable APP_URL en tu .env debe coincidir exactamente con la URL y el puerto donde accedés al sitio (protocolo, host y puerto), o las imágenes servidas desde storage/ no se van a visualizar correctamente.

3. Credenciales de prueba

El seeder actual (database/seeders/DatabaseSeeder.php) crea automáticamente una cuenta de administrador y cliente:

Rol	            Email	                        Contraseña
Administrador	test@example.com	            password
Cliente         cliente@example.com             password

4. Diagrama Entidad-Relación

El diagrama E-R se encuentra en docs/diagrama e-r.png.

Resumen de las relaciones principales:

users (1) → (N) orders, addresses, reviews — un usuario puede tener múltiples pedidos, direcciones y reseñas.
users (N) ↔ (N) products a través de wishlists — pivote simple sin atributos propios.
categories (N) ↔ (N) products a través de category_product — un producto puede pertenecer a varias categorías.
brands (1) → (N) products — una marca tiene muchos productos, pero cada producto tiene una sola marca (o ninguna).
products (1) → (N) product_images — galería de imágenes por producto.
orders (1) → (N) order_items — cada ítem de un pedido guarda quantity y unit_price "congelados" al momento de la compra, para que cambios futuros en el precio del producto no alteren pedidos históricos.
orders.status está modelado como un Enum de PHP (App\Enums\OrderStatus) con lógica de transición de estados válida encapsulada en el propio Enum (pendiente → pagado → enviado → entregado, o cancelado en cualquier punto antes de enviado).
carts (1) → (N) cart_items — carrito de compras persistente por usuario, independiente de la wishlist.

5. Decisiones de diseño relevantes
Wishlist y category_product sin Model dedicado: al ser pivotes N:M simples sin atributos propios más allá de las claves foráneas, se resuelven con belongsToMany() directo sobre el nombre de la tabla, sin necesitar una clase Eloquent intermedia.
order_items con Model propio: a diferencia de la wishlist, esta pivote sí tiene atributos propios (quantity, unit_price) y se consulta de forma independiente (por ejemplo, para reportes de productos más vendidos), por lo que se modela con hasMany/belongsTo en vez de belongsToMany.
Imágenes de producto: los productos cargados por seeders usan assets estáticos en public/images/, mientras que las imágenes subidas por el administrador desde el panel se guardan en storage/app/public/ (accesibles vía el symlink public/storage). El accessor ProductImage::url() resuelve automáticamente cuál de los dos casos aplica según dónde exista físicamente el archivo.
Middleware de autorización por rol: EnsureUserIsAdmin (alias admin) restringe todo el prefijo /admin a usuarios con role = 'admin', complementando al middleware auth nativo de Laravel (sin usar Sanctum ni paquetes de tokens).
Carrito vs. Wishlist: son dos entidades separadas (carts/cart_items vs. wishlists) porque representan intenciones distintas — el carrito es la intención inmediata de compra con cantidades, mientras que la wishlist es una lista de deseos sin cantidad ni relación con el proceso de checkout.
Transacciones en el checkout: tanto la compra individual como la compra de todo el carrito envuelven la creación del pedido, sus ítems y el descuento de stock dentro de una transacción de base de datos (DB::transaction), evitando pedidos parciales si algo falla a mitad de camino.

6. Rutas principales

Sitio (vistas Blade)
Método	Ruta	Descripción
GET	/	Home
GET	/productos	Catálogo (con filtros por categoría, marca, búsqueda y orden)
GET	/productos/{product}	Detalle de producto
GET, POST	/login, /registro	Autenticación
POST	/logout	Cerrar sesión
GET, POST, DELETE	/carrito	Ver / agregar / quitar productos del carrito
GET, POST, DELETE	/wishlist	Ver / agregar / quitar productos de la wishlist
GET	/mis-pedidos, /mis-pedidos/{order}	Historial y detalle de pedidos del cliente
POST	/productos/{product}/comprar	Compra directa de un producto
POST	/checkout	Finalizar compra de todo el carrito
Panel de administración (/admin, requiere rol admin)
Método	Ruta	Descripción
GET	/admin/dashboard	Panel principal con estadísticas
Resource	/admin/products	CRUD de productos (incluye carga de imágenes)
Resource	/admin/categories	CRUD de categorías
Resource	/admin/brands	CRUD de marcas
GET, PUT	/admin/orders, /admin/orders/{order}	Listado, detalle y actualización de estado de pedidos
API REST (JSON, reutiliza la sesión del sitio)
Método	Ruta	Descripción
GET	/api/products	Listado paginado del catálogo
GET	/api/products/{id}	Detalle de un producto (404 si no existe)
GET	/api/orders	Pedidos del usuario autenticado (401 si no hay sesión)
GET	/api/wishlist	Wishlist del usuario autenticado
POST	/api/wishlist	Agrega un producto a la wishlist
DELETE	/api/wishlist	Remueve un producto de la wishlist