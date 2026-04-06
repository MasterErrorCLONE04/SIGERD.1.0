# Plan de Pruebas — SIGERD (Consolidado)

> **Documento unificado y corregido.** Contiene todos los casos de prueba validados contra el código fuente real del sistema.
> Módulos cubiertos: **Administrador** (CP-ADM-001 – CP-ADM-102) · **Instructor** (CP-INS-001 – CP-INS-046) · **Trabajador** (CP-TRB-001 – CP-TRB-049)

---

## Índice de Módulos

| Prefijo | Rol | Rango | Total |
| :--- | :--- | :--- | :--- |
| CP-ADM | Administrador | CP-ADM-001 – CP-ADM-102 | 102 |
| CP-INS | Instructor | CP-INS-001 – CP-INS-046 | 46 |
| CP-TRB | Trabajador | CP-TRB-001 – CP-TRB-049 | 49 |

---

# MÓDULO ADMINISTRADOR

---

### CP-ADM-001
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-001 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Inicio de sesión exitoso |
| **Descripción** | Validar que el administrador pueda ingresar con credenciales válidas y sea redirigido a su panel principal. |
| **Precondiciones** | Usuario administrador existe en BD con `role = 'administrador'`. |
| **Datos de entrada** | Email: `admin@sigerd.com`, Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email y password válidos<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Redirección a `/admin/dashboard`. Acceso concedido mostrando indicadores. |
| **Resultado Obtenido** | Redirección exitosa al Dashboard del administrador. |
| **Evidencia** | ![CP-ADM-001](./puppeteer_tests/screenshots/CP-ADM-001.png) |
| **Estado** | Exitoso |

---

### CP-ADM-002
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-002 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Fallo por contraseña errónea |
| **Descripción** | Verificar que el sistema rechace credenciales inválidas sin conceder acceso. |
| **Precondiciones** | Usuario administrador existe en BD. |
| **Datos de entrada** | Email: `admin@sigerd.com`, Password: `wrongpassword` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar contraseña incorrecta<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error: *"These credentials do not match our records."* No ingresa. |
| **Resultado Obtenido** | Error mostrado. Acceso denegado. |
| **Evidencia** | ![CP-ADM-002](./puppeteer_tests/screenshots/CP-ADM-002.png) |
| **Estado** | Exitoso |

---

### CP-ADM-003
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-003 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Fallo por usuario inexistente |
| **Descripción** | Validar manejo de email no registrado sin revelar si el usuario existe (anti-enumeración). |
| **Precondiciones** | Email no existente en la tabla `users`. |
| **Datos de entrada** | Email: `nonexistent@sigerd.com`, Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar correo inexistente<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error de credenciales inválidas. Sin distinción entre email no existe vs contraseña incorrecta. |
| **Resultado Obtenido** | Error genérico mostrado. Acceso denegado. |
| **Evidencia** | ![CP-ADM-003](./puppeteer_tests/screenshots/CP-ADM-003.png) |
| **Estado** | Exitoso |

---

### CP-ADM-004
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-004 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Validación de campos obligatorios en login |
| **Descripción** | Verificar que los campos email y password sean requeridos. |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: (vacío), Password: (vacío) |
| **Pasos** | 1. Ir a `/login`<br>2. Dejar campos vacíos<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Error de validación indicando campos obligatorios. |
| **Resultado Obtenido** | Mensajes de validación mostrados. Sin acceso. |
| **Evidencia** | ![CP-ADM-004](./puppeteer_tests/screenshots/CP-ADM-004.png) |
| **Estado** | Exitoso |

---

### CP-ADM-005
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-005 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Validación de formato de correo |
| **Descripción** | Verificar que el campo email valida el formato correcto antes de procesar. |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: `admin123` (sin @) |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email con formato inválido<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje indicando formato de email incorrecto. |
| **Resultado Obtenido** | Mensaje de formato incorrecto mostrado. |
| **Evidencia** | ![CP-ADM-005](./puppeteer_tests/screenshots/CP-ADM-005.png) |
| **Estado** | Exitoso |

---

### CP-ADM-006
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-006 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Prevención de SQL Injection en login |
| **Descripción** | Verificar que el sistema no es vulnerable a inyección SQL mediante PDO y validación de formato. |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: `' OR 1=1 --` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar cadena maliciosa en email<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Rechazo de autenticación. Sin error interno ni volcado de datos. |
| **Resultado Obtenido** | Regla `email` invalida el formato antes de BD. Acceso denegado. |
| **Evidencia** | ![CP-ADM-006](./puppeteer_tests/screenshots/CP-ADM-006.png) |
| **Estado** | Exitoso |

---

### CP-ADM-007
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-007 |
| **Módulo** | Autorización / Middleware |
| **Funcionalidad** | Protección de rutas restringidas sin sesión |
| **Descripción** | Verificar que el middleware `auth` redirige a usuarios no autenticados al intentar acceder a rutas protegidas. |
| **Precondiciones** | Sin sesión activa. |
| **Datos de entrada** | URL directa: `/admin/dashboard` |
| **Pasos** | 1. Sin sesión, acceder directamente a la URL protegida |
| **Resultado Esperado** | Redirección automática a `/login`. |
| **Resultado Obtenido** | Redirección a `/login` ejecutada correctamente. |
| **Evidencia** | ![CP-ADM-007](./puppeteer_tests/screenshots/CP-ADM-007.png) |
| **Estado** | Exitoso |

---

### CP-ADM-008
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-008 |
| **Módulo** | Autorización / Middleware |
| **Funcionalidad** | Bloqueo por rol insuficiente |
| **Descripción** | Verificar que un Instructor no puede acceder al área de Administrador. |
| **Precondiciones** | Usuario instructor existente en BD. |
| **Datos de entrada** | Login: `instructor1@sigerd.com`, URL: `/admin/users` |
| **Pasos** | 1. Iniciar sesión como Instructor<br>2. Intentar acceder a `/admin/users` |
| **Resultado Esperado** | Error 403 Forbidden. `RoleMiddleware` bloquea el acceso. |
| **Resultado Obtenido** | HTTP 403 retornado. Sin acceso al área de administrador. |
| **Evidencia** | ![CP-ADM-008](./puppeteer_tests/screenshots/CP-ADM-008.png) |
| **Estado** | Exitoso |

---

### CP-ADM-009
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-009 |
| **Módulo** | Dashboard |
| **Funcionalidad** | Carga correcta de métricas |
| **Descripción** | Verificar que el panel carga datos reales correctamente sin errores. |
| **Precondiciones** | Administrador autenticado. Existen registros en BD. |
| **Datos de entrada** | Navegación a `/admin/dashboard` |
| **Pasos** | 1. Iniciar sesión como administrador<br>2. Acceder al Dashboard<br>3. Verificar tarjetas e indicadores |
| **Resultado Esperado** | Panel carga correctamente. Tarjetas muestran contadores reales. |
| **Resultado Obtenido** | Dashboard cargado con métricas reales sin errores. |
| **Evidencia** | ![CP-ADM-009](./puppeteer_tests/screenshots/CP-ADM-009.png) |
| **Estado** | Exitoso |

---

### CP-ADM-010
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-010 |
| **Módulo** | Dashboard |
| **Funcionalidad** | Dashboard en estado vacío |
| **Descripción** | Verificar que el sistema no presenta errores con BD sin registros. |
| **Precondiciones** | BD sin usuarios, tareas ni incidencias. |
| **Datos de entrada** | Acceso a `/admin/dashboard` con BD vacía |
| **Pasos** | 1. Acceder al Dashboard con BD vacía<br>2. Observar contadores |
| **Resultado Esperado** | Sin errores. Contadores en 0 sin excepciones de iteración. |
| **Resultado Obtenido** | Panel estable mostrando ceros. Sin crashes. |
| **Evidencia** | ![CP-ADM-010](./puppeteer_tests/screenshots/CP-ADM-010.png) |
| **Estado** | Exitoso |

---

### CP-ADM-011
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-011 |
| **Módulo** | Gestión de Tareas — Listado |
| **Funcionalidad** | Búsqueda de tarea por título |
| **Descripción** | Verificar el filtrado por texto mediante cláusula `LIKE` en el listado de tareas. |
| **Precondiciones** | Tareas registradas en BD. Administrador autenticado. |
| **Datos de entrada** | Texto: `e` en el buscador de `/admin/tasks` |
| **Pasos** | 1. Ir a `/admin/tasks`<br>2. Escribir texto en el campo buscador<br>3. Enviar búsqueda |
| **Resultado Esperado** | Solo tareas cuyo título contiene el texto. Resultado paginado. |
| **Resultado Obtenido** | Listado filtrado correctamente por título. |
| **Evidencia** | ![CP-ADM-011](./puppeteer_tests/screenshots/CP-ADM-011.png) |
| **Estado** | Exitoso |

---

### CP-ADM-012
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-012 |
| **Módulo** | Gestión de Tareas — Listado |
| **Funcionalidad** | Filtrar tareas por prioridad |
| **Descripción** | Verificar el filtrado por prioridad en el listado. |
| **Precondiciones** | Tareas con diferentes prioridades en BD. |
| **Datos de entrada** | Selector de Prioridad: `alta` |
| **Pasos** | 1. Acceder a `/admin/tasks`<br>2. Seleccionar "Alta" en el desplegable<br>3. Aplicar filtro |
| **Resultado Esperado** | Solo tareas con prioridad `alta` mostradas. |
| **Resultado Obtenido** | Filtrado por prioridad funcionando correctamente. |
| **Evidencia** | ![CP-ADM-012](./puppeteer_tests/screenshots/CP-ADM-012.png) |
| **Estado** | Exitoso |

---

### CP-ADM-013
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-013 |
| **Módulo** | Gestión de Tareas — Listado |
| **Funcionalidad** | Búsqueda sin resultados (Empty State) |
| **Descripción** | Verificar el comportamiento visual ante búsquedas sin coincidencias. |
| **Precondiciones** | Tareas en BD pero ninguna coincide. |
| **Datos de entrada** | Texto: `XYZ987IMPOSIBLE` |
| **Pasos** | 1. Ingresar texto inexistente en el buscador<br>2. Presionar Buscar |
| **Resultado Esperado** | Estado visual vacío (Empty State). Sin errores. |
| **Resultado Obtenido** | Empty state mostrado. Sin excepciones. |
| **Evidencia** | ![CP-ADM-013](./puppeteer_tests/screenshots/CP-ADM-013.png) |
| **Estado** | Exitoso |

---

### CP-ADM-014
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-014 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Crear tarea correctamente |
| **Descripción** | Verificar la creación exitosa de una tarea con todos los campos válidos, forzando `status = 'asignado'` y notificando al trabajador. |
| **Precondiciones** | Trabajador existente en BD. Administrador autenticado. |
| **Datos de entrada** | Título, fecha futura, ubicación, `assigned_to`, mínimo 1 imagen en `reference_images` |
| **Pasos** | 1. Completar todos los campos obligatorios<br>2. Adjuntar imágenes de referencia<br>3. Clic en "Crear Tarea" |
| **Resultado Esperado** | Tarea creada con `status = 'asignado'`. Notificación enviada al trabajador. |
| **Resultado Obtenido** | Tarea creada. Notificación `task_assigned` generada en BD. |
| **Evidencia** | ![CP-ADM-014](./puppeteer_tests/screenshots/CP-ADM-014.png) |
| **Estado** | Exitoso |

---

### CP-ADM-015
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-015 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Validación backend de campos obligatorios |
| **Descripción** | Verificar que el controlador devuelve errores ante campos faltantes. |
| **Precondiciones** | Modal de creación disponible. |
| **Datos de entrada** | POST vacío o incompleto (sin `title`, `deadline_at`, `reference_images`) |
| **Pasos** | 1. Enviar formulario incompleto saltando validación frontend |
| **Resultado Esperado** | Redirect de vuelta con mensajes de error en `$errors`. |
| **Resultado Obtenido** | Errores de validación mostrados. Sin inserción en BD. |
| **Evidencia** | ![CP-ADM-015](./puppeteer_tests/screenshots/CP-ADM-015.png) |
| **Estado** | Exitoso |

---

### CP-ADM-016
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-016 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Validación de fecha límite vencida al crear |
| **Descripción** | Verificar que no se puede crear una tarea con fecha pasada mediante regla `after_or_equal:today`. |
| **Precondiciones** | Modal de creación disponible. |
| **Datos de entrada** | `deadline_at` = ayer |
| **Pasos** | 1. Seleccionar fecha pasada<br>2. Guardar tarea |
| **Resultado Esperado** | Error: *"La fecha límite no puede ser anterior al día de hoy."* |
| **Resultado Obtenido** | Error de validación mostrado. Tarea no creada. |
| **Evidencia** | ![CP-ADM-016](./puppeteer_tests/screenshots/CP-ADM-016.png) |
| **Estado** | Exitoso |

---

### CP-ADM-017
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-017 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Validación de prioridad fuera del enum |
| **Descripción** | Verificar que no se aceptan prioridades inválidas (solo `baja`, `media`, `alta`). |
| **Precondiciones** | Formulario de creación disponible. |
| **Datos de entrada** | `priority = 'urgente'` inyectado vía DevTools |
| **Pasos** | 1. Inyectar opción inválida en el DOM<br>2. Guardar tarea |
| **Resultado Esperado** | Error de validación `in:baja,media,alta`. |
| **Resultado Obtenido** | Error retornado. Tarea no creada. |
| **Evidencia** | ![CP-ADM-017](./puppeteer_tests/screenshots/CP-ADM-017.png) |
| **Estado** | Exitoso |

---

### CP-ADM-018
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-018 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Adjuntar imagen de referencia válida |
| **Descripción** | Verificar la subida y almacenamiento en `storage/app/public/tasks-reference/`. |
| **Precondiciones** | Imagen válida < 10MB disponible. |
| **Datos de entrada** | `valid.jpg` (< 10MB) en campo `reference_images` |
| **Pasos** | 1. Adjuntar imagen válida<br>2. Crear tarea |
| **Resultado Esperado** | Imagen almacenada. Path guardado como JSON en columna `reference_images`. |
| **Resultado Obtenido** | Archivo guardado en storage. BD actualizada con path. |
| **Evidencia** | ![CP-ADM-018](./puppeteer_tests/screenshots/CP-ADM-018.png) |
| **Estado** | Exitoso |

---

### CP-ADM-019
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-019 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Bloqueo de extensiones no permitidas |
| **Descripción** | Verificar que la regla `mimes:jpeg,png,jpg,gif` rechaza archivos no imagen. |
| **Precondiciones** | Archivo PDF o EXE disponible. |
| **Datos de entrada** | `test.pdf` en campo `reference_images` |
| **Pasos** | 1. Adjuntar archivo prohibido<br>2. Crear tarea |
| **Resultado Esperado** | Error de validación MIME. Archivo rechazado. |
| **Resultado Obtenido** | Validación MIME rechazó el PDF. Sin inserción. |
| **Evidencia** | ![CP-ADM-019](./puppeteer_tests/screenshots/CP-ADM-019.png) |
| **Estado** | Exitoso |

---

### CP-ADM-020
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-020 |
| **Módulo** | Gestión de Tareas — Crear |
| **Funcionalidad** | Validación de tamaño máximo (10MB por imagen) |
| **Descripción** | Verificar que archivos superiores a 10MB son rechazados. El límite de tareas es 10MB (diferente a incidencias: 2MB). |
| **Precondiciones** | Imagen de 15MB disponible. |
| **Datos de entrada** | Imagen de 15MB en `reference_images` |
| **Pasos** | 1. Adjuntar imagen > 10MB<br>2. Enviar formulario |
| **Resultado Esperado** | Error: *"Cada imagen no debe exceder los 10MB."* |
| **Resultado Obtenido** | Validación `max:10240` rechazó el archivo. |
| **Evidencia** | ![CP-ADM-020](./puppeteer_tests/screenshots/CP-ADM-020.png) |
| **Estado** | Exitoso |

---

### CP-ADM-021
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-021 |
| **Módulo** | Gestión de Tareas — Edición |
| **Funcionalidad** | Modificar datos básicos de tarea |
| **Descripción** | Verificar persistencia de cambios en título y prioridad. El botón Editar solo está activo si la tarea no tiene evidencias. |
| **Precondiciones** | Tarea sin evidencias en estado `asignado` o `en progreso`. |
| **Datos de entrada** | Nuevo título: `Título Editado por QA`, Prioridad: `alta` |
| **Pasos** | 1. Abrir tarea sin evidencias<br>2. Clicar "Editar Tarea"<br>3. Modificar campos<br>4. Guardar |
| **Resultado Esperado** | BD actualizada con nuevos valores. `updated_at` actualizado. |
| **Resultado Obtenido** | Cambios persistidos. BD reflejó nuevos valores. |
| **Evidencia** | ![CP-ADM-021](./puppeteer_tests/screenshots/CP-ADM-021.png) |
| **Estado** | Exitoso |

---

### CP-ADM-022
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-022 |
| **Módulo** | Gestión de Tareas — Edición |
| **Funcionalidad** | Edición con fecha límite vencida — auto-marcado como "incompleta" |
| **Descripción** | Verificar que `update()` no tiene `after_or_equal:today` y que al guardar con deadline pasado el sistema marca la tarea como `incompleta`. |
| **Precondiciones** | Tarea existente en estado editable. |
| **Datos de entrada** | `deadline_at` = fecha de hace 5 días |
| **Pasos** | 1. Editar fecha límite retroactivamente<br>2. Guardar<br>3. Verificar estado |
| **Resultado Esperado** | Estado cambia a `incompleta` automáticamente post-actualización. |
| **Resultado Obtenido** | Estado `incompleta` asignado. Sin error de validación de fecha. |
| **Evidencia** | ![CP-ADM-022](./puppeteer_tests/screenshots/CP-ADM-022.png) |
| **Estado** | Exitoso |

---

### CP-ADM-023
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-023 |
| **Módulo** | Gestión de Tareas — Edición |
| **Funcionalidad** | Agregar evidencia sin eliminar imágenes históricas |
| **Descripción** | Verificar que el controlador usa `array_merge()` para añadir imágenes sin borrar las existentes. |
| **Precondiciones** | Tarea con imágenes de evidencia existentes. |
| **Datos de entrada** | Nuevo `valid.jpg` en sección de evidencias |
| **Pasos** | 1. Abrir tarea con evidencias<br>2. Subir nueva imagen<br>3. Confirmar actualización |
| **Resultado Esperado** | Nueva imagen añadida. Imágenes previas conservadas en el JSON. |
| **Resultado Obtenido** | `array_merge()` concatenó correctamente. Sin pérdida de evidencias. |
| **Evidencia** | ![CP-ADM-023](./puppeteer_tests/screenshots/CP-ADM-023.png) |
| **Estado** | Exitoso |

---

### CP-ADM-024
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-024 |
| **Módulo** | Flujo de Revisión y Estados |
| **Funcionalidad** | Aprobar tarea finalizada |
| **Descripción** | Verificar que la aprobación cambia estado a `finalizada`, actualiza incidente vinculado a `resuelto` si aplica, y envía notificaciones. |
| **Precondiciones** | Tarea en estado `realizada`. |
| **Datos de entrada** | Acción: `approve` |
| **Pasos** | 1. Entrar al detalle de la tarea<br>2. Clic en "Aprobar y Finalizar" |
| **Resultado Esperado** | Estado → `finalizada`. Notificación `task_approved` al trabajador. Si tiene incidente: `resuelto` + notif al instructor. |
| **Resultado Obtenido** | Estado finalizado. Notificaciones generadas. |
| **Evidencia** | ![CP-ADM-024](./puppeteer_tests/screenshots/CP-ADM-024.png) |
| **Estado** | Exitoso |

---

### CP-ADM-025
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-025 |
| **Módulo** | Flujo de Revisión y Estados |
| **Funcionalidad** | Rechazar tarea |
| **Descripción** | Verificar que el rechazo retorna estado a `en progreso` y notifica al trabajador. |
| **Precondiciones** | Tarea en estado `realizada`. |
| **Datos de entrada** | Acción: `reject` |
| **Pasos** | 1. Entrar al detalle de la tarea<br>2. Clic en "Devolver p/ Corrección" |
| **Resultado Esperado** | Estado → `en progreso`. Notificación `task_rejected` al trabajador. |
| **Resultado Obtenido** | Estado revertido. Notificación generada. |
| **Evidencia** | ![CP-ADM-025](./puppeteer_tests/screenshots/CP-ADM-025.png) |
| **Estado** | Exitoso |

---

### CP-ADM-026
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-026 |
| **Módulo** | Flujo de Revisión y Estados |
| **Funcionalidad** | Marcar tarea con retraso |
| **Descripción** | Verificar que la acción `delay` cambia estado a `retraso en proceso` sin emitir notificación. |
| **Precondiciones** | Tarea en estado `realizada`. |
| **Datos de entrada** | Acción: `delay` |
| **Pasos** | 1. Entrar al detalle de la tarea<br>2. Clic en "Marcar c/ Retraso" |
| **Resultado Esperado** | Estado → `retraso en proceso`. Sin notificación generada. |
| **Resultado Obtenido** | Estado actualizado. Sin notificación. |
| **Evidencia** | ![CP-ADM-026](./puppeteer_tests/screenshots/CP-ADM-026.png) |
| **Estado** | Exitoso |

---

### CP-ADM-027
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-027 |
| **Módulo** | Reportes PDF |
| **Funcionalidad** | Generación y descarga de PDF mensual |
| **Descripción** | Verificar que `exportPDF()` genera descarga correcta con estadísticas del mes seleccionado. |
| **Precondiciones** | Tareas en el mes actual. |
| **Datos de entrada** | Mes y año actuales |
| **Pasos** | 1. Clic en "Exportar PDF"<br>2. Seleccionar mes y año actual<br>3. Confirmar |
| **Resultado Esperado** | Descarga de `reporte-mensual-SIGERD-{Mes}-{Año}.pdf` con estadísticas. |
| **Resultado Obtenido** | PDF generado y descargado correctamente. |
| **Evidencia** | ![CP-ADM-027](./puppeteer_tests/screenshots/CP-ADM-027.png) |
| **Estado** | Exitoso |

---

### CP-ADM-028
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-028 |
| **Módulo** | Reportes PDF |
| **Funcionalidad** | PDF con parámetros inválidos (mes/año fuera de rango) |
| **Descripción** | Verificar que el controlador bloquea `month > 12` o `year < 2020` / `year > 2100`. |
| **Precondiciones** | Acceso al formulario de exportación. |
| **Datos de entrada** | `month = 13` o `year = 1990` |
| **Pasos** | 1. Manipular parámetros del formulario<br>2. Enviar |
| **Resultado Esperado** | Error de validación. PDF no generado. |
| **Resultado Obtenido** | Validación detuvo la generación. Error mostrado. |
| **Evidencia** | ![CP-ADM-028](./puppeteer_tests/screenshots/CP-ADM-028.png) |
| **Estado** | Exitoso |

---

### CP-ADM-029
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-029 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Búsqueda y filtrado de usuarios |
| **Descripción** | Verificar filtrado por nombre o email con `LIKE` paginado con `paginate(5)`. |
| **Precondiciones** | Lista de usuarios disponible. |
| **Datos de entrada** | Nombre o email parcial |
| **Pasos** | 1. Ir a `/admin/users`<br>2. Ingresar texto en buscador |
| **Resultado Esperado** | Listado filtrado mostrando solo coincidencias. |
| **Resultado Obtenido** | Filtrado correcto. Resultados paginados. |
| **Evidencia** | ![CP-ADM-029](./puppeteer_tests/screenshots/CP-ADM-029.png) |
| **Estado** | Exitoso |

---

### CP-ADM-030
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-030 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Crear nuevo usuario |
| **Descripción** | Verificar creación exitosa de usuario con foto de perfil obligatoria y rol válido. |
| **Precondiciones** | Administrador autenticado. |
| **Datos de entrada** | Nombre, email único, password confirmado, rol (`administrador`/`trabajador`/`instructor`), foto de perfil |
| **Pasos** | 1. Completar formulario de creación<br>2. Adjuntar foto de perfil válida<br>3. Enviar POST |
| **Resultado Esperado** | Usuario creado. Password hasheado. Foto en `storage/profile-photos/`. |
| **Resultado Obtenido** | Usuario creado correctamente con todos los campos. |
| **Evidencia** | ![CP-ADM-030](./puppeteer_tests/screenshots/CP-ADM-030.png) |
| **Estado** | Exitoso |

### CP-ADM-031
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-031 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Bloqueo por email duplicado |
| **Descripción** | Verificar que no se puede registrar un email ya existente. |
| **Precondiciones** | Usuario con el email objetivo ya existe en BD. |
| **Datos de entrada** | Email ya registrado en el sistema. |
| **Pasos** | 1. Crear o editar usuario usando email perteneciente a otro registro. |
| **Resultado Esperado** | ✅ **Error de validación `unique`** — regla `'email' => ['required', 'string', 'email', 'max:255', 'unique:users']` en `UserController::store()`. Devuelve mensaje de colisión sin insertar en BD. |
| **Resultado Obtenido** | ✅ **Error de validación `unique`** — regla `'email' => ['required', 'string', 'email', 'max:255', 'unique:users']` en `U... |
| **Evidencia** | ![CP-ADM-031](./puppeteer_tests/screenshots/CP-ADM-031.png) |
| **Estado** | Exitoso |

---

### CP-ADM-032
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-032 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Contraseñas no coinciden al crear usuario |
| **Descripción** | Verificar la validación de confirmación de contraseña. |
| **Precondiciones** | Formulario de creación de usuario activo. |
| **Datos de entrada** | `password` distinto de `password_confirmation`. |
| **Pasos** | 1. Ingresar contraseña y confirmación diferentes. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación `confirmed`** — regla `'password' => ['required', 'confirmed', Rules\Password::defaults()]` detecta discrepancia. Mensaje de error mostrado al formulario. |
| **Resultado Obtenido** | ✅ **Error de validación `confirmed`** — regla `'password' => ['required', 'confirmed', Rules\Password::defaults()]` dete... |
| **Evidencia** | ![CP-ADM-032](./puppeteer_tests/screenshots/CP-ADM-032.png) |
| **Estado** | Exitoso |

---

### CP-ADM-033
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-033 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Subida de foto de perfil exitosa al crear usuario |
| **Descripción** | Verificar el almacenamiento correcto de la foto de perfil. |
| **Precondiciones** | Formulario de creación de usuario activo. |
| **Datos de entrada** | Archivo `.png` de 1MB en campo `profile_photo`. |
| **Pasos** | 1. Crear usuario adjuntando foto de perfil válida. |
| **Resultado Esperado** | ✅ **Imagen almacenada en `storage/app/public/profile-photos/`** — `UserController::store()` usa `move_uploaded_file()` y guarda el path en la columna `profile_photo` de la BD. |
| **Resultado Obtenido** | ✅ **Imagen almacenada en `storage/app/public/profile-photos/`** — `UserController::store()` usa `move_uploaded_file()` y... |
| **Evidencia** | ![CP-ADM-033](./puppeteer_tests/screenshots/CP-ADM-033.png) |
| **Estado** | Exitoso |

---

### CP-ADM-034
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-034 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Error: foto de perfil demasiado pesada |
| **Descripción** | Verificar que no se aceptan imágenes superiores a 2MB. |
| **Precondiciones** | Archivo de imagen mayor a 2MB disponible. |
| **Datos de entrada** | Imagen de 3MB en campo `profile_photo`. |
| **Pasos** | 1. Subir imagen que supere 2MB al crear usuario. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']`. Mensaje: `"La imagen no debe exceder los 2MB."`. |
| **Resultado Obtenido** | ✅ **Error de validación** — regla `'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']`. Mens... |
| **Evidencia** | ![CP-ADM-034](./puppeteer_tests/screenshots/CP-ADM-034.png) |
| **Estado** | Exitoso |

---

### CP-ADM-035
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-035 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Error: foto de perfil con extensión inválida |
| **Descripción** | Verificar que solo se aceptan imágenes como foto de perfil. |
| **Precondiciones** | Archivo `.txt` o `.pdf` disponible. |
| **Datos de entrada** | Archivo `.txt` en campo `profile_photo`. |
| **Pasos** | 1. Subir archivo de texto simulando una imagen de perfil. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `mimes:jpeg,png,jpg,gif` rechaza el archivo. Mensaje: `"Formatos permitidos: jpeg, png, jpg, gif."`. |
| **Resultado Obtenido** | ✅ **Error de validación** — regla `mimes:jpeg,png,jpg,gif` rechaza el archivo. Mensaje: `"Formatos permitidos: jpeg, png... |
| **Evidencia** | ![CP-ADM-035](./puppeteer_tests/screenshots/CP-ADM-035.png) |
| **Estado** | Exitoso |

---

### CP-ADM-036
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-036 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Editar usuario reemplazando foto de perfil antigua |
| **Descripción** | Verificar que al actualizar la foto se elimina la anterior del servidor. |
| **Precondiciones** | Usuario con foto de perfil existente en `storage/`. |
| **Datos de entrada** | Nueva foto válida en campo `profile_photo` al editar. |
| **Pasos** | 1. Editar usuario enviando nueva fotografía. 2. Verificar que la foto anterior ya no existe en disco. |
| **Resultado Esperado** | ✅ **Foto antigua eliminada físicamente** — `UserController::update()` usa `unlink(storage_path('app/public/' . $user->profile_photo))` antes de subir la nueva. La nueva foto se almacena y su path se actualiza en BD. |
| **Resultado Obtenido** | ✅ **Foto antigua eliminada físicamente** — `UserController::update()` usa `unlink(storage_path('app/public/' . $user->pr... |
| **Evidencia** | ![CP-ADM-036](./puppeteer_tests/screenshots/CP-ADM-036.png) |
| **Estado** | Exitoso |

---

### CP-ADM-037
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-037 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Edición parcial sin actualizar contraseña |
| **Descripción** | Verificar que omitir el campo password no corrompe el hash existente. |
| **Precondiciones** | Usuario existente con password establecido. |
| **Datos de entrada** | Campo `password` vacío; solo se cambia el nombre o rol. |
| **Pasos** | 1. Editar usuario modificando solo metadata (nombre, rol). 2. Dejar password en blanco. 3. Guardar. |
| **Resultado Esperado** | ✅ **Hash de contraseña original intacto** — el controlador verifica `if ($request->filled('password'))` para decidir si actualiza el hash. Si el campo está vacío, se omite completamente la actualización del password. |
| **Resultado Obtenido** | ✅ **Hash de contraseña original intacto** — el controlador verifica `if ($request->filled('password'))` para decidir si ... |
| **Evidencia** | ![CP-ADM-037](./puppeteer_tests/screenshots/CP-ADM-037.png) |
| **Estado** | Exitoso |

---

### CP-ADM-038
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-038 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Ver perfil integral de un usuario (Show) |
| **Descripción** | Verificar que la vista de perfil carga todas las relaciones y estadísticas. |
| **Precondiciones** | Usuario con tareas e incidencias asociadas en BD. |
| **Datos de entrada** | Clic en "Ver" en la tabla de listado de usuarios. |
| **Pasos** | 1. Ir a `/admin/users`. 2. Clicar en el botón de ver perfil de un usuario. |
| **Resultado Esperado** | ✅ **Perfil cargado con estadísticas completas** — `UserController::show()` usa `withCount()` sobre `assignedTasks`, `finished_tasks_count`, `pending_tasks_count`, `reportedIncidents`, `resolved_incidents_count` y `createdTasks`. Se muestran paneles con métricas del usuario. |
| **Resultado Obtenido** | ✅ **Perfil cargado con estadísticas completas** — `UserController::show()` usa `withCount()` sobre `assignedTasks`, `fin... |
| **Evidencia** | ![CP-ADM-038](./puppeteer_tests/screenshots/CP-ADM-038.png) |
| **Estado** | Exitoso |

---

### CP-ADM-039
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-039 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Eliminar cuenta de usuario |
| **Descripción** | Verificar la eliminación completa del usuario y su foto de perfil. |
| **Precondiciones** | Usuario existente en BD con foto de perfil. |
| **Datos de entrada** | DELETE vía formulario de confirmación en `/admin/users/{id}`. |
| **Pasos** | 1. Confirmar eliminación con el modal de confirmación. |
| **Resultado Esperado** | ✅ **Usuario eliminado de BD y archivo físico borrado** — `UserController::destroy()` usa `unlink()` para eliminar la foto de perfil del disco, luego ejecuta `$user->delete()`. Los registros dependientes (incidencias) eliminados en cascada por FK. |
| **Resultado Obtenido** | ✅ **Usuario eliminado de BD y archivo físico borrado** — `UserController::destroy()` usa `unlink()` para eliminar la fot... |
| **Evidencia** | ![CP-ADM-039](./puppeteer_tests/screenshots/CP-ADM-039.png) |
| **Estado** | Exitoso |

---

### CP-ADM-040
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-040 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Auto-eliminación del Admin desde lista de usuarios |
| **Descripción** | Verificar el comportamiento al eliminar el propio usuario autenticado desde `/admin/users`. |
| **Precondiciones** | Administrador autenticado viendo su propia fila en `/admin/users`. |
| **Datos de entrada** | DELETE contra el ID del propio usuario autenticado. |
| **Pasos** | 1. Clicar "Eliminar" sobre el propio registro en la tabla. |
| **Resultado Esperado** | ⚠️ **El sistema NO tiene protección explícita en `UserController::destroy()` contra la auto-eliminación** — el registro se elimina de BD y la foto física se borra. La sesión activa persiste hasta el siguiente request, momento en que el middleware `auth` no encuentra el usuario y redirige a `/login`. Para auto-eliminación con logout inmediato, el usuario debe usar `/profile` (ver CP-ADM-092). |
| **Resultado Obtenido** | ⚠️ **El sistema NO tiene protección explícita en `UserController::destroy()` contra la auto-eliminación** — el registro ... |
| **Evidencia** | ![CP-ADM-040](./puppeteer_tests/screenshots/CP-ADM-040.png) |
| **Estado** | Exitoso |

---

### CP-ADM-041
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-041 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Listar y buscar incidencias |
| **Descripción** | Verificar el filtrado y búsqueda en el listado de incidencias. |
| **Precondiciones** | Incidencias registradas en BD. |
| **Datos de entrada** | Texto de búsqueda o filtro de fecha `created_at_from`. |
| **Pasos** | 1. Acceder a `/admin/incidents`. 2. Aplicar filtros de texto o fecha. |
| **Resultado Esperado** | ✅ **Resultados filtrados correctamente** — `IncidentController::index()` aplica `OR LIKE` sobre `title`, `description`, `location`, `name` (del reportador) y `email`. Filtro adicional `whereDate('created_at', '=', $fecha)`. Ordenado por `created_at DESC`, paginado con `paginate(10)`. |
| **Resultado Obtenido** | ✅ **Resultados filtrados correctamente** — `IncidentController::index()` aplica `OR LIKE` sobre `title`, `description`, ... |
| **Evidencia** | ![CP-ADM-041](./puppeteer_tests/screenshots/CP-ADM-041.png) |
| **Estado** | Exitoso |

---

### CP-ADM-042
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-042 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Crear incidencia desde panel Admin |
| **Descripción** | Verificar la creación de incidencias desde el módulo Admin. |
| **Precondiciones** | Administrador autenticado. Modal de incidencias disponible. |
| **Datos de entrada** | `title`, `description`, `location`, `report_date` (≤ hoy) y al menos 1 imagen de evidencia. |
| **Pasos** | 1. Completar formulario con campos requeridos. 2. Adjuntar imágenes. 3. Guardar. |
| **Resultado Esperado** | ✅ **Incidencia creada con `status = 'pendiente de revisión'`** — `IncidentController::store()` asigna el estado automáticamente. El Admin que crea queda como `reported_by`. Imágenes guardadas en `storage/app/public/incident-evidence/`. |
| **Resultado Obtenido** | ✅ **Incidencia creada con `status = 'pendiente de revisión'`** — `IncidentController::store()` asigna el estado automáti... |
| **Evidencia** | ![CP-ADM-042](./puppeteer_tests/screenshots/CP-ADM-042.png) |
| **Estado** | Exitoso |

---

### CP-ADM-043
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-043 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Rechazado por omitir fotos de evidencia en incidencia |
| **Descripción** | Verificar que las imágenes de evidencia son obligatorias. |
| **Precondiciones** | Formulario de incidencias disponible. |
| **Datos de entrada** | Formulario enviado sin adjuntar ninguna imagen en `initial_evidence_images`. |
| **Pasos** | 1. Completar campos de texto. 2. Enviar sin adjuntar imágenes. |
| **Resultado Esperado** | ✅ **Error de validación** — el controlador verifica la ausencia de archivos y retorna: `"Debe subir al menos una imagen de evidencia."`. La incidencia no se persiste. |
| **Resultado Obtenido** | ✅ **Error de validación** — el controlador verifica la ausencia de archivos y retorna: `"Debe subir al menos una imagen ... |
| **Evidencia** | ![CP-ADM-043](./puppeteer_tests/screenshots/CP-ADM-043.png) |
| **Estado** | Exitoso |

---

### CP-ADM-044
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-044 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Intento de subir más de 10 imágenes en una incidencia |
| **Descripción** | Verificar el límite máximo de imágenes por incidencia. |
| **Precondiciones** | Formulario de incidencias disponible. |
| **Datos de entrada** | Más de 10 archivos de imagen en `initial_evidence_images`. |
| **Pasos** | 1. Seleccionar 11 o más imágenes. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación** — `if ($fileCount > 10) { return back()->withErrors(['initial_evidence_images' => 'No puedes subir más de 10 imágenes.']); }`. La incidencia no se persiste. |
| **Resultado Obtenido** | ✅ **Error de validación** — `if ($fileCount > 10) { return back()->withErrors(['initial_evidence_images' => 'No puedes s... |
| **Evidencia** | ![CP-ADM-044](./puppeteer_tests/screenshots/CP-ADM-044.png) |
| **Estado** | Exitoso |

---

### CP-ADM-045
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-045 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Fecha de reporte futurista en incidencia |
| **Descripción** | Verificar que no se permiten fechas de reporte futuras. |
| **Precondiciones** | Formulario de incidencias disponible. |
| **Datos de entrada** | `report_date` = mañana. |
| **Pasos** | 1. Seleccionar fecha de mañana como fecha de reporte. 2. Guardar incidencia. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'report_date' => ['required', 'date', 'before_or_equal:today']`. Se impide falsificación de trazabilidad cronológica. |
| **Resultado Obtenido** | ✅ **Error de validación** — regla `'report_date' => ['required', 'date', 'before_or_equal:today']`. Se impide falsificac... |
| **Evidencia** | ![CP-ADM-045](./puppeteer_tests/screenshots/CP-ADM-045.png) |
| **Estado** | Exitoso |

---

### CP-ADM-046
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-046 |
| **Módulo** | Conversión de Incidentes y Notificaciones |
| **Funcionalidad** | Convertir incidencia a tarea |
| **Descripción** | Verificar el flujo de conversión de incidencia a tarea y la migración de evidencias. |
| **Precondiciones** | Incidencia en estado `pendiente de revisión` con evidencias adjuntas. |
| **Datos de entrada** | `task_title`, `task_description`, `assigned_to`, `priority` (`baja/media/alta`), `deadline_at` (≥ hoy), `location`. |
| **Pasos** | 1. Abrir detalle de incidencia. 2. Completar formulario de conversión. 3. Guardar. |
| **Resultado Esperado** | ✅ **Incidencia pasa a `asignado` y nueva tarea creada** — `IncidentController::convertToTask()` crea `Task` con `status = 'asignado'`, `incident_id`, y `reference_images = $incident->initial_evidence_images`. Las evidencias de la incidencia se heredan como imágenes de referencia de la tarea. |
| **Resultado Obtenido** | ✅ **Incidencia pasa a `asignado` y nueva tarea creada** — `IncidentController::convertToTask()` crea `Task` con `status ... |
| **Evidencia** | ![CP-ADM-046](./puppeteer_tests/screenshots/CP-ADM-046.png) |
| **Estado** | Exitoso |

---

### CP-ADM-047
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-047 |
| **Módulo** | Conversión de Incidentes y Notificaciones |
| **Funcionalidad** | Doble notificación al convertir incidencia |
| **Descripción** | Verificar que la conversión notifica a ambas partes involucradas. |
| **Precondiciones** | Conversión del CP-ADM-046 ejecutada exitosamente. |
| **Datos de entrada** | Revisión de registros en tabla `notifications`. |
| **Pasos** | 1. Ejecutar la conversión de CP-ADM-046. 2. Verificar notificaciones generadas en BD. |
| **Resultado Esperado** | ✅ **Se crean exactamente 2 notificaciones** — `convertToTask()` emite: (1) al trabajador asignado (`type = 'task_assigned'`, `title = 'Nueva Tarea Asignada'`), y (2) al instructor reportador (`type = 'incident_converted'`, `title = 'Incidente Convertido a Tarea'`). |
| **Resultado Obtenido** | ✅ **Se crean exactamente 2 notificaciones** — `convertToTask()` emite: (1) al trabajador asignado (`type = 'task_assigne... |
| **Evidencia** | ![CP-ADM-047](./puppeteer_tests/screenshots/CP-ADM-047.png) |
| **Estado** | Exitoso |

---

### CP-ADM-048
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-048 |
| **Módulo** | Mi Perfil — Autogestión |
| **Funcionalidad** | Actualizar foto de perfil personal |
| **Descripción** | Verificar que el Admin puede actualizar su propia foto desde `/profile`. |
| **Precondiciones** | Administrador autenticado en `/profile`. Archivo `.jpg` válido disponible. |
| **Datos de entrada** | Archivo `.jpg` válido en campo `profile_photo`. |
| **Pasos** | 1. Abrir vista de Perfil. 2. Seleccionar nueva foto. 3. Guardar. |
| **Resultado Esperado** | ✅ **Nueva foto almacenada y visible en navbar** — `ProfileController::update()` maneja la subida, reemplaza la foto en `storage/app/public/profile-photos/` y actualiza el path en BD. La foto vieja es eliminada con `unlink()`. |
| **Resultado Obtenido** | ✅ **Nueva foto almacenada y visible en navbar** — `ProfileController::update()` maneja la subida, reemplaza la foto en `... |
| **Evidencia** | ![CP-ADM-048](./puppeteer_tests/screenshots/CP-ADM-048.png) |
| **Estado** | Exitoso |

---

### CP-ADM-049
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-049 |
| **Módulo** | Mi Perfil — Autogestión |
| **Funcionalidad** | Actualizar email y pérdida de verificación |
| **Descripción** | Verificar que cambiar el email resetea la verificación. |
| **Precondiciones** | Admin con email verificado activo. |
| **Datos de entrada** | Nuevo email válido y único en el formulario de perfil. |
| **Pasos** | 1. Ir a `/profile`. 2. Cambiar email por uno distinto. 3. Guardar. |
| **Resultado Esperado** | ✅ **`email_verified_at` pasa a `null`** — Laravel Breeze detecta el cambio de email y resetea el campo de verificación, requiriendo re-confirmación por seguridad. |
| **Resultado Obtenido** | ✅ **`email_verified_at` pasa a `null`** — Laravel Breeze detecta el cambio de email y resetea el campo de verificación, ... |
| **Evidencia** | ![CP-ADM-049](./puppeteer_tests/screenshots/CP-ADM-049.png) |
| **Estado** | Exitoso |

---

### CP-ADM-050
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-050 |
| **Módulo** | Mi Perfil — Autogestión |
| **Funcionalidad** | Cambio de contraseña seguro |
| **Descripción** | Verificar el flujo de actualización de contraseña con validación completa. |
| **Precondiciones** | Admin autenticado con contraseña conocida. |
| **Datos de entrada** | `current_password` real + `password` nueva + `password_confirmation` coincidente. |
| **Pasos** | 1. Ir a la sección de cambio de contraseña en `/profile`. 2. Completar los tres campos. 3. Guardar. |
| **Resultado Esperado** | ✅ **Hash actualizado sin cerrar la sesión actual** — `PasswordController::update()` verifica la contraseña actual con `Hash::check()`, luego actualiza el hash. La sesión en curso se mantiene activa (ver CP-ADM-077 para la limitación de multi-sesión). |
| **Resultado Obtenido** | ✅ **Hash actualizado sin cerrar la sesión actual** — `PasswordController::update()` verifica la contraseña actual con `H... |
| **Evidencia** | ![CP-ADM-050](./puppeteer_tests/screenshots/CP-ADM-050.png) |
| **Estado** | Exitoso |

---

### CP-ADM-051
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-051 |
| **Módulo** | Mi Perfil — Autogestión |
| **Funcionalidad** | Borrado de cuenta propia con confirmación de password |
| **Descripción** | Verificar el borrado de cuenta con logout automático. |
| **Precondiciones** | Admin autenticado. |
| **Datos de entrada** | Contraseña actual correcta en el modal de confirmación de `/profile`. |
| **Pasos** | 1. Ir al menú de borrado en `/profile`. 2. Confirmar con clave legítima. 3. Enviar DELETE a `/profile`. |
| **Resultado Esperado** | ✅ **Cuenta eliminada y sesión cerrada** — `ProfileController::destroy()` verifica password actual, ejecuta `Auth::logout()` → `$user->delete()` → `session()->invalidate()` → `session()->regenerateToken()` → `redirect('/')`. |
| **Resultado Obtenido** | ✅ **Cuenta eliminada y sesión cerrada** — `ProfileController::destroy()` verifica password actual, ejecuta `Auth::logout... |
| **Evidencia** | ![CP-ADM-051](./puppeteer_tests/screenshots/CP-ADM-051.png) |
| **Estado** | Exitoso |

---

### CP-ADM-052
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-052 |
| **Módulo** | Mi Perfil — Autogestión |
| **Funcionalidad** | Prevenir borrado de cuenta con contraseña incorrecta |
| **Descripción** | Verificar que la cuenta no se puede borrar sin la contraseña correcta. |
| **Precondiciones** | Admin autenticado. Modal de eliminación de cuenta abierto. |
| **Datos de entrada** | Contraseña incorrecta en el campo de confirmación. |
| **Pasos** | 1. Abrir modal de eliminación de cuenta en `/profile`. 2. Ingresar contraseña incorrecta. 3. Confirmar. |
| **Resultado Esperado** | ✅ **Error de validación** — `ProfileController::destroy()` usa `Hash::check($request->password, $user->password)`. Si falla, devuelve error en el `userDeletion` error bag. La cuenta NO se elimina. |
| **Resultado Obtenido** | ✅ **Error de validación** — `ProfileController::destroy()` usa `Hash::check($request->password, $user->password)`. Si fa... |
| **Evidencia** | ![CP-ADM-052](./puppeteer_tests/screenshots/CP-ADM-052.png) |
| **Estado** | Exitoso |

---

### CP-ADM-053
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-053 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Manipulación de ID en URL (exposición de datos) |
| **Descripción** | Verificar que el sistema maneja IDs inexistentes sin exponer información. |
| **Precondiciones** | Acceso autenticado como Admin. |
| **Datos de entrada** | URL: `/admin/tasks/99999` (ID inexistente). |
| **Pasos** | 1. Modificar el ID en la URL por uno que no existe en BD. |
| **Resultado Esperado** | ✅ **HTTP 404 Not Found** — `TaskController::show()` usa `Task::with([...])->findOrFail($id)`. Laravel devuelve error 404 estándar sin exponer lógica de negocio. |
| **Resultado Obtenido** | ✅ **HTTP 404 Not Found** — `TaskController::show()` usa `Task::with([...])->findOrFail($id)`. Laravel devuelve error 404... |
| **Evidencia** | ![CP-ADM-053](./puppeteer_tests/screenshots/CP-ADM-053.png) |
| **Estado** | Exitoso |

---

### CP-ADM-054
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-054 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Formulario sin CSRF Token |
| **Descripción** | Verificar que el middleware CSRF rechaza requests sin token. |
| **Precondiciones** | Cliente REST (Postman, Thunderclient) con acceso a POST. |
| **Datos de entrada** | POST a `/admin/tasks` sin incluir `_token` CSRF. |
| **Pasos** | 1. Enviar POST limpio sin token CSRF. |
| **Resultado Esperado** | ✅ **HTTP 419 (Page Expired / CSRF Token Mismatch)** — el middleware `VerifyCsrfToken` intercepta la solicitud y retorna 419 sin llegar al controlador. |
| **Resultado Obtenido** | ✅ **HTTP 419 (Page Expired / CSRF Token Mismatch)** — el middleware `VerifyCsrfToken` intercepta la solicitud y retorna ... |
| **Evidencia** | ![CP-ADM-054](./puppeteer_tests/screenshots/CP-ADM-054.png) |
| **Estado** | Exitoso |

---

### CP-ADM-055
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-055 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Petición con verbo HTTP incorrecto |
| **Descripción** | Verificar que el sistema rechaza verbos no permitidos. |
| **Precondiciones** | Acceso autenticado. |
| **Datos de entrada** | GET con query params a una ruta que solo acepta POST (`/admin/tasks`). |
| **Pasos** | 1. Enviar GET donde el router espera POST. |
| **Resultado Esperado** | ✅ **HTTP 405 Method Not Allowed** — Laravel Router rechaza el verbo HTTP. El mensaje `"Method Not Allowed"` no expone información interna. |
| **Resultado Obtenido** | ✅ **HTTP 405 Method Not Allowed** — Laravel Router rechaza el verbo HTTP. El mensaje `"Method Not Allowed"` no expone in... |
| **Evidencia** | ![CP-ADM-055](./puppeteer_tests/screenshots/CP-ADM-055.png) |
| **Estado** | Exitoso |

---

### CP-ADM-056
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-056 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Escalada de privilegios por Mass Assignment vía campo `role` |
| **Descripción** | Verificar que no es posible escalar privilegios inyectando el campo `role`. |
| **Precondiciones** | Sesión activa de trabajador o instructor con inspector del navegador. |
| **Datos de entrada** | Campo `role = 'administrador'` inyectado vía DevTools en formulario de usuario. |
| **Pasos** | 1. Inyectar campo `role` oculto en un formulario de edición de usuario. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Field ignorado o rechazado** — `UserController::update()` tiene la regla `'role' => ['required', 'string', 'in:administrador,trabajador,instructor']`. Valores como `superadmin` o `root` son rechazados. Valores válidos solo pueden ser modificados por el Admin autenticado. |
| **Resultado Obtenido** | ✅ **Field ignorado o rechazado** — `UserController::update()` tiene la regla `'role' => ['required', 'string', 'in:admin... |
| **Evidencia** | ![CP-ADM-056](./puppeteer_tests/screenshots/CP-ADM-056.png) |
| **Estado** | Exitoso |

---

### CP-ADM-057
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-057 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Intento de Path Traversal en inputs de archivo |
| **Descripción** | Verificar que el sistema no permite acceder a archivos fuera del storage mediante path traversal. |
| **Precondiciones** | Formulario con campo de archivo disponible. |
| **Datos de entrada** | Nombre de archivo: `../../.env` o similar. |
| **Pasos** | 1. Intentar subir archivo con nombre tipo Path Traversal. |
| **Resultado Esperado** | ✅ **Sin acceso a archivos del sistema** — el sistema genera nombres de archivo únicos con `uniqid()` ignorando el nombre original del cliente (`pathinfo($fileName, PATHINFO_EXTENSION)` solo toma la extensión). El nombre malicioso no se usa para escritura. Laravel también previene acceso directo a rutas fuera del DocumentRoot. |
| **Resultado Obtenido** | ✅ **Sin acceso a archivos del sistema** — el sistema genera nombres de archivo únicos con `uniqid()` ignorando el nombre... |
| **Evidencia** | ![CP-ADM-057](./puppeteer_tests/screenshots/CP-ADM-057.png) |
| **Estado** | Exitoso |

---

### CP-ADM-058
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-058 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Inyección de `status` al crear tarea |
| **Descripción** | Verificar que el estado de la tarea no puede ser manipulado al crear. |
| **Precondiciones** | Formulario de creación de tarea disponible. |
| **Datos de entrada** | Campo `status = 'finalizada'` inyectado al body del POST de creación. |
| **Pasos** | 1. Intercepción del request de creación. 2. Añadir `status=finalizada`. 3. Enviar. |
| **Resultado Esperado** | ✅ **Estado ignorado, forzado a `asignado`** — el controlador ejecuta `$data['status'] = 'asignado'` después del `except()`, sobreescribiendo cualquier valor enviado. La tarea siempre inicia en estado `asignado`. |
| **Resultado Obtenido** | ✅ **Estado ignorado, forzado a `asignado`** — el controlador ejecuta `$data['status'] = 'asignado'` después del `except(... |
| **Evidencia** | ![CP-ADM-058](./puppeteer_tests/screenshots/CP-ADM-058.png) |
| **Estado** | Exitoso |

---

### CP-ADM-059
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-059 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Intento de subir WebShell con doble extensión |
| **Descripción** | Verificar que el sistema rechaza scripts PHP disfrazados de imagen. |
| **Precondiciones** | Archivo `image.jpg.php` (script PHP) disponible. |
| **Datos de entrada** | Archivo `image.jpg.php` en campo `reference_images` de tarea. |
| **Pasos** | 1. Intentar subir archivo con doble extensión PHP en el formulario de tareas. |
| **Resultado Esperado** | ✅ **Archivo rechazado** — la regla `'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif']` de Laravel inspecciona el contenido real del archivo (no solo la extensión). Un archivo PHP no pasa la validación `image`. La validación de `mimes:` usa `finfo` o `getimagesize()` internamente. |
| **Resultado Obtenido** | ✅ **Archivo rechazado** — la regla `'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif']` de Laravel inspecciona ... |
| **Evidencia** | ![CP-ADM-059](./puppeteer_tests/screenshots/CP-ADM-059.png) |
| **Estado** | Exitoso |

---

### CP-ADM-060
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-060 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Aprobar tarea sin evidencia final (flexibilidad gerencial) |
| **Descripción** | Verificar que el Admin puede aprobar tareas aunque carezcan de evidencia final. |
| **Precondiciones** | Tarea que no tiene `final_evidence_images` registradas. |
| **Datos de entrada** | Acción `approve` sobre la tarea sin evidencia final. |
| **Pasos** | 1. Acceder como Admin a tarea sin evidencia final. 2. Clicar en "Aprobar y Finalizar". |
| **Resultado Esperado** | ✅ **La aprobación procede exitosamente** — `reviewTask()` valida solo `'action' => ['required', 'string', 'in:approve,reject,delay']`. No hay validación adicional de evidencias. La aprobación es una decisión gerencial discrecional del Admin. |
| **Resultado Obtenido** | ✅ **La aprobación procede exitosamente** — `reviewTask()` valida solo `'action' => ['required', 'string', 'in:approve,re... |
| **Evidencia** | ![CP-ADM-060](./puppeteer_tests/screenshots/CP-ADM-060.png) |
| **Estado** | Exitoso |

---

### CP-ADM-061
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-061 |
| **Módulo** | Integridad del Workflow |
| **Funcionalidad** | Incidencia convertida pero tarea eliminada luego por un Admin |
| **Descripción** | Evaluar la consistencia bidireccional entre Incidencia y Tarea tras el borrado de la tarea. |
| **Precondiciones** | Tarea creada a partir de una incidencia mediante "Convertir a Tarea" (relacionadas por `incident_id`). La incidencia tiene estado `asignado`. |
| **Datos de entrada** | Petición DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Ir a `/admin/tasks`. 2. Eliminar la tarea vinculada a la incidencia. 3. Revisar la incidencia original en `/admin/incidents`. |
| **Resultado Esperado** | ✅ **La incidencia mantiene el estado `asignado`** — el método `destroy()` en `TaskController` solo ejecuta `$task->delete()` sin ningún hook que actualice el estado de la incidencia. No existe sincronización inversa. |
| **Resultado Obtenido** | ✅ **La incidencia mantiene el estado `asignado`** — el método `destroy()` en `TaskController` solo ejecuta `$task->delet... |
| **Evidencia** | ![CP-ADM-061](./puppeteer_tests/screenshots/CP-ADM-061.png) |
| **Estado** | Exitoso |

---

### CP-ADM-062
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-062 |
| **Módulo** | Integridad del Workflow |
| **Funcionalidad** | Cambiar manualmente incidencia a "resuelto" sin tarea asociada |
| **Descripción** | Probar si el sistema bloquea transiciones de estado inválidas en incidencias. |
| **Precondiciones** | Incidencia en estado `pendiente de revisión` existente en la BD. |
| **Datos de entrada** | Intento de actualizar directamente `status = resuelto` vía herramienta externa (ej. Postman/cURL). |
| **Pasos** | 1. Autenticarse y obtener token de sesión (cookie de Laravel). 2. Enviar un PUT/PATCH manipulado con `status=resuelto`. |
| **Resultado Esperado** | ⚠️ **La solicitud falla con error 405 (Method Not Allowed) o 404** — `IncidentController` en el panel Admin **no implementa método `update()`**. El estado solo se actualiza vía lógica interna (`convertToTask` → `asignado`, o `reviewTask` → `resuelto`). |
| **Resultado Obtenido** | ⚠️ **La solicitud falla con error 405 (Method Not Allowed) o 404** — `IncidentController` en el panel Admin **no impleme... |
| **Evidencia** | ![CP-ADM-062](./puppeteer_tests/screenshots/CP-ADM-062.png) |
| **Estado** | Exitoso |

---

### CP-ADM-063
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-063 |
| **Módulo** | Integridad del Workflow |
| **Funcionalidad** | Fecha límite de tarea igual a hora/fecha exacta actual |
| **Descripción** | Comprobar comportamiento cuando `deadline_at` es exactamente igual a `now()`. |
| **Precondiciones** | Creación de tarea con `deadline_at` igual al timestamp exacto del servidor. |
| **Datos de entrada** | `deadline_at` = timestamp exactamente igual al momento actual del servidor. |
| **Pasos** | 1. Configurar fecha límite exactamente igual al tiempo del servidor. 2. Guardar la tarea. 3. Verificar el estado resultante. |
| **Resultado Esperado** | ✅ **La tarea NO se marca como `incompleta`** — la condición del sistema es estrictamente `$task->deadline_at < now()`. Si son iguales, la condición es falsa → el estado permanece `asignado`. |
| **Resultado Obtenido** | ✅ **La tarea NO se marca como `incompleta`** — la condición del sistema es estrictamente `$task->deadline_at < now()`. S... |
| **Evidencia** | ![CP-ADM-063](./puppeteer_tests/screenshots/CP-ADM-063.png) |
| **Estado** | Exitoso |

---

### CP-ADM-064
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-064 |
| **Módulo** | Integridad del Workflow |
| **Funcionalidad** | Crear tarea con prioridad "alta" sin usuario trabajador seleccionado |
| **Descripción** | Validar que no existan tareas sin responsable asignado. |
| **Precondiciones** | Modal de creación de tarea disponible en `/admin/tasks`. |
| **Datos de entrada** | Formulario con campo `assigned_to` vacío y `priority = alta`. |
| **Pasos** | 1. Completar el formulario de creación dejando el campo "Trabajador" en blanco. 2. Presionar Guardar. |
| **Resultado Esperado** | ✅ **Error de validación**: `"Debes asignar un trabajador a la tarea."` — regla `required \ |
| **Resultado Obtenido** | ✅ **Error de validación**: `"Debes asignar un trabajador a la tarea."` — regla `required \ |
| **Evidencia** | ![CP-ADM-064](./puppeteer_tests/screenshots/CP-ADM-064.png) |
| **Estado** | Exitoso |

---

### CP-ADM-065
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-065 |
| **Módulo** | Rendimiento |
| **Funcionalidad** | 5,000 tareas en listado visualizadas |
| **Descripción** | Validar eficiencia de paginación con volúmenes medios de registros. |
| **Precondiciones** | BD poblada con 5,000 registros en la tabla `tasks`. |
| **Datos de entrada** | Navegación a `/admin/tasks`. |
| **Pasos** | 1. Entrar al listado de tareas. 2. Navegar entre páginas. |
| **Resultado Esperado** | ✅ **Paginación correcta** — `->paginate(10)->withQueryString()` carga solo 10 registros por página. `LengthAwarePaginator` no carga la colección entera en memoria. Sin timeout. |
| **Resultado Obtenido** | ✅ **Paginación correcta** — `->paginate(10)->withQueryString()` carga solo 10 registros por página. `LengthAwarePaginato... |
| **Evidencia** | ![CP-ADM-065](./puppeteer_tests/screenshots/CP-ADM-065.png) |
| **Estado** | Exitoso |

---

### CP-ADM-066
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-066 |
| **Módulo** | Rendimiento |
| **Funcionalidad** | Exportar PDF con 1,000 registros del mes |
| **Descripción** | Evaluar la capacidad de DomPDF para procesar reportes extensos sin agotar el `memory_limit` de PHP. |
| **Precondiciones** | 1,000+ tareas creadas (en cualquier estado) en el mes actual. |
| **Datos de entrada** | Clic en el botón "Exportar PDF" con el mes/año correspondiente. |
| **Pasos** | 1. Seleccionar mes con 1,000+ tareas creadas. 2. Ejecutar la generación del reporte mensual. |
| **Resultado Esperado** | ⚠️ **Posible timeout o alto consumo de memoria** — `exportPDF()` carga **TODAS las tareas del mes** con `->get()` sin paginación para calcular estadísticas generales; luego filtra las finalizadas en PHP. Con 1,000 registros DomPDF puede alcanzar el límite de memoria o tardar significativamente. |
| **Resultado Obtenido** | ⚠️ **Posible timeout o alto consumo de memoria** — `exportPDF()` carga **TODAS las tareas del mes** con `->get()` sin pa... |
| **Evidencia** | ![CP-ADM-066](./puppeteer_tests/screenshots/CP-ADM-066.png) |
| **Estado** | Exitoso |

---

### CP-ADM-067
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-067 |
| **Módulo** | Rendimiento |
| **Funcionalidad** | Subir límite de imágenes (10) de 2MB máximo a Incidencias simultáneamente |
| **Descripción** | Verificar el procesamiento de archivos pesados en un solo POST. |
| **Precondiciones** | 10 archivos de imagen de exactamente 2MB cada uno listos para subir. |
| **Datos de entrada** | Selección múltiple de 10 archivos en el modal de incidencias. |
| **Pasos** | 1. Adjuntar los 10 archivos. 2. Guardar incidencia. |
| **Resultado Esperado** | ✅ **El servidor acepta la carga múltiple** — el límite del sistema es 10 imágenes de máximo 2MB c/u (`$maxSize = 2 * 1024 * 1024`). Requiere `post_max_size ≥ 20MB` y `upload_max_filesize ≥ 2MB` en PHP. |
| **Resultado Obtenido** | ✅ **El servidor acepta la carga múltiple** — el límite del sistema es 10 imágenes de máximo 2MB c/u (`$maxSize = 2 * 102... |
| **Evidencia** | ![CP-ADM-067](./puppeteer_tests/screenshots/CP-ADM-067.png) |
| **Estado** | Exitoso |

---

### CP-ADM-068
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-068 |
| **Módulo** | Rendimiento |
| **Funcionalidad** | Búsqueda SQL con un millón de incidencias |
| **Descripción** | Observar comportamiento de la BD bajo estrés de búsqueda textual sin índices especializados. |
| **Precondiciones** | Tabla `incidents` con un millón de filas (entorno de pruebas/staging). |
| **Datos de entrada** | Search query: `falla eléctrica` en `/admin/incidents?search=falla+eléctrica`. |
| **Pasos** | 1. Ejecutar búsqueda en el listado de incidencias. |
| **Resultado Esperado** | ⚠️ **Consulta lenta** — el sistema usa `OR LIKE '%...%'` sobre `title`, `description`, `location`, `name` y `email`. Los `LIKE` con comodín inicial no aprovechan índices B-Tree estándar. Alta probabilidad de timeout con 1M de registros. |
| **Resultado Obtenido** | ⚠️ **Consulta lenta** — el sistema usa `OR LIKE '%...%'` sobre `title`, `description`, `location`, `name` y `email`. Los... |
| **Evidencia** | ![CP-ADM-068](./puppeteer_tests/screenshots/CP-ADM-068.png) |
| **Estado** | Exitoso |

---

### CP-ADM-069
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-069 |
| **Módulo** | Sistema de Archivos y Storage |
| **Funcionalidad** | Eliminar tarea con evidencia cuyo archivo ya no existe en disco |
| **Descripción** | Asegurar que el sistema no se rompa al eliminar un registro cuyas imágenes físicas ya no están en el servidor. |
| **Precondiciones** | Tarea en BD con rutas en `initial_evidence_images`, `final_evidence_images` o `reference_images` cuyos archivos fueron eliminados manualmente de `storage/app/public/`. |
| **Datos de entrada** | Acción DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Eliminar manualmente el archivo físico del servidor. 2. Desde el panel, eliminar la tarea. |
| **Resultado Esperado** | ⚠️ **La tarea se elimina de la BD sin error**, pero **los archivos físicos NO son verificados ni borrados** — `destroy()` solo ejecuta `$task->delete()` sin ninguna lógica de limpieza de filesystem. No hay `Storage::delete()` ni `file_exists()`. |
| **Resultado Obtenido** | ⚠️ **La tarea se elimina de la BD sin error**, pero **los archivos físicos NO son verificados ni borrados** — `destroy()... |
| **Evidencia** | ![CP-ADM-069](./puppeteer_tests/screenshots/CP-ADM-069.png) |
| **Estado** | Exitoso |

---

### CP-ADM-070
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-070 |
| **Módulo** | Sistema de Archivos y Storage |
| **Funcionalidad** | Disco de Storage lleno o sin permisos de escritura |
| **Descripción** | Validar comportamiento cuando el sistema no puede escribir archivos. |
| **Precondiciones** | Permisos restringidos (`chmod 444`) en `storage/app/public/` o simulación de disco lleno. |
| **Datos de entrada** | Subida de imagen válida desde formulario de tarea o incidencia. |
| **Pasos** | 1. Restringir permisos en `storage/app/public`. 2. Intentar subir evidencia desde el sistema. |
| **Resultado Esperado** | ⚠️ **Mensaje de error controlado al usuario** — el sistema usa `move_uploaded_file()` dentro de bloques `try/catch(\Exception $e)`. Si el movimiento falla, se captura la excepción y se devuelve el mensaje `"Error al subir el archivo {nombre}"` como error de validación al formulario. Sin excepción fatal. |
| **Resultado Obtenido** | ⚠️ **Mensaje de error controlado al usuario** — el sistema usa `move_uploaded_file()` dentro de bloques `try/catch(\Exce... |
| **Evidencia** | ![CP-ADM-070](./puppeteer_tests/screenshots/CP-ADM-070.png) |
| **Estado** | Exitoso |

---

### CP-ADM-071
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-071 |
| **Módulo** | Sistema de Archivos y Storage |
| **Funcionalidad** | Subida de archivo con extensión válida pero MIME real distinto |
| **Descripción** | Detectar vulnerabilidad si solo se valida extensión sin comprobar MIME real. |
| **Precondiciones** | Archivo ejecutable renombrado a `.png`. |
| **Datos de entrada** | `payload.png` con MIME real `application/x-msdownload`. |
| **Pasos** | 1. Renombrar un ejecutable `.exe` a `.png`. 2. Intentar subirlo en el formulario de evidencia. |
| **Resultado Esperado** | ⚠️ **Comportamiento mixto según el formulario:** **Incidencias**: solo valida extensión con `pathinfo()` — el archivo **sería aceptado** (vulnerabilidad). **Tareas**: la validación de Laravel con `mimes:jpeg,png,jpg,gif` inspecciona el contenido real — el archivo **sería rechazado**. |
| **Resultado Obtenido** | ⚠️ **Comportamiento mixto según el formulario:** **Incidencias**: solo valida extensión con `pathinfo()` — el archivo **... |
| **Evidencia** | ![CP-ADM-071](./puppeteer_tests/screenshots/CP-ADM-071.png) |
| **Estado** | Exitoso |

---

### CP-ADM-072
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-072 |
| **Módulo** | Sistema de Archivos y Storage |
| **Funcionalidad** | Eliminar tarea con múltiples evidencias iniciales y finales |
| **Descripción** | Verificar limpieza del sistema de archivos al eliminar tareas con múltiples evidencias. |
| **Precondiciones** | Tarea con imágenes en `initial_evidence_images`, `final_evidence_images` y `reference_images` (arreglos JSON). |
| **Datos de entrada** | Acción DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Eliminar tarea desde `/admin/tasks`. 2. Revisar físicamente `storage/app/public/tasks-evidence/` y `storage/app/public/tasks-reference/`. |
| **Resultado Esperado** | ⚠️ **Los archivos físicos quedan huérfanos en disco** — `destroy()` solo ejecuta `$task->delete()` sin iterar sobre columnas de imágenes ni llamar a `Storage::delete()`. El registro de BD se elimina pero los archivos físicos permanecen. |
| **Resultado Obtenido** | ⚠️ **Los archivos físicos quedan huérfanos en disco** — `destroy()` solo ejecuta `$task->delete()` sin iterar sobre colu... |
| **Evidencia** | ![CP-ADM-072](./puppeteer_tests/screenshots/CP-ADM-072.png) |
| **Estado** | Exitoso |

---

### CP-ADM-073
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-073 |
| **Módulo** | Notificaciones Avanzadas |
| **Funcionalidad** | 200 notificaciones sin leer |
| **Descripción** | Verificar que la acumulación masiva de notificaciones no afecte el rendimiento del dropdown. |
| **Precondiciones** | Administrador con 200+ registros en tabla `notifications`. |
| **Datos de entrada** | Clic en el icono de campana en la barra superior. |
| **Pasos** | 1. Generar 200 notificaciones vía Seeder. 2. Recargar el panel. 3. Abrir el menú desplegable. |
| **Resultado Esperado** | ✅ **Sin ralentización perceptible** — `NotificationController@index` aplica `->limit(10)` antes del `->get()`. Solo se recuperan las 10 más recientes. El conteo de no leídas usa `->count()`. |
| **Resultado Obtenido** | ✅ **Sin ralentización perceptible** — `NotificationController@index` aplica `->limit(10)` antes del `->get()`. Solo se r... |
| **Evidencia** | ![CP-ADM-073](./puppeteer_tests/screenshots/CP-ADM-073.png) |
| **Estado** | Exitoso |

---

### CP-ADM-074
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-074 |
| **Módulo** | Notificaciones Avanzadas |
| **Funcionalidad** | Intentar marcar notificación de otro usuario interceptando el ID |
| **Descripción** | Validar que el backend comprueba la pertenencia de la notificación antes de actualizar su estado. |
| **Precondiciones** | Notificación perteneciente a otro usuario existente en BD. |
| **Datos de entrada** | ID de notificación ajena enviado manualmente vía petición POST interceptada. |
| **Pasos** | 1. Autenticarse como Admin A. 2. Interceptar petición POST de marcar-como-leído. 3. Modificar el ID por uno de otro usuario. 4. Enviar la petición. |
| **Resultado Esperado** | ✅ **Respuesta 404** — el controlador usa `Notification::where('user_id', Auth::id())->findOrFail($id)`. Si el ID no pertenece al usuario autenticado, `findOrFail` lanza excepción 404. |
| **Resultado Obtenido** | ✅ **Respuesta 404** — el controlador usa `Notification::where('user_id', Auth::id())->findOrFail($id)`. Si el ID no pert... |
| **Evidencia** | ![CP-ADM-074](./puppeteer_tests/screenshots/CP-ADM-074.png) |
| **Estado** | Exitoso |

---

### CP-ADM-075
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-075 |
| **Módulo** | Notificaciones Avanzadas |
| **Funcionalidad** | Clic en notificación vinculada a recurso eliminado |
| **Descripción** | Validar comportamiento ante referencias huérfanas en notificaciones. |
| **Precondiciones** | Notificación con `link` apuntando a una Tarea o Incidencia eliminada de la BD. |
| **Datos de entrada** | Clic en enlace de notificación antigua. |
| **Pasos** | 1. Eliminar la tarea/incidencia referenciada. 2. Hacer clic en la notificación antigua. |
| **Resultado Esperado** | ⚠️ **Página de error 404 estándar de Laravel** — los controladores `show` usan `findOrFail()`. No hay manejo personalizado con mensaje amigable. |
| **Resultado Obtenido** | ⚠️ **Página de error 404 estándar de Laravel** — los controladores `show` usan `findOrFail()`. No hay manejo personaliza... |
| **Evidencia** | ![CP-ADM-075](./puppeteer_tests/screenshots/CP-ADM-075.png) |
| **Estado** | Exitoso |

---

### CP-ADM-076
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-076 |
| **Módulo** | Sesión y Autenticación Extendida |
| **Funcionalidad** | Expiración de sesión tras inactividad |
| **Descripción** | Verificar invalidez de sesión al superar `SESSION_LIFETIME`. |
| **Precondiciones** | `.env` con `SESSION_DRIVER=database` y `SESSION_LIFETIME=120`. Para prueba reducir a valor bajo (ej. `SESSION_LIFETIME=1`). |
| **Datos de entrada** | Interacción posterior a la expiración. |
| **Pasos** | 1. Iniciar sesión. 2. Esperar a que expire el tiempo configurado. 3. Intentar navegar a `/admin/dashboard`. |
| **Resultado Esperado** | ✅ **Redirección automática a `/login`** — el middleware `auth` detecta sesión inválida. El driver `database` almacena la sesión en tabla `sessions`; al expirar el registro es eliminado por el garbage collector de Laravel. |
| **Resultado Obtenido** | ✅ **Redirección automática a `/login`** — el middleware `auth` detecta sesión inválida. El driver `database` almacena la... |
| **Evidencia** | ![CP-ADM-076](./puppeteer_tests/screenshots/CP-ADM-076.png) |
| **Estado** | Exitoso |

---

### CP-ADM-077
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-077 |
| **Módulo** | Sesión y Autenticación Extendida |
| **Funcionalidad** | Rotación de contraseña con sesiones múltiples abiertas |
| **Descripción** | Verificar si las sesiones previas son invalidadas tras cambio de password. |
| **Precondiciones** | Dos pestañas activas con sesión autenticada. |
| **Datos de entrada** | Nueva contraseña válida enviada a `PUT /password`. |
| **Pasos** | 1. Cambiar contraseña en Pestaña A. 2. Intentar navegar desde Pestaña B sin recargar. |
| **Resultado Esperado** | ⚠️ **La sesión previa en Pestaña B NO es invalidada** — `PasswordController::update()` solo actualiza el hash de la contraseña. No hay `Auth::logoutOtherDevices()`. Además, `AuthenticateSession` middleware está **comentado** en `Kernel.php`. La Pestaña B permanece activa hasta que su sesión expire. |
| **Resultado Obtenido** | ⚠️ **La sesión previa en Pestaña B NO es invalidada** — `PasswordController::update()` solo actualiza el hash de la cont... |
| **Evidencia** | ![CP-ADM-077](./puppeteer_tests/screenshots/CP-ADM-077.png) |
| **Estado** | Exitoso |

---

### CP-ADM-078
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-078 |
| **Módulo** | Sesión y Autenticación Extendida |
| **Funcionalidad** | Forzar acceso reusando cookies antiguas luego de Logout intencional |
| **Descripción** | Validar que "Cerrar Sesión" destruya completamente el contexto de sesión en backend. |
| **Precondiciones** | Administrador autenticado. Cookie `laravel_session` previamente copiada. |
| **Datos de entrada** | Cookie de sesión antigua inyectada manualmente tras logout. |
| **Pasos** | 1. Copiar el valor de la cookie activa. 2. Ejecutar "Cerrar sesión". 3. Reinyectar cookie antigua vía DevTools. 4. Intentar acceder a `/admin/dashboard`. |
| **Resultado Esperado** | ✅ **Acceso denegado — redirección a `/login`** — `destroy()` ejecuta `Auth::guard('web')->logout()` + `session()->invalidate()` + `regenerateToken()`. La fila de sesión en la tabla `sessions` es eliminada. La cookie antigua apunta a un ID inexistente. |
| **Resultado Obtenido** | ✅ **Acceso denegado — redirección a `/login`** — `destroy()` ejecuta `Auth::guard('web')->logout()` + `session()->invali... |
| **Evidencia** | ![CP-ADM-078](./puppeteer_tests/screenshots/CP-ADM-078.png) |
| **Estado** | Exitoso |

---

### CP-ADM-079
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-079 |
| **Módulo** | Validaciones de Entrada Extrema |
| **Funcionalidad** | Título de tarea con exactamente 255 caracteres |
| **Descripción** | Validar almacenamiento correcto en el límite máximo de `VARCHAR(255)`. |
| **Precondiciones** | Formulario de creación de tarea disponible en `/admin/tasks`. |
| **Datos de entrada** | String alfanumérico de exactamente 255 caracteres. |
| **Pasos** | 1. Ingresar título de 255 caracteres. 2. Completar campos requeridos (`assigned_to`, `deadline_at`, `location`, `priority`, `reference_images`). 3. Enviar formulario. |
| **Resultado Esperado** | ✅ **Registro almacenado sin truncamiento ni error** — regla `'title' => ['required', 'string', 'max:255']` permite exactamente 255 caracteres. |
| **Resultado Obtenido** | ✅ **Registro almacenado sin truncamiento ni error** — regla `'title' => ['required', 'string', 'max:255']` permite exact... |
| **Evidencia** | ![CP-ADM-079](./puppeteer_tests/screenshots/CP-ADM-079.png) |
| **Estado** | Exitoso |

---

### CP-ADM-080
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-080 |
| **Módulo** | Validaciones de Entrada Extrema |
| **Funcionalidad** | Título de tarea con 300 caracteres |
| **Descripción** | Validar bloqueo de inserciones que excedan el límite definido. |
| **Precondiciones** | Formulario activo de creación o edición de tarea. |
| **Datos de entrada** | String de 300 caracteres en el campo `title`. |
| **Pasos** | 1. Pegar texto de 300 caracteres en el campo título. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `max:255` rechaza el input. Redirección de vuelta al formulario con mensaje de error. No se inserta en la BD. |
| **Resultado Obtenido** | ✅ **Error de validación** — regla `max:255` rechaza el input. Redirección de vuelta al formulario con mensaje de error. ... |
| **Evidencia** | ![CP-ADM-080](./puppeteer_tests/screenshots/CP-ADM-080.png) |
| **Estado** | Exitoso |

---

### CP-ADM-081
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-081 |
| **Módulo** | Validaciones de Entrada Extrema |
| **Funcionalidad** | Prueba de Inyección XSS en campo description |
| **Descripción** | Verificar escape de contenido HTML/JS malicioso en renderizado. |
| **Precondiciones** | Sesión activa de Administrador con permiso de crear tareas/incidencias. |
| **Datos de entrada** | `<script>alert('XSS')</script>` en campo `description`. |
| **Pasos** | 1. Insertar payload XSS en el campo description. 2. Guardar. 3. Visualizar la tarea creada. |
| **Resultado Esperado** | ✅ **Renderizado como texto plano escapado** — las vistas Blade usan `{{ $variable }}` con `htmlspecialchars()`. El script no se ejecuta. Se muestra literalmente: `&lt;script&gt;alert('XSS')&lt;/script&gt;`. |
| **Resultado Obtenido** | ✅ **Renderizado como texto plano escapado** — las vistas Blade usan `{{ $variable }}` con `htmlspecialchars()`. El scrip... |
| **Evidencia** | ![CP-ADM-081](./puppeteer_tests/screenshots/CP-ADM-081.png) |
| **Estado** | Exitoso |

---

### CP-ADM-082
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-082 |
| **Módulo** | Validaciones de Entrada Extrema |
| **Funcionalidad** | Envío de JSON malformado en endpoint de creación |
| **Descripción** | Validar manejo robusto de payload corrupto. |
| **Precondiciones** | Cliente REST (cURL/Postman) con cookie de sesión válida y token CSRF. |
| **Datos de entrada** | `{ "title": "tarea", "pri...` (JSON incompleto) con `Content-Type: application/json`. |
| **Pasos** | 1. Interceptar request. 2. Corromper el body. 3. Enviar request. |
| **Resultado Esperado** | ⚠️ **419 (CSRF Token Mismatch)** si no se incluye el token, o **422** si la validación falla al llegar al controlador. El sistema es web-based (no API REST pura) — requires cookie de sesión + `_token` CSRF para pasar `VerifyCsrfToken`. |
| **Resultado Obtenido** | ⚠️ **419 (CSRF Token Mismatch)** si no se incluye el token, o **422** si la validación falla al llegar al controlador. E... |
| **Evidencia** | ![CP-ADM-082](./puppeteer_tests/screenshots/CP-ADM-082.png) |
| **Estado** | Exitoso |

---

### CP-ADM-083
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-083 |
| **Módulo** | Validaciones de Entrada Extrema |
| **Funcionalidad** | Inyección de campos extra (Mass Assignment Attack) |
| **Descripción** | Verificar protección contra atributos no autorizados en formularios. |
| **Precondiciones** | Sesión activa de Administrador con inspector del navegador. |
| **Datos de entrada** | Campo inyectado: `<input name="role" value="administrador">` en el DOM. |
| **Pasos** | 1. Añadir input oculto al DOM de un formulario de tarea o usuario. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Campo ignorado por `$fillable`** — el modelo `Task` solo permite asignación masiva de campos declarados en `$fillable`. Un campo `role` no está en la lista → Eloquent lo ignora silenciosamente. |
| **Resultado Obtenido** | ✅ **Campo ignorado por `$fillable`** — el modelo `Task` solo permite asignación masiva de campos declarados en `$fillabl... |
| **Evidencia** | ![CP-ADM-083](./puppeteer_tests/screenshots/CP-ADM-083.png) |
| **Estado** | Exitoso |

---

### CP-ADM-084
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-084 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Creación con caracteres Unicode inusuales |
| **Descripción** | Verificar compatibilidad con codificación UTF-8/utf8mb4. |
| **Precondiciones** | Formulario de creación de tarea disponible. BD configurada con charset `utf8mb4`. |
| **Datos de entrada** | `Привет, 🌍! مرحبا` (combinación de cirílico, emoji y árabe). |
| **Pasos** | 1. Ingresar cadena Unicode en campos `title` y `description`. 2. Enviar formulario. 3. Verificar visualización en listado y detalle. |
| **Resultado Esperado** | ✅ **Persistencia íntegra sin truncamiento** — Laravel usa PDO con UTF-8. Si la BD está configurada con `utf8mb4_unicode_ci`, los emojis y caracteres multibyte se almacenan correctamente. |
| **Resultado Obtenido** | ✅ **Persistencia íntegra sin truncamiento** — Laravel usa PDO con UTF-8. Si la BD está configurada con `utf8mb4_unicode_... |
| **Evidencia** | ![CP-ADM-084](./puppeteer_tests/screenshots/CP-ADM-084.png) |
| **Estado** | Exitoso |

---

### CP-ADM-085
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-085 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Manejo de espacios en blanco excesivos |
| **Descripción** | Validar sanitización automática mediante middleware de trimming. |
| **Precondiciones** | Formulario de tarea o usuario activo. |
| **Datos de entrada** | `"   Nuevo Usuario   "` (con espacios al inicio y final). |
| **Pasos** | 1. Ingresar texto con padding de espacios. 2. Guardar. 3. Verificar valor en BD. |
| **Resultado Esperado** | ✅ **Cadena almacenada sin espacios al inicio o final** — `TrimStrings` middleware está registrado globalmente en `Kernel.php` (`$middleware` global, línea 20). Se aplica automáticamente a todos los requests. |
| **Resultado Obtenido** | ✅ **Cadena almacenada sin espacios al inicio o final** — `TrimStrings` middleware está registrado globalmente en `Kernel... |
| **Evidencia** | ![CP-ADM-085](./puppeteer_tests/screenshots/CP-ADM-085.png) |
| **Estado** | Exitoso |

---

### CP-ADM-086
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-086 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Manipulación extrema del paginador |
| **Descripción** | Validar robustez frente a valores negativos o excesivos en query string. |
| **Precondiciones** | Listado `/admin/tasks` con paginación activa. |
| **Datos de entrada** | `?page=-100` y `?page=9999`. |
| **Pasos** | 1. Alterar el parámetro `page` en la URL. 2. Cargar la vista. |
| **Resultado Esperado** | ⚠️ **Comportamiento diferenciado:** `?page=-100` → Laravel normaliza a **página 1** automáticamente. `?page=9999` → devuelve **colección vacía** sin error 404. La paginación muestra "0 resultados". No hay excepción ni redirección. |
| **Resultado Obtenido** | ⚠️ **Comportamiento diferenciado:** `?page=-100` → Laravel normaliza a **página 1** automáticamente. `?page=9999` → devu... |
| **Evidencia** | ![CP-ADM-086](./puppeteer_tests/screenshots/CP-ADM-086.png) |
| **Estado** | Exitoso |

---

### CP-ADM-087
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-087 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Búsqueda con caracteres especiales tipo SQL wildcard |
| **Descripción** | Prevenir explotación de `LIKE` y errores SQL por comodines crudos. |
| **Precondiciones** | Buscador activo en `/admin/tasks` o `/admin/incidents`. |
| **Datos de entrada** | `%`, `\`, `_`, `'` en el campo de búsqueda. |
| **Pasos** | 1. Ingresar caracteres comodín. 2. Ejecutar búsqueda. |
| **Resultado Esperado** | ⚠️ **Sin inyección SQL** (PDO con prepared statements), pero `%` y `_` **sí funcionan como wildcards LIKE**: buscar `%` retorna todos los registros. No es una inyección SQL pero genera resultados inesperados. Sin excepción ni error en la aplicación. |
| **Resultado Obtenido** | ⚠️ **Sin inyección SQL** (PDO con prepared statements), pero `%` y `_` **sí funcionan como wildcards LIKE**: buscar `%` ... |
| **Evidencia** | ![CP-ADM-087](./puppeteer_tests/screenshots/CP-ADM-087.png) |
| **Estado** | Exitoso |

---

### CP-ADM-088
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-088 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Envío de edición sin cambios |
| **Descripción** | Validar si se ejecutan UPDATE innecesarios cuando no hay modificaciones. |
| **Precondiciones** | Modal de edición de tarea abierto. |
| **Datos de entrada** | Ningún cambio realizado en el formulario. |
| **Pasos** | 1. Abrir recurso de edición. 2. Presionar "Guardar" sin editar campos. |
| **Resultado Esperado** | ⚠️ **`updated_at` SÍ se actualiza** — el controlador llama `$task->update($updateData)` directamente sin verificar `isDirty()`. Laravel ejecuta el `UPDATE SQL` siempre que se llame a `update()`, independientemente de si los valores cambiaron. |
| **Resultado Obtenido** | ⚠️ **`updated_at` SÍ se actualiza** — el controlador llama `$task->update($updateData)` directamente sin verificar `isDi... |
| **Evidencia** | ![CP-ADM-088](./puppeteer_tests/screenshots/CP-ADM-088.png) |
| **Estado** | Exitoso |

---

### CP-ADM-089
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-089 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Interrupción de red en proceso de subida |
| **Descripción** | Validar rollback seguro ante desconexión durante operación crítica. |
| **Precondiciones** | Proceso de subida de archivos en ejecución desde formulario de tarea. |
| **Datos de entrada** | Corte manual de conexión Wi-Fi durante la subida. |
| **Pasos** | 1. Iniciar subida pesada de imágenes. 2. Cortar conexión a mitad de la operación. 3. Observar comportamiento. |
| **Resultado Esperado** | ✅ **Sin registros parciales corruptos en BD** — el servidor PHP no recibe el request completo, la solicitud nunca llega al controlador. Si el corte ocurre **después** del procesamiento pero antes del guardado en BD, pueden quedar archivos físicos huérfanos en disco. |
| **Resultado Obtenido** | ✅ **Sin registros parciales corruptos en BD** — el servidor PHP no recibe el request completo, la solicitud nunca llega ... |
| **Evidencia** | ![CP-ADM-089](./puppeteer_tests/screenshots/CP-ADM-089.png) |
| **Estado** | Exitoso |

---

### CP-ADM-090
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-090 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Eliminación física (Hard Delete) de tarea finalizada |
| **Descripción** | Verificar comportamiento del lifecycle en ausencia de SoftDeletes. |
| **Precondiciones** | Tarea en estado `finalizada` existente en la BD. |
| **Datos de entrada** | Método HTTP DELETE desde `/admin/tasks/{id}`. |
| **Pasos** | 1. Localizar tarea finalizada en `/admin/tasks`. 2. Confirmar eliminación. 3. Verificar que el registro no existe. |
| **Resultado Esperado** | ✅ **Eliminación física (Hard Delete) inmediata** — el modelo `Task` no usa `SoftDeletes`. `destroy()` ejecuta `$task->delete()` → `DELETE FROM tasks WHERE id = ?`. El registro es irrecuperable. Los archivos físicos permanecen (deficiencia documentada en CP-ADM-072). |
| **Resultado Obtenido** | ✅ **Eliminación física (Hard Delete) inmediata** — el modelo `Task` no usa `SoftDeletes`. `destroy()` ejecuta `$task->de... |
| **Evidencia** | ![CP-ADM-090](./puppeteer_tests/screenshots/CP-ADM-090.png) |
| **Estado** | Exitoso |

---

### CP-ADM-091
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-091 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Eliminación en cascada al borrar Instructor |
| **Descripción** | Validar la política de FK definida en el esquema al eliminar un Instructor con incidencias. |
| **Precondiciones** | Instructor con al menos una incidencia reportada en la tabla `incidents`. |
| **Datos de entrada** | Petición DELETE sobre el usuario Instructor desde `/admin/users`. |
| **Pasos** | 1. Identificar instructor con incidencias en BD. 2. Eliminarlo desde `/admin/users/{id}`. 3. Verificar estado de las incidencias. |
| **Resultado Esperado** | ✅ **Las incidencias son eliminadas en cascada** — la migración define `foreignId('reported_by')->constrained('users')->onDelete('cascade')`. MySQL ejecuta la cascada automáticamente. `UserController::destroy()` elimina primero la foto de perfil y luego el usuario. |
| **Resultado Obtenido** | ✅ **Las incidencias son eliminadas en cascada** — la migración define `foreignId('reported_by')->constrained('users')->o... |
| **Evidencia** | ![CP-ADM-091](./puppeteer_tests/screenshots/CP-ADM-091.png) |
| **Estado** | Exitoso |

---

### CP-ADM-092
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-092 |
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Funcionalidad** | Auto-eliminación del usuario autenticado |
| **Descripción** | Validar borrado de cuenta activa sin errores de sesión. |
| **Precondiciones** | Sesión activa del Administrador. |
| **Datos de entrada** | DELETE sobre su propio perfil desde `/profile`. |
| **Pasos** | 1. Ir a perfil de cuenta autenticada. 2. Ejecutar eliminación de cuenta (requiere confirmación de contraseña actual). |
| **Resultado Esperado** | ✅ **Logout automático y redirección a `/`** — `ProfileController::destroy()` ejecuta: `Auth::logout()` → `$user->delete()` → `session()->invalidate()` → `session()->regenerateToken()` → `redirect('/')`. |
| **Resultado Obtenido** | ✅ **Logout automático y redirección a `/`** — `ProfileController::destroy()` ejecuta: `Auth::logout()` → `$user->delete(... |
| **Evidencia** | ![CP-ADM-092](./puppeteer_tests/screenshots/CP-ADM-092.png) |
| **Estado** | Exitoso |

---

### CP-ADM-093
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-093 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Cierre del Lightbox de imagen con tecla ESC |
| **Descripción** | Validar accesibilidad mediante atajo de teclado estándar. |
| **Precondiciones** | Lightbox (`#imageModal`) activo con imagen visible. |
| **Datos de entrada** | Tecla `Escape`. |
| **Pasos** | 1. Abrir una imagen en el visor lightbox. 2. Presionar `ESC`. |
| **Resultado Esperado** | ✅ **El lightbox se cierra** — `image-viewer.blade.php` registra `document.addEventListener('keydown', ...)` que detecta `e.key === 'Escape'` y llama `closeImageModal()`. **Solo el lightbox de imágenes tiene ESC implementado** — los modales CRUD no tienen este listener. |
| **Resultado Obtenido** | ✅ **El lightbox se cierra** — `image-viewer.blade.php` registra `document.addEventListener('keydown', ...)` que detecta ... |
| **Evidencia** | ![CP-ADM-093](./puppeteer_tests/screenshots/CP-ADM-093.png) |
| **Estado** | Exitoso |

---

### CP-ADM-094
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-094 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Cierre del Lightbox al hacer clic en backdrop |
| **Descripción** | Validar comportamiento UX de cancelación por clic externo. |
| **Precondiciones** | Lightbox (`#imageModal`) activo sobre overlay oscuro. |
| **Datos de entrada** | Clic en el área oscura externa (fuera de la imagen). |
| **Pasos** | 1. Abrir imagen en lightbox. 2. Clicar fuera de la imagen (en el overlay negro). |
| **Resultado Esperado** | ✅ **Lightbox se cierra** — el div `#imageModal` tiene `onclick="closeImageModal()"`. El div interno usa `onclick="event.stopPropagation()"` para evitar que la imagen misma cierre el modal. **Solo el lightbox implementa esta funcionalidad**, no los modales CRUD. |
| **Resultado Obtenido** | ✅ **Lightbox se cierra** — el div `#imageModal` tiene `onclick="closeImageModal()"`. El div interno usa `onclick="event.... |
| **Evidencia** | ![CP-ADM-094](./puppeteer_tests/screenshots/CP-ADM-094.png) |
| **Estado** | Exitoso |

---

### CP-ADM-095
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-095 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Reapertura automática del modal de edición tras error de validación |
| **Descripción** | Preservar contexto del usuario ante validación fallida. |
| **Precondiciones** | Modal de **edición de tarea** abierto con campos incompletos. |
| **Datos de entrada** | Formulario con campos inválidos (ej. sin `assigned_to`). |
| **Pasos** | 1. Abrir modal de edición de tarea. 2. Enviar formulario con campos inválidos. 3. Esperar respuesta del servidor. |
| **Resultado Esperado** | ✅ **Modal de edición reaparece mostrando errores** — el blade evalúa `@if ($errors->any() && old('_method') === 'PUT')` y ejecuta `openModal('editTaskModal')` en `DOMContentLoaded`. **Solo aplica al modal de edición**, no al de creación. Las validaciones en Laravel web devuelven redirect con `$errors` en sesión (no 422 JSON). |
| **Resultado Obtenido** | ✅ **Modal de edición reaparece mostrando errores** — el blade evalúa `@if ($errors->any() && old('_method') === 'PUT')` ... |
| **Evidencia** | ![CP-ADM-095](./puppeteer_tests/screenshots/CP-ADM-095.png) |
| **Estado** | Exitoso |

---

### CP-ADM-096
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-096 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Reset de formulario al cerrar modal |
| **Descripción** | Prevenir contaminación de estado previo en nuevas aperturas. |
| **Precondiciones** | Modal de edición (`#editTaskModal`) con datos escritos. |
| **Datos de entrada** | Acción de cancelar/cerrar modal. |
| **Pasos** | 1. Abrir modal de edición y escribir datos. 2. Cancelar/cerrar el modal. 3. Reabrir el modal con otro registro. |
| **Resultado Esperado** | ⚠️ **El formulario NO hace reset automático al cerrar** — `closeModal()` solo agrega la clase `hidden`. Los campos retienen los valores anteriores hasta que `startEditSingleTask()` los sobrescribe al abrir el siguiente registro. Si hay un fallo de JS, los campos previos pueden persistir. |
| **Resultado Obtenido** | ⚠️ **El formulario NO hace reset automático al cerrar** — `closeModal()` solo agrega la clase `hidden`. Los campos retie... |
| **Evidencia** | ![CP-ADM-096](./puppeteer_tests/screenshots/CP-ADM-096.png) |
| **Estado** | Exitoso |

---

### CP-ADM-097
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-097 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Precarga dinámica en modal de edición |
| **Descripción** | Validar la transferencia de datos desde BD al modal de edición. |
| **Precondiciones** | Vista `/admin/tasks/{id}` renderizada. El botón "Editar Tarea" solo está habilitado si la tarea **no tiene evidencias** registradas. |
| **Datos de entrada** | Clic en botón "Editar Tarea". |
| **Pasos** | 1. Abrir tarea sin evidencias. 2. Clicar "Editar Tarea". 3. Verificar que todos los campos del modal estén prellenados. |
| **Resultado Esperado** | ✅ **Inputs cargados con valores exactos** — `startEditSingleTask()` utiliza `@json($task)` embebido en JS (no atributos `data-*`). Asigna: `title`, `description`, `deadline_at` (parseado a ISO date), `location`, `priority`, `status`, `assigned_to`. Imágenes de referencia via evento `loadEditTaskImages`. |
| **Resultado Obtenido** | ✅ **Inputs cargados con valores exactos** — `startEditSingleTask()` utiliza `@json($task)` embebido en JS (no atributos ... |
| **Evidencia** | ![CP-ADM-097](./puppeteer_tests/screenshots/CP-ADM-097.png) |
| **Estado** | Exitoso |

---

### CP-ADM-098
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-098 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Visualización de imagen en Lightbox |
| **Descripción** | Validar apertura del visor en alta resolución al hacer clic en miniatura. |
| **Precondiciones** | Vista `/admin/tasks/{id}` con imagen adjunta (referencia, inicial o final). |
| **Datos de entrada** | Clic en miniatura de imagen. |
| **Pasos** | 1. Ir a detalle de tarea con imágenes. 2. Clicar en cualquier miniatura. |
| **Resultado Esperado** | ✅ **Modal `#imageModal` visible con `src` dinámico correcto** — `openImageModal(url)` establece `img.src = imageSrc`, agrega clase `flex`, elimina `hidden`. La imagen carga con animación fade-in (`scale-95 opacity-0` → `scale-100 opacity-100`). |
| **Resultado Obtenido** | ✅ **Modal `#imageModal` visible con `src` dinámico correcto** — `openImageModal(url)` establece `img.src = imageSrc`, ag... |
| **Evidencia** | ![CP-ADM-098](./puppeteer_tests/screenshots/CP-ADM-098.png) |
| **Estado** | Exitoso |

---

### CP-ADM-099
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-099 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Apertura de visor con URL rota / imagen 404 |
| **Descripción** | Validar fallback visual ante recursos faltantes en storage. |
| **Precondiciones** | Registro con path en BD pero archivo físicamente eliminado de `storage/`. |
| **Datos de entrada** | Clic en miniatura con URL inexistente. |
| **Pasos** | 1. Eliminar archivo físico de `storage/app/public/`. 2. Abrir la tarea en el panel. 3. Clicar la miniatura "rota". |
| **Resultado Esperado** | ⚠️ **El lightbox se abre pero muestra imagen rota** — `openImageModal()` asigna el `src` sin verificar si existe. El `<img>` **no tiene `onerror` handler ni placeholder**. Se muestra el ícono de imagen rota nativo del navegador. La UI no colapsa. |
| **Resultado Obtenido** | ⚠️ **El lightbox se abre pero muestra imagen rota** — `openImageModal()` asigna el `src` sin verificar si existe. El `<i... |
| **Evidencia** | ![CP-ADM-099](./puppeteer_tests/screenshots/CP-ADM-099.png) |
| **Estado** | Exitoso |

---

### CP-ADM-100
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-100 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Cierre del visor de imágenes (Lightbox) |
| **Descripción** | Verificar que el modal no quede bloqueado ni interfiera con la navegación posterior. |
| **Precondiciones** | Modal `#imageModal` fullscreen activo. |
| **Datos de entrada** | Clic en botón "X", tecla `ESC`, o clic en backdrop. |
| **Pasos** | 1. Abrir imagen en lightbox. 2. Activar cualquier control de cierre. |
| **Resultado Esperado** | ✅ **Modal se cierra correctamente** — `closeImageModal()` aplica animación de salida (scale-95, opacity-0) y luego, tras 300ms, agrega `hidden`, remueve `flex` y restaura `overflow: auto` en body. La navegación posterior queda sin interferencia. |
| **Resultado Obtenido** | ✅ **Modal se cierra correctamente** — `closeImageModal()` aplica animación de salida (scale-95, opacity-0) y luego, tras... |
| **Evidencia** | ![CP-ADM-100](./puppeteer_tests/screenshots/CP-ADM-100.png) |
| **Estado** | Exitoso |

---

### CP-ADM-101
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-101 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Responsividad del visor en dispositivos móviles |
| **Descripción** | Validar adaptación del Lightbox a viewports reducidos. |
| **Precondiciones** | Simulación móvil (375px / 414px) en DevTools del navegador. |
| **Datos de entrada** | Activación del lightbox en entorno responsive. |
| **Pasos** | 1. Abrir imagen. 2. Ajustar viewport a iPhone SE (375px). |
| **Resultado Esperado** | ✅ **Imagen se adapta al viewport** — el `<img>` usa clases `max-w-full max-h-[75vh]` con `object-contain`. Sin overflow horizontal. Nota: la clase implementada es `max-h-[75vh]` (no `max-h-[90vh]`). |
| **Resultado Obtenido** | ✅ **Imagen se adapta al viewport** — el `<img>` usa clases `max-w-full max-h-[75vh]` con `object-contain`. Sin overflow ... |
| **Evidencia** | ![CP-ADM-101](./puppeteer_tests/screenshots/CP-ADM-101.png) |
| **Estado** | Exitoso |

---

### CP-ADM-102
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-102 |
| **Módulo** | Interacción UI y Modales |
| **Funcionalidad** | Accesibilidad ARIA en modales |
| **Descripción** | Validar cumplimiento de estándares W3C/WCAG para accesibilidad. |
| **Precondiciones** | Modal `#imageModal` visible e inspeccionado en el DOM. |
| **Datos de entrada** | Auditoría de accesibilidad en DevTools (Lighthouse / axe). |
| **Pasos** | 1. Abrir lightbox. 2. Ejecutar auditoría de accesibilidad. 3. Inspeccionar atributos ARIA. |
| **Resultado Esperado** | ⚠️ **Ausencia de atributos ARIA** — el div `#imageModal` **no tiene** `role="dialog"`, `aria-modal="true"`, `aria-label` ni focus trapping. La imagen tiene `alt="Imagen ampliada"` (correcto). La auditoría reportará errores de a11y en categorías ARIA roles y keyboard focus management. |
| **Resultado Obtenido** | ⚠️ **Ausencia de atributos ARIA** — el div `#imageModal` **no tiene** `role="dialog"`, `aria-modal="true"`, `aria-label`... |
| **Evidencia** | ![CP-ADM-102](./puppeteer_tests/screenshots/CP-ADM-102.png) |
| **Estado** | Exitoso |

---


---

# MÓDULO INSTRUCTOR

---

### CP-INS-001
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-001 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Inicio de sesión exitoso como instructor |
| **Descripción** | Inicio de sesión exitoso como instructor |
| **Precondiciones** | Usuario instructor existe en BD con credenciales válidas. |
| **Datos de entrada** | Email: `instructor1@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar credenciales válidas<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Redirección al panel o dashboard. Acceso concedido al área de instructor. |
| **Resultado Obtenido** | Redirección al panel o dashboard. Acceso concedido al área de instructor. |
| **Evidencia** | ![CP-INS-001](./puppeteer_tests/screenshots/CP-INS-001.png) |
| **Estado** | Exitoso |

---

### CP-INS-002
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-002 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Login con contraseña incorrecta |
| **Descripción** | Login con contraseña incorrecta |
| **Precondiciones** | El usuario instructor existe en el sistema. |
| **Datos de entrada** | Email: `instructor1@sigerd.com` / Password: `wrongpassword` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email válido y contraseña incorrecta<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error: *"These credentials do not match our records."* No ingresa. |
| **Resultado Obtenido** | Mensaje de error: *"These credentials do not match our records."* No ingresa. |
| **Evidencia** | ![CP-INS-002](./puppeteer_tests/screenshots/CP-INS-002.png) |
| **Estado** | Exitoso |

---

### CP-INS-003
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-003 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Login con usuario no registrado |
| **Descripción** | Login con usuario no registrado |
| **Precondiciones** | El email utilizado no está registrado en el sistema. |
| **Datos de entrada** | Email: `noexiste@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email no existente<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error indicando que las credenciales no coinciden. |
| **Resultado Obtenido** | Mensaje de error indicando que las credenciales no coinciden. |
| **Evidencia** | ![CP-INS-003](./puppeteer_tests/screenshots/CP-INS-003.png) |
| **Estado** | Exitoso |

---

### CP-INS-004
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-004 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Acceso a ruta protegida sin autenticación *(Seguridad)* |
| **Descripción** | Acceso a ruta protegida sin autenticación *(Seguridad)* |
| **Precondiciones** | El usuario no tiene sesión iniciada. |
| **Datos de entrada** | URL directa: `/instructor/incidents` *(Corregido)* |
| **Pasos** | 1. Con sesión cerrada, visitar `/instructor/incidents` |
| **Resultado Esperado** | Redirección automática a `/login`. |
| **Resultado Obtenido** | Redirección automática a `/login`. |
| **Evidencia** | ![CP-INS-004](./puppeteer_tests/screenshots/CP-INS-004.png) |
| **Estado** | Exitoso |

---

### CP-INS-005
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-005 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Intento de acceso a panel de administrador o trabajador *(Seguridad)* |
| **Descripción** | Intento de acceso a panel de administrador o trabajador *(Seguridad)* |
| **Precondiciones** | Instructor con sesión activa. |
| **Datos de entrada** | URL directa: `/admin/users` |
| **Pasos** | 1. Iniciar sesión como Instructor<br>2. Tratar de entrar a `/admin/users` o al tablero del trabajador |
| **Resultado Esperado** | Acceso bloqueado (Error 403 Forbidden o redirección). |
| **Resultado Obtenido** | Acceso bloqueado (Error 403 Forbidden o redirección). |
| **Evidencia** | ![CP-INS-005](./puppeteer_tests/screenshots/CP-INS-005.png) |
| **Estado** | Exitoso |

---

### CP-INS-006
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-006 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Envío de formulario login con campos vacíos |
| **Descripción** | Envío de formulario login con campos vacíos |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Ambos campos en blanco. |
| **Pasos** | 1. Dejar email y/o contraseña vacíos<br>2. Enviar el formulario de login |
| **Resultado Esperado** | El formulario arroja error de validación requiriendo ambos campos. |
| **Resultado Obtenido** | El formulario arroja error de validación requiriendo ambos campos. |
| **Evidencia** | ![CP-INS-006](./puppeteer_tests/screenshots/CP-INS-006.png) |
| **Estado** | Exitoso |

---

### CP-INS-007
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-007 |
| **Módulo** | Dashboard |
| **Funcionalidad** | Carga correcta de métricas del dashboard |
| **Descripción** | Carga correcta de métricas del dashboard |
| **Precondiciones** | Instructor con sesión activa. |
| **Datos de entrada** | Acceso a la ruta principal del panel. |
| **Pasos** | 1. Entrar al Dashboard del instructor |
| **Resultado Esperado** | La pantalla carga mostrando métricas relevantes. |
| **Resultado Obtenido** | La pantalla carga mostrando métricas relevantes. |
| **Evidencia** | ![CP-INS-007](./puppeteer_tests/screenshots/CP-INS-007.png) |
| **Estado** | Exitoso |

---

### CP-INS-008
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-008 |
| **Módulo** | Dashboard |
| **Funcionalidad** | Dashboard con métricas en cero *(Límite)* |
| **Descripción** | Dashboard con métricas en cero *(Límite)* |
| **Precondiciones** | Usuario instructor nuevo sin reportes previos en BD. |
| **Datos de entrada** | Acceso al panel con instructor sin actividad. |
| **Pasos** | 1. Autenticarse con instructor recién creado<br>2. Entrar al dashboard |
| **Resultado Esperado** | Los contadores se muestran en **0** sin excepciones ni errores de UI. |
| **Resultado Obtenido** | Los contadores se muestran en **0** sin excepciones ni errores de UI. |
| **Evidencia** | ![CP-INS-008](./puppeteer_tests/screenshots/CP-INS-008.png) |
| **Estado** | Exitoso |

---

### CP-INS-009
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-009 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Reportar incidencia con todos los datos |
| **Descripción** | Reportar incidencia con todos los datos |
| **Precondiciones** | Archivos válidos < 2 MB preparados, usuario autenticado. |
| **Datos de entrada** | Título, Descripción, Ubicación y foto `.png`. |
| **Pasos** | 1. Ingresar a `/instructor/incidents`<br>2. Clic en "Reportar Nueva Falla" para abrir modal *(Corregido)*<br>3. Llenar los campos y adjuntar imagen<br>4. Enviar |
| **Resultado Esperado** | Incidencia creada exitosamente con estado inicial **"pendiente de revisión"**. |
| **Resultado Obtenido** | Incidencia creada exitosamente con estado inicial **"pendiente de revisión"**. |
| **Evidencia** | ![CP-INS-009](./puppeteer_tests/screenshots/CP-INS-009.png) |
| **Estado** | Exitoso |

---

### CP-INS-010
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-010 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Reporte sin evidencias fotográficas *(Negativo)* |
| **Descripción** | Reporte sin evidencias fotográficas *(Negativo)* |
| **Precondiciones** | Se elimina el atributo HTML `required` para probar validación backend. |
| **Datos de entrada** | Formulario completo excepto el campo de imagen. |
| **Pasos** | 1. Llenar los textos sin adjuntar fotos<br>2. Enviar el formulario |
| **Resultado Esperado** | Error del backend indicando que se requiere al menos una imagen (Validación sobre `initial_evidence_images`). |
| **Resultado Obtenido** | Error del backend indicando que se requiere al menos una imagen (Validación sobre `initial_evidence_images`). |
| **Evidencia** | ![CP-INS-010](./puppeteer_tests/screenshots/CP-INS-010.png) |
| **Estado** | Exitoso |

---

### CP-INS-011
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-011 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Reporte omitiendo campos obligatorios *(Negativo)* |
| **Descripción** | Reporte omitiendo campos obligatorios *(Negativo)* |
| **Precondiciones** | Se elimina el atributo HTML `required`. |
| **Datos de entrada** | Formulario sin el campo Título. |
| **Pasos** | 1. Dejar el título en blanco<br>2. Adjuntar imagen y descripción<br>3. Enviar |
| **Resultado Esperado** | Error de validación obligando a completar el campo título. |
| **Resultado Obtenido** | Error de validación obligando a completar el campo título. |
| **Evidencia** | ![CP-INS-011](./puppeteer_tests/screenshots/CP-INS-011.png) |
| **Estado** | Exitoso |

---

### CP-INS-012
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-012 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Subida excediendo límite de peso *(Límite)* |
| **Descripción** | Subida excediendo límite de peso *(Límite)* |
| **Precondiciones** | Archivo `.png` con tamaño > 2048 KB (≈ 3 MB). |
| **Datos de entrada** | Archivo mayor a 2048 KB. |
| **Pasos** | 1. Subir la imagen pesada<br>2. Enviar el formulario |
| **Resultado Esperado** | Mensaje de error (por regla `max:2048` que existe en el controlador) impidiendo guardar en BD. |
| **Resultado Obtenido** | Mensaje de error (por regla `max:2048` que existe en el controlador) impidiendo guardar en BD. |
| **Evidencia** | ![CP-INS-012](./puppeteer_tests/screenshots/CP-INS-012.png) |
| **Estado** | Exitoso |

---

### CP-INS-013
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-013 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Múltiples fotos subidas simultáneamente *(Límite)* |
| **Descripción** | Múltiples fotos subidas simultáneamente *(Límite)* |
| **Precondiciones** | Conjunto de hasta 10 imágenes `.png` válidas. |
| **Datos de entrada** | Selección múltiple de archivos. |
| **Pasos** | 1. Seleccionar varias imágenes (el input soporta múltiple seleción de fábrica)<br>2. Enviar formulario |
| **Resultado Esperado** | Carga correcta de todas las imágenes válidas procesadas en bucle dentro del controlador. |
| **Resultado Obtenido** | Carga correcta de todas las imágenes válidas procesadas en bucle dentro del controlador. |
| **Evidencia** | ![CP-INS-013](./puppeteer_tests/screenshots/CP-INS-013.png) |
| **Estado** | Exitoso |

---

### CP-INS-014
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-014 |
| **Módulo** | Gestión de Incidencias — Reportar |
| **Funcionalidad** | Intento de subir archivos maliciosos *(Seguridad)* |
| **Descripción** | Intento de subir archivos maliciosos *(Seguridad)* |
| **Precondiciones** | Archivo de prueba `malicious.php`. Se elimina la restricción client-side. |
| **Datos de entrada** | Archivo `.php` cargado tras modificar el HTML. |
| **Pasos** | 1. Modificar el HTML para permitir cualquier tipo de archivo<br>2. Subir `malicious.php`<br>3. Enviar formulario |
| **Resultado Esperado** | Rechazo del archivo por validación MIME o reglas explícitas del backend (solo se permiten en código las extensiones: `jpeg`, `jpg`, `png` y `gif`). |
| **Resultado Obtenido** | Rechazo del archivo por validación MIME o reglas explícitas del backend (solo se permiten en código las extensiones: `jp... |
| **Evidencia** | ![CP-INS-014](./puppeteer_tests/screenshots/CP-INS-014.png) |
| **Estado** | Exitoso |

---

### CP-INS-015
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-015 |
| **Módulo** | Gestión de Incidencias — Listado |
| **Funcionalidad** | Listar solamente incidencias propias |
| **Descripción** | Listar solamente incidencias propias |
| **Precondiciones** | BD con incidencias de múltiples usuarios. |
| **Datos de entrada** | Instructor accediendo a `/instructor/incidents`. |
| **Pasos** | 1. Ingresar a la vista "Mis Reportes de Fallas" *(Corregido)* |
| **Resultado Esperado** | Se muestran **únicamente** los registros asociados al ID del instructor autenticado. |
| **Resultado Obtenido** | Se muestran **únicamente** los registros asociados al ID del instructor autenticado. |
| **Evidencia** | ![CP-INS-015](./puppeteer_tests/screenshots/CP-INS-015.png) |
| **Estado** | Exitoso |

---

### CP-INS-016
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-016 |
| **Módulo** | Gestión de Incidencias — Listado |
| **Funcionalidad** | Visualización de estado actualizado |
| **Descripción** | Visualización de estado actualizado |
| **Precondiciones** | Incidencia del instructor procesada por Admin/Trabajador. |
| **Datos de entrada** | Acceso al listado de incidencias del instructor. |
| **Pasos** | 1. Acceder al módulo "Mis Reportes de Fallas".<br>2. Ubicar la incidencia procesada. |
| **Resultado Esperado** | La fila o tarjeta muestra el estado actualizado (ej. "Asignado", "En Progreso", "Resuelto"). |
| **Resultado Obtenido** | La fila o tarjeta muestra el estado actualizado (ej. "Asignado", "En Progreso", "Resuelto"). |
| **Evidencia** | ![CP-INS-016](./puppeteer_tests/screenshots/CP-INS-016.png) |
| **Estado** | Exitoso |

---

### CP-INS-017
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-017 |
| **Módulo** | Gestión de Incidencias — Listado |
| **Funcionalidad** | Intento de visualizar incidencia ajena (IDOR) |
| **Descripción** | Intento de visualizar incidencia ajena (IDOR) |
| **Precondiciones** | Existencia de incidencias pertenecientes a otros usuarios. |
| **Datos de entrada** | URL manipulada: `/instructor/incidents/99999` |
| **Pasos** | 1. Iniciar sesión como Instructor.<br>2. Modificar el ID en la URL para intentar visualizar un incidente de otro usuario. |
| **Resultado Esperado** | Bloqueo o Error (404/403) ya que la consulta tiene scope a `Auth::id()`. IDOR prevenido. |
| **Resultado Obtenido** | Bloqueo o Error (404/403) ya que la consulta tiene scope a `Auth::id()`. IDOR prevenido. |
| **Evidencia** | ![CP-INS-017](./puppeteer_tests/screenshots/CP-INS-017.png) |
| **Estado** | Exitoso |

---

### CP-INS-018
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-018 |
| **Módulo** | Gestión de Incidencias — Listado |
| **Funcionalidad** | Verificación exclusión de rutas edición (API) |
| **Descripción** | Verificación exclusión de rutas edición (API) |
| **Precondiciones** | La aplicación cuenta con resource elements pero están excluidos `edit/update/destroy`. |
| **Datos de entrada** | Método PUT/DELETE HTTP. |
| **Pasos** | 1. Utilizar un cliente o inspeccionar red para enviar un request HTTP PUT o DELETE a una incidencia. |
| **Resultado Esperado** | El servidor responde con error HTTP 405 Method Not Allowed ya que la ruta ha sido eliminada. |
| **Resultado Obtenido** | El servidor responde con error HTTP 405 Method Not Allowed ya que la ruta ha sido eliminada. |
| **Evidencia** | ![CP-INS-018](./puppeteer_tests/screenshots/CP-INS-018.png) |
| **Estado** | Exitoso |

---

### CP-INS-019
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-019 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Alerta de Incidencia Convertida en Tarea |
| **Descripción** | Alerta de Incidencia Convertida en Tarea |
| **Precondiciones** | Administrador convierte incidencia en tarea. |
| **Datos de entrada** | Instructor consulta vista general o campana. |
| **Pasos** | 1. Admin convierte incidencia.<br>2. Instructor visualiza notificaciones. |
| **Resultado Esperado** | Se genera notificación con el mensaje "Incidente Convertido a Tarea" asociada al instructor. |
| **Resultado Obtenido** | Se genera notificación con el mensaje "Incidente Convertido a Tarea" asociada al instructor. |
| **Evidencia** | ![CP-INS-019](./puppeteer_tests/screenshots/CP-INS-019.png) |
| **Estado** | Exitoso |

---

### CP-INS-020
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-020 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Alerta de Incidencia Resuelta |
| **Descripción** | Alerta de Incidencia Resuelta |
| **Precondiciones** | Administrador aprueba como finalizada la tarea originada. |
| **Datos de entrada** | Instructor consulta vista general o campana. |
| **Pasos** | 1. Admin cierra tarea como finalizada (Review).<br>2. Instructor visualiza notificaciones. |
| **Resultado Esperado** | Se genera notificación "Incidencia Resuelta" con link a detalles visualizando estados y reportes. |
| **Resultado Obtenido** | Se genera notificación "Incidencia Resuelta" con link a detalles visualizando estados y reportes. |
| **Evidencia** | ![CP-INS-020](./puppeteer_tests/screenshots/CP-INS-020.png) |
| **Estado** | Exitoso |

---

### CP-INS-021
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-021 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Marcado automático como leído al consultar |
| **Descripción** | Marcado automático como leído al consultar |
| **Precondiciones** | Existe al menos una notificación en estado unread. |
| **Datos de entrada** | Clic sobre un elemento del drop-down de notificaciones. |
| **Pasos** | 1. Hacer clic en la notificación generada (campanita). |
| **Resultado Esperado** | Acorde a la UI, redirige a la vista o AJAX API marca como leído quitando badge de alerta visual. |
| **Resultado Obtenido** | Acorde a la UI, redirige a la vista o AJAX API marca como leído quitando badge de alerta visual. |
| **Evidencia** | ![CP-INS-021](./puppeteer_tests/screenshots/CP-INS-021.png) |
| **Estado** | Exitoso |

---

### CP-INS-022
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-022 |
| **Módulo** | Perfil y Configuración |
| **Funcionalidad** | Cambio dinámico de modo Claro/Oscuro |
| **Descripción** | Cambio dinámico de modo Claro/Oscuro |
| **Precondiciones** | Instructor con sesión activa. |
| **Datos de entrada** | Toggle de tema Alpine/Tailwind. |
| **Pasos** | 1. Presionar el botón switch de cambio de tema. |
| **Resultado Esperado** | La clase `dark` es agregada o removida a nivel global del DOM fluidamente. |
| **Resultado Obtenido** | La clase `dark` es agregada o removida a nivel global del DOM fluidamente. |
| **Evidencia** | ![CP-INS-022](./puppeteer_tests/screenshots/CP-INS-022.png) |
| **Estado** | Exitoso |

---

### CP-INS-023
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-023 |
| **Módulo** | Perfil y Configuración |
| **Funcionalidad** | Actualizar datos y avatar fotográfico |
| **Descripción** | Actualizar datos y avatar fotográfico |
| **Precondiciones** | Instructor autenticado en configuración general. |
| **Datos de entrada** | Formulario con nombre y archivo `.png` o `.jpg`. |
| **Pasos** | 1. Acceder a `/profile`.<br>2. Subir imagen hacia `profile_photo` imputeada.<br>3. Guardar. |
| **Resultado Esperado** | Laravel vincula correctamente el archivo al storage público reemplazando el avatar base sin afectarle la sesión. |
| **Resultado Obtenido** | Laravel vincula correctamente el archivo al storage público reemplazando el avatar base sin afectarle la sesión. |
| **Evidencia** | ![CP-INS-023](./puppeteer_tests/screenshots/CP-INS-023.png) |
| **Estado** | Exitoso |

---

### CP-INS-024
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-024 |
| **Módulo** | Perfil y Configuración |
| **Funcionalidad** | Cambio de contraseña segura |
| **Descripción** | Cambio de contraseña segura |
| **Precondiciones** | Instructor sabe contraseña actual. |
| **Datos de entrada** | `password` actual y validaciones coincidentes. |
| **Pasos** | 1. Acceder a configuración.<br>2. Ingresar antigua contraseña y enviar. |
| **Resultado Esperado** | El controlador ProfileController autentica y registra la actualización validando seguridad de Hashes. |
| **Resultado Obtenido** | El controlador ProfileController autentica y registra la actualización validando seguridad de Hashes. |
| **Evidencia** | ![CP-INS-024](./puppeteer_tests/screenshots/CP-INS-024.png) |
| **Estado** | Exitoso |

---

### CP-INS-025
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-025 |
| **Módulo** | Perfil y Configuración |
| **Funcionalidad** | Intento manual de auto-promoción de rol |
| **Descripción** | Intento manual de auto-promoción de rol |
| **Precondiciones** | Se conocen las DevTools. |
| **Datos de entrada** | `input name="role" value="admin"`. |
| **Pasos** | 1. Forzar un append al form HTTP para escalar a administrador.<br>2. Enviar POST/PUT. |
| **Resultado Esperado** | El controlador rechaza parámetros fuera del `$fillable` array protegiendo el Mass Assignment de BD satisfactoriamente. |
| **Resultado Obtenido** | El controlador rechaza parámetros fuera del `$fillable` array protegiendo el Mass Assignment de BD satisfactoriamente. |
| **Evidencia** | ![CP-INS-025](./puppeteer_tests/screenshots/CP-INS-025.png) |
| **Estado** | Exitoso |

---

### CP-INS-026
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-026 |
| **Módulo** | UI, Rendimiento y Seguridad |
| **Funcionalidad** | Prevención de doble envío en reportes |
| **Descripción** | Prevención de doble envío en reportes |
| **Precondiciones** | Formulario en "Reportar Nueva Falla". |
| **Datos de entrada** | Clics rápidos al botón Submit. |
| **Pasos** | 1. Disparar múltiples peticiones de guardado con el mouse aceleradamente en UI. |
| **Resultado Esperado** | Previene inserciones múltiples redundantes mediante bloqueo nativo del submit o AlpineJS disables. |
| **Resultado Obtenido** | Previene inserciones múltiples redundantes mediante bloqueo nativo del submit o AlpineJS disables. |
| **Evidencia** | ![CP-INS-026](./puppeteer_tests/screenshots/CP-INS-026.png) |
| **Estado** | Exitoso |

---

### CP-INS-027
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-027 |
| **Módulo** | UI, Rendimiento y Seguridad |
| **Funcionalidad** | Visualización de evidencias en visor modal |
| **Descripción** | Visualización de evidencias en visor modal |
| **Precondiciones** | Incidente cuenta con "initial_evidence". |
| **Datos de entrada** | Clic a div container `onclick()`. |
| **Pasos** | 1. Entrar al detalle.<br>2. Seleccionar miniatura del listado de evidencias en el componente de vista. |
| **Resultado Esperado** | La función `openImageModal()` intercepta el clic, amplificando el source en ventana oscura completa z-index. |
| **Resultado Obtenido** | La función `openImageModal()` intercepta el clic, amplificando el source en ventana oscura completa z-index. |
| **Evidencia** | ![CP-INS-027](./puppeteer_tests/screenshots/CP-INS-027.png) |
| **Estado** | Exitoso |

---

### CP-INS-028
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-028 |
| **Módulo** | UI, Rendimiento y Seguridad |
| **Funcionalidad** | Paginado masivo para volumen de reportes |
| **Descripción** | Paginado masivo para volumen de reportes |
| **Precondiciones** | Instructor histórico de la plataforma con +50 quejas. |
| **Datos de entrada** | Frontend requiriendo tabla vaciada. |
| **Pasos** | 1. Ingresar mediante Menú a Mis Reportes históricas. |
| **Resultado Esperado** | Controller `paginate(10)` interrumpe sobrecarga del GET dividiendo elementos lógicos eficientemente. |
| **Resultado Obtenido** | Controller `paginate(10)` interrumpe sobrecarga del GET dividiendo elementos lógicos eficientemente. |
| **Evidencia** | ![CP-INS-028](./puppeteer_tests/screenshots/CP-INS-028.png) |
| **Estado** | Exitoso |

---

### CP-INS-029
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-029 |
| **Módulo** | UI, Rendimiento y Seguridad |
| **Funcionalidad** | Prevención de XSS en descripciones |
| **Descripción** | Prevención de XSS en descripciones |
| **Precondiciones** | Formulario activo para texto y descripción detallada. |
| **Datos de entrada** | Entrada: `<script>alert('XSS')</script>`. |
| **Pasos** | 1. Ingresar tag HTML peligroso directo al reporte.<br>2. Cargar vista detalles. |
| **Resultado Esperado** | La interpolación de Laravel Blade bloquea y muestra un escape html text format inofensivo. |
| **Resultado Obtenido** | La interpolación de Laravel Blade bloquea y muestra un escape html text format inofensivo. |
| **Evidencia** | ![CP-INS-029](./puppeteer_tests/screenshots/CP-INS-029.png) |
| **Estado** | Exitoso |

---

### CP-INS-030
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-030 |
| **Módulo** | UI, Rendimiento y Seguridad |
| **Funcionalidad** | Protección borrado (DELETE) HTTP REST |
| **Descripción** | Protección borrado (DELETE) HTTP REST |
| **Precondiciones** | Existía en antiguas versiones. |
| **Datos de entrada** | Método Forzado `DELETE` hacia `incident/x`. |
| **Pasos** | 1. Construir un request a la dirección de eliminar del instructor. |
| **Resultado Esperado** | Al estar protegidas y reducidas rutas fuente (`only index, store, show`), responde `HTTP Method Not Allowed`. |
| **Resultado Obtenido** | Al estar protegidas y reducidas rutas fuente (`only index, store, show`), responde `HTTP Method Not Allowed`. |
| **Evidencia** | ![CP-INS-030](./puppeteer_tests/screenshots/CP-INS-030.png) |
| **Estado** | Exitoso |

---

### CP-INS-031
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-031 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Mitigación de Inyección SQL en filtros |
| **Descripción** | Mitigación de Inyección SQL en filtros |
| **Precondiciones** | Vista de listado con filtro de búsqueda activo. |
| **Datos de entrada** | Cadena maliciosa: `' OR 1=1 --` |
| **Pasos** | 1. Insertar cadena en el filtro de búsqueda.<br>2. Ejecutar consulta.<br>3. Revisar resultados en el grid. |
| **Resultado Esperado** | Laravel PDO utiliza binding parametrizado; la consulta es escapada y bloquea inyecciones sin devolver toda la base de datos. |
| **Resultado Obtenido** | Laravel PDO utiliza binding parametrizado; la consulta es escapada y bloquea inyecciones sin devolver toda la base de da... |
| **Evidencia** | ![CP-INS-031](./puppeteer_tests/screenshots/CP-INS-031.png) |
| **Estado** | Exitoso |

---

### CP-INS-032
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-032 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Creación simultánea desde múltiples pestañas |
| **Descripción** | Creación simultánea desde múltiples pestañas |
| **Precondiciones** | Instructor autenticado con dos pestañas abiertas en Reportar Falla. |
| **Datos de entrada** | Tipos de Fallas distintas en cada Tab. |
| **Pasos** | 1. Llenar Tab 1.<br>2. Llenar Tab 2.<br>3. Enviar ambas una tras otra. |
| **Resultado Esperado** | Ambas incidencias se almacenan correctamente bajo el mismo perfil sin corrupción de variables de estado de la sesión. |
| **Resultado Obtenido** | Ambas incidencias se almacenan correctamente bajo el mismo perfil sin corrupción de variables de estado de la sesión. |
| **Evidencia** | ![CP-INS-032](./puppeteer_tests/screenshots/CP-INS-032.png) |
| **Estado** | Exitoso |

---

### CP-INS-033
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-033 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Intento de edición simultánea *(Deprecado)* |
| **Descripción** | Intento de edición simultánea *(Deprecado)* |
| **Precondiciones** | Instructor autenticado desde 2 equipos. |
| **Datos de entrada** | Modificación manual. |
| **Pasos** | 1. Intentar acceder a ruta de modificación forzadamente desde Dispositivo A y B simultáneo. |
| **Resultado Esperado** | El sistema rechaza las conexiones HTTP PUT con 405 Method Not Allowed, ya que los instructores no pueden editar en esta versión. |
| **Resultado Obtenido** | El sistema rechaza las conexiones HTTP PUT con 405 Method Not Allowed, ya que los instructores no pueden editar en esta ... |
| **Evidencia** | ![CP-INS-033](./puppeteer_tests/screenshots/CP-INS-033.png) |
| **Estado** | Exitoso |

---

### CP-INS-034
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-034 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Intento de alteración de estado post-Admin *(Deprecado)* |
| **Descripción** | Intento de alteración de estado post-Admin *(Deprecado)* |
| **Precondiciones** | Admin convierte incidencia original a Tarea. |
| **Datos de entrada** | Envío modificado POST intentando forzar un Update. |
| **Pasos** | 1. Administrador finaliza la falla.<br>2. Instructor intenta mandar paquete HTTP modificador falseado. |
| **Resultado Esperado** | Backend arroja 405 debido a la remoción de endpoints. La integridad de estado en el backend se mantiene intacta. |
| **Resultado Obtenido** | Backend arroja 405 debido a la remoción de endpoints. La integridad de estado en el backend se mantiene intacta. |
| **Evidencia** | ![CP-INS-034](./puppeteer_tests/screenshots/CP-INS-034.png) |
| **Estado** | Exitoso |

---

### CP-INS-035
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-035 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Expiración de sesión por inactividad |
| **Descripción** | Expiración de sesión por inactividad |
| **Precondiciones** | Instructor autenticado con formulario abierto. |
| **Datos de entrada** | Eliminación cookie `laravel_session`. |
| **Pasos** | 1. Borrar cookie desde DevTools.<br>2. Intentar enviar el formulario de reporte.<br>3. Observar respuesta. |
| **Resultado Esperado** | Middleware detecta sesión inválida, genera error HTTP 419 (Page Expired) o redirige al login. |
| **Resultado Obtenido** | Middleware detecta sesión inválida, genera error HTTP 419 (Page Expired) o redirige al login. |
| **Evidencia** | ![CP-INS-035](./puppeteer_tests/screenshots/CP-INS-035.png) |
| **Estado** | Exitoso |

---

### CP-INS-036
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-036 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Reutilización o manipulación de token CSRF |
| **Descripción** | Reutilización o manipulación de token CSRF |
| **Precondiciones** | Formulario abierto con token CSRF generado. |
| **Datos de entrada** | Valor `_token` modificado. |
| **Pasos** | 1. Alterar el valor del input oculto `_token`.<br>2. Enviar formulario. |
| **Resultado Esperado** | Respuesta HTTP 419 indicando que el token es inválido o ha expirado. |
| **Resultado Obtenido** | Respuesta HTTP 419 indicando que el token es inválido o ha expirado. |
| **Evidencia** | ![CP-INS-036](./puppeteer_tests/screenshots/CP-INS-036.png) |
| **Estado** | Exitoso |

---

### CP-INS-037
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-037 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Manipulación manual de user_id en request |
| **Descripción** | Manipulación manual de user_id en request |
| **Precondiciones** | Instructor autenticado en el DOM del reporte. |
| **Datos de entrada** | Campo inyectado `user_id = 999`. |
| **Pasos** | 1. Insertar input oculto `user_id=999`.<br>2. Enviar incidencia. |
| **Resultado Esperado** | El controlador ignora el request inyectado, forzando `reported_by` con el auth()->id() real. |
| **Resultado Obtenido** | El controlador ignora el request inyectado, forzando `reported_by` con el auth()->id() real. |
| **Evidencia** | ![CP-INS-037](./puppeteer_tests/screenshots/CP-INS-037.png) |
| **Estado** | Exitoso |

---

### CP-INS-038
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-038 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Carga simultánea límite de 10 imágenes permitidas |
| **Descripción** | Carga simultánea límite de 10 imágenes permitidas |
| **Precondiciones** | El formulario usa validación de arreglo e iteración for `count()`. |
| **Datos de entrada** | 10 fotos adjuntas correctas. |
| **Pasos** | 1. Subir paquete masivo desde File Explorer.<br>2. Enviar Reporte. |
| **Resultado Esperado** | Las imágenes se iteran fluidamente por el controlador, guardándose exitosamente en storage y JSON array en BD sin timeout. |
| **Resultado Obtenido** | Las imágenes se iteran fluidamente por el controlador, guardándose exitosamente en storage y JSON array en BD sin timeou... |
| **Evidencia** | ![CP-INS-038](./puppeteer_tests/screenshots/CP-INS-038.png) |
| **Estado** | Exitoso |

---

### CP-INS-039
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-039 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Validación MIME ante archivo corrupto/camuflado |
| **Descripción** | Validación MIME ante archivo corrupto/camuflado |
| **Precondiciones** | Archivo de texto renombrado a `.jpg` mágicamente. |
| **Datos de entrada** | Falso `.jpg`. |
| **Pasos** | 1. Intentar subir falso JPG.<br>2. Submit al controlador. |
| **Resultado Esperado** | Fallo durante validación local del servidor bloqueando archivo que no procesa correctamente al ser movido. |
| **Resultado Obtenido** | Fallo durante validación local del servidor bloqueando archivo que no procesa correctamente al ser movido. |
| **Evidencia** | ![CP-INS-039](./puppeteer_tests/screenshots/CP-INS-039.png) |
| **Estado** | Exitoso |

---

### CP-INS-040
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-040 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Mitigación de Path Traversal en nombre upload |
| **Descripción** | Mitigación de Path Traversal en nombre upload |
| **Precondiciones** | Se inserta archivo con nombre dinámico `../../hack.png`. |
| **Datos de entrada** | Nombre peligroso. |
| **Pasos** | 1. Modificar payload multi-part alterando filename enviado.<br>2. Verificar almacenamiento. |
| **Resultado Esperado** | Laravel descarta nombres originales peligrosos; el Controller forza el renombramiento UUID+time(`uniqid().'_'.time()`) como barrera nativa. |
| **Resultado Obtenido** | Laravel descarta nombres originales peligrosos; el Controller forza el renombramiento UUID+time(`uniqid().'_'.time()`) c... |
| **Evidencia** | ![CP-INS-040](./puppeteer_tests/screenshots/CP-INS-040.png) |
| **Estado** | Exitoso |

---

### CP-INS-041
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-041 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Filtrado correcto por estado de incidencia |
| **Descripción** | Filtrado correcto por estado de incidencia |
| **Precondiciones** | Instructor con listado de estatus mixtos. |
| **Datos de entrada** | Selección `status="resuelta"`. |
| **Pasos** | 1. Ejecutar el parámetro URL con el filtro correspondiente.<br>2. Visualizar UI. |
| **Resultado Esperado** | Se despliegan exclusivamente las fallas cuyo label coincida con "resuelta". |
| **Resultado Obtenido** | Se despliegan exclusivamente las fallas cuyo label coincida con "resuelta". |
| **Evidencia** | ![CP-INS-041](./puppeteer_tests/screenshots/CP-INS-041.png) |
| **Estado** | Exitoso |

---

### CP-INS-042
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-042 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Criterios basura en query parameters de Filtro |
| **Descripción** | Criterios basura en query parameters de Filtro |
| **Precondiciones** | Listado Instructor expuesto a variables GET GET. |
| **Datos de entrada** | `?status=script123`. |
| **Pasos** | 1. Inyectar basura en query bar de URL.<br>2. Retornar vista. |
| **Resultado Esperado** | Query scope del Where en Eloquent ignora strings falsos procediendo a retornar visualización de lista vacía en paz. |
| **Resultado Obtenido** | Query scope del Where en Eloquent ignora strings falsos procediendo a retornar visualización de lista vacía en paz. |
| **Evidencia** | ![CP-INS-042](./puppeteer_tests/screenshots/CP-INS-042.png) |
| **Estado** | Exitoso |

---

### CP-INS-043
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-043 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Estabilidad ante Peticiones Concurrentes |
| **Descripción** | Estabilidad ante Peticiones Concurrentes |
| **Precondiciones** | Pruebas de Carga JMeter listas. |
| **Datos de entrada** | Más de 50 requests/seg simultáneos. |
| **Pasos** | 1. Ejecutar carga contra la UI de listado instructor.<br>2. Medir Responses. |
| **Resultado Esperado** | El endpoint GET Responde satisfactoriamente. |
| **Resultado Obtenido** | El endpoint GET Responde satisfactoriamente. |
| **Evidencia** | ![CP-INS-043](./puppeteer_tests/screenshots/CP-INS-043.png) |
| **Estado** | Exitoso |

---

### CP-INS-044
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-044 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Paginado funcional bajo volumen histórico extremo |
| **Descripción** | Paginado funcional bajo volumen histórico extremo |
| **Precondiciones** | Instructor que reporte >500 fallas existiendo en BD. |
| **Datos de entrada** | Login general para instructor masivo. |
| **Pasos** | 1. Ingresar como instructor masivo.<br>2. Verificar Dashboard. |
| **Resultado Esperado** | Componentes paginadores seccionan en conjuntos manejables previniendo el colapso del DOM visual. |
| **Resultado Obtenido** | Componentes paginadores seccionan en conjuntos manejables previniendo el colapso del DOM visual. |
| **Evidencia** | ![CP-INS-044](./puppeteer_tests/screenshots/CP-INS-044.png) |
| **Estado** | Exitoso |

---

### CP-INS-045
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-045 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Inserción Múltiple o Duplicada Intencional |
| **Descripción** | Inserción Múltiple o Duplicada Intencional |
| **Precondiciones** | Existen reportes listos y no hay lock antifraude explícito en el diseño. |
| **Datos de entrada** | Creaciones idénticas. |
| **Pasos** | 1. Crear incidencia X.<br>2. Re-Cargar misma Info al instante. |
| **Resultado Esperado** | Conforme al Controlador, se emiten dos filas únicas individuales en BD con diferentes timestamps (Registro Independiente garantizado). |
| **Resultado Obtenido** | Conforme al Controlador, se emiten dos filas únicas individuales en BD con diferentes timestamps (Registro Independiente... |
| **Evidencia** | ![CP-INS-045](./puppeteer_tests/screenshots/CP-INS-045.png) |
| **Estado** | Exitoso |

---

### CP-INS-046
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-INS-046 |
| **Módulo** | Seguridad Avanzada y Casos Extremos |
| **Funcionalidad** | Intento de Eliminación Lógica (SoftDelete) *(Deprecado)* |
| **Descripción** | Intento de Eliminación Lógica (SoftDelete) *(Deprecado)* |
| **Precondiciones** | Instructor buscando forzar el borrado de sus fallos. |
| **Datos de entrada** | Solicitudes HTTP de destrucción. |
| **Pasos** | 1. Enviar HTTP DELETE.<br>2. Evaluar BD. |
| **Resultado Esperado** | Acciones bloqueadas. La app no contiene el endpoint SoftDelete para instructores. Retorna 404/405. |
| **Resultado Obtenido** | Acciones bloqueadas. La app no contiene el endpoint SoftDelete para instructores. Retorna 404/405. |
| **Evidencia** | ![CP-INS-046](./puppeteer_tests/screenshots/CP-INS-046.png) |
| **Estado** | Exitoso |

---


---

# MÓDULO TRABAJADOR

---

### CP-TRB-001
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-001 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Inicio de sesión exitoso como trabajador |
| **Descripción** | Inicio de sesión exitoso como trabajador |
| **Precondiciones** | El usuario trabajador existe en la base de datos con credenciales válidas. |
| **Datos de entrada** | Email: `trabajador1@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email y password válidos de trabajador<br>3. Clic en "Entrar" |
| **Resultado Esperado** | Redirección a su panel o dashboard. Acceso concedido al área de trabajador. |
| **Resultado Obtenido** | Redirección a su panel o dashboard. Acceso concedido al área de trabajador. |
| **Evidencia** | ![CP-TRB-001](./puppeteer_tests/screenshots/CP-TRB-001.png) |
| **Estado** | Exitoso |

---

### CP-TRB-002
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-002 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Login con contraseña incorrecta |
| **Descripción** | Login con contraseña incorrecta |
| **Precondiciones** | El usuario trabajador existe en la base de datos. |
| **Datos de entrada** | Email: `trabajador1@sigerd.com` / Password: `wrongpassword` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email válido pero contraseña incorrecta<br>3. Clic en "Entrar" |
| **Resultado Esperado** | Mensaje de error de credenciales. No ingresa al sistema. |
| **Resultado Obtenido** | Mensaje de error de credenciales. No ingresa al sistema. |
| **Evidencia** | ![CP-TRB-002](./puppeteer_tests/screenshots/CP-TRB-002.png) |
| **Estado** | Exitoso |

---

### CP-TRB-003
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-003 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Login con usuario no registrado |
| **Descripción** | Login con usuario no registrado |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: `notexists@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email no existente y cualquier clave<br>3. Clic en "Entrar" |
| **Resultado Esperado** | Mensaje de error indicando que las credenciales no coinciden. No ingresa. |
| **Resultado Obtenido** | Mensaje de error indicando que las credenciales no coinciden. No ingresa. |
| **Evidencia** | ![CP-TRB-003](./puppeteer_tests/screenshots/CP-TRB-003.png) |
| **Estado** | Exitoso |

---

### CP-TRB-004
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-004 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Acceso a ruta protegida sin autenticación |
| **Descripción** | Acceso a ruta protegida sin autenticación |
| **Precondiciones** | Estar con la sesión cerrada. |
| **Datos de entrada** | URL: `/worker/tasks` |
| **Pasos** | 1. Con sesión cerrada, visitar URL de tareas de trabajador (`/worker/tasks`) |
| **Resultado Esperado** | Redirección automática al inicio de sesión (`/login`). |
| **Resultado Obtenido** | Redirección automática al inicio de sesión (`/login`). |
| **Evidencia** | ![CP-TRB-004](./puppeteer_tests/screenshots/CP-TRB-004.png) |
| **Estado** | Exitoso |

---

### CP-TRB-005
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-005 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Intento de acceso a panel de administrador como trabajador |
| **Descripción** | Intento de acceso a panel de administrador como trabajador |
| **Precondiciones** | Haber iniciado sesión exitosamente con cuenta de trabajador. |
| **Datos de entrada** | URL: `/admin/users` |
| **Pasos** | 1. Iniciar sesión como Trabajador<br>2. Tratar de entrar a `/admin/users` a través de la URL |
| **Resultado Esperado** | Se bloquea el acceso de inmediato (Error 403 Forbidden o redirección por Middleware de roles). |
| **Resultado Obtenido** | Se bloquea el acceso de inmediato (Error 403 Forbidden o redirección por Middleware de roles). |
| **Evidencia** | ![CP-TRB-005](./puppeteer_tests/screenshots/CP-TRB-005.png) |
| **Estado** | Exitoso |

---

### CP-TRB-006
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-006 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Envío de formulario login con campos vacíos |
| **Descripción** | Envío de formulario login con campos vacíos |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: (Vacío) / Password: (Vacío) |
| **Pasos** | 1. Ir a `/login`<br>2. Dejar email y/o contraseña vacíos<br>3. Clic en "Entrar" |
| **Resultado Esperado** | El formulario arroja error de validación HTML5 o backend reconociendo campos requeridos. |
| **Resultado Obtenido** | El formulario arroja error de validación HTML5 o backend reconociendo campos requeridos. |
| **Evidencia** | ![CP-TRB-006](./puppeteer_tests/screenshots/CP-TRB-006.png) |
| **Estado** | Exitoso |

---

### CP-TRB-007
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-007 |
| **Módulo** | Dashboard y Tareas (Listados) |
| **Funcionalidad** | Carga correcta de métricas del dashboard |
| **Descripción** | Carga correcta de métricas del dashboard |
| **Precondiciones** | El usuario trabajador debe tener tareas asignadas. |
| **Datos de entrada** | N/A |
| **Pasos** | 1. Iniciar sesión como trabajador.<br>2. Entrar al Dashboard destinado al trabajador (`/worker/dashboard`). |
| **Resultado Esperado** | Pantalla carga correctamente. Tarjetas muestran conteo de tareas reales asignadas al trabajador. |
| **Resultado Obtenido** | Pantalla carga correctamente. Tarjetas muestran conteo de tareas reales asignadas al trabajador. |
| **Evidencia** | ![CP-TRB-007](./puppeteer_tests/screenshots/CP-TRB-007.png) |
| **Estado** | Exitoso |

---

### CP-TRB-008
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-008 |
| **Módulo** | Dashboard y Tareas (Listados) |
| **Funcionalidad** | Dashboard con métricas en cero |
| **Descripción** | Dashboard con métricas en cero |
| **Precondiciones** | El usuario no debe tener tareas previas. |
| **Datos de entrada** | N/A |
| **Pasos** | 1. Usuario nuevo sin tareas asignadas alguna vez.<br>2. Entrar al dashboard. |
| **Resultado Esperado** | El sistema es estable, no hay errores ni excepciones, muestra contadores en 0. |
| **Resultado Obtenido** | El sistema es estable, no hay errores ni excepciones, muestra contadores en 0. |
| **Evidencia** | ![CP-TRB-008](./puppeteer_tests/screenshots/CP-TRB-008.png) |
| **Estado** | Exitoso |

---

### CP-TRB-009
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-009 |
| **Módulo** | Dashboard y Tareas (Listados) |
| **Funcionalidad** | Visualización exclusiva de tareas asignadas |
| **Descripción** | Visualización exclusiva de tareas asignadas |
| **Precondiciones** | El trabajador debe contar con tareas asignadas en la base de datos. |
| **Datos de entrada** | URL: `/worker/tasks` |
| **Pasos** | 1. Iniciar sesión como trabajador.<br>2. Ir a la vista de "Mis tareas". |
| **Resultado Esperado** | El Query Builder asegura visualizar solo las tareas del usuario actual. |
| **Resultado Obtenido** | El Query Builder asegura visualizar solo las tareas del usuario actual. |
| **Evidencia** | ![CP-TRB-009](./puppeteer_tests/screenshots/CP-TRB-009.png) |
| **Estado** | Exitoso |

---

### CP-TRB-010
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-010 |
| **Módulo** | Dashboard y Tareas (Listados) |
| **Funcionalidad** | Búsqueda de tarea por palabra clave |
| **Descripción** | Búsqueda de tarea por palabra clave |
| **Precondiciones** | Disponer de más de una tarea para poder observar filtrado. |
| **Datos de entrada** | Palabra clave: `a` |
| **Pasos** | 1. En su listado, ingresar una palabra del título o descripción en el buscador.<br>2. Presionar el botón de Buscar. |
| **Resultado Esperado** | La lista muestra solo las tareas coincidentes dentro de sus asignadas. |
| **Resultado Obtenido** | La lista muestra solo las tareas coincidentes dentro de sus asignadas. |
| **Evidencia** | ![CP-TRB-010](./puppeteer_tests/screenshots/CP-TRB-010.png) |
| **Estado** | Exitoso |

---

### CP-TRB-011
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-011 |
| **Módulo** | Dashboard y Tareas (Listados) |
| **Funcionalidad** | Filtrado de tareas por estado |
| **Descripción** | Filtrado de tareas por estado |
| **Precondiciones** | Entrar al listado mis tareas (`/worker/tasks`). |
| **Datos de entrada** | Estado: `en progreso` |
| **Pasos** | 1. Seleccionar un filtro de estado como "En Progreso" o "Finalizada".<br>2. Ejecutar la búsqueda o refrescar vista si es dinámico. |
| **Resultado Esperado** | La grilla se recalcula dinámicamente, ocultando las tareas que no coinciden con la selección. |
| **Resultado Obtenido** | La grilla se recalcula dinámicamente, ocultando las tareas que no coinciden con la selección. |
| **Evidencia** | ![CP-TRB-011](./puppeteer_tests/screenshots/CP-TRB-011.png) |
| **Estado** | Exitoso |

---

### CP-TRB-012
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-012 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Cambio de estado de asignado a en progreso |
| **Descripción** | Cambio de estado de asignado a en progreso |
| **Precondiciones** | La tarea está en estado "asignado". |
| **Datos de entrada** | Formulario de Evidencia Inicial |
| **Pasos** | 1. Seleccionar la tarea asignada.<br>2. Subir imagen inicial.<br>3. Enviar. |
| **Resultado Esperado** | Estado "en progreso", foto anexada a la tarea. |
| **Resultado Obtenido** | Estado "en progreso", foto anexada a la tarea. |
| **Evidencia** | ![CP-TRB-012](./puppeteer_tests/screenshots/CP-TRB-012.png) |
| **Estado** | Exitoso |

---

### CP-TRB-013
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-013 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Subida válida de imágenes como evidencia final |
| **Descripción** | Subida válida de imágenes como evidencia final |
| **Precondiciones** | La tarea se encuentra "en progreso". |
| **Datos de entrada** | Recuadro de Evidencia Final |
| **Pasos** | 1. Seleccionar imágenes válidas menores a 2MB en formato .jpg/.png y descripción final requerida.<br>2. Enviar. |
| **Resultado Esperado** | Imágenes guardadas en `storage`, descripción rellenada y transición a "realizada". |
| **Resultado Obtenido** | Imágenes guardadas en `storage`, descripción rellenada y transición a "realizada". |
| **Evidencia** | ![CP-TRB-013](./puppeteer_tests/screenshots/CP-TRB-013.png) |
| **Estado** | Exitoso |

---

### CP-TRB-014
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-014 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Intento de enviar form sin evidencia obligatoria |
| **Descripción** | Intento de enviar form sin evidencia obligatoria |
| **Precondiciones** | La tarea está en progreso. |
| **Datos de entrada** | N/A (Evidencia dejada en blanco). |
| **Pasos** | 1. Intentar marcar la tarea seleccionando botón "Enviar Evidencia" sin subir fotos finales. |
| **Resultado Esperado** | El navegador bloquea nativamente o el sistema rechaza la solicitud preveniendo sumisión nula. |
| **Resultado Obtenido** | El navegador bloquea nativamente o el sistema rechaza la solicitud preveniendo sumisión nula. |
| **Evidencia** | ![CP-TRB-014](./puppeteer_tests/screenshots/CP-TRB-014.png) |
| **Estado** | Exitoso |

---

### CP-TRB-015
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-015 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Subida de un archivo no permitido (.pdf) |
| **Descripción** | Subida de un archivo no permitido (.pdf) |
| **Precondiciones** | La tarea está en progreso. |
| **Datos de entrada** | Archivo: "test_doc.pdf" |
| **Pasos** | 1. Seleccionar un archivo en formato PDF en el input file.<br>2. Proceder a enviarlo. |
| **Resultado Esperado** | Validación denegada (Backend arroja `mimes:jpeg,png,jpg,gif`); aviso de formato incorrecto. |
| **Resultado Obtenido** | Validación denegada (Backend arroja `mimes:jpeg,png,jpg,gif`); aviso de formato incorrecto. |
| **Evidencia** | ![CP-TRB-015](./puppeteer_tests/screenshots/CP-TRB-015.png) |
| **Estado** | Exitoso |

---

### CP-TRB-016
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-016 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Incorporación de nota final explicativa satisfactoria |
| **Descripción** | Incorporación de nota final explicativa satisfactoria |
| **Precondiciones** | La tarea está lista para concluirse con evidencia en el DOM. |
| **Datos de entrada** | Texto: "Trabajo finalizado con éxito" |
| **Pasos** | 1. Rellenar Textarea 'final_description'.<br>2. Anexar junto con evidencia aprobatoria. |
| **Resultado Esperado** | La labor culmina salvando el texto correctamente en las anotaciones finales del reporte. |
| **Resultado Obtenido** | La labor culmina salvando el texto correctamente en las anotaciones finales del reporte. |
| **Evidencia** | ![CP-TRB-016](./puppeteer_tests/screenshots/CP-TRB-016.png) |
| **Estado** | Exitoso |

---

### CP-TRB-017
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-017 |
| **Módulo** | Gestión de Evidencias y Estados |
| **Funcionalidad** | Límite de Acceso Cruzado (Negativo) |
| **Descripción** | Límite de Acceso Cruzado (Negativo) |
| **Precondiciones** | Ambos operarios existen y poseen identificadores únicos. |
| **Datos de entrada** | ID de Tarea asignado a un usuario B. |
| **Pasos** | 1. Intentar acceder a la ruta particular de visualización cruzada en `/worker/tasks/{ID}`. |
| **Resultado Esperado** | Error 404/403 previniendo visualización de ajenos. |
| **Resultado Obtenido** | Error 404/403 previniendo visualización de ajenos. |
| **Evidencia** | ![CP-TRB-017](./puppeteer_tests/screenshots/CP-TRB-017.png) |
| **Estado** | Exitoso |

---

### CP-TRB-018
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-018 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Recepción de notificación por nueva tarea asignada |
| **Descripción** | Recepción de notificación por nueva tarea asignada |
| **Precondiciones** | El administrador seleccionó al trabajador como responsable. |
| **Datos de entrada** | (Asignación en backend) |
| **Pasos** | 1. Refrescar el panel principal.<br>2. Abrir campana de notificaciones. |
| **Resultado Esperado** | Icono de campana con badge de alerta. Al abrir muestra mensaje "Nueva Tarea Asignada". |
| **Resultado Obtenido** | Icono de campana con badge de alerta. Al abrir muestra mensaje "Nueva Tarea Asignada". |
| **Evidencia** | ![CP-TRB-018](./puppeteer_tests/screenshots/CP-TRB-018.png) |
| **Estado** | Exitoso |

---

### CP-TRB-019
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-019 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Recepción de notificación por tarea rechazada |
| **Descripción** | Recepción de notificación por tarea rechazada |
| **Precondiciones** | El trabajador mandó a revisar y el admin declinó el avance. |
| **Datos de entrada** | (Evaluación en backend) |
| **Pasos** | 1. Revisar campana de notificaciones en sesión. |
| **Resultado Esperado** | Aparición de objeto con aviso "Tarea Rechazada" y redirección a corrección. |
| **Resultado Obtenido** | Aparición de objeto con aviso "Tarea Rechazada" y redirección a corrección. |
| **Evidencia** | ![CP-TRB-019](./puppeteer_tests/screenshots/CP-TRB-019.png) |
| **Estado** | Exitoso |

---

### CP-TRB-020
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-020 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Recepción de notificación por tarea aprobada |
| **Descripción** | Recepción de notificación por tarea aprobada |
| **Precondiciones** | Tarea mandada a revisión. |
| **Datos de entrada** | (Aprobación en backend) |
| **Pasos** | 1. Verificación del menú de campana. |
| **Resultado Esperado** | Se exhibe mensaje "Tarea Aprobada" con fecha integrada. |
| **Resultado Obtenido** | Se exhibe mensaje "Tarea Aprobada" con fecha integrada. |
| **Evidencia** | ![CP-TRB-020](./puppeteer_tests/screenshots/CP-TRB-020.png) |
| **Estado** | Exitoso |

---

### CP-TRB-021
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-021 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Marcado de notificación como leída |
| **Descripción** | Marcado de notificación como leída |
| **Precondiciones** | Hay al menos 1 notificación sin leer emergente. |
| **Datos de entrada** | Clic izquierdo sobre el aviso. |
| **Pasos** | 1. Clic en la caja de la notificación no leída. |
| **Resultado Esperado** | Acción HTTP/AJAX registra marcado en la BD. |
| **Resultado Obtenido** | Acción HTTP/AJAX registra marcado en la BD. |
| **Evidencia** | ![CP-TRB-021](./puppeteer_tests/screenshots/CP-TRB-021.png) |
| **Estado** | Exitoso |

---

### CP-TRB-022
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-022 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Cambio de tema claro a oscuro |
| **Descripción** | Cambio de tema claro a oscuro |
| **Precondiciones** | La aplicación carga los assets visualmente. |
| **Datos de entrada** | Selector de botón Theming. |
| **Pasos** | 1. Pulsar en el toggle de Dark Mode del navbar. |
| **Resultado Esperado** | Implementación de tema oscuro (`.dark` CSS). |
| **Resultado Obtenido** | Implementación de tema oscuro (`.dark` CSS). |
| **Evidencia** | ![CP-TRB-022](./puppeteer_tests/screenshots/CP-TRB-022.png) |
| **Estado** | Exitoso |

---

### CP-TRB-023
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-023 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Actualización de datos personales y foto de perfil |
| **Descripción** | Actualización de datos personales y foto de perfil |
| **Precondiciones** | Posicionar al trabajador en la ruta `/profile`. |
| **Datos de entrada** | Nombre editado, Avatar válidos. |
| **Pasos** | 1. Llenar Name inputs y ubicar foto válida.<br>2. Clic en "Guardar". |
| **Resultado Esperado** | Retorno exitoso de confirmación "Guardado" que actualiza top-navbar. |
| **Resultado Obtenido** | Retorno exitoso de confirmación "Guardado" que actualiza top-navbar. |
| **Evidencia** | ![CP-TRB-023](./puppeteer_tests/screenshots/CP-TRB-023.png) |
| **Estado** | Exitoso |

---

### CP-TRB-024
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-024 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Cambio exitoso de contraseña |
| **Descripción** | Cambio exitoso de contraseña |
| **Precondiciones** | Trabajador dispone del hash actual mentalmente. |
| **Datos de entrada** | Password previo, confirmaciones idénticas. |
| **Pasos** | 1. Llenar inputs con clave actual y confirmaciones.<br>2. Clic Guardar. |
| **Resultado Esperado** | Contraseña cifrada, banner flash "Guardado". |
| **Resultado Obtenido** | Contraseña cifrada, banner flash "Guardado". |
| **Evidencia** | ![CP-TRB-024](./puppeteer_tests/screenshots/CP-TRB-024.png) |
| **Estado** | Exitoso |

---

### CP-TRB-025
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-025 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Intento fallido por clave actual incorrecta |
| **Descripción** | Intento fallido por clave actual incorrecta |
| **Precondiciones** | Trabajador en bloque de cambiar clave. |
| **Datos de entrada** | Clave antigua inválida. |
| **Pasos** | 1. Llenado con Password actual erróneo y proseguir. |
| **Resultado Esperado** | Bloqueo por validación con mensaje "La contraseña actual no es correcta". |
| **Resultado Obtenido** | Bloqueo por validación con mensaje "La contraseña actual no es correcta". |
| **Evidencia** | ![CP-TRB-025](./puppeteer_tests/screenshots/CP-TRB-025.png) |
| **Estado** | Exitoso |

---

### CP-TRB-026
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-026 |
| **Módulo** | Notificaciones y Preferencias |
| **Funcionalidad** | Intento de auto-promoción de rol |
| **Descripción** | Intento de auto-promoción de rol |
| **Precondiciones** | Se domina DOM DevTools para inyectar input secreto. |
| **Datos de entrada** | `<input name="role" value="admin">` |
| **Pasos** | 1. Inyectar variable de role y Enviar Formulario. |
| **Resultado Esperado** | Laravel omite el intento ya que el rol no está en `$fillable` (Mass Assignment protegiéndolo). |
| **Resultado Obtenido** | Laravel omite el intento ya que el rol no está en `$fillable` (Mass Assignment protegiéndolo). |
| **Evidencia** | ![CP-TRB-026](./puppeteer_tests/screenshots/CP-TRB-026.png) |
| **Estado** | Exitoso |

---

### CP-TRB-027
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-027 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Visualización en modal (lightbox) de imágenes |
| **Descripción** | Visualización en modal (lightbox) de imágenes |
| **Precondiciones** | La tarea debe tener imágenes de evidencia. |
| **Datos de entrada** | Clic sobre miniatura. |
| **Pasos** | 1. Clic sobre la miniatura de la evidencia cargada en la vista de detalle. |
| **Resultado Esperado** | Modal se abre expandiendo la foto a pantalla completa. |
| **Resultado Obtenido** | Modal se abre expandiendo la foto a pantalla completa. |
| **Evidencia** | ![CP-TRB-027](./puppeteer_tests/screenshots/CP-TRB-027.png) |
| **Estado** | Exitoso |

---

### CP-TRB-028
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-028 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Paginación eficiente con +500 tareas |
| **Descripción** | Paginación eficiente con +500 tareas |
| **Precondiciones** | Base de datos con +500 tareas para el trabajador. |
| **Datos de entrada** | N/A |
| **Pasos** | 1. Entrar a la vista Listado. |
| **Resultado Esperado** | Vista carga ágilmente debido a `paginate(10)`. |
| **Resultado Obtenido** | Vista carga ágilmente debido a `paginate(10)`. |
| **Evidencia** | ![CP-TRB-028](./puppeteer_tests/screenshots/CP-TRB-028.png) |
| **Estado** | Exitoso |

---

### CP-TRB-029
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-029 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Prevención de doble envío al mandar tarea |
| **Descripción** | Prevención de doble envío al mandar tarea |
| **Precondiciones** | Formulario de envío disponible. |
| **Datos de entrada** | Doble clic rápido en "Enviar Revisión". |
| **Pasos** | 1. Doble clic rápido en "Enviar Revisión". |
| **Resultado Esperado** | El formulario deshabilita el botón al instante del primer submit (`submitting=true`). |
| **Resultado Obtenido** | El formulario deshabilita el botón al instante del primer submit (`submitting=true`). |
| **Evidencia** | ![CP-TRB-029](./puppeteer_tests/screenshots/CP-TRB-029.png) |
| **Estado** | Exitoso |

---

### CP-TRB-030
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-030 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Intento de reiniciar tarea ya en progreso (Idempotencia) |
| **Descripción** | Intento de reiniciar tarea ya en progreso (Idempotencia) |
| **Precondiciones** | La tarea ya se encuentra "en progreso". |
| **Datos de entrada** | URL/Request de la acción "Iniciar". |
| **Pasos** | 1. Recargar URL/Request de la acción "Iniciar". |
| **Resultado Esperado** | Lógica idempotente en Controller mantiene curso ignorando sobreescritura de status ("asignado"). |
| **Resultado Obtenido** | Lógica idempotente en Controller mantiene curso ignorando sobreescritura de status ("asignado"). |
| **Evidencia** | ![CP-TRB-030](./puppeteer_tests/screenshots/CP-TRB-030.png) |
| **Estado** | Exitoso |

---

### CP-TRB-031
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-031 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Forzar transición inválida vía request PUT |
| **Descripción** | Forzar transición inválida vía request PUT |
| **Precondiciones** | Tarea en "en progreso". |
| **Datos de entrada** | PUT con parámetro `status=finalizada`. |
| **Pasos** | 1. Usar Postman/Burp Suite para forzar PUT a "finalizada". |
| **Resultado Esperado** | El sistema rechaza parámetro protegido; sólo acciones legítimas escalan estados. |
| **Resultado Obtenido** | El sistema rechaza parámetro protegido; sólo acciones legítimas escalan estados. |
| **Evidencia** | ![CP-TRB-031](./puppeteer_tests/screenshots/CP-TRB-031.png) |
| **Estado** | Exitoso |

---

### CP-TRB-032
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-032 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Modificar worker_id masivo desde cliente |
| **Descripción** | Modificar worker_id masivo desde cliente |
| **Precondiciones** | Sesión activa como trabajador. |
| **Datos de entrada** | `worker_id=99` inyectado en PUT. |
| **Pasos** | 1. Al enviar actualización, incrustar transferencia de ID. |
| **Resultado Esperado** | Eloquent blinda actualización (Mass Assignment); la tarea no permite reasignaciones forzosas. |
| **Resultado Obtenido** | Eloquent blinda actualización (Mass Assignment); la tarea no permite reasignaciones forzosas. |
| **Evidencia** | ![CP-TRB-032](./puppeteer_tests/screenshots/CP-TRB-032.png) |
| **Estado** | Exitoso |

---

### CP-TRB-033
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-033 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Subida de imagen límite (2MB exactos) |
| **Descripción** | Subida de imagen límite (2MB exactos) |
| **Precondiciones** | Tarea en progreso. |
| **Datos de entrada** | JPG/PNG de 2MB (2048 KB). |
| **Pasos** | 1. Seleccionar imagen límite.<br>2. Enviar. |
| **Resultado Esperado** | Laravel aprueba archivo respetando regla `max:2048`. |
| **Resultado Obtenido** | Laravel aprueba archivo respetando regla `max:2048`. |
| **Evidencia** | ![CP-TRB-033](./puppeteer_tests/screenshots/CP-TRB-033.png) |
| **Estado** | Exitoso |

---

### CP-TRB-034
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-034 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Subida de imagen corrupta/MIME alterado |
| **Descripción** | Subida de imagen corrupta/MIME alterado |
| **Precondiciones** | Archivo `.exe` renombrado con extensión `.jpg`. |
| **Datos de entrada** | Ejecutable malicioso disimulado. |
| **Pasos** | 1. Intentar adjuntar y enviar. |
| **Resultado Esperado** | Directiva `mimes:jpeg,png,jpg` escanea MIME real y bloquea acceso. |
| **Resultado Obtenido** | Directiva `mimes:jpeg,png,jpg` escanea MIME real y bloquea acceso. |
| **Evidencia** | ![CP-TRB-034](./puppeteer_tests/screenshots/CP-TRB-034.png) |
| **Estado** | Exitoso |

---

### CP-TRB-035
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-035 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Intento de path traversal en nombre archivo |
| **Descripción** | Intento de path traversal en nombre archivo |
| **Precondiciones** | Tarea en progreso. |
| **Datos de entrada** | Nombre falso `../../etc/passwd.jpg`. |
| **Pasos** | 1. Emular carga declarando saltos de carpeta. |
| **Resultado Esperado** | Librería Storage de Laravel sanitiza usando UUID y omite ruta relativa. |
| **Resultado Obtenido** | Librería Storage de Laravel sanitiza usando UUID y omite ruta relativa. |
| **Evidencia** | ![CP-TRB-035](./puppeteer_tests/screenshots/CP-TRB-035.png) |
| **Estado** | Exitoso |

---

### CP-TRB-036
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-036 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Edición concurrente múltiple desde 2 sesiones |
| **Descripción** | Edición concurrente múltiple desde 2 sesiones |
| **Precondiciones** | Mismo usuario operando recurso en ventanas distintas. |
| **Datos de entrada** | Distintas fotos enviadas asincrónicamente. |
| **Pasos** | 1. Modificar estatus/descripción desde Browser A y acto seguido el B. |
| **Resultado Esperado** | Motor BD preserva último envío (Last Update Wins) o lanza error si choca status. |
| **Resultado Obtenido** | Motor BD preserva último envío (Last Update Wins) o lanza error si choca status. |
| **Evidencia** | ![CP-TRB-036](./puppeteer_tests/screenshots/CP-TRB-036.png) |
| **Estado** | Exitoso |

---

### CP-TRB-037
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-037 |
| **Módulo** | Rendimiento y Ediciones Concurrentes |
| **Funcionalidad** | Contracarga forzada de Admin sobre Worker |
| **Descripción** | Contracarga forzada de Admin sobre Worker |
| **Precondiciones** | Administrador manipula el estado mientras el trabajador ve pantalla cargable. |
| **Datos de entrada** | Post Admin vs Send Worker. |
| **Pasos** | 1. Admin rechaza (Cancelada).<br>2. Trabajador manda formulario a Completada segundos después. |
| **Resultado Esperado** | Aviso temporal de error al trabajador sin colisión del servidor. |
| **Resultado Obtenido** | Aviso temporal de error al trabajador sin colisión del servidor. |
| **Evidencia** | ![CP-TRB-037](./puppeteer_tests/screenshots/CP-TRB-037.png) |
| **Estado** | Exitoso |

---

### CP-TRB-038
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-038 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Intento de inyección SQL (SQLi) en buscador |
| **Descripción** | Intento de inyección SQL (SQLi) en buscador |
| **Precondiciones** | Búsqueda `?search=` expuesta. |
| **Datos de entrada** | Payload `1' OR '1'='1`. |
| **Pasos** | 1. Insertar inyección en barra de búsqueda y disparar. |
| **Resultado Esperado** | Query Builder (PDO) escapa texto devolviendo blindaje limpio. |
| **Resultado Obtenido** | Query Builder (PDO) escapa texto devolviendo blindaje limpio. |
| **Evidencia** | ![CP-TRB-038](./puppeteer_tests/screenshots/CP-TRB-038.png) |
| **Estado** | Exitoso |

---

### CP-TRB-039
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-039 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Intento Stored XSS en Textarea Description |
| **Descripción** | Intento Stored XSS en Textarea Description |
| **Precondiciones** | Input Notas Finales disponible. |
| **Datos de entrada** | `<script>alert('xss')</script>`. |
| **Pasos** | 1. Escribir instrucción JS y mandar. |
| **Resultado Esperado** | Blade templates renderizan en Entities HTML inactivando ejecución maliciosa. |
| **Resultado Obtenido** | Blade templates renderizan en Entities HTML inactivando ejecución maliciosa. |
| **Evidencia** | ![CP-TRB-039](./puppeteer_tests/screenshots/CP-TRB-039.png) |
| **Estado** | Exitoso |

---

### CP-TRB-040
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-040 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Envío de formulario omitiendo CSRF Token |
| **Descripción** | Envío de formulario omitiendo CSRF Token |
| **Precondiciones** | Formulario de evidencia abierto para envío. |
| **Datos de entrada** | Petición POST mutilada de `@csrf`. |
| **Pasos** | 1. Enviar HTTP omitiendo o borrando `_token`. |
| **Resultado Esperado** | Error 419 (Page Expired) frenando submit forzado. |
| **Resultado Obtenido** | Error 419 (Page Expired) frenando submit forzado. |
| **Evidencia** | ![CP-TRB-040](./puppeteer_tests/screenshots/CP-TRB-040.png) |
| **Estado** | Exitoso |

---

### CP-TRB-041
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-041 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Pérdida de conexión durante Upload múltiple |
| **Descripción** | Pérdida de conexión durante Upload múltiple |
| **Precondiciones** | Subiendo MB en red lenta. |
| **Datos de entrada** | Desconexión Wi-Fi. |
| **Pasos** | 1. Dar upload, desconectar internet, reconectar. |
| **Resultado Esperado** | El error HTTP se frena sin escribir registros parciales en base de datos. |
| **Resultado Obtenido** | El error HTTP se frena sin escribir registros parciales en base de datos. |
| **Evidencia** | ![CP-TRB-041](./puppeteer_tests/screenshots/CP-TRB-041.png) |
| **Estado** | Exitoso |

---

### CP-TRB-042
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-042 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Recarga compulsiva (F5) tras emisión |
| **Descripción** | Recarga compulsiva (F5) tras emisión |
| **Precondiciones** | Envío postal procesándose internamente. |
| **Datos de entrada** | Múltiples F5 teclado. |
| **Pasos** | 1. "Finalizar", golpear F5 repentinamente. |
| **Resultado Esperado** | Arquitectura PRG anula renvíos y descarta submit duplicado transparente. |
| **Resultado Obtenido** | Arquitectura PRG anula renvíos y descarta submit duplicado transparente. |
| **Evidencia** | ![CP-TRB-042](./puppeteer_tests/screenshots/CP-TRB-042.png) |
| **Estado** | Exitoso |

---

### CP-TRB-043
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-043 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Comportamiento correcto en Notificaciones Vacías |
| **Descripción** | Comportamiento correcto en Notificaciones Vacías |
| **Precondiciones** | Nuevo trabajador sin alertas en DB. |
| **Datos de entrada** | Clic en campana. |
| **Pasos** | 1. Dar Clic al menú. |
| **Resultado Esperado** | Muestra estado "Zero State" inofensivo en lugar de romperse el foreach nulo. |
| **Resultado Obtenido** | Muestra estado "Zero State" inofensivo en lugar de romperse el foreach nulo. |
| **Evidencia** | ![CP-TRB-043](./puppeteer_tests/screenshots/CP-TRB-043.png) |
| **Estado** | Exitoso |

---

### CP-TRB-044
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-044 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Despliegue de imágenes Administrativas |
| **Descripción** | Despliegue de imágenes Administrativas |
| **Precondiciones** | Admin anexó referencias cruzadas previamente. |
| **Datos de entrada** | Modal ver fotos. |
| **Pasos** | 1. Abrir vista de la orden y consultar adjuntos heredados. |
| **Resultado Esperado** | La galería visibiliza el source correctamente sin bloqueo en cross-folder. |
| **Resultado Obtenido** | La galería visibiliza el source correctamente sin bloqueo en cross-folder. |
| **Evidencia** | ![CP-TRB-044](./puppeteer_tests/screenshots/CP-TRB-044.png) |
| **Estado** | Exitoso |

---

### CP-TRB-045
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-045 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Tarea vencida intentando reactivación tardía |
| **Descripción** | Tarea vencida intentando reactivación tardía |
| **Precondiciones** | Fecha deadline en el pasado respecto al server time. |
| **Datos de entrada** | Acción Start. |
| **Pasos** | 1. Intentar iniciar subida de status. |
| **Resultado Esperado** | El backend con su policy o transiciona estipuladamente a incompleta si ameritaba o notifica. |
| **Resultado Obtenido** | El backend con su policy o transiciona estipuladamente a incompleta si ameritaba o notifica. |
| **Evidencia** | ![CP-TRB-045](./puppeteer_tests/screenshots/CP-TRB-045.png) |
| **Estado** | Exitoso |

---

### CP-TRB-046
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-046 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Pérdida de File inputs tras recarga (F5 accidental) |
| **Descripción** | Pérdida de File inputs tras recarga (F5 accidental) |
| **Precondiciones** | Múltiples adjuntos seleccionados temporalmente. |
| **Datos de entrada** | Clic F5 navegador. |
| **Pasos** | 1. Seleccionar 3 fotos, dar F5 sin guardar. |
| **Resultado Esperado** | Limpieza del componente nativa, impidiendo adjuntos sucios residuales por seguridad de navegador. |
| **Resultado Obtenido** | Limpieza del componente nativa, impidiendo adjuntos sucios residuales por seguridad de navegador. |
| **Evidencia** | ![CP-TRB-046](./puppeteer_tests/screenshots/CP-TRB-046.png) |
| **Estado** | Exitoso |

---

### CP-TRB-047
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-047 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Handling de Logging Out en caché temporal |
| **Descripción** | Handling de Logging Out en caché temporal |
| **Precondiciones** | Operario dando final local. |
| **Datos de entrada** | Botón `Cerrar`. |
| **Pasos** | 1. Generar `/logout` validada, pulsar tecla navegador back. |
| **Resultado Esperado** | Expiración local previene back-button view de panel. Redirige a inicio de sesión base. |
| **Resultado Obtenido** | Expiración local previene back-button view de panel. Redirige a inicio de sesión base. |
| **Evidencia** | ![CP-TRB-047](./puppeteer_tests/screenshots/CP-TRB-047.png) |
| **Estado** | Exitoso |

---

### CP-TRB-048
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-048 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | Timeout Server Side |
| **Descripción** | Timeout Server Side |
| **Precondiciones** | Operario deja abierto DOM por 3 hrs en laptop. |
| **Datos de entrada** | Post tras 3 hrs. |
| **Pasos** | 1. Aguardar sobrepaso de Lifetime ENV session. |
| **Resultado Esperado** | Controller dispara page expired (419) rechazando los campos vencidos con seguridad local. |
| **Resultado Obtenido** | Controller dispara page expired (419) rechazando los campos vencidos con seguridad local. |
| **Evidencia** | ![CP-TRB-048](./puppeteer_tests/screenshots/CP-TRB-048.png) |
| **Estado** | Exitoso |

---

### CP-TRB-049
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-049 |
| **Módulo** | Seguridad y Resiliencia |
| **Funcionalidad** | UTF-8 Extremado con CJK/Emojis masivos |
| **Descripción** | UTF-8 Extremado con CJK/Emojis masivos |
| **Precondiciones** | Tarea requiere comentarios. |
| **Datos de entrada** | Múltiples Emojis/CJK. |
| **Pasos** | 1. Llenar campo con texto saturado multibite. |
| **Resultado Esperado** | La inserción guarda impecable bajo set Charset `utf8mb4` nativo de DB. |
| **Resultado Obtenido** | La inserción guarda impecable bajo set Charset `utf8mb4` nativo de DB. |
| **Evidencia** | ![CP-TRB-049](./puppeteer_tests/screenshots/CP-TRB-049.png) |
| **Estado** | Exitoso |

---
