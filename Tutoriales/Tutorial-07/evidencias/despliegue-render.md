# Tutorial 07 — validación del despliegue Render

Fecha de validación: 2026-11-04 (America/Bogota).

## Configuración

- Web Service `tutorial-07-randomquotes`, rama `main`.
- Repositorio `SailBliss/Isabela-Ruiz-de-la-Ossa-Topicos-Software`.
- Runtime Docker, root directory `Tutoriales/Tutorial-07`, Dockerfile `./Dockerfile`, build context `.`.
- Región Virginia (US East); instancia Free indicada como USD 0/mes.
- Health check configurado en `/health`.
- Proveedor GitHub conectado al repositorio; Auto-Deploy `On Commit`.
- URL: https://tutorial-07-randomquotes.onrender.com/

## Resultados observados

- Primer despliegue: `Deploy succeeded | Live`, fuente commit `437d32695fcd2a8d9bb25a83f2d01d53b01f6c04`.
- Tras guardar el health check `/health`: `Deploy succeeded | Live` (deploy por cambio de configuración, no por push).
- Prueba de Auto-Deploy: se cambió una frase y se publicó el commit `a807c1c441e80a11d59bb42c8dcac4506840c5b3`. Render mostró trigger `Auto-Deploy`, fuente `a807c1c` y estado `Deploy succeeded | Live`.
- GitHub Actions `Tutorial 07 - test Random Quotes` para ese commit concluyó `success` (run 41917765685).
- `GET /`: HTTP 200, frase aleatoria, hostname del contenedor y versión `1.0.0`.
- `GET /health`: HTTP 200, cuerpo `{"status":"ok"}`.
- Doce solicitudes consecutivas a `/`: 12 respuestas HTTP 200, un único hostname de instancia.
- `npm test`: 2 pruebas aprobadas, 0 fallidas.
- Tras el deploy automático, `GET /` y `GET /health` volvieron a responder HTTP 200.

## Alcance

No se crearon recursos AWS. No se verificaron Amazon ECR, cuatro tareas ECS, un ALB, cuatro destinos saludables ni la detención y sustitución de una tarea. Render Free ejecuta una sola instancia y no permite escalarla desde este plan. El panel también avisó que la instancia se suspende por inactividad y que el siguiente inicio puede añadir 50 segundos o más.

Las capturas de entrega deben guardarse aquí cuando la usuaria las comparta. No se han fabricado capturas ni se afirma que exista evidencia visual de acciones no realizadas.
