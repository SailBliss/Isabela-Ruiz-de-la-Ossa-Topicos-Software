# Progreso de tutoriales — Tópicos de Software EAFIT

Estados basados en código inspeccionado y verificaciones realmente ejecutadas. Los tutoriales 01–06 tienen commits separados; 07 sigue en implementación local y aún no tiene commit.

| Tutorial | Estado | Verificación / pendiente |
|---|---|---|
| 01 | Verificado | Proyecto existente conservado; pruebas de Laravel ejecutadas satisfactoriamente. |
| 02 | Verificado | Persistencia, migraciones y formulario de productos; pruebas automatizadas satisfactorias. |
| 03 | Verificado | Carrito de sesión (vacío, agregar, persistir, eliminar, limpiar e IDs inválidos); pruebas satisfactorias. |
| 04 | Verificado | API REST versionada, validación, recursos, paginación y autenticación; suite satisfactoria (16 pruebas, 59 aserciones). |
| 05 | Verificado | Docker en EC2, Laravel + MySQL, migraciones y persistencia tras reinicio sin borrar volúmenes. Evidencias en `tutorial/evidencias/tutorial-05/`. No se verificó acceso HTTP público. |
| 06 | Verificado | Node.js 24/Express: 3/3 pruebas; build y ejecución Docker local; imagen construida en la EC2 existente; contenedor activo en TCP 80; 50 comprobaciones HTTP públicas, todas 200 y con las siete frases. Evidencia en `Tutoriales/Tutorial-06/evidencias/despliegue-ec2.txt`. |
| 07 | Implementado, sin verificar | App Express/Docker (Node 22), 2/2 pruebas, build Docker y 20/20 respuestas locales HTTP 200; sintaxis YAML de ambos templates y workflow parseada. CloudFormation para ECR y ECS/ALB (4 tareas), workflow OIDC en `.github/workflows/` y README listos. No se han creado recursos AWS; ALB, tareas, recuperación y Actions quedan sin verificar hasta desplegar con aprobación de costos y permisos de AWS Academy. |

## Commits separados

- Tutorial 01: `168a672` (implementación previa conservada).
- Tutorial 02: `890b037`.
- Tutorial 03: `7f0b11d`.
- Tutorial 04: `7e960c5`.
- Tutorial 05: `101d291`.
- Tutorial 06: `0e38732` (implementación y despliegue verificado).
- Tutorial 07: todavía sin commit; despliegue AWS pendiente de autorización y permisos.

Los commits permanecen locales y no se han enviado a GitHub.
