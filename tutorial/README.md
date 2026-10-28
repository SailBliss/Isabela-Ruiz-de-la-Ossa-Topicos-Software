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

## Tutorial 05 — Docker y AWS

Se prepararon el `Dockerfile`, `.dockerignore`, `compose.infra.yaml` y `compose.app.yaml` para desplegar este Laravel con MySQL y phpMyAdmin en la instancia Amazon Linux 2023 asignada al grupo. Los dos proyectos Compose comparten una red individual del estudiante; MySQL publica su puerto solo en `127.0.0.1`, y los datos sobreviven a `down` sin `-v`.

### Valores personales y seguridad

En AWS, copie `.env.aws.example` a `.env` solo si aún no existe. Sustituya el identificador y los puertos por una fila que el grupo haya asignado exclusivamente a usted. Cambie `APP_URL` por la dirección de su instancia. Genere dos contraseñas distintas con `openssl rand -hex 24`, asígnelas a `DB_PASSWORD` y `MYSQL_ROOT_PASSWORD`, y genere `APP_KEY` con `docker run --rm laravel-your-id:1.0 php artisan key:generate --show` después de construir la imagen. Conserve valores existentes si ya hay datos. No publique `.env` ni llaves SSH.

### Construcción y ejecución en la instancia asignada

En la terminal de la instancia EC2 ya asignada, desde la carpeta `tutorial` (la que contiene `artisan` y este `Dockerfile`):

```bash
docker build -t laravel-your-id:1.0 .
docker run --rm laravel-your-id:1.0 php artisan key:generate --show
docker compose -f compose.infra.yaml config --quiet
docker compose -f compose.infra.yaml up -d --wait --wait-timeout 240
docker compose -f compose.app.yaml config --quiet
docker compose -f compose.app.yaml up -d
docker compose -f compose.app.yaml exec --user www-data app php artisan migrate --force
docker compose -f compose.infra.yaml ps
docker compose -f compose.app.yaml ps
```

Antes de acceder, cree en phpMyAdmin la base y el usuario de aplicación a partir de los valores de `.env`; no use el usuario `root` desde Laravel. Abra el puerto HTTP asignado en el Security Group solo si el grupo autoriza acceso público. Si no, use un túnel SSH local y cambie `APP_URL` al puerto local del túnel. No abra MySQL al público.

`docker compose -f compose.app.yaml down` y `docker compose -f compose.infra.yaml down` conservan datos si no se usa `-v`. Vuelva a iniciar primero la infraestructura con `up -d --wait` y después la aplicación.

### Validación realizada

Se desplegó y verificó esta configuración en la instancia EC2 asignada (Amazon Linux 2023, `t3.micro`). Docker y Compose quedaron instalados; la imagen Laravel se construyó y ambos proyectos Compose iniciaron, con MySQL saludable. Se aplicaron las seis migraciones. La página de productos respondió HTTP 200 y la API devolvió el producto `Prueba AWS` por $123.

También se detuvieron y reiniciaron los servicios sin borrar volúmenes. Después del reinicio, la API y la consulta a MySQL confirmaron que el producto seguía persistido. MySQL quedó publicado solo en loopback. Para no abrir puertos de aplicación en el grupo de seguridad, la comprobación HTTP se hizo mediante túneles SSH locales.

Evidencias incluidas en `evidencias/tutorial-05/`:

- `t05-01-instancia-lanzada.png`: instancia EC2 en ejecución.
- `t05-04-producto-creado.png`: confirmación de creación del producto desde Laravel.
- `t05-validation-remote.txt`: versiones, estado de contenedores, permisos SQL, producto consultado por SQL y JSON de API tras reiniciar.

No se incluye captura de detalles de AMI porque mostraba identificadores de cuenta/recurso. Las capturas de configuración SQL con credenciales tampoco deben compartirse. No se validó un acceso HTTP público desde Internet.
