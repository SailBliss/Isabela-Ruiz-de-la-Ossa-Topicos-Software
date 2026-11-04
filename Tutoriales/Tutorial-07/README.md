# Tutorial 07: Microservicios con Docker en Render

Este tutorial publica la aplicación `randomquotes` (Node.js, Express y Docker) en Render. La guía de clase describe AWS ECS/Fargate, ECR y un Application Load Balancer; para esta entrega se usa el plan gratuito de Render, como alternativa autorizada por el profesor. El servicio ya está desplegado y accesible en la URL pública indicada abajo.

## Arquitectura de esta entrega

`GitHub (main) → Render (construye el Dockerfile y ejecuta el servicio web) → URL pública`

Render construye la imagen desde el `Dockerfile`, entrega tráfico HTTP y consulta `/health`. El servicio usa una sola instancia gratuita. La cuenta de Render administra la infraestructura de entrada y el ciclo de vida; esta alternativa no expone un repositorio ECR, cuatro tareas ECS ni un ALB que podamos configurar o inspeccionar.

## Requisitos

- Repositorio GitHub conectado a Render.
- Servicio Web de Render con runtime Docker.
- Para la prueba local: Node.js 22 o posterior, npm y Docker.

## Ejecutar y probar localmente

Desde `Tutoriales/Tutorial-07`:

```bash
npm ci
npm test
npm start
```

La app escucha en `PORT` (80 por defecto) y en `0.0.0.0`. Abra `http://localhost:80/`; `/health` devuelve `{"status":"ok"}`.

Prueba opcional con Docker:

```bash
docker build -t randomquotes:local .
docker run --rm -p 8080:80 randomquotes:local
```

Abra `http://localhost:8080/` y `http://localhost:8080/health`.

## Despliegue en Render

La configuración del servicio `tutorial-07-randomquotes` es:

- Repositorio: `SailBliss/Isabela-Ruiz-de-la-Ossa-Topicos-Software`, rama `main`.
- Runtime: Docker.
- Root Directory: `Tutoriales/Tutorial-07`.
- Dockerfile Path: `./Dockerfile`.
- Docker Build Context: `.`.
- Región: Virginia (US East).
- Plan: Free, mostrado por Render como USD 0/mes.
- Health Check Path: `/health`.
- Auto-Deploy: pendiente. El servicio se creó desde la pestaña **Public Git Repository**, que no activa Auto-Deploy; por ahora los cambios se publican manualmente desde Render.

Para repetir el despliegue desde Render:

1. Seleccione **New → Web Service** y conecte el repositorio de GitHub.
2. Elija la rama `main`, runtime **Docker** y carpeta raíz `Tutoriales/Tutorial-07`.
3. Seleccione región **Virginia (US East)** y el plan **Free**.
4. Cree el servicio y espere el estado **Deploy succeeded | Live**.
5. En **Settings → Health Checks**, establezca `/health`.
6. La fuente actual es **Public Git Repository** y no dispone de Auto-Deploy. Para desplegar una actualización, use **Manual Deploy**; para automatizarlo, conecte el proveedor GitHub en Render y autorice el acceso al repositorio.

### URL y validación del despliegue

- Aplicación: <https://tutorial-07-randomquotes.onrender.com/>
- Salud: <https://tutorial-07-randomquotes.onrender.com/health>
- La raíz devolvió HTTP 200 con una frase, hostname del contenedor y versión `1.0.0`.
- `/health` devolvió HTTP 200 y `{"status":"ok"}`.
- Se ejecutaron 12 solicitudes seguidas a `/`; todas devolvieron HTTP 200 y el mismo hostname, como corresponde a una sola instancia.
- `npm test`: 2 pruebas pasaron, 0 fallaron.
- El historial de Render mostró el despliegue inicial **Deploy succeeded | Live** y otro despliegue exitoso al guardar `/health` como health check. Ese segundo despliegue fue por cambio de configuración, no por un push a GitHub.

Los resultados reproducibles y el alcance de esta validación están en [`evidencias/despliegue-render.md`](evidencias/despliegue-render.md). Las capturas de pantalla de entrega se añadirán a `evidencias/` cuando estén disponibles.

## Qué demuestra esta alternativa

| Objetivo de la guía AWS | Evidencia o límite en Render Free |
|---|---|
| Crear y publicar una imagen en ECR | Render construye la imagen desde el Dockerfile; no se crea un repositorio ECR accesible para esta práctica. |
| Ejecutar cuatro réplicas en ECS | Render Free usa una instancia y no permite escalar el servicio. Las 12 solicitudes observaron el mismo hostname. |
| Balancear tráfico con un ALB | La URL pública recibe tráfico a través de Render, pero no se configura ni inspecciona un ALB propio ni se puede comparar el reparto entre cuatro tareas. |
| Comprobar salud | La app expone `/health` y Render tiene esa ruta configurada como health check. |
| Detener una tarea y observar su reemplazo por ECS | El plan gratuito no da acceso SSH ni permite administrar o detener directamente una tarea/instancia. Esta prueba específica de ECS no se puede hacer aquí. |
| Automatizar el despliegue | El workflow `tutorial-07-ci.yml` está preparado para ejecutar las pruebas en GitHub Actions. La conexión actual no auto-publica pushes; se requiere enlazar GitHub con Render o usar un deploy hook. No se usan credenciales AWS ni OIDC para esta ruta. |

### Conceptos para explicar en la entrega

En AWS, el Application Load Balancer acepta las solicitudes y las distribuye entre los destinos saludables del target group. El ECS Service conserva el número deseado de tareas y lanza un reemplazo cuando una deja de estar disponible. El health check permite excluir destinos que no responden correctamente.

En Render Free se verificó la ruta de salud y la respuesta pública del servicio, pero no cuatro réplicas, la distribución entre hostnames ni el reemplazo manual de una tarea ECS. Esas diferencias deben quedar explícitas al presentar la evidencia.

## Limitaciones del plan gratuito

Render indica que una instancia Free puede suspenderse tras un periodo sin tráfico y que la siguiente solicitud puede tardar en despertar el servicio. El panel informó que el inicio puede añadir 50 segundos o más. El plan Free también limita el servicio a una instancia; consulta los [límites actuales de Render Free](https://render.com/docs/free). El plan elegido aparece como USD 0/mes, sujeto a los límites y condiciones vigentes de Render.

## Evidencias de entrega

Guardar capturas reales en `evidencias/`:

1. Panel de Render con el despliegue **Live** y la URL del servicio.
2. Página pública `/` mostrando una frase y el hostname.
3. Página `/health` mostrando `{"status":"ok"}`.
4. Settings de Render con Docker, plan Free, carpeta raíz y health check `/health`.
5. Ejecución exitosa de GitHub Actions. Para evidenciar publicación automática después de un cambio en `main`, primero hay que conectar el proveedor GitHub a Render.

La captura no debe afirmar que se observaron cuatro hostnames ni cuatro tareas: Render Free no permite esa verificación.

## Limpieza

Si ya no necesita la URL, puede suspender o eliminar el Web Service desde Render. Antes de eliminarlo, guarde las capturas y la URL requerida para la entrega. Este despliegue no creó recursos en AWS.
