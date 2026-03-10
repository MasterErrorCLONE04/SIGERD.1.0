# Historias de Usuario — Rol: Instructor
## Sistema: SIGERD v1.0 — Sistema de Gestión de Reportes y Distribución
### Centro de Formación Agroindustrial

---

## Convenciones del Documento

| Campo | Descripción |
|---|---|
| **Identificador (ID)** | Código único en formato `HU-INS-XXX` |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Acción que el instructor necesita o puede realizar |
| **Razón / Resultado** | Finalidad o beneficio esperado al ejecutar la acción |
| **Número (#) de Escenario** | Número secuencial del escenario de aceptación |
| **Criterio de Aceptación (Título)** | Nombre corto del escenario |
| **Contexto** | Condición previa o situación que desencadena el escenario |
| **Evento** | Acción que ejecuta el usuario |
| **Resultado / Comportamiento esperado** | Respuesta del sistema ante el evento |

---

## MÓDULO 1: AUTENTICACIÓN Y ACCESO AL SISTEMA

---

### HU-INS-001 — Inicio de Sesión en el Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-001 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito iniciar sesión en el sistema con mis credenciales |
| **Razón / Resultado** | Con la finalidad de acceder a mi panel de reportes y gestionar las fallas que identifico en el centro |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Inicio de sesión exitoso | En caso de que el instructor ingrese email y contraseña válidos | Cuando el instructor completa el formulario de login y hace clic en "Iniciar sesión" | El sistema autentica al usuario y lo redirige automáticamente al panel del instructor (`/instructor/dashboard`) |
| 2 | Credenciales incorrectas | En caso de que el instructor ingrese email o contraseña incorrectos | Cuando el instructor ingresa datos inválidos y hace clic en "Iniciar sesión" | El sistema muestra un mensaje de error y no permite el acceso |
| 3 | Redirección automática según rol | N/A | Cuando el instructor accede a la ruta `/dashboard` | El sistema detecta el rol `instructor` y redirige automáticamente a `/instructor/dashboard` |
| 4 | Acceso denegado a rutas del administrador | En caso de que el instructor intente acceder a rutas del panel de administración | Cuando el instructor navega a `/admin/dashboard` o cualquier ruta protegida del admin | El sistema bloquea el acceso y redirige al dashboard del instructor |

---

### HU-INS-002 — Cierre de Sesión del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-002 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito cerrar la sesión activa en el sistema |
| **Razón / Resultado** | Con la finalidad de proteger mi cuenta y garantizar que nadie más pueda acceder a mi información |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cierre de sesión exitoso | En caso de que el instructor se encuentre autenticado en el sistema | Cuando el instructor hace clic en la opción "Cerrar Sesión" del menú lateral o del menú desplegable de usuario | El sistema invalida la sesión activa, destruye el token de autenticación y redirige al instructor a la página de inicio de sesión (`/login`) |
| 2 | Acceso bloqueado tras cerrar sesión | En caso de que el instructor intente navegar a una página protegida después de haber cerrado sesión | Cuando el instructor intenta acceder a `/instructor/dashboard` u otra ruta protegida sin sesión activa | El sistema detecta que no hay sesión válida y redirige automáticamente a la página de login |
| 3 | No se puede retroceder al panel tras el logout | En caso de que el instructor haya cerrado sesión | Cuando el instructor usa el botón "Atrás" del navegador para volver al dashboard | El sistema redirige al login en lugar de mostrar el panel, ya que la sesión fue invalidada |

---

### HU-INS-003 — Recuperación de Contraseña Olvidada

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-003 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito recuperar el acceso a mi cuenta cuando olvido mi contraseña |
| **Razón / Resultado** | Con la finalidad de restablecer mi contraseña de forma segura a través de mi correo electrónico registrado |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Solicitud con email válido | En caso de que el instructor ingrese un email registrado en el sistema | Cuando el instructor accede a `/forgot-password`, ingresa su email y hace clic en "Enviar enlace" | El sistema envía un enlace de restablecimiento al correo y muestra un mensaje de confirmación |
| 2 | Solicitud con email no registrado | En caso de que el email ingresado no exista en el sistema | Cuando el instructor ingresa un email inválido o no registrado | El sistema muestra un mensaje de error indicando que no se encontró ninguna cuenta asociada |
| 3 | Campo email vacío | En caso de que el instructor no ingrese ningún email | Cuando el instructor deja el campo vacío e intenta enviar | El sistema muestra un error de validación solicitando que el campo sea diligenciado |
| 4 | Restablecimiento exitoso mediante token | En caso de que el instructor acceda al enlace enviado por email | Cuando ingresa a `/reset-password/{token}`, completa la nueva contraseña y su confirmación, y hace clic en "Restablecer Contraseña" | El sistema actualiza la contraseña, invalida el token y redirige a `/login` con mensaje de éxito |
| 5 | Contraseñas no coinciden en el restablecimiento | En caso de que la nueva contraseña y su confirmación sean diferentes | Cuando el instructor ingresa contraseñas distintas | El sistema muestra un error de validación y no actualiza la contraseña |
| 6 | Token inválido o expirado | En caso de que el enlace de restablecimiento haya expirado o sea inválido | Cuando el instructor intenta usar un token caducado | El sistema muestra un error indicando que el token no es válido |

---

### HU-INS-004 — Cambio de Contraseña desde el Perfil

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-004 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito cambiar mi contraseña actual estando autenticado en el sistema |
| **Razón / Resultado** | Con la finalidad de actualizar mis credenciales de acceso por razones de seguridad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cambio exitoso de contraseña | En caso de que el instructor ingrese correctamente su contraseña actual, la nueva y su confirmación | Cuando el instructor completa el formulario de cambio de contraseña en su perfil y hace clic en "Guardar" | El sistema actualiza la contraseña y muestra un mensaje de éxito (`password-updated`) |
| 2 | Contraseña actual incorrecta | En caso de que la contraseña actual ingresada no coincida con la almacenada | Cuando el instructor intenta guardar con la contraseña actual errónea | El sistema muestra un error de validación y no realiza el cambio |
| 3 | Nueva contraseña y confirmación no coinciden | En caso de que los campos de nueva contraseña y confirmación sean distintos | Cuando el instructor ingresa contraseñas distintas en esos campos | El sistema muestra un error de validación y no actualiza la contraseña |

---

## MÓDULO 2: DASHBOARD (PANEL DE REPORTES)

---

### HU-INS-005 — Visualización del Panel de Reportes Personal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-005 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito ver un resumen general del estado de todas mis incidencias al ingresar al sistema |
| **Razón / Resultado** | Con la finalidad de tener visibilidad inmediata sobre el estado de mis reportes y cuáles requieren seguimiento |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización de métricas de incidentes propios | En caso de que el instructor tenga incidentes registrados | Cuando el instructor accede a `/instructor/dashboard` | El sistema muestra el total de reportes enviados y el número de incidentes asignados (en atención) |
| 2 | Listado de incidentes pendientes de revisión | En caso de que existan incidentes con estado "pendiente de revisión" | Cuando el instructor accede al dashboard | El sistema muestra una lista de hasta 5 incidentes pendientes de revisión con título, descripción parcial, tiempo transcurrido y enlace para ver el detalle |
| 3 | Listado de reportes recientes | En caso de que el instructor tenga incidentes registrados | Cuando el instructor accede al dashboard | El sistema muestra una lista de hasta 5 incidentes más recientes con título, descripción parcial, badge de estado y tiempo transcurrido |
| 4 | Indicador de estado con colores en reportes recientes | N/A | Cuando se muestran los reportes recientes en el dashboard | El sistema aplica badges de colores según el estado: amarillo (pendiente de revisión), azul (asignado), índigo (resuelto), verde (cerrado) |
| 5 | Dashboard sin incidentes registrados | En caso de que el instructor no haya reportado ningún incidente | Cuando el instructor accede al dashboard | El sistema muestra los contadores en cero y los paneles de listas vacíos con mensajes informativos |
| 6 | Acceso rápido para reportar nueva falla desde dashboard | N/A | Cuando el instructor hace clic en el botón "Reportar Nueva Falla" de la sección de Acceso Rápido | El sistema abre el modal de creación de incidente sin necesidad de salir del dashboard |
| 7 | Acceso rápido al listado de reportes | N/A | Cuando el instructor hace clic en "Ver Todos mis Reportes" de la sección de Acceso Rápido | El sistema redirige al instructor a la vista de listado de incidentes (`/instructor/incidents`) |

---

## MÓDULO 3: GESTIÓN DE REPORTES DE FALLAS (INCIDENTES)

---

### HU-INS-006 — Listado de Mis Reportes de Fallas

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-006 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito ver el listado completo de todas las fallas que he reportado al sistema |
| **Razón / Resultado** | Con la finalidad de monitorear el estado y seguimiento de cada incidencia reportada |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Lista de reportes con datos | En caso de que el instructor tenga incidentes registrados | Cuando el instructor accede a la sección "Mis Reportes" (`/instructor/incidents`) | El sistema muestra una tabla paginada (10 por página) con los incidentes del instructor ordenados por fecha de creación descendente, mostrando título, descripción parcial, ubicación, estado y fecha |
| 2 | Lista de reportes vacía | En caso de que el instructor no haya registrado ningún incidente | Cuando el instructor accede a la sección de incidentes | El sistema muestra un mensaje indicando que no tiene reportes de fallas y un botón para reportar la primera falla |
| 3 | Búsqueda de reporte por título, descripción o ubicación | N/A | Cuando el instructor ingresa un término en el campo de búsqueda y presiona buscar | El sistema filtra y muestra únicamente los incidentes cuyo título, descripción o ubicación contengan el término ingresado |
| 4 | Filtrado por estado de incidente | N/A | Cuando el instructor selecciona un estado del selector (pendiente de revisión, asignado, resuelto, cerrado) | El sistema muestra únicamente los incidentes con ese estado |
| 5 | Combinación de búsqueda y filtro de estado | N/A | Cuando el instructor aplica texto de búsqueda y filtro de estado simultáneamente | El sistema aplica ambos criterios y retorna los incidentes que cumplan las dos condiciones |
| 6 | Limpieza de filtros aplicados | En caso de que el instructor tenga filtros activos | Cuando el instructor hace clic en "Limpiar" | El sistema elimina todos los filtros y muestra el listado completo de incidentes |
| 7 | Búsqueda sin coincidencias | En caso de que ningún incidente coincida con los filtros aplicados | Cuando el instructor aplica filtros sin resultados | El sistema muestra un mensaje indicando que no hay reportes con esos criterios y ofrece la opción de limpiar los filtros |
| 8 | Paginación de incidentes | En caso de que el instructor tenga más de 10 incidentes | Cuando el instructor accede al listado | El sistema muestra controles de paginación para navegar entre páginas de resultados |
| 9 | El instructor solo ve sus propios incidentes | N/A | Cuando el instructor accede al listado | El sistema muestra únicamente los incidentes reportados por el instructor autenticado, sin mostrar incidentes de otros usuarios |
| 10 | Badge de estado en la tabla | N/A | Cuando el sistema renderiza cada fila del listado | El sistema muestra el estado del incidente con un badge de color: amarillo (pendiente de revisión), azul/verde (asignado), verde oscuro (resuelto/cerrado) |

---

### HU-INS-007 — Reporte de Nueva Falla o Incidencia

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-007 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito reportar una nueva falla o incidencia identificada en las instalaciones del centro |
| **Razón / Resultado** | Con la finalidad de notificar al equipo administrativo para que sea atendida y resuelta oportunamente |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Apertura del modal de reporte desde el dashboard | En caso de que el instructor esté en el dashboard o en el listado de incidentes | Cuando el instructor hace clic en "Reportar Nueva Falla" | El sistema abre un modal con el formulario de reporte de falla (título, descripción, ubicación, fecha del reporte e imágenes de evidencia) |
| 2 | Reporte exitoso de nueva falla | En caso de que todos los campos obligatorios sean correctamente diligenciados | Cuando el instructor completa el formulario con título, descripción, ubicación, fecha del reporte e imágenes de evidencia, y hace clic en "Reportar" | El sistema crea el incidente con estado "pendiente de revisión", registra al instructor como reportante, notifica a todos los administradores y redirige al listado con el mensaje "Falla reportada exitosamente." |
| 3 | Notificación automática a administradores | En caso de que el reporte sea creado exitosamente | Cuando el sistema procesa el reporte | El sistema genera automáticamente una notificación a todos los usuarios con rol administrador con el mensaje "[nombre instructor] ha reportado: [título de la falla]" y con enlace directo al incidente |
| 4 | Campos obligatorios vacíos | En caso de que el instructor no complete todos los campos requeridos | Cuando intenta guardar el reporte sin completar título, descripción, ubicación o fecha | El sistema muestra los errores de validación correspondientes y no crea el incidente |
| 5 | Fecha de reporte posterior a hoy | En caso de que el instructor ingrese una fecha futura | Cuando el instructor ingresa una fecha de reporte mayor a la fecha actual | El sistema muestra el error: la fecha del reporte no puede ser posterior a hoy |
| 6 | Imágenes de evidencia obligatorias | En caso de que el instructor no adjunte ninguna imagen | Cuando el instructor intenta guardar sin imágenes de evidencia | El sistema muestra el error "Debe subir al menos una imagen de evidencia." |
| 7 | Formato de imagen no válido | En caso de que se adjunte un archivo con extensión no permitida | Cuando el instructor sube un archivo que no es jpeg, jpg, png o gif | El sistema muestra un mensaje indicando que la extensión no está permitida y no crea el incidente |
| 8 | Imagen de evidencia excede 2MB | En caso de que alguna imagen supere el tamaño máximo | Cuando el instructor adjunta una imagen mayor a 2MB | El sistema muestra el error indicando que ese archivo excede el tamaño máximo de 2MB |
| 9 | Cierre del modal sin guardar | N/A | Cuando el instructor hace clic fuera del modal o en el botón de cierre | El sistema cierra el modal sin crear ningún incidente |

---

### HU-INS-008 — Visualización del Detalle de un Reporte de Falla

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-008 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito ver el detalle completo de un reporte de falla que he enviado |
| **Razón / Resultado** | Con la finalidad de conocer el estado actual de la incidencia, revisar la evidencia enviada y ver si ya fue atendida |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Ver detalle completo del reporte | En caso de que el incidente exista y pertenezca al instructor | Cuando el instructor hace clic en "Ver" en la fila de un incidente del listado | El sistema muestra el detalle con: título, estado, descripción del problema, ubicación, fecha de reporte, ID del reporte e imágenes de evidencia inicial |
| 2 | Visualización de imágenes de evidencia inicial con zoom | En caso de que el incidente tenga imágenes de evidencia adjuntas | Cuando el instructor hace clic en una imagen del detalle | El sistema abre la imagen en un modal a tamaño completo con opción de cerrar (clic fuera, ESC o botón X) y botón de descarga |
| 3 | Acceso denegado a reportes de otros instructores | En caso de que el instructor intente ver un incidente de otro usuario | Cuando el instructor navega directamente a la URL del detalle de un incidente ajeno | El sistema retorna un error 404 (no encontrado), protegiendo la privacidad de los datos |
| 4 | Reporte en estado "pendiente de revisión" | En caso de que el incidente aún no haya sido procesado por el administrador | Cuando el instructor visualiza el detalle de un incidente con estado "pendiente de revisión" | El sistema muestra un aviso informativo indicando que el reporte está siendo revisado por el equipo administrativo y será asignado a un trabajador |
| 5 | Reporte en estado "asignado" | En caso de que el incidente haya sido convertido en tarea y asignado a un trabajador | Cuando el instructor visualiza el detalle de un incidente con estado "asignado" | El sistema muestra el nombre del trabajador asignado y un aviso informativo indicando que el trabajo está en progreso |
| 6 | Reporte en estado "resuelto" con evidencia final | En caso de que el incidente haya sido resuelto | Cuando el instructor visualiza el detalle de un incidente con estado "resuelto" | El sistema muestra la sección de resolución con: fecha de resolución, descripción de la solución aplicada e imágenes de evidencia final del trabajo realizado |
| 7 | Imágenes de evidencia final con zoom | En caso de que el incidente resuelto tenga imágenes de evidencia final | Cuando el instructor hace clic en una imagen de evidencia final | El sistema abre la imagen en el modal a pantalla completa con badge "Final" visible, opción de cerrar y botón de descarga |
| 8 | Botón de regreso al listado | N/A | Cuando el instructor hace clic en "Volver a la Lista" | El sistema redirige al instructor al listado de sus incidentes (`/instructor/incidents`) |

---

## MÓDULO 4: NOTIFICACIONES

---

### HU-INS-009 — Recepción y Visualización de Notificaciones

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-009 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito recibir y visualizar notificaciones sobre el estado de mis reportes de fallas |
| **Razón / Resultado** | Con la finalidad de estar al tanto de cuando mis incidentes son convertidos en tarea o cuando el mantenimiento es finalizado |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Notificación al convertir incidente en tarea | En caso de que un administrador convierta uno de mis incidentes en tarea | Cuando el sistema procesa la conversión | El instructor recibe automáticamente una notificación con el mensaje "Tu incidente ha sido convertido en una tarea" |
| 2 | Notificación al resolver el incidente | En caso de que el administrador apruebe la tarea vinculada al incidente | Cuando el sistema procesa la aprobación de la tarea | El instructor recibe automáticamente una notificación con el mensaje "Reparación/Mantenimiento finalizado con éxito para tu incidencia: [título]" |
| 3 | Contador de notificaciones no leídas | En caso de que el instructor tenga notificaciones sin leer | Cuando el instructor está autenticado en cualquier página del sistema | El sistema muestra un indicador (badge) con el número de notificaciones no leídas en el ícono de notificaciones de la barra lateral |
| 4 | Sin notificaciones no leídas | En caso de que todas las notificaciones estén marcadas como leídas | Cuando el instructor revisa la barra de navegación | El sistema no muestra el badge de notificaciones |
| 5 | Listado de notificaciones | N/A | Cuando el instructor accede a la sección de notificaciones (`/notifications`) | El sistema muestra el historial de todas las notificaciones recibidas |
| 6 | Marcar notificación como leída | En caso de que el instructor tenga notificaciones sin leer | Cuando el instructor hace clic en una notificación específica | El sistema marca esa notificación como leída |
| 7 | Marcar todas como leídas | En caso de que existan múltiples notificaciones sin leer | Cuando el instructor hace clic en "Marcar todas como leídas" | El sistema marca todas las notificaciones como leídas y el badge desaparece |

---

## MÓDULO 5: PERFIL DE USUARIO Y CONFIGURACIÓN

---

### HU-INS-010 — Visualización y Edición del Perfil Personal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-010 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Necesito ver y editar mi información de perfil personal dentro del sistema |
| **Razón / Resultado** | Con la finalidad de mantener mis datos actualizados y gestionar la seguridad de mi cuenta |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización del perfil personal | N/A | Cuando el instructor accede a `/profile/show` | El sistema muestra la información del perfil: nombre completo, dirección de email, rol asignado (`Instructor`) y foto de perfil del instructor autenticado |
| 2 | Acceso al formulario de edición de perfil | N/A | Cuando el instructor hace clic en "Editar Perfil" o accede a `/profile` | El sistema muestra el formulario de edición con los campos nombre y email precargados con los datos actuales |
| 3 | Edición exitosa de nombre y/o email | En caso de que el instructor ingrese datos válidos diferentes a los actuales | Cuando el instructor modifica su nombre o email y hace clic en "Guardar" | El sistema actualiza la información, muestra un mensaje de éxito (`profile-updated`) y refleja los cambios inmediatamente en el menú de usuario |
| 4 | Campo nombre vacío en edición | En caso de que el instructor borre el campo nombre | Cuando el instructor intenta guardar con el nombre en blanco | El sistema muestra un error de validación indicando que el nombre es requerido |
| 5 | Email con formato inválido | En caso de que el instructor ingrese un email con formato incorrecto | Cuando el instructor escribe un email sin `@` u otro formato inválido e intenta guardar | El sistema muestra un error de validación indicando que el email debe tener un formato válido |
| 6 | Email duplicado en edición de perfil | En caso de que el nuevo email ya esté en uso por otro usuario registrado | Cuando el instructor intenta guardar un email ya registrado en el sistema | El sistema muestra un error de validación y no actualiza el perfil |
| 7 | Cambio de contraseña desde perfil | N/A | Cuando el instructor completa los campos contraseña actual, nueva contraseña y confirmación con datos válidos y hace clic en "Guardar" | El sistema actualiza la contraseña y muestra el mensaje de éxito (`password-updated`) en el perfil |
| 8 | Eliminación de cuenta propia con confirmación | En caso de que el instructor desee eliminar permanentemente su cuenta | Cuando el instructor hace clic en "Eliminar cuenta", ingresa su contraseña actual para confirmar y acepta | El sistema cierra la sesión, elimina todos los datos asociados a la cuenta y redirige a la página de inicio |

---

### HU-INS-011 — Acceso a Configuraciones del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-011 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Puedo acceder y configurar las preferencias personales del sistema desde la sección de configuración |
| **Razón / Resultado** | Con la finalidad de personalizar la apariencia de la plataforma, gestionar las preferencias de notificaciones y revisar opciones de privacidad y seguridad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a configuraciones desde el menú | N/A | Cuando el instructor hace clic en "Configuración" en el menú lateral | El sistema redirige a la vista de configuraciones (`/settings`) mostrando la pestaña "Notificaciones" activa por defecto |
| 2 | Navegación entre secciones de configuración | N/A | Cuando el instructor hace clic en cualquier opción del menú lateral de configuración | El sistema muestra el contenido de la sección seleccionada sin recargar la página (navegación por hash con Alpine.js) |
| 3 | Toggle: Nuevas Tareas o Incidentes | En caso de que el instructor desee controlar alertas por correo de asignaciones | Cuando el instructor activa o desactiva el toggle "Nuevas Tareas o Incidentes" en la sección Notificaciones | El sistema refleja visualmente el cambio del toggle (activado por defecto) |
| 4 | Toggle: Actualizaciones de Estado | En caso de que el instructor desee controlar notificaciones sobre cambios en sus reportes | Cuando el instructor activa o desactiva el toggle "Actualizaciones de Estado" | El sistema refleja visualmente el cambio del toggle |
| 5 | Toggle: Alertas Promocionales | En caso de que el instructor desee controlar noticias y nuevos lanzamientos de la plataforma | Cuando el instructor activa o desactiva el toggle "Alertas Promocionales" | El sistema refleja visualmente el cambio del toggle (inactivo por defecto) |
| 6 | Cambio de tema: Modo Claro | En caso de que el instructor desee una interfaz clara | Cuando el instructor selecciona la opción "Claro" en la sección Apariencia | El sistema aplica inmediatamente el tema claro a toda la interfaz, guarda la preferencia en `localStorage` y muestra el ícono de selección activo sobre esa opción |
| 7 | Cambio de tema: Modo Oscuro | En caso de que el instructor desee una interfaz oscura | Cuando el instructor selecciona la opción "Oscuro" en la sección Apariencia | El sistema aplica inmediatamente el tema oscuro a toda la interfaz y guarda la preferencia en `localStorage` |
| 8 | Cambio de tema: Modo Sistema | En caso de que el instructor prefiera seguir la configuración del sistema operativo | Cuando el instructor selecciona la opción "Sistema" en la sección Apariencia | El sistema detecta la preferencia del SO, aplica el tema correspondiente, guarda la preferencia en `localStorage` y escucha automáticamente cambios futuros del SO |
| 9 | Sección Privacidad y Seguridad en construcción | N/A | Cuando el instructor hace clic en "Privacidad y Seguridad" del menú lateral de configuración | El sistema muestra la sección con un aviso indicando que la funcionalidad (autenticación de dos factores y gestión de dispositivos) está próximamente disponible |
| 10 | Persistencia del tema entre sesiones | En caso de que el instructor haya configurado un tema previamente | Cuando el instructor recarga la página o navega a otra sección del sistema | El sistema carga y aplica automáticamente el tema guardado en `localStorage` sin necesidad de reconfigurarlo |

---

### HU-INS-012 — Acceso a la Sección de Soporte

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-INS-012 |
| **Rol** | Como un Instructor |
| **Característica / Funcionalidad** | Puedo acceder a la sección de ayuda y soporte del sistema |
| **Razón / Resultado** | Con la finalidad de consultar las preguntas frecuentes, contactar al equipo de soporte técnico y descargar la documentación del sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a soporte desde el menú | N/A | Cuando el instructor hace clic en "Soporte" en el menú lateral | El sistema redirige a la vista de soporte (`/support`) mostrando el panel de Preguntas Frecuentes (FAQ) y las opciones rápidas de contacto y manual |
| 2 | Visualización de preguntas frecuentes (FAQ) | N/A | Cuando el instructor accede a la sección de soporte | El sistema muestra el listado de preguntas frecuentes colapsadas relevantes para el instructor: (1) Cómo restablecer la contraseña, (2) Formato permitido para fotos de evidencia al reportar una falla, (3) Razón por la que no se pueden editar incidentes ya procesados |
| 3 | Expandir una pregunta frecuente | N/A | Cuando el instructor hace clic sobre el título de una pregunta del FAQ | El sistema expande el cuerpo de esa pregunta mostrando la respuesta detallada y colapsa automáticamente cualquier otra que estuviera expandida |
| 4 | Colapsar una pregunta frecuente | En caso de que una pregunta esté activa/expandida | Cuando el instructor vuelve a hacer clic sobre esa misma pregunta | El sistema colapsa el contenido de la pregunta, ocultando la respuesta |
| 5 | Botón de contacto a soporte urgente | N/A | Cuando el instructor hace clic en "Contactar Soporte" en el panel lateral | El sistema ofrece el medio de contacto directo con el equipo de soporte técnico disponible 24/7 |
| 6 | Descarga del Manual Técnico | N/A | Cuando el instructor hace clic en "Descargar PDF" en la tarjeta de Manual Técnico | El sistema proporciona el enlace de descarga del manual de usuario en formato PDF |

---

## Resumen de Historias de Usuario — Rol Instructor

| ID | Módulo | Historia |
|---|---|---|
| HU-INS-001 | Autenticación | Inicio de sesión en el sistema |
| HU-INS-002 | Autenticación | Cierre de sesión del sistema |
| HU-INS-003 | Autenticación | Recuperación de contraseña olvidada |
| HU-INS-004 | Autenticación | Cambio de contraseña desde el perfil |
| HU-INS-005 | Dashboard | Visualización del panel de reportes personal |
| HU-INS-006 | Gestión de Reportes | Listado de mis reportes de fallas |
| HU-INS-007 | Gestión de Reportes | Reporte de nueva falla o incidencia |
| HU-INS-008 | Gestión de Reportes | Visualización del detalle de un reporte de falla |
| HU-INS-009 | Notificaciones | Recepción y visualización de notificaciones |
| HU-INS-010 | Perfil y Configuración | Visualización y edición del perfil personal |
| HU-INS-011 | Perfil y Configuración | Acceso a configuraciones del sistema |
| HU-INS-012 | Perfil y Configuración | Acceso a la sección de soporte |

---

*Documento generado para el proyecto SIGERD v1.0 — Centro de Formación Agroindustrial*
*Fecha de elaboración: 08/03/2026*
