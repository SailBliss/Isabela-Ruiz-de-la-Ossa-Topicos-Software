# Tutorial 01 — Online Store

Solución completa del tutorial de Laravel 12 sobre rutas, controladores, vistas Blade y validación.

## Funcionalidades

- Páginas Home, About y Contact.
- Listado y detalle de productos con precio.
- Redirección segura cuando el identificador de producto no existe.
- Formulario de creación con validación de nombre y precio numérico mayor que cero.
- Confirmación visual al crear un producto válido.
- Menú responsive con acceso a todas las páginas.
- Pruebas automatizadas de los recorridos principales.

## Ejecutar localmente

Requisitos: PHP 8.2 o superior y Composer.

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Abra `http://127.0.0.1:8000`.

## Pruebas

```bash
php artisan test
```
