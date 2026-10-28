# Progreso de tutoriales — Tópicos de Software EAFIT

Estados basados en código inspeccionado y verificaciones realmente ejecutadas. Los tutoriales 01–05 tienen commits separados; 06 y 07 siguen pendientes.

| Tutorial | Estado | Verificación / pendiente |
|---|---|---|
| 01 | Verificado | Proyecto existente conservado; pruebas de Laravel ejecutadas satisfactoriamente. |
| 02 | Verificado | Persistencia, migraciones y formulario de productos; pruebas automatizadas satisfactorias. |
| 03 | Verificado | Carrito de sesión (vacío, agregar, persistir, eliminar, limpiar e IDs inválidos); pruebas satisfactorias. |
| 04 | Verificado | API REST versionada, validación, recursos, paginación y autenticación; suite satisfactoria (16 pruebas, 59 aserciones). |
| 05 | Verificado | Docker en EC2, Laravel + MySQL, migraciones y persistencia tras reinicio sin borrar volúmenes. Evidencias en `tutorial/evidencias/tutorial-05/`. No se verificó acceso HTTP público. |
| 06 | Verificado | Node.js 24/Express: 3/3 pruebas; build y ejecución Docker local; imagen construida en la EC2 existente; contenedor activo en TCP 80; 50 comprobaciones HTTP públicas, todas 200 y con las siete frases. Evidencia en `Tutoriales/Tutorial-06/evidencias/despliegue-ec2.txt`. |
| 07 | Pendiente | Implementar después del Tutorial 06 y revisar el enunciado. Hay archivos preliminares sin seguimiento en `Tutoriales/Tutorial-07`; no son entrega ni están validados. |

## Commits separados

- Tutorial 01: `168a672` (implementación previa conservada).
- Tutorial 02: `890b037`.
- Tutorial 03: `7f0b11d`.
- Tutorial 04: `7e960c5`.
- Tutorial 05: `101d291`.
- Tutorial 06: commit independiente de implementación y despliegue, actualmente en `HEAD`.

Los commits permanecen locales y no se han enviado a GitHub.
