# Casos de Prueba — Módulo Administrador (CP-ADM-001 al CP-ADM-102)

> **Documento consolidado y corregido.** Todos los CPs fueron validados contra el código fuente real del sistema SIGERD:
> `TaskController`, `IncidentController`, `NotificationController`, `UserController`, `ProfileController`, `PasswordController`, `AuthenticatedSessionController`, `RoleMiddleware`, `Kernel.php`, migraciones de BD y vistas Blade.

---

## Índice por Módulo

| Rango | Módulo |
|---|---|
| CP-ADM-001 – CP-ADM-006 | Autenticación — Login |
| CP-ADM-007 – CP-ADM-008 | Autorización / Middleware |
| CP-ADM-009 – CP-ADM-010 | Dashboard |
| CP-ADM-011 – CP-ADM-013 | Gestión de Tareas — Listado y Filtros |
| CP-ADM-014 – CP-ADM-020 | Gestión de Tareas — Crear |
| CP-ADM-021 – CP-ADM-023 | Gestión de Tareas — Edición |
| CP-ADM-024 – CP-ADM-026 | Flujo de Revisión y Estados |
| CP-ADM-027 – CP-ADM-028 | Reportes PDF |
| CP-ADM-029 – CP-ADM-040 | Gestión de Usuarios |
| CP-ADM-041 – CP-ADM-045 | Gestión de Incidencias |
| CP-ADM-046 – CP-ADM-047 | Conversión de Incidentes y Notificaciones |
| CP-ADM-048 – CP-ADM-052 | Mi Perfil — Autogestión |
| CP-ADM-053 – CP-ADM-060 | Seguridad Avanzada |
| CP-ADM-061 – CP-ADM-063 | Integridad del Workflow |
| CP-ADM-064 | Integridad del Workflow |
| CP-ADM-065 – CP-ADM-068 | Rendimiento |
| CP-ADM-069 – CP-ADM-072 | Sistema de Archivos y Storage |
| CP-ADM-073 – CP-ADM-075 | Notificaciones Avanzadas |
| CP-ADM-076 – CP-ADM-078 | Sesión y Autenticación Extendida |
| CP-ADM-079 – CP-ADM-083 | Validaciones de Entrada Extrema |
| CP-ADM-084 – CP-ADM-092 | Pruebas Críticas Adicionales CRUD |
| CP-ADM-093 – CP-ADM-102 | Interacción UI y Modales |

---

## CP-ADM-001

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Inicio de sesión exitoso como Administrador |
| **Objetivo** | Verificar que el administrador puede ingresar con credenciales válidas y es redirigido a su panel. |
| **Precondición** | Usuario administrador existente en BD con `role = 'administrador'`. |
| **Entrada** | Email: `admin@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`. 2. Ingresar credenciales válidas. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Redirección a `/admin/dashboard`** — `AuthenticatedSessionController::store()` llama `$request->authenticate()` y redirige según rol: `if ($user->isAdmin()) return redirect()->route('admin.dashboard')`. |

---

## CP-ADM-002

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Fallo de login por contraseña errónea |
| **Objetivo** | Verificar que el sistema rechace credenciales inválidas. |
| **Precondición** | Usuario administrador existente. |
| **Entrada** | Email: `admin@sigerd.com` / Password: `wrongpassword` |
| **Pasos** | 1. Ir a `/login`. 2. Ingresar contraseña inválida. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Mensaje de error**: `"These credentials do not match our records."` — Laravel devuelve el error al formulario sin acceso al sistema. |

---

## CP-ADM-003

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Fallo de login por usuario inexistente |
| **Objetivo** | Validar manejo de email no registrado. |
| **Precondición** | Email no existente en la tabla `users`. |
| **Entrada** | Email: `nonexistent@sigerd.com` / Password: `password` |
| **Pasos** | 1. Ir a `/login`. 2. Ingresar correo inexistente. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Mensaje de error de credenciales inválidas** — Laravel no distingue entre email no registrado y contraseña incorrecta (protección anti-enumeración por diseño). |

---

## CP-ADM-004

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Validación de campos obligatorios en login |
| **Objetivo** | Verificar que los campos email y password son requeridos. |
| **Precondición** | Ninguna. |
| **Entrada** | Email: (vacío) / Password: (vacío) |
| **Pasos** | 1. Ir a `/login`. 2. Dejar campos vacíos. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Error de validación** — `LoginRequest` tiene reglas `required` sobre `email` y `password`. Se muestran mensajes de error en el formulario. |

---

## CP-ADM-005

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Validación de formato de correo electrónico |
| **Objetivo** | Verificar que el campo email valida el formato. |
| **Precondición** | Ninguna. |
| **Entrada** | Email: `admin123` (formato inválido) |
| **Pasos** | 1. Ir a `/login`. 2. Ingresar email sin formato válido. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Mensaje de formato incorrecto** — regla `email` de `LoginRequest` rechaza el valor. Error retornado al formulario. |

---

## CP-ADM-006

| Campo | Detalle |
|---|---|
| **Módulo** | Autenticación — Login |
| **Título** | Prevención de SQL Injection en login |
| **Objetivo** | Verificar que el sistema no es vulnerable a inyección SQL en el formulario de login. |
| **Precondición** | Ninguna. |
| **Entrada** | Email: `' OR 1=1 --` |
| **Pasos** | 1. Ir a `/login`. 2. Ingresar cadena maliciosa en el campo email. 3. Clic en "Iniciar Sesión". |
| **Resultado Esperado** | ✅ **Autenticación rechazada sin error interno** — Laravel usa PDO con prepared statements; el payload no se interpreta como SQL. La regla `email` de `LoginRequest` invalida el formato antes de llegar a la BD. Sin volcado de datos. |

---

## CP-ADM-007

| Campo | Detalle |
|---|---|
| **Módulo** | Autorización / Middleware |
| **Título** | Protección de rutas restringidas sin sesión |
| **Objetivo** | Verificar que el middleware `auth` redirige a usuarios no autenticados. |
| **Precondición** | Sin sesión activa. |
| **Entrada** | URL directa: `/admin/dashboard` |
| **Pasos** | 1. Sin sesión, intentar acceder directamente a la URL protegida. |
| **Resultado Esperado** | ✅ **Redirección automática a `/login`** — el middleware `auth` detecta la ausencia de sesión y redirige. Las rutas admin están protegidas con `middleware(['auth', 'role:administrador'])`. |

---

## CP-ADM-008

| Campo | Detalle |
|---|---|
| **Módulo** | Autorización / Middleware |
| **Título** | Bloqueo por rol insuficiente |
| **Objetivo** | Verificar que un Instructor no puede acceder al área de Administrador. |
| **Precondición** | Usuario instructor existente en BD. |
| **Entrada** | Login como instructor + URL: `/admin/users` |
| **Pasos** | 1. Iniciar sesión como Instructor. 2. Intentar acceder a `/admin/users`. |
| **Resultado Esperado** | ✅ **HTTP 403 Forbidden** — `RoleMiddleware` verifica `in_array($user->role, $roles)`. El instructor tiene `role = 'instructor'`, la ruta requiere `role:administrador` → `abort(403)`. No hay redirección, solo 403. |

---

## CP-ADM-009

| Campo | Detalle |
|---|---|
| **Módulo** | Dashboard |
| **Título** | Carga correcta de métricas en el Dashboard |
| **Objetivo** | Verificar que el panel carga datos reales sin errores. |
| **Precondición** | Administrador autenticado. Existen registros en BD (usuarios, tareas, incidencias). |
| **Entrada** | Navegación a `/admin/dashboard` |
| **Pasos** | 1. Iniciar sesión como administrador. 2. Acceder al Dashboard. 3. Verificar tarjetas e indicadores. |
| **Resultado Esperado** | ✅ **Panel carga correctamente** con contadores y datos reales. Las tarjetas de métricas reflejan los valores actuales de la BD sin errores de renderizado. |

---

## CP-ADM-010

| Campo | Detalle |
|---|---|
| **Módulo** | Dashboard |
| **Título** | Dashboard en estado vacío (sin datos en BD) |
| **Objetivo** | Verificar que el sistema no presenta errores con BD vacía. |
| **Precondición** | BD sin registros de usuarios, tareas ni incidencias. |
| **Entrada** | Acceso a `/admin/dashboard` con BD vacía. |
| **Pasos** | 1. Acceder al Dashboard con base de datos vacía. 2. Observar comportamiento de los contadores. |
| **Resultado Esperado** | ✅ **Sin errores lógicos** — los contadores muestran `0` sin excepciones de iteración ni fallos de Blade. Las colecciones vacías se manejan con `count()` o `->isEmpty()`. |

---

## CP-ADM-011

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Listado |
| **Título** | Buscar tarea por título |
| **Objetivo** | Verificar el filtrado por texto en el listado de tareas. |
| **Precondición** | Tareas registradas en BD. Administrador autenticado. |
| **Entrada** | Texto: `e` en el buscador de `/admin/tasks` |
| **Pasos** | 1. Ir a `/admin/tasks`. 2. Escribir texto en el campo "Buscar título...". 3. Enviar búsqueda. |
| **Resultado Esperado** | ✅ **Solo tareas con el texto en el título** — el controlador usa `->where('title', 'like', '%' . $request->search . '%')`. Resultados paginados con `paginate(10)->withQueryString()`. |

---

## CP-ADM-012

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Listado |
| **Título** | Filtrar tareas por prioridad |
| **Objetivo** | Verificar el filtrado por prioridad en el listado. |
| **Precondición** | Tareas con diferentes prioridades existentes en BD. |
| **Entrada** | Selector de Prioridad: `alta` |
| **Pasos** | 1. Acceder a `/admin/tasks`. 2. Seleccionar "Alta" en el desplegable de prioridad. 3. Aplicar filtro. |
| **Resultado Esperado** | ✅ **Solo tareas con prioridad `alta`** — el controlador aplica `->where('priority', $request->priority)`. |

---

## CP-ADM-013

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Listado |
| **Título** | Búsqueda sin resultados |
| **Objetivo** | Verificar el comportamiento ante búsquedas sin coincidencias. |
| **Precondición** | Tareas registradas pero ninguna coincide con el texto buscado. |
| **Entrada** | Texto: `XYZ987IMPOSIBLE` |
| **Pasos** | 1. Ingresar texto inexistente en el buscador. 2. Presionar Buscar. |
| **Resultado Esperado** | ✅ **Estado vacío (Empty State)** — la consulta retorna colección vacía. La vista muestra el estado visual de "sin resultados". Sin excepción ni error. |

---

## CP-ADM-014

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Crear tarea correctamente |
| **Objetivo** | Verificar la creación exitosa de una tarea con todos los campos válidos. |
| **Precondición** | Administrador autenticado. Trabajador existente en BD. |
| **Entrada** | Título, fecha futura, ubicación, trabajador asignado (`assigned_to`), y al menos una `reference_images` válida. |
| **Pasos** | 1. Completar todos los campos obligatorios incluyendo imágenes de referencia. 2. Clic en "Crear Tarea". |
| **Resultado Esperado** | ✅ **Tarea creada con `status = 'asignado'`** — el controlador fuerza `$data['status'] = 'asignado'` independientemente del input. Se crea una notificación al trabajador (`task_assigned`). Imágenes guardadas en `storage/app/public/tasks-reference/`. |

---

## CP-ADM-015

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Validación backend de campos obligatorios |
| **Objetivo** | Verificar que el controlador valida todos los campos requeridos. |
| **Precondición** | Modal de creación disponible. |
| **Entrada** | POST vacío o con campos faltantes (`title`, `deadline_at`, `reference_images`). |
| **Pasos** | 1. Enviar formulario incompleto (saltando validación frontend si aplica). |
| **Resultado Esperado** | ✅ **Redirect de vuelta con errores** — el controlador tiene reglas `required` sobre `title`, `deadline_at`, `location`, `priority`, `assigned_to`, `reference_images`. Los errores se muestran vía `$errors`. |

---

## CP-ADM-016

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Validación de fecha límite vencida al crear |
| **Objetivo** | Verificar que no se pueden crear tareas con fecha pasada. |
| **Precondición** | Modal de creación disponible. |
| **Entrada** | `deadline_at` = ayer (fecha anterior a hoy). |
| **Pasos** | 1. Seleccionar fecha pasada. 2. Guardar tarea. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'deadline_at' => ['required', 'date', 'after_or_equal:today']`. Mensaje: `"La fecha límite no puede ser anterior al día de hoy."`. |

---

## CP-ADM-017

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Validación de prioridad fuera del enum permitido |
| **Objetivo** | Verificar que no se aceptan prioridades inválidas. |
| **Precondición** | Formulario de creación disponible. |
| **Entrada** | `priority = 'urgente'` (inyectado vía DevTools). |
| **Pasos** | 1. Inyectar opción inválida de prioridad en el HTML. 2. Guardar tarea. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'priority' => ['required', 'string', 'in:baja,media,alta']` rechaza valores fuera del enum. |

---

## CP-ADM-018

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Adjuntar imagen de referencia válida |
| **Objetivo** | Verificar la subida y almacenamiento correcto de imágenes válidas. |
| **Precondición** | Archivo imagen válido menor a 10MB disponible. |
| **Entrada** | `valid.jpg` (<10MB) en el campo `reference_images`. |
| **Pasos** | 1. Adjuntar imagen válida. 2. Crear tarea. |
| **Resultado Esperado** | ✅ **Imagen almacenada correctamente** — el sistema usa `move_uploaded_file()` hacia `storage/app/public/tasks-reference/`. El path se guarda como JSON en la columna `reference_images` de la BD. |

---

## CP-ADM-019

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Bloqueo de extensiones no permitidas en tareas |
| **Objetivo** | Verificar que solo se aceptan imágenes en el campo de evidencias de tareas. |
| **Precondición** | Archivo PDF o EXE disponible. |
| **Entrada** | `test.pdf` en el campo `reference_images`. |
| **Pasos** | 1. Adjuntar archivo prohibido. 2. Crear tarea. |
| **Resultado Esperado** | ✅ **Error de validación MIME** — regla `'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif']` de Laravel inspecciona el contenido real del archivo. El PDF es rechazado. Mensaje: `"El archivo debe ser una imagen válida."` |

---

## CP-ADM-020

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Crear |
| **Título** | Validación de tamaño máximo de archivo en tareas |
| **Objetivo** | Verificar que archivos superiores al límite son rechazados. |
| **Precondición** | Imagen mayor a 10MB disponible. |
| **Entrada** | Imagen de 15MB en el campo `reference_images`. |
| **Pasos** | 1. Adjuntar imagen superior a 10MB. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'reference_images.*' => ['max:10240']` (10MB). Mensaje: `"Cada imagen no debe exceder los 10MB."`. El archivo no se persiste. Nota: el límite de tareas es **10MB** por imagen (no 2MB como en incidencias). |

---

## CP-ADM-021

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Edición |
| **Título** | Modificar datos básicos de una tarea |
| **Objetivo** | Verificar que los cambios en título y prioridad se persisten correctamente. |
| **Precondición** | Tarea existente en estado `asignado` o `en progreso`. Sin evidencias cargadas (requisito para que el botón "Editar" esté activo). |
| **Entrada** | Nuevo título: `Título Editado por QA`. Prioridad: `alta`. |
| **Pasos** | 1. Abrir detalle de tarea sin evidencias. 2. Clicar "Editar Tarea". 3. Modificar título y prioridad. 4. Guardar. |
| **Resultado Esperado** | ✅ **BD actualizada con nuevos valores** — `TaskController::update()` valida y ejecuta `$task->update($updateData)`. El campo `updated_at` se actualiza siempre (sin `isDirty()` check). |

---

## CP-ADM-022

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Edición |
| **Título** | Edición con fecha límite vencida — conversión a estado "incompleta" |
| **Objetivo** | Verificar que guardar una tarea con deadline pasado la marca como incompleta. |
| **Precondición** | Tarea existente en estado editable. |
| **Entrada** | `deadline_at` = fecha de hace 5 días. |
| **Pasos** | 1. Editar la fecha límite retroactivamente. 2. Guardar cambios. 3. Verificar el estado resultante. |
| **Resultado Esperado** | ✅ **Estado cambia a `incompleta`** — el método `update()` **no tiene** la regla `after_or_equal:today` (a diferencia de `store()`). Tras actualizar, el controlador ejecuta: `if ($task->deadline_at < now() && $task->status !== 'finalizada' && $task->status !== 'cancelada') { $task->status = 'incompleta'; }`. |

---

## CP-ADM-023

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Tareas — Edición |
| **Título** | Agregar evidencia complementaria como Admin |
| **Objetivo** | Verificar que el Admin puede añadir más imágenes sin eliminar las existentes. |
| **Precondición** | Tarea con imágenes de evidencia ya cargadas. |
| **Entrada** | Nuevo archivo `valid.jpg` en sección de evidencias (inicial, final o referencia). |
| **Pasos** | 1. Abrir tarea existente con evidencias. 2. Subir nueva imagen en la sección correspondiente. 3. Confirmar actualización. |
| **Resultado Esperado** | ✅ **Nueva imagen añadida sin eliminar las existentes** — el controlador usa `array_merge((array) $task->reference_images, $referenceImagePaths)` para concatenar los paths. Las imágenes históricas se conservan en el JSON de la columna. |

---

## CP-ADM-024

| Campo | Detalle |
|---|---|
| **Módulo** | Flujo de Revisión y Estados |
| **Título** | Aprobar tarea finalizada |
| **Objetivo** | Verificar que el Admin puede aprobar una tarea en estado `realizada`. |
| **Precondición** | Tarea en estado `realizada` (enviada por el trabajador con evidencia final). |
| **Entrada** | Acción: `approve` vía botón "Aprobar y Finalizar". |
| **Pasos** | 1. Entrar al detalle de la tarea. 2. Clic en "Aprobar y Finalizar". |
| **Resultado Esperado** | ✅ **Estado cambia a `finalizada`** — `reviewTask()` con `action=approve` asigna `$task->status = 'finalizada'`. Si la tarea tiene incidente vinculado, actualiza el incidente a `resuelto`. Envía notificación `task_approved` al trabajador. Si hay incidente, envía `incident_resolved` al instructor. |

---

## CP-ADM-025

| Campo | Detalle |
|---|---|
| **Módulo** | Flujo de Revisión y Estados |
| **Título** | Rechazar tarea |
| **Objetivo** | Verificar que el Admin puede devolver una tarea para corrección. |
| **Precondición** | Tarea en estado `realizada`. |
| **Entrada** | Acción: `reject` vía botón "Devolver p/ Corrección". |
| **Pasos** | 1. Entrar al detalle de la tarea. 2. Clic en "Devolver p/ Corrección". |
| **Resultado Esperado** | ✅ **Estado retrocede a `en progreso`** — `reviewTask()` con `action=reject` asigna `$task->status = 'en progreso'`. Envía notificación `task_rejected` al trabajador solicitando correcciones. |

---

## CP-ADM-026

| Campo | Detalle |
|---|---|
| **Módulo** | Flujo de Revisión y Estados |
| **Título** | Marcar tarea con retraso |
| **Objetivo** | Verificar que el Admin puede marcar una tarea como "retraso en proceso". |
| **Precondición** | Tarea en estado `realizada`. |
| **Entrada** | Acción: `delay` vía botón "Marcar c/ Retraso". |
| **Pasos** | 1. Entrar al detalle de la tarea. 2. Clic en "Marcar c/ Retraso". |
| **Resultado Esperado** | ✅ **Estado cambia a `retraso en proceso`** — `reviewTask()` con `action=delay` asigna `$task->status = 'retraso en proceso'`. No se emite notificación para esta acción. |

---

## CP-ADM-027

| Campo | Detalle |
|---|---|
| **Módulo** | Reportes PDF |
| **Título** | Generación y descarga de PDF del mes actual |
| **Objetivo** | Verificar que el reporte mensual se genera y descarga correctamente. |
| **Precondición** | Tareas existentes en el mes actual. Administrador autenticado. |
| **Entrada** | Mes y año actuales en el formulario de exportación. |
| **Pasos** | 1. En el botón "Exportar PDF", seleccionar mes y año actual. 2. Confirmar exportación. |
| **Resultado Esperado** | ✅ **Descarga de archivo `.pdf`** — `exportPDF()` valida `month` (1-12) y `year` (2020-2100), carga todas las tareas del mes con `->get()`, genera estadísticas y renderiza `admin.tasks.pdf` vía DomPDF. El archivo se descarga como `reporte-mensual-SIGERD-{Mes}-{Año}.pdf`. |

---

## CP-ADM-028

| Campo | Detalle |
|---|---|
| **Módulo** | Reportes PDF |
| **Título** | PDF con mes o año inválido (fuera de rango) |
| **Objetivo** | Verificar que el controlador bloquea parámetros inválidos. |
| **Precondición** | Acceso al formulario de exportación. |
| **Entrada** | `month = 13` o `year = 1990`. |
| **Pasos** | 1. Manipular parámetros del formulario. 2. Enviar mes 13 o año fuera de rango. |
| **Resultado Esperado** | ✅ **Error de validación** — reglas: `'month' => 'required|integer|min:1|max:12'` y `'year' => 'required|integer|min:2020|max:2100'`. El PDF no se genera. |

---

## CP-ADM-029

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Búsqueda y filtrado de usuarios |
| **Objetivo** | Verificar el filtrado de usuarios por nombre o email. |
| **Precondición** | Lista de usuarios disponible en `/admin/users`. |
| **Entrada** | Nombre o email parcial en el buscador. |
| **Pasos** | 1. Ingresar en `/admin/users`. 2. Enviar string parcial de email o nombre. |
| **Resultado Esperado** | ✅ **Listado filtrado** — `UserController::index()` usa `->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")`. Resultados paginados con `paginate(5)`. |

---

## CP-ADM-030

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Crear nuevo usuario (Admin, Trabajador o Instructor) |
| **Objetivo** | Verificar la creación exitosa de un usuario con todos los campos válidos. |
| **Precondición** | Administrador autenticado. |
| **Entrada** | Nombre, email único, password confirmado, rol válido (`administrador`/`trabajador`/`instructor`), foto de perfil (requerida). |
| **Pasos** | 1. Completar el formulario de creación en `/admin/users`. 2. Enviar POST. |
| **Resultado Esperado** | ✅ **Usuario creado correctamente** — `UserController::store()` valida todos los campos incluyendo `profile_photo` (requerida, `mimes:jpeg,png,jpg,gif`, `max:2048`). El password se hashea. El rol se guarda en la columna `role`. |

---

## CP-ADM-031

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Bloqueo por email duplicado |
| **Objetivo** | Verificar que no se puede registrar un email ya existente. |
| **Precondición** | Usuario con el email objetivo ya existe en BD. |
| **Entrada** | Email ya registrado en el sistema. |
| **Pasos** | 1. Crear o editar usuario usando email perteneciente a otro registro. |
| **Resultado Esperado** | ✅ **Error de validación `unique`** — regla `'email' => ['required', 'string', 'email', 'max:255', 'unique:users']` en `UserController::store()`. Devuelve mensaje de colisión sin insertar en BD. |

---

## CP-ADM-032

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Contraseñas no coinciden al crear usuario |
| **Objetivo** | Verificar la validación de confirmación de contraseña. |
| **Precondición** | Formulario de creación de usuario activo. |
| **Entrada** | `password` distinto de `password_confirmation`. |
| **Pasos** | 1. Ingresar contraseña y confirmación diferentes. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación `confirmed`** — regla `'password' => ['required', 'confirmed', Rules\Password::defaults()]` detecta discrepancia. Mensaje de error mostrado al formulario. |

---

## CP-ADM-033

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Subida de foto de perfil exitosa al crear usuario |
| **Objetivo** | Verificar el almacenamiento correcto de la foto de perfil. |
| **Precondición** | Formulario de creación de usuario activo. |
| **Entrada** | Archivo `.png` de 1MB en campo `profile_photo`. |
| **Pasos** | 1. Crear usuario adjuntando foto de perfil válida. |
| **Resultado Esperado** | ✅ **Imagen almacenada en `storage/app/public/profile-photos/`** — `UserController::store()` usa `move_uploaded_file()` y guarda el path en la columna `profile_photo` de la BD. |

---

## CP-ADM-034

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Error: foto de perfil demasiado pesada |
| **Objetivo** | Verificar que no se aceptan imágenes superiores a 2MB. |
| **Precondición** | Archivo de imagen mayor a 2MB disponible. |
| **Entrada** | Imagen de 3MB en campo `profile_photo`. |
| **Pasos** | 1. Subir imagen que supere 2MB al crear usuario. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']`. Mensaje: `"La imagen no debe exceder los 2MB."`. |

---

## CP-ADM-035

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Error: foto de perfil con extensión inválida |
| **Objetivo** | Verificar que solo se aceptan imágenes como foto de perfil. |
| **Precondición** | Archivo `.txt` o `.pdf` disponible. |
| **Entrada** | Archivo `.txt` en campo `profile_photo`. |
| **Pasos** | 1. Subir archivo de texto simulando una imagen de perfil. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `mimes:jpeg,png,jpg,gif` rechaza el archivo. Mensaje: `"Formatos permitidos: jpeg, png, jpg, gif."`. |

---

## CP-ADM-036

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Editar usuario reemplazando foto de perfil antigua |
| **Objetivo** | Verificar que al actualizar la foto se elimina la anterior del servidor. |
| **Precondición** | Usuario con foto de perfil existente en `storage/`. |
| **Entrada** | Nueva foto válida en campo `profile_photo` al editar. |
| **Pasos** | 1. Editar usuario enviando nueva fotografía. 2. Verificar que la foto anterior ya no existe en disco. |
| **Resultado Esperado** | ✅ **Foto antigua eliminada físicamente** — `UserController::update()` usa `unlink(storage_path('app/public/' . $user->profile_photo))` antes de subir la nueva. La nueva foto se almacena y su path se actualiza en BD. |

---

## CP-ADM-037

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Edición parcial sin actualizar contraseña |
| **Objetivo** | Verificar que omitir el campo password no corrompe el hash existente. |
| **Precondición** | Usuario existente con password establecido. |
| **Entrada** | Campo `password` vacío; solo se cambia el nombre o rol. |
| **Pasos** | 1. Editar usuario modificando solo metadata (nombre, rol). 2. Dejar password en blanco. 3. Guardar. |
| **Resultado Esperado** | ✅ **Hash de contraseña original intacto** — el controlador verifica `if ($request->filled('password'))` para decidir si actualiza el hash. Si el campo está vacío, se omite completamente la actualización del password. |

---

## CP-ADM-038

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Ver perfil integral de un usuario (Show) |
| **Objetivo** | Verificar que la vista de perfil carga todas las relaciones y estadísticas. |
| **Precondición** | Usuario con tareas e incidencias asociadas en BD. |
| **Entrada** | Clic en "Ver" en la tabla de listado de usuarios. |
| **Pasos** | 1. Ir a `/admin/users`. 2. Clicar en el botón de ver perfil de un usuario. |
| **Resultado Esperado** | ✅ **Perfil cargado con estadísticas completas** — `UserController::show()` usa `withCount()` sobre `assignedTasks`, `finished_tasks_count`, `pending_tasks_count`, `reportedIncidents`, `resolved_incidents_count` y `createdTasks`. Se muestran paneles con métricas del usuario. |

---

## CP-ADM-039

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Eliminar cuenta de usuario |
| **Objetivo** | Verificar la eliminación completa del usuario y su foto de perfil. |
| **Precondición** | Usuario existente en BD con foto de perfil. |
| **Entrada** | DELETE vía formulario de confirmación en `/admin/users/{id}`. |
| **Pasos** | 1. Confirmar eliminación con el modal de confirmación. |
| **Resultado Esperado** | ✅ **Usuario eliminado de BD y archivo físico borrado** — `UserController::destroy()` usa `unlink()` para eliminar la foto de perfil del disco, luego ejecuta `$user->delete()`. Los registros dependientes (incidencias) eliminados en cascada por FK. |

---

## CP-ADM-040

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Usuarios |
| **Título** | Auto-eliminación del Admin desde lista de usuarios |
| **Objetivo** | Verificar el comportamiento al eliminar el propio usuario autenticado desde `/admin/users`. |
| **Precondición** | Administrador autenticado viendo su propia fila en `/admin/users`. |
| **Entrada** | DELETE contra el ID del propio usuario autenticado. |
| **Pasos** | 1. Clicar "Eliminar" sobre el propio registro en la tabla. |
| **Resultado Esperado** | ⚠️ **El sistema NO tiene protección explícita en `UserController::destroy()` contra la auto-eliminación** — el registro se elimina de BD y la foto física se borra. La sesión activa persiste hasta el siguiente request, momento en que el middleware `auth` no encuentra el usuario y redirige a `/login`. Para auto-eliminación con logout inmediato, el usuario debe usar `/profile` (ver CP-ADM-092). |

---

## CP-ADM-041

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Incidencias |
| **Título** | Listar y buscar incidencias |
| **Objetivo** | Verificar el filtrado y búsqueda en el listado de incidencias. |
| **Precondición** | Incidencias registradas en BD. |
| **Entrada** | Texto de búsqueda o filtro de fecha `created_at_from`. |
| **Pasos** | 1. Acceder a `/admin/incidents`. 2. Aplicar filtros de texto o fecha. |
| **Resultado Esperado** | ✅ **Resultados filtrados correctamente** — `IncidentController::index()` aplica `OR LIKE` sobre `title`, `description`, `location`, `name` (del reportador) y `email`. Filtro adicional `whereDate('created_at', '=', $fecha)`. Ordenado por `created_at DESC`, paginado con `paginate(10)`. |

---

## CP-ADM-042

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Incidencias |
| **Título** | Crear incidencia desde panel Admin |
| **Objetivo** | Verificar la creación de incidencias desde el módulo Admin. |
| **Precondición** | Administrador autenticado. Modal de incidencias disponible. |
| **Entrada** | `title`, `description`, `location`, `report_date` (≤ hoy) y al menos 1 imagen de evidencia. |
| **Pasos** | 1. Completar formulario con campos requeridos. 2. Adjuntar imágenes. 3. Guardar. |
| **Resultado Esperado** | ✅ **Incidencia creada con `status = 'pendiente de revisión'`** — `IncidentController::store()` asigna el estado automáticamente. El Admin que crea queda como `reported_by`. Imágenes guardadas en `storage/app/public/incident-evidence/`. |

---

## CP-ADM-043

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Incidencias |
| **Título** | Rechazado por omitir fotos de evidencia en incidencia |
| **Objetivo** | Verificar que las imágenes de evidencia son obligatorias. |
| **Precondición** | Formulario de incidencias disponible. |
| **Entrada** | Formulario enviado sin adjuntar ninguna imagen en `initial_evidence_images`. |
| **Pasos** | 1. Completar campos de texto. 2. Enviar sin adjuntar imágenes. |
| **Resultado Esperado** | ✅ **Error de validación** — el controlador verifica la ausencia de archivos y retorna: `"Debe subir al menos una imagen de evidencia."`. La incidencia no se persiste. |

---

## CP-ADM-044

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Incidencias |
| **Título** | Intento de subir más de 10 imágenes en una incidencia |
| **Objetivo** | Verificar el límite máximo de imágenes por incidencia. |
| **Precondición** | Formulario de incidencias disponible. |
| **Entrada** | Más de 10 archivos de imagen en `initial_evidence_images`. |
| **Pasos** | 1. Seleccionar 11 o más imágenes. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación** — `if ($fileCount > 10) { return back()->withErrors(['initial_evidence_images' => 'No puedes subir más de 10 imágenes.']); }`. La incidencia no se persiste. |

---

## CP-ADM-045

| Campo | Detalle |
|---|---|
| **Módulo** | Gestión de Incidencias |
| **Título** | Fecha de reporte futurista en incidencia |
| **Objetivo** | Verificar que no se permiten fechas de reporte futuras. |
| **Precondición** | Formulario de incidencias disponible. |
| **Entrada** | `report_date` = mañana. |
| **Pasos** | 1. Seleccionar fecha de mañana como fecha de reporte. 2. Guardar incidencia. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `'report_date' => ['required', 'date', 'before_or_equal:today']`. Se impide falsificación de trazabilidad cronológica. |

---

## CP-ADM-046

| Campo | Detalle |
|---|---|
| **Módulo** | Conversión de Incidentes y Notificaciones |
| **Título** | Convertir incidencia a tarea |
| **Objetivo** | Verificar el flujo de conversión de incidencia a tarea y la migración de evidencias. |
| **Precondición** | Incidencia en estado `pendiente de revisión` con evidencias adjuntas. |
| **Entrada** | `task_title`, `task_description`, `assigned_to`, `priority` (`baja/media/alta`), `deadline_at` (≥ hoy), `location`. |
| **Pasos** | 1. Abrir detalle de incidencia. 2. Completar formulario de conversión. 3. Guardar. |
| **Resultado Esperado** | ✅ **Incidencia pasa a `asignado` y nueva tarea creada** — `IncidentController::convertToTask()` crea `Task` con `status = 'asignado'`, `incident_id`, y `reference_images = $incident->initial_evidence_images`. Las evidencias de la incidencia se heredan como imágenes de referencia de la tarea. |

---

## CP-ADM-047

| Campo | Detalle |
|---|---|
| **Módulo** | Conversión de Incidentes y Notificaciones |
| **Título** | Doble notificación al convertir incidencia |
| **Objetivo** | Verificar que la conversión notifica a ambas partes involucradas. |
| **Precondición** | Conversión del CP-ADM-046 ejecutada exitosamente. |
| **Entrada** | Revisión de registros en tabla `notifications`. |
| **Pasos** | 1. Ejecutar la conversión de CP-ADM-046. 2. Verificar notificaciones generadas en BD. |
| **Resultado Esperado** | ✅ **Se crean exactamente 2 notificaciones** — `convertToTask()` emite: (1) al trabajador asignado (`type = 'task_assigned'`, `title = 'Nueva Tarea Asignada'`), y (2) al instructor reportador (`type = 'incident_converted'`, `title = 'Incidente Convertido a Tarea'`). |

---

## CP-ADM-048

| Campo | Detalle |
|---|---|
| **Módulo** | Mi Perfil — Autogestión |
| **Título** | Actualizar foto de perfil personal |
| **Objetivo** | Verificar que el Admin puede actualizar su propia foto desde `/profile`. |
| **Precondición** | Administrador autenticado en `/profile`. Archivo `.jpg` válido disponible. |
| **Entrada** | Archivo `.jpg` válido en campo `profile_photo`. |
| **Pasos** | 1. Abrir vista de Perfil. 2. Seleccionar nueva foto. 3. Guardar. |
| **Resultado Esperado** | ✅ **Nueva foto almacenada y visible en navbar** — `ProfileController::update()` maneja la subida, reemplaza la foto en `storage/app/public/profile-photos/` y actualiza el path en BD. La foto vieja es eliminada con `unlink()`. |

---

## CP-ADM-049

| Campo | Detalle |
|---|---|
| **Módulo** | Mi Perfil — Autogestión |
| **Título** | Actualizar email y pérdida de verificación |
| **Objetivo** | Verificar que cambiar el email resetea la verificación. |
| **Precondición** | Admin con email verificado activo. |
| **Entrada** | Nuevo email válido y único en el formulario de perfil. |
| **Pasos** | 1. Ir a `/profile`. 2. Cambiar email por uno distinto. 3. Guardar. |
| **Resultado Esperado** | ✅ **`email_verified_at` pasa a `null`** — Laravel Breeze detecta el cambio de email y resetea el campo de verificación, requiriendo re-confirmación por seguridad. |

---

## CP-ADM-050

| Campo | Detalle |
|---|---|
| **Módulo** | Mi Perfil — Autogestión |
| **Título** | Cambio de contraseña seguro |
| **Objetivo** | Verificar el flujo de actualización de contraseña con validación completa. |
| **Precondición** | Admin autenticado con contraseña conocida. |
| **Entrada** | `current_password` real + `password` nueva + `password_confirmation` coincidente. |
| **Pasos** | 1. Ir a la sección de cambio de contraseña en `/profile`. 2. Completar los tres campos. 3. Guardar. |
| **Resultado Esperado** | ✅ **Hash actualizado sin cerrar la sesión actual** — `PasswordController::update()` verifica la contraseña actual con `Hash::check()`, luego actualiza el hash. La sesión en curso se mantiene activa (ver CP-ADM-077 para la limitación de multi-sesión). |

---

## CP-ADM-051

| Campo | Detalle |
|---|---|
| **Módulo** | Mi Perfil — Autogestión |
| **Título** | Borrado de cuenta propia con confirmación de password |
| **Objetivo** | Verificar el borrado de cuenta con logout automático. |
| **Precondición** | Admin autenticado. |
| **Entrada** | Contraseña actual correcta en el modal de confirmación de `/profile`. |
| **Pasos** | 1. Ir al menú de borrado en `/profile`. 2. Confirmar con clave legítima. 3. Enviar DELETE a `/profile`. |
| **Resultado Esperado** | ✅ **Cuenta eliminada y sesión cerrada** — `ProfileController::destroy()` verifica password actual, ejecuta `Auth::logout()` → `$user->delete()` → `session()->invalidate()` → `session()->regenerateToken()` → `redirect('/')`. |

---

## CP-ADM-052

| Campo | Detalle |
|---|---|
| **Módulo** | Mi Perfil — Autogestión |
| **Título** | Prevenir borrado de cuenta con contraseña incorrecta |
| **Objetivo** | Verificar que la cuenta no se puede borrar sin la contraseña correcta. |
| **Precondición** | Admin autenticado. Modal de eliminación de cuenta abierto. |
| **Entrada** | Contraseña incorrecta en el campo de confirmación. |
| **Pasos** | 1. Abrir modal de eliminación de cuenta en `/profile`. 2. Ingresar contraseña incorrecta. 3. Confirmar. |
| **Resultado Esperado** | ✅ **Error de validación** — `ProfileController::destroy()` usa `Hash::check($request->password, $user->password)`. Si falla, devuelve error en el `userDeletion` error bag. La cuenta NO se elimina. |

---

## CP-ADM-053

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Manipulación de ID en URL (exposición de datos) |
| **Objetivo** | Verificar que el sistema maneja IDs inexistentes sin exponer información. |
| **Precondición** | Acceso autenticado como Admin. |
| **Entrada** | URL: `/admin/tasks/99999` (ID inexistente). |
| **Pasos** | 1. Modificar el ID en la URL por uno que no existe en BD. |
| **Resultado Esperado** | ✅ **HTTP 404 Not Found** — `TaskController::show()` usa `Task::with([...])->findOrFail($id)`. Laravel devuelve error 404 estándar sin exponer lógica de negocio. |

---

## CP-ADM-054

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Formulario sin CSRF Token |
| **Objetivo** | Verificar que el middleware CSRF rechaza requests sin token. |
| **Precondición** | Cliente REST (Postman, Thunderclient) con acceso a POST. |
| **Entrada** | POST a `/admin/tasks` sin incluir `_token` CSRF. |
| **Pasos** | 1. Enviar POST limpio sin token CSRF. |
| **Resultado Esperado** | ✅ **HTTP 419 (Page Expired / CSRF Token Mismatch)** — el middleware `VerifyCsrfToken` intercepta la solicitud y retorna 419 sin llegar al controlador. |

---

## CP-ADM-055

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Petición con verbo HTTP incorrecto |
| **Objetivo** | Verificar que el sistema rechaza verbos no permitidos. |
| **Precondición** | Acceso autenticado. |
| **Entrada** | GET con query params a una ruta que solo acepta POST (`/admin/tasks`). |
| **Pasos** | 1. Enviar GET donde el router espera POST. |
| **Resultado Esperado** | ✅ **HTTP 405 Method Not Allowed** — Laravel Router rechaza el verbo HTTP. El mensaje `"Method Not Allowed"` no expone información interna. |

---

## CP-ADM-056

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Escalada de privilegios por Mass Assignment vía campo `role` |
| **Objetivo** | Verificar que no es posible escalar privilegios inyectando el campo `role`. |
| **Precondición** | Sesión activa de trabajador o instructor con inspector del navegador. |
| **Entrada** | Campo `role = 'administrador'` inyectado vía DevTools en formulario de usuario. |
| **Pasos** | 1. Inyectar campo `role` oculto en un formulario de edición de usuario. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Field ignorado o rechazado** — `UserController::update()` tiene la regla `'role' => ['required', 'string', 'in:administrador,trabajador,instructor']`. Valores como `superadmin` o `root` son rechazados. Valores válidos solo pueden ser modificados por el Admin autenticado. |

---

## CP-ADM-057

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Intento de Path Traversal en inputs de archivo |
| **Objetivo** | Verificar que el sistema no permite acceder a archivos fuera del storage mediante path traversal. |
| **Precondición** | Formulario con campo de archivo disponible. |
| **Entrada** | Nombre de archivo: `../../.env` o similar. |
| **Pasos** | 1. Intentar subir archivo con nombre tipo Path Traversal. |
| **Resultado Esperado** | ✅ **Sin acceso a archivos del sistema** — el sistema genera nombres de archivo únicos con `uniqid()` ignorando el nombre original del cliente (`pathinfo($fileName, PATHINFO_EXTENSION)` solo toma la extensión). El nombre malicioso no se usa para escritura. Laravel también previene acceso directo a rutas fuera del DocumentRoot. |

---

## CP-ADM-058

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Inyección de `status` al crear tarea |
| **Objetivo** | Verificar que el estado de la tarea no puede ser manipulado al crear. |
| **Precondición** | Formulario de creación de tarea disponible. |
| **Entrada** | Campo `status = 'finalizada'` inyectado al body del POST de creación. |
| **Pasos** | 1. Intercepción del request de creación. 2. Añadir `status=finalizada`. 3. Enviar. |
| **Resultado Esperado** | ✅ **Estado ignorado, forzado a `asignado`** — el controlador ejecuta `$data['status'] = 'asignado'` después del `except()`, sobreescribiendo cualquier valor enviado. La tarea siempre inicia en estado `asignado`. |

---

## CP-ADM-059

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Intento de subir WebShell con doble extensión |
| **Objetivo** | Verificar que el sistema rechaza scripts PHP disfrazados de imagen. |
| **Precondición** | Archivo `image.jpg.php` (script PHP) disponible. |
| **Entrada** | Archivo `image.jpg.php` en campo `reference_images` de tarea. |
| **Pasos** | 1. Intentar subir archivo con doble extensión PHP en el formulario de tareas. |
| **Resultado Esperado** | ✅ **Archivo rechazado** — la regla `'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif']` de Laravel inspecciona el contenido real del archivo (no solo la extensión). Un archivo PHP no pasa la validación `image`. La validación de `mimes:` usa `finfo` o `getimagesize()` internamente. |

---

## CP-ADM-060

| Campo | Detalle |
|---|---|
| **Módulo** | Seguridad Avanzada |
| **Título** | Aprobar tarea sin evidencia final (flexibilidad gerencial) |
| **Objetivo** | Verificar que el Admin puede aprobar tareas aunque carezcan de evidencia final. |
| **Precondición** | Tarea que no tiene `final_evidence_images` registradas. |
| **Entrada** | Acción `approve` sobre la tarea sin evidencia final. |
| **Pasos** | 1. Acceder como Admin a tarea sin evidencia final. 2. Clicar en "Aprobar y Finalizar". |
| **Resultado Esperado** | ✅ **La aprobación procede exitosamente** — `reviewTask()` valida solo `'action' => ['required', 'string', 'in:approve,reject,delay']`. No hay validación adicional de evidencias. La aprobación es una decisión gerencial discrecional del Admin. |

---

## CP-ADM-061

| Campo | Detalle |
|---|---|
| **Módulo** | Integridad del Workflow |
| **Título** | Incidencia convertida pero tarea eliminada luego por un Admin |
| **Objetivo** | Evaluar la consistencia bidireccional entre Incidencia y Tarea tras el borrado de la tarea. |
| **Precondición** | Tarea creada a partir de una incidencia mediante "Convertir a Tarea" (relacionadas por `incident_id`). La incidencia tiene estado `asignado`. |
| **Entrada** | Petición DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Ir a `/admin/tasks`. 2. Eliminar la tarea vinculada a la incidencia. 3. Revisar la incidencia original en `/admin/incidents`. |
| **Resultado Esperado** | ✅ **La incidencia mantiene el estado `asignado`** — el método `destroy()` en `TaskController` solo ejecuta `$task->delete()` sin ningún hook que actualice el estado de la incidencia. No existe sincronización inversa. |

---

## CP-ADM-062

| Campo | Detalle |
|---|---|
| **Módulo** | Integridad del Workflow |
| **Título** | Cambiar manualmente incidencia a "resuelto" sin tarea asociada |
| **Objetivo** | Probar si el sistema bloquea transiciones de estado inválidas en incidencias. |
| **Precondición** | Incidencia en estado `pendiente de revisión` existente en la BD. |
| **Entrada** | Intento de actualizar directamente `status = resuelto` vía herramienta externa (ej. Postman/cURL). |
| **Pasos** | 1. Autenticarse y obtener token de sesión (cookie de Laravel). 2. Enviar un PUT/PATCH manipulado con `status=resuelto`. |
| **Resultado Esperado** | ⚠️ **La solicitud falla con error 405 (Method Not Allowed) o 404** — `IncidentController` en el panel Admin **no implementa método `update()`**. El estado solo se actualiza vía lógica interna (`convertToTask` → `asignado`, o `reviewTask` → `resuelto`). |

---

## CP-ADM-063

| Campo | Detalle |
|---|---|
| **Módulo** | Integridad del Workflow |
| **Título** | Fecha límite de tarea igual a hora/fecha exacta actual |
| **Objetivo** | Comprobar comportamiento cuando `deadline_at` es exactamente igual a `now()`. |
| **Precondición** | Creación de tarea con `deadline_at` igual al timestamp exacto del servidor. |
| **Entrada** | `deadline_at` = timestamp exactamente igual al momento actual del servidor. |
| **Pasos** | 1. Configurar fecha límite exactamente igual al tiempo del servidor. 2. Guardar la tarea. 3. Verificar el estado resultante. |
| **Resultado Esperado** | ✅ **La tarea NO se marca como `incompleta`** — la condición del sistema es estrictamente `$task->deadline_at < now()`. Si son iguales, la condición es falsa → el estado permanece `asignado`. |

---

## CP-ADM-064

| Campo | Detalle |
|---|---|
| **Módulo** | Integridad del Workflow |
| **Título** | Crear tarea con prioridad "alta" sin usuario trabajador seleccionado |
| **Objetivo** | Validar que no existan tareas sin responsable asignado. |
| **Precondición** | Modal de creación de tarea disponible en `/admin/tasks`. |
| **Entrada** | Formulario con campo `assigned_to` vacío y `priority = alta`. |
| **Pasos** | 1. Completar el formulario de creación dejando el campo "Trabajador" en blanco. 2. Presionar Guardar. |
| **Resultado Esperado** | ✅ **Error de validación**: `"Debes asignar un trabajador a la tarea."` — regla `required \| exists:users,id` sobre el campo `assigned_to`. |

---

## CP-ADM-065

| Campo | Detalle |
|---|---|
| **Módulo** | Rendimiento |
| **Título** | 5,000 tareas en listado visualizadas |
| **Objetivo** | Validar eficiencia de paginación con volúmenes medios de registros. |
| **Precondición** | BD poblada con 5,000 registros en la tabla `tasks`. |
| **Entrada** | Navegación a `/admin/tasks`. |
| **Pasos** | 1. Entrar al listado de tareas. 2. Navegar entre páginas. |
| **Resultado Esperado** | ✅ **Paginación correcta** — `->paginate(10)->withQueryString()` carga solo 10 registros por página. `LengthAwarePaginator` no carga la colección entera en memoria. Sin timeout. |

---

## CP-ADM-066

| Campo | Detalle |
|---|---|
| **Módulo** | Rendimiento |
| **Título** | Exportar PDF con 1,000 registros del mes |
| **Objetivo** | Evaluar la capacidad de DomPDF para procesar reportes extensos sin agotar el `memory_limit` de PHP. |
| **Precondición** | 1,000+ tareas creadas (en cualquier estado) en el mes actual. |
| **Entrada** | Clic en el botón "Exportar PDF" con el mes/año correspondiente. |
| **Pasos** | 1. Seleccionar mes con 1,000+ tareas creadas. 2. Ejecutar la generación del reporte mensual. |
| **Resultado Esperado** | ⚠️ **Posible timeout o alto consumo de memoria** — `exportPDF()` carga **TODAS las tareas del mes** con `->get()` sin paginación para calcular estadísticas generales; luego filtra las finalizadas en PHP. Con 1,000 registros DomPDF puede alcanzar el límite de memoria o tardar significativamente. |

---

## CP-ADM-067

| Campo | Detalle |
|---|---|
| **Módulo** | Rendimiento |
| **Título** | Subir límite de imágenes (10) de 2MB máximo a Incidencias simultáneamente |
| **Objetivo** | Verificar el procesamiento de archivos pesados en un solo POST. |
| **Precondición** | 10 archivos de imagen de exactamente 2MB cada uno listos para subir. |
| **Entrada** | Selección múltiple de 10 archivos en el modal de incidencias. |
| **Pasos** | 1. Adjuntar los 10 archivos. 2. Guardar incidencia. |
| **Resultado Esperado** | ✅ **El servidor acepta la carga múltiple** — el límite del sistema es 10 imágenes de máximo 2MB c/u (`$maxSize = 2 * 1024 * 1024`). Requiere `post_max_size ≥ 20MB` y `upload_max_filesize ≥ 2MB` en PHP. |

---

## CP-ADM-068

| Campo | Detalle |
|---|---|
| **Módulo** | Rendimiento |
| **Título** | Búsqueda SQL con un millón de incidencias |
| **Objetivo** | Observar comportamiento de la BD bajo estrés de búsqueda textual sin índices especializados. |
| **Precondición** | Tabla `incidents` con un millón de filas (entorno de pruebas/staging). |
| **Entrada** | Search query: `falla eléctrica` en `/admin/incidents?search=falla+eléctrica`. |
| **Pasos** | 1. Ejecutar búsqueda en el listado de incidencias. |
| **Resultado Esperado** | ⚠️ **Consulta lenta** — el sistema usa `OR LIKE '%...%'` sobre `title`, `description`, `location`, `name` y `email`. Los `LIKE` con comodín inicial no aprovechan índices B-Tree estándar. Alta probabilidad de timeout con 1M de registros. |

---

## CP-ADM-069

| Campo | Detalle |
|---|---|
| **Módulo** | Sistema de Archivos y Storage |
| **Título** | Eliminar tarea con evidencia cuyo archivo ya no existe en disco |
| **Objetivo** | Asegurar que el sistema no se rompa al eliminar un registro cuyas imágenes físicas ya no están en el servidor. |
| **Precondición** | Tarea en BD con rutas en `initial_evidence_images`, `final_evidence_images` o `reference_images` cuyos archivos fueron eliminados manualmente de `storage/app/public/`. |
| **Entrada** | Acción DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Eliminar manualmente el archivo físico del servidor. 2. Desde el panel, eliminar la tarea. |
| **Resultado Esperado** | ⚠️ **La tarea se elimina de la BD sin error**, pero **los archivos físicos NO son verificados ni borrados** — `destroy()` solo ejecuta `$task->delete()` sin ninguna lógica de limpieza de filesystem. No hay `Storage::delete()` ni `file_exists()`. |

---

## CP-ADM-070

| Campo | Detalle |
|---|---|
| **Módulo** | Sistema de Archivos y Storage |
| **Título** | Disco de Storage lleno o sin permisos de escritura |
| **Objetivo** | Validar comportamiento cuando el sistema no puede escribir archivos. |
| **Precondición** | Permisos restringidos (`chmod 444`) en `storage/app/public/` o simulación de disco lleno. |
| **Entrada** | Subida de imagen válida desde formulario de tarea o incidencia. |
| **Pasos** | 1. Restringir permisos en `storage/app/public`. 2. Intentar subir evidencia desde el sistema. |
| **Resultado Esperado** | ⚠️ **Mensaje de error controlado al usuario** — el sistema usa `move_uploaded_file()` dentro de bloques `try/catch(\Exception $e)`. Si el movimiento falla, se captura la excepción y se devuelve el mensaje `"Error al subir el archivo {nombre}"` como error de validación al formulario. Sin excepción fatal. |

---

## CP-ADM-071

| Campo | Detalle |
|---|---|
| **Módulo** | Sistema de Archivos y Storage |
| **Título** | Subida de archivo con extensión válida pero MIME real distinto |
| **Objetivo** | Detectar vulnerabilidad si solo se valida extensión sin comprobar MIME real. |
| **Precondición** | Archivo ejecutable renombrado a `.png`. |
| **Entrada** | `payload.png` con MIME real `application/x-msdownload`. |
| **Pasos** | 1. Renombrar un ejecutable `.exe` a `.png`. 2. Intentar subirlo en el formulario de evidencia. |
| **Resultado Esperado** | ⚠️ **Comportamiento mixto según el formulario:** **Incidencias**: solo valida extensión con `pathinfo()` — el archivo **sería aceptado** (vulnerabilidad). **Tareas**: la validación de Laravel con `mimes:jpeg,png,jpg,gif` inspecciona el contenido real — el archivo **sería rechazado**. |

---

## CP-ADM-072

| Campo | Detalle |
|---|---|
| **Módulo** | Sistema de Archivos y Storage |
| **Título** | Eliminar tarea con múltiples evidencias iniciales y finales |
| **Objetivo** | Verificar limpieza del sistema de archivos al eliminar tareas con múltiples evidencias. |
| **Precondición** | Tarea con imágenes en `initial_evidence_images`, `final_evidence_images` y `reference_images` (arreglos JSON). |
| **Entrada** | Acción DELETE sobre la tarea desde `/admin/tasks`. |
| **Pasos** | 1. Eliminar tarea desde `/admin/tasks`. 2. Revisar físicamente `storage/app/public/tasks-evidence/` y `storage/app/public/tasks-reference/`. |
| **Resultado Esperado** | ⚠️ **Los archivos físicos quedan huérfanos en disco** — `destroy()` solo ejecuta `$task->delete()` sin iterar sobre columnas de imágenes ni llamar a `Storage::delete()`. El registro de BD se elimina pero los archivos físicos permanecen. |

---

## CP-ADM-073

| Campo | Detalle |
|---|---|
| **Módulo** | Notificaciones Avanzadas |
| **Título** | 200 notificaciones sin leer |
| **Objetivo** | Verificar que la acumulación masiva de notificaciones no afecte el rendimiento del dropdown. |
| **Precondición** | Administrador con 200+ registros en tabla `notifications`. |
| **Entrada** | Clic en el icono de campana en la barra superior. |
| **Pasos** | 1. Generar 200 notificaciones vía Seeder. 2. Recargar el panel. 3. Abrir el menú desplegable. |
| **Resultado Esperado** | ✅ **Sin ralentización perceptible** — `NotificationController@index` aplica `->limit(10)` antes del `->get()`. Solo se recuperan las 10 más recientes. El conteo de no leídas usa `->count()`. |

---

## CP-ADM-074

| Campo | Detalle |
|---|---|
| **Módulo** | Notificaciones Avanzadas |
| **Título** | Intentar marcar notificación de otro usuario interceptando el ID |
| **Objetivo** | Validar que el backend comprueba la pertenencia de la notificación antes de actualizar su estado. |
| **Precondición** | Notificación perteneciente a otro usuario existente en BD. |
| **Entrada** | ID de notificación ajena enviado manualmente vía petición POST interceptada. |
| **Pasos** | 1. Autenticarse como Admin A. 2. Interceptar petición POST de marcar-como-leído. 3. Modificar el ID por uno de otro usuario. 4. Enviar la petición. |
| **Resultado Esperado** | ✅ **Respuesta 404** — el controlador usa `Notification::where('user_id', Auth::id())->findOrFail($id)`. Si el ID no pertenece al usuario autenticado, `findOrFail` lanza excepción 404. |

---

## CP-ADM-075

| Campo | Detalle |
|---|---|
| **Módulo** | Notificaciones Avanzadas |
| **Título** | Clic en notificación vinculada a recurso eliminado |
| **Objetivo** | Validar comportamiento ante referencias huérfanas en notificaciones. |
| **Precondición** | Notificación con `link` apuntando a una Tarea o Incidencia eliminada de la BD. |
| **Entrada** | Clic en enlace de notificación antigua. |
| **Pasos** | 1. Eliminar la tarea/incidencia referenciada. 2. Hacer clic en la notificación antigua. |
| **Resultado Esperado** | ⚠️ **Página de error 404 estándar de Laravel** — los controladores `show` usan `findOrFail()`. No hay manejo personalizado con mensaje amigable. |

---

## CP-ADM-076

| Campo | Detalle |
|---|---|
| **Módulo** | Sesión y Autenticación Extendida |
| **Título** | Expiración de sesión tras inactividad |
| **Objetivo** | Verificar invalidez de sesión al superar `SESSION_LIFETIME`. |
| **Precondición** | `.env` con `SESSION_DRIVER=database` y `SESSION_LIFETIME=120`. Para prueba reducir a valor bajo (ej. `SESSION_LIFETIME=1`). |
| **Entrada** | Interacción posterior a la expiración. |
| **Pasos** | 1. Iniciar sesión. 2. Esperar a que expire el tiempo configurado. 3. Intentar navegar a `/admin/dashboard`. |
| **Resultado Esperado** | ✅ **Redirección automática a `/login`** — el middleware `auth` detecta sesión inválida. El driver `database` almacena la sesión en tabla `sessions`; al expirar el registro es eliminado por el garbage collector de Laravel. |

---

## CP-ADM-077

| Campo | Detalle |
|---|---|
| **Módulo** | Sesión y Autenticación Extendida |
| **Título** | Rotación de contraseña con sesiones múltiples abiertas |
| **Objetivo** | Verificar si las sesiones previas son invalidadas tras cambio de password. |
| **Precondición** | Dos pestañas activas con sesión autenticada. |
| **Entrada** | Nueva contraseña válida enviada a `PUT /password`. |
| **Pasos** | 1. Cambiar contraseña en Pestaña A. 2. Intentar navegar desde Pestaña B sin recargar. |
| **Resultado Esperado** | ⚠️ **La sesión previa en Pestaña B NO es invalidada** — `PasswordController::update()` solo actualiza el hash de la contraseña. No hay `Auth::logoutOtherDevices()`. Además, `AuthenticateSession` middleware está **comentado** en `Kernel.php`. La Pestaña B permanece activa hasta que su sesión expire. |

---

## CP-ADM-078

| Campo | Detalle |
|---|---|
| **Módulo** | Sesión y Autenticación Extendida |
| **Título** | Forzar acceso reusando cookies antiguas luego de Logout intencional |
| **Objetivo** | Validar que "Cerrar Sesión" destruya completamente el contexto de sesión en backend. |
| **Precondición** | Administrador autenticado. Cookie `laravel_session` previamente copiada. |
| **Entrada** | Cookie de sesión antigua inyectada manualmente tras logout. |
| **Pasos** | 1. Copiar el valor de la cookie activa. 2. Ejecutar "Cerrar sesión". 3. Reinyectar cookie antigua vía DevTools. 4. Intentar acceder a `/admin/dashboard`. |
| **Resultado Esperado** | ✅ **Acceso denegado — redirección a `/login`** — `destroy()` ejecuta `Auth::guard('web')->logout()` + `session()->invalidate()` + `regenerateToken()`. La fila de sesión en la tabla `sessions` es eliminada. La cookie antigua apunta a un ID inexistente. |

---

## CP-ADM-079

| Campo | Detalle |
|---|---|
| **Módulo** | Validaciones de Entrada Extrema |
| **Título** | Título de tarea con exactamente 255 caracteres |
| **Objetivo** | Validar almacenamiento correcto en el límite máximo de `VARCHAR(255)`. |
| **Precondición** | Formulario de creación de tarea disponible en `/admin/tasks`. |
| **Entrada** | String alfanumérico de exactamente 255 caracteres. |
| **Pasos** | 1. Ingresar título de 255 caracteres. 2. Completar campos requeridos (`assigned_to`, `deadline_at`, `location`, `priority`, `reference_images`). 3. Enviar formulario. |
| **Resultado Esperado** | ✅ **Registro almacenado sin truncamiento ni error** — regla `'title' => ['required', 'string', 'max:255']` permite exactamente 255 caracteres. |

---

## CP-ADM-080

| Campo | Detalle |
|---|---|
| **Módulo** | Validaciones de Entrada Extrema |
| **Título** | Título de tarea con 300 caracteres |
| **Objetivo** | Validar bloqueo de inserciones que excedan el límite definido. |
| **Precondición** | Formulario activo de creación o edición de tarea. |
| **Entrada** | String de 300 caracteres en el campo `title`. |
| **Pasos** | 1. Pegar texto de 300 caracteres en el campo título. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Error de validación** — regla `max:255` rechaza el input. Redirección de vuelta al formulario con mensaje de error. No se inserta en la BD. |

---

## CP-ADM-081

| Campo | Detalle |
|---|---|
| **Módulo** | Validaciones de Entrada Extrema |
| **Título** | Prueba de Inyección XSS en campo description |
| **Objetivo** | Verificar escape de contenido HTML/JS malicioso en renderizado. |
| **Precondición** | Sesión activa de Administrador con permiso de crear tareas/incidencias. |
| **Entrada** | `<script>alert('XSS')</script>` en campo `description`. |
| **Pasos** | 1. Insertar payload XSS en el campo description. 2. Guardar. 3. Visualizar la tarea creada. |
| **Resultado Esperado** | ✅ **Renderizado como texto plano escapado** — las vistas Blade usan `{{ $variable }}` con `htmlspecialchars()`. El script no se ejecuta. Se muestra literalmente: `&lt;script&gt;alert('XSS')&lt;/script&gt;`. |

---

## CP-ADM-082

| Campo | Detalle |
|---|---|
| **Módulo** | Validaciones de Entrada Extrema |
| **Título** | Envío de JSON malformado en endpoint de creación |
| **Objetivo** | Validar manejo robusto de payload corrupto. |
| **Precondición** | Cliente REST (cURL/Postman) con cookie de sesión válida y token CSRF. |
| **Entrada** | `{ "title": "tarea", "pri...` (JSON incompleto) con `Content-Type: application/json`. |
| **Pasos** | 1. Interceptar request. 2. Corromper el body. 3. Enviar request. |
| **Resultado Esperado** | ⚠️ **419 (CSRF Token Mismatch)** si no se incluye el token, o **422** si la validación falla al llegar al controlador. El sistema es web-based (no API REST pura) — requires cookie de sesión + `_token` CSRF para pasar `VerifyCsrfToken`. |

---

## CP-ADM-083

| Campo | Detalle |
|---|---|
| **Módulo** | Validaciones de Entrada Extrema |
| **Título** | Inyección de campos extra (Mass Assignment Attack) |
| **Objetivo** | Verificar protección contra atributos no autorizados en formularios. |
| **Precondición** | Sesión activa de Administrador con inspector del navegador. |
| **Entrada** | Campo inyectado: `<input name="role" value="administrador">` en el DOM. |
| **Pasos** | 1. Añadir input oculto al DOM de un formulario de tarea o usuario. 2. Enviar formulario. |
| **Resultado Esperado** | ✅ **Campo ignorado por `$fillable`** — el modelo `Task` solo permite asignación masiva de campos declarados en `$fillable`. Un campo `role` no está en la lista → Eloquent lo ignora silenciosamente. |

---

## CP-ADM-084

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Creación con caracteres Unicode inusuales |
| **Objetivo** | Verificar compatibilidad con codificación UTF-8/utf8mb4. |
| **Precondición** | Formulario de creación de tarea disponible. BD configurada con charset `utf8mb4`. |
| **Entrada** | `Привет, 🌍! مرحبا` (combinación de cirílico, emoji y árabe). |
| **Pasos** | 1. Ingresar cadena Unicode en campos `title` y `description`. 2. Enviar formulario. 3. Verificar visualización en listado y detalle. |
| **Resultado Esperado** | ✅ **Persistencia íntegra sin truncamiento** — Laravel usa PDO con UTF-8. Si la BD está configurada con `utf8mb4_unicode_ci`, los emojis y caracteres multibyte se almacenan correctamente. |

---

## CP-ADM-085

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Manejo de espacios en blanco excesivos |
| **Objetivo** | Validar sanitización automática mediante middleware de trimming. |
| **Precondición** | Formulario de tarea o usuario activo. |
| **Entrada** | `"   Nuevo Usuario   "` (con espacios al inicio y final). |
| **Pasos** | 1. Ingresar texto con padding de espacios. 2. Guardar. 3. Verificar valor en BD. |
| **Resultado Esperado** | ✅ **Cadena almacenada sin espacios al inicio o final** — `TrimStrings` middleware está registrado globalmente en `Kernel.php` (`$middleware` global, línea 20). Se aplica automáticamente a todos los requests. |

---

## CP-ADM-086

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Manipulación extrema del paginador |
| **Objetivo** | Validar robustez frente a valores negativos o excesivos en query string. |
| **Precondición** | Listado `/admin/tasks` con paginación activa. |
| **Entrada** | `?page=-100` y `?page=9999`. |
| **Pasos** | 1. Alterar el parámetro `page` en la URL. 2. Cargar la vista. |
| **Resultado Esperado** | ⚠️ **Comportamiento diferenciado:** `?page=-100` → Laravel normaliza a **página 1** automáticamente. `?page=9999` → devuelve **colección vacía** sin error 404. La paginación muestra "0 resultados". No hay excepción ni redirección. |

---

## CP-ADM-087

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Búsqueda con caracteres especiales tipo SQL wildcard |
| **Objetivo** | Prevenir explotación de `LIKE` y errores SQL por comodines crudos. |
| **Precondición** | Buscador activo en `/admin/tasks` o `/admin/incidents`. |
| **Entrada** | `%`, `\`, `_`, `'` en el campo de búsqueda. |
| **Pasos** | 1. Ingresar caracteres comodín. 2. Ejecutar búsqueda. |
| **Resultado Esperado** | ⚠️ **Sin inyección SQL** (PDO con prepared statements), pero `%` y `_` **sí funcionan como wildcards LIKE**: buscar `%` retorna todos los registros. No es una inyección SQL pero genera resultados inesperados. Sin excepción ni error en la aplicación. |

---

## CP-ADM-088

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Envío de edición sin cambios |
| **Objetivo** | Validar si se ejecutan UPDATE innecesarios cuando no hay modificaciones. |
| **Precondición** | Modal de edición de tarea abierto. |
| **Entrada** | Ningún cambio realizado en el formulario. |
| **Pasos** | 1. Abrir recurso de edición. 2. Presionar "Guardar" sin editar campos. |
| **Resultado Esperado** | ⚠️ **`updated_at` SÍ se actualiza** — el controlador llama `$task->update($updateData)` directamente sin verificar `isDirty()`. Laravel ejecuta el `UPDATE SQL` siempre que se llame a `update()`, independientemente de si los valores cambiaron. |

---

## CP-ADM-089

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Interrupción de red en proceso de subida |
| **Objetivo** | Validar rollback seguro ante desconexión durante operación crítica. |
| **Precondición** | Proceso de subida de archivos en ejecución desde formulario de tarea. |
| **Entrada** | Corte manual de conexión Wi-Fi durante la subida. |
| **Pasos** | 1. Iniciar subida pesada de imágenes. 2. Cortar conexión a mitad de la operación. 3. Observar comportamiento. |
| **Resultado Esperado** | ✅ **Sin registros parciales corruptos en BD** — el servidor PHP no recibe el request completo, la solicitud nunca llega al controlador. Si el corte ocurre **después** del procesamiento pero antes del guardado en BD, pueden quedar archivos físicos huérfanos en disco. |

---

## CP-ADM-090

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Eliminación física (Hard Delete) de tarea finalizada |
| **Objetivo** | Verificar comportamiento del lifecycle en ausencia de SoftDeletes. |
| **Precondición** | Tarea en estado `finalizada` existente en la BD. |
| **Entrada** | Método HTTP DELETE desde `/admin/tasks/{id}`. |
| **Pasos** | 1. Localizar tarea finalizada en `/admin/tasks`. 2. Confirmar eliminación. 3. Verificar que el registro no existe. |
| **Resultado Esperado** | ✅ **Eliminación física (Hard Delete) inmediata** — el modelo `Task` no usa `SoftDeletes`. `destroy()` ejecuta `$task->delete()` → `DELETE FROM tasks WHERE id = ?`. El registro es irrecuperable. Los archivos físicos permanecen (deficiencia documentada en CP-ADM-072). |

---

## CP-ADM-091

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Eliminación en cascada al borrar Instructor |
| **Objetivo** | Validar la política de FK definida en el esquema al eliminar un Instructor con incidencias. |
| **Precondición** | Instructor con al menos una incidencia reportada en la tabla `incidents`. |
| **Entrada** | Petición DELETE sobre el usuario Instructor desde `/admin/users`. |
| **Pasos** | 1. Identificar instructor con incidencias en BD. 2. Eliminarlo desde `/admin/users/{id}`. 3. Verificar estado de las incidencias. |
| **Resultado Esperado** | ✅ **Las incidencias son eliminadas en cascada** — la migración define `foreignId('reported_by')->constrained('users')->onDelete('cascade')`. MySQL ejecuta la cascada automáticamente. `UserController::destroy()` elimina primero la foto de perfil y luego el usuario. |

---

## CP-ADM-092

| Campo | Detalle |
|---|---|
| **Módulo** | Pruebas Críticas Adicionales CRUD |
| **Título** | Auto-eliminación del usuario autenticado |
| **Objetivo** | Validar borrado de cuenta activa sin errores de sesión. |
| **Precondición** | Sesión activa del Administrador. |
| **Entrada** | DELETE sobre su propio perfil desde `/profile`. |
| **Pasos** | 1. Ir a perfil de cuenta autenticada. 2. Ejecutar eliminación de cuenta (requiere confirmación de contraseña actual). |
| **Resultado Esperado** | ✅ **Logout automático y redirección a `/`** — `ProfileController::destroy()` ejecuta: `Auth::logout()` → `$user->delete()` → `session()->invalidate()` → `session()->regenerateToken()` → `redirect('/')`. |

---

## CP-ADM-093

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Cierre del Lightbox de imagen con tecla ESC |
| **Objetivo** | Validar accesibilidad mediante atajo de teclado estándar. |
| **Precondición** | Lightbox (`#imageModal`) activo con imagen visible. |
| **Entrada** | Tecla `Escape`. |
| **Pasos** | 1. Abrir una imagen en el visor lightbox. 2. Presionar `ESC`. |
| **Resultado Esperado** | ✅ **El lightbox se cierra** — `image-viewer.blade.php` registra `document.addEventListener('keydown', ...)` que detecta `e.key === 'Escape'` y llama `closeImageModal()`. **Solo el lightbox de imágenes tiene ESC implementado** — los modales CRUD no tienen este listener. |

---

## CP-ADM-094

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Cierre del Lightbox al hacer clic en backdrop |
| **Objetivo** | Validar comportamiento UX de cancelación por clic externo. |
| **Precondición** | Lightbox (`#imageModal`) activo sobre overlay oscuro. |
| **Entrada** | Clic en el área oscura externa (fuera de la imagen). |
| **Pasos** | 1. Abrir imagen en lightbox. 2. Clicar fuera de la imagen (en el overlay negro). |
| **Resultado Esperado** | ✅ **Lightbox se cierra** — el div `#imageModal` tiene `onclick="closeImageModal()"`. El div interno usa `onclick="event.stopPropagation()"` para evitar que la imagen misma cierre el modal. **Solo el lightbox implementa esta funcionalidad**, no los modales CRUD. |

---

## CP-ADM-095

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Reapertura automática del modal de edición tras error de validación |
| **Objetivo** | Preservar contexto del usuario ante validación fallida. |
| **Precondición** | Modal de **edición de tarea** abierto con campos incompletos. |
| **Entrada** | Formulario con campos inválidos (ej. sin `assigned_to`). |
| **Pasos** | 1. Abrir modal de edición de tarea. 2. Enviar formulario con campos inválidos. 3. Esperar respuesta del servidor. |
| **Resultado Esperado** | ✅ **Modal de edición reaparece mostrando errores** — el blade evalúa `@if ($errors->any() && old('_method') === 'PUT')` y ejecuta `openModal('editTaskModal')` en `DOMContentLoaded`. **Solo aplica al modal de edición**, no al de creación. Las validaciones en Laravel web devuelven redirect con `$errors` en sesión (no 422 JSON). |

---

## CP-ADM-096

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Reset de formulario al cerrar modal |
| **Objetivo** | Prevenir contaminación de estado previo en nuevas aperturas. |
| **Precondición** | Modal de edición (`#editTaskModal`) con datos escritos. |
| **Entrada** | Acción de cancelar/cerrar modal. |
| **Pasos** | 1. Abrir modal de edición y escribir datos. 2. Cancelar/cerrar el modal. 3. Reabrir el modal con otro registro. |
| **Resultado Esperado** | ⚠️ **El formulario NO hace reset automático al cerrar** — `closeModal()` solo agrega la clase `hidden`. Los campos retienen los valores anteriores hasta que `startEditSingleTask()` los sobrescribe al abrir el siguiente registro. Si hay un fallo de JS, los campos previos pueden persistir. |

---

## CP-ADM-097

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Precarga dinámica en modal de edición |
| **Objetivo** | Validar la transferencia de datos desde BD al modal de edición. |
| **Precondición** | Vista `/admin/tasks/{id}` renderizada. El botón "Editar Tarea" solo está habilitado si la tarea **no tiene evidencias** registradas. |
| **Entrada** | Clic en botón "Editar Tarea". |
| **Pasos** | 1. Abrir tarea sin evidencias. 2. Clicar "Editar Tarea". 3. Verificar que todos los campos del modal estén prellenados. |
| **Resultado Esperado** | ✅ **Inputs cargados con valores exactos** — `startEditSingleTask()` utiliza `@json($task)` embebido en JS (no atributos `data-*`). Asigna: `title`, `description`, `deadline_at` (parseado a ISO date), `location`, `priority`, `status`, `assigned_to`. Imágenes de referencia via evento `loadEditTaskImages`. |

---

## CP-ADM-098

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Visualización de imagen en Lightbox |
| **Objetivo** | Validar apertura del visor en alta resolución al hacer clic en miniatura. |
| **Precondición** | Vista `/admin/tasks/{id}` con imagen adjunta (referencia, inicial o final). |
| **Entrada** | Clic en miniatura de imagen. |
| **Pasos** | 1. Ir a detalle de tarea con imágenes. 2. Clicar en cualquier miniatura. |
| **Resultado Esperado** | ✅ **Modal `#imageModal` visible con `src` dinámico correcto** — `openImageModal(url)` establece `img.src = imageSrc`, agrega clase `flex`, elimina `hidden`. La imagen carga con animación fade-in (`scale-95 opacity-0` → `scale-100 opacity-100`). |

---

## CP-ADM-099

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Apertura de visor con URL rota / imagen 404 |
| **Objetivo** | Validar fallback visual ante recursos faltantes en storage. |
| **Precondición** | Registro con path en BD pero archivo físicamente eliminado de `storage/`. |
| **Entrada** | Clic en miniatura con URL inexistente. |
| **Pasos** | 1. Eliminar archivo físico de `storage/app/public/`. 2. Abrir la tarea en el panel. 3. Clicar la miniatura "rota". |
| **Resultado Esperado** | ⚠️ **El lightbox se abre pero muestra imagen rota** — `openImageModal()` asigna el `src` sin verificar si existe. El `<img>` **no tiene `onerror` handler ni placeholder**. Se muestra el ícono de imagen rota nativo del navegador. La UI no colapsa. |

---

## CP-ADM-100

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Cierre del visor de imágenes (Lightbox) |
| **Objetivo** | Verificar que el modal no quede bloqueado ni interfiera con la navegación posterior. |
| **Precondición** | Modal `#imageModal` fullscreen activo. |
| **Entrada** | Clic en botón "X", tecla `ESC`, o clic en backdrop. |
| **Pasos** | 1. Abrir imagen en lightbox. 2. Activar cualquier control de cierre. |
| **Resultado Esperado** | ✅ **Modal se cierra correctamente** — `closeImageModal()` aplica animación de salida (scale-95, opacity-0) y luego, tras 300ms, agrega `hidden`, remueve `flex` y restaura `overflow: auto` en body. La navegación posterior queda sin interferencia. |

---

## CP-ADM-101

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Responsividad del visor en dispositivos móviles |
| **Objetivo** | Validar adaptación del Lightbox a viewports reducidos. |
| **Precondición** | Simulación móvil (375px / 414px) en DevTools del navegador. |
| **Entrada** | Activación del lightbox en entorno responsive. |
| **Pasos** | 1. Abrir imagen. 2. Ajustar viewport a iPhone SE (375px). |
| **Resultado Esperado** | ✅ **Imagen se adapta al viewport** — el `<img>` usa clases `max-w-full max-h-[75vh]` con `object-contain`. Sin overflow horizontal. Nota: la clase implementada es `max-h-[75vh]` (no `max-h-[90vh]`). |

---

## CP-ADM-102

| Campo | Detalle |
|---|---|
| **Módulo** | Interacción UI y Modales |
| **Título** | Accesibilidad ARIA en modales |
| **Objetivo** | Validar cumplimiento de estándares W3C/WCAG para accesibilidad. |
| **Precondición** | Modal `#imageModal` visible e inspeccionado en el DOM. |
| **Entrada** | Auditoría de accesibilidad en DevTools (Lighthouse / axe). |
| **Pasos** | 1. Abrir lightbox. 2. Ejecutar auditoría de accesibilidad. 3. Inspeccionar atributos ARIA. |
| **Resultado Esperado** | ⚠️ **Ausencia de atributos ARIA** — el div `#imageModal` **no tiene** `role="dialog"`, `aria-modal="true"`, `aria-label` ni focus trapping. La imagen tiene `alt="Imagen ampliada"` (correcto). La auditoría reportará errores de a11y en categorías ARIA roles y keyboard focus management. |

---

## Resumen General de Correcciones

| CP | Estado | Descripción de la corrección |
|---|---|---|
| CP-ADM-061 | ✅ Correcto | Sin cambios |
| CP-ADM-062 | ⚠️ Corregido | Bloqueo por **ausencia de `update()`**, no por validación de estado |
| CP-ADM-063 | ✅ Correcto | Sin cambios |
| CP-ADM-064 | ⚠️ Corregido | Campo correcto es `assigned_to`, no `worker_id` |
| CP-ADM-065 | ✅ Correcto | Sin cambios |
| CP-ADM-066 | ⚠️ Corregido | PDF exporta **todas las tareas del mes**, no solo finalizadas |
| CP-ADM-067 | ✅ Correcto | Sin cambios |
| CP-ADM-068 | ✅ Correcto | Sin cambios |
| CP-ADM-069 | ⚠️ Corregido | Sistema **no verifica archivos** — elimina solo el registro de BD |
| CP-ADM-070 | ⚠️ Corregido | Usa `move_uploaded_file()` nativo, no `Storage::` |
| CP-ADM-071 | ⚠️ Corregido | Incidencias: vulnerable. Tareas: segura con `mimes:` |
| CP-ADM-072 | ⚠️ Corregido | `destroy()` no limpia archivos físicos — huérfanos garantizados |
| CP-ADM-073 | ✅ Correcto | Límite real: `limit(10)` |
| CP-ADM-074 | ✅ Correcto | Sin cambios |
| CP-ADM-075 | ⚠️ Corregido | 404 estándar, sin mensaje amigable personalizado |
| CP-ADM-076 | ✅ Correcto | Sin cambios |
| CP-ADM-077 | ⚠️ Corregido | `PasswordController` no invalida otras sesiones — `AuthenticateSession` comentado |
| CP-ADM-078 | ✅ Correcto | Sin cambios |
| CP-ADM-079 | ✅ Correcto | Sin cambios |
| CP-ADM-080 | ✅ Correcto | Sin cambios |
| CP-ADM-081 | ✅ Correcto | Sin cambios |
| CP-ADM-082 | ⚠️ Corregido | Requiere CSRF token — sistema web, no API REST |
| CP-ADM-083 | ✅ Correcto | Campo ejemplo más realista: `role` |
| CP-ADM-084 | ✅ Correcto | Sin cambios |
| CP-ADM-085 | ✅ Correcto | `TrimStrings` confirmado en `Kernel.php` |
| CP-ADM-086 | ⚠️ Corregido | `page=9999` → vacío (no 404). `page=-100` → página 1 |
| CP-ADM-087 | ⚠️ Corregido | `%` y `_` interpretados como wildcards LIKE (no inyección SQL) |
| CP-ADM-088 | ⚠️ Corregido | Siempre actualiza `updated_at` — no hay `isDirty()` |
| CP-ADM-089 | ✅ Correcto | Matiz de huérfanos posibles post-procesamiento |
| CP-ADM-090 | ✅ Correcto | Sin cambios |
| CP-ADM-091 | ⚠️ Corregido | `onDelete('cascade')` — incidencias borradas automáticamente |
| CP-ADM-092 | ✅ Correcto | Sin cambios |
| CP-ADM-093 | ⚠️ Corregido | ESC solo en lightbox, no en modales CRUD |
| CP-ADM-094 | ⚠️ Corregido | Backdrop solo en lightbox, con `stopPropagation()` en imagen |
| CP-ADM-095 | ⚠️ Corregido | Solo se reabre modal de edición (`old('_method') === 'PUT'`) |
| CP-ADM-096 | ⚠️ Corregido | No hay `form.reset()` — datos sobrescritos al abrir siguiente |
| CP-ADM-097 | ⚠️ Corregido | Datos vía `@json($task)` en JS, no `data-*`. Botón solo sin evidencias |
| CP-ADM-098 | ✅ Correcto | Sin cambios |
| CP-ADM-099 | ⚠️ Corregido | No hay `onerror` — imagen rota nativa del navegador |
| CP-ADM-100 | ⚠️ Corregido | Cierre con animación 300ms antes de `hidden` |
| CP-ADM-101 | ⚠️ Corregido | Clase real: `max-h-[75vh]` (no `max-h-[90vh]`) |
| CP-ADM-102 | ⚠️ Corregido | No hay `role="dialog"` ni `aria-modal` — brecha de accesibilidad |
