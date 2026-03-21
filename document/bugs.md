# REPORTE DE DEFECTOS (BUG REPORT)

Proyecto: SIGERD 
Módulo: Gestión de Tareas.

## 1. RESUMEN DEL DEFECTO 
• **ID:** BUG-001 
• **Título:** Un trabajador (Worker) puede visualizar tareas asignadas a otros trabajadores modificando el ID en la URL.
• **Estado:** ASIGNADO 
• **Reportero:** Equipo QA – SIGERD 
• **Fecha:** 20/03/2026 

## 2. CLASIFICACIÓN 
• **Severidad:** MAYOR – Compromete la privacidad y la correcta distribución de la carga laboral al exponer tareas ajenas.
• **Prioridad:** ALTA – Afecta la seguridad y control de acceso del módulo de tareas.

## 3. ENTORNO DE PRUEBAS 
• **Ambiente:** Pruebas (QA)  
• **Dispositivo/Navegador:** Brave / Windows 11
• **Versión del Software:** v1.0 

## 4. PASOS PARA REPRODUCIR 
1. Iniciar sesión en el sistema SIGERD con rol de Trabajador (Worker). 
2. Ir al módulo de "Mis Tareas" desde el menú lateral. 
3. Hacer clic en una de las tareas asignadas para ver sus detalles (ej. la URL será `/worker/tasks/15`).
4. En la barra de direcciones del navegador, cambiar el ID de la tarea por uno numérico aleatorio (ej. cambiar el `15` por `16`) y presionar Enter.
5. Observar la respuesta del sistema al intentar acceder a la tarea con ID 16, la cual pertenece a otro trabajador.

## 5. RESULTADOS 
• **Resultado Esperado:** El sistema debe validar que la tarea solicitada pertenece al usuario en sesión. De no ser así, debe mostrar un error de "Acceso Denegado" (403) o redirigir al listado de tareas propias.
• **Resultado Actual:** El sistema no realiza la validación de propiedad y muestra todos los detalles de la tarea número 16, permitiendo al trabajador ver información que no le corresponde.

## 6. EVIDENCIAS Y LOGS 
• **Captura/Video:**  
• **Anteriormente:** (Falta validación de usuario en `TaskController`)
• **Corregido:** 

## 7. NOTAS ADICIONALES 
• Se ajustó la lógica en el `TaskController` del Worker agregando un middleware o validación directa `where('worker_id', auth()->id())` para restringir el acceso.

---

# REPORTE DE DEFECTOS (BUG REPORT)

Proyecto: SIGERD 
Módulo: Gestión de Incidencias.

## 1. RESUMEN DEL DEFECTO 
• **ID:** BUG-002 
• **Título:** El sistema permite convertir una misma incidencia en múltiples tareas duplicadas.
• **Estado:** ASIGNADO 
• **Reportero:** Equipo QA – SIGERD
• **Fecha:** 20/03/2026 

## 2. CLASIFICACIÓN 
• **Severidad:** MEDIA – Genera redundancia de datos y posible solapamiento de trabajo.
• **Prioridad:** MEDIA – Afecta la integridad del flujo de trabajo de los administradores e instructores.

## 3. ENTORNO DE PRUEBAS 
• **Ambiente:** Pruebas (QA)  
• **Dispositivo/Navegador:** Chrome / MacOS
• **Versión del Software:** v1.0 

## 4. PASOS PARA REPRODUCIR 
1. Iniciar sesión como Administrador.
2. Ir al módulo de Incidencias reportadas por los instructores.
3. Seleccionar una incidencia con estado "Pendiente".
4. Hacer clic en el botón "Convertir a Tarea" y completar el formulario de asignación.
5. Regresar a la incidencia anterior usando el botón "Atrás" del navegador o abriendo la incidencia en una nueva pestaña previa.
6. Volver a hacer clic en "Convertir a Tarea" sobre la misma incidencia.
7. Observar el listado de tareas.

## 5. RESULTADOS 
• **Resultado Esperado:** El sistema debe bloquear el botón "Convertir a Tarea" o mostrar un mensaje indicando que la incidencia ya fue procesada, evitando crear una segunda tarea para el mismo reporte.
• **Resultado Actual:** El sistema permite guardar nuevamente y crea una segunda tarea idéntica en la base de datos vinculada a la misma incidencia.

## 6. EVIDENCIAS Y LOGS 
• **Captura/Video:**  
• **Anteriormente:** 
• **Corregido:** 

## 7. NOTAS ADICIONALES 
• Se solucionó actualizando el estado de la incidencia a "Asignada" en la base de datos dentro de la misma transacción, y validando este estado antes de mostrar el botón o procesar la petición POST.

---

# REPORTE DE DEFECTOS (BUG REPORT)

Proyecto: SIGERD 
Módulo: Reportes PDF.

## 1. RESUMEN DEL DEFECTO 
• **ID:** BUG-003 
• **Título:** Error de tiempo de espera (Timeout) al generar reporte PDF de tareas de todo un año.
• **Estado:** ASIGNADO 
• **Reportero:** Equipo QA – SIGERD
• **Fecha:** 20/03/2026 

## 2. CLASIFICACIÓN 
• **Severidad:** MAYOR – Impide la obtención de estadísticas a largo plazo.
• **Prioridad:** ALTA – El módulo de reportes falla al procesar grandes volúmenes de registros.

## 3. ENTORNO DE PRUEBAS 
• **Ambiente:** Pruebas (QA)  
• **Dispositivo/Navegador:** Edge / Windows 10
• **Versión del Software:** v1.0 

## 4. PASOS PARA REPRODUCIR 
1. Iniciar sesión como Administrador en SIGERD.
2. Ir al módulo de Reportes Consolidados.
3. Seleccionar el rango de fechas "01/01/2025 al 31/12/2025" (un año completo).
4. Hacer clic en el botón "Exportar a PDF".
5. Esperar la respuesta del servidor.

## 5. RESULTADOS 
• **Resultado Esperado:** El sistema debe generar y descargar el archivo PDF con el resumen estadístico solicitado en un tiempo prudencial o procesarlo en segundo plano.
• **Resultado Actual:** Después de 30 segundos, la página muestra un error "504 Gateway Time-out" o "Maximum execution time exceeded" en Laravel, y no se genera ningún documento.

## 6. EVIDENCIAS Y LOGS 
• **Captura/Video:**  
• **Anteriormente:** (Traza del error en `laravel.log`)
• **Corregido:** 

## 7. NOTAS ADICIONALES 
• Se optimizaron las consultas Eager Loading (`with()`) para reducir la carga de memoria. Se implementó una vista gráfica más limpia en el PDF reduciendo el peso de la librería generadora de reportes.
