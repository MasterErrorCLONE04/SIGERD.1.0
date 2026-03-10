# Historias de Usuario — Rol: Trabajador
## Sistema: SIGERD v1.0 — Sistema de Gestión de Reportes y Distribución
### Centro de Formación Agroindustrial

---

## Convenciones del Documento

| Campo | Descripción |
|---|---|
| **Identificador (ID)** | Código único en formato `HU-TRB-XXX` |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Acción que el trabajador necesita o puede realizar |
| **Razón / Resultado** | Finalidad o beneficio esperado al ejecutar la acción |
| **Número (#) de Escenario** | Número secuencial del escenario de aceptación |
| **Criterio de Aceptación (Título)** | Nombre corto del escenario |
| **Contexto** | Condición previa o situación que desencadena el escenario |
| **Evento** | Acción que ejecuta el usuario |
| **Resultado / Comportamiento esperado** | Respuesta del sistema ante el evento |

---

## MÓDULO 1: AUTENTICACIÓN Y ACCESO AL SISTEMA

---

### HU-TRB-001 — Inicio de Sesión en el Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-001 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito iniciar sesión en el sistema con mis credenciales |
| **Razón / Resultado** | Con la finalidad de acceder a mi panel de trabajo y gestionar las tareas de mantenimiento que me han sido asignadas |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Inicio de sesión exitoso | En caso de que el trabajador ingrese email y contraseña válidos | Cuando el trabajador completa el formulario de login y hace clic en "Iniciar sesión" | El sistema autentica al usuario y lo redirige automáticamente al panel del trabajador (`/worker/dashboard`) |
| 2 | Credenciales incorrectas | En caso de que el trabajador ingrese email o contraseña incorrectos | Cuando el trabajador ingresa datos inválidos y hace clic en "Iniciar sesión" | El sistema muestra un mensaje de error y no permite el acceso |
| 3 | Redirección automática según rol | N/A | Cuando el trabajador accede a la ruta `/dashboard` | El sistema detecta el rol `trabajador` y redirige automáticamente a `/worker/dashboard` |
| 4 | Acceso denegado a rutas del administrador | En caso de que el trabajador intente acceder a rutas protegidas de admin o instructor | Cuando el trabajador navega a `/admin/dashboard` o `/instructor/dashboard` | El sistema bloquea el acceso y redirige al dashboard del trabajador |

---

### HU-TRB-002 — Cierre de Sesión del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-002 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito cerrar la sesión activa en el sistema |
| **Razón / Resultado** | Con la finalidad de proteger mi cuenta cuando termino de trabajar |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cierre de sesión exitoso | En caso de que el trabajador se encuentre autenticado en el sistema | Cuando el trabajador hace clic en la opción "Cerrar Sesión" del menú lateral o del menú desplegable de usuario | El sistema invalida la sesión activa, destruye el token de autenticación y redirige al trabajador a la página de inicio de sesión (`/login`) |
| 2 | Acceso bloqueado tras cerrar sesión | En caso de que el trabajador intente navegar a una página protegida después de haber cerrado sesión | Cuando el trabajador intenta acceder a `/worker/dashboard` u otra ruta protegida sin sesión activa | El sistema detecta que no hay sesión válida y redirige automáticamente a la página de login |
| 3 | No se puede retroceder al panel tras el logout | En caso de que el trabajador haya cerrado sesión | Cuando el trabajador usa el botón "Atrás" del navegador para volver al dashboard | El sistema redirige al login en lugar de mostrar el panel, ya que la sesión fue invalidada |

---

### HU-TRB-003 — Recuperación de Contraseña Olvidada

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-003 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito recuperar el acceso a mi cuenta cuando olvido mi contraseña |
| **Razón / Resultado** | Con la finalidad de restablecer mi contraseña de forma segura a través de mi correo electrónico registrado |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Solicitud con email válido | En caso de que el trabajador ingrese un email registrado en el sistema | Cuando el trabajador accede a `/forgot-password`, ingresa su email y hace clic en "Enviar enlace" | El sistema envía un enlace de restablecimiento al correo y muestra un mensaje de confirmación |
| 2 | Solicitud con email no registrado | En caso de que el email ingresado no exista en el sistema | Cuando el trabajador ingresa un email inválido o no registrado | El sistema muestra un mensaje de error indicando que no se encontró ninguna cuenta asociada |
| 3 | Campo email vacío | En caso de que el trabajador no ingrese ningún email | Cuando el trabajador deja el campo vacío e intenta enviar | El sistema muestra un error de validación solicitando que el campo sea diligenciado |
| 4 | Restablecimiento exitoso mediante token | En caso de que el trabajador acceda al enlace enviado por email | Cuando ingresa a `/reset-password/{token}`, completa la nueva contraseña y su confirmación, y hace clic en "Restablecer Contraseña" | El sistema actualiza la contraseña, invalida el token y redirige a `/login` con mensaje de éxito |
| 5 | Contraseñas no coinciden en el restablecimiento | En caso de que la nueva contraseña y su confirmación sean diferentes | Cuando el trabajador ingresa contraseñas distintas | El sistema muestra un error de validación y no actualiza la contraseña |
| 6 | Token inválido o expirado | En caso de que el enlace de restablecimiento haya expirado o sea inválido | Cuando el trabajador intenta usar un token caducado | El sistema muestra un error indicando que el token no es válido |

---

### HU-TRB-004 — Cambio de Contraseña desde el Perfil

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-004 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito cambiar mi contraseña actual estando autenticado en el sistema |
| **Razón / Resultado** | Con la finalidad de actualizar mis credenciales de acceso por razones de seguridad personal |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cambio exitoso de contraseña | En caso de que el trabajador ingrese correctamente su contraseña actual, la nueva y su confirmación | Cuando el trabajador completa el formulario de cambio de contraseña en su perfil y hace clic en "Guardar" | El sistema actualiza la contraseña y muestra un mensaje de éxito |
| 2 | Contraseña actual incorrecta | En caso de que la contraseña actual ingresada no coincida con la almacenada | Cuando el trabajador intenta guardar con la contraseña actual errónea | El sistema muestra un error de validación y no realiza el cambio |
| 3 | Nueva contraseña y confirmación no coinciden | En caso de que los campos de nueva contraseña y confirmación sean distintos | Cuando el trabajador ingresa contraseñas distintas en esos campos | El sistema muestra un error de validación y no actualiza la contraseña |

---

## MÓDULO 2: DASHBOARD (PANEL DE TRABAJO)

---

### HU-TRB-005 — Visualización del Panel de Trabajo Personal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-005 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito ver un resumen general del estado de mis tareas asignadas al ingresar al sistema |
| **Razón / Resultado** | Con la finalidad de tener visibilidad inmediata sobre mis tareas pendientes, urgentes y vencidas para planificar mi trabajo diario |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización de métricas de tareas personales | En caso de que el trabajador tenga tareas asignadas | Cuando el trabajador accede a `/worker/dashboard` | El sistema muestra 4 tarjetas con: total de tareas, tareas asignadas (sin iniciar), tareas en progreso y tareas completadas (finalizadas + aprobadas) |
| 2 | Alerta de tareas vencidas | En caso de que el trabajador tenga tareas cuya fecha límite ya pasó y no estén finalizadas ni canceladas | Cuando el trabajador accede al dashboard | El sistema muestra un aviso rojo con el número de tareas vencidas |
| 3 | Alerta de fechas límite próximas | En caso de que el trabajador tenga tareas con fecha límite en los próximos 7 días que no estén finalizadas ni canceladas | Cuando el trabajador accede al dashboard | El sistema muestra un aviso amarillo con el número de tareas con fecha límite próxima |
| 4 | No mostrar alertas cuando no hay vencimientos | En caso de que el trabajador no tenga tareas vencidas ni con fechas próximas | Cuando el trabajador accede al dashboard | El sistema no muestra la sección de alertas |
| 5 | Listado de tareas urgentes | En caso de que existan tareas de prioridad alta no finalizadas ni canceladas | Cuando el trabajador accede al dashboard | El sistema muestra hasta 5 tareas urgentes (alta prioridad) ordenadas por fecha límite ascendente, con título, fecha límite y enlace para ver el detalle |
| 6 | Listado de tareas recientes | En caso de que el trabajador tenga tareas asignadas recientemente | Cuando el trabajador accede al dashboard | El sistema muestra hasta 5 tareas más recientes con título, nombre del administrador que la asignó, tiempo transcurrido desde la asignación y enlace para ver el detalle |
| 7 | Dashboard sin tareas | En caso de que el trabajador no tenga tareas asignadas | Cuando el trabajador accede al dashboard | El sistema muestra los contadores en cero, sin alertas y con mensajes indicando que no hay tareas urgentes ni recientes |
| 8 | Acceso rápido al listado completo de tareas | N/A | Cuando el trabajador hace clic en "Ver Todas mis Tareas" en la sección de Acceso Rápido | El sistema redirige al listado completo de tareas del trabajador (`/worker/tasks`) |

---

## MÓDULO 3: GESTIÓN DE MIS TAREAS

---

### HU-TRB-006 — Listado de Mis Tareas Asignadas

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-006 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito ver el listado completo de todas las tareas que me han sido asignadas |
| **Razón / Resultado** | Con la finalidad de tener una vista organizada de todas mis responsabilidades de mantenimiento y su estado actual |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Lista de tareas con datos | En caso de que el trabajador tenga tareas asignadas | Cuando el trabajador accede a la sección "Mis Tareas" (`/worker/tasks`) | El sistema muestra una tabla paginada (10 por página) con las tareas del trabajador, ordenadas por fecha límite ascendente (más urgentes primero), mostrando título, asignado por, estado, prioridad y fecha límite |
| 2 | Lista de tareas vacía | En caso de que el trabajador no tenga tareas asignadas | Cuando el trabajador accede a la sección de tareas | El sistema muestra un mensaje indicando que no tiene tareas asignadas |
| 3 | Búsqueda de tarea por título o descripción | N/A | Cuando el trabajador ingresa un término en el campo de búsqueda y presiona buscar | El sistema filtra y muestra únicamente las tareas cuyo título o descripción contengan el término ingresado |
| 4 | Filtrado por estado de tarea | N/A | Cuando el trabajador selecciona un estado del selector (asignado, en progreso, finalizada, realizada, cancelada) | El sistema muestra únicamente las tareas con ese estado |
| 5 | Filtrado por prioridad de tarea | N/A | Cuando el trabajador selecciona una prioridad del selector (alta, media, baja) | El sistema muestra únicamente las tareas con esa prioridad |
| 6 | Combinación de filtros | N/A | Cuando el trabajador aplica búsqueda, estado y prioridad simultáneamente | El sistema aplica todos los criterios y retorna las tareas que cumplan todas las condiciones |
| 7 | Limpieza de filtros aplicados | En caso de que el trabajador tenga filtros activos | Cuando el trabajador hace clic en el botón "Limpiar" | El sistema elimina todos los filtros y muestra el listado completo de tareas |
| 8 | Paginación de tareas | En caso de que el trabajador tenga más de 10 tareas | Cuando el trabajador accede al listado | El sistema muestra controles de paginación para navegar entre páginas de resultados |
| 9 | El trabajador solo ve sus propias tareas | N/A | Cuando el trabajador accede al listado | El sistema muestra únicamente las tareas asignadas al trabajador autenticado |
| 10 | Badge de estado y prioridad en la tabla | N/A | Cuando el sistema renderiza cada fila del listado | El sistema muestra el estado con badge de color (azul=asignado, índigo=en progreso, verde=finalizada, morado=realizada, rojo=cancelada) y la prioridad con badge (rojo=alta, naranja=media, verde=baja) |

---

### HU-TRB-007 — Visualización del Detalle de una Tarea Asignada

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-007 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito ver el detalle completo de una tarea que me ha sido asignada |
| **Razón / Resultado** | Con la finalidad de conocer todas las especificaciones del trabajo a realizar, las imágenes de referencia y el estado actual del proceso |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Ver detalle completo de la tarea | En caso de que la tarea exista y esté asignada al trabajador | Cuando el trabajador hace clic en "Ver" en la fila de una tarea del listado | El sistema muestra el detalle con: título (indicando "Incidente:" si proviene de un incidente), badge de estado, badge de prioridad, descripción de la tarea, ubicación, fecha límite, nombre del asignador y nombre del instructor que reportó (si aplica) |
| 2 | Aviso de incidente relacionado | En caso de que la tarea provenga de un incidente reportado por un instructor | Cuando el trabajador visualiza el detalle de la tarea | El sistema muestra un banner informativo con el título del incidente relacionado |
| 3 | Galería de imágenes de referencia | N/A | Cuando el trabajador visualiza el detalle de la tarea | El sistema muestra la sección "Imágenes de Referencia" con las imágenes suministradas por el administrador al crear la tarea, con navegación horizontal si hay más de 2 |
| 4 | Galería de evidencia inicial | N/A | Cuando el trabajador visualiza el detalle de la tarea | El sistema muestra la sección "Evidencia Inicial" con las imágenes que el trabajador ha subido como estado de la falla al llegar, o el mensaje "Sin registros iniciales" si aún no hay imágenes |
| 5 | Galería de evidencia final | N/A | Cuando el trabajador visualiza el detalle de la tarea | El sistema muestra la sección "Evidencia Final" con las imágenes del trabajo completado, o el mensaje "Sin registros finales" si aún no se han subido |
| 6 | Visualización de imágenes en zoom | N/A | Cuando el trabajador hace clic en cualquier imagen de las galerías | El sistema abre la imagen en un modal a pantalla completa con botón de cerrar (ESC, clic fuera o botón X) y botón de descarga |
| 7 | Descripción final del trabajo | En caso de que el trabajador haya subido evidencia final con descripción | Cuando el trabajador visualiza el detalle | El sistema muestra el bloque "Descripción Final del Trabajo" con el texto descriptivo del trabajo realizado |
| 8 | Acceso denegado a tareas de otros trabajadores | En caso de que el trabajador intente ver una tarea asignada a otro usuario | Cuando el trabajador navega directamente a la URL del detalle de una tarea ajena | El sistema retorna un error 404 (no encontrado), protegiendo la privacidad de los datos |

---

### HU-TRB-008 — Registro de Evidencia Inicial y Cambio de Estado a "En Progreso"

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-008 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito registrar imágenes de la condición inicial de la falla cuando llego al lugar para dar inicio al trabajo |
| **Razón / Resultado** | Con la finalidad de documentar el estado de la falla antes de la intervención y notificar al administrador que el trabajo ha comenzado |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Formulario de evidencia inicial disponible | En caso de que la tarea esté en estado "asignado" | Cuando el trabajador accede al detalle de la tarea | El sistema muestra la sección "Actualizar Tarea" con el campo de carga de imágenes de evidencia inicial (estado de la falla al llegar) |
| 2 | Subida exitosa de evidencia inicial | En caso de que el trabajador adjunte imágenes válidas | Cuando el trabajador selecciona las imágenes y hace clic en "Enviar Evidencia" | El sistema guarda las imágenes, cambia automáticamente el estado de la tarea de "asignado" a "en progreso", notifica al administrador y redirige al listado con el mensaje "Tarea actualizada exitosamente." |
| 3 | Notificación automática al administrador al iniciar trabajo | En caso de que la subida de evidencia inicial sea exitosa | Cuando el sistema procesa la actualización | El sistema genera automáticamente una notificación al administrador que creó la tarea con el mensaje "[nombre trabajador] ha iniciado el trabajo en: [título de la tarea]" |
| 4 | Imagen con formato inválido | En caso de que el trabajador intente subir un archivo con extensión no permitida | Cuando el trabajador adjunta un archivo que no es jpeg, jpg, png o gif | El sistema muestra un error de validación y no actualiza la tarea |
| 5 | Imagen excede 2MB | En caso de que alguna imagen supere el tamaño máximo | Cuando el trabajador adjunta una imagen mayor a 2MB | El sistema muestra un error indicando que ese archivo excede el tamaño máximo de 2MB |
| 6 | Formulario bloqueado en estados diferentes a "asignado" | En caso de que la tarea no esté en estado "asignado" | Cuando el trabajador visualiza el detalle de una tarea con otro estado | El sistema no muestra el formulario de evidencia inicial, en su lugar muestra un aviso informativo indicando que el estado actual no permite actualizaciones desde su perfil |

---

### HU-TRB-009 — Registro de Evidencia Final y Envío a Revisión ("Realizada")

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-009 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito registrar las imágenes del trabajo completado junto con una descripción del trabajo realizado para enviarlo a revisión del administrador |
| **Razón / Resultado** | Con la finalidad de documentar el resultado de la intervención y solicitar la aprobación del administrador para dar por cerrada la tarea |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Formulario de evidencia final disponible | En caso de que la tarea esté en estado "en progreso" | Cuando el trabajador accede al detalle de la tarea | El sistema muestra la sección "Actualizar Tarea" con el campo de carga de imágenes de evidencia final y el campo de texto para la descripción del trabajo realizado |
| 2 | Subida exitosa de evidencia final con descripción | En caso de que el trabajador adjunte imágenes válidas y complete la descripción | Cuando el trabajador selecciona las imágenes, escribe la descripción del trabajo y hace clic en "Enviar Evidencia" | El sistema guarda las imágenes, guarda la descripción, cambia automáticamente el estado de la tarea de "en progreso" a "realizada", notifica al administrador y redirige al listado con el mensaje "Tarea actualizada exitosamente." |
| 3 | Notificación automática al administrador al completar trabajo | En caso de que la subida de evidencia final sea exitosa | Cuando el sistema procesa la actualización | El sistema genera automáticamente una notificación al administrador que creó la tarea con el mensaje "[nombre trabajador] ha completado: [título de la tarea]" y tipo `task_completed` |
| 4 | Evidencias adicionales se acumulan | En caso de que la tarea ya tenga imágenes de evidencia final previas | Cuando el trabajador sube nuevas imágenes de evidencia final | El sistema añade las nuevas imágenes a las ya existentes (merge), sin eliminar las anteriores |
| 5 | Imagen con formato inválido en evidencia final | En caso de que el trabajador adjunte un archivo con extensión no permitida | Cuando el trabajador selecciona un archivo que no es jpeg, jpg, png o gif | El sistema muestra un error de validación y no actualiza la tarea |
| 6 | Imagen excede 2MB en evidencia final | En caso de que alguna imagen supere el tamaño máximo | Cuando el trabajador adjunta una imagen mayor a 2MB | El sistema muestra el error correspondiente y no actualiza la tarea |
| 7 | Formulario bloqueado en estados distintos a "en progreso" | En caso de que la tarea no esté en estado "en progreso" | Cuando el trabajador visualiza el detalle de una tarea con estado "realizada", "finalizada", "cancelada" u otro | El sistema no muestra el formulario de evidencia final, en su lugar muestra un aviso informativo indicando que el estado actual no permite actualizaciones desde su perfil y sugiere contactar al administrador si se requieren correcciones |

---

## MÓDULO 4: NOTIFICACIONES

---

### HU-TRB-010 — Recepción y Visualización de Notificaciones

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-010 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito recibir y visualizar notificaciones sobre las tareas que me son asignadas |
| **Razón / Resultado** | Con la finalidad de estar al tanto de nuevas asignaciones y actualizaciones sobre mis tareas de mantenimiento |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Notificación al ser asignado a una nueva tarea | En caso de que un administrador cree una tarea y la asigne al trabajador | Cuando el sistema procesa la asignación | El trabajador recibe automáticamente una notificación con el mensaje "Te han asignado una nueva tarea: [título de la tarea]" |
| 2 | Notificación al rechazar su trabajo | En caso de que el administrador rechace la tarea enviada por el trabajador | Cuando el sistema procesa el rechazo | El trabajador recibe una notificación indicando que su trabajo fue rechazado y la tarea vuelve a estado "en progreso" para corrección |
| 3 | Notificación al aprobar su trabajo | En caso de que el administrador apruebe la tarea "realizada" por el trabajador | Cuando el sistema procesa la aprobación | El trabajador puede recibir una notificación confirmando que la tarea fue aprobada exitosamente |
| 4 | Contador de notificaciones no leídas | En caso de que el trabajador tenga notificaciones sin leer | Cuando el trabajador está autenticado en cualquier página del sistema | El sistema muestra un indicador (badge) con el número de notificaciones no leídas en el ícono de notificaciones de la barra lateral |
| 5 | Sin notificaciones no leídas | En caso de que todas las notificaciones estén marcadas como leídas | Cuando el trabajador revisa la barra de navegación | El sistema no muestra el badge de notificaciones |
| 6 | Listado de notificaciones | N/A | Cuando el trabajador accede a la sección de notificaciones (`/notifications`) | El sistema muestra el historial de todas las notificaciones recibidas |
| 7 | Marcar notificación como leída | En caso de que el trabajador tenga notificaciones sin leer | Cuando el trabajador hace clic en una notificación específica | El sistema marca esa notificación como leída |
| 8 | Marcar todas como leídas | En caso de que existan múltiples notificaciones sin leer | Cuando el trabajador hace clic en "Marcar todas como leídas" | El sistema marca todas las notificaciones como leídas y el badge desaparece |

---

## MÓDULO 5: PERFIL DE USUARIO Y CONFIGURACIÓN

---

### HU-TRB-011 — Visualización y Edición del Perfil Personal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-011 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Necesito ver y editar mi información de perfil personal dentro del sistema |
| **Razón / Resultado** | Con la finalidad de mantener mis datos actualizados y gestionar la seguridad de mi cuenta |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización del perfil personal | N/A | Cuando el trabajador accede a `/profile/show` | El sistema muestra la información del perfil: nombre completo, dirección de email, rol asignado (`Trabajador`) y foto de perfil del trabajador autenticado |
| 2 | Acceso al formulario de edición de perfil | N/A | Cuando el trabajador hace clic en "Editar Perfil" o accede a `/profile` | El sistema muestra el formulario de edición con los campos nombre y email precargados con los datos actuales |
| 3 | Edición exitosa de nombre y/o email | En caso de que el trabajador ingrese datos válidos diferentes a los actuales | Cuando el trabajador modifica su nombre o email y hace clic en "Guardar" | El sistema actualiza la información, muestra un mensaje de éxito (`profile-updated`) y refleja los cambios inmediatamente en el menú de usuario |
| 4 | Campo nombre vacío en edición | En caso de que el trabajador borre el campo nombre | Cuando el trabajador intenta guardar con el nombre en blanco | El sistema muestra un error de validación indicando que el nombre es requerido |
| 5 | Email con formato inválido | En caso de que el trabajador ingrese un email con formato incorrecto | Cuando el trabajador escribe un email sin `@` u otro formato inválido e intenta guardar | El sistema muestra un error de validación indicando que el email debe tener un formato válido |
| 6 | Email duplicado en edición de perfil | En caso de que el nuevo email ya esté en uso por otro usuario registrado | Cuando el trabajador intenta guardar un email ya registrado en el sistema | El sistema muestra un error de validación y no actualiza el perfil |
| 7 | Cambio de contraseña desde perfil | N/A | Cuando el trabajador completa los campos contraseña actual, nueva contraseña y confirmación con datos válidos y hace clic en "Guardar" | El sistema actualiza la contraseña y muestra el mensaje de éxito (`password-updated`) en el perfil |
| 8 | Eliminación de cuenta propia con confirmación | En caso de que el trabajador desee eliminar permanentemente su cuenta | Cuando el trabajador hace clic en "Eliminar cuenta", ingresa su contraseña actual para confirmar y acepta | El sistema cierra la sesión, elimina todos los datos asociados a la cuenta y redirige a la página de inicio |

---

### HU-TRB-012 — Acceso a Configuraciones del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-012 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Puedo acceder y configurar las preferencias personales del sistema desde la sección de configuración |
| **Razón / Resultado** | Con la finalidad de personalizar la apariencia de la plataforma, gestionar las preferencias de notificaciones y revisar opciones de privacidad y seguridad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a configuraciones desde el menú | N/A | Cuando el trabajador hace clic en "Configuración" en el menú lateral | El sistema redirige a la vista de configuraciones (`/settings`) mostrando la pestaña "Notificaciones" activa por defecto |
| 2 | Navegación entre secciones de configuración | N/A | Cuando el trabajador hace clic en cualquier opción del menú lateral de configuración | El sistema muestra el contenido de la sección seleccionada sin recargar la página (navegación por hash con Alpine.js) |
| 3 | Toggle: Nuevas Tareas o Incidentes | En caso de que el trabajador desee controlar alertas por correo al ser asignado a una tarea | Cuando el trabajador activa o desactiva el toggle "Nuevas Tareas o Incidentes" en la sección Notificaciones | El sistema refleja visualmente el cambio del toggle (activado por defecto) |
| 4 | Toggle: Actualizaciones de Estado | En caso de que el trabajador desee controlar notificaciones sobre cambios en sus tareas | Cuando el trabajador activa o desactiva el toggle "Actualizaciones de Estado" | El sistema refleja visualmente el cambio del toggle |
| 5 | Toggle: Alertas Promocionales | En caso de que el trabajador desee controlar noticias y nuevos lanzamientos de la plataforma | Cuando el trabajador activa o desactiva el toggle "Alertas Promocionales" | El sistema refleja visualmente el cambio del toggle (inactivo por defecto) |
| 6 | Cambio de tema: Modo Claro | En caso de que el trabajador desee una interfaz clara | Cuando el trabajador selecciona la opción "Claro" en la sección Apariencia | El sistema aplica inmediatamente el tema claro a toda la interfaz, guarda la preferencia en `localStorage` y muestra el ícono de selección activo sobre esa opción |
| 7 | Cambio de tema: Modo Oscuro | En caso de que el trabajador desee una interfaz oscura | Cuando el trabajador selecciona la opción "Oscuro" en la sección Apariencia | El sistema aplica inmediatamente el tema oscuro a toda la interfaz y guarda la preferencia en `localStorage` |
| 8 | Cambio de tema: Modo Sistema | En caso de que el trabajador prefiera seguir la configuración del sistema operativo | Cuando el trabajador selecciona la opción "Sistema" en la sección Apariencia | El sistema detecta la preferencia del SO, aplica el tema correspondiente, guarda la preferencia en `localStorage` y escucha automáticamente cambios futuros del SO |
| 9 | Sección Privacidad y Seguridad en construcción | N/A | Cuando el trabajador hace clic en "Privacidad y Seguridad" del menú lateral de configuración | El sistema muestra la sección con un aviso indicando que la funcionalidad (autenticación de dos factores y gestión de dispositivos) está próximamente disponible |
| 10 | Persistencia del tema entre sesiones | En caso de que el trabajador haya configurado un tema previamente | Cuando el trabajador recarga la página o navega a otra sección del sistema | El sistema carga y aplica automáticamente el tema guardado en `localStorage` sin necesidad de reconfigurarlo |

---

### HU-TRB-013 — Acceso a la Sección de Soporte

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-TRB-013 |
| **Rol** | Como un Trabajador |
| **Característica / Funcionalidad** | Puedo acceder a la sección de ayuda y soporte del sistema |
| **Razón / Resultado** | Con la finalidad de consultar las preguntas frecuentes, contactar al equipo de soporte técnico y descargar la documentación del sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a soporte desde el menú | N/A | Cuando el trabajador hace clic en "Soporte" en el menú lateral | El sistema redirige a la vista de soporte (`/support`) mostrando el panel de Preguntas Frecuentes (FAQ) y las opciones rápidas de contacto y manual |
| 2 | Visualización de preguntas frecuentes (FAQ) | N/A | Cuando el trabajador accede a la sección de soporte | El sistema muestra el listado de preguntas frecuentes colapsadas relevantes para el trabajador: (1) Cómo restablecer la contraseña, (2) Formato permitido para fotos de evidencia al registrar avance de tarea, (3) Razón por la que no se pueden editar tareas con evidencias ya cargadas |
| 3 | Expandir una pregunta frecuente | N/A | Cuando el trabajador hace clic sobre el título de una pregunta del FAQ | El sistema expande el cuerpo de esa pregunta mostrando la respuesta detallada y colapsa automáticamente cualquier otra que estuviera expandida |
| 4 | Colapsar una pregunta frecuente | En caso de que una pregunta esté activa/expandida | Cuando el trabajador vuelve a hacer clic sobre esa misma pregunta | El sistema colapsa el contenido de la pregunta, ocultando la respuesta |
| 5 | Botón de contacto a soporte urgente | N/A | Cuando el trabajador hace clic en "Contactar Soporte" en el panel lateral | El sistema ofrece el medio de contacto directo con el equipo de soporte técnico disponible 24/7 |
| 6 | Descarga del Manual Técnico | N/A | Cuando el trabajador hace clic en "Descargar PDF" en la tarjeta de Manual Técnico | El sistema proporciona el enlace de descarga del manual de usuario en formato PDF |

---

## Resumen de Historias de Usuario — Rol Trabajador

| ID | Módulo | Historia |
|---|---|---|
| HU-TRB-001 | Autenticación | Inicio de sesión en el sistema |
| HU-TRB-002 | Autenticación | Cierre de sesión del sistema |
| HU-TRB-003 | Autenticación | Recuperación de contraseña olvidada |
| HU-TRB-004 | Autenticación | Cambio de contraseña desde el perfil |
| HU-TRB-005 | Dashboard | Visualización del panel de trabajo personal |
| HU-TRB-006 | Gestión de Tareas | Listado de mis tareas asignadas |
| HU-TRB-007 | Gestión de Tareas | Visualización del detalle de una tarea asignada |
| HU-TRB-008 | Gestión de Tareas | Registro de evidencia inicial y cambio de estado a "En Progreso" |
| HU-TRB-009 | Gestión de Tareas | Registro de evidencia final y envío a revisión ("Realizada") |
| HU-TRB-010 | Notificaciones | Recepción y visualización de notificaciones |
| HU-TRB-011 | Perfil y Configuración | Visualización y edición del perfil personal |
| HU-TRB-012 | Perfil y Configuración | Acceso a configuraciones del sistema |
| HU-TRB-013 | Perfil y Configuración | Acceso a la sección de soporte |

---

*Documento generado para el proyecto SIGERD v1.0 — Centro de Formación Agroindustrial*
*Fecha de elaboración: 08/03/2026*
