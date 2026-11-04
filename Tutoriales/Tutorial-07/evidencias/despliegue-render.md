# Tutorial 07 — validación del despliegue Render

Fecha de validación: 2026-11-04 (America/Bogota).

## Configuración

- Web Service `tutorial-07-randomquotes`, rama `main`.
- Repositorio `SailBliss/Isabela-Ruiz-de-la-Ossa-Topicos-Software`.
- Runtime Docker, root directory `Tutoriales/Tutorial-07`, Dockerfile `./Dockerfile`, build context `.`.
- Región Virginia (US East); instancia Free indicada como USD 0/mes.
- Health check configurado en `/health`.
- Auto-Deploy habilitado desde la rama conectada.
- URL: https://tutorial-07-randomquotes.onrender.com/

## Resultados observados

- Primer despliegue: `Deploy succeeded | Live`, fuente commit `437d32695fcd2a8d9bb25a83f2d01d53b01f6c04`.
- Tras guardar el health check `/health`: `Deploy succeeded | Live`.
- `GET /`: HTTP 200, frase aleatoria, hostname del contenedor y versión `1.0.0`.
- `GET /health`: HTTP 200, cuerpo `{"status":"ok"}`.
- Doce solicitudes consecutivas a `/`: 12 respuestas HTTP 200, un único hostname de instancia.
- `npm test`: 2 pruebas aprobadas, 0 fallidas.

## Alcance

No se crearon recursos AWS. No se verificaron Amazon ECR, cuatro tareas ECS, un ALB, cuatro destinos saludables ni la detención y sustitución de una tarea. Render Free ejecuta una sola instancia y no permite escalarla desde este plan. El panel también avisó que la instancia se suspende por inactividad y que el siguiente inicio puede añadir 50 segundos o más.

Las capturas de entrega deben guardarse aquí cuando la usuaria las comparta. No se han fabricado capturas ni se afirma que exista evidencia visual de acciones no realizadas.
