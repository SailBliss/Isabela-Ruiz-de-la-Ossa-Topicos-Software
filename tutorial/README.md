# Tutoriales 01–04 — Laravel Online Store, carrito y API REST

Proyecto acumulativo Laravel 12 para las páginas y productos (Tutoriales 01–02), carrito de sesión (03) y API REST v1/v2/v3 (04).

## Funcionalidades

- Páginas Home, About y Contact.
- Listado y detalle de productos con precio.
- Redirección segura cuando el identificador de producto no existe.
- Formulario de creación con validación de nombre y precio numérico mayor que cero.
- Confirmación visual al crear un producto válido.
- Menú responsive con acceso a todas las páginas.
- Pruebas automatizadas de los recorridos principales.
- Persistencia de productos con migraciones, recursos JSON versionados y paginación.
- Carrito de sesión vacío, persistente, validado y limpiable.
- API para listar, consultar y crear productos.

## Ejecutar localmente

Requisitos: PHP 8.2 o superior y Composer.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Abra `http://127.0.0.1:8000`.

## Pruebas

```bash
php artisan test
```

La base local de desarrollo usa SQLite. No se ha configurado un motor de base de datos remoto.

## Rutas principales

- `GET /products`, `GET /products/create`, `POST /products/save`, `GET /products/{id}`
- `GET /cart`, `POST /cart/items/{id}`, `DELETE /cart/items`
- `GET /api/products`, `GET /api/products/{id}`, `POST /api/products`
- `GET /api/v2/products`, `GET /api/v2/products/{id}`
- `GET /api/v3/products`, `GET /api/v3/products/paginate?page=2`
