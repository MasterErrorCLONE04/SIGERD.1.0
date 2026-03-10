# Historias de Usuario — Rol: Administrador
## Sistema: SIGERD v1.0 — Sistema de Gestión de Reportes y Distribución
### Centro de Formación Agroindustrial

---

## Convenciones del Documento

| Campo | Descripción |
|---|---|
| **Identificador (ID)** | Código único en formato `HU-ADM-XXX` |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Acción que el administrador necesita o puede realizar |
| **Razón / Resultado** | Finalidad o beneficio esperado al ejecutar la acción |
| **Número (#) de Escenario** | Número secuencial del escenario de aceptación |
| **Criterio de Aceptación (Título)** | Nombre corto del escenario |
| **Contexto** | Condición previa o situación que desencadena el escenario |
| **Evento** | Acción que ejecuta el usuario |
| **Resultado / Comportamiento esperado** | Respuesta del sistema ante el evento |

---

## MÓDULO 1: AUTENTICACIÓN Y ACCESO AL SISTEMA

---

### HU-ADM-001 — Inicio de Sesión en el Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-001 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito iniciar sesión en el sistema con mis credenciales |
| **Razón / Resultado** | Con la finalidad de acceder al panel de administración y gestionar el sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Inicio de sesión con credenciales correctas | En caso de que el administrador ingrese email y contraseña válidos | Cuando el administrador diligencia el formulario de login y hace clic en "Iniciar sesión" | El sistema autentica al usuario y lo redirige automáticamente al panel de administración (`/admin/dashboard`) |
| 2 | Inicio de sesión con credenciales incorrectas | En caso de que el administrador ingrese email o contraseña incorrectos | Cuando el administrador diligencia el formulario con datos inválidos y hace clic en "Iniciar sesión" | El sistema muestra un mensaje de error indicando que las credenciales no son correctas y no permite el acceso |
| 3 | Acceso denegado a usuario sin rol de administrador | En caso de que un usuario con rol distinto (trabajador o instructor) intente acceder a rutas del panel de administración | Cuando el usuario intenta navegar a `/admin/dashboard` | El sistema bloquea el acceso y redirige al dashboard correspondiente al rol del usuario autenticado |
| 4 | Redirección automática según rol | N/A | Cuando el administrador accede a la ruta `/dashboard` | El sistema detecta el rol `administrador` y redirige automáticamente a `/admin/dashboard` |

---

### HU-ADM-002 — Cierre de Sesión del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-002 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito cerrar la sesión activa en el sistema |
| **Razón / Resultado** | Con la finalidad de proteger la información y asegurar que ningún usuario no autorizado pueda acceder al panel |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cierre de sesión exitoso | En caso de que el administrador se encuentre autenticado en el sistema | Cuando el administrador hace clic en la opción "Cerrar Sesión" del menú | El sistema invalida la sesión y redirige al administrador a la página de inicio de sesión (`/login`) |

---

### HU-ADM-003 — Recuperación de Contraseña Olvidada

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-003 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito recuperar el acceso a mi cuenta cuando olvido mi contraseña |
| **Razón / Resultado** | Con la finalidad de restablecer mi contraseña de forma segura a través de mi correo electrónico registrado |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Solicitud de restablecimiento con email válido | En caso de que el administrador ingrese un email que esté registrado en el sistema | Cuando el administrador accede a `/forgot-password`, ingresa su email y hace clic en "Enviar enlace" | El sistema envía un enlace de restablecimiento al correo registrado y muestra en pantalla un mensaje de confirmación indicando que el enlace fue enviado |
| 2 | Solicitud con email no registrado | En caso de que el administrador ingrese un email que no existe en el sistema | Cuando el administrador ingresa un email inválido o no registrado y hace clic en "Enviar enlace" | El sistema muestra un mensaje de error indicando que no se encontró ninguna cuenta asociada a ese email |
| 3 | Campo email vacío | En caso de que el administrador no ingrese ningún email | Cuando el administrador deja el campo de email vacío e intenta enviar | El sistema muestra un error de validación solicitando que el campo email sea diligenciado |
| 4 | Restablecimiento exitoso de contraseña mediante token | En caso de que el administrador acceda al enlace de restablecimiento enviado por email | Cuando el administrador ingresa a `/reset-password/{token}`, completa la nueva contraseña y su confirmación, y hace clic en "Restablecer Contraseña" | El sistema actualiza la contraseña del usuario, invalida el token y redirige a la página de inicio de sesión (`/login`) con un mensaje de éxito |
| 5 | Contraseñas no coinciden en el restablecimiento | En caso de que la nueva contraseña y la confirmación sean diferentes | Cuando el administrador ingresa contraseñas distintas en el formulario de restablecimiento | El sistema muestra un error de validación y no actualiza la contraseña |
| 6 | Token de restablecimiento inválido o expirado | En caso de que el enlace de restablecimiento haya expirado o sea inválido | Cuando el administrador intenta usar un token caducado o manipulado | El sistema muestra un error de validación indicando que el token no es válido y no procesa el cambio |

---

### HU-ADM-004 — Cambio de Contraseña desde el Perfil

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-004 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito cambiar mi contraseña actual estando autenticado en el sistema |
| **Razón / Resultado** | Con la finalidad de actualizar mis credenciales de acceso por razones de seguridad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Cambio exitoso de contraseña | En caso de que el administrador ingrese correctamente su contraseña actual, la nueva y su confirmación | Cuando el administrador completa el formulario de cambio de contraseña en el perfil y hace clic en "Guardar" | El sistema actualiza la contraseña y muestra un mensaje de éxito (`password-updated`) en la misma página |
| 2 | Contraseña actual incorrecta | En caso de que el administrador ingrese una contraseña actual que no coincida con la almacenada en el sistema | Cuando el administrador intenta guardar el cambio con la contraseña actual errónea | El sistema muestra un error de validación indicando que la contraseña actual no es correcta y no realiza el cambio |
| 3 | Nueva contraseña y confirmación no coinciden | En caso de que la nueva contraseña y su campo de confirmación sean diferentes | Cuando el administrador ingresa contraseñas distintas en los campos de nueva contraseña y confirmación | El sistema muestra un error de validación y no actualiza la contraseña |
| 4 | Nueva contraseña no cumple requisitos mínimos | En caso de que la nueva contraseña no cumpla las reglas de seguridad del sistema | Cuando el administrador ingresa una contraseña demasiado corta o débil | El sistema muestra el error de validación correspondiente indicando los requisitos de seguridad |

---

## MÓDULO 2: DASHBOARD (PANEL DE CONTROL)

---

### HU-ADM-005 — Visualización del Panel de Control Principal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-005 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver un resumen general del estado del sistema al ingresar al panel de administración |
| **Razón / Resultado** | Con la finalidad de tener una visión global y en tiempo real del desempeño operativo del centro |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización de estadísticas de usuarios | En caso de que existan usuarios registrados en el sistema | Cuando el administrador accede al dashboard | El sistema muestra el total de usuarios, número de administradores, instructores y trabajadores registrados |
| 2 | Visualización de estadísticas de tareas | En caso de que existan tareas en el sistema | Cuando el administrador accede al dashboard | El sistema muestra el total de tareas y su distribución por estado: pendiente, asignado, en progreso, finalizada, realizada, cancelada, incompleta y "retraso en proceso" |
| 3 | Visualización de tareas con fecha límite próxima | En caso de que existan tareas cuya fecha límite venza en los próximos 7 días y no estén finalizadas o canceladas | Cuando el administrador accede al dashboard | El sistema muestra un contador con las tareas cuya fecha límite se aproxima en los próximos 7 días |
| 4 | Visualización de tareas vencidas | En caso de que existan tareas con fecha límite ya superada y sin estado final | Cuando el administrador accede al dashboard | El sistema muestra el conteo de tareas vencidas (en estado diferente a finalizada, cancelada o realizada) |
| 5 | Visualización de estadísticas de incidentes | En caso de que existan incidentes registrados | Cuando el administrador accede al dashboard | El sistema muestra el total de incidentes, incidentes pendientes de revisión e incidentes asignados |
| 6 | Dashboard sin datos registrados | En caso de que el sistema no tenga usuarios, tareas ni incidentes registrados | Cuando el administrador accede al dashboard | El sistema muestra todos los contadores en cero sin errores |

---

### HU-ADM-006 — Creación Rápida de Tarea desde el Dashboard

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-006 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Puedo crear una nueva tarea de mantenimiento directamente desde el panel de control |
| **Razón / Resultado** | Con la finalidad de agilizar la asignación de tareas sin necesidad de navegar a otro módulo |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Apertura del modal de creación rápida | En caso de que el administrador esté en el dashboard | Cuando el administrador hace clic en el botón de creación rápida de tarea | El sistema muestra un modal con el formulario de creación de tarea, incluyendo los campos: título, descripción, fecha límite, ubicación, prioridad, trabajador asignado e imágenes de referencia |
| 2 | Listado de trabajadores disponibles en el selector | En caso de que existan usuarios con rol "trabajador" en el sistema | Cuando se despliega el formulario de creación de tarea | El sistema carga automáticamente la lista de trabajadores activos en el campo "Asignar a" |
| 3 | Sin trabajadores disponibles en el selector | En caso de que no existan usuarios con rol "trabajador" registrados | Cuando se despliega el formulario de creación de tarea | El selector de trabajadores se muestra vacío o con un mensaje indicando que no hay trabajadores disponibles |

---

### HU-ADM-007 — Creación Rápida de Usuario desde el Dashboard

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-007 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Puedo crear un nuevo usuario directamente desde el panel de control sin salir del dashboard |
| **Razón / Resultado** | Con la finalidad de registrar nuevos miembros del personal de forma ágil sin necesidad de navegar al módulo de usuarios |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Apertura del modal de creación de usuario desde el botón superior | En caso de que el administrador esté en el dashboard | Cuando el administrador hace clic en el botón "Nuevo Usuario" de la barra superior del dashboard | El sistema abre un modal con el formulario completo de creación de usuario (nombre, email, contraseña, confirmación, rol y foto de perfil) |
| 2 | Apertura del modal de creación de usuario desde Acciones Rápidas | En caso de que el administrador esté en la sección de Acciones Rápidas del dashboard | Cuando el administrador hace clic en la tarjeta "Nuevo Usuario" en la sección de Acciones Rápidas | El sistema abre el mismo modal de creación de usuario |
| 3 | Creación exitosa de usuario desde el dashboard | En caso de que todos los campos del formulario modal sean correctamente diligenciados | Cuando el administrador completa el formulario con nombre, email único, contraseña, confirmación, rol y foto de perfil válida, y hace clic en "Guardar" | El sistema crea el nuevo usuario, lo almacena en base de datos, guarda la foto de perfil y redirige al listado de usuarios con el mensaje "Usuario creado exitosamente." |
| 4 | Validación de campos obligatorios en el modal | En caso de que el administrador no complete todos los campos requeridos | Cuando el administrador intenta guardar sin completar algún campo obligatorio (nombre, email, contraseña, rol o foto) | El sistema muestra los errores de validación correspondientes y vuelve a abrir el modal mostrando los errores |
| 5 | Reapertura automática del modal ante errores de validación | En caso de que la validación del formulario falle | Cuando el sistema detecta errores al intentar guardar el nuevo usuario | El sistema redirige de vuelta al dashboard y reabre automáticamente el modal `createUserModal` mostrando los errores de validación |
| 6 | Cierre del modal sin guardar | N/A | Cuando el administrador hace clic fuera del modal, en el botón "Cancelar" o presiona la tecla ESC | El sistema cierra el modal sin crear ningún usuario ni modificar datos |

---

## MÓDULO 3: GESTIÓN DE USUARIOS

---

### HU-ADM-008 — Listado de Usuarios del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-008 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el listado completo de todos los usuarios registrados en el sistema |
| **Razón / Resultado** | Con la finalidad de tener control y visibilidad total sobre los usuarios que pueden acceder a la plataforma |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Lista de usuarios con datos | En caso de que existan usuarios registrados en el sistema | Cuando el administrador accede a la sección "Usuarios" (`/admin/users`) | El sistema muestra una tabla paginada (5 usuarios por página) con los usuarios ordenados por fecha de creación descendente, mostrando nombre, email y rol de cada uno |
| 2 | Lista de usuarios vacía | En caso de que no existan usuarios registrados | Cuando el administrador accede a la sección "Usuarios" | El sistema muestra un mensaje indicando que no existen usuarios en el sistema |
| 3 | Paginación de usuarios | En caso de que existan más de 5 usuarios registrados | Cuando el administrador accede a la sección "Usuarios" | El sistema muestra controles de paginación para navegar entre páginas de resultados |
| 4 | Búsqueda de usuario por nombre o email | N/A | Cuando el administrador ingresa un término en el campo de búsqueda y presiona buscar | El sistema filtra y muestra únicamente los usuarios cuyo nombre o email contengan el término ingresado |
| 5 | Búsqueda sin resultados | En caso de que el término de búsqueda no coincida con ningún usuario | Cuando el administrador realiza una búsqueda sin coincidencias | El sistema muestra un mensaje indicando que no se encontraron usuarios con ese criterio de búsqueda |

---

### HU-ADM-009 — Creación de Nuevo Usuario

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-009 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito crear nuevos usuarios en el sistema y asignarles un rol específico |
| **Razón / Resultado** | Con la finalidad de gestionar el acceso de nuevos miembros del personal al sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Creación de usuario con datos válidos | En caso de que todos los campos del formulario sean correctamente diligenciados | Cuando el administrador completa el formulario con nombre, email único, contraseña, confirmación de contraseña, rol y foto de perfil válida, y hace clic en "Guardar" | El sistema crea el nuevo usuario, almacena la foto de perfil y redirige al listado de usuarios con el mensaje "Usuario creado exitosamente." |
| 2 | Email ya registrado | En caso de que el email ingresado ya esté en uso por otro usuario | Cuando el administrador intenta crear un usuario con un email existente | El sistema muestra un error de validación indicando que el email ya está en uso y no crea el registro |
| 3 | Contraseña sin confirmación coincidente | En caso de que la contraseña y su confirmación no sean iguales | Cuando el administrador ingresa contraseñas que no coinciden | El sistema muestra un error de validación y no permite la creación del usuario |
| 4 | Foto de perfil obligatoria | En caso de que el administrador no seleccione una foto de perfil | Cuando el administrador intenta guardar el usuario sin foto de perfil | El sistema muestra el error: "La foto de perfil es obligatoria." |
| 5 | Formato de imagen no válido en foto de perfil | En caso de que se seleccione un archivo que no sea imagen (jpeg, png, jpg, gif) | Cuando el administrador sube un archivo con extensión no permitida | El sistema muestra el error: "Formatos permitidos: jpeg, png, jpg, gif." |
| 6 | Imagen de perfil excede tamaño máximo | En caso de que la imagen seleccionada supere los 2MB | Cuando el administrador sube una imagen mayor a 2MB | El sistema muestra el error: "La imagen no debe exceder los 2MB." |
| 7 | Asignación de rol al crear usuario | N/A | Cuando el administrador selecciona un rol del listado (administrador, trabajador, instructor) | El sistema almacena el rol seleccionado y el usuario podrá acceder solo a las secciones correspondientes a su rol |

---

### HU-ADM-010 — Visualización del Perfil Detallado de un Usuario

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-010 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el perfil completo y el historial de actividad de un usuario específico |
| **Razón / Resultado** | Con la finalidad de monitorear el rendimiento y las actividades de cada miembro del personal |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Ver perfil de usuario trabajador | En caso de que el usuario sea de rol "trabajador" | Cuando el administrador hace clic en "Ver" en la fila de un trabajador | El sistema muestra el perfil con sus estadísticas: total de tareas asignadas, tareas finalizadas, tareas pendientes, incidentes reportados, incidentes resueltos, incidentes pendientes, así como el historial de tareas asignadas paginado (10 por página) |
| 2 | Ver perfil de usuario instructor o administrador | En caso de que el usuario sea de rol "instructor" o "administrador" | Cuando el administrador hace clic en "Ver" en la fila de ese usuario | El sistema muestra el perfil del usuario con sus incidentes reportados y tareas creadas, sin mostrar el bloque de tareas asignadas (exclusivo de trabajadores) |
| 3 | Usuario sin actividad registrada | En caso de que el usuario no haya realizado tareas ni reportado incidentes | Cuando el administrador visualiza el perfil del usuario | El sistema muestra el perfil con todos los contadores estadísticos en cero |

---

### HU-ADM-011 — Edición de Datos de un Usuario

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-011 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito editar los datos de un usuario existente en el sistema |
| **Razón / Resultado** | Con la finalidad de mantener la información actualizada o corregir datos incorrectos |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Edición exitosa de datos básicos | En caso de que el administrador modifique nombre, email y/o rol con datos válidos | Cuando el administrador completa el formulario de edición y hace clic en "Actualizar" | El sistema actualiza los datos del usuario y redirige al listado con el mensaje "Usuario actualizado exitosamente." |
| 2 | Email duplicado en edición | En caso de que el administrador cambie el email por uno que ya pertenece a otro usuario | Cuando el administrador guarda la edición con un email ya en uso | El sistema muestra un error de validación indicando que el email ya está registrado |
| 3 | Actualización de foto de perfil | En caso de que el administrador seleccione una nueva imagen válida para reemplazar la foto actual | Cuando el administrador sube una nueva foto y guarda los cambios | El sistema elimina la foto anterior del almacenamiento y guarda la nueva foto de perfil |
| 4 | Actualización de foto con imagen inválida | En caso de que la nueva imagen no tenga formato permitido o supere los 2MB | Cuando el administrador intenta guardar una imagen con formato no permitido o muy pesada | El sistema muestra el error correspondiente y no actualiza la foto |

---

### HU-ADM-012 — Eliminación de un Usuario

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-012 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito eliminar un usuario del sistema de forma permanente |
| **Razón / Resultado** | Con la finalidad de revocar el acceso a usuarios que ya no pertenecen al personal del centro |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Eliminación exitosa de usuario | En caso de que el administrador confirme la eliminación de un usuario | Cuando el administrador hace clic en "Eliminar" y confirma la acción | El sistema elimina el registro del usuario, borra su foto de perfil del almacenamiento y redirige al listado con el mensaje "Usuario eliminado exitosamente." |
| 2 | Eliminación de usuario con foto de perfil | En caso de que el usuario a eliminar tenga una foto de perfil almacenada | Cuando el sistema procesa la eliminación | El sistema también elimina el archivo de imagen del almacenamiento del servidor |

---

## MÓDULO 4: GESTIÓN DE TAREAS

---

### HU-ADM-013 — Listado de Tareas del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-013 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el listado de todas las tareas registradas en el sistema |
| **Razón / Resultado** | Con la finalidad de supervisar el estado y progreso de todas las actividades de mantenimiento |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Lista de tareas con datos | En caso de que existan tareas registradas | Cuando el administrador accede a la sección "Tareas" (`/admin/tasks`) | El sistema muestra una tabla paginada (10 tareas por página) ordenadas por fecha de creación descendente, con trabajador asignado y administrador que la creó |
| 2 | Lista de tareas vacía | En caso de que no existan tareas en el sistema | Cuando el administrador accede a la sección "Tareas" | El sistema muestra un mensaje indicando que no hay tareas registradas |
| 3 | Filtrado de tareas por título | N/A | Cuando el administrador ingresa un término en el buscador y lo aplica | El sistema filtra y muestra únicamente las tareas cuyo título contiene el término de búsqueda |
| 4 | Filtrado de tareas por prioridad | N/A | Cuando el administrador selecciona una prioridad (baja, media, alta) del filtro | El sistema muestra únicamente las tareas que coinciden con la prioridad seleccionada |
| 5 | Combinación de filtros | N/A | Cuando el administrador aplica búsqueda por texto y filtro de prioridad simultáneamente | El sistema aplica ambos filtros y muestra las tareas que cumplan ambas condiciones |
| 6 | Sin resultados en la búsqueda | En caso de que ninguna tarea coincida con los filtros aplicados | Cuando el administrador aplica filtros sin coincidencias | El sistema muestra un mensaje indicando que no hay tareas con esos criterios |

---

### HU-ADM-014 — Creación de Nueva Tarea

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-014 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito crear nuevas tareas de mantenimiento y asignarlas a un trabajador |
| **Razón / Resultado** | Con la finalidad de organizar y delegar las actividades de mantenimiento del centro de formación |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Creación exitosa de tarea con datos válidos | En caso de que todos los campos obligatorios sean diligenciados correctamente | Cuando el administrador completa el formulario con título, fecha límite futura, ubicación, prioridad, trabajador asignado e imágenes de referencia, y hace clic en "Crear Tarea" | El sistema crea la tarea con estado "asignado", notifica al trabajador asignado y redirige al listado con el mensaje "Tarea creada exitosamente." |
| 2 | Fecha límite anterior a hoy | En caso de que el administrador ingrese una fecha límite en el pasado | Cuando el administrador intenta guardar la tarea con fecha límite anterior al día actual | El sistema muestra el error: "La fecha límite no puede ser anterior al día de hoy." |
| 3 | Campos obligatorios vacíos | En caso de que el administrador no complete algún campo obligatorio (título, fecha, ubicación, prioridad, trabajador) | Cuando intenta guardar la tarea sin los campos requeridos | El sistema muestra los errores de validación correspondientes y no crea la tarea |
| 4 | Imágenes de referencia obligatorias | En caso de que el administrador no adjunte imágenes de referencia | Cuando intenta guardar la tarea sin imágenes | El sistema muestra el error: "Las imágenes de referencia son obligatorias para crear la tarea." |
| 5 | Imagen de referencia con formato inválido | En caso de que alguna imagen adjuntada no sea de tipo jpeg, png, jpg o gif | Cuando el administrador sube un archivo con extensión no permitida | El sistema muestra el error: "Formatos permitidos: jpeg, png, jpg, gif." |
| 6 | Imagen de referencia excede 2MB | En caso de que alguna imagen de referencia supere los 2MB | Cuando el administrador adjunta una imagen muy pesada | El sistema muestra el error: "Cada imagen no debe exceder los 2MB." |
| 7 | Notificación automática al trabajador | En caso de que la tarea sea creada con un trabajador asignado | Cuando el sistema procesa la creación exitosa | El sistema genera automáticamente una notificación al trabajador con el mensaje "Te han asignado una nueva tarea: [título de la tarea]" |
| 8 | Tarea con adjunto de imágenes de evidencia inicial | En caso de que el administrador decida adjuntar imágenes de evidencia inicial | Cuando el administrador sube imágenes en el campo de evidencia inicial y guarda | El sistema almacena las imágenes de evidencia inicial de forma correcta junto con la tarea |

---

### HU-ADM-015 — Visualización del Detalle de una Tarea

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-015 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el detalle completo de una tarea específica |
| **Razón / Resultado** | Con la finalidad de revisar toda la información, avance e imágenes relacionadas con esa actividad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Ver detalle completo de tarea | En caso de que la tarea exista en el sistema | Cuando el administrador hace clic en una tarea del listado | El sistema muestra el detalle con: título, descripción, estado, prioridad, ubicación, fecha límite, trabajador asignado, administrador que la creó, imágenes de referencia e imágenes de evidencia inicial y final |
| 2 | Detalle de tarea vinculada a un incidente | En caso de que la tarea haya sido generada desde un incidente | Cuando el administrador visualiza el detalle de la tarea | El sistema muestra también la información del incidente de origen asociado a la tarea |
| 3 | Tarea sin evidencia final | En caso de que el trabajador aún no haya subido imágenes de evidencia final | Cuando el administrador visualiza el detalle de la tarea | El sistema muestra el apartado de evidencia final vacío o con un mensaje indicando que no hay evidencia disponible |

---

### HU-ADM-016 — Edición de una Tarea

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-016 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito editar los datos de una tarea existente |
| **Razón / Resultado** | Con la finalidad de corregir información, actualizar el estado, reasignar el trabajador o agregar imágenes adicionales |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Edición exitosa de datos de una tarea | En caso de que los datos ingresados sean válidos | Cuando el administrador modifica los campos y hace clic en "Actualizar Tarea" | El sistema actualiza los datos de la tarea y redirige al listado con el mensaje "Tarea actualizada exitosamente." |
| 2 | Cambio de estado de la tarea | N/A | Cuando el administrador selecciona un nuevo estado del listado (asignado, en progreso, realizada, finalizada, cancelada, incompleta, retraso en proceso) y guarda | El sistema actualiza el estado de la tarea al valor seleccionado |
| 3 | Adición de imágenes de evidencia en edición | N/A | Cuando el administrador adjunta nuevas imágenes en el campo de evidencia inicial, final o referencia | El sistema combina las imágenes nuevas con las existentes (no reemplaza) y almacena el conjunto completo |
| 4 | Tarea con fecha límite vencida al actualizar | En caso de que la fecha límite guardada sea anterior a la fecha actual y la tarea no esté finalizada ni cancelada | Cuando el sistema procesa la actualización | El sistema automáticamente cambia el estado de la tarea a "incompleta" |

---

### HU-ADM-017 — Revisión y Aprobación de Tarea Completada

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-017 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito revisar el trabajo realizado por un trabajador y aprobar, rechazar o marcar en retraso una tarea |
| **Razón / Resultado** | Con la finalidad de asegurar la calidad del trabajo antes de dar por concluida una actividad de mantenimiento |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Aprobación de tarea | En caso de que el administrador revise el trabajo y lo considere correcto | Cuando el administrador hace clic en "Aprobar" en el detalle de la tarea | El sistema cambia el estado a "finalizada", notifica al trabajador con "¡Felicidades! Tu trabajo en la tarea ha sido aprobado." y redirige con el mensaje de éxito |
| 2 | Aprobación de tarea vinculada a incidente | En caso de que la tarea aprobada esté vinculada a un incidente previo | Cuando el administrador aprueba la tarea | El sistema adicionalmente actualiza el estado del incidente a "resuelto", registra la fecha de resolución y notifica al instructor que reportó el incidente |
| 3 | Rechazo de tarea | En caso de que el administrador considere que el trabajo requiere correcciones | Cuando el administrador hace clic en "Rechazar" | El sistema cambia el estado de la tarea a "en progreso" para que el trabajador la corrija, y notifica al trabajador con "Tu trabajo en la tarea requiere correcciones." |
| 4 | Marcado de tarea en retraso | En caso de que el trabajo presente demoras significativas | Cuando el administrador selecciona la acción "Retraso" | El sistema cambia el estado de la tarea a "retraso en proceso" |
| 5 | Notificación al instructor al resolver incidente | En caso de que un incidente vinculado se resuelva al aprobar la tarea | Cuando el sistema procesa la aprobación | El sistema genera automáticamente una notificación al instructor que reportó el incidente con el mensaje: "Reparación/Mantenimiento finalizado con éxito para tu incidencia: [título]" |

---

### HU-ADM-018 — Eliminación de una Tarea

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-018 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito eliminar una tarea del sistema de forma permanente |
| **Razón / Resultado** | Con la finalidad de limpiar registros incorrectos o innecesarios del sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Eliminación exitosa de tarea | En caso de que el administrador confirme la eliminación | Cuando el administrador hace clic en "Eliminar" y confirma la acción | El sistema elimina el registro de la tarea y redirige al listado con el mensaje "Tarea eliminada exitosamente." |

---

### HU-ADM-019 — Exportación de Reporte de Tareas en PDF

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-019 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito exportar un reporte mensual de las tareas finalizadas en formato PDF |
| **Razón / Resultado** | Con la finalidad de generar informes de gestión para presentar al equipo directivo del centro |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Exportación exitosa de PDF con data | En caso de que existan tareas finalizadas en el mes y año seleccionados | Cuando el administrador selecciona el mes y el año, y hace clic en "Exportar PDF" | El sistema genera y descarga automáticamente un archivo PDF llamado `reporte-tareas-[Mes]-[Año].pdf` con el listado de tareas finalizadas, estadísticas de prioridad, promedio de días de finalización y ranking de trabajadores |
| 2 | Exportación de PDF sin tareas finalizadas | En caso de que no existan tareas finalizadas para el mes y año seleccionados | Cuando el administrador genera el PDF para un periodo sin tareas | El sistema genera el PDF con los totales en cero y sin filas en la tabla de tareas |
| 3 | Mes o año inválido | En caso de que el administrador seleccione un mes fuera del rango 1-12 o un año fuera del rango 2020-2100 | Cuando el administrador intenta exportar con valores inválidos | El sistema muestra un error de validación y no genera el PDF |
| 4 | Contenido del reporte PDF | N/A | Cuando el sistema genera el PDF exitosamente | El documento incluye: nombre del mes y año, tabla de tareas finalizadas, total de tareas, tareas por prioridad (alta, media, baja), promedio de días de finalización y los 5 principales trabajadores |

---

## MÓDULO 5: GESTIÓN DE INCIDENTES

---

### HU-ADM-020 — Listado de Incidentes del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-020 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el listado completo de todos los incidentes reportados al sistema |
| **Razón / Resultado** | Con la finalidad de supervisar y gestionar todas las fallas o novedades reportadas por los instructores |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Lista de incidentes con datos | En caso de que existan incidentes reportados | Cuando el administrador accede a la sección "Incidentes" (`/admin/incidents`) | El sistema muestra una tabla paginada (10 por página) con los incidentes ordenados por fecha de creación descendente, mostrando título, descripción parcial, ubicación y el usuario que lo reportó |
| 2 | Lista de incidentes vacía | En caso de que no existan incidentes registrados | Cuando el administrador accede a la sección de incidentes | El sistema muestra un mensaje indicando que no hay incidentes registrados |
| 3 | Búsqueda de incidente por título, descripción, ubicación o reportante | N/A | Cuando el administrador escribe en el campo de búsqueda | El sistema filtra y muestra los incidentes que coincidan con el término en cualquiera de esos campos |
| 4 | Filtrado por fecha de creación | N/A | Cuando el administrador selecciona una fecha específica en el filtro de fecha | El sistema muestra únicamente los incidentes creados en esa fecha exacta |
| 5 | Combinación de búsqueda y fecha | N/A | Cuando el administrador aplica texto de búsqueda y filtro de fecha simultáneamente | El sistema aplica ambos criterios y retorna los incidentes que cumplan las dos condiciones |

---

### HU-ADM-021 — Visualización del Detalle de un Incidente

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-021 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver el detalle completo de un incidente específico |
| **Razón / Resultado** | Con la finalidad de analizar la información de la falla, su evidencia fotográfica y tomar decisiones sobre su atención |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Ver detalle completo del incidente | En caso de que el incidente exista | Cuando el administrador hace clic en un incidente del listado | El sistema muestra el detalle del incidente con: título, descripción, ubicación, fecha de reporte, estado, usuario reportante e imágenes de evidencia inicial |
| 2 | Incidente resuelto con evidencia final | En caso de que el incidente haya sido resuelto y tenga evidencia final | Cuando el administrador visualiza el detalle del incidente resuelto | El sistema muestra también la descripción de resolución, fecha de resolución e imágenes de evidencia final |
| 3 | Incidente con tarea vinculada | En caso de que el incidente haya sido convertido en tarea | Cuando el administrador visualiza el detalle | El sistema muestra la información de la tarea asociada, incluyendo el trabajador asignado y el estado de la tarea |

---

### HU-ADM-022 — Conversión de Incidente a Tarea

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-022 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito convertir un incidente reportado en una tarea de mantenimiento y asignarla a un trabajador |
| **Razón / Resultado** | Con la finalidad de gestionar la atención de las fallas reportadas asignando el trabajo al personal correspondiente |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Conversión exitosa de incidente a tarea | En caso de que todos los campos del formulario de conversión sean correctamente diligenciados | Cuando el administrador completa el formulario con título de tarea, descripción, trabajador asignado, prioridad, fecha límite, ubicación y hace clic en "Convertir a Tarea" | El sistema crea la tarea con estado "asignado", usa las imágenes del incidente como imágenes de referencia, actualiza el estado del incidente a "asignado", y redirige al listado de incidentes con el mensaje "Incidente convertido a tarea exitosamente." |
| 2 | Notificación al trabajador al convertir | En caso de que la conversión sea exitosa | Cuando el sistema procesa la conversión | El sistema genera automáticamente una notificación al trabajador asignado con el mensaje "Te han asignado una nueva tarea: [título de la tarea]" |
| 3 | Notificación al instructor reportante | En caso de que el incidente sea convertido en tarea | Cuando el sistema procesa la conversión | El sistema notifica al instructor que reportó el incidente con el mensaje "Tu incidente ha sido convertido en una tarea" |
| 4 | Campos obligatorios incompletos en conversión | En caso de que algún campo requerido esté vacío | Cuando el administrador intenta convertir sin completar todos los campos | El sistema muestra errores de validación y no realiza la conversión |
| 5 | Fecha límite anterior a hoy en conversión | En caso de que la fecha límite de la tarea sea anterior al día de hoy | Cuando el administrador ingresa una fecha límite pasada | El sistema muestra el error de validación y no convierte el incidente |
| 6 | Imágenes del incidente reutilizadas | N/A | Cuando el sistema ejecuta la conversión exitosa | Las imágenes de evidencia inicial del incidente son automáticamente asignadas como imágenes de referencia de la nueva tarea |

---

## MÓDULO 6: NOTIFICACIONES

---

### HU-ADM-023 — Recepción y Visualización de Notificaciones

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-023 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito recibir y visualizar notificaciones sobre eventos importantes del sistema |
| **Razón / Resultado** | Con la finalidad de estar al tanto de las actualizaciones y cambios realizados por los trabajadores e instructores |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Contador de notificaciones no leídas | En caso de que el administrador tenga notificaciones sin leer | Cuando el administrador está autenticado en cualquier página del sistema | El sistema muestra un indicador (badge) con el número de notificaciones no leídas en el ícono de notificaciones de la barra lateral |
| 2 | Sin notificaciones no leídas | En caso de que todas las notificaciones estén marcadas como leídas | Cuando el administrador revisa la barra de navegación | El sistema no muestra el badge de notificaciones no leídas |
| 3 | Listado de notificaciones | N/A | Cuando el administrador accede a la sección de notificaciones (`/notifications`) | El sistema muestra el historial de todas las notificaciones recibidas |
| 4 | Marcar notificación como leída | En caso de que el administrador tenga notificaciones no leídas | Cuando el administrador hace clic en una notificación específica | El sistema marca esa notificación como leída |
| 5 | Marcar todas las notificaciones como leídas | En caso de que existan múltiples notificaciones sin leer | Cuando el administrador hace clic en "Marcar todas como leídas" | El sistema marca todas las notificaciones existentes como leídas y el badge desaparece |

---

## MÓDULO 7: PERFIL DE USUARIO Y CONFIGURACIÓN

---

### HU-ADM-024 — Visualización y Edición del Perfil Personal

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-024 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Necesito ver y editar mi información de perfil personal dentro del sistema |
| **Razón / Resultado** | Con la finalidad de mantener mis datos actualizados y gestionar la seguridad de mi cuenta |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Visualización del perfil personal | N/A | Cuando el administrador accede a `/profile/show` | El sistema muestra la información del perfil: nombre, email, rol y foto de perfil del administrador autenticado |
| 2 | Edición de datos del perfil | N/A | Cuando el administrador accede a `/profile` y modifica nombre o email con datos válidos, luego guarda | El sistema actualiza la información del perfil y muestra un mensaje de éxito |
| 3 | Email duplicado en edición de perfil | En caso de que el nuevo email ya esté en uso por otro usuario | Cuando el administrador intenta guardar un email ya registrado | El sistema muestra un error de validación y no actualiza el perfil |
| 4 | Eliminación de cuenta propia | En caso de que el administrador desee eliminar su propia cuenta | Cuando el administrador hace clic en "Eliminar cuenta" y confirma la acción | El sistema cierra la sesión, elimina la cuenta y redirige a la página de inicio |

---

### HU-ADM-025 — Acceso a Configuraciones del Sistema

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-025 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Puedo acceder y configurar las preferencias personales del sistema desde la sección de configuración |
| **Razón / Resultado** | Con la finalidad de personalizar la apariencia de la plataforma, gestionar las notificaciones y revisar opciones de privacidad y seguridad |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a configuraciones desde el menú | N/A | Cuando el administrador hace clic en "Configuración" en el menú lateral | El sistema redirige a la vista de configuraciones (`/settings`) mostrando la pestaña "Notificaciones" activa por defecto |
| 2 | Navegación entre secciones de configuración | N/A | Cuando el administrador hace clic en cualquier opción del menú lateral izquierdo de configuración | El sistema muestra el contenido de la sección seleccionada sin recargar la página (navegación por hash con Alpine.js) |
| 3 | Configuración de notificaciones: Nuevas Tareas o Incidentes | En caso de que el administrador desee controlar las alertas por correo de asignaciones | Cuando el administrador activa o desactiva el toggle "Nuevas Tareas o Incidentes" en la sección Notificaciones | El sistema refleja visualmente el cambio del toggle (activado/desactivado) |
| 4 | Configuración de notificaciones: Actualizaciones de Estado | En caso de que el administrador desee controlar alertas sobre cambios en tareas | Cuando el administrador activa o desactiva el toggle "Actualizaciones de Estado" | El sistema refleja visualmente el cambio del toggle |
| 5 | Configuración de notificaciones: Alertas Promocionales | En caso de que el administrador desee controlar noticias y nuevos lanzamientos | Cuando el administrador activa o desactiva el toggle "Alertas Promocionales" | El sistema refleja visualmente el cambio del toggle (inactivo por defecto) |
| 6 | Cambio de tema: Modo Claro | En caso de que el administrador desee una interfaz clara | Cuando el administrador selecciona la opción "Claro" en la sección Apariencia | El sistema aplica inmediatamente el tema claro a toda la interfaz, guarda la preferencia en `localStorage` y muestra el ícono de selección activo sobre esa opción |
| 7 | Cambio de tema: Modo Oscuro | En caso de que el administrador desee una interfaz oscura | Cuando el administrador selecciona la opción "Oscuro" en la sección Apariencia | El sistema aplica inmediatamente el tema oscuro a toda la interfaz, guarda la preferencia en `localStorage` y muestra el ícono de selección activo |
| 8 | Cambio de tema: Modo Sistema | En caso de que el administrador prefiera que la interfaz siga la configuración del sistema operativo | Cuando el administrador selecciona la opción "Sistema" | El sistema detecta la preferencia del SO y aplica claro u oscuro según corresponda, guarda la preferencia en `localStorage` y escucha automáticamente cambios futuros del SO |
| 9 | Acceso a la sección de Privacidad y Seguridad | N/A | Cuando el administrador hace clic en "Privacidad y Seguridad" del menú lateral | El sistema muestra la sección correspondiente con un mensaje informando que la funcionalidad (autenticación de dos factores y gestión de dispositivos) está en construcción |
| 10 | Persistencia del tema tras recarga | En caso de que el administrador haya configurado un tema previamente | Cuando el administrador recarga la página o navega a otra sección | El sistema carga el tema previamente guardado en `localStorage` y lo aplica automáticamente sin que el usuario deba volver a configurarlo |

---

### HU-ADM-026 — Acceso a la Sección de Soporte

| Campo | Descripción |
|---|---|
| **Identificador (ID) de la Historia** | HU-ADM-026 |
| **Rol** | Como un Administrador |
| **Característica / Funcionalidad** | Puedo acceder a la sección de ayuda y soporte del sistema |
| **Razón / Resultado** | Con la finalidad de consultar las preguntas frecuentes, contactar al equipo de soporte técnico y descargar la documentación del sistema |

#### Criterios de Aceptación

| # | Criterio de Aceptación (Título) | Contexto | Evento | Resultado / Comportamiento Esperado |
|---|---|---|---|---|
| 1 | Acceso a soporte desde el menú | N/A | Cuando el administrador hace clic en "Soporte" en el menú lateral | El sistema redirige a la vista de soporte (`/support`) mostrando el panel de Preguntas Frecuentes (FAQ) y las opciones rápidas |
| 2 | Visualización de preguntas frecuentes (FAQ) | N/A | Cuando el administrador accede a la sección de soporte | El sistema muestra un listado de preguntas frecuentes colapsadas: (1) Cómo restablecer la contraseña, (2) Formato permitido para fotos de evidencia, (3) Razón por la que no se pueden editar incidentes con evidencias |
| 3 | Expandir una pregunta frecuente | N/A | Cuando el administrador hace clic sobre el título de una pregunta del FAQ | El sistema expande el contenido de esa pregunta con la respuesta detallada, y colapsa automáticamente cualquier otra que estuviera expandida |
| 4 | Colapsar una pregunta frecuente | En caso de que una pregunta esté activa/expandida | Cuando el administrador vuelve a hacer clic sobre esa misma pregunta | El sistema colapsa el contenido de la pregunta, ocultando la respuesta |
| 5 | Botón de contacto a soporte urgente | N/A | Cuando el administrador hace clic en "Contactar Soporte" en el panel lateral | El sistema dispone del botón de contacto para comunicarse con el equipo de soporte técnico disponible 24/7 |
| 6 | Descarga del Manual Técnico | N/A | Cuando el administrador hace clic en "Descargar PDF" en la tarjeta de Manual Técnico | El sistema ofrece el enlace de descarga del manual de usuario en formato PDF |

---

## Resumen de Historias de Usuario — Rol Administrador

| ID | Módulo | Historia |
|---|---|---|
| HU-ADM-001 | Autenticación | Inicio de sesión en el sistema |
| HU-ADM-002 | Autenticación | Cierre de sesión del sistema |
| HU-ADM-003 | Autenticación | Recuperación de contraseña olvidada |
| HU-ADM-004 | Autenticación | Cambio de contraseña desde el perfil |
| HU-ADM-005 | Dashboard | Visualización del panel de control principal |
| HU-ADM-006 | Dashboard | Creación rápida de tarea desde el dashboard |
| HU-ADM-007 | Dashboard | Creación rápida de usuario desde el dashboard |
| HU-ADM-008 | Gestión de Usuarios | Listado de usuarios del sistema |
| HU-ADM-009 | Gestión de Usuarios | Creación de nuevo usuario |
| HU-ADM-010 | Gestión de Usuarios | Visualización del perfil detallado de un usuario |
| HU-ADM-011 | Gestión de Usuarios | Edición de datos de un usuario |
| HU-ADM-012 | Gestión de Usuarios | Eliminación de un usuario |
| HU-ADM-013 | Gestión de Tareas | Listado de tareas del sistema |
| HU-ADM-014 | Gestión de Tareas | Creación de nueva tarea |
| HU-ADM-015 | Gestión de Tareas | Visualización del detalle de una tarea |
| HU-ADM-016 | Gestión de Tareas | Edición de una tarea |
| HU-ADM-017 | Gestión de Tareas | Revisión y aprobación de tarea completada |
| HU-ADM-018 | Gestión de Tareas | Eliminación de una tarea |
| HU-ADM-019 | Gestión de Tareas | Exportación de reporte de tareas en PDF |
| HU-ADM-020 | Gestión de Incidentes | Listado de incidentes del sistema |
| HU-ADM-021 | Gestión de Incidentes | Visualización del detalle de un incidente |
| HU-ADM-022 | Gestión de Incidentes | Conversión de incidente a tarea |
| HU-ADM-023 | Notificaciones | Recepción y visualización de notificaciones |
| HU-ADM-024 | Perfil y Configuración | Visualización y edición del perfil personal |
| HU-ADM-025 | Perfil y Configuración | Acceso a configuraciones del sistema |
| HU-ADM-026 | Perfil y Configuración | Acceso a la sección de soporte |

---

*Documento generado para el proyecto SIGERD v1.0 — Centro de Formación Agroindustrial*
*Fecha de elaboración: 08/03/2026*
